@extends('layouts.app')

@section('page-title', 'Uploaded documents')
@section('page-heading', 'Uploaded documents')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('documents.index') }}">@lang('Documents')</a>
    </li>
    <li class="breadcrumb-item active">
        <a>Document {{$document->id}}</a>
    </li>
@stop

@section('content')
    @include('partials.messages')
    {{-- @if(auth()->user()->hasPermission('document.edit'))
         <div class="row my-3">
             <form class="d-flex" method="POST" action="{{route('documents.update', $document)}}">
                 @method("PUT")
                 @csrf
                 {!! Form::select('status', $statuses,  $document->status,
                     ['class' => 'form-control input-solid', 'id' => 'status']) !!}
                 --}}{{--            <select name="status" id="status" class="form-control input-solid"></select>--}}{{--
                 <button type="submit" class="btn btn-primary flex-shrink-0 mx-3" id="update-details-btn">
                     <i class="fa fa-refresh"></i>
                     @lang('Update Details')
                 </button>
             </form>

             <div class="col-md-2 mt-2 mt-md-0">
                 --}}{{--{!!
                     Form::select(
                         'status',
                         $statuses,
                         Request::get('status'),
                         ['id' => 'status', 'class' => 'form-control input-solid']
                     )
                 !!}--}}{{--
             </div>
         </div>
     @endif--}}
    <div class="card">
        <div class="card-body">
            <div class="row py-3">
                <div class="col-lg-6 text-center">
                    @isset($document->file)
                        @if($isPdf)
                            <a href="{{ asset($document->file) }}">PDF file</a>
                        @else
                            <img class="img-fluid document-image" src="{{ asset($document->file) }}"
                                 alt="Document {{ $document->id }}">
                        @endif
                    @endisset
                </div>
                <div class="col-lg-6">
                    {!! Form::open(['route' => ['documents.update', 'document' => $document], 'files' => true, 'id' => 'document-form', 'method' => 'PUT']) !!}
                    <div class="form-row align-items-center">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="document_number">@lang('Document number')</label>
                                <input type="text" class="form-control" name="document_number" id="document_number"
                                       required value="{{old('document_number', $document->document_number)}}"
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
                                       class="form-control" id="document_date" name="document_date" readonly required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="currency">@lang("Currency"):</label>
                                <select name='currency_id' class="form-control" id="currency" disabled>
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
                            <div class="form-group">
                                <label for="vendor">@lang("Vendor"):</label>
                                <select name='vendor_id' class="form-control" id="vendor" disabled>
                                    @foreach($vendors as $vendor)
                                        <option
                                            value="{{$vendor->id}}"
                                            @isset($document->vendor)
                                            @if($document->vendor->id == $vendor->id) selected @endif
                                            @endisset>@lang($vendor->name)</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="my-3">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="document_type_0" name="document_type"
                                   class="custom-control-input"
                                   value="0"
                                   readonly
                                   @unless($document->document_type) checked @endunless"
                            @nopermission('document.edit') disabled @endpermission>
                            <label class="custom-control-label" for="document_type_0">@lang('Expense')</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="document_type_1" name="document_type"
                                   class="custom-control-input"
                                   value="1"
                                   readonly
                                   @if($document->document_type) checked @endif
                                   @nopermission('document.edit') disabled @endpermission>
                            <label class="custom-control-label" for="document_type_1">@lang('Income')</label>
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
                    <div class="card">
                        <div class="card-body document-text__card">
                            <div class="document-text">
                                {!! nl2br($document->document_text ?? '') !!}
                            </div>
                        </div>
                    </div>
                    @endpermission
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
