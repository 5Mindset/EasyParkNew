<aside id="sidebar" class="sidebar">



    <ul class="sidebar-nav" id="sidebar-nav">



        <li class="nav-item">

            <a class="nav-link no-underline {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ url('dashboard') }}">

                <i class="bi bi-grid"></i>

                <span>Dashboard</span>

            </a>

        </li>



        <li class="nav-item">

            <a class="nav-link collapsed no-underline {{ request()->is('officers*') || request()->is('students*') ? '' : 'collapsed' }}" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">

                <i class="bi bi-menu-button-wide"></i><span>Pengguna</span><i class="bi bi-chevron-down ms-auto"></i>

            </a>

            <ul id="components-nav" class="nav-content collapse {{ request()->is('officers*') || request()->is('students*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">

                <li>

                    <a href="{{ route('officers.index') }}" class="no-underline {{ request()->routeIs('officers.*') ? 'active' : '' }}">

                        <i class="bi bi-circle"></i><span>Petugas</span>

                    </a>

                </li>

                <li>

                    <a href="{{ route('students.index') }}" class="no-underline {{ request()->routeIs('students.*') ? 'active' : '' }}">

                        <i class="bi bi-circle"></i><span>Mahasiswa</span>

                    </a>

                </li>

            </ul>

        </li>



        <li class="nav-item">

            <a class="nav-link collapsed no-underline {{ request()->is('vehicle-types*') || request()->is('vehicle-brands*') || request()->is('vehicle-models*') || request()->is('vehicles*') || request()->is('parking-areas*') ? '' : 'collapsed' }}" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">

                <i class="bi bi-journal-text"></i><span>Kendaraan</span><i class="bi bi-chevron-down ms-auto"></i>

            </a>

            <ul id="forms-nav" class="nav-content collapse {{ request()->is('vehicle-types*') || request()->is('vehicle-brands*') || request()->is('vehicle-models*') || request()->is('vehicles*') || request()->is('parking-areas*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">

                <li>

                    <a href="{{ route('vehicle-types.index') }}" class="no-underline {{ request()->routeIs('vehicle-types.*') ? 'active' : '' }}">

                        <i class="bi bi-circle"></i><span>Tipe Kendaraan</span>

                    </a>

                </li>

                <li>

                    <a href="{{ route('vehicle-brands.index') }}" class="no-underline {{ request()->routeIs('vehicle-brands.*') ? 'active' : '' }}">

                        <i class="bi bi-circle"></i><span>Merek Kendaraan</span>

                    </a>

                </li>

                <li>

                    <a href="{{ route('vehicle-models.index') }}" class="no-underline {{ request()->routeIs('vehicle-models.*') ? 'active' : '' }}">

                        <i class="bi bi-circle"></i><span>Model Kendaraan</span>

                    </a>

                </li>

                <li>

                    <a href="{{ route('vehicles.index') }}" class="no-underline {{ request()->routeIs('vehicles.*') ? 'active' : '' }}">

                        <i class="bi bi-circle"></i><span>Kendaraan</span>

                    </a>

                </li>

                <li>

                    <a href="{{ route('parking-areas.index') }}" class="no-underline {{ request()->routeIs('parking-areas.*') ? 'active' : '' }}">

                        <i class="bi bi-circle"></i><span>Area Parkir</span>

                    </a>

                </li>

            </ul>

        </li>



        <li class="nav-item">

            <a class="nav-link collapsed no-underline {{ request()->is('parking-records*') || request()->is('guest-vehicles*') ? '' : 'collapsed' }}" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">

                <i class="bi bi-layout-text-window-reverse"></i><span>Riwayat Parkir</span><i class="bi bi-chevron-down ms-auto"></i>

            </a>

            <ul id="tables-nav" class="nav-content collapse {{ request()->is('parking-records*') || request()->is('guest-vehicles*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">

                <li>

                    <a href="{{ route('parking-records.index') }}" class="no-underline {{ request()->routeIs('parking-records.*') ? 'active' : '' }}">

                        <i class="bi bi-circle"></i><span>Mahasiswa Parkir</span>

                    </a>

                </li>

                <li>

                    <a href="{{ route('guest-vehicles.index') }}" class="no-underline {{ request()->routeIs('guest-vehicles.*') ? 'active' : '' }}">

                        <i class="bi bi-circle"></i><span>Tamu Parkir</span>

                    </a>

                </li>

            </ul>

        </li>

    </ul>



</aside>

