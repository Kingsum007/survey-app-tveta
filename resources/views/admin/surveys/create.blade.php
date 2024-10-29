@extends('admin.layouts.admin')
@section('content')
<h1>Create Survey</h1>
<form action="{{ route('surveys.store') }}" method="POST" id="survey-form">
    @csrf
    <input type="text" class="form-control" name="title" placeholder="Survey Title" required>
    <textarea class="form-control" id="details" name="description" placeholder="Description"></textarea>

    <div id="questions-container">
        <h3>Questions</h3>
        <ul id="sortable">
            <!-- Questions will be added here -->
        </ul>
    </div>

    <button type="button" id="add-question">Add Question</button>
    <button type="submit">Create Survey</button>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sortable = new Sortable(document.getElementById('sortable'), {
            animation: 150,
            ghostClass: 'blue-background-class'
        });

        document.getElementById('add-question').addEventListener('click', function() {
            const questionHtml = `
                <li>
                    <input type="text" class="form-control" name="questions[][question_text]" placeholder="Question" required>
                    <select name="questions[][question_type]" class="form-control">
                        <option value="text">Text</option>
                        <option value="multiple_choice">Multiple Choice</option>
                    </select>
                    <div class="options-container">
                        <input type="text" class="form-control" name="questions[][options][]" placeholder="Option (optional)">
                    </div>
                    <button type="button" class="add-option">Add Option</button>
                    <button type="button" class="remove-question">Remove</button>
                </li>
            `;
            document.getElementById('sortable').insertAdjacentHTML('beforeend', questionHtml);
        });

        document.getElementById('sortable').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-question')) {
                e.target.closest('li').remove();
            }
            if (e.target.classList.contains('add-option')) {
                const optionsContainer = e.target.previousElementSibling;
                optionsContainer.insertAdjacentHTML('beforeend', '<input type="text" name="questions[][options][]" placeholder="Option (optional)">');
            }
        });
    });
</script>
@endsection