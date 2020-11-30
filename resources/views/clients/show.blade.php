@extends('layouts.app')

@section('page-title', __('Users'))
@section('page-heading', __('Users'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('clients.index') }}">@lang('Clients')</a>
    </li>
    <li class="breadcrumb-item active">
        <a>
            {{ $user->present()->nameOrEmail }}
        </a>
    </li>
@stop

@section('content')
    @include('partials.messages')
    <div class="card">
        <div class="card-body">
            <h2>{{ $user->present()->name }}</h2>
        </div>
    </div>


    <h4>@lang('Documents')</h4>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive" id="users-table-wrapper">
                @include('document.partials.table')
                {{--<table class="table table-borderless table-striped">
                    <thead>
                    <tr>
                        <th class="min-width-80">@lang('Document id')</th>
                        <th class="min-width-100">@lang('Username')</th>
                        <th class="min-width-80">@lang('Upload date')</th>
                        <th class="min-width-80">@lang('Status')</th>
                        <th class="min-width-100">@lang('Sum')</th>
                        <th class="text-center min-width-100">@lang('Action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (count($documents))
                        @foreach ($documents as $document)
                            @include('document.partials.row')
                        @endforeach
                        <tr>
                            <td colspan="4"></td>
                            <td><strong class="{{$sum_class}}">@money($sum)</strong></td>
                            <td></td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="7"><em>@lang('No records found.')</em></td>
                        </tr>
                    @endif
                    </tbody>
                </table>--}}
            </div>
        </div>
    </div>
@endsection
