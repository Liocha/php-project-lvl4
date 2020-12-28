<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Task::class, 'task');
    }

    public function index(): View
    {
        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters(['status_id', 'created_by_id', 'assigned_to_id'])
            ->get();
        $taskStatuses = TaskStatus::all();
        $users = User::all();
        $acviteFilters = optional(request()->get('filter'));
        return view('task.index', compact('tasks', 'users', 'taskStatuses', 'acviteFilters'));
    }

    public function create(): View
    {
        $taskStatuses = TaskStatus::all();
        $users = User::all();
        $labels = Label::all();
        return view('task.create', compact('users', 'taskStatuses', 'labels'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => "required|string|unique:tasks",
            'description' => 'nullable|string',
            'assigned_to_id' => 'nullable|exists:users,id',
            'labels.*' => 'exists:labels,id'
        ]);
        $task = new Task();
        $task->creator()->associate(Auth::user());
        $task->fill($request->all());
        $task->save();
        $task->labels()->sync($request->input('labels'));
        flash(__('messages.flash.success.added', ['subject' => 'Task']))->success();
        return redirect()->route('tasks.index');
    }

    public function show(Task $task): View
    {
        $statusName = $task->status->name;
        $labels = $task->labels()->orderBy('name')->get();
        $comments = $task->comments()->get();
        return view('task.show', compact('task', 'statusName', 'labels', 'comments'));
    }

    public function edit(Task $task): View
    {
        $taskStatuses = TaskStatus::all();
        $labels = Label::all();
        $users = User::all();
        $taskLables = $task->labels->modelKeys();
        return view('task.edit', compact('task', 'taskStatuses', 'users', 'labels', 'taskLables'));
    }

    public function update(Request $request, Task $task): RedirectResponse
    {

        $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique('tasks')->ignore($task)
            ],
            'description' => 'nullable|string',
            'status_id' => 'required|exists:task_statuses,id',
            'assigned_to_id' => 'nullable|exists:users,id',
            'labels.*' => 'exists:labels,id'
        ]);
        $task->fill($request->all());
        $task->save();
        $task->labels()->sync($request->input('labels'));
        flash(__('messages.flash.success.changed', ['subject' => 'Task']))->success();
        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task): RedirectResponse
    {
        $task->labels()->detach();
        $task->comments()->delete();
        $task->delete();
        flash(__('messages.flash.success.deleted', ['subject' => 'Task']))->success();
        return redirect()->route('tasks.index');
    }
}
