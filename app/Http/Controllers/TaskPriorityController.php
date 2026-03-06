<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskPriorityRequest;
use App\Http\Requests\UpdateTaskPriorityRequest;
use App\Models\TaskPriority;
use Illuminate\Http\Request;

class TaskPriorityController extends ResponseController
{
    /**
     * Display a listing of task priorities.
     * Query params: per_page, sort_by, sort_dir, search
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', TaskPriority::class);

        $query = TaskPriority::query();

        // ── Filtres ────────────────────────────────────────────────
        if ($request->filled('search')) {
            $search = '%' . $request->input('search') . '%';
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', $search)
                  ->orWhere('description', 'like', $search);
            });
        }

        // ── Tri ────────────────────────────────────────────────────
        $sortBy  = in_array($request->input('sort_by'), ['name', 'color', 'created_at'])
            ? $request->input('sort_by')
            : 'name';
        $sortDir = $request->input('sort_dir', 'asc') === 'desc' ? 'desc' : 'asc';

        $query->orderBy($sortBy, $sortDir);

        // ── Pagination ─────────────────────────────────────────────
        $perPage = $request->integer('per_page', 15);

        if ($perPage === -1) {
            return $this->success($query->get(), 'Priorités récupérées avec succès');
        }

        return $this->success($query->paginate($perPage), 'Priorités récupérées avec succès');
    }

    /**
     * Store a newly created task priority.
     */
    public function store(StoreTaskPriorityRequest $request)
    {
        $this->authorize('create', TaskPriority::class);

        $taskPriority = TaskPriority::create($request->validated());

        return $this->success($taskPriority, 'Priorité créée avec succès', 201);
    }

    /**
     * Display the specified task priority.
     */
    public function show(Request $request, $id)
    {
        $taskPriority = TaskPriority::find($id);

        if (!$taskPriority) {
            return $this->error('Priorité non trouvée', 404);
        }

        $this->authorize('view', $taskPriority);

        return $this->success($taskPriority, 'Priorité récupérée avec succès');
    }

    /**
     * Update the specified task priority.
     */
    public function update(UpdateTaskPriorityRequest $request, $id)
    {
        $taskPriority = TaskPriority::find($id);

        if (!$taskPriority) {
            return $this->error('Priorité non trouvée', 404);
        }

        $this->authorize('update', $taskPriority);

        $taskPriority->update($request->validated());

        return $this->success($taskPriority, 'Priorité mise à jour avec succès');
    }

    /**
     * Remove the specified task priority.
     */
    public function destroy(Request $request, $id)
    {
        $taskPriority = TaskPriority::find($id);

        if (!$taskPriority) {
            return $this->error('Priorité non trouvée', 404);
        }

        $this->authorize('delete', $taskPriority);

        $taskPriority->delete();

        return $this->success(null, 'Priorité supprimée avec succès');
    }
}
