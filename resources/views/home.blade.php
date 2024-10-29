@extends('layouts.app')

@section('content')
<div class="container">
    <h3>{{__('message.welcome')}}</h3>
    <p>{{__('message.information')}}</p>
    <a href="{{ route('surveys.create') }}" class="btn btn-primary">{{__('message.create')}}</a>
</div>
@endsection
