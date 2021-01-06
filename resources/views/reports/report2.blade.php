@extends('layouts.app')

@section('page-title', __('Report') . '2')
@section('page-heading', __('Report') . '2')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{route('clients.index')}}">@lang('Clients')</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{route('clients.show', $client)}}">{{ $client->present()->name ?? $client->email }}</a>
    </li>
    <li class="breadcrumb-item active">
        <a>@lang('Report') 2</a>
    </li>
@stop

@section('content')
    @include('partials.messages')
    <h1>@lang('Report') 2</h1>
    <div class="card">
        <div class="card-body">
            <div class="col-md-6">
                <form action="" method="GET" class="mb-0" id="search-form">

                    <div class="form-row align-items-center">
                        <div class="col">
                            <div class="form-group">
                                <label for="startDate">@lang('From'):</label>
                                <input type="date" name="start_date" class="form-control datechk" id="startDate"
                                       value="{{Request::get('start_date') ?? date('Y-m-d', strtotime(date('Y-m-d') . "-1 month"))}}">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="endDate">@lang('To'):</label>
                                <input type="date" name="end_date" class="form-control datechk" id="endDate"
                                       value="{{ Request::get('end_date') ?? date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="col">
                            <button class="btn btn-primary" type="submit">{{ __('Make report')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if (count($expense_groups))
        @foreach($expense_groups as $name => $group)
            <h2>@lang($name != "" ? $name : "Other") <small>({{count($group)}})</small></h2>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless table-striped">
                            <thead>
                            <tr>
                                <th>@lang('#')</th>
                                <th>@lang('Date')</th>
{{--                                <th>@lang('Type')</th>--}}
                                <th>@lang('Sum')</th>
                                <th>@lang('VAT')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($group as $item)
                                <tr class="text-danger">
                                    <td><a class="text-danger"
                                           href="{{ route('documents.show', $item) }}">{{ $item->document_number }}</a></td>
                                    <td>{{ $item->document_date }}</td>
{{--                                    <td>{{ $item->expense_type->name ?? 'Other' }}</td>--}}
                                    <td>{{ number_format($item->sum, 2) }}</td>
                                    <td>{{number_format($item->vat, 2)}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach

    @endif

@endsection
