@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{__('message.your-surveys')}}</h1>
    <a href="{{ route('surveys.create') }}" class="btn btn-primary mb-3">{{__('message.create')}}</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>{{__('message.title')}}</th>
                <th>{{__('message.description')}}</th>
                <th>{{__('message.actions')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($surveys as $survey)
                <tr>
                    <td>{{ Str::limit($survey->title,30,'...') }}</td>
                    <td>{{ Str::limit($survey->description.'...',50,'...') }}</td>
                    <td>
                    <a href="{{ route('surveys.public', $survey->token) }}" class="btn btn-info">{{__('message.public_link')}} </a>    
                    <a href="{{ route('surveys.show', $survey) }}" class="btn btn-info">{{__('message.view')}}</a>

                     @if(auth()->id() == $survey->user_id)   <a href="{{ route('surveys.edit', $survey) }}" class="btn btn-warning">{{__('message.edit')}}</a> @else  @endif
                        <form action="{{ route('surveys.destroy', $survey) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            @if(auth()->id() == $survey->user_id)    <button type="submit" class="btn btn-danger">{{__('message.delete')}}</button>@else 
                             @endif
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
