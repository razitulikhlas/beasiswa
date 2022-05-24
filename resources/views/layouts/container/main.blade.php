<!DOCTYPE html>
<html lang="en">
@include('layouts.container.header')

<body>
    <div id="app">
        @include('layouts.container.sidebar')
        <div id="main">
            @yield('container')
        </div>

        @include('layouts.container.footer')
