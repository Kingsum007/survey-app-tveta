@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Admin Dashboard</h1>
    <p>Welcome to the admin panel.</p>
    <a href="{{ route('admin.exams.index') }}" class="btn btn-primary">Manage Exams</a>
    <a href="{{ route('admin.questions.index') }}" class="btn btn-primary">Manage Questions</a>
</div>
@endsection

