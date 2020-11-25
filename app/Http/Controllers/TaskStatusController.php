<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskStatusController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(TaskStatus::class, 'task_status');
    }
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
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            flash('Поле name не должно быть пустым!')->error();
            return redirect()->back();
        }

        TaskStatus::create($request->all());
        flash('Таск успешно добавлен!')->success();
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
        return "Заглушка";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(TaskStatus $taskStatus)
    {
        $taskStatus = TaskStatus::find($taskStatus->id);
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
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            flash('Поле name не должно быть пустым!')->error();
            return redirect()->back();
        }

        $taskStatus = TaskStatus::find($taskStatus->id);
        $taskStatus->update($request->all());
        flash('Таск был успешно изменен!')->success();
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
        TaskStatus::find($taskStatus->id)->delete();
        flash('Таск был успешно удален!')->success();
        return redirect()->route('task_statuses.index');
    }
}
