@extends('layouts.app')

@section('page-title', __('Add Organization Type'))
@section('page-heading', __('Add Organization Type'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('organization_types.index') }}">@lang('Organization Types')</a>
    </li>
    <li class="breadcrumb-item active">
        <a>@lang('Add Organization Type')</a>
    </li>
@stop

@section('content')

    @include('partials.messages')

    {!! Form::open(['route' => 'organization_types.store']) !!}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">@lang('Type Name')</label>
                        <input type="text" class="form-control input-solid" id="name"
                               name="name" placeholder="@lang('Type Name')" required value="{{old('name')}}">
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="have_tax"
                               name="have_tax" value="1" checked>
                        <label for="have_tax" class="custom-control-label">@lang('Have to pay taxes')</label>
                    </div>
                </div>
                <div class="col-md-6">
                    @foreach($document_types as $type)
                        <div class="custom-control custom-checkbox">
                            <input id="type[{{$type->id}}]" name="document_types[{{$type->id}}]" type="checkbox" class="custom-control-input">
                            <label class="custom-control-label" for="type[{{$type->id}}]">@lang($type->name)</label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">
                @lang('Add Organization Type')
            </button>
        </div>
    </div>
    {!! Form::close() !!}

    <br>
@stop
