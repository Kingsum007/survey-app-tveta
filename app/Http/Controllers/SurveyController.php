<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Question;
use Illuminate\Http\Request;
use Str;

class SurveyController extends Controller
{
    public function index()
    {
        $surveys = Survey::where('user_id', auth()->id())->get();
        return view('surveys.index', compact('surveys'));
    }

    public function create()
    {
        return view('surveys.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'questions.*.question_text' => 'required|string',
            'questions.*.question_type' => 'required|string',
            'questions.*.options' => 'nullable|string', // Assuming options are passed as a string
        ]);

        // Create the survey
        $survey = new Survey();
        $survey->title = $request->title;
        $survey->description = $request->description;
        $survey->user_id = auth()->id(); // Set the user_id to the logged-in user's ID
        $survey->token = Str::random(32); // Generate a random token
        $survey->save();

        // Loop through the questions and save them
        foreach ($validated['questions'] as $index => $question) {
            // Encode the options as JSON
            $options = json_encode(array_filter(explode(',', $question['options']))); // Converts comma-separated options to array and then encodes

            $survey->questions()->create([
                'question_text' => $question['question_text'],
                'question_type' => $question['question_type'],
                'options' => $options,
            ]);
        }

        return redirect()->route('surveys.index')->with('success', 'Survey created successfully!');
    }


    public function show(Survey $survey)
    {
        return view('surveys.show', compact('survey'));
    }
    public function showResponses(Survey $survey)
    {
        // Get responses for the survey
        $responses = $survey->responses; // Ensure you define this relationship in the Survey model

        return view('surveys.responses', compact('survey', 'responses'));
    }
    public function update(Request $request, Survey $survey)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'questions.*.question_text' => 'required|string',
            'questions.*.question_type' => 'required|string',
            'questions.*.options' => 'nullable|string', // Assuming options are passed as a string
        ]);

        // Update the survey
        $survey->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
        ]);

        // Update or create questions
        foreach ($validated['questions'] as $index => $question) {
            $options = json_encode(array_filter(explode(',', $question['options']))); // Converts comma-separated options to array and then encodes

            // Update existing question or create a new one
            $survey->questions()->updateOrCreate(
                ['id' => $question['id']], // Make sure to have question ID in your input if updating
                [
                    'question_text' => $question['question_text'],
                    'question_type' => $question['question_type'],
                    'options' => $options,
                ]
            );
        }

        return redirect()->route('surveys.index')->with('success', 'Survey updated successfully!');
    }

    public function showStatistics(Survey $survey)
    {
        // Fetch all responses related to the survey
        $responses = $survey->responses;

        // Process the responses for statistics
        $statistics = $this->calculateStatistics($responses);

        return view('surveys.statistics', compact('survey', 'statistics'));
    }

    private function calculateStatistics($responses)
    {
        $statistics = [];

        foreach ($responses as $response) {
            $answers = $response->answers; // Now you can access it as a property

            foreach ($answers as $questionId => $answer) {
                if (!isset($statistics[$questionId])) {
                    $statistics[$questionId] = [
                        'total' => 0,
                        'counts' => [],
                    ];
                }

                $statistics[$questionId]['total']++;

                // Count answers based on question type
                if (is_array($answer)) {
                    foreach ($answer as $item) {
                        $statistics[$questionId]['counts'][$item] = ($statistics[$questionId]['counts'][$item] ?? 0) + 1;
                    }
                } else {
                    $statistics[$questionId]['counts'][$answer] = ($statistics[$questionId]['counts'][$answer] ?? 0) + 1;
                }
            }
        }

        return $statistics;
    }
    public function showPublicSurvey($token)
    {
        $survey = Survey::where('token', $token)->firstOrFail();

        $questions = json_decode($survey->questions,true);
        

        return view('surveys.public', compact('survey','questions'));
    }


}
