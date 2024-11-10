@extends('admin.layouts.admin')

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
                                // Decode JSON
                                $answers = is_array($response->answers) ? $response->answers : json_decode($response->answers, true);
                            @endphp
                            @foreach($responses as $response)
                            <tr>
                                <td>{{ $response->id }}</td>
                                <td>
                                
                                    @foreach ($answers as $questionId => $answer)
                                    <div class="answer">
                                        <strong>Question ID {{ $questionId }}:</strong>
                                        
                                        @if (is_string($answer))
                                            <!-- Check if it's an image -->
                                            @if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $answer))
                                                @php
                                                    $imagePath = str_replace('\/', '/', $answer);
                                                @endphp
                                                <img src="{{ asset($imagePath) }}" alt="Uploaded Image" style="max-width: 200px; max-height: 200px;">
                                            <!-- Check if it's a document -->
                                            @elseif (preg_match('/\.(pdf|docx|doc|xlsx|xls|pptx|ppt)$/i', $answer))
                                                @php
                                                    $filePath = str_replace('\/', '/', $answer);
                                                @endphp
                                                <a href="{{ asset($filePath) }}" target="_blank">{{ __('message.download') }}</a>
                                            @else
                                                <!-- If it's a text answer -->
                                                {{ $answer }}
                                            @endif
                                        @else
                                            <!-- Handle case where answer isn't a string -->
                                            <p>No valid answer available.</p>
                                        @endif
                                    </div>
                                @endforeach
                                
                                </td>
                                <td>{{ $response->created_at }}</td>
                            </tr>
                        @endforeach
                        </td>  
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection