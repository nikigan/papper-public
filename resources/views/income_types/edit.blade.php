@extends('layouts.app')

@section('page-title', __('Edit Income Type'))
@section('page-heading', __('Edit Income Type'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('income_types.index') }}">@lang('Income Types')</a>
    </li>
    <li class="breadcrumb-item active">
        <a>@lang($incomeType->name)</a>
    </li>
@stop

@section('content')

    @include('partials.messages')

    <form action="{{route('income_types.update', $incomeType)}}" method="POST">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">@lang('Type Name')</label>
                            <input type="text" class="form-control input-solid" id="name"
                                   name="name" placeholder="@lang('Type Name')" required value="{{ $incomeType->name }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="group">@lang('Group')</label>
                            <select class="form-control" name="income_group_id" id="group">
                                <option value="">@lang('Other')</option>
                                @foreach($income_groups as $group)
                                    <option value="{{$group->id}}" @if($group->id == $incomeType->income_group_id) selected @endif>@lang($group->name)</option>
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
                    @lang('Edit Income Type')
                </button>
            </div>
        </div>
    </form>

    <br>
@stop
