<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="dashboard">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse"
                href="#">
                <i class="bi bi-menu-button-wide"></i><span>Pengguna</span><i
                    class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="components-alerts.html">
                        <i class="bi bi-circle"></i><span>Petugas</span>
                    </a>
                </li>
                <li>
                    <a href="components-accordion.html">
                        <i class="bi bi-circle"></i><span>Mahasiswa</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Components Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-journal-text"></i><span>Kendaraan</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="forms-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('vehicle-types.index') }}">
                        <i class="bi bi-circle"></i><span>Tipe Kendaraan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('vehicle-brands.index') }}">
                        <i class="bi bi-circle"></i><span>Merek Kendaraan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('vehicle-models.index') }}">
                        <i class="bi bi-circle"></i><span>Model Kendaraan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('vehicles.index') }}">
                        <i class="bi bi-circle"></i><span>Kendaraan</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Forms Nav -->        

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-layout-text-window-reverse"></i><span>Riwayat Parkir</span><i
                    class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="tables-general.html">
                        <i class="bi bi-circle"></i><span>Parkir</span>
                    </a>
                </li>
                <li>
                    <a href="tables-data.html">
                        <i class="bi bi-circle"></i><span>Tamu Parkir</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Tables Nav -->
    </ul>

</aside><!-- End Sidebar-->