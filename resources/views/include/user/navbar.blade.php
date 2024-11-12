<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
    data-scroll="false">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm">
                    <a class="opacity-5 text-white" href="javascript:void(0);">Pages</a>
                </li>
                <li class="breadcrumb-item text-sm text-white active" aria-current="page">Aplikasi HRD</li>
            </ol>
            <h6 class="font-weight-bolder text-white mb-0">User</h6>
        </nav>

        {{-- <ul class="navbar-nav justify-content-end align-items-center">
            <!-- User Dropdown -->
            <li class="nav-item dropdown ms-3">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="{{ asset('user/assets/img/user-circle-solid-24.png') }}" alt="User Avatar"
                            class="w-px-40 h-auto rounded-circle" />
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" data-bs-auto-close="outside">
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul> --}}
            </li>
        </ul>
    </div>
</nav>
