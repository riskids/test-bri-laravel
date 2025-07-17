<?php
$notifications = optional(auth()->user())->unreadNotifications;
$notifications_count = optional($notifications)->count();
$notifications_latest = optional($notifications)->take(5);
?>

<header class="header header-sticky mb-3 p-0">
    <div class="container-fluid border-bottom px-4">
        <button
            class="header-toggler"
            type="button"
            style="margin-inline-start: -14px"
            onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()"
        >
            <i class="fa-solid fa-bars"></i>
        </button>
        <ul class="header-nav">
            <li class="nav-item dropdown">
                <a
                    class="nav-link py-0 pe-0"
                    data-coreui-toggle="dropdown"
                    href="#"
                    role="button"
                    aria-haspopup="true"
                    aria-expanded="false"
                >
                    <div class="avatar avatar-md">
                        <img
                            class="avatar-img"
                            src="{{ asset(auth()->user()->avatar) }}"
                            alt="{{ asset(auth()->user()->name) }}"
                        />
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <div class="dropdown-header bg-body-tertiary text-body-secondary fw-semibold rounded-top mb-2">
                        {{ __("Account") }}
                    </div>
                    <a class="dropdown-item" href="{{ route("backend.users.show", Auth::user()->id) }}">
                        <i class="fa-regular fa-user me-2"></i>
                        &nbsp;{{ Auth::user()->name }}
                    </a>
                    <a class="dropdown-item" href="{{ route("backend.users.show", Auth::user()->id) }}">
                        <i class="fa-solid fa-at me-2"></i>
                        &nbsp;{{ Auth::user()->email }}
                    </a>
                    <div class="dropdown-header bg-body-tertiary text-body-secondary fw-semibold my-2">
                        <div class="fw-semibold">@lang("Settings")</div>
                    </div>
                    <a
                        class="dropdown-item"
                        href="{{ route("logout") }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    >
                        <i class="fa-solid fa-right-from-bracket me-2"></i>
                        &nbsp;
                        @lang("Logout")
                    </a>
                    <form id="logout-form" style="display: none" action="{{ route("logout") }}" method="POST">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </div>
    <div class="container-fluid px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0 ms-2">
                @yield("breadcrumbs")
            </ol>
        </nav>
    </div>
</header>
