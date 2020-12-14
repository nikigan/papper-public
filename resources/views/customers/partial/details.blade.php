<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="first_name">@lang('Name')</label>
            <input type="text" class="form-control input-solid" id="first_name"
                   name="name" placeholder="@lang('Name')" required value="{{ $edit ? $customer->first_name : old('name') }}">
        </div>
        <div class="form-group">
            <label for="email">@lang('Email')</label>
            <input type="email"
                   class="form-control input-solid"
                   id="email"
                   name="email"
                   placeholder="@lang('Email')"
                   required
                   value="{{ $edit ? $customer->email : old('email') }}">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="phone">@lang('Phone')</label>
            <input type="text" class="form-control input-solid" id="phone"
                   name="phone" placeholder="@lang('Phone')" required value="{{ $edit ? $customer->phone : old('phone') }}">
        </div>
        <div class="form-group">
            <label for="address">@lang('Address')</label>
            <input type="text" class="form-control input-solid" id="address"
                   name="address" placeholder="@lang('Address')" required value="{{ $edit ? $customer->address : old('address') }}">
        </div>
        <div class="form-group">
            <label for="address">@lang('VAT Number')</label>
            <input type="text" class="form-control input-solid" id="vat"
                   name="vat_number" placeholder="@lang('VAT Number')" required value="{{ $edit ? $customer->vat_number : old('vat_number') }}">
        </div>
    </div>
</div>
