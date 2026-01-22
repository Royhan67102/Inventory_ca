<!DOCTYPE html>
<html lang="id">
<head>
    @include('layouts.partials.head')
</head>

<body class="g-sidenav-show bg-gray-100">

    @include('layouts.partials.sidebar')

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">

        @include('layouts.partials.navbar')

        <div class="container-fluid py-4">
            @yield('content')
        </div>

    </main>

    @include('layouts.partials.scripts')
    @stack('scripts')

</body>
</html>
