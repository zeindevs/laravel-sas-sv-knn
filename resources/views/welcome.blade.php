@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card bg-white">
                <div class="card-header">
                    <h3 class="fs-4 mb-0">{{ __('Submission') }}</h3>
                </div>
                <form class="card-body bg-white" action="{{ route('predict') }}" method="post">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="name" class="form-label">{{ __('Your Name') }}</label>
                        <input type="text" class="form-control" name="name" placeholder="John Doe" required>
                    </div>
                    <p>{{ __('Questions:') }}</p>
                    <div class="overflow-auto">
                        <table class="table table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th style="width: 1%;">#</th>
                                    <th>Question</th>
                                    @foreach ($answers as $answer)
                                        <th class="text-nowrap">{{ $answer['name'] }} ({{ $answer['weight'] }})</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($questions as $key => $question)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $question['name'] }}</td>
                                         @foreach ($answers as $answer)
                                            <td class="text-center">
                                                <input type="text" class="form-control" name="questions[{{$key}}][id]" value="{{ $question['id'] }}" hidden />
                                                <input type="radio" name="questions[{{$key}}][answer]" value="{{ $answer['id'] }}" required />
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                    </div>
                </form>
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
