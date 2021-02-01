<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="first_name">@lang('Name')</label>
            <input type="text" class="form-control input-solid" id="first_name"
                   name="name" placeholder="@lang('Name')" value="{{ $edit ? $customer->name : old('name') }}">
        </div>
        <div class="form-group">
            <label for="email">@lang('Email')</label>
            <input type="email"
                   class="form-control input-solid"
                   id="email"
                   name="email"
                   placeholder="@lang('Email')"
                   value="{{ $edit ? $customer->email : old('email') }}">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="phone">@lang('Phone')</label>
            <input type="text" class="form-control input-solid" id="phone"
                   name="phone" placeholder="@lang('Phone')" value="{{ $edit ? $customer->phone : old('phone') }}">
        </div>
        <div class="form-group">
            <label for="address">@lang('Address')</label>
            <input type="text" class="form-control input-solid" id="address"
                   name="address" placeholder="@lang('Address')" value="{{ $edit ? $customer->address : old('address') }}">
        </div>
        <div class="form-group">
            <label for="address">@lang('VAT Number')</label>
            <input type="text" class="form-control input-solid" id="vat"
                   name="vat_number" placeholder="@lang('VAT Number')" value="{{ $edit ? $customer->vat_number : old('vat_number') }}">
        </div>
        @if(auth()->user()->hasRole('Auditor') || auth()->user()->hasRole('Accountant'))
            <div class="form-group">
                <label for="client_id">@lang('Client')</label>
                {!! Form::select('client_id', $clients, old('client_id', $selected_client ?? $customer->creator_id ?? null),
                ['class' => 'form-control input-solid', 'id' => 'client_id']) !!}
            </div>
        @endif
    </div>
</div>
