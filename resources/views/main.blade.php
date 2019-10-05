<!DOCTYPE html>
<html lang="en">
    @include('partials._head')
<body class="fix-header fix-sidebar card-no-border">
    <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <div class="main-wrapper">
        @include('partials._navbar')

        @include('partials._sidebar')

        <div class="page-wrapper">
            @yield('content')
        </div>
    </div>

    @include('partials._javascript')
    @yield('scripts')
</body>
</html>