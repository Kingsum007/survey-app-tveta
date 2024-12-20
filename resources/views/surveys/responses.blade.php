@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Survey Responses</h3>
         
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="dt-buttons btn-group flex-wrap">
                            <div class="btn-group"></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div id="example1_filter" class="dataTables_filter">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table id="example1" class="table table-bordered table-striped dataTable dtr-inline"
                        aria-describedby="example1_info">
                <thead>
                    <tr>
                        <th>Response ID</th>
                        @foreach ($survey->questions as $question)
                            <th>{{ $question->question_text }}</th>
                        @endforeach
                        <th>Submitted At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($responses as $response)
                    @php
                        $answers = is_array($response->answers) ? $response->answers : json_decode($response->answers, true);
                    @endphp
                    <tr>
                        <td>{{ $response->id }}</td>
                        @foreach ($survey->questions as $question)
                            <td>
                                @php
                                    $answer = $answers[$question->id] ?? 'N/A';
                                @endphp
                                @if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $answer))
                                    <img src="{{ asset($answer) }}" alt="Image" style="max-width: 100px; max-height: 100px;">
                                @elseif (preg_match('/\.(pdf|docx|doc|xlsx|xls|pptx|ppt)$/i', $answer))
                                    <a href="{{ asset($answer) }}" target="_blank">Download {{ pathinfo($answer, PATHINFO_BASENAME) }}</a>
                                @else
                                    {{ $answer }}
                                @endif
                            </td>
                        @endforeach
                        <td>{{ $response->created_at }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-5">

            </div>
            <div class="col-sm-12 col-md-7">
                <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">

                </div>
            </div>
        </div>
    </div>
</div>
        <!-- /.card-body -->
    </div>
</div>
@endsection

