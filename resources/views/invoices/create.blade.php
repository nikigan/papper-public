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
                            <div class="col-md-4 offset-4 text-center">
                                @lang("Invoice number")*:
                                <br/>
                                <input type="text" name='invoice[invoice_number]' class="form-control"
                                       value="{{$id}}" required/>
                                @lang("Invoice date")*:
                                <br/>
                                <input type="date" name='invoice[invoice_date]' class="form-control"
                                       value="{{ date('Y-m-d') }}" required/>
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
                                        <th class="text-center"> @lang("Price") ({{ config('invoices.currency') }})</th>
                                        <th class="text-center"> @lang("Total") ({{ config('invoices.currency') }})</th>
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
                                <div class="float-right col-md-5">
                                    <table class="table table-bordered table-hover" id="tab_logic_total">
                                        <tbody>
                                        <tr>
                                            <th class="text-center" style="width: 60%">@lang("Sub Total")
                                                ({{ config('invoices.currency') }})
                                            </th>
                                            <td class="text-center"><input type="number" name='sub_total'
                                                                           placeholder='0.00' class="form-control"
                                                                           id="sub_total" readonly/></td>
                                        </tr>
                                        <tr>
                                            <th class="text-center">@lang("Tax")</th>
                                            <td class="text-center">
                                                <div class="input-group mb-2 mb-sm-0">
                                                    <input type="number" class="form-control" id="tax" placeholder="0"
                                                           name="invoice[tax_percent]" value="{{ $tax }}">
                                                    <div class="input-group-addon">%</div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-center">@lang("Including tax")</th>
                                            <td class="text-center">
                                                <div class="input-group mb-2 mb-sm-0">
                                                    <input type="checkbox" class="form-control" id="include_tax" checked
                                                           name="invoice[include_tax]">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-center">@lang("Tax Amount")
                                                ({{ config('invoices.currency') }})
                                            </th>
                                            <td class="text-center"><input type="number" name='tax_amount'
                                                                           id="tax_amount" placeholder='0.00'
                                                                           class="form-control" readonly/></td>
                                        </tr>
                                        <tr>
                                            <th class="text-center">@lang("Grand Total")
                                                ({{ config('invoices.currency') }})
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
            total = 0;
            $('.total').each(function () {
                total += parseFloat($(this).val());
            });
            $('#sub_total').val(total.toFixed(2));
            const k = $('#include_tax').prop('checked') ? 1 : -1;
            tax_sum = total / 100 * $('#tax').val();
            $('#tax_amount').val(tax_sum.toFixed(2));
            $('#total_amount').val((k * tax_sum + total).toFixed(2));
        }
    </script>
@stop