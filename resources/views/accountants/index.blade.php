@extends('layouts.app')

@section('page-title', 'Accountants')
@section('page-heading', 'Accountants')

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        <a>@lang('Accountants')</a>
    </li>
@stop

@section('content')
    @include('partials.messages')
    <h2>@lang('Your Accountants')</h2>
    <div class="card">
        <div class="card-body">
            <div class="row my-3 flex-md-row flex-column-reverse">
                <div class="col-md-4 mt-md-0 mt-2">
                </div>
                <div class="col-md-2 mt-2 mt-md-0">
                </div>
                <div class="col-md-6">
                    @permission('client.assign')
                        <a href="{{ route('accountants.create') }}" class="btn btn-primary btn-rounded float-right">
                            <i class="fas fa-plus mr-2"></i>
                            @lang('Create Accountant')
                        </a>
                    @endpermission
                </div>
            </div>
            <div class="table-responsive" id="users-table-wrapper">
                <table class="table table-borderless table-striped">
                    <thead>
                    <tr>
                        <th></th>
                        <th class="min-width-80">@lang('Username')</th>
                        <th class="min-width-150">@lang('Full Name')</th>
                        <th class="min-width-100">@lang('Email')</th>
                        <th class="min-width-80">@lang('Registration Date')</th>
                        <th class="text-center min-width-150">@lang('Action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (count($users))
                        @foreach ($users as $user)
                            @include('accountants.partials.row')
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
@endsection
