@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Your Surveys</h1>
    <a href="{{ route('surveys.create') }}" class="btn btn-primary mb-3">Create New Survey</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($surveys as $survey)
                <tr>
                    <td>{{ $survey->title }}</td>
                    <td>{{ $survey->description }}</td>
                    <td>
                    <a href="{{ route('surveys.public', $survey->token) }}" class="btn btn-info">Public Link</a>    
                    <a href="{{ route('surveys.show', $survey) }}" class="btn btn-info">View</a>

                        <a href="{{ route('surveys.edit', $survey) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('surveys.destroy', $survey) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
