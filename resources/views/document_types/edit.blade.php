@extends('layouts.app')

@section('page-title', __('Edit Document Type'))
@section('page-heading', __('Edit Document Type'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('document_types.index') }}">@lang('Document Types')</a>
    </li>
    <li class="breadcrumb-item active">
        <a>@lang($documentType->name)</a>
    </li>
@stop

@section('content')

    @include('partials.messages')

    <form action="{{route('document_types.update', $documentType)}}" method="POST">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">@lang('Type Name')</label>
                            <input type="text" class="form-control input-solid" id="name"
                                   name="name" placeholder="@lang('Type Name')" required value="{{ $documentType->name }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone">@lang('Type Prefix')</label>
                            <input type="text" class="form-control input-solid" id="prefix"
                                   name="prefix" placeholder="@lang('Type Prefix')" required
                                   value="{{ $documentType->prefix }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">
                    @lang('Edit Document Type')
                </button>
            </div>
        </div>
    </form>

    <br>
@stop
