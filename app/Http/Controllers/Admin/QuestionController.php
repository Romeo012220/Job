<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\QuestionGroup;

class QuestionController extends Controller
{
public function index()
{
    $groups = \App\Models\QuestionGroup::with('questions')->get();
    return view('admin.questions.index', compact('groups'));
}



 public function create()
{
    return view('admin.questions.createquestion');
}


    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $question = Question::findOrFail($id);
        return view('admin.questions.show', compact('question'));
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    public function viewGroup($groupId)
    {
        $group = QuestionGroup::with('questions')->findOrFail($groupId);
        return view('admin.questions.showgroup', compact('group'));
    }

    public function storeGroup(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    QuestionGroup::create([
        'name' => $request->input('name'),
    ]);

    return redirect()->route('admin.questions.index')->with('success', 'Group created successfully!');
}

}
