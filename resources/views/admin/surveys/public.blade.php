
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $survey->{{ __('message.title') }} }}</h1>
    <p>{{ $survey->{{ __('message.survey_description') }} }}</p>
    <form action="{{ route('responses.store', $survey) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @foreach ($survey->questions as $question)
            <div class="form-group">
                <label>{{ $question->question_text }}</label>
                @if ($question->question_type == 'text')
                <input type="text" name="answers[{{$question->id}}][question_text]" class="form-control">

                @elseif ($question->question_type == 'multiple_choice')
                    @foreach (json_decode($question->options) as $option)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answers[{{ $question->id }}][options]" value="{{ $option }}">
                            <label class="form-check-label">{{ $option }}</label>
                        </div>
                    @endforeach
                @elseif ($question->question_type == 'checkbox')
                    @foreach (json_decode($question->options) as $option)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="answers[{{ $question->id }}][options]" value="{{ $option }}">
                            <label class="form-check-label">{{ $option }}</label>
                        </div>
                    @endforeach
                @elseif ($question->question_type == 'dropdown')
                    <select class="form-control" name="answers[{{ $question->id }}][options]">
                        <option value="">Select an option</option>
                        @foreach (json_decode($question->options) as $option)
                            <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                    </select>
                    @elseif($question->question_type == 'file')
                    
                        <input type="file" name="answers[{{$question->id}}][file_upload]" id="" class="form-control">
                    
                @endif
            </div>
        @endforeach
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection

