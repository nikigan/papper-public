@extends('layouts.main')

@section('page-title', 'Invoices')
@section('page-heading', 'Invoices')

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        <a>@lang('Invoices')</a>
    </li>
@stop

@section('content')
    @include('partials.messages')
    <h1>@lang('List of created invoices')</h1>

    <div class="card">
        <div class="card-body">
            <div class="row my-3 flex-md-row flex-column-reverse">
                <div class="col-md-4 mt-md-0 mt-2">
                </div>

                <div class="col-md-2 mt-2 mt-md-0">
                </div>

                <div class="col-md-6">
                    <a href="{{ route('invoice.create') }}" class="btn btn-primary btn-rounded action-btn mr-2">
                        <i class="fas fa-plus mr-2"></i>
                        @lang('Create Invoice')
                    </a>
                </div>
            </div>
            @include('invoices.partials.table')
        </div>
    </div>
@endsection
