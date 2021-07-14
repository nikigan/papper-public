@extends('layouts.main')

@section('page-title', __('Trash'))
@section('page-heading', __('Trash'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        <a>@lang('Trash')</a>
    </li>
@stop

@section('content')
    @include('partials.messages')
    <h2>@lang('Trash')</h2>
    <div class="card">
        <div class="card-body">
            @include('document.partials.table')
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            @include('invoices.partials.table ')
        </div>
    </div>
@endsection
