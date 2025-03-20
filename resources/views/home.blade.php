@extends('layouts.app')

@section('content')
<div class="background-image back" style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: #f3f4f6;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" style="background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); border-radius: 15px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <div class="card-header text-center" style="font-size: 1.5rem; font-weight: bold; color: #1f2937;">{{ __('Dashboard') }}</div>

                    <div class="card-body text-center">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        
                        <p style="font-size: 1.2rem; color: #4b5563;">{{ __('You are logged in!') }}</p>
                        <a href="{{ route('report') }}" class="btn" style="background-color: #3b82f6; color: white; padding: 10px 20px; border-radius: 8px; font-size: 1rem; text-decoration: none; margin-top: 20px; display: inline-block; transition: background-color 0.3s ease;">
                            Return
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
