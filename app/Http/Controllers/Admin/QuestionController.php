<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobQuestion;
use App\Models\QuestionGroup;

class QuestionController extends Controller
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
        // Implement this if needed
    }

    public function show($id)
    {
        $question = JobQuestion::findOrFail($id);
        return view('admin.questions.show', compact('question'));
    }

    public function edit($id)
    {
        $question = JobQuestion::findOrFail($id); // ✅ FIXED
        return view('admin.questions.edit', compact('question'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'question' => 'required|string|max:255',
        ]);

        $question = JobQuestion::findOrFail($id); // ✅ FIXED
        $question->question = $request->question;
        $question->save();

        return redirect()->route('admin.question-groups.show', $question->group_id)
                         ->with('success', 'Question updated.');
    }

    public function destroy($id)
    {
        $question = JobQuestion::findOrFail($id); // ✅ FIXED
        $groupId = $question->group_id;
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

        return redirect()->route('admin.questions.index')
                         ->with('success', 'Group created successfully!');
    }
}
