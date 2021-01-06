@extends('layouts.app')

@section('page-title', 'Uploaded documents')
@section('page-heading', 'Uploaded documents')

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        <a href="{{ Route::current()->uri() }}">@lang('Documents')</a>
    </li>
@stop

@section('content')
    @include('partials.messages')

    <div class="card">
        <div class="card-body">
            <form action="" method="GET" class="mb-0" id="search-form">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="input-group custom-search-form">
                            <input type="text"
                                   class="form-control input-solid"
                                   id="search"
                                   name="query"
                                   value="{{ Request::get('query') }}"
                                   placeholder="@lang('Search...')">

                            <span class="input-group-append">
                                @if (Request::has('query') && Request::get('query') != '')
                                    <a href="{{ url()->current()}}"
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
                                <div class="form-group mb-4">
                                    <label for="startDate">@lang('From'):</label>
                                    <input type="date" name="start_date" class="form-control datechk" id="startDate" value="{{Request::get('start_date') ?? date('Y-m-d', strtotime(date('Y-m-d') . "-1 year"))}}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mb-4">
                                    <label for="endDate">@lang('To'):</label>
                                    <input type="date" name="end_date" class="form-control datechk" id="endDate" value="{{ Request::get('end_date') ?? date('Y-m-d') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <h1>@lang('List of uploaded documents')</h1>
    <div class="card">
        <div class="card-body">
            <div class="row my-3 flex-md-row flex-column-reverse">
                <div class="col-md-4 mt-md-0 mt-2">
                    {{--<div class="input-group custom-search-form">
                        <input type="text"
                               class="form-control input-solid"
                               name="search"
                               value="{{ Request::get('search') }}"
                               placeholder="@lang('Search for documents...')">

                        <span class="input-group-append">
                                        @if (Request::has('search') && Request::get('search') != '')
                                <a href="{{ route('users.index') }}"
                                   class="btn btn-light d-flex align-items-center text-muted"
                                   role="button">
                                                <i class="fas fa-times"></i>
                                            </a>
                            @endif
                                        <button class="btn btn-light" type="submit" id="search-users-btn">
                                            <i class="fas fa-search text-muted"></i>
                                        </button>
                                    </span>
                    </div>--}}
                </div>

                <div class="col-md-2 mt-2 mt-md-0">
                    {{--{!!
                        Form::select(
                            'status',
                            $statuses,
                            Request::get('status'),
                            ['id' => 'status', 'class' => 'form-control input-solid']
                        )
                    !!}--}}
                </div>

                <div class="col-md-6 col-12">
                    @if(auth()->user()->hasPermission('document.upload'))
                        <a href="{{ route('documents.upload') }}" class="btn btn-primary btn-rounded action-btn mb-sm-2">
                            <i class="fas fa-plus mr-2"></i>
                            @lang('Upload Document')
                        </a>
                        <a href="{{ route('document.create') }}" class="btn btn-primary btn-rounded action-btn mr-lg-2">
                            <i class="fas fa-plus mr-2"></i>
                            @lang('Create Document')
                        </a>
                    @endif
                </div>
            </div>
            @include('document.partials.table')
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        $('input[type=\'date\']').change(function () {
            $('#search-form').submit();
        });
    </script>
@stop
