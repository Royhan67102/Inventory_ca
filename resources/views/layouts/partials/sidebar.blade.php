<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2 bg-white my-2"
    id="sidenav-main">

    <div class="sidenav-header">
        <a class="navbar-brand px-4 py-3 m-0" href="#">
            <img src="{{ asset('assets/img/ca.png') }}" width="26">
            <span class="ms-1 text-sm text-dark">Cahaya Acrylic</span>
        </a>
    </div>

    <hr class="horizontal dark mt-0 mb-2">

    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">

            @auth
            @php
                $role = auth()->user()->role;
            @endphp

            {{-- ================= ADMIN SECTION ================= --}}
            @if($role === 'admin')

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                        href="{{ route('dashboard') }}">
                        <i class="material-symbols-rounded opacity-5">dashboard</i>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('orders.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                        href="{{ route('orders.index') }}">
                        <i class="material-symbols-rounded opacity-5">shopping_cart</i>
                        <span class="nav-link-text ms-1">Orders</span>
                    </a>
                </li>

                {{-- ================= DESIGN ================= --}}
                @if(in_array($role, ['admin','tim_desain']))
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('designs.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                        href="{{ route('designs.index') }}">
                        <i class="material-symbols-rounded opacity-5">draw</i>
                        <span class="nav-link-text ms-1">Desain</span>
                    </a>
                </li>
                @endif

                {{-- ================= PRODUKSI ================= --}}
                @if(in_array($role, ['admin','tim_produksi']))
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('productions.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                        href="{{ route('productions.index') }}">
                        <i class="material-symbols-rounded opacity-5">factory</i>
                        <span class="nav-link-text ms-1">Produksi</span>
                    </a>
                </li>
                @endif

                {{-- ================= DELIVERY ================= --}}
                @if(in_array($role, ['admin','driver']))
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('delivery.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                        href="{{ route('delivery.index') }}">
                        <i class="material-symbols-rounded opacity-5">local_shipping</i>
                        <span class="nav-link-text ms-1">Pengiriman</span>
                    </a>
                </li>
                @endif

                {{-- ================= PICKUP ================= --}}
                @if(in_array($role, ['admin','driver','logistik']))
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('pickup.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                        href="{{ route('pickup.index') }}">
                        <i class="material-symbols-rounded opacity-5">move_to_inbox</i>
                        <span class="nav-link-text ms-1">Pickup</span>
                    </a>
                </li>
                @endif

                {{-- ================= ACRYLIC STOCKS ================= --}}
                @if(in_array($role, ['admin','logistik']))
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('acrylic-stocks.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                        href="{{ route('acrylic-stocks.index') }}">
                        <i class="material-symbols-rounded opacity-5">package_2</i>
                        <span class="nav-link-text ms-1">Acrylic Stocks</span>
                    </a>
                </li>
                @endif

                {{-- ================= INVENTORIES ================= --}}
                @if(in_array($role, ['admin','logistik']))
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('inventories.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                        href="{{ route('inventories.index') }}">
                        <i class="material-symbols-rounded opacity-5">inventory</i>
                        <span class="nav-link-text ms-1">Inventory</span>
                    </a>
                </li>
                @endif

            @elseif($role === 'driver')

                {{-- ================= DELIVERY (DRIVER) ================= --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('delivery.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                        href="{{ route('delivery.index') }}">
                        <i class="material-symbols-rounded opacity-5">local_shipping</i>
                        <span class="nav-link-text ms-1">Pengiriman</span>
                    </a>
                </li>

                {{-- ================= PICKUP (DRIVER) ================= --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('pickup.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                        href="{{ route('pickup.index') }}">
                        <i class="material-symbols-rounded opacity-5">move_to_inbox</i>
                        <span class="nav-link-text ms-1">Pickup</span>
                    </a>
                </li>

            @elseif($role === 'logistik')

                {{-- ================= ACRYLIC STOCKS (LOGISTIK) ================= --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('acrylic-stocks.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                        href="{{ route('acrylic-stocks.index') }}">
                        <i class="material-symbols-rounded opacity-5">package_2</i>
                        <span class="nav-link-text ms-1">Acrylic Stocks</span>
                    </a>
                </li>

                {{-- ================= INVENTORIES (LOGISTIK) ================= --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('inventories.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                        href="{{ route('inventories.index') }}">
                        <i class="material-symbols-rounded opacity-5">inventory</i>
                        <span class="nav-link-text ms-1">Inventory</span>
                    </a>
                </li>

                {{-- ================= PICKUP ================= --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('pickup.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                        href="{{ route('pickup.index') }}">
                        <i class="material-symbols-rounded opacity-5">move_to_inbox</i>
                        <span class="nav-link-text ms-1">Pickup</span>
                    </a>
                </li>

            @elseif($role === 'tim_desain')

                {{-- ================= DESIGN (TIM DESAIN) ================= --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('designs.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                        href="{{ route('designs.index') }}">
                        <i class="material-symbols-rounded opacity-5">draw</i>
                        <span class="nav-link-text ms-1">Desain</span>
                    </a>
                </li>

            @elseif($role === 'tim_produksi')

                {{-- ================= PRODUKSI (TIM PRODUKSI) ================= --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('productions.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                        href="{{ route('productions.index') }}">
                        <i class="material-symbols-rounded opacity-5">factory</i>
                        <span class="nav-link-text ms-1">Produksi</span>
                    </a>
                </li>

            @endif

            {{-- ================= ACCOUNT ================= --}}
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs opacity-5">Account</h6>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('profile.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                    href="{{ route('profile.index') }}">
                    <i class="material-symbols-rounded opacity-5">person</i>
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
            </li>

            <li class="nav-item">
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="button"
                        class="nav-link text-dark btn btn-link d-flex align-items-center text-start"
                        onclick="confirmLogout()">
                        <i class="material-symbols-rounded opacity-5">logout</i>
                        <span class="nav-link-text ms-1">Logout</span>
                    </button>
                </form>
            </li>

            @endauth

        </ul>
    </div>
</aside>
