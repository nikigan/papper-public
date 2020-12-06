@extends('layouts.app')

@section('page-title', __('Clients documents'))
@section('page-heading', __('Clients'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('clients.index') }}">@lang('Clients')</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('clients.show', $user) }}">
            {{ $user->present()->nameOrEmail }}
        </a>
    </li>
    <li class="breadcrumb-item active">
        <a>
            {{ $month }}/{{ $year }}
        </a>
    </li>
@stop

@section('content')
    @include('partials.messages')
    <h4>@lang('Documents')</h4>
    <div class="card">
        <div class="card-body">
            @include('document.partials.table')
            {{--<div class="table-responsive" id="users-table-wrapper">
                <div class="table-responsive" id="users-table-wrapper">
                    <table class="table table-borderless table-striped">
                        <thead>
                        <tr>
                            <th class="min-width-80">@lang('Document id')</th>
                            <th class="min-width-100">@lang('Username')</th>
                            <th class="min-width-80">@lang('Upload date')</th>
                            <th class="min-width-80">@lang('Status')</th>
                            <th class="min-width-100">@lang('Sum')</th>
                            <th class="min-width-100">@lang('VAT')</th>
                            <th class="text-center min-width-100">@lang('Action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count($documents))
                            @foreach ($documents as $document)
                                @include('document.partials.row')
                            @endforeach
                            @isset($sum_class)
                                <tr>
                                    <td colspan="4"></td>
                                    <td><strong class="{{$sum_class}}">@money($sum)</strong></td>
                                    <td><strong class="{{$sum_class}}">@money($vat)</strong></td>
                                    <td></td>
                                </tr>
                            @endisset
                        @else
                            <tr>
                                <td colspan="7"><em>@lang('No records found.')</em></td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>

            </div>--}}
        </div>
    </div>
@endsection
