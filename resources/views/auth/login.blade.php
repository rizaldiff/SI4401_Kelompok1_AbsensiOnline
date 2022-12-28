@extends('layout.auth')
@section('title', 'Login Absensi')
@section('content')
    <div class="container auth-card">
        <div class="row justify-content-center">
            <div class="col-lg-6 align-self-center">
                <div class="text-center my-2">
                    <img src="{{ asset(config('settings.logo_instansi')) }}" class="card-img" style="width:50%;">
                    <h3 class="text-white">{{ config('settings.nama_app_absensi') }}</h3>
                    <h4 id="date-and-clock mt-3">
                        <h5 class="text-white" id="clocknow"></h5>
                        <h5 class="text-white" id="datenow"></h5>
                    </h4>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow-lg border-0 rounded-lg p-2">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light">Login</h3>
                    </div>
                    <div class="card-body">
                        @error('login')
                            <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @enderror
                        <form action="{{ route('login') }}" method="post" accept-charset="utf-8">
                            @csrf
                            <div class="form-group row">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><span class="fas fa-user"></span>
                                        </div>
                                    </div>
                                    <input class="form-control py-4" name="username" id="username" type="text"
                                        placeholder="Enter username" value="{{ old('username') }}" />
                                </div>
                                @error('username')
                                    <span class="text text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <div class="input-group" id="show_hide_password">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><span class="fas fa-key"></span></div>
                                    </div>
                                    <input class="form-control py-4" name="password" id="password" type="password"
                                        placeholder="Enter password" />
                                    <div class="input-group-append">
                                        <button class="input-group-text" type="button" tabindex="-1"><span
                                                class="fas fa-eye-slash" aria-hidden="false"></span></button>
                                    </div>
                                </div>
                                @error('password')
                                    <span class="text text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox"><input class="custom-control-input"
                                        id="remember_me" type="checkbox" name="remember_me" /><label
                                        class="custom-control-label" for="remember_me">Remember Me</label></div>
                            </div>
                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                <button type="submit" class="btn btn-primary"><span
                                        class="fas fa-fw fa-sign-in-alt mr-2"></span>Login</button>
                            </div>
                        </form>
                        <hr>
                        <div class="container">
                            <div class="d-flex align-items-center justify-content-center small">
                                <div class="text-muted">Copyright &copy; 2022<a href="{{ config('app.url') }}"
                                        class="ml-1">{{ config('settings.nama_app_absensi') }}</a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
