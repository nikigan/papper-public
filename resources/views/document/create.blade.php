@extends('layouts.app')

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

    {!! Form::open(['route' => 'document.manualStore', 'files' => true, 'id' => 'document-form']) !!}
    <div class="card">
        <div class="card-body">
            <div class="form-row align-items-center">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="document_number">@lang('Document number')</label>
                        <input type="text" class="form-control" name="document_number" id="document_number" required value="{{old('document_number')}}">
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="sum">@lang('Total sum')</label>
                        <input type="text" class="form-control" name="sum" id="sum" required value="{{old('sum')}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="vat">@lang('VAT')</label>
                        <input type="text" class="form-control" name="vat" id="vat" required value="{{old('vat')}}">
                    </div>
                </div>
            </div>
            <div class="my-3">
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
            <div class="col-lg-6" id="drop-area">
                <label for="file" id="file-label">Upload file</label>
                <input type="file" accept="image/png, image/jpeg, .pdf" name="file" id="file">
                <div id="gallery"></div>
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
@stop

@section('scripts')
    <script>

        let dropArea = document.getElementById('drop-area');
        let fileInput = document.getElementById('file');
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false)
        });

        function preventDefaults (e) {
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
            reader.onloadend = function() {
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
    </script>
    @stop

