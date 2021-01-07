@extends('layouts.app')

@section('page-title', __('Add Income Type'))
@section('page-heading', __('Add Income Type'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('income_types.index') }}">@lang('Income Types')</a>
    </li>
    <li class="breadcrumb-item active">
        <a>@lang('Add Income Type')</a>
    </li>
@stop

@section('content')

    @include('partials.messages')

    {!! Form::open(['route' => 'income_types.store']) !!}
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
                        <label for="group">@lang('Group')</label>
                        <select class="form-control" name="income_group_id" id="group">
                            <option value="">@lang('Other')</option>
                            @foreach($income_groups as $group)
                                <option value="{{$group->id}}">@lang($group->name)</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">
                @lang('Add Income Type')
            </button>
        </div>
    </div>
    {!! Form::close() !!}

    <br>
@stop
