@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $survey->title }}</h1>
    <p>{{ $survey->description }}</p>

    <form action="{{ route('surveys.responses.store', $survey->id) }}" method="POST">
        @csrf

        @foreach ($survey->questions as $question)
            <div class="mb-3">
                <label>{{ $question->text }}</label>

                @if ($question->type === 'text')
                    <input type="text" name="answers[{{ $question->id }}]" class="form-control">
                @elseif ($question->type === 'multiple_choice')
                    @foreach (json_decode($question->options) as $option)
                        <div>
                            <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option }}">
                            <label>{{ $option }}</label>
                        </div>
                    @endforeach
                @elseif ($question->type === 'checkbox')
                    @foreach (json_decode($question->options) as $option)
                        <div>
                            <input type="checkbox" name="answers[{{ $question->id }}][]" value="{{ $option }}">
                            <label>{{ $option }}</label>
                        </div>
                    @endforeach
                @elseif ($question->type === 'dropdown')
                    <select name="answers[{{ $question->id }}]" class="form-control">
                        @foreach (json_decode($question->options) as $option)
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
