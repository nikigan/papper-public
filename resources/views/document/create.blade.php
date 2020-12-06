@extends('layouts.app')

@section('page-title', __('Add Document'))
@section('page-heading', __('Create New Document'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('documents.index') }}">@lang('Documents')</a>
    </li>
    <li class="breadcrumb-item active">
        <a>@lang('Create Document')</a>
    </li>
@stop

@section('content')

    @include('partials.messages')

    {!! Form::open(['route' => 'document.manualStore', 'files' => true, 'id' => 'document-form']) !!}
    <div class="card">
        <div class="card-body">
            <div class="form-row align-items-center">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="document_number">@lang('Document number')</label>
                        <input type="text" class="form-control" name="document_number" id="document_number" required value="{{old('document_number')}}">
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="sum">@lang('Total sum')</label>
                        <input type="text" class="form-control" name="sum" id="sum" required value="{{old('sum')}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="vat">@lang('VAT')</label>
                        <input type="text" class="form-control" name="vat" id="vat" required value="{{old('vat')}}">
                    </div>
                </div>
            </div>
            <div class="my-3">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="document_type_0" name="document_type" class="custom-control-input"
                           value="0" checked>
                    <label class="custom-control-label" for="document_type_0">@lang('Expense')</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="document_type_1" name="document_type" class="custom-control-input"
                           value="1">
                    <label class="custom-control-label" for="document_type_1">@lang('Income')</label>
                </div>
            </div>
            <div class="form-group">
                <label for="file">Upload file</label>
                <input type="file" accept="image/png, image/jpeg, .pdf" name="file" id="file" class="form-control-file">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">
                @lang('Create Document')
            </button>
        </div>
    </div>
    {!! Form::close() !!}

    <br>
@stop
