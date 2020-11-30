<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{


    public function __construct()
    {
        $this->authorizeResource(Task::class, 'task');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::with('creator', 'status', 'assignee')->get();
        return view('task.index', compact('tasks'));
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
        return view('task.create', compact('users', 'taskStatuses'));
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
            'status_id' => 'required|exists:App\Models\TaskStatus,id'
        ]);

        $task = new Task();
        $task->created_by_id = Auth::id();
        $task->fill($request->all());
        $task->save();
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
        $statusName = TaskStatus::where('id', $task->status_id)->value('name');
        return view('task.show', compact('task', 'statusName'));
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
        $users = User::all();
        return view('task.edit', compact('task', 'taskStatuses', 'users'));
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
            'name' => 'required|string|unique:App\Models\Task',
            'description' => 'nullable|string',
            'status_id' => 'required|exists:App\Models\TaskStatus,id'
        ]);

        $task->fill($request->all());
        $task->save();

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
        $task->delete();
        flash(__('messages.flash.success.deleted', ['obj' => 'Task']))->success();
        return redirect()->route('tasks.index');
    }
}
