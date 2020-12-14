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

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = QueryBuilder::for(Task::class)
                    ->allowedFilters(['status_id','created_by_id', 'assigned_to_id'])
                    ->get();
        $taskStatuses = TaskStatus::all();
        $users = User::all();
        $acviteFiltrs = optional(request()->get('filter'));
        return view('task.index', compact('tasks', 'users', 'taskStatuses', 'acviteFiltrs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $taskStatuses = TaskStatus::all();
        $users = User::all();
        $labels = Label::all();
        return view('task.create', compact('users', 'taskStatuses', 'labels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:App\Models\Task',
            'description' => 'nullable|string',
            'status_id' => 'required|exists:App\Models\TaskStatus,id',
            'assigned_to_id' => 'nullable|exists:App\Models\User,id'
        ]);

        $task = new Task();
        $task->created_by_id = Auth::id();
        $task->fill($request->all());
        $task->save();
        $labels = collect($request->input('labels'))->whereNotNull()->all();
        $task->labels()->sync($labels);
        flash(__('messages.flash.success.added', ['obj' => 'Task']))->success();
        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        $statusName = $task->status()->value('name');
        $labels = $task->labels()->orderBy('name')->get();
        $comments = $task->comments()->get();
        return view('task.show', compact('task', 'statusName', 'labels', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        $taskStatuses = TaskStatus::all();
        $labels = Label::all();
        $users = User::all();
        $taskLables = $task->labels->modelKeys();
        return view('task.edit', compact('task', 'taskStatuses', 'users', 'labels', 'taskLables'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique('tasks')->ignore($task)
            ],
            'description' => 'nullable|string',
            'status_id' => 'required|exists:App\Models\TaskStatus,id',
            'assigned_to_id' => 'nullable|exists:App\Models\User,id'
        ]);

        $task->fill($request->all());
        $task->save();
        $labels = collect($request->input('labels'))->whereNotNull()->all();
        $task->labels()->sync($labels);
        flash(__('messages.flash.success.changed', ['obj' => 'Task']))->success();
        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->labels()->detach();
        $task->comments()->delete();
        $task->delete();
        flash(__('messages.flash.success.deleted', ['obj' => 'Task']))->success();
        return redirect()->route('tasks.index');
    }
}
