<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskStatusController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(TaskStatus::class, 'task_status');
    }

    public function index()
    {
        $taskStatuses = TaskStatus::all();
        return view('taskStatuses.index', compact('taskStatuses'));
    }

    public function create()
    {
        return view('taskStatuses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:App\Models\TaskStatus',
        ]);

        TaskStatus::create($request->all());
        flash(__('messages.flash.success.added', ['obj' => 'Status']))->success();
        return redirect()->route('task_statuses.index');
    }

    public function edit(TaskStatus $taskStatus)
    {
        return view('taskStatuses.edit', compact('taskStatus'));
    }

    public function update(Request $request, TaskStatus $taskStatus)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique('task_statuses')->ignore($taskStatus)
            ]
        ]);

        $taskStatus->fill($request->all());
        $taskStatus->save();
        flash(__('messages.flash.success.changed', ['obj' => 'Status']))->success();
        return redirect()->route('task_statuses.index');
    }

    public function destroy(TaskStatus $taskStatus)
    {
        if ($taskStatus->tasks()->count() !== 0) {
            flash(__('messages.flash.error.deleted', ['obj' => 'Status']))->error();
            return redirect()->back();
        }
        $taskStatus->delete();
        flash(__('messages.flash.success.deleted', ['obj' => 'Status']))->success();
        return redirect()->route('task_statuses.index');
    }
}
