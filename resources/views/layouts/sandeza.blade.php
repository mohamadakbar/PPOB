<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="Kerehore">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{url('/')}}/themes/assets/images/favicon.png" />
    <title>SPPOB</title>

    <!-- CSS -->
    <link href="{{url('/')}}/themes/assets/plugins/jqueryui/jquery-ui.min.css" rel="stylesheet" />
    <link href="{{url('/')}}/themes/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{url('/')}}/themes/assets/plugins/bootstrap-switch/bootstrap-switch.min.css" rel="stylesheet">
    <link href="{{url('/')}}/themes/assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
    <link href="{{url('/')}}/themes/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" />
    <link href="{{url('/')}}/themes/assets/plugins/bootstrap-table/dist/bootstrap-table.min.css" rel="stylesheet" />
    <link href="{{url('/')}}/themes/assets/plugins/datatables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link href="{{url('/')}}/themes/assets/plugins/toast-master/css/jquery.toast.css" rel="stylesheet">
    <link href="{{url('/')}}/themes/assets/plugins/dropify/dist/css/dropify.min.css" rel="stylesheet">
    <link href="{{url('/')}}/themes/assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" />
    <link href="{{url('/')}}/themes/css/style.css" rel="stylesheet" />
    <link href="{{url('/')}}/datatables/select.dataTables.min.css" rel="stylesheet" />
    <link href="{{url('/')}}/fontawesome/css/fontawesome.min.css" rel="stylesheet" />
    <link href="{{url('/')}}/fontawesome/css/regular.min.css" rel="stylesheet" />

    <!-- Custom CSS -->
    <link href="{{url('/')}}/themes/css/chosen.css" rel="stylesheet" />
    <link href="{{url('/')}}/themes/css/mahta.css" rel="stylesheet" />

    <!-- You can change the theme colors from here -->
    <link href="{{url('/')}}/themes/css/colors/blue.css" id="theme" rel="stylesheet" />

    <script src="{{url('/')}}/themes/assets/plugins/jquery/jquery.min.js"></script>
    <script src="{{url('/')}}/themes/assets/plugins/jquery/jquery.mask.min.js"></script>
    <script src="{{url('/')}}/themes/assets/plugins/jqueryui/jquery-ui.min.js"></script>
    <script src="{{url('/')}}/themes/assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="{{url('/')}}/themes/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="{{url('/')}}/themes/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="{{url('/')}}/themes/assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
    <script src="{{url('/')}}/themes/assets/plugins/bootstrap-table/dist/bootstrap-table.min.js"></script>
    <script src="{{url('/')}}/themes/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="{{url('/')}}/themes/assets/plugins/bootstrap-switch/bootstrap-switch.min.js"></script>
    <script src="{{url('/')}}/themes/assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
    <script src="{{url('/')}}/themes/assets/plugins/sweetalert/sweetalert.min.js"></script>
    <script src="{{url('/')}}/themes/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{url('/')}}/themes/assets/plugins/toast-master/js/jquery.toast.js"></script>
    <script src="{{url('/')}}/themes/assets/plugins/numeral-js/min/numeral.min.js"></script>
    <script src="{{url('/')}}/themes/js/jquery.slimscroll.js"></script>
    <script src="{{url('/')}}/themes/js/sidebarmenu.js"></script>
    <script src="{{url('/')}}/themes/js/custom.min.js"></script>
    <script src="{{url('/')}}/themes/js/waves.js"></script>
    <script src="{{url('/')}}/themes/js/chosen.jquery.js"></script>
    <script src="/js/multiple_input.js" type="text/javascript"/></script>

</head>

<body class="fix-header fix-sidebar logo-center">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <div id="main-wrapper">
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header">
                    <a class="navbar-brand" href="/">
                        <span style="color: #ffffff;">
                            {{$title}}
                        </span> </a>
                </div>
                <div class="navbar-collapse">
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                    </ul>
                    <ul class="navbar-nav my-lg-0">
						<li class="nav-item" style="border-right: 1px solid #afafaf;border-left: 1px solid #afafaf;"> 
							<a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="{{ route('deposit.index') }}" >Balance: Rp. 100.000.000 </a>
						</li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }} <span></span></a>
                            <div class="dropdown-menu dropdown-menu-right scale-up">
                                <ul class="dropdown-user">
                                    <li style="padding: 12px;font-size:12px;"> 
										<div style="border-bottom: 2px solid #cacaca;font-weight: bold;padding-bottom: 6px;">Detail Deposit</div>
										<div class="row p-t-10">
											<div class="col-md-4">Mitracomm</div>
											<div class="col-md-8">: Rp 40.000.000</div>
										</div>
										<div class="row">
											<div class="col-md-4">Prismalink</div>
											<div class="col-md-8">: Rp 30.000.000</div>
										</div>
										<div class="row">
											<div class="col-md-4">Bima Sakti</div>
											<div class="col-md-8">: Rp 30.000.000</div>
										</div>
                                    </li>
                                    <li style="font-size:12px;text-align:right">
                                        <a href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            <i class="fa fa-power-off"></i> {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        @section('sidebar')
       <div class="wrapper">
            <!-- Sidebar  -->
            <nav id="sidebar">
                <div class="sidebar-header">
                    <h2>
                        <a href="{{ url('/') }}" style="color: #fff;">
                            PPOB
                        </a>
                    </h2>
                </div>

                {!! $menu !!}

                
            </nav>

            <!-- Page Content  -->
            <div id="content" style="">
                <div class="row page-titles col-md-5 " style="background: #fff0;">
                    <div class=" align-self-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item menu2"> <a class ="name_Nav" >{{$title}}</a></li>
                            @isset($gen)
                                <li class='breadcrumb-item'>{{ $gen}}</li>
                            @endisset
                            @isset($subgen1)
                                <li class='breadcrumb-item'>{{ $subgen1}}</li>
                            @endisset
                            @isset($subgen2)
                                <li class='breadcrumb-item'>{{ $subgen2}}</li>
                            @endisset
                        </ol>
                    </div>
                </div>
                <div class="container-fluid">
                    @yield('content')
                </div>
				<br>
                <footer class="footer" style="position:fixed;"> Â© 2020 Copyright by PT Sprint Asia Technology</footer>
            </div>
        </div>

        @show
    </div>
    @section('custom_script')

        <script type="text/javascript">
            $(document).ready(function () {

                $('#sidebarCollapse').on('click', function () {
                    $('#sidebar, #content').toggleClass('active');
                    $('.collapse.in').toggleClass('in');
                    $('a[aria-expanded=true]').attr('aria-expanded', 'false');
                });
                $('#sidebar li.active').parents('li').children('a').trigger('click');
            });
        </script>
    @show
</body>

</html>