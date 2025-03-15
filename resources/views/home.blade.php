@extends('layouts.app')

@section('content')
<div class ="background-image back">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                        <a href="{{ route('home') }}" class="btn bg-blue-500 text-white px-4 py-2 rounded">Return</a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
