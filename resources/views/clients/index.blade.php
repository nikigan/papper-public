@extends('layouts.main')

@section('page-title', __('Clients'))
@section('page-heading', __('Clients'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        <a>@lang('Clients')</a>
    </li>
@stop

@section('content')
    @include('partials.messages')
    <h2>@lang('Your clients')</h2>
    <div class="card">
        <div class="card-body">
            <div class="row my-3 flex-md-row flex-column-reverse">
                <div class="col-md-4 mt-md-0 mt-2">
                </div>
                <div class="col-md-2 mt-2 mt-md-0">
                </div>
                <div class="col-md-6">
                    @permission('clients.manage')
                        <a href="{{ route('clients.create') }}" class="btn btn-primary btn-rounded float-left">
                            <i class="fas fa-plus mr-2"></i>
                            @lang('Create Client')
                        </a>
                    @endpermission
                </div>
            </div>
            @include('clients.partials.table')
        </div>
    </div>
@endsection
