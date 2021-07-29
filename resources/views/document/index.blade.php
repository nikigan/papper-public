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

   @include('document.partials.header')

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
        </div>
    </div>
@endsection


