@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card bg-white">
                <div class="card-header">
                    <h4 class="mb-0">{{ __('Submission') }}</h4>
                </div>
                <form
                    class="card-body bg-white"
                    action="{{ route('result') }}"
                    method="post"
                >
                    @csrf

                    <div class="form-group mb-3">
                        <label for="name" class="form-label">{{ __('Your Name') }}</label>
                        <input
                            type="text"
                            class="form-control @error('name') is-invalid @enderror"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="John Doe"
                            autocomplete="email"
                            required
                        />

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <p>{{ __('Questions:') }}</p>
                    <div class="overflow-x-auto">
                        <table class="table table-bordered table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th style="width: 1%">#</th>
                                    <th>Question</th>
                                    @foreach ($answers as $answer)
                                    <th class="text-nowrap">
                                        ({{ $answer['weight'] }})
                                    </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($questions as $key => $question)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        <p class="mb-0">
                                            {{ $question['name'] }}
                                        </p>
                                        @error('questions.'. $key .'.answer')
                                        <span
                                            class="text-danger small"
                                            role="alert"
                                        >
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </td>
                                    @foreach ($answers as $answer)
                                    <td class="text-nowrap bg-light">
                                        <div class="form-check">
                                            <input
                                                type="text"
                                                class="form-control"
                                                name="questions[{{ $key }}][id]"
                                                value="{{ $question['id'] }}"
                                                hidden
                                            />
                                            <label
                                                for=""
                                                class="form-check-label"
                                                >{{ $answer['name'] }}</label
                                            >
                                            <input
                                                type="radio"
                                                class="form-check-input"
                                                name="questions[{{ $key }}][answer]"
                                                value="{{ $answer['id'] }}"
                                                required
                                            />
                                        </div>
                                    </td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Submit') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
