<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Test Laravel</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
        integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
        crossorigin="anonymous" />

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo" style="margin-right: 20px">
        </div>
        <!-- /.login-logo -->

        <!-- /.login-box-body -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">{{__('texts.signintostart')}}</p>

                <form method="post" action="{{ url('/login') }}">
                    @csrf

                    <div class="input-group mb-3">
                        <input type="text" name="username" value="{{ old('username') }}" placeholder="{{__('labels.email')}}"
                            class="form-control @error('username') is-invalid @enderror">
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-user"></span></div>
                        </div>
                        @error('username')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" name="password" placeholder="{{__('labels.password')}}"
                            class="form-control @error('password') is-invalid @enderror">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @error('password')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror

                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">{{__('buttons.signin')}}</button>
                        </div>
                    </div>
                </form>
                <p class="mt-3 mb-1">
                    <a href="{{ route('password.request') }}">J'ai oublié mon mot de passe</a>
                </p>
                <p class="mt-3 mb-1">
                    <a href="{{ route('register') }}">Je n'ai pas de compte</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <script src="{{ mix('js/app.js') }}" defer></script>

</body>

</html>
