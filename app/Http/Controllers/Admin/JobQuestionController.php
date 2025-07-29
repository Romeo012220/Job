<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobQuestion;

class JobQuestionController extends Controller
{
    public function edit($id)
    {
        $question = JobQuestion::findOrFail($id);
        return view('admin.questions.editquestion', compact('question'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'question' => 'required|string|max:1000',
        ]);

        $question = JobQuestion::findOrFail($id);
        $question->question = $request->question;
        $question->save();

        return redirect()->route('admin.questions.index')->with('success', 'Question updated successfully.');
    }

    public function destroy($id)
    {
        $question = JobQuestion::findOrFail($id);
        $question->delete();

        return back()->with('success', 'Question deleted successfully.');
    }
}
