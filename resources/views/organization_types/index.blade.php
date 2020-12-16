@extends('layouts.app')

@section('page-title', __('Organization types'))
@section('page-heading', __('Organization types'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        <a>@lang('Organization types')</a>
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
                    <a href="{{ route('organization_types.create') }}" class="btn btn-primary btn-rounded float-right mr-2">
                        <i class="fas fa-plus mr-2"></i>
                        @lang('Add organization type')
                    </a>
                </div>
            </div>
            @if(count($organization_types))
                <div class="table-responsive" id="users-table-wrapper">
                    <table class="table table-borderless table-striped">
                        <thead>
                        <tr>
                            <th class="text-center"> #</th>
                            <th class="text-center"> @lang("Type name")</th>
                            <th class="text-center">@lang("Action")</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($organization_types as $type)
                            <tr>
                                <td class="text-center">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="text-center">
                                    <b>@lang($type->name)</b>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('organization_types.edit', $type) }}"
                                       class="btn btn-icon"
                                       title="@lang('Edit Organization')"
                                       data-toggle="tooltip"
                                       data-placement="top">
                                        <i class="fas fa-edit mr-2"></i>
                                    </a>
                                    <a href="{{ route('organization_types.destroy', $type) }}"
                                       class="btn btn-icon"
                                       title="@lang('Delete Type')"
                                       data-toggle="tooltip"
                                       data-placement="top"
                                       data-method="DELETE"
                                       data-confirm-title="@lang('Please Confirm')"
                                       data-confirm-text="@lang('Are you sure that you want to delete this type?')"
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
