@extends('layouts.app')

@section('style')
<style>
    .container .title {
        font-size: 25px;
        font-weight: 500;
        position: relative;
    }

    .container .title::before {
        content: ""; 
        position: absolute;
        left: 0;
        bottom: 0;
        height: 3px;
        width: 25px;
        border-radius: 5px;
        background: linear-gradient(to right, #053718, #006022, #008d28, #00bb26, #2feb12);
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header border-bottom-0 pb-0">
                    <h3 class="title">{{ __('Register') }}</h3>
                    <hr>
                </div>

                <div class="card-body pt-0">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <label for="first_name" class="font-weight-normal">{{ __('First Name') }}</label>
                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                                <label for="last_name" class="font-weight-normal">{{ __('Last Name') }}</label>
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                                <label for="email" class="font-weight-normal">{{ __('E-Mail Address') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-6">

                                <label for="contact_number" class="font-weight-normal">{{ __('Contact Number') }}</label>
                                <input id="contact_number" type="text" class="form-control @error('contact_number') is-invalid @enderror" name="contact_number" value="{{ old('contact_number') }}" required autocomplete="contact_number" maxlength="11" >
                                @error('contact_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                                <label for="password" class="font-weight-normal">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                                <label for="password-confirm" class="font-weight-normal">{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <hr class="mt-4 mb-0">
                        <button type="submit" class="btn btn-success my-4" style="width: 100%;">{{ __('Register') }}</button>
                        <br>

                        <p class="text-center mb-2"> Doesn't have an account yet? Register <a href="login">here!</a></p>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection