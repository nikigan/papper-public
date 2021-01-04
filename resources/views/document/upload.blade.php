@extends('layouts.app')

@section('page-title', 'Upload document')
@section('page-heading', 'Upload document')

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        <a href="{{ Route::current()->uri() }}">@lang('Upload document')</a>
    </li>
@stop

@section('content')
    @include('partials.messages')
    <form method="post" action="{{route('documents.store')}}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="file">Upload file</label>
            <input type="file" required accept="image/png, image/jpeg, .pdf" name="file" id="file" class="form-control-file">
        </div>
        <button type="submit" class="btn btn-primary">Upload file</button>
    </form>
@stop
