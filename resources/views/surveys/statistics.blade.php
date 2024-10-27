@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Survey Statistics for "{{ $survey->title }}"</h1>

    @forelse ($statistics as $questionId => $stat)
        <div class="mb-4">
            <h4>Question {{ $questionId }}</h4>
            <p>Total Responses: {{ $stat['total'] }}</p>
            <ul>
                @forelse ($stat['counts'] as $answer => $count)
                    <li>
                        {{ $answer }}: {{ $count }} ({{ number_format(($count / $stat['total']) * 100, 2) }}%)
                    </li>
                    @empty
                    <li></li>
                @endforelse
            </ul>
        </div>
        @empty
            <li>There is no Data</li>
    @endforelse
   
</div>
@endsection
