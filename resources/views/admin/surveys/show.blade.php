@extends('admin.layouts.admin')
@section('content')
<div class="container">
    <h1>{{ $survey->title }}</h1>
    <p>{{ $survey->description }}</p>

    @if(auth()->id() == $survey->user_id)
        <a href="{{ route('control.statistics', $survey) }}" class="btn btn-info">View Statistics</a>
        <a href="{{ route('control.responses', $survey) }}" class="btn btn-info">View Responses</a>
    @endif

    <form action="/surveys/{{ $survey }}/responses" method="POST" enctype="multipart/form-data">
        @csrf

        @foreach ($survey->questions as $question)
            <div class="form-group">
                <label>{{ $question->question_text }}</label>

                {{-- Text input --}}
                @if ($question->question_type == 'text')
                    <input type="text" name="answers[{{$question->id}}][text]" class="form-control">

                {{-- Multiple choice --}}
                @elseif ($question->question_type == 'multiple_choice')
                    @foreach (json_decode($question->options) as $option)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answers[{{ $question->id }}][radio]" value="{{ $option }}">
                            <label class="form-check-label">{{ $option }}</label>
                        </div>
                    @endforeach

                {{-- Checkbox --}}
                @elseif ($question->question_type == 'checkbox')
                    @foreach (json_decode($question->options) as $option)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="answers[{{ $question->id }}][checkbox][]" value="{{ $option }}">
                            <label class="form-check-label">{{ $option }}</label>
                        </div>
                    @endforeach

                {{-- Dropdown --}}
                @elseif ($question->question_type == 'dropdown')
                    <select class="form-control" name="answers[{{ $question->id }}][dropdown]">
                        <option value="">Select an option</option>
                        @foreach (json_decode($question->options) as $option)
                            <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                    </select>

                {{-- File upload --}}
                @elseif($question->question_type == 'file')
                <input type="file" name="answers[{{$question->id}}][file_upload]" class="form-control">
                @endif
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
