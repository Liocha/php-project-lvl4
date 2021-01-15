<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class LabelController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Label::class, 'label');
    }

    public function index(): View
    {
        $labels = Label::all();
        return view('label.index', compact('labels'));
    }

    public function create(): View
    {
        return view('label.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|unique:labels',
            'description' => 'nullable|string',
        ]);

        Label::create($request->all());
        flash(__('messages.flash.success.added', ['subject' => __('label.subject')]))->success();
        return redirect()->route('labels.index');
    }

    public function edit(Label $label): View
    {
        return view('label.edit', compact('label'));
    }

    public function update(Request $request, Label $label): RedirectResponse
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

        flash(__('messages.flash.success.changed', ['subject' => __('label.subject')]))->success();
        return redirect()->route('labels.index');
    }

    public function destroy(Label $label): RedirectResponse
    {
        if ($label->tasks()->exists()) {
            flash(__('messages.flash.error.deleted', ['subject' => __('label.subject')]))->error();
            return redirect()->back();
        }
        $label->delete();
        flash(__('messages.flash.success.deleted', ['subject' => __('label.subject')]))->success();
        return redirect()->route('labels.index');
    }
}
