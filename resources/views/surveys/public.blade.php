@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $survey->title }}</h1>
    <p>{{ $survey->description }}</p>
    <form action="{{ route('responses.store', $survey->id) }}" method="POST">
        @csrf
           
        @foreach ($questions as $question)
            <div class="mb-3">
                <label>{{ $question['question_text'] }}</label>

                @if ($question['question_type'] === 'text')
                    <input type="text" name="answers[{{ $question['id'] }}]" class="form-control">
                @elseif ($question['question_type'] === 'multiple_choice')
                    @foreach (json_decode($question['options']) as $option)
                        <div>
                            <input type="radio" name="answers[{{ $question['id'] }}]" value="{{ $option }}">
                            <label>{{ $option }}</label>
                        </div>
                    @endforeach
                @elseif ($question['question_type'] === 'checkbox')
                    @foreach (json_decode($question['options']) as $option)
                        <div>
                            <input type="checkbox" name="answers[{{ $question['id'] }}][]" value="{{ $option }}">
                            <label>{{ $option }}</label>
                        </div>
                    @endforeach
                @elseif ($question['question_type'] === 'dropdown')
                    <select name="answers[{{ $question['id'] }}]" class="form-control">
                        @foreach (json_decode($question['options']) as $option)
                            <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                    </select>
                @endif
            </div>
        @endforeach

        <button type="submit" class="btn btn-success">Submit</button>
    </form>
</div>
@endsection
