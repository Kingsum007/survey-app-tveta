<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Response;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    public function store(Request $request, Survey $survey)
    {
        // Validate and store the response
        $response = new Response();
        $response->survey_id = $survey->id;
        $response->answers = json_encode($request->answers);
        $response->save();
    
        return redirect()->route('surveys.public', $survey->token)->with('success', 'Thank you for your response!');
    }
    
    
}

