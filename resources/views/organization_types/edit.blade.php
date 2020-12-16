@extends('layouts.app')

@section('page-title', __('Edit Organization Type'))
@section('page-heading', __('Edit Organization Type'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('organization_types.index') }}">@lang('Organization Types')</a>
    </li>
    <li class="breadcrumb-item active">
        <a>@lang($organizationType->name)</a>
    </li>
@stop

@section('content')

    @include('partials.messages')

    <form action="{{route('organization_types.update', $organizationType)}}" method="POST">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">@lang('Type Name')</label>
                            <input type="text" class="form-control input-solid" id="name"
                                   name="name" placeholder="@lang('Type Name')" required value="{{ $organizationType->name }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        @foreach($document_types as $type)
                            <div class="custom-control custom-checkbox">
                                <input id="type[{{$type->id}}]" name="document_types[{{$type->id}}]" type="checkbox" class="custom-control-input"
                                @if(in_array($type->id, $organizationDocuments)) checked @endif>
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
                    @lang('Edit Organization Type')
                </button>
            </div>
        </div>
    </form>

    <br>
@stop
