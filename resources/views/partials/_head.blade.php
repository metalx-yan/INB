<head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
        <title>@yield('title', 'Welcome to Application')</title>
        <!-- Bootstrap Core CSS -->
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        {{-- <link href=" {{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }} " rel="stylesheet"> --}}
        <!-- chartist CSS -->
        
        <link rel="stylesheet" href="{{ asset('css/css/jquery.dataTables.min.css') }}">
        <link href="{{ asset('assets/plugins/chartist-js/dist/chartist.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/plugins/chartist-js/dist/chartist-init.css') }}" rel="stylesheet">
        <link href="{{asset('assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css')}}" rel="stylesheet">
        <link href="{{ asset('assets/plugins/css-chart/css-chart.css') }}" rel="stylesheet">
        <!-- Custom CSS -->
        {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"> --}}
        {{-- <link rel="stylesheet" href="{{ asset('css/css/buttons.dataTables.min.css') }}"> --}}
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <!-- You can change the theme colors from here -->
        <link href="{{ asset('css/colors/blue.css') }}" id="theme" rel="stylesheet">

        {{-- <link href="{{ asset('css/material.css') }}" id="theme" rel="stylesheet"> --}}

        @yield('link')
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
        {{-- <link rel="stylesheet" href=" {{ asset('css/multiselect.css') }} ">
        <script src=" {{ asset('js/multiselect.min.js') }} "></script> --}}
        <script>
        (function(i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function() {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o), m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
        ga('create', 'UA-85622565-1', 'auto');
        ga('send', 'pageview');
        </script>
    </head>