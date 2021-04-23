<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'SPPOB') }}</title>

  <!-- Scripts -->
  <script src="/fontawesome/js/fontawesome.min.js" type="text/javascript"/></script>
  <script src="/js/jquery-3.4.1.min.js" type="text/javascript"/></script>
  <script src="/js/bootstrap.min.js" type="text/javascript"/></script>
  <script src="/js/custom.js" type="text/javascript"/></script>
  <script src="/datatables/DataTables-1.10.20/js/jquery.dataTables.min.js" type="text/javascript"/></script>
  <script src="/datatables/DataTables-1.10.20/js/dataTables.bootstrap4.min.js" type="text/javascript"/></script>
  <script src="/js/selectize.js" type="text/javascript"/></script>
  <script src="/js/modal.js" type="text/javascript"/></script>
  <script src="/js/multiple_input.js" type="text/javascript"/></script>

  <!-- Styles -->
  <link rel="stylesheet" type="text/css" href="/fontawesome/css/all.css">
  <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="/datatables/DataTables-1.10.20/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" type="text/css" href="/css/selectize.css">
  <link rel="stylesheet" type="text/css" href="/css/selectize.bootstrap3.css">

</head>
<body>
    <div id="app">
        <!-- <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm"> -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'SPPOB') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                      @if (Auth::check())
                      <li class="nav-item">
                          <a class="nav-link" href="{{ route('home') }}">{{ __('Dashboard') }}</a>
                      </li>
                      @endif
                      @role('Administrator')
                      <li class="nav-item">
                          <a class="nav-link" href="{{ route('groupuser.index') }}">{{ __('User Groups') }}</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="{{ route('manusers.index') }}">{{ __('Users') }}</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="{{ route('roleusers.index') }}">{{ __('Role Users') }}</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="{{ route('client.index') }}">{{ __('Clients') }}</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="{{ route('prodtype.index') }}">{{ __('Product Types') }}</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="{{ route('prodcat.index') }}">{{ __('Product Categories') }}</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="{{ route('prodvend.index') }}">{{ __('Vendors') }}</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="{{ route('product.index') }}">{{ __('Products') }}</a>
                      </li>
                      @endrole
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            <!-- @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif -->
                        @else
							<li class="nav-item">
								<a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" >Balance: Rp. 100.000.000 <span></span></a>
							</li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @include('layouts._flash')
            @yield('content')
        </main>
    </div>
</body>
@yield('scripts')
</html>
