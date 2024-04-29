@extends('layout.auth')

@section('title', 'Login')

@section('content')
    <div class="login-box" style="margin: auto;">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="logo text-center my-3">
                <img src="{{ asset('images/team7.jpeg') }}" alt="Sanbercode" style="width: 100px;">
            </div>

            <div class="card-header text-center">
                <span class="h1"><b>Team 7</b> - Forum</span>

                <h4>
                    {{ __('Verify Your Email Address') }}
                </h4>
            </div>

            <div class="card-body">
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif

                {{ __('Before proceeding, please check your email for a verification link.') }}
                {{ __('If you did not receive the email') }},
                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit"
                        class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
@endsection
