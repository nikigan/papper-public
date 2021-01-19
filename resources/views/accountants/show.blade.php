@extends('layouts.main')

@section('page-title', __('Users'))
@section('page-heading', __('Users'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('accountants.index') }}">@lang('Accountants')</a>
    </li>
    <li class="breadcrumb-item active">
        <a>
            {{ $accountant->present()->nameOrEmail }}
        </a>
    </li>
@stop

@section('content')
    @include('partials.messages')
    <div class="card">
        <div class="card-body">
            <h2>{{ $accountant->present()->name }}</h2>
        </div>
    </div>


    <h4>@lang('Accountant clients')</h4>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive" id="users-table-wrapper">
                <table class="table table-borderless table-striped">
                    <thead>
                    <tr>
                        <th></th>
                        <th class="min-width-80">@lang('Username')</th>
                        <th class="min-width-150">@lang('Full Name')</th>
                        <th class="min-width-100">@lang('Email')</th>
                        <th class="min-width-80">@lang('Registration Date')</th>
                        <th class="min-width-80">@lang('Accountant')</th>
                        <th class="text-center min-width-150">@lang('Action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (count($clients))
                        @foreach ($clients as $user)
                            @include('clients.partials.row')
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7"><em>@lang('No records found.')</em></td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @if(count($clients_to_add))
        <h4>@lang('Add clients to accountant')</h4>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive" id="users-table-wrapper">
                    <table class="table table-borderless table-striped">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="min-width-80">@lang('Username')</th>
                            <th class="min-width-150">@lang('Full Name')</th>
                            <th class="min-width-100">@lang('Email')</th>
                            <th class="min-width-80">@lang('Registration Date')</th>
                            <th class="min-width-80">@lang('Accountant')</th>
                            <th class="text-center min-width-150">@lang('Action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count($clients_to_add))
                            @foreach ($clients_to_add as $user)
                                @include('clients.partials.row', ['add' => true])
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7"><em>@lang('No records found.')</em></td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection
