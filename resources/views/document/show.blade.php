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
                    <a class="page-link" href="{{route('documents.show', $prev->id)}}">@lang('Previous')</a>
                </li>
            @endif
            @if($next)
                <li class="page-item">
                    <a class="page-link" href="{{route('documents.show', $next->id)}}">@lang('Next')</a>
                </li>
            @endif
        </ul>
    </nav>
    <div class="card">
        <div class="card-body">
            <div class="row py-3">
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
                <div class="col-lg-6">
                    {!! Form::open(['route' => ['documents.update', 'document' => $document], 'files' => true, 'id' => 'document-form', 'method' => 'PUT']) !!}
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
                                <input type="date" max="{{ date('Y-m-d') }}"
                                       value="{{ \Carbon\Carbon::parse($document->document_date)->format('Y-m-d') }}"
                                       class="form-control" id="document_date" name="document_date" readonly
                                       required>
                            </div>
                        </div>
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
                            <div id="vendor-block" class="form-group"
                                 @if($document->document_type != 0) style="display:none;" @endif>
                                <label for="vendor">@lang("Vendor"):</label>
                                <select name='vendor_id' class="form-control" id="vendor" @nopermission('document.edit')
                                disabled @endpermission>
                                    @foreach($vendors as $vendor)
                                        <option
                                            value="{{$vendor->id}}"
                                            @isset($document->vendor)
                                            @if($document->vendor->id == $vendor->id) selected @endif
                                            @endisset>@lang($vendor->name)</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="customer-block" class="form-group"
                                 @if($document->document_type != 1) style="display:none;" @endif>
                                <label for="customer">@lang("Customer"):</label>
                                <select name='customer_id' class="form-control" id="customer">
                                    <option value="">@lang('N/A')</option>
                                    @foreach($customers as $customer)
                                        <option value="{{$customer->id}}"
                                                @isset($document->customer)
                                                @if($document->customer->id == $customer->id) selected @endif
                                            @endisset
                                        >@lang($customer->name)
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" id="expense_type_block"
                                 @if($document->document_type != 0) style="display:none;" @endif>
                                <label for="expense_type">@lang("Expense type"):</label>
                                <select name='expense_type_id' class="form-control" id="expense_type"
                                        @nopermission('document.edit') disabled @endpermission>
                                    <option value="">@lang('Other Expense')</option>
                                    @foreach($expense_types as $type)
                                        <option value="{{$type->id}}"
                                                @if($document->expense_type_id == $type->id) selected @endif
                                        >@lang($type->name)</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" id="income_type_block"
                                 @if($document->document_type != 1) style="display: none" @endif>
                                <label for="income_type">@lang("Income type"):</label>
                                <select name='income_type_id' class="form-control" id="income_type">
                                    <option value="">@lang('Other Income')</option>
                                    @foreach($income_types as $type)
                                        <option value="{{$type->id}}"
                                                @if($document->income_type_id == $type->id) selected @endif
                                        >@lang($type->name)</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
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
                                        <option value="">@lang('Other Type')</option>
                                        @foreach($document_types as $type)
                                            <option value="{{$type->id}}"
                                                    @if($document->document_type_id == $type->id) selected @endif>@lang($type->name)</option>
                                        @endforeach
                                    </select>
                                </div>
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
                    @if ($document->note)
                        <h6>@lang('Comments')</h6>
                        <div class="card">
                            <div class="card-body document-text__card">
                                <div class="document-text">
                                    {!! nl2br($document->note ?? '') !!}
                                </div>
                            </div>
                        </div>
                    @endif
                    @permission('document.edit')
                    <button type="submit" class="btn btn-primary">
                        @lang('Update Document')
                    </button>
                    @endpermission
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('assets/plugins/zoom-master/jquery.zoom.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            const img = document.querySelector('.document-image');

            const ratio = img.naturalHeight / img.naturalWidth;
            $('.document-image-zoom').zoom({
                url: '{{asset($document->file)}}',
                magnify: ratio
            });


            $('input[name=\"document_type\"]').change(function (event) {
                if (event.target.value == 0) {
                    $('#expense_type_block').show();
                    $('#document_type_block').hide();
                    $('#income_type_block').hide();
                } else {
                    $('#expense_type_block').hide();
                    $('#document_type_block').show();
                    $('#income_type_block').show();
                }
            })
        });
    </script>
@stop
