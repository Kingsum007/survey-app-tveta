@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Responses for Survey: {{ $survey->title }}</h1>

    @if($responses->isEmpty())
        <p>No responses yet.</p>
    @else
    <table class="table">
        <thead>
            <tr>
                <th>Response ID</th>
                <th>Answers</th>
                <th>Submitted At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($responses as $response)
            @php
                // Ensure $response->answers is decoded if it's a string
                $answers = is_array($response->answers) ? $response->answers : json_decode($response->answers, true);
            @endphp
            <tr>
                <td>{{ $response->id }}</td>
                <td>
                    @foreach ($answers as $questionId => $answer)
    <div class="answer">
        <strong>Question ID {{ $questionId }}:</strong>

        @if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $answer))
            <!-- Image File: Display Thumbnail -->
            <img src="{{ asset( $answer) }}" alt="Image" style="max-width: 200px; max-height: 200px; border-radius: 5px;">

        @elseif (preg_match('/\.(pdf|docx|doc|xlsx|xls|pptx|ppt)$/i', $answer))
            <!-- Document File: Display Download Link -->
            <a href="{{ asset( $answer) }}" target="_blank">Download {{ pathinfo($answer, PATHINFO_BASENAME) }}</a>
        @else
            <!-- Other Non-Image, Non-Document File: Display as Text -->
            <p>{{ $answer }}</p>
        @endif
    </div>
@endforeach

                </td>
                <td>{{ $response->created_at }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    
    @endif
</div>
@endsection