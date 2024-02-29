@extends('layouts.app') 

@section('content')
<div class="container">
    <div class="row justify-content-center gap-3">
        <div class="col-md-12">
            <div class="d-flex gap-3">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Total Dataset</h4>
                            <span class="fw-medium fs-1">{{ $total_dataset }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Total Submitted</h4>
                            <span class="fw-medium fs-1">{{ $total_submited }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card bg-white">
                <div class="card-header">
                    <h4 class="mb-0">{{ __('Last Submitted') }}</h4>
                </div>

                <div class="card-body bg-white">
                    <table
                        class="table table-bordered table-striped table-responsive"
                    >
                        <thead>
                            <tr>
                                <th style="width: 1%">ID</th>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Result</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($submited as $item)
                            <tr>
                                <td>{{ $item['id'] }}</td>
                                <td class="text-nowrap">
                                    {{ $item['created_at'] }}
                                </td>
                                <td>{{ $item['name'] }}</td>
                                <td>
                                    @if($item['prediction'] == 'Addiction')
                                    <span>{{ $item['prediction'] }}</span>
                                    @else
                                    <span>{{ $item['prediction'] }}</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
