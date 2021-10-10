@extends('layouts.main')

@section('page-title', __('Documents'))
@section('page-heading', __('Documents'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('documents.index') }}">@lang('Documents')</a>
    </li>
    <li class="breadcrumb-item active">
        <a>@lang('Documents') {{$document->id}}</a>
    </li>
@stop

@section('content')
    @include('partials.messages')
    <nav>
        <ul class="pagination justify-content-end">
            @if($prev)
                <li class="page-item">
                    <a class="page-link"
                       href="{{$client->id ? route('clients.documents.show', ['client' => $client, 'document' => $prev->id]) : route('documents.show', $prev->id)}}">@lang('Previous')</a>
                </li>
            @endif
            @if($next)
                <li class="page-item">
                    <a class="page-link"
                       href="{{$client->id ? route('clients.documents.show', ['client' => $client, 'document' => $next->id]) : route('documents.show', $next->id)}}">@lang('Next')</a>
                </li>
            @endif
        </ul>
    </nav>
    <div class="card">
        <div class="card-body">
            <div class="row py-3">
                <div class="col-lg-6">
                    <h3>@lang('Client'): <a
                            href="{{route('clients.show', $document->user)}}">{{$document->user->present()->name}}</a>
                    </h3>
                    {!! Form::open(['route' => ['documents.update', 'document' => $document], 'files' => true, 'id' => 'document-form', 'method' => 'PUT']) !!}
                    <div class="my-3">
                        <div class="form-row align-items-center">
                            <div class="col-md-6">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="document_type_0" name="document_type"
                                           class="custom-control-input"
                                           value="0"
                                           @unless($document->document_type) checked @endunless"
                                    @nopermission('document.edit') disabled @endpermission>
                                    <label class="custom-control-label"
                                           for="document_type_0">@lang('Expense')</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="document_type_1" name="document_type"
                                           class="custom-control-input"
                                           value="1"
                                           @if($document->document_type) checked @endif
                                           @nopermission('document.edit') disabled @endpermission>
                                    <label class="custom-control-label"
                                           for="document_type_1">@lang('Income')</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id="document_type_block"
                                     @if($document->document_type != 1) style="display: none;" @endif>
                                    <label for="document_type">@lang("Document type"):</label>
                                    <select name='document_type_id' class="form-control" id="document_type">
                                        <option value="">@lang('Other type')</option>
                                        @foreach($document_types as $type)
                                            <option value="{{$type->id}}"
                                                    @if($document->document_type_id == $type->id) selected @endif>@lang($type->name)</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row align-items-center">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="document_number">@lang('Document number')</label>
                                <input type="text" class="form-control" name="document_number"
                                       id="document_number"
                                       required
                                       value="{{old('document_number', $document->document_number)}}"
                                       @nopermission('document.edit') readonly @endpermission>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sum">@lang('Total sum')</label>
                                <input type="text" class="form-control" name="sum" id="sum" required
                                       value="{{old('sum', $document->sum)}}"
                                       @nopermission('document.edit') readonly @endpermission>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="vat">@lang('VAT')</label>
                                <input type="text" class="form-control" name="vat" id="vat" required
                                       value="{{old('vat', $document->vat)}}"
                                       @nopermission('document.edit') readonly @endpermission>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="document_date">@lang('Document date')</label>
                                <input
                                    value="{{ \Carbon\Carbon::parse($document->document_date)->format(config('app.date_format')) }}"
                                    class="form-control datepicker-here"
                                    id="document_date" name="document_date" data-language="en"
                                    data-date-format="dd-mm-yyyy">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="report_month">@lang('Report month')</label>
                                <input
                                    value="{{ (new \Carbon\Carbon($document->report_month))->format(config('app.date_month_format')) }}"
                                    class="form-control datepicker-here"
                                    id="report_month" data-date-format="mm-yyyy" data-min-view="months"
                                    data-view="months" data-language="en" name="report_month">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="currency">@lang("Currency"):</label>
                                <select name='currency_id' class="form-control" id="currency"
                                        @nopermission('document.edit')
                                        disabled @endpermission>
                                    @foreach($currencies as $currency)
                                        <option value="{{$currency->id}}"
                                                data-currency="{{$currency->ISO_code}}"
                                                @if($document->currency->id == $currency->id) selected @endif>@lang($currency->name)</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div id="vendors-block" class="form-group"
                                 @if($document->document_type != 0) style="display:none;" @endif>
                                <label for="vendor">@lang("Vendor"):</label>
                                <select name='vendor_id' class="form-control selectpicker" data-live-search="true"
                                        id="vendor">
                                    @foreach($vendors as $vendor)
                                        <option value="{{$vendor->id}}"
                                                @isset($document->$vendor)
                                                @if($document->vendor->id == $vendor->id) selected @endif
                                                @endisset
                                                data-vat="{{$vendor->vat_number}}">@lang($vendor->name) -
                                            ({{$vendor->vat_number}})
                                        </option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-link" data-toggle="modal"
                                        data-target="#vendorsModal">@lang('Add a new vendor')</button>
                            </div>
                            <div id="customers-block" class="form-group"
                                 @if($document->document_type != 1) style="display:none;" @endif>
                                <label for="customer">@lang("Customer"):</label>
                                <select name="customer_id" id="customer" class="selectpicker" data-live-search="true">
                                    @foreach($customers as $customer)
                                        <option value="{{$customer->id}}"
                                                @isset($document->customer)
                                                @if($document->customer->id == $customer->id) selected @endif
                                                @endisset
                                                data-vat="{{$customer->vat_number}}">@lang($customer->name)
                                            - {{$customer->vat_number}}</option>
                                    @endforeach
                                </select>

                                <button type="button" class="btn btn-link" data-toggle="modal"
                                        data-target="#customersModal">@lang('Add a new customer')</button>
                                {{--                                <a href="{{route('customers.create', ['selected_client' => $document->user])}}">@lang('Add a new customer')</a>--}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="partner_vat">@lang("VAT"):</label>
                                <input type="text" name='partner_vat'
                                       value="{{isset($document->vendor) ? $document->vendor->vat_number : (isset($document->customer) ? $document->customer->vat_number : "")}}"
                                       class="form-control"
                                       id="partner_vat">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group" id="expense_type_block"
                                 @if($document->document_type != 0) style="display:none;" @endif>
                                <label for="expense_type">@lang("Expense type"):</label>
                                <select name='expense_type_id' class="form-control selectpicker" data-live-search="true"
                                        id="expense_type">
                                    <option value="">@lang('Other Expense')</option>
                                    @foreach($expense_types as $type)
                                        <option value="{{$type->id}}"
                                                @if($document->expense_type_id == $type->id) selected @endif>@lang($type->name)</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" id="income_type_block"
                                 @if($document->document_type != 1) style="display: none" @endif>
                                <label for="income_type">@lang("Income type"):</label>
                                <select name='income_type_id' class="form-control selectpicker" data-live-search="true"
                                        id="income_type">
                                    <option value="">@lang('Other Income')</option>
                                    @foreach($income_types as $type)
                                        <option value="{{$type->id}}"
                                                @if($document->income_type_id == $type->id || auth()->user()->default_income_type_id == $type->id) selected @endif>@lang($type->name)</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{--<div class="form-group">
                        <label for="file">Upload file</label>
                        <input type="file" accept="image/png, image/jpeg, .pdf" name="file" id="file"
                               class="form-control-file" value="{{ old('file', $document->file) }}">
                    </div>--}}
                    @permission('document.edit')
                    {!! Form::select('status', $statuses, $document->status,
                    ['class' => 'form-control input-solid my-3', 'id' => 'status']) !!}
                    @endpermission
                    @permission('document.text')
                    @if ($document->document_text)
                        <div class="card">
                            <div class="card-body document-text__card">
                                <div class="document-text">
                                    {!! nl2br($document->document_text ?? '') !!}
                                </div>
                            </div>
                        </div>
                    @endif
                    @endpermission
                    <h6>@lang('Comments')</h6>
                    <div class="document-text">
                            <textarea name="note" id="note" rows="7"
                                      class="form-control">{!! nl2br($document->note ?? '') !!}</textarea>
                    </div>

                </div>
                <div class="col-lg-6 text-center">
                    @isset($document->file)
                        @if($isPdf)
                            <iframe
                                src='{{ asset("assets/pdf-js/web/viewer.html") . "?file=" . asset($document->file) }}'
                                width="100%"
                                height="600px"
                                style="border: none;"></iframe>
                            <a href="{{ asset($document->file) }}">PDF file</a>
                        @else
                            <div class="document-image-zoom">
                                <img class="img-responsive document-image" src="{{ asset($document->file) }}" alt="">
                            </div>
                        @endif
                    @endisset
                </div>
            </div>
            @permission('document.edit')
            <button type="submit" class="btn btn-primary">
                @lang('Update Document')
            </button>
            @endpermission
            @if(!auth()->user()->hasRole('User'))
                <button
                    type="button"
                    data-toggle="modal" data-target="#documentCheckModal-{{$document->id}}"
                    class="btn btn-icon"
                    title="@lang('Check Document')">
                    <i class="fas fa-question"></i>
                </button>
            @endif
            {!! Form::close() !!}


        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="vendorsModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Create Vendor')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::open(['route' => 'vendors.store', 'id' => "vendorsForm"]) !!}
                    <div class="card">
                        <div class="card-body">
                            @include('vendors.partial.details', ['edit' => false])
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">
                                @lang('Create Vendor')
                            </button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="customersModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Create Customer')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::open(['route' => 'customers.store', 'id' => 'customersForm']) !!}
                    <div class="card">
                        <div class="card-body">
                            @include('customers.partial.details', ['edit' => false])
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">
                                @lang('Create Customer')
                            </button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    @include('document_check.partial.modal')
