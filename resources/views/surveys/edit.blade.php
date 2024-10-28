@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Edit Survey <i class="badge badge-outline-danger">"{{$survey->title}}"</i></h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('surveys.update', $survey->id) }}" method="POST">
        @method('PATCH')
        @csrf
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" value="{{ old('title', $survey->title) }}" class="form-control"
                required>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea name="description" id="description" class="form-control"
                required>{{ old('description', $survey->description) }}</textarea>
        </div>

        <h3>Questions</h3>
        @foreach ($survey->questions as $question)
            <div class="form-group">

                <label for="question_text{{ $question->id }}">Question Text:</label>
                <input type="text" name="questions[{{ $question->id }}][question_text]"
                    id="question_text{{ $question->id }}"
                    value="{{ old('questions.' . $question->id . '.question_text', $question->question_text) }}"
                    class="form-control" required>

                <label for="question_type{{ $question->id }}">Question Type:</label>
                <select name="questions[{{ $question->id }}][question_type]" id="question_type{{ $question->id }}"
                    class="form-control">
                    <option value="text" {{ $question->question_type == 'text' ? 'selected' : '' }}>Text</option>
                    <option value="multiple_choice" {{ $question->question_type == 'multiple_choice' ? 'selected' : '' }}>
                        Multiple Choice</option>
                    <option value="checkbox" {{ $question->question_type == 'checkbox' ? 'selected' : '' }}>Check Box</option>
                    <option value="dropdown" {{ $question->question_type == 'dropdown' ? 'selected' : '' }}>Drop Down
                    </option>
                </select>

                <label for="options{{ $question->id }}">Options (comma-separated):</label>
                <input type="text" name="questions[{{ $question->id }}][options]" id="options{{ $question->id }}"
                    value="{{ old('questions.' . $question->id . '.options', $question->options) }}" class="form-control">
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Update Survey</button>
    </form>
</div>
@endsection