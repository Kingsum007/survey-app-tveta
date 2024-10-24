@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Survey Statistics for "{{ $survey->title }}"</h1>

    @foreach ($statistics as $questionId => $stat)
        <div class="mb-4">
            <h4>Question {{ $questionId }}</h4>
            <p>Total Responses: {{ $stat['total'] }}</p>
            <ul>
                @foreach ($stat['counts'] as $answer => $count)
                    <li>
                        {{ $answer }}: {{ $count }} ({{ number_format(($count / $stat['total']) * 100, 2) }}%)
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach
    <canvas id="questionChart"></canvas>
<script>
    const ctx = document.getElementById('questionChart').getContext('2d');
    const chartData = {
        labels: @json(array_keys($statistics[$questionId]['counts'])),
        datasets: [{
            label: 'Responses',
            data: @json(array_values($statistics[$questionId]['counts'])),
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    };

    const myChart = new Chart(ctx, {
        type: 'bar',
        data: chartData,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

</div>
@endsection