@endsection

@section('scripts')
    <script src="{{asset('assets/plugins/zoom-master/jquery.zoom.min.js')}}"></script>
    <script>
        $(document).ready(function () {

            $('input[name=\"document_type\"]').change(function (event) {
                if (event.target.value == 0) {
                    $('#expense_type_block').show();
                    $('#document_type_block').hide();
                    $('#income_type_block').hide();
                    $('#vendors-block').show();
                    $('#customers-block').hide();
                } else {
                    $('#expense_type_block').hide();
                    $('#document_type_block').show();
                    $('#income_type_block').show();
                    $('#vendors-block').hide();
                    $('#customers-block').show();
                }
            })

            const img = document.querySelector('.document-image');

            const ratio = img.naturalHeight / img.naturalWidth;
            $('.document-image-zoom').zoom({
                url: '{{asset($document->file)}}',
                magnify: ratio
            });
        });

        document.querySelectorAll('input[list]').forEach(input => input.addEventListener('input', function (e) {
            var input = e.target,
                list = input.getAttribute('list'),
                options = document.querySelectorAll('#' + list + ' option'),
                hiddenInput = document.getElementById(input.getAttribute('id') + '-hidden'),
                inputValue = input.value;

            hiddenInput.value = inputValue;

            console.log(input);
            for (var i = 0; i < options.length; i++) {
                var option = options[i];

                if (option.innerText === inputValue) {
                    hiddenInput.value = option.getAttribute('data-value');
                    break;
                }
            }
        }));

        const listErrors = (data) => {
            return Object.values(data.errors).map(error => error.join('\n'));
        }

        $('#vendorsForm').submit(function (e) {
            e.preventDefault();
            const form = $(this);

            if (!form.valid) return false;
            const data = form.serialize();

            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                dataType: 'json',
                data: data,
                success: (response) => {
                    $("#vendorsModal").modal('hide');
                    $("#vendor").append(`<option value="${response.id}" data-vat="${response.vat_number}" selected >${response.name} - ${response.vat_number}</option>`).change();
                    $('.selectpicker').selectpicker('refresh');
                    $('.selectpicker').selectpicker('render');

                },
                error: (response) => {
                    $("#vendorsModal .modal-body").append(`<div class="alert alert-danger" role="alert">${listErrors(response.responseJSON)} <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>`)
                }
            });
        });

        $('#customersForm').submit(function (e) {
            e.preventDefault();
            const form = $(this);

            if (!form.valid) return false;
            const data = form.serialize();

            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                dataType: 'json',
                data: data,
                success: (response) => {
                    $("#customersModal").modal('hide');
                    $("#customer").append(`<option value="${response.id}" data-vat="${response.vat_number}" selected>${response.name} - ${response.vat_number}</option>`).change();
                    $('.selectpicker').selectpicker('refresh');
                    $('.selectpicker').selectpicker('render');

                },
                error: (response) => {
                    $("#customersModal .modal-body").append(`<div class="alert alert-danger" role="alert">${listErrors(response.responseJSON)} <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>`)
                }
            });
        });

        const partnerVatInput = $("#partner_vat")

        partnerVatInput.on('input', function (e) {
            const value = $(this).val();
            $("#vendor_vat_number").val(value);
            $("#customer_vat_number").val(value);
            let found = false;

            $("#vendor option").each(function () {
                if ($(this).data('vat').toString() === value.toString()) {
                    $(this).attr('selected', 'selected');
                    found = true;
                    $("#vendor").val($(this).val());
                }

                if (!found) {
                    $(this).attr('selected', false);
                    $("#vendor").val(null);
                }
            });

            $("#customer option").each(function () {
                if ($(this).data('vat').toString() === value.toString()) {
                    $(this).attr('selected', 'selected');
                    found = true;
                    $("#customer").val($(this).val());
                }

                if (!found) {
                    $(this).attr('selected', false);
                    $("#customer").val(null);
                }
            });

            $('.selectpicker').selectpicker('render');
        });

        $("#vendor, #customer").change(function () {
            partnerVatInput.val($(this).find(":selected").data('vat'));
        });
    </script>
@stop
