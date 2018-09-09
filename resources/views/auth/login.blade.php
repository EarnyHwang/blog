@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center title">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-8">
                                <input id="email" type="email" class="title form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-8">
                                <input id="password" type="password" class="title form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-4 text-md-right col-form-label">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
							
                            <div class="col-md-8 text-md-right col-form-label">
                                <button type="submit" class="btn btn-outline-success title">
                                    {{ __('Login') }}
                                </button>
                            </div>
							
                        </div>

                        <!--div class="form-group row">
                            <div class="col-md-3 offset-md-9">
                                <button type="submit" class="btn btn-outline-success title">
                                    {{ __('Login') }}
                                </button>
                            </div>
						</div-->
						<!--div class="form-group row justify-content-md-center">
							<div class="col-md-6 title" >
                                <a href="{{ route('password.request') }}">Forgot Your Password?</a>
							</div>
                        </div-->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
