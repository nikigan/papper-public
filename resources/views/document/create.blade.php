@extends('layouts.main')

@section('page-title', __('Add Document'))
@section('page-heading', __('Create New Document'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('documents.index') }}">@lang('Documents')</a>
    </li>
    <li class="breadcrumb-item active">
        <a>@lang('Create Document')</a>
    </li>
@stop

@section('content')

    @include('partials.messages')

    <style>
        #drop-area {
            border: 2px dashed #ccc;
            border-radius: 20px;
            position: relative;
            width: 100%;
            font-family: sans-serif;
            margin: 50px auto;
            display: flex;
            align-items: center;
            flex-flow: column;
            justify-content: center;
        }

        #drop-area label {
            display: block;
            padding: 200px 20px;
            width: 100%;
            height: 100%;
            text-align: center;
            z-index: 1;
        }

        #drop-area.highlight {
            border-color: purple;
        }

        p {
            margin-top: 0;
        }

        .my-form {
            margin-bottom: 10px;
        }

        #gallery {
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            height: 100%;
            width: 100%;
            z-index: 0;
            text-align: center;
        }

        #gallery img {
            max-height: 300px;
            max-width: 100%;
        }

        .button {
            display: inline-block;
            padding: 10px;
            background: #ccc;
            cursor: pointer;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .button:hover {
            background: #ddd;
        }

        #file {
            display: none;
        }
    </style>

    {!! Form::open(['route' => ['document.manualStore', 'client' => $client], 'files' => true, 'id' => 'document-form']) !!}
    <div class="card">
        <div class="card-body">
            @isset($client->id)
                <h3>@lang('Client'): {{$client->present()->name}}</h3>
            @endisset
            <div class="form-row my-3 align-items-center">
                <div class="col-md-6 form-group">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="document_type_0" name="document_type" class="custom-control-input"
                               value="0" checked>
                        <label class="custom-control-label" for="document_type_0">@lang('Expense')</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="document_type_1" name="document_type" class="custom-control-input"
                               value="1">
                        <label class="custom-control-label" for="document_type_1">@lang('Income')</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" id="expense_type_block">
                        <label for="expense_type">@lang("Expense type"):</label>
                        <select name='expense_type_id' class="form-control" id="expense_type">
                            <option value="">@lang('Other Expense')</option>
                            @foreach($expense_types as $type)
                                <option value="{{$type->id}}"
                                        @if($vendors[0]->default_expense_type_id == $type->id) selected @endif>@lang($type->name)</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" id="income_type_block" style="display: none">
                        <label for="income_type">@lang("Income type"):</label>
                        <select name='income_type_id' class="form-control" id="income_type">
                            <option value="">@lang('Other Income')</option>
                            @foreach($income_types as $type)
                                <option value="{{$type->id}}"
                                        @if(auth()->user()->default_income_type_id == $type->id) selected @endif>@lang($type->name)</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-row align-items-center">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="document_number">@lang('Document number')</label>
                        <input type="text" class="form-control" @if($required)required @endif name="document_number"
                               id="document_number"
                               value="{{old('document_number')}}">
                        @if($error_document)
                            <a href="{{$error_document}}">@lang('Document with this number')</a>
                        @endif
                    </div>
                </div>
            </div>
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sum">@lang('Sum')</label>
                            <input type="number" class="form-control" @if($required)required @endif name="sum" id="sum"
                                   value="{{old('sum')}}">
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" checked class="custom-control-input" id="include_tax"
                                   name="include_tax">
                            <label class="custom-control-label" for="include_tax">@lang('Including tax')</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="vat">@lang('VAT') %</label>
                            <input type="number" min="0" max="100" step="0.1" class="form-control" name="vat" id="vat"
                                   value="{{old('vat', 17)}}">
                            <small id="vatHelp" class="form-text text-muted">0</small>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        <div class="form-group" id="document_type_block" style="display: none;">
                        <label for="document_type">@lang("Document type"):</label>
                        <select name='document_type_id' class="form-control" id="document_type">
                            <option value="">@lang('Other Type')</option>
                            @foreach($document_types as $type)
                                <option value="{{$type->id}}">@lang($type->name)</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="document_date">@lang('Document date')</label>
                            <input value="{{ \Carbon\Carbon::now() }}" class="form-control datepicker-here"
                                   id="document_date" name="document_date" data-language="en"
                                   data-date-format="dd-mm-yyyy">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="report_month">@lang('Report month')</label>
                            <input value="{{ \Carbon\Carbon::now()->format('m-Y') }}"
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
                            <select name='currency_id' class="form-control" id="currency">
                                @foreach($currencies as $currency)
                                    <option value="{{$currency->id}}"
                                            data-currency="{{$currency->ISO_code}}">@lang($currency->name)</option>
                                @endforeach
                            </select>
                        </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6">
                    <div id="vendors-block">
                        <div class="form-group">
                            <label for="vendor">@lang("Vendor"):</label>
                            <select name='vendor_id' class="form-control" id="vendor">
                                @foreach($vendors as $vendor)
                                    <option value="{{$vendor->id}}"
                                            data-vat="{{$vendor->vat_number}}"
                                            data-default-expense="{{$vendor->default_expense_type_id}}">@lang($vendor->name)
                                        -
                                        ({{$vendor->vat_number}})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="button" class="btn btn-link" data-toggle="modal"
                                data-target="#vendorsModal">@lang('Add a new vendor')</button>
                    </div>
                    <div id="customers-block" style="display: none;">
                        <div class="form-group">
                            <label for="customer">@lang("Customer"):</label>
                            <select name='customer_id' class="form-control" id="customer">
                                @foreach($customers as $customer)
                                    <option value="{{$customer->id}}"
                                            data-vat="{{$customer->vat_number}}">@lang($customer->name)
                                        - {{$customer->vat_number}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="button" class="btn btn-link" data-toggle="modal"
                                data-target="#customersModal">@lang('Add a new customer')</button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="partner_vat">@lang("VAT"):</label>
                        <input type="text" name='partner_vat' value="{{$vendors[0]->vat_number}}" class="form-control"
                               id="partner_vat">
                    </div>
                </div>
            </div>
            <div class="col-lg-6" id="drop-area">
                <label for="file" id="file-label">@lang('Upload file')</label>
                <input type="file" accept="image/png, image/jpeg, .pdf" name="file" id="file">
                <div id="gallery"></div>
            </div>
            <div class="col-lg-8 mx-auto">
                <label for="note" id="file-label">@lang('Comments')</label>
                <textarea name="note" id="note" rows="7" class="form-control"></textarea>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">
                @lang('Create Document')
            </button>
        </div>
    </div>
    {!! Form::close() !!}

    <br>

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
@stop

@section('scripts')
    <script>
        let dropArea = document.getElementById('drop-area');
        let fileInput = document.getElementById('file');
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false)
        });

        function preventDefaults(e) {
            e.preventDefault()
            e.stopPropagation()
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, highlight, false)
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, unhighlight, false)
        });

        function highlight(e) {
            dropArea.classList.add('highlight')
        }

        function unhighlight(e) {
            dropArea.classList.remove('highlight')
        }

        dropArea.addEventListener('drop', handleDrop, false)

        function handleDrop(e) {
            let dt = e.dataTransfer
            let files = dt.files
            fileInput.files = files;
            previewFile(files[0])
        }

        fileInput.addEventListener('change', function (e) {
            previewFile(e.target.files[0]);
        })

        function previewFile(file) {
            let reader = new FileReader()
            reader.readAsDataURL(file)
            reader.onloadend = function () {
                if (file.type == 'application/pdf') {
                    document.getElementById('file-label').innerText = file.name;
                } else {
                    let img = document.createElement('img')
                    img.src = reader.result
                    const gallery = document.getElementById('gallery');
                    gallery.innerHTML = "";
                    document.getElementById('file-label').innerText = "";
                    gallery.appendChild(img);
                }
            }
        }

        $('input[name=\"document_type\"]').change(function (event) {
            if (event.target.value == 0) {
                $('#expense_type_block').show();
                $('#vendors-block').show();
                $('#customers-block').hide();
                $('#document_type_block').hide();
                $('#income_type_block').hide();
            } else {
                $('#expense_type_block').hide();
                $('#vendors-block').hide();
                $('#customers-block').show();
                $('#document_type_block').show();
                $('#income_type_block').show();
            }
        });

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

            $("#vendor > option").each(function () {
                if ($(this).data('vat').toString() === value.toString()) {
                    $(this).attr('selected', 'selected');
                    found = true;
                    $("#vendor").val($(this).val());
                }
                console.log(found);

                if (!found) {
                    $(this).attr('selected', false);
                    $("#vendor").val(null);
                }
            });
        });

        $("#vendor, #customer").change(function () {
            partnerVatInput.val($(this).find(":selected").data('vat'));

        });

        $("#vendor").change(function () {
            $("#expense_type").val($(this).find(":selected").data('default-expense'));
        })

        $("#sum, #vat, #include_tax").on('input', function () {
            const sum = $("#sum").val();
            const tax = $("#vat").val();
            const includeTax = $("#include_tax").is(':checked');

            if (includeTax) {
                $("#vatHelp").html(((sum / (1 + tax / 100)) * tax / 100).toFixed(2));
            } else {
                $("#vatHelp").html((sum * tax / 100).toFixed(2));
            }

        });
    </script>
@stop

