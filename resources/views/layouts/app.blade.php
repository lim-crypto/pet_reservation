<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.head')
    @yield('style')
</head>

<body>
    <div id="loading">
        <div id="loading-image">
        </div>
        <div id="loading-image2"></div>
    </div>
    <div id="app">
        @include('layouts.nav')
        <main>
            @yield('content')
        </main>
    </div>
    @include('layouts.script')
    @yield('script')
</body>

</html>