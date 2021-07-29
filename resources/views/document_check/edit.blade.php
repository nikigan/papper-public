@extends('layouts.app')
@php($create = !isset($document_check))

@section('page-title', $create ? __("Create document check") : __('Edit Document Check'))
@section('page-heading', $create ? __("Create document check") : __('Edit Document Check'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('document_check.index') }}">@lang('Document Checks')</a>
    </li>
    <li class="breadcrumb-item active">
        <a>{{ $create ? __('Create document check') : __($document_check->name) }}</a>
    </li>
@stop

@section('content')

    @include('partials.messages')

    <form action="{{$create ? route('document_check.store') : route('document_check.update', $document_check)}}"
          method="POST">
        @csrf
        @unless($create)
            @method('PUT')
        @endif
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">@lang('Check Title')</label>
                            <input type="text" class="form-control input-solid" id="title"
                                   name="title" placeholder="@lang('Check Title')" required
                                   value="{{ $create ? old('title') : $document_check->title }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="text">@lang('Check Text')</label>
                            <textarea class="form-control input-solid" id="text"
                                      name="text" placeholder="@lang('Check Text')"
                                      rows="10"
                                      required>{{ $create ? old('text') : $document_check->text }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">
                    {{$create ? __("Create document check") : __("Edit Document Check")}}
                </button>
            </div>
        </div>
    </form>

    <br>
@stop
