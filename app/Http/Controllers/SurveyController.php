<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\Response;
use Str;

class SurveyController extends Controller
{
    public function index()
    {
        $surveys = Survey::orderBy('created_at','desc')->paginate(9);
        return view('surveys.index', compact('surveys'));
    }

    public function create()
    {
        return view('surveys.create');
    }

    public function store(Request $request)
    {
        try{
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'questions.*.question_text' => 'required|string',
            'questions.*.question_type' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'questions.*.options' => 'nullable|string', // Assuming options are passed as a string
        ]); 

        // Create the survey
        $survey = new Survey();
        $survey->title = $request->title;
        $survey->description = $request->description;
        $survey->user_id = auth()->id(); // Set the user_id to the logged-in user's ID
        $survey->token = Str::random(32); // Generate a random token
        $survey->save();

         // Handle image upload (if there's an image)
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension(); // Create a unique name for the image
        $image->storeAs('survey_images', $imageName, 'public'); // Store the image in the public disk
        $survey->image = 'survey_images/' . $imageName; // Save the image path to the database
        $survey->save(); // Save the survey again with the image path
    }
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
    catch (\Exception $e) {
        // Log the error
        \Log::error('Error while storing survey: ' . $e->getMessage());

        // Optionally, return a response with error message
        return back()->with('error', 'An error occurred while creating the survey. Please try again later.');
    }
}


    public function show(Survey $survey)
    {
        return view('surveys.show', compact('survey'));
    }
    public function showResponses($surveyId)
    {
        $survey = Survey::with('questions')->findOrFail($surveyId); // Eager load questions
        $responses = $survey->responses()->orderBy('created_at', 'desc')->paginate(10); // Paginate responses
    
        return view('surveys.responses', compact('survey', 'responses'));
    }

    public function update(Request $request, $id)
    {
        try{
        // Validate the request if necessary
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'questions.*.question_text' => 'required|string',
            'questions.*.question_type' => 'required|string',
            'questions.*.options' => 'nullable|string', // Adjust as needed
        ]);

        // Find the survey
        $survey = Survey::findOrFail($id);
        $survey->update($validatedData);

        // Update questions
        foreach ($request->input('questions') as $questionId => $questionData) {
            // Check if question ID is valid
            if (isset($questionData['question_text'])) {
                $question = Question::findOrFail($questionId);
                $question->update($questionData);
            }
        }

        return redirect()->route('surveys.edit', $id)->with('success', 'Survey updated successfully!');
    }
    catch(\Exception $e){
         // Log the error
         \Log::error('Error while Updating survey: ' . $e->getMessage());

         // Optionally, return a response with error message
         return back()->with('error', 'An error occurred while creating the survey. Please try again later.');
    }
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

        $questions = json_decode($survey->questions, true);


        return view('surveys.public', compact('survey', 'questions'));
    }
    public function destroy($survey)
    {
        Survey::where('id', $survey)->delete();
        Question::where('survey_id', $survey)->delete();
        Response::where('survey_id', $survey)->delete();
        return redirect()->back()->with('success', 'Survey Deleted Successfully');
    }
    public function edit($id)
    {
        $survey = Survey::with('questions')->findOrFail($id);

        return view('surveys.edit', compact('survey'));
    }
    public function admin()
    {
        return view('about');
    }

}
