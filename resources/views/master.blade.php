<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials._head')
</head>

<body id="main-body" class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed text-sm">
    <div class="wrapper" id="app">
        {{-- Page Loader --}}
        @include('partials._page-loader')

        {{-- NavBar --}}
        @include('partials._navbar')

        {{-- Main Sidebar --}}
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            {{-- Brand Logo --}}
            @include('partials._brand-logo')

            {{-- Sidebar --}}
            <div class="sidebar">
                {{-- Sidebar Username and Role --}}
                @include('partials._sidebar-user-panel')

                {{-- Sidebar Menu --}}
                @include('partials._sidebar-menu')
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="content-wrapper">
            @yield('content')
            <vue-progress-bar></vue-progress-bar>
        </div>

        {{-- Footer --}}
        <footer class="main-footer">
            @include('partials._footer')
        </footer>
    </div>

    @auth
    <script>
        window.user = @json(auth()->user())
    </script>
    @endauth
    @yield('scripts')
    <script src="{{ mix('/js/app.js') }}"></script>
</body>

</html>