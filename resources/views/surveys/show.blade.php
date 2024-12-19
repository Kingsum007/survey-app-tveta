@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $survey->title }}</h1>
    <p>{{ $survey->description }}</p>

    @if(auth()->id() == $survey->user_id)
        <a href="{{ route('surveys.statistics', $survey) }}" class="btn btn-info">View Statistics</a>
        <a href="{{ route('surveys.responses', $survey) }}" class="btn btn-info">View Responses</a>
    @endif

    <form action="{{ route('responses.store', $survey) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="progress-bar-container">
            <div class="progress-bar" id="progress-bar"></div>
        </div>

        @foreach ($survey->questions as $index => $question)
            <div class="card-question">
                <h5>{{ $question->question_text }}</h5>

                {{-- Text input --}}
                @if ($question->question_type == 'text')
                    <input type="text" name="answers[{{$question->id}}][text]" class="form-control" required>
                
                {{-- Multiple choice --}}
                @elseif ($question->question_type == 'multiple_choice')
                    @foreach (json_decode($question->options) as $option)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answers[{{ $question->id }}][radio]" value="{{ $option }}" required>
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
                    <select class="form-control" name="answers[{{ $question->id }}][dropdown]" required>
                        <option value="">Select an option</option>
                        @foreach (json_decode($question->options) as $option)
                            <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                    </select>

                {{-- File upload --}}
                @elseif($question->question_type == 'file')
                    <input type="file" name="answers[{{$question->id}}][file_upload]" class="form-control" onchange="previewFile(event, {{ $question->id }})" required>
                    <div class="file-preview" id="file-preview-{{ $question->id }}"></div>
                @endif
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary" id="submit-btn">
            Submit <span id="submit-spinner" class="spinner" style="display: none;"></span>
        </button>
    </form>
</div>

<script>
// File Preview Function
function previewFile(event, questionId) {
    var filePreview = document.getElementById('file-preview-' + questionId);
    var file = event.target.files[0];
    
    if (file) {
        var reader = new FileReader();
        
        reader.onload = function() {
            var fileType = file.type.split('/')[0];
            
            if (fileType === 'image') {
                filePreview.innerHTML = `<img src="${reader.result}" alt="Preview">`;
            } else {
                filePreview.innerHTML = `<span>File: ${file.name}</span>`;
            }
        };
        
        reader.readAsDataURL(file);
    }
}

// Dynamic Progress Bar Update
let totalQuestions = {{ $survey->questions->count() }};
let answeredQuestions = 0;

document.querySelectorAll('input, select, textarea').forEach(function(input) {
    input.addEventListener('change', function() {
        answeredQuestions = document.querySelectorAll('input:checked, select:valid, textarea:not(:empty)').length;
        let progress = (answeredQuestions / totalQuestions) * 100;
        document.getElementById('progress-bar').style.width = progress + '%';
    });
});

// Submit Spinner Display
document.getElementById('submit-btn').addEventListener('click', function() {
    document.getElementById('submit-spinner').style.display = 'inline-block';
});
</script>
@endsection
