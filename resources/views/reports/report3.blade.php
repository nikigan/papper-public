@extends('layouts.app')

@section('page-title', __('Report 3'))
@section('page-heading', __('Report 3'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{route('clients.index')}}">@lang('Clients')</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{route('clients.show', $client)}}">{{ $client->present()->name ?? $client->email }}</a>
    </li>
    <li class="breadcrumb-item active">
        <a>@lang('Report 3')</a>
    </li>
@stop

@section('content')
    @include('partials.messages')
    <h1>@lang('Report 3')</h1>
    <div class="card">
        <div class="card-body">
            <div class="col-md-6">
                <form action="" method="GET" class="mb-0" id="search-form">

                    <div class="form-row align-items-center">
                        <div class="col">
                            <div class="form-group">
                                <label for="startDate">@lang('From'):</label>
                                <input type="date" name="start_date" class="form-control datechk" id="startDate"
                                       value="{{Request::get('start_date') ?? date('Y-m-d', strtotime(date('Y-m-d') . "-{$client->report_period} month"))}}">
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

    @if (count($groups))
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless table-striped">
                        <thead>
                        <tr>
                            <th>@lang('Name')</th>
                            <th>@lang('Sum')</th>
                            <th>@lang('%')</th>
                        </tr>
                        </thead>
                        <tbody class="text-success">
                        @foreach ($groups as $name => $group)
                            <tr style="font-weight: bold">
                                <td>{{$name != "" && $name != null ? $name : 'Other Income Group'}}</td>
                                <td>{{number_format($group['sum'], 2) ?? 'N/A'}}</td>
                                <td>100%</td>
                            </tr>
                            @foreach($group['subgroups'] as $n => $subgroup)
                                @if($n != "Other")
                                    <tr>
                                        <td>{{$n ?? 'Other'}}</td>
                                        <td>{{number_format($subgroup['sum'], 2)}}</td>
                                        <td>{{number_format($subgroup['percentage'], 2)}}%</td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    @if (count($expense_groups))
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless table-striped">
                        <thead>
                        <tr>
                            <th>@lang('Name')</th>
                            <th>@lang('Sum')</th>
                            <th>@lang('%')</th>
                        </tr>
                        </thead>
                        <tbody class="text-danger">
                        @foreach ($expense_groups as $name => $group)
                            <tr style="font-weight: bold">
                                <td>{{$name != "" && $name != null ? $name : __('Other Expense Group')}}</td>
                                <td>{{number_format($group['sum'], 2) ?? 'N/A'}}</td>
                                <td>100%</td>
                            </tr>
                            @foreach($group as $n => $subgroup)
                                @if($n == 'sum' || !$n)
                                    @continue
                                @endif
                                <tr>
                                    <td>{{$n != "" && $n != null ? $n :'Other'}}</td>
                                    <td>{{number_format($subgroup[0]['sum'], 2)}}</td>
                                    <td>{{number_format($subgroup[0]['percentage'], 2)}}%</td>
                                </tr>
                            @endforeach
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection
