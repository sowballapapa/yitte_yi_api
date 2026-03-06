<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends ResponseController
{
    /**
     * Display a listing of tasks.
     * Admin → toutes les tâches | User → seulement les siennes.
     * Query params: per_page, sort_by, sort_dir, priority_id, is_completed, search, start_date, end_date
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Task::class);

        $user = $request->user();

        $query = $user->isAdmin()
            ? Task::with(['user', 'taskPriority'])
            : Task::with(['taskPriority'])->where('user_id', $user->id);

        // ── Filtres ────────────────────────────────────────────────
        if ($request->filled('priority_id')) {
            $query->where('task_priority_id', $request->integer('priority_id'));
        }

        if ($request->has('is_completed')) {
            $query->where('is_completed', filter_var($request->input('is_completed'), FILTER_VALIDATE_BOOLEAN));
        }

        if ($request->filled('search')) {
            $search = '%' . $request->input('search') . '%';
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', $search)
                  ->orWhere('content', 'like', $search);
            });
        }

        if ($request->filled('start_date')) {
            $query->whereDate('start_date', '>=', $request->input('start_date'));
        }

        if ($request->filled('end_date')) {
            $query->whereDate('due_datetime', '<=', $request->input('end_date'));
        }

        // ── Tri ────────────────────────────────────────────────────
        $sortBy  = in_array($request->input('sort_by'), ['title', 'start_date', 'due_datetime', 'is_completed', 'created_at'])
            ? $request->input('sort_by')
            : 'created_at';
        $sortDir = $request->input('sort_dir', 'desc') === 'asc' ? 'asc' : 'desc';

        $query->orderBy($sortBy, $sortDir);

        // ── Pagination ─────────────────────────────────────────────
        $perPage = $request->integer('per_page', 15);

        if ($perPage === -1) {
            return $this->success($query->get(), 'Tâches récupérées avec succès');
        }

        return $this->success($query->paginate($perPage), 'Tâches récupérées avec succès');
    }

    /**
     * Store a newly created task.
     */
    public function store(StoreTaskRequest $request)
    {
        $this->authorize('create', Task::class);

        $task = Task::create(array_merge(
            $request->validated(),
            ['user_id' => $request->user()->id]
        ));

        $task->load('taskPriority');

        return $this->success($task, 'Tâche créée avec succès', 201);
    }

    /**
     * Display the specified task.
     */
    public function show(Request $request, $id)
    {
        $task = Task::with(['taskPriority', 'user'])->find($id);

        if (!$task) {
            return $this->error('Tâche non trouvée', 404);
        }

        $this->authorize('view', $task);

        return $this->success($task, 'Tâche récupérée avec succès');
    }

    /**
     * Update the specified task.
     */
    public function update(UpdateTaskRequest $request, $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return $this->error('Tâche non trouvée', 404);
        }

        $this->authorize('update', $task);

        $task->update($request->validated());

        $task->load('taskPriority');

        return $this->success($task, 'Tâche mise à jour avec succès');
    }

    /**
     * Remove the specified task.
     */
    public function destroy(Request $request, $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return $this->error('Tâche non trouvée', 404);
        }

        $this->authorize('delete', $task);

        $task->delete();

        return $this->success(null, 'Tâche supprimée avec succès');
    }
}
