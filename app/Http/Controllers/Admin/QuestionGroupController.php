<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuestionGroup;
use App\Models\JobQuestion;



class QuestionGroupController extends Controller
{
    public function index()
    {
        $groups = QuestionGroup::with('questions')->get();
        return view('admin.questions.index', compact('groups'));
    }

    public function create()
    {
        return view('admin.questions.createquestion');
    }

    public function store(Request $request)
    {
        $request->validate([
            'group_name' => 'required|string|max:255',
            'questions.*' => 'nullable|string|max:1000',
        ]);

        // Create group
        $group = QuestionGroup::create([
            'name' => $request->group_name,
        ]);

        // Save questions if provided
        if ($request->has('questions')) {
            foreach ($request->questions as $text) {
                if (!empty($text)) {
                    JobQuestion::create([
                        'question' => $text,
                        'group_id' => $group->id,
                    ]);
                }
            }
        }

        return redirect()->route('admin.questions.index')->with('success', 'Question group and questions added successfully.');
    }

public function updateQuestion(Request $request, $id)
{
    $request->validate([
        'text' => 'required|string|max:1000',
    ]);

    $question = JobQuestion::findOrFail($id);
    $question->text = $request->text;
    $question->save();

    return back()->with('success', 'Question updated successfully.');
}

public function deleteQuestion($id)
{
    $question = JobQuestion::findOrFail($id);
    $question->delete();

    return back()->with('success', 'Question deleted successfully.');
}





    public function destroy($id)
    {
        $group = QuestionGroup::findOrFail($id);
        $group->questions()->delete(); // Delete related questions
        $group->delete();
        return back()->with('success', 'Question group deleted.');
    }
    public function show($id)
{
    $group = QuestionGroup::with('questions')->findOrFail($id);
    return view('admin.questions.showgroup', compact('group'));
}
public function edit($id)
{
    $group = QuestionGroup::with('questions')->findOrFail($id); // eager load questions
return view('admin.questions.editgroupquestion', compact('group'));

}
public function editQuestion($id)
{
    $question = JobQuestion::findOrFail($id);
    return view('admin.questions.editquestion', compact('question'));
}

    
}
