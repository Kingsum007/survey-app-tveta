@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Survey Statistics for "{{ $survey->title }}"</h1>

    @forelse ($statistics as $questionId => $stat)
        <div class="mb-4">
            <h4>Question {{ $stat['question_text'] }}</h4>
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

<div class="charts-container">
    @foreach ($statistics as $data)
        <div class="chart-block">
            <h3>{{ $data['question_text'] }}</h3>
            <canvas class="chart" id="chart-{{ $data['question_text'] }}"></canvas>
        </div>
    @endforeach
</div>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Register chartjs-plugin-datalabels plugin explicitly
        Chart.register(ChartDataLabels);

        @foreach ($statistics as $questionId => $data)
            const ctx{{ $questionId }} = document.getElementById('chart-{{ $data['question_text'] }}').getContext('2d');
            const colors{{ $questionId }} = {
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)', // Red
                    'rgba(54, 162, 235, 0.2)', // Blue
                    'rgba(255, 206, 86, 0.2)', // Yellow
                    'rgba(75, 192, 192, 0.2)', // Green
                    'rgba(153, 102, 255, 0.2)', // Purple
                    'rgba(255, 159, 64, 0.2)', // Orange
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                ],
            };

            const chartData{{ $questionId }} = {
                labels: {!! json_encode(array_keys($data['counts'])) !!},
                datasets: [{
                    label: 'Responses',
                    data: {!! json_encode(array_values($data['counts'])) !!},
                    backgroundColor: colors{{ $questionId }}.backgroundColor.slice(0, {!! json_encode(count($data['counts'])) !!}),
                    borderColor: colors{{ $questionId }}.borderColor.slice(0, {!! json_encode(count($data['counts'])) !!}),
                    borderWidth: 1
                }]
            };

            new Chart(ctx{{ $questionId }}, {
                type: 'pie',
                data: chartData{{ $questionId }},
                options: {
                    responsive: true,
                    plugins: {
                        datalabels: {
                            formatter: (value, context) => {
                                let total = context.dataset.data.reduce((acc, val) => acc + val, 0);
                                let percentage = ((value / total) * 100).toFixed(2) + '%';
                                return percentage;
                            },
                            color: '#fff',
                            font: {
                                weight: 'bold',
                                size: 14
                            },
                            // Adjusting the positioning of labels
                            anchor: 'center',
                            align: 'center',
                        }
                    },
                    // Ensure the chart has a fixed size
                    aspectRatio: 1,  // Keeps the chart a square
                    maintainAspectRatio: false,  // Allows it to be resized based on container
                }
            });
        @endforeach
    });
</script>

<!-- Custom CSS to control the chart size -->
<style>
    .chart-block {
        width: 100%;
        max-width: 500px;  /* Set a max width for each chart */
        height: 600px;  /* Fixed height */
        margin: 0 auto 20px;
    }

    .chart {
        width: 100% !important;
        height: 100% !important;
    }
</style>

@endsection
