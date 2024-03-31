@extends('layouts.auth')

@section('htmlheader_title')
    Register
@endsection

@section('content')
    <div class="register-box">
        <div class="register-logo">
            <a href="{{ route('login.show') }}"><b>Syscore</b></a>
        </div>
        <div class="card">
            <div class="card-body register-card-body">
                <p class="login-box-msg">Register</p>
                <form action="{{ route('register.perform') }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="First name" name="first_name">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>

                    </div>
                    @if ($errors->has('first_name'))
                        <span class="text-danger text-left">{{ $errors->first('first_name') }}</span>
                    @endif
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Last name" name="last_name">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    @if ($errors->has('last_name'))
                        <span class="text-danger text-left">{{ $errors->first('last_name') }}</span>
                    @endif
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" name="email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    @if ($errors->has('email'))
                        <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                    @endif
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password" name="password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>

                    </div>
                    @if ($errors->has('password'))
                        <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                    @endif
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Retype password" name="confirm_password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>

                    </div>
                    @if ($errors->has('confirm_password'))
                        <span class="text-danger text-left">{{ $errors->first('confirm_password') }}</span>
                    @endif
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </div>

                    </div>
                </form>
                <a href="{{ route('login.show') }}" class="text-center">Already Registered? Login</a>
            </div>

        </div>
    </div>
@endsection
