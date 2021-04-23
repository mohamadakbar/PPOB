<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('master.name', 'SPPOB') }}</title>
 
  <link rel="stylesheet" href="/css/bootstrap.min.css" />
  <link rel="stylesheet" href="/font-awesome/4.5.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="/css/fonts.googleapis.com.css" />
  <link rel="stylesheet" href="/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
  <link rel="stylesheet" href="/css/ace-skins.min.css" />
  <link rel="stylesheet" href="/css/ace-rtl.min.css" />
  <link rel="stylesheet" type="text/css" href="/datatables/DataTables-1.10.20/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="/css/ace-blue.css" class="ace-main-stylesheet" id="main-ace-style" />
  <script src="/js/jquery-2.1.4.min.js"></script><script src="/js/bootstrap.min.js"></script>

  <!-- page specific plugin scripts -->

  <!--[if lte IE 8]>
    <script src="/js/excanvas.min.js"></script>
  <![endif]-->
  <script src="/js/jquery-ui.custom.min.js"></script>
  <script src="/js/jquery.ui.touch-punch.min.js"></script>
  <script src="/js/jquery.easypiechart.min.js"></script>
  <script src="/js/jquery.sparkline.index.min.js"></script>
  <script src="/js/jquery.flot.min.js"></script>
  <script src="/js/jquery.flot.pie.min.js"></script>
  <script src="/js/jquery.flot.resize.min.js"></script>

  <!-- ace scripts -->
  <script src="/js/ace-elements.min.js"></script>
  <script src="/js/ace.min.js"></script>
  <script src="/js/ace-extra.min.js"></script>
  <script src="/js/selectize.js" type="text/javascript"/></script>
  <script src="/datatables/DataTables-1.10.20/js/jquery.dataTables.min.js" type="text/javascript"/></script>
  <script src="/datatables/DataTables-1.10.20/js/dataTables.bootstrap4.min.js" type="text/javascript"/></script>
  <script src="/js/modal.js" type="text/javascript"/></script>
  <script src="/js/multiple_input.js" type="text/javascript"/></script>


</head>
<body class="no-skin">
@if (Auth::check())
  @include('partials.header')
@endif
<div class="main-container" id="main-container">
  @include('partials.sidebar')
  <div class="main-content"> 
    <div class="main-content-inner">
      @yield('content') 
    </div>
  </div>
 @include('partials.footer')
</div>


  <script type="text/javascript">
    if('ontouchstart' in document.documentElement) document.write("<script src='/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
  </script>

</body>