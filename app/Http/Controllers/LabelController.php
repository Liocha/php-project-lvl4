<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LabelController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Label::class, 'label');
    }

    public function index()
    {
        $labels = Label::all();
        return view('label.index', compact('labels'));
    }

    public function create()
    {
        return view('label.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:App\Models\Label',
            'description' => 'required|nullable|string',
        ]);

        Label::create($request->all());
        flash(__('messages.flash.success.added', ['obj' => 'Label']))->success();
        return redirect()->route('labels.index');
    }

    public function show(Label $label)
    {
        //не используется
    }

    public function edit(Label $label)
    {
        return view('label.edit', compact('label'));
    }

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
