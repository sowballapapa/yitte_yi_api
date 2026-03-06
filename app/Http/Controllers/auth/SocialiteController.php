<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\ResponseController;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends ResponseController
{
    // ── GOOGLE ────────────────────────────────────────────────────

    /**
     * Redirect to Google OAuth page.
     * GET /api/auth/google/redirect
     */
    public function redirectToGoogle()
    {
        $url = Socialite::driver('google')
            ->stateless()
            ->redirect()
            ->getTargetUrl();

        return $this->success(['url' => $url], "URL d'authentification Google générée");
    }

    /**
     * Handle Google OAuth callback (web).
     * GET /api/auth/google/callback
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return $this->error('Token Google invalide ou accès refusé.', 401);
        }

        return $this->findOrCreateSocialUser($googleUser, 'google');
    }

    /**
     * Handle Google Sign-In from a mobile app (ID token).
     * POST /api/auth/google/mobile
     * Body: { "id_token": "..." }
     */
    public function handleGoogleMobile(Request $request)
    {
        $request->validate([
            'id_token' => ['required', 'string'],
        ], [
            'id_token.required' => 'Le token Google est obligatoire.',
        ]);

        try {
            $googleUser = Socialite::driver('google')
                ->stateless()
                ->userFromToken($request->input('id_token'));
        } catch (\Exception $e) {
            return $this->error('Token Google invalide ou expiré.', 401);
        }

        return $this->findOrCreateSocialUser($googleUser, 'google');
    }

    // ── APPLE ─────────────────────────────────────────────────────

    /**
     * Redirect to Apple OAuth page.
     * GET /api/auth/apple/redirect
     */
    public function redirectToApple()
    {
        $url = Socialite::driver('apple')
            ->stateless()
            ->redirect()
            ->getTargetUrl();

        return $this->success(['url' => $url], "URL d'authentification Apple générée");
    }

    /**
     * Handle Apple OAuth callback (web).
     * POST /api/auth/apple/callback
     */
    public function handleAppleCallback(Request $request)
    {
        try {
            $appleUser = Socialite::driver('apple')->stateless()->user();
        } catch (\Exception $e) {
            return $this->error('Token Apple invalide ou accès refusé.', 401);
        }

        return $this->findOrCreateSocialUser($appleUser, 'apple');
    }

    /**
     * Handle Apple Sign-In from a mobile app (identity token).
     * POST /api/auth/apple/mobile
     * Body: { "identity_token": "...", "name": "..." (optionnel, 1ère connexion) }
     */
    public function handleAppleMobile(Request $request)
    {
        $request->validate([
            'identity_token' => ['required', 'string'],
            'name'           => ['nullable', 'string', 'max:255'],
        ], [
            'identity_token.required' => 'Le token Apple est obligatoire.',
        ]);

        try {
            $appleUser = Socialite::driver('apple')
                ->stateless()
                ->userFromToken($request->input('identity_token'));

            // Apple ne fournit le nom qu'à la première connexion
            if ($request->filled('name')) {
                $appleUser->name = $request->input('name');
            }
        } catch (\Exception $e) {
            return $this->error('Token Apple invalide ou expiré.', 401);
        }

        return $this->findOrCreateSocialUser($appleUser, 'apple');
    }

    // ── HELPER ────────────────────────────────────────────────────

    private function findOrCreateSocialUser($socialUser, string $provider)
    {
        if (!$socialUser->getEmail()) {
            return $this->error("L'adresse e-mail est requise pour cette connexion sociale.", 422);
        }

        $userRole = Role::where('name', 'User')->first();

        /** @var User $user */
        $user = User::firstOrCreate(
            ['email' => $socialUser->getEmail()],
            [
                'name'              => $socialUser->getName() ?? $socialUser->getNickname() ?? 'Utilisateur',
                'phone'             => null,
                'password'          => Str::random(32),
                'email_verified_at' => now(),
                'role_id'           => $userRole?->id,
            ]
        );

        if (!$user->name && $socialUser->getName()) {
            $user->update(['name' => $socialUser->getName()]);
        }

        $user->tokens()->delete();
        $token = $user->createToken("{$provider}-token")->plainTextToken;

        return $this->success([
            'user'  => $user->load('role'),
            'token' => $token,
        ], 'Authentification ' . ucfirst($provider) . ' réussie');
    }
}
