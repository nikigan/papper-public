@extends('layouts.app')

@section('page-title', 'Uploaded documents')
@section('page-heading', 'Uploaded documents')

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        <a href="{{ Route::current()->uri() }}">@lang('Uploaded documents')</a>
    </li>
@stop

@section('content')
    @include('partials.messages')
    {{--<h1>List of uploaded documents</h1>
        <div class="row py-3">
            @foreach($documents as $document)
                <div class="col-lg-4">
                    <a class="document-card">
                        <i class="document-card__icon fas fa-file-alt"></i>
                        <h5 class="document-card__title">{{ $document->user->username }}</h5>
                        <p class="document-card__text">{!! nl2br($document->document_text) ?? '' !!}</p>
                        <span class="document-card__date">{{ $document->getDate() }}</span>
                    </a>
                </div>
            @endforeach
        </div>--}}
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

        <div class="col-md-6">
            <a href="{{ route('documents.upload') }}" class="btn btn-primary btn-rounded float-right">
                <i class="fas fa-plus mr-2"></i>
                @lang('Upload Document')
            </a>
        </div>
    </div>
    <div class="table-responsive" id="users-table-wrapper">
    <table class="table table-borderless table-striped">
        <thead>
        <tr>
            {{--<th></th>
            <th class="min-width-80">@lang('Username')</th>
            <th class="min-width-150">@lang('Full Name')</th>
            <th class="min-width-100">@lang('Email')</th>--}}
            <th class="min-width-80">@lang('Document id')</th>
            <th class="min-width-100">@lang('Username')</th>
            <th class="min-width-80">@lang('Upload date')</th>
            <th class="min-width-80">@lang('Status')</th>
            <th class="text-center min-width-150">@lang('Action')</th>
        </tr>
        </thead>
        <tbody>
        @if (count($documents))
            @foreach ($documents as $document)
                @include('document.partials.row')
            @endforeach
        @else
            <tr>
                <td colspan="7"><em>@lang('No records found.')</em></td>
            </tr>
        @endif
        </tbody>
    </table>
    </div>
@endsection
