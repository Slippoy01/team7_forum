@extends('layout.auth')

@section('title', 'Register')

@section('content')

    <div class="register-box" style="margin: auto;width: 700px;">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="mb-0 text-center">
                    Register New User
                </h3>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Fill out with your data</p>
                @if ($errors->any())
                    <div class="alert alert-danger m-2">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                                <input id="name" type="text" placeholder="Your Full Name"
                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}" required autocomplete="name" autofocus>
                            </div>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <span class="fas fa-clock"></span>
                                    </div>
                                </div>
                                <input type="number" name="umur" min="1" class="form-control"
                                    placeholder="Your Age" class="form-control @error('umur') is-invalid @enderror"
                                    value="{{ old('umur') }}" required autocomplete="umur">
                            </div>
                            @error('umur')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <span class="fas fa-file"></span>
                                    </div>
                                </div>
                                <input type="text" name="biodata" class="form-control" placeholder="Fill your biodata"
                                    class="form-control @error('biodata') is-invalid @enderror" value="{{ old('biodata') }}"
                                    required autocomplete="biodata">
                            </div>
                            @error('biodata')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <span class="fas fa-map"></span>
                                    </div>
                                </div>
                                <textarea id="alamat" style="min-height: 90px;" placeholder="Fill your address"
                                    class="form-control @error('alamat') is-invalid @enderror" name="alamat" required>{{ old('alamat') }}</textarea>
                            </div>
                            @error('alamat')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-sm-6">

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                                <input id="email" type="email" placeholder="Fill your email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email">
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                                <input id="password" type="password" placeholder="Password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="new-password">
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                                <input id="password-confirm" type="password" placeholder="Re-enter password"
                                    class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>

                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <hr>
                <a href="{{ route('login') }}" class="text-center">Already have account</a>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
@endsection
