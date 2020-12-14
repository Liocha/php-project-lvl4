<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LabelController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $labels = Label::all();
        return view('label.index', compact('labels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('label.create');
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
            'name' => 'required|string|unique:App\Models\Label',
            'description' => 'nullable|string',
        ]);

        Label::create($request->all());
        flash(__('messages.flash.success.added', ['obj' => 'Label']))->success();
        return redirect()->route('labels.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function show(Label $label)
    {
        //не используется
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function edit(Label $label)
    {
        return view('label.edit', compact('label'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Label $label)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique('labels')->ignore($label)
            ],
            'description' => 'nullable|string',
        ]);

        $label->fill($request->all());
        $label->save();

        flash(__('messages.flash.success.changed', ['obj' => 'Label']))->success();
        return redirect()->route('labels.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function destroy(Label $label)
    {
        if ($label->tasks()->count() != 0) {
            flash(__('messages.flash.error.deleted', ['obj' => 'Label']))->error();
            return redirect()->back();
        }
        $label->delete();
        flash(__('messages.flash.success.deleted', ['obj' => 'Label']))->success();
        return redirect()->route('labels.index');
    }
}
