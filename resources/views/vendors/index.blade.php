@extends('layouts.app')

@section('page-title', 'Vendors')
@section('page-heading', 'Vendors')

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        <a>@lang('Vendors')</a>
    </li>
@stop

@section('content')
    @include('partials.messages')
    <h2>@lang('Your Vendors')</h2>
    <div class="card">
        <div class="card-body">
            <div class="row my-3 flex-md-row flex-column-reverse">
                <div class="col-md-4 mt-md-0 mt-2">
                </div>
                <div class="col-md-2 mt-2 mt-md-0">
                </div>
                <div class="col-md-6">
                    <a href="{{ route('vendors.create') }}" class="btn btn-primary btn-rounded float-right">
                        <i class="fas fa-plus mr-2"></i>
                        @lang('Create Vendor')
                    </a>
                </div>
            </div>
            <div class="table-responsive" id="users-table-wrapper">
                <table class="table table-borderless table-striped">
                    <thead>
                    <tr>
                        <th class="min-width-80">@lang('Name')</th>
                        <th class="min-width-100">@lang('Email')</th>
                        <th class="min-width-100">@lang('Phone')</th>
                        <th class="min-width-100">@lang('VAT number')</th>
                        <th class="text-center min-width-150">@lang('Action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (count($vendors))
                        @foreach ($vendors as $vendor)
                            <tr>
                                <td class="align-middle">
                                    <a href="{{ route('vendors.show', $vendor->id) }}">
                                        {{ $vendor->name ?: __('N/A') }}
                                    </a>
                                </td>
                                <td class="align-middle">{{ $vendor->email }}</td>
                                <td class="align-middle">{{ $vendor->phone }}</td>
                                <td class="align-middle">{{ $vendor->vat_number }}</td>
                                <td class="text-center align-middle">
                                    <a href="{{ route('vendors.show', $vendor->id) }}" class="btn btn-sm btn-primary"
                                       title="@lang('View Vendor')"
                                       data-toggle="tooltip" data-placement="top">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('vendors.destroy', $vendor) }}"
                                       class="btn btn-sm btn-danger"
                                       title="@lang('Delete Vendor')"
                                       data-toggle="tooltip"
                                       data-placement="top"
                                       data-method="DELETE"
                                       data-confirm-title="@lang('Please Confirm')"
                                       data-confirm-text="@lang('Are you sure that you want to delete this vendor?')"
                                       data-confirm-delete="@lang('Yes, delete it!')">
                                        <i class="fa fa-trash"></i>
                                    </a>

                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7"><em>@lang('No records found.')</em></td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
