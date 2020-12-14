<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $taskStatuses = TaskStatus::all();
        return view('taskStatuses.index', compact('taskStatuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('taskStatuses.create');
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
            'name' => 'required|string|unique:App\Models\TaskStatus',
        ]);

        TaskStatus::create($request->all());
        flash(__('messages.flash.success.added', ['obj' => 'Status']))->success();
        return redirect()->route('task_statuses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function show(TaskStatus $taskStatus)
    {
        //не используется
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(TaskStatus $taskStatus)
    {
        return view('taskStatuses.edit', compact('taskStatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaskStatus $taskStatus)
    {
        if ($taskStatus->task()->count() != 0) {
            flash(__('messages.flash.error.deleted', ['obj' => 'Status']))->error();
            return redirect()->back();
        }
        $taskStatus->delete();
        flash(__('messages.flash.success.deleted', ['obj' => 'Status']))->success();
        return redirect()->route('task_statuses.index');
    }
}
