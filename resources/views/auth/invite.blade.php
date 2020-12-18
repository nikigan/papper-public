@extends('layouts.auth')

@section('page-title', __("You have been invited!"))

@section('content')
    <div class="col-md-8 col-lg-6 col-xl-5 mx-auto my-10p">
        <div class="text-center">
            <img src="{{ url('assets/img/vanguard-logo.svg') }}" alt="{{ setting('app_name') }}" height="50">
        </div>

        <div class="card mt-5">
            <div class="card-body">
                {{--<h5 class="card-title text-center mt-4 mb-2 text-uppercase">
                    @lang('Choose Your Password')
                </h5>--}}
                @include('partials.messages')

                <form role="form" action="{{ route('client.invite.update', ['user' => $user]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{$token}}">

                    @unless($accountant)
                    <div class="form-group">
                        <label for="organization_type">@lang('Organization Type')</label>
                        {!! Form::select('organization_type_id', $organization_types, '',
                        ['class' => 'form-control input-solid', 'id' => 'organization_type_id']) !!}
                    </div>
                    @endunless
                    <div class="form-group">
                        <label for="password" class="sr-only">@lang('New Password')</label>
                        <input type="password"
                               name="password"
                               id="password"
                               class="form-control input-solid"
                               placeholder="@lang('Password')">
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="sr-only">@lang('Confirm Password')</label>
                        <input type="password"
                               name="password_confirmation"
                               id="password_confirmation"
                               class="form-control input-solid"
                               placeholder="@lang('Confirm Password')">
                    </div>

                    <div class="form-group mt-5">
                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                            @lang('Change password')
                        </button>
                    </div>
                </form>

            </div>
        </div>
@stop

