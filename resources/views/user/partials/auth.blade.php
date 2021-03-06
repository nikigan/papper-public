<div class="form-group">
    <label for="email">@lang('Email')</label>
    <input type="email"
           class="form-control input-solid"
           id="email"
           name="email"
           placeholder="@lang('Email')"
           required
           value="{{ $edit ? $user->email : '' }}">
</div>

<div class="form-group">
    <label for="username">@lang('Username')</label>
    <input id="username"
           autocapitalize="off"
           autocomplete="off"
           class="form-control input-solid"
           name="username"
           placeholder="(@lang('optional'))"
           type="text"
           value="{{ $edit ? $user->username : '' }}">
</div>

<div class="form-group">
    <label for="password">{{ $edit ? __("New Password") : __('Password') }}</label>
    <input type="password"
           class="form-control input-solid"
           id="password"
           name="password"
           autocomplete="off"
           required
           @if ($edit) placeholder="@lang("Leave field blank if you don't want to change it")" @endif>
</div>

<div class="form-group">
    <label for="password_confirmation">{{ $edit ? __("Confirm New Password") : __('Confirm Password') }}</label>
    <input type="password"
           class="form-control input-solid"
           id="password_confirmation"
           name="password_confirmation"
           @if ($edit) placeholder="@lang("Leave field blank if you don't want to change it")" @endif>
</div>

@if ($edit)
    <button type="submit" class="btn btn-primary mt-2" id="update-login-details-btn">
        <i class="fa fa-refresh"></i>
        @lang('Update Details')
    </button>
@endif
