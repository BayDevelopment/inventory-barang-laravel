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
                <li><a class="dropdown-item" href="#!">Pengaturan</a></li>
                <li><a class="dropdown-item" href="#!">Aktivitas</a></li>
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <li>
                    <a href="#" class="dropdown-item" onclick="confirmLogout(event)">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </li>
    </ul>

</nav>
