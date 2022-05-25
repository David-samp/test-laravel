<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Test Laravel</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#ffffff">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
        integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
        crossorigin="anonymous" />

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    @yield('third_party_stylesheets')

    @stack('page_css')
</head>

<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">
    <div class="wrapper">
        <!-- Main Header -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav" id="toggleBtn">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-angle-double-right"></i></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown user-menu d-flex align-items-center hover-nav">
                <a href="#" class="nav-link dropdown hover-nav" id="dropdownUserLink" data-toggle="dropdown"aria-haspopup="true" aria-expanded="false" style="color:#444;">
                    @if(!is_null(Auth::user()->first_name) && !is_null(Auth::user()->last_name) )
                        {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
                    @else
                        {{ Auth::user()->email}}
                    @endif
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="dropdownUserLink">
                        <li class="user-header bg-primary">
                            <p>
                                {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
                                <small>
                                    {{ __('texts.membersince') }}
                                    {{ Auth::user()->created_at }}
                                </small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <a href="#" class="btn btn-outline-danger w-100"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-fw fa-power-off"></i>&nbsp;{{ __('buttons.signout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
                <li class="navbar navbar-light bg-white hover-nav">
                    <a class="dropdown" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="{{ asset('img/'.session('lang').'.png')}}" style="width:20px;" alt="flag"/>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item dropdown-item-lang" href="{{ route('changelang', ['lang' => 'fr']) }}">&nbsp;Francais</a>
                        <a class="dropdown-item dropdown-item-lang" href="{{ route('changelang', ['lang' => 'en']) }}">&nbsp;English</a>
                    </div>
                </li>
            </ul>
        </nav>

        <!-- Left side column. contains the logo and sidebar -->
        @include('layouts.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper px-4 py-2">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            @yield('backButton')
                        </div>
                        <div class="col-sm-6 d-none d-sm-block">
                            <x-breadcrumb :breadcrumb="$breadcrumb" />
                        </div>
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid" id="mainContent">
                    @yield('content')
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->


    </div>

    <div class="modal fade" id="modalConfirmation" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body" id="modalConfirmationBody"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btnConfirmYes">{{ __('labels.yes') }}</button>
                    <button type="button" class="btn btn-danger" id="btnConfirmNo">{{ __('labels.no') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalChangePwd" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('changePassword') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group">
                                <label>{{ __('labels.newpassword') }}</label>
                                <input type="text" name="newpwd" minlength="8" class="form-control" require />
                            </div>
                        </row>
                        <input type="hidden" id="changePwdUserId" name="userId" value="{{ Auth::user()->id }}" />
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" >{{ __('labels.save') }}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('labels.cancel') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ asset('js/localtimer.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#toggleBtn li a').click(function() {
                $(this).find('i').toggleClass('fa-angle-double-left fa-angle-double-right')
            });
        });

        function confirm(message, callBackOnYes, callBackOnNo) {
            $('#modalConfirmationBody').html(message);
            $('#btnConfirmYes').on('click', callBackOnYes);
            $('#btnConfirmNo').on('click', callBackOnNo);
            $('#modalConfirmation').modal('show');
        }
    </script>


    @yield('third_party_scripts')
    @stack('page_scripts')
    @include('layouts.toastr');
</body>

</html>
