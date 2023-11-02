<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link href="https://unpkg.com/vue-loading-overlay@3.4.2/dist/vue-loading.css" rel="stylesheet" type="text/css">
    @yield('vue-scripts')
    @vite(['resources/sass/app.scss'])
    @yield('styles')
    <!-- Scripts -->

</head>
<body style="background-color: #e3ecff">
<div id="app">

    <main>
        @yield('content')
    </main>
</div>

@yield('scripts')
</body>
</html>
