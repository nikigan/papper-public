@extends('layouts.app')

@section('page-title', __('Document types'))
@section('page-heading', __('Document types'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        <a>@lang('Document types')</a>
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
                    <a href="{{ route('document_types.create') }}" class="btn btn-primary btn-rounded float-right mr-2">
                        <i class="fas fa-plus mr-2"></i>
                        @lang('Add document type')
                    </a>
                </div>
            </div>
            @if(count($document_types))
                <div class="table-responsive" id="users-table-wrapper">
                    <table class="table table-borderless table-striped">
                        <thead>
                        <tr>
                            <th class="text-center"> #</th>
                            <th class="text-center"> @lang("Type name")</th>
                            <th class="text-center"> @lang("Type prefix")</th>
                            <th class="text-center">@lang("Action")</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($document_types as $type)
                            <tr>
                                <td class="text-center">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="text-center">
                                    {{--<input type="text" name="name[]" class="document-type__name form-control"
                                           value="@lang($type->name)">--}}
                                    <b>@lang($type->name)</b>
                                </td>
                                <td class="text-center">
                                    {{--                                    <input type="text" name="prefix[]" value="{{$type->prefix}}" class="form-control">--}}
                                    <span>{{$type->prefix}}</span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('document_types.edit', $type) }}"
                                       class="btn btn-icon"
                                       title="@lang('Edit Document')"
                                       data-toggle="tooltip"
                                       data-placement="top">
                                        <i class="fas fa-edit mr-2"></i>
                                    </a>
                                    <a href="{{ route('document_types.destroy', $type) }}"
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
                {{--<tr>

                    <td>
                        1
                    </td>
                    <td>
                        <input type="text" name="name[]" class="document-type__name form-control"
                               value="{{old('name[]')}}" placeholder="@lang('Type name')">
                    </td>
                    <td>
                        <input type="text" name="prefix[]" value="{{old('prefix[]')}}" class="form-control"
                               placeholder="@lang('Type prefix')">
                    </td>
                </tr>--}}
                <div><em>@lang('No records found.')</em></div>
            @endif
            {{--<div class="form-row">
                <button type="button" class="btn btn-info my-3" id="add-btn">@lang('Add document type')</button>
                <button type="submit" class="btn btn-primary my-3 ml-auto" id="add-btn">@lang('Save')</button>
            </div>--}}
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
