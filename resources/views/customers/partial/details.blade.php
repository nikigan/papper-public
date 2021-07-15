<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="customer_first_name">@lang('Name')</label>
            <input type="text" class="form-control input-solid" id="customer_first_name"
                   name="name" placeholder="@lang('Name')" value="{{ $edit ? $customer->name : old('name') }}">
        </div>
        <div class="form-group">
            <label for="customer_email">@lang('Email')</label>
            <input type="email"
                   class="form-control input-solid"
                   id="customer_email"
                   name="email"
                   placeholder="@lang('Email')"
                   value="{{ $edit ? $customer->email : old('email') }}">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="customer_phone">@lang('Phone')</label>
            <input type="text" class="form-control input-solid" id="customer_phone"
                   name="phone" placeholder="@lang('Phone')" value="{{ $edit ? $customer->phone : old('phone') }}">
        </div>
        <div class="form-group">
            <label for="customer_address">@lang('Address')</label>
            <input type="text" class="form-control input-solid" id="customer_address"
                   name="address" placeholder="@lang('Address')" value="{{ $edit ? $customer->address : old('address') }}">
        </div>
        <div class="form-group">
            <label for="customer_vat_number">@lang('VAT Number')</label>
            <input type="text" class="form-control input-solid" id="customer_vat_number"
                   name="vat_number" placeholder="@lang('VAT Number')"
                   value="{{ $edit ? $customer->vat_number : old('vat_number') }}">
        </div>
        @if(!isset($client) && (auth()->user()->hasRole('Auditor') || auth()->user()->hasRole('Accountant')) && isset($clients))
            <div class="form-group">
                <label for="client_id">@lang('Client')</label>
                {!! Form::select('client_id', $clients, old('client_id', $selected_client ?? $customer->creator_id ?? null),
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
