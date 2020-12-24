@extends('layouts.app')

@section('page-title', 'Search')
@section('page-heading', 'Search')

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        <a>@lang('Search')</a>
    </li>
@stop

@section('content')
    @include('partials.messages')

    <div class="card">
        <div class="card-body">
            <form action="" method="GET" id="users-form" class="pb-2">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group custom-search-form">
                            <input type="text"
                                   class="form-control input-solid"
                                   name="query"
                                   value="{{ Request::get('query') }}"
                                   placeholder="@lang('Search...')">

                            <span class="input-group-append">
                                @if (Request::has('query') && Request::get('query') != '')
                                    <a href="{{ route('search.index') }}"
                                       class="btn btn-light d-flex align-items-center text-muted"
                                       role="button">
                                                            <i class="fas fa-times"></i>
                                                        </a>
                                @endif
                                <button class="btn btn-light" type="submit" id="search-users-btn">
                                    <i class="fas fa-search text-muted"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="startDate">@lang('From'):</label>
                                    <input type="date" name="start_date" class="form-control" id="startDate" value="{{Request::get('start_date') ?? date('Y-m-d', strtotime(date('Y-m-d') . "-1 year"))}}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="endDate">@lang('To'):</label>
                                    <input type="date" name="end_date" class="form-control" id="endDate" value="{{ Request::get('end_date') ?? date('Y-m-d') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
