@extends('layouts.app')

@section('page-title', __('Currencies'))
@section('page-heading', __('Currencies'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        <a>@lang('Currencies')</a>
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
                    <a href="{{ route('currency.create') }}" class="btn btn-primary btn-rounded float-right mr-2">
                        <i class="fas fa-plus mr-2"></i>
                        @lang('Add currency')
                    </a>
                </div>
            </div>
            @if(count($currencies))
                <div class="table-responsive" id="users-table-wrapper">
                    <table class="table table-borderless table-striped">
                        <thead>
                        <tr>
                            <th class="text-center"> #</th>
                            <th class="text-center"> @lang("Currency name")</th>
                            <th class="text-center"> @lang("ISO code")</th>
                            <th class="text-center"> @lang("Sign")</th>
                            <th class="text-center"> @lang("Currency value")</th>
                            <th class="text-center">@lang("Action")</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($currencies as $currency)
                            <tr>
                                <td class="text-center">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="text-center">
                                    <b>@lang($currency->name)</b>
                                </td>
                                <td class="text-center">
                                    @lang($currency->ISO_code)
                                </td>
                                <td class="text-center">
                                    @lang($currency->sign)
                                </td>
                                <td class="text-center">
                                    <b>{{$currency->value}}</b>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('currency.edit', $currency) }}"
                                       class="btn btn-icon"
                                       title="@lang('Edit Document')"
                                       data-toggle="tooltip"
                                       data-placement="top">
                                        <i class="fas fa-edit mr-2"></i>
                                    </a>
                                    <a href="{{ route('currency.destroy', $currency) }}"
                                       class="btn btn-icon"
                                       title="@lang('Delete Type')"
                                       data-toggle="tooltip"
                                       data-placement="top"
                                       data-method="DELETE"
                                       data-confirm-title="@lang('Please Confirm')"
                                       data-confirm-text="@lang('Are you sure that you want to delete this currency?')"
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

{{--@section('scripts')
    <script>
        $(document).ready(function () {
            let index = {{count($document_types) + 1}};

            $('#add-btn').click(function () {
                $("#table").append(`
                <tr>
                <td>
                            ${index}
                        </td>
                        <td>
                            <input type="text" name="name[]" class="document-type__name form-control"
                                   value="{{old('name[]')}}" placeholder="@lang('Type name')">
                        </td>
                        <td>
                            <input type="text" name="prefix[]" value="{{old('prefix[]')}}" class="form-control"
                                   placeholder="@lang('Type prefix')">
                        </td>
                        </tr>`);
                index++;
            });
        });
    </script>
@stop--}}
