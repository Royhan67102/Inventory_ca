<nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl">
    <div class="container-fluid py-1 px-3">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0">
                <li class="breadcrumb-item text-sm opacity-5">Pages</li>
                <li class="breadcrumb-item text-sm text-dark active">
                    @yield('page-title', 'Dashboard')
                </li>
            </ol>
        </nav>

        <div class="collapse navbar-collapse mt-sm-0 mt-2">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                <div class="input-group input-group-outline">
                    <label class="form-label">Type here...</label>
                    <input type="text" class="form-control">
                </div>
            </div>

            <ul class="navbar-nav align-items-center">
                <li class="nav-item d-flex align-items-center">
                    <i class="material-symbols-rounded">account_circle</i>
                </li>
            </ul>
        </div>

    </div>
</nav>
