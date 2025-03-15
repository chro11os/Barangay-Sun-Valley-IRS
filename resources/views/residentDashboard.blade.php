<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body class="bg-cover bg-center bg-fixed pt-16" style="background-image: url('/img/background.png');">
    @extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Resident Reports Dashboard</h1>
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Submitted Reports</h4>
        </div>
        <div class="card-body">
            @if($reports->isEmpty())
                <p class="text-center">No reports have been submitted yet.</p>
            @else
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Report Title</th>
                            <th>Date Submitted</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $index => $report)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $report->title }}</td>
                                <td>{{ $report->created_at->format('F d, Y') }}</td>
                                <td>{{ ucfirst($report->status) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
</body>
</html>