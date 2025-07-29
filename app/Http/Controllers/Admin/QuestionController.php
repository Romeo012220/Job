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

public function edit($id)
{
    $question = Question::findOrFail($id);
    return view('admin.questions.edit', compact('question'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'question' => 'required|string|max:255',
    ]);

    $question = Question::findOrFail($id);
    $question->question = $request->question;
    $question->save();

    return redirect()->route('admin.question-groups.show', $question->question_group_id)->with('success', 'Question updated.');
}



 public function destroy($id)
{
    $question = Question::findOrFail($id);
    $groupId = $question->question_group_id;
    $question->delete();

    return redirect()->route('admin.question-groups.show', $groupId)
                     ->with('success', 'Question deleted successfully.');
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
