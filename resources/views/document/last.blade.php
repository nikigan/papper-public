@extends('layouts.main')

@section('page-title', __('Documents'))
@section('page-heading', __('Uploaded documents'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        <a href="{{ Route::current()->uri() }}">@lang('Last documents')</a>
    </li>
@stop

@section('content')
    @include('partials.messages')

    @include('document.partials.header')

    <h2>@lang('List of last documents')</h2>
    <div class="card">
        <div class="card-body">
            <div class="row my-3 flex-md-row flex-column-reverse">
                <div class="col-md-4 mt-md-0 mt-2">
                </div>

                <div class="col-md-2 mt-2 mt-md-0">
                </div>

                <div class="col-md-6 col-12">
                    @if(auth()->user()->hasPermission('document.upload'))
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


@section('scripts')
    <script>
        $('input[type=\'date\']').change(function () {
            $('#search-form').submit();
        });
    </script>
@stop
