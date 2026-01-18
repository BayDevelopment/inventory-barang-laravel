<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand d-flex align-items-center" href="index.html" style="margin-left: 20px;">
        <!-- Logo -->
        <i class="fa-brands fa-nfc-symbol" style="font-size: 24px; margin-right: 8px;"></i>

        <!-- Tulisan dengan spasi antar huruf -->
        <span style="letter-spacing: 3px; text-transform: uppercase; line-height: 1.2; font-size: 14px;">
            PANEL<br>
            E-INVENTORY
        </span>
    </a>




    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
            class="fas fa-bars"></i></button>

    <!-- Navbar-->
    <ul class="navbar-nav ms-auto me-3">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center" id="navbarDropdown" href="#"
                role="button" data-bs-toggle="dropdown" aria-expanded="false">

                {{-- Ternary: jika ada avatar tampilkan, jika tidak tampilkan placeholder --}}
                @if (Auth::user()->avatar)
                    <img src="{{ Auth::user()->avatar }}" alt="User Avatar" class="rounded-circle"
                        style="width:32px; height:32px; margin-right:8px;">
                @else
                    <div class="rounded-circle d-flex justify-content-center align-items-center"
                        style="width:32px; height:32px; background-color:#000; color:#fff; font-weight:bold; margin-right:8px;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif

                <span>{{ Auth::user()->name }}</span>
            </a>

            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown" style="min-width: 220px;">
                <!-- User info -->
                <li>
                    <div class="dropdown-item d-flex align-items-center">
                        {{-- Avatar besar di dropdown --}}
                        @if (Auth::user()->avatar)
                            <img src="{{ Auth::user()->avatar }}" alt="User Avatar" class="rounded-circle"
                                style="width:40px; height:40px; margin-right:10px;">
                        @else
                            <div class="rounded-circle d-flex justify-content-center align-items-center"
                                style="width:40px; height:40px; background-color:#000; color:#fff; font-weight:bold; margin-right:10px;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="d-flex flex-column">
                            <strong>{{ Auth::user()->name }}</strong>
                            <small class="text-muted">{{ Auth::user()->email }}</small>
                        </div>
                    </div>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <!-- Menu items -->
                <li>
                    <a class="dropdown-item <?= $navlink == 'Pengaturan' ? 'active' : '' ?>"
                        href="{{ route('user.setting') }}">
                        <i class="fa-solid fa-gear me-2"></i> Pengaturan
                    </a>
                </li>

                <li>
                    <a href="#" class="dropdown-item text-danger" onclick="confirmLogout(event)">
                        <i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>

                <!-- Tambahkan CSS -->
                <style>
                    /* Dropdown items modern */
                    .dropdown-menu .dropdown-item {
                        border-radius: 8px;
                        transition: all 0.2s ease-in-out;
                        background-color: #f8f9fa;
                        /* default background */
                        color: #212529;
                        margin: 2px 0;
                        /* jarak antar item */
                    }

                    /* Hover */
                    .dropdown-menu .dropdown-item:hover {
                        background-color: #e2e6ea;
                        /* warna saat hover */
                        color: #212529;
                    }

                    /* Focus (keyboard navigation) */
                    .dropdown-menu .dropdown-item:focus {
                        background-color: #d6d8db;
                        /* warna saat focus */
                        outline: none;
                        color: #212529;
                    }

                    /* Active (misal menu aktif) */
                    .dropdown-menu .dropdown-item.active {
                        background-color: #ced4da;
                        color: #212529;
                        font-weight: 500;
                    }

                    /* Jika item text-danger (Logout) */
                    .dropdown-menu .dropdown-item.text-danger:hover,
                    .dropdown-menu .dropdown-item.text-danger:focus {
                        background-color: #f8d7da;
                        /* merah muda saat hover/focus */
                        color: #721c24;
                    }
                </style>

            </ul>
        </li>
    </ul>

</nav>
