@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Welcome to Survey App</h1>
    <p>Create and manage surveys easily!</p>
    <a href="{{ route('surveys.create') }}" class="btn btn-primary">Create a Survey</a>
</div>
@endsection
