@extends('layouts.app')

@section('page-title', __('Document checks'))
@section('page-heading', __('Document checks'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        <a>@lang('Document checks')</a>
    </li>
@stop

@section('content')
    @include('partials.messages')
    <div class="card">
        <div class="card-body">
            <div class="row my-3 flex-md-row flex-column-reverse">
                <div class="col-md-4 mt-md-0 mt-2">
                </div>
                <div class="col-md-2 mt-2 mt-md-0">
                </div>
                <div class="col-md-6">
                    <a href="{{ route('document_check.create') }}" class="btn btn-primary btn-rounded float-right mr-2">
                        <i class="fas fa-plus mr-2"></i>
                        @lang('Add document check')
                    </a>
                </div>
            </div>
            @if(count($document_checks))
                <div class="table-responsive" id="users-table-wrapper">
                    <table class="table table-borderless table-striped">
                        <thead>
                        <tr>
                            <th class="text-center"> #</th>
                            <th class="text-center"> @lang("Check title")</th>
                            <th class="text-center"> @lang("Check text")</th>
                            <th class="text-center">@lang("Action")</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($document_checks as $check)
                            <tr>
                                <td class="text-center">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="text-center">
                                    <b>@lang($check->title)</b>
                                </td>
                                <td class="text-center">
                                    <span>{{$check->text}}</span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('document_check.edit', $check) }}"
                                       class="btn btn-icon"
                                       title="@lang('Edit Document Check')"
                                       data-toggle="tooltip"
                                       data-placement="top">
                                        <i class="fas fa-edit mr-2"></i>
                                    </a>
                                    <a href="{{ route('document_check.destroy', $check) }}"
                                       class="btn btn-icon"
                                       title="@lang('Delete Check')"
                                       data-toggle="tooltip"
                                       data-placement="top"
                                       data-method="DELETE"
                                       data-confirm-title="@lang('Please Confirm')"
                                       data-confirm-text="@lang('Are you sure that you want to delete this check?')"
                                       data-confirm-delete="@lang('Yes, delete it!')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            @else
                <div><em>@lang('No records found.')</em></div>
            @endif
        </div>
    </div>
@stop
