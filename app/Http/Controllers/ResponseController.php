<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Response;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    public function store(Request $request, $surveyId)
    {
        $request->validate([
          'answers.*.file_upload' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf,xlsx,docx,doc,pptx,ppt|max:2048',
            'answers.*.text' => 'nullable|string',
            'answers.*.radio' => 'nullable|string', // Changed to string for radio options
            'answers.*.checkbox' => 'nullable|array',
            'answers.*.dropdown' => 'nullable|string', // Assuming dropdown is also a string
        ]);
    
        $answers = [];
    
        foreach ($request->answers as $questionId => $answer) {
            \Log::debug("Processing question ID: {$questionId} with data: " . json_encode($answer));
    
            // Handle text input
            if (isset($answer['text'])) {
                $answers[$questionId] = $answer['text'];
            }
    
            // Handle radio input
            if (isset($answer['radio'])) {
                $answers[$questionId] = $answer['radio'];
            }
    
            // Handle checkbox input
            if (isset($answer['checkbox'])) {
                $answers[$questionId] = implode(', ', $answer['checkbox']);
            }
    
            // Handle dropdown input
            if (isset($answer['dropdown'])) {
                $answers[$questionId] = $answer['dropdown'];
            }
    
            // Handle file upload
            if (isset($answer['file_upload']) && $answer['file_upload'] instanceof \Illuminate\Http\UploadedFile) {
                $imageName = time() . '_' . $questionId . '.' . $answer['file_upload']->getClientOriginalExtension();
                $answer['file_upload']->storeAs('images', $imageName, 'public');
                $answers[$questionId] = 'storage/images/' . $imageName;
            }
        }
    
        // Check if any answers were processed
        if (empty($answers)) {
           \Log::error("No answers were processed.");
            return redirect()->back()->withErrors("No answers to save.");
        }
    
        // Save the answers
        Response::create([
            'survey_id' => $surveyId,
            'answers' => json_encode($answers),
        ]);
    
        return redirect()->route('surveys.index')->with('success', 'Responses submitted successfully.');
    }
    

}

