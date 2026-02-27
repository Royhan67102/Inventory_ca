<!DOCTYPE html>
<html lang="id">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<head>
    @include('layouts.partials.head')

    <style>
    /* Fix modal / alert ketutup sidebar */
    .modal {
        z-index: 2000 !important;
    }

    .modal-backdrop {
        z-index: 1999 !important;
    }

    /* Kalau pakai SweetAlert */
    .swal2-container {
        z-index: 9999 !important;
    }
    </style>
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

    <script>
    document.addEventListener("DOMContentLoaded", function () {

        const sidenavBtn = document.getElementById("iconNavbarSidenav");
        const body = document.body;

        if (sidenavBtn) {
            sidenavBtn.addEventListener("click", function () {

                body.classList.toggle("g-sidenav-pinned");

                // Supaya smooth di mobile
                if (window.innerWidth < 1200) {
                    body.classList.toggle("g-sidenav-hidden");
                }

            });
        }

    });
    </script>

</body>
</html>
