@extends('layouts.app') 

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card bg-white">
                <div class="card-header">
                    <h4 class="mb-0">{{ __('Submission') }}</h4>
                </div>

                <div class="card-body bg-white">
                    <div class="overflow-x-auto">
                        <table class="table table-bordered table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th style="width: 1%">ID</th>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Result</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($submissions as $item)
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

                    <div class="d-flex justify-content-end">
                        {{ $submissions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
