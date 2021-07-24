@extends('layouts.main')

@section('page-title', __('Documents'))
@section('page-heading', __('Uploaded documents'))

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
                                    <input name="start_date" class="form-control datepicker-here" id="startDate"
                                           data-language="en"
                                           data-min-view="months" data-view="months" data-date-format="dd-mm-yyyy"
                                           value="{{Request::get('start_date') ?? date(config('app.date_format'), strtotime(date(config('app.date_format')) . "-1 year"))}}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mb-4">
                                    <label for="endDate">@lang('To'):</label>
                                    <input name="end_date" class="form-control datepicker-here" id="endDate"
                                           data-language="en"
                                           data-min-view="months" data-view="months" data-date-format="dd-mm-yyyy"
                                           value="{{ Request::get('end_date') ?? date(config('app.date_format')) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <h2>@lang('List of uploaded documents')</h2>
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
                    @if(auth()->user()->hasRole('User'))
                        {{--<a href="{{ route('documents.upload') }}" class="btn btn-primary btn-rounded action-btn mb-sm-2">
                            <i class="fas fa-plus mr-2"></i>
                            @lang('Upload Document')
                        </a> --}}
                        <a href="{{ route('document.create') }}" class="btn btn-primary btn-rounded action-btn mr-lg-2">
                            <i class="fas fa-plus mr-2"></i>
                            @lang('Create Document')
                        </a>
                    @endif
                </div>
            </div>
            @include('document.partials.table')
            {{--            {{$table}}--}}
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        // $('.datepicker-here').datepicker({
        //     language: "en",
        //     minView: "months",
        //     view: "months",
        //     dateFormat: "dd-mm-yyyy",
        //     onSelect: function () {
        //         $('#search-form').submit();
        //     }
        // });

        $('tr[data-href]').on("click", function (event) {
            console.log('tr');
            // document.location = $(this).data('href');

        });

        document.querySelectorAll(".action-cell").forEach(btn => btn.addEventListener('click', function (event) {
            // event.cancelBubble = true;
            // event.stopPropagation();
        }, true));
    </script>
@endsection
