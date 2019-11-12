<!DOCTYPE html>
<html>
@include('layouts.headtag')
<body>
<div class="container">
    @include('layouts.nav')
    <main role="main">
        @yield('contain')
    </main>
</div>
</body>
</html>
