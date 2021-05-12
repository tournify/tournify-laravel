<!doctype html>
<html lang="sv" class="theme-d has-gradient has-pattern">
<head>
    @include('includes.head')
</head>
<body>
<div id="root">

    <header id="top" class="heading-a row">
        @include('includes.header')
    </header>

    <div id="main" class="row">

        @yield('content')

    </div>

    <footer id="footer" class="row">
        @include('includes.footer')
    </footer>
</div>

<script>
    head.load('/javascript/scripts.js','/javascript/mobile.js')
</script>

</body>
</html>