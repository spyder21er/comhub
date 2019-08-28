<!doctype html>
<html lang="en" class="h-100">
    <head>
        <title>AGrS - @yield('title')</title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <meta name="description" content="The local web app for Ateneo de Naga University Grade School">
        <!--
            *
            *
            *
            *
            *
            Thanks for trying to view this page source!

            You may want to collaborate with me developing this site. If you do, please contact me.
            *
            *
            *
            *
            *
        -->
        <meta name="author" content="Allen B. Mabana <spyder21er@gmail.com>">

        @include('partials.stylesheets')
        @yield('pagestyle')
    </head>
    <body class="h-100">
		@include('partials.navbar')
        @yield('content')
		@include('partials.scripts')
        @yield('pagescripts')
    </body>
</html>
