@extends('layouts.app')

@section('page-title', 'Create invoice')
@section('page-heading', 'Create invoice')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{route('invoice.index')}}">@lang('Invoices')</a>
    </li>
    <li class="breadcrumb-item active">
        <a>@lang('Create invoice')</a>
    </li>
@stop

@section('content')
    @include('partials.messages')
    <div class="container">
        <div class="card">
            <div class="card-header">{{__("Create invoice")}}</div>
            <form action="{{ route('invoice.store') }}" method="post">
                @csrf
                <div class="card-body">
                    <div class="container">
                        <div class="row clearfix">
                            <div class="col-md-6 text-center">
                                <div class="form-group">
                                    <label for="document_type">@lang("Document type")*:</label>
                                    <select name='invoice[document_type]' class="form-control" id="document_type">
                                        @foreach($document_types as $document_type)
                                            <option value="{{$document_type->id}}"
                                                    data-prefix="{{$document_type->prefix}}"
                                                    @if($loop->first) selected @endif>@lang($document_type->name)</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="invoice_number">@lang("Document number")*:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"
                                                 id="prefix">{{$document_types[0]->prefix}}</div>
                                        </div>
                                        <input type="text" name='invoice[invoice_number]' class="form-control"
                                               value="{{$id}}" required readonly
                                               id="invoice_number"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="date">@lang("Document date")*:</label>
                                    <input id="date" type="date" name='invoice[invoice_date]' max="{{ date('Y-m-d') }}"
                                           class="form-control datechk"
                                           value="{{ date('Y-m-d') }}" required/>
                                </div>
                            </div>
                            <div class="col-md-6 text-center">
                                <div class="form-group">
                                    <label for="currency">@lang("Currency")*:</label>
                                    <select name='invoice[currency_id]' class="form-control" id="currency">
                                        @foreach($currencies as $currency)
                                            <option value="{{$currency->id}}"
                                                    data-currency="{{$currency->ISO_code}}">@lang($currency->name)</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="payment">@lang("Payment type")*:</label>
                                    <select name='invoice[payment_type]' class="form-control" id="payment">
                                        @foreach($payment_types as $payment_type)
                                            <option
                                                value="{{$payment_type->id}}">@lang($payment_type->name)</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group" id="income_type_block">
                                    <label for="income_type">@lang("Income type"):</label>
                                    <select name='invoice[income_type_id]' class="form-control" id="income_type">
                                        <option value="">@lang('Other')</option>
                                        @foreach($income_types as $type)
                                            <option value="{{$type->id}}">@lang($type->name)</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        @isset($user)
                            <div class="row clearfix" style="margin-top:20px">
                                <div class="col-md-12">
                                    @isset($customer)
                                        <div class="float-left col-md-6">
                                            @lang("Customer"): <b>{{ $customer->name }}</b>
                                            <input type="hidden" name="invoice[customer_id]"
                                                   value="{{ $customer->id }}"/>
                                        </div>
                                    @else
                                        <div class="float-left col-md-6">
                                            <label for="customer_id">
                                                @lang('Customer')
                                            </label>
                                            <select name="invoice[customer_id]" id="customer_id" class="form-control">
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                @endforeach
                                            </select>
                                            <a href="{{route('customers.create')}}">@lang('Add new customer')</a>
                                        </div>
                                    @endif
                                    <div class="float-right col-md-4">
                                        <b>@lang("Seller details")</b>:
                                        <br/>
                                        {{ $user->first_name }} {{$user->last_name}}
                                        <br/>
                                        @lang("Email"): {{ $user->email }}
                                        <br/>
                                        {{ $user->address }}
                                        <br/>
                                        VAT Number: xx xxxxx xxxx
                                    </div>
                                </div>
                            </div>
                        @endisset

                        <div class="row clearfix" style="margin-top:20px">
                            <div class="col-md-12">
                                <table class="table table-bordered table-hover" id="tab_logic">
                                    <thead>
                                    <tr>
                                        <th class="text-center"> #</th>
                                        <th class="text-center"> @lang("Product")</th>
                                        <th class="text-center"> @lang("Qty")</th>
                                        <th class="text-center"> @lang("Price") (<span
                                                class="currency">{{$currencies[0]->ISO_code}}</span>)
                                        </th>
                                        <th class="text-center"> @lang("Total") (<span
                                                class="currency">{{$currencies[0]->ISO_code}}</span>)
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr id='addr0'>
                                        <td>1</td>
                                        <td>
                                            <input type="text" name="service[]" id=""
                                                   placeholder="@lang("Enter service")" class="form-control">
                                            {{--<select name="product[]" class="form-control">
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                @endforeach
                                            </select>--}}
                                        </td>
                                        <td><input type="number" name='qty[]' placeholder='@lang("Enter Qty")'
                                                   class="form-control qty" step="1" min="0"/></td>
                                        <td><input type="number" name='price[]' placeholder='@lang("Enter Unit Price")'
                                                   class="form-control price" step="0.01" min="0"/></td>
                                        <td><input type="number" name='total[]' placeholder='0.00'
                                                   class="form-control total" readonly/></td>
                                    </tr>
                                    <tr id='addr1'></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-md-12">
                                <input type="button" id="add_row" class="btn btn-primary float-left"
                                       value="@lang("Add Row")"/>
                                <input type="button" id='delete_row' class="float-right btn btn-info"
                                       value="@lang("Delete Row")"/>
                            </div>
                        </div>
                        <div class="row clearfix" style="margin-top:20px">
                            <div class="col-md-12">
                                <div class="float-left col-md-7">
                                    <div class="form-group">
                                        <label for="note">@lang('Comments'):</label>
                                        <textarea name="note" class="form-control" id="note" rows="10"></textarea>
                                    </div>
                                </div>
                                <div class="float-right col-md-5">
                                    <table class="table table-bordered table-hover" id="tab_logic_total">
                                        <tbody>
                                        @if($have_tax)
                                            <tr>
                                                <th class="text-center" style="width: 60%">@lang("Sub Total")
                                                    (<span class="currency">{{$currencies[0]->ISO_code}}</span>)
                                                </th>
                                                <td class="text-center"><input type="number" name='sub_total'
                                                                               placeholder='0.00' class="form-control"
                                                                               id="sub_total" readonly/></td>
                                            </tr>
                                            <tr>
                                                <th class="text-center">@lang("Tax")</th>
                                                <td class="text-center">
                                                    <div class="input-group mb-2 mb-sm-0">
                                                        <input type="number" class="form-control" id="tax"
                                                               placeholder="0"
                                                               name="invoice[tax_percent]" value="{{ $tax }}">
                                                        <div class="input-group-addon">%</div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="text-center">@lang("Including tax")</th>
                                                <td class="text-center">
                                                    <div class="input-group mb-2 mb-sm-0">
                                                        <input type="checkbox" class="form-control" id="include_tax"
                                                               checked
                                                               name="invoice[include_tax]">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="text-center">@lang("Tax Amount")
                                                    (<span class="currency">{{$currencies[0]->ISO_code}}</span>)
                                                </th>
                                                <td class="text-center"><input type="number" name='tax_amount'
                                                                               id="tax_amount" placeholder='0.00'
                                                                               class="form-control" readonly/></td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th class="text-center">@lang("Grand Total")
                                                (<span class="currency">{{$currencies[0]->ISO_code}}</span>)
                                            </th>
                                            <td class="text-center"><input type="number" name='total_amount'
                                                                           id="total_amount" placeholder='0.00'
                                                                           class="form-control" readonly/></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary" value="@lang("Save Invoice")"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            var i = 1;
            $("#add_row").click(function () {
                b = i - 1;
                $('#addr' + i).html($('#addr' + b).html()).find('td:first-child').html(i + 1);
                $('#tab_logic').append('<tr id="addr' + (i + 1) + '"></tr>');
                i++;
            });
            $("#delete_row").click(function () {
                if (i > 1) {
                    $("#addr" + (i - 1)).html('');
                    i--;
                }
                calc();
            });

            $('#tab_logic tbody').on('keyup change', function () {
                calc();
            });
            $('#tax').on('keyup change', function () {
                calc_total();
            });

            $('#include_tax').change(function () {
                calc_total();
            });

            $('#document_type').change(function (event) {
                const prefix = $('#document_type option:selected').data('prefix');
                $('#prefix').text(prefix);
            });

            $('#currency').change(function () {
                $('.currency').text($(this).find('option:selected').data('currency'));
            })
        });

        function calc() {
            $('#tab_logic tbody tr').each(function (i, element) {
                var html = $(this).html();
                if (html != '') {
                    var qty = $(this).find('.qty').val();
                    var price = $(this).find('.price').val();
                    $(this).find('.total').val((qty * price).toFixed(2));

                    calc_total();
                }
            });
        }

        function calc_total() {
            let total = 0;
            $('.total').each(function () {
                total += parseFloat($(this).val());
            });
            console.log(total);
            $('#sub_total').val(total.toFixed(2));
            @if($have_tax)
            const k = $('#include_tax').prop('checked') ? 1 : -1;
            const tax_sum = total / 100 * $('#tax').val();
            $('#tax_amount').val(tax_sum.toFixed(2));
            $('#total_amount').val((k * tax_sum + total).toFixed(2));
            @else
            $('#total_amount').val((total).toFixed(2));
            @endif
        }

    </script>
@stop
