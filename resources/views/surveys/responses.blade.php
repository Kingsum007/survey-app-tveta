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
        <tr>
            <td>{{ $response->id }}</td>
            <td>
                @php
                    $answers = $response->answers; //json_decode($response->answers,true); // Decode JSON
                @endphp
                @foreach($answers as $questionId => $answer)
                    <strong>Question ID {{ $questionId }}:</strong> {{ is_array($answer) ? implode(', ', $answer) : $answer }}<br>
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
