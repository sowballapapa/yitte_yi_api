<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserPreferenceRequest;
use App\Models\UserPreference;
use Illuminate\Http\Request;

class UserPreferenceController extends ResponseController
{
    /**
     * Display the authenticated user's preferences.
     * GET /api/preferences
     */
    public function show(Request $request)
    {
        $preference = $request->user()->preferences;

        if (!$preference) {
            return $this->error('Préférences non trouvées.', 404);
        }

        $this->authorize('view', $preference);

        return $this->success($preference, 'Préférences récupérées avec succès');
    }

    /**
     * Update the authenticated user's preferences.
     * PUT /api/preferences
     */
    public function update(UpdateUserPreferenceRequest $request)
    {
        $preference = $request->user()->preferences;

        if (!$preference) {
            return $this->error('Préférences non trouvées.', 404);
        }

        $this->authorize('update', $preference);

        $preference->update($request->validated());

        return $this->success($preference, 'Préférences mises à jour avec succès');
    }

    /**
     * Admin: list all users preferences (paginated).
     * GET /api/admin/preferences
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', UserPreference::class);

        $query = UserPreference::with('user');

        $sortBy  = in_array($request->input('sort_by'), ['user_id', 'theme', 'language', 'timezone', 'created_at'])
            ? $request->input('sort_by')
            : 'user_id';
        $sortDir = $request->input('sort_dir', 'asc') === 'desc' ? 'desc' : 'asc';
        $query->orderBy($sortBy, $sortDir);

        $perPage = $request->integer('per_page', 15);

        if ($perPage === -1) {
            return $this->success($query->get(), 'Préférences récupérées avec succès');
        }

        return $this->success($query->paginate($perPage), 'Préférences récupérées avec succès');
    }
}
