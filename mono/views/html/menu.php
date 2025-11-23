<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo demo">

            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2">Mecánica</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        <li class="menu-item active">
            <a href="../views/home.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>


        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">Menu Principal</div>
            </a>

            <ul class="menu-sub">

                <li class="menu-item">
                    <a href="usuarios/usuarios.views.php" target="base" class="menu-link">
                        <div data-i18n="Blank">Usuarios</div>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="Roles/roles.views.php" target="base" class="menu-link">
                        <div data-i18n="Roles">Acceso/Roles</div>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="empleado/empleado.views.php" target="base" class="menu-link">
                        <?php $_SESSION['rutas'] = 'Empleados'; ?>
                        <div data-i18n="Without navbar">Empleados</div>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="clientes/clientes.views.php" target="base" class="menu-link">
                        <div data-i18n="Blank">Clientes</div>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="vehiculos/vehiculos.views.php" target="base" class="menu-link">
                        <div data-i18n="Blank">Vehículos</div>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="tipo_servicio/tipo_servicio.views.php" target="base" class="menu-link">
                        <div data-i18n="Fluid">Servicios</div>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="orden_trabajo/orden_trabajo.views.php" target="base" class="menu-link">
                        <div data-i18n="Blank">Órdenes de Trabajo</div>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="Reportes/reportes.views.php" target="base" class="menu-link">
                        <?php $_SESSION['rutas'] = 'Reportes'; ?>
                        <div data-i18n="Container">Reportes de Clientes</div>
                    </a>
                </li>

            </ul>
        </li>
        
    </ul>
</aside>