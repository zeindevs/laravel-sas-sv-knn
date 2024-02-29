@extends('layouts.app') 

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card bg-white">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ __('Dataset') }}</h4>
                    <div class="button-group">
                        <button class="btn btn-sm btn-primary">Import</button>
                    </div>
                </div>

                <div class="card-body bg-white">
                    <div class="overflow-x-auto">
                        <table class="table table-bordered table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th style="width: 1%">ID</th>
                                    <th>Label</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datasets as $item)
                                <tr>
                                    <td>{{ $item['id'] }}</td>
                                    <td>{{ $item['prediction'] }}</td>
                                    <td class="text-nowrap">
                                        [
                                        @foreach ($item->items as $element)
                                            <span>{{ $element['weight'] }}</span>,
                                        @endforeach
                                        ]
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end">
                        {{ $datasets->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
