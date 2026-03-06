<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\ResponseController;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password as PasswordRule;

class AuthController extends ResponseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone'    => ['required', 'string', 'max:20', 'unique:users,phone'],
            'password' => ['required', 'confirmed', PasswordRule::min(8)->letters()->mixedCase()->numbers()->symbols()],
        ], [
            'name.required'      => 'Le nom est obligatoire.',
            'name.max'           => 'Le nom ne peut pas dépasser 255 caractères.',
            'email.required'     => "L'adresse e-mail est obligatoire.",
            'email.email'        => "L'adresse e-mail n'est pas valide.",
            'email.unique'       => 'Cette adresse e-mail est déjà utilisée.',
            'phone.required'     => 'Le numéro de téléphone est obligatoire.',
            'phone.unique'       => 'Ce numéro de téléphone est déjà utilisé.',
            'password.required'  => 'Le mot de passe est obligatoire.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        if ($validator->fails()) {
            return $this->error('Erreur de validation', 422, $validator->errors());
        }

        $userRole = Role::where('name', 'User')->first();

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role_id'  => $userRole?->id,
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return $this->success([
            'user'  => $user->load('role'),
            'token' => $token,
        ], 'Compte créé avec succès', 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required'    => "L'adresse e-mail est obligatoire.",
            'email.email'       => "L'adresse e-mail n'est pas valide.",
            'password.required' => 'Le mot de passe est obligatoire.',
        ]);

        if ($validator->fails()) {
            return $this->error('Erreur de validation', 422, $validator->errors());
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->error('Identifiants incorrects. Veuillez vérifier votre e-mail et mot de passe.', 401);
        }

        /** @var User $user */
        $user = Auth::user();
        $user->tokens()->delete();

        $token = $user->createToken('api-token')->plainTextToken;

        return $this->success([
            'user'  => $user->load('role'),
            'token' => $token,
        ], 'Connexion réussie');
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success(null, 'Déconnexion réussie');
    }

    public function logoutAll(Request $request)
    {
        $request->user()->tokens()->delete();

        return $this->success(null, 'Déconnexion de tous les appareils réussie');
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.required' => "L'adresse e-mail est obligatoire.",
            'email.email'    => "L'adresse e-mail n'est pas valide.",
            'email.exists'   => "Aucun compte n'est associé à cette adresse e-mail.",
        ]);

        if ($validator->fails()) {
            return $this->error('Erreur de validation', 422, $validator->errors());
        }

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return $this->success(null, 'Un lien de réinitialisation a été envoyé à votre adresse e-mail.');
        }

        return $this->error("Impossible d'envoyer le lien de réinitialisation. Veuillez réessayer.", 500);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token'    => ['required', 'string'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'confirmed', PasswordRule::min(8)->letters()->mixedCase()->numbers()->symbols()],
        ], [
            'token.required'     => 'Le token de réinitialisation est obligatoire.',
            'email.required'     => "L'adresse e-mail est obligatoire.",
            'email.email'        => "L'adresse e-mail n'est pas valide.",
            'password.required'  => 'Le nouveau mot de passe est obligatoire.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        if ($validator->fails()) {
            return $this->error('Erreur de validation', 422, $validator->errors());
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill(['password' => Hash::make($password)])->save();
                $user->tokens()->delete();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return $this->success(null, 'Mot de passe réinitialisé avec succès. Veuillez vous reconnecter.');
        }

        return $this->error(
            $status === Password::INVALID_TOKEN
                ? 'Token invalide ou expiré.'
                : 'Erreur lors de la réinitialisation du mot de passe.',
            400
        );
    }

    public function me(Request $request)
    {
        return $this->success($request->user()->load('role'), 'Profil récupéré avec succès');
    }
}
