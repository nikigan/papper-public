@extends('layouts.app')

@section('page-title', __('Edit Income Group'))
@section('page-heading', __('Edit Income Group'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('income_groups.index') }}">@lang('Income Groups')</a>
    </li>
    <li class="breadcrumb-item active">
        <a>@lang($incomeGroup->name)</a>
    </li>
@stop

@section('content')

    @include('partials.messages')

    <form action="{{route('income_groups.update', $incomeGroup)}}" method="POST">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">@lang('Group Name')</label>
                            <input group="text" class="form-control input-solid" id="name"
                                   name="name" placeholder="@lang('Group Name')" required value="{{ $incomeGroup->name }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <button group="submit" class="btn btn-primary">
                    @lang('Edit Income Group')
                </button>
            </div>
        </div>
    </form>

    <br>
@stop
