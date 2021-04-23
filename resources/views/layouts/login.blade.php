<html lang="en"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{url('/')}}/themes/assets/images/favicon.png" />
    <title>SPPOB</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{url('/')}}/themes/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <!-- page css -->
    <link href="{{url('/')}}/themes/css/colors/blue.css" id="theme" rel="stylesheet" />
    <!-- Custom CSS -->
    <link href="{{url('/')}}/themes/css/colors/blue.css" id="theme" rel="stylesheet" />
    <link id="style-css" rel="stylesheet" href="{{url('/')}}/themes/css/login.css">
    <link rel="stylesheet" href="{{url('/')}}/themes/css/animate.css">

    <script src="{{url('/')}}/themes/assets/plugins/jquery/jquery.min.js"></script>
    <script src="{{url('/')}}/themes/assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="{{url('/')}}/themes/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    
    <style>
        #generalLoading{
        position: fixed;
        z-index: 100;
        width: 100%;
        height: 100%;
        background-color: rgb(255, 255, 255);
        }
        .loadingImgCenter{
        position: absolute;
        margin: auto;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        }
        
        @media (min-width: 576px){
            .class-card{
                background-image: url(images/login.jpg);
            }
        }
        
        @media (max-width: 575px){
            .class-card{
                background-image: none;
            }
        }
    </style>
</head>

<body class="bg-body">
    <!--<div id="generalLoading">
        <img src="images/maintenance.jpg" width="100%" class="loadingImgCenter">
    </div>-->
    
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader" style="display: none;">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Sprint WebMessaging</p>
        </div>
    </div>
    
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <section id="wrapper" class="login-register login-sidebar b-l-d">
           @yield('content')
    </section>


<!-- ALERT -->
<div id="mAlertDialog" aria-hidden="true" role="dialog" tabindex="-1" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div id="mHeader" class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button id="mBtnOk" class="btn btn-primary" type="button" data-dismiss="modal">&nbsp;&nbsp;OK&nbsp;&nbsp;</button>
            </div>
        </div>
    </div>
</div>  

<!-- LOADER -->
<div id="mLoaderDialog" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content bg-black-rgba">
            <div class="modal-body bg-black-trans" style="text-align: center;">
                <p><span>Silahkan tunggu...</span></p>
            </div>  
        </div>
    </div>
</div>

</body>
</html>     