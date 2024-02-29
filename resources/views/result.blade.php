@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card bg-white">
                <div class="card-header">
                    <h4 class="mb-0">{{ __('Result') }}</h4>
                </div>
                <div class="card-body bg-white text-center p-5">
                    <h4 class="card-title">
                        {{ __('Thank you') }} {{ $submission['name'] }} {{
                        __('for submitting') }}
                    </h4>
                    <p class="card-subtitle">{{ __('You are:') }}</p>
                    <h2>{{ $submission['prediction'] }}</h2>

                    <div class="mt-3">
                        <a href="{{ url('/') }}" class="btn btn-primary"
                            >Test Again</a
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
