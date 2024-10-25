@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Welcome to Technical and Vocational Education and Training Authority Survey App</h3>
    <p>Create and manage surveys easily!</p>
    <a href="{{ route('surveys.create') }}" class="btn btn-primary">Create a Survey</a>
</div>
@endsection
