@extends('layouts.app')

@section('content')
<div class="container">
    <h3>{{__('message.welcome')}}</h3>
    
    @auth
    <p>{{__('message.information')}}</p>
    @if(auth()->user()->role=="Admin")
    <a href="{{ route('surveys.create') }}" class="btn btn-primary">{{__('message.create')}}</a> 
    @else
    <a class="btn btn-info" href="{{ route('survey-list') }}">{{ __('message.your-surveys') }}</a>
    @endif
    @endauth
    @guest
        <a class="btn btn-info" href="{{ route('survey-list') }}">{{ __('message.your-surveys') }}</a>
    @endguest
</div>
@endsection
