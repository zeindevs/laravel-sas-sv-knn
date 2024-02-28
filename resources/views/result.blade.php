@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card bg-white">
                <div class="card-header">
                    <h3 class="fs-4 mb-0">{{ __('Result') }}</h3>
                </div>
                <div class="card-body text-center">
                    <h4>{{ __('Thank you') }} {{ $submission['name'] }} {{ __('for submitting') }}</h4>
                    <p>{{ __('You are:') }}</p>
                    <h2>{{ $submission['prediction'] }}</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<footer class="container p-3">
    <div class="text-center">
        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
    </div>
</footer>
@endsection
