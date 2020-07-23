<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="{{ asset('js/app.js') }}" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <!-- toaster -->
    <script src="{{ asset('js/toaster/jquery.toaster.js') }}" ></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            @if(Auth::user()->type == 1)
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown5" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" data-target="#navbarDropdown6" aria-controls="navbarDropdown5" aria-expanded="false" aria-label="Toggle navigation" >
                                        Departments <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" id="navbarDropdown6" class="dropdown-menu"  role="menu" aria-labelledby="navbarDropdown5" >
                                        <a class="dropdown-item" href="{{ route('department') }}"> {{ __('Manage') }}</a>
                                        <a class="dropdown-item" href="{{ route('department.heads') }}"> {{ __('Head list') }}</a>
                                        <a class="dropdown-item" href="{{ route('employee.add') }}"> {{ __('Add') }}</a>
                                    </div>
                                </li>

                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown1" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" data-target="#navbarDropdown2" aria-controls="navbarDropdown1" aria-expanded="false" aria-label="Toggle navigation" >
                                        Employees <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" id="navbarDropdown2" class="dropdown-menu"  role="menu" aria-labelledby="navbarDropdown1" >
                                        <a class="dropdown-item" href="{{ route('employees') }}"> {{ __('Manage') }}</a>
                                        <a class="dropdown-item" href="{{ route('employee.add') }}"> {{ __('Add') }}</a>
                                    </div>
                                </li>
                            @endif

                            @if(Auth::user()->type == 2)
                            <li class="nav-item">
                                    <a  class="nav-link" href="{{ route('department.reports') }}" >Employee Reports</a>
                                </li>
                            @endif

                            @if(Auth::user()->type == 3)
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown7" class="nav-link dropdown-toggle" href="#" role="button"  data-toggle="dropdown" data-target="#navbarDropdown8" aria-controls="navbarDropdown7" aria-expanded="false" aria-label="Toggle navigation"  >
                                        Report <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" id="navbarDropdown8" class="dropdown-menu"  role="menu" aria-labelledby="navbarDropdown7" >
                                        <a class="dropdown-item" href="{{ route('report') }}"> Add </a>
                                        <a class="dropdown-item" href="{{ route('report.list') }}"> List </a>
                                    </div>
                                </li>
                            @endif

                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown3" class="nav-link dropdown-toggle" href="#" role="button"  data-toggle="dropdown" data-target="#navbarDropdown4" aria-controls="navbarDropdown3" aria-expanded="false" aria-label="Toggle navigation"  >
                                        {{ Auth::user()->first_name.' '.Auth::user()->last_name }} <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" id="navbarDropdown4" class="dropdown-menu"  role="menu" aria-labelledby="navbarDropdown3" >
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
            @yield('content')
        </main>
    </div>
</body>
</html>
