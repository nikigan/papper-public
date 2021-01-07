@extends('layouts.app')

@section('page-title', __('Income groups'))
@section('page-heading', __('Income groups'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        <a>@lang('Income groups')</a>
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
                    <a href="{{ route('income_groups.create') }}" class="btn btn-primary btn-rounded float-right mr-2">
                        <i class="fas fa-plus mr-2"></i>
                        @lang('Add Income Group')
                    </a>
                </div>
            </div>
            @if(count($income_groups))
                <div class="table-responsive">
                    <table class="table table-borderless table-striped">
                        <thead>
                        <tr>
                            <th class="text-center"> #</th>
                            <th class="text-center"> @lang("Group name")</th>
                            <th class="text-center">@lang("Action")</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($income_groups as $group)
                            <tr>
                                <td class="text-center">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="text-center">
                                    <b>@lang($group->name)</b>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('income_groups.edit', $group) }}"
                                       class="btn btn-icon"
                                       title="@lang('Edit Income')"
                                       data-toggle="tooltip"
                                       data-placement="top">
                                        <i class="fas fa-edit mr-2"></i>
                                    </a>
                                    <a href="{{ route('income_groups.destroy', $group) }}"
                                       class="btn btn-icon"
                                       title="@lang('Delete Group')"
                                       data-toggle="tooltip"
                                       data-placement="top"
                                       data-method="DELETE"
                                       data-confirm-title="@lang('Please Confirm')"
                                       data-confirm-text="@lang('Are you sure that you want to delete this group?')"
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
