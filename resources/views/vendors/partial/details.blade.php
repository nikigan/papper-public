<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="vendor_first_name">@lang('Name')</label>
            <input type="text" class="form-control input-solid" id="vendor_first_name"
                   name="name" placeholder="@lang('Name')" value="{{ $edit ? $vendor->name : old('name') }}">
        </div>
        <div class="form-group">
            <label for="vendor_email">@lang('Email')</label>
            <input type="email"
                   class="form-control input-solid"
                   id="vendor_email"
                   name="email"
                   placeholder="@lang('Email')"
                   value="{{ $edit ? $vendor->email : old('email') }}">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="vendor_phone">@lang('Phone')</label>
            <input type="text" class="form-control input-solid" id="vendor_phone"
                   name="phone" placeholder="@lang('Phone')"
                   value="{{ $edit ? $vendor->phone : old('phone') }}">
        </div>
        <div class="form-group">
            <label for="vendor_address">@lang('Address')</label>
            <input type="text" class="form-control input-solid" id="vendor_address"
                   name="address" placeholder="@lang('Address')"
                   value="{{ $edit ? $vendor->address : old('address') }}">
        </div>
        <div class="form-group">
            <label for="vendor_vat_number">@lang('VAT Number')</label>
            <input type="text" class="form-control input-solid" id="vendor_vat_number"
                   name="vat_number" placeholder="@lang('VAT Number')"
                   value="{{ $edit ? $vendor->vat_number : old('vat_number') }}">
        </div>
        <div class="form-group">
            <label for="default_expense_type_id">@lang('Default expense type')</label>
            {!! Form::select('default_expense_type_id', $expense_types->pluck('name', 'id'), old('default_expense_type_id', $vendor->default_expense_type_id ?? null),
            ['class' => 'form-control input-solid', 'id' => 'default_expense_type_id']) !!}
        </div>
        @if(!isset($client) && (auth()->user()->hasRole('Auditor') || auth()->user()->hasRole('Accountant')) && isset($clients))
            <div class="form-group">
                <label for="client_id">@lang('Client')</label>
                {!! Form::select('client_id', $clients, old('client_id', $selected_client ?? $vendor->creator_id ?? null),
                ['class' => 'form-control input-solid', 'id' => 'client_id']) !!}
            </div>
        @endif
        @isset($client)
            <input type="hidden" name="client_id" value="{{$client->id}}">
        @else
            <input type="hidden" name="client_id" value="{{isset($selected_client) ? $selected_client->id : null}}">
        @endif
    </div>
</div>
