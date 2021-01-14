<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="first_name">@lang('First Name')</label>
            <input type="text" class="form-control input-solid" id="first_name"
                   name="first_name" placeholder="@lang('First Name')" value="{{ $edit ? $user->first_name : '' }}">
        </div>
        <div class="form-group">
            <label for="last_name">@lang('Last Name')</label>
            <input type="text" class="form-control input-solid" id="last_name"
                   name="last_name" placeholder="@lang('Last Name')" value="{{ $edit ? $user->last_name : '' }}">
        </div>
        <div class="form-group">
            <label for="tax">@lang('Tax Percent')</label>
            <input type="number" step="0.1" min="0" max="100" class="form-control input-solid" id="tax"
                   name="tax_percent" placeholder="@lang('Tax Percent')" value="{{ $edit ? $user->tax_percent : '' }}">
        </div>
        <div class="form-group">
            <label for="social_security">@lang('Social Security')</label>
            <input type="number" step="0.1" min="0" class="form-control input-solid" id="social_security"
                   name="social_security" placeholder="@lang('Social Security')" value="{{ $edit ? $user->social_security : '' }}">
        </div>
        <div class="form-group">
            <label for="report_period">@lang('Report Period')</label>
            {!! Form::select('report_period', [1 => __('One Month'), 2 => __('Two Months')], $edit ? $user->report_period : 1, ['id' => 'report_period','class' => 'form-control input-solid']) !!}
        </div>
        <div class="form-group">
            <label for="mh_advances">@lang('Book of MH Advances')</label>
            <input type="text" class="form-control input-solid" id="mh_advances"
                   name="mh_advances" placeholder="@lang('Book of MH Advances')" value="{{ $edit ? $user->mh_advances : '' }}">
        </div>
        <div class="form-group">
            <label for="mh_deductions">@lang('Book of MH Deductions')</label>
            <input type="text" class="form-control input-solid" id="mh_deductions"
                   name="mh_deductions" placeholder="@lang('Book of MH Deductions')" value="{{ $edit ? $user->mh_deductions : '' }}">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="phone">@lang('Phone')</label>
            <input type="text" class="form-control input-solid" id="phone"
                   name="phone" placeholder="@lang('Phone')" value="{{ $edit ? $user->phone : '' }}">
        </div>
        <div class="form-group">
            <label for="address">@lang('Address')</label>
            <input type="text" class="form-control input-solid" id="address"
                   name="address" placeholder="@lang('Address')" value="{{ $edit ? $user->address : '' }}">
        </div>
        {{---
        <div class="form-group">
            <label for="address">@lang('Country')</label>
            {!! Form::select('country_id', $countries, $edit ? $user->country_id : '', ['class' => 'form-control input-solid']) !!}
        </div>
        ---}}
        <div class="form-group">
            <label for="passport">@lang('Passport')</label>
            <input type="text" class="form-control input-solid" id="passport"
                   name="passport" placeholder="@lang('Passport')" value="{{ $edit ? $user->passport : '' }}">
        </div>
        <div class="form-group">
            <label for="social_security_number">@lang('Social Security Number')</label>
            <input type="text" class="form-control input-solid" id="social_security_number"
                   name="social_security_number" placeholder="@lang('Social Security Number')" value="{{ $edit ? $user->social_security_number : '' }}">
        </div>
        <div class="form-group">
            <label for="portfolio">@lang('Portfolio of employed persons')</label>
            <input type="text" class="form-control input-solid" id="portfolio"
                   name="portfolio" placeholder="@lang('Portfolio of employed persons')" value="{{ $edit ? $user->portfolio : '' }}">
        </div>
        <div class="form-group">
            <label for="organization_type">@lang('Organization Type')</label>
            {!! Form::select('organization_type_id', $organization_types, $edit ? $user->organization_type->id : '',
            ['class' => 'form-control input-solid', 'id' => 'organization_type_id']) !!}
        </div>
        <div class="form-group">
            <label for="default_income_type_id">@lang('Default Income Type')</label>
            {!! Form::select('default_income_type_id', $income_types, $edit ? $user->default_income_type_id : 1,
            ['class' => 'form-control input-solid', 'id' => 'default_income_type_id']) !!}
        </div>
    </div>

    @if ($edit)
        <div class="col-md-12 mt-2">
            <button type="submit" class="btn btn-primary" id="update-details-btn">
                <i class="fa fa-refresh"></i>
                @lang('Update Details')
            </button>
        </div>
    @endif
</div>
