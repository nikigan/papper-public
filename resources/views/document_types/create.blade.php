@extends('layouts.app')

@section('page-title', __('Add Document Type'))
@section('page-heading', __('Add Document Type'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('document_types.index') }}">@lang('Document Types')</a>
    </li>
    <li class="breadcrumb-item active">
        <a>@lang('Add Document Type')</a>
    </li>
@stop

@section('content')

    @include('partials.messages')

    {!! Form::open(['route' => 'document_types.store']) !!}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">@lang('Type Name')</label>
                        <input type="text" class="form-control input-solid" id="name"
                               name="name" placeholder="@lang('Type Name')" required value="{{ old('name') }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phone">@lang('Type Prefix')</label>
                        <input type="text" class="form-control input-solid" id="prefix"
                               name="prefix" placeholder="@lang('Type Prefix')" required value="{{ old('prefix') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">
                @lang('Add Document Type')
            </button>
        </div>
    </div>
    {!! Form::close() !!}

    <br>
@stop
