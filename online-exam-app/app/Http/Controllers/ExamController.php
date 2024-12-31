<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExamController extends Controller
{
    
    public function start(Exam $exam)
{
    $questions = $exam->questions()->inRandomOrder()->get();
    return view('exams.start', compact('exam', 'questions'));
}
public function submit(Request $request, Exam $exam)
{
    $userResponses = $request->input('responses');
    foreach ($userResponses as $questionId => $selectedOption) {
        UserResponse::create([
            'user_id' => auth()->id(),
            'exam_id' => $exam->id,
            'question_id' => $questionId,
            'selected_option' => $selectedOption,
        ]);
    }

    // Calculate score or handle results
    return redirect()->route('exam.results', $exam);
}

}
