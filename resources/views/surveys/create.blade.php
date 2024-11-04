@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{__('message.create')}}</h1>
    <form action="{{ route('surveys.store') }}" method="POST">
        @csrf

        <!-- Survey Title -->
        <div class="form-group">
            <label for="title">{{__('message.survey_title')}}</label>
            <input type="text" class="form-control" name="title" id="title" placeholder="Enter Survey Title" required>
        </div>

        <!-- Survey Description -->
        <div class="form-group">
            <label for="description">{{__('message.survey_description')}}</label>
            <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter Survey Description"></textarea>
        </div>

        <div id="questions" class="mb-3">
            <div class="question mb-3">
                <label for="">{{__('message.question_text')}}</label>
                <input type="text" class="form-control" name="questions[0][question_text]" placeholder="Question Text" required>
                <label>{{__('message.question_type')}}</label>
                <select class="form-control" name="questions[0][question_type]">
                    <option value="text">{{__('message.text_type')}}</option>
                    <option value="multiple_choice">{{__('message.multi_choice_type')}}</option>
                    <option value="checkbox">{{__('message.check_type')}}</option>
                    <option value="dropdown">{{__('message.dropdown_type')}}</option>
                    <option value="file">{{__('message.file_type')}}</option>
                </select>
                {{__('message.question_options')}}
                <input type="text" class="form-control" name="questions[0][options]" placeholder="Options (comma separated)">
                <button type="button" class="btn btn-danger remove-question mt-2">Remove</button>
            </div>
        </div>

        <button type="button" class="btn btn-primary" id="add-question">Add Question</button>
        <button type="submit" class="btn btn-success">Create Survey</button>
    </form>

    <script>
        let questionIndex = 1;

        document.getElementById('add-question').onclick = function() {
            const questionDiv = document.createElement('div');
            questionDiv.classList.add('question', 'mb-3');
            questionDiv.innerHTML = `
            <label>{{__('message.question_text')}}</label>
                <input type="text" class="form-control" name="questions[${questionIndex}][question_text]" placeholder="Question Text" required>
                <label>{{__('message.question_type')}}</label>
                <select class="form-control" name="questions[${questionIndex}][question_type]">
                     <option value="text">{{__('message.text_type')}}</option>
                    <option value="multiple_choice">{{__('message.multi_choice_type')}}</option>
                    <option value="checkbox">{{__('message.check_type')}}</option>
                    <option value="dropdown">{{__('message.dropdown_type')}}</option>
                    <option value="file">{{__('message.file_type')}}</option>
                </select>
                <label>{{__('message.question_options')}}</label>
                <input type="text" class="form-control" name="questions[${questionIndex}][options]" placeholder="Options (comma separated)">
                <button type="button" class="btn btn-danger remove-question mt-2">Remove</button>
            `;
            document.getElementById('questions').appendChild(questionDiv);
            questionIndex++;
        };

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-question')) {
                e.target.parentElement.remove();
            }
        });
    </script>
</div>
@endsection
