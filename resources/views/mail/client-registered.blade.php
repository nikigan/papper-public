@component('mail::message')

# @lang('Hello!')

@lang('You were just registered on :app website.', ['app' => setting('app_name')])

@lang('To login just visit the link below.')

@component('mail::button', ['url' => route('client.invite', ['user' => $user, 'token' => $token])])
    @lang('Login page')
@endcomponent

@lang('Regards'),<br>
{{ setting('app_name') }}

@endcomponent
