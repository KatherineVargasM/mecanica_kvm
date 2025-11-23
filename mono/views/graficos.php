<?php
require_once('../config/sesiones.php');
require_once('html/head2.php');

require_once('../models/usuario.models.php');
require_once('../models/clientes.models.php');
require_once('../models/vehiculos.models.php');
require_once('../models/orden_trabajo.models.php');

$usuario = new Usuarios();
$clientes = new Clientes();
$vehiculos = new Vehiculos();
$ordenes = new OrdenTrabajo(); 

$totalUsuarios = mysqli_num_rows($usuario->todos());
$totalClientes = mysqli_num_rows($clientes->todos());
$totalVehiculos = mysqli_num_rows($vehiculos->todos());
$totalOrdenes = mysqli_num_rows($ordenes->todos());
?>

<body>
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      
      <div class="col-lg-8 mb-4 order-0">
        <div class="card">
          <div class="d-flex align-items-end row">
            <div class="col-sm-7">
              <div class="card-body">
                <h5 class="card-title text-primary">Bienvenido a Mecánica KVM</h5>
                <p class="mb-4">
                  Tenés <span class="fw-bold"><?php echo $totalOrdenes; ?></span> órdenes de trabajo registradas en el sistema. 
                  Revisá las pendientes hoy.
                </p>

                <a href="orden_trabajo/orden_trabajo.views.php" target="_parent" class="btn btn-sm btn-outline-primary">Ver Órdenes</a>
              </div>
            </div>
            <div class="col-sm-5 text-center text-sm-left">
              <div class="card-body pb-0 px-0 px-md-4">
                <img
                  src="../public/assets/img/illustrations/man-with-laptop-light.png"
                  height="140"
                  alt="View Badge User"
                  data-app-dark-img="illustrations/man-with-laptop-dark.png"
                  data-app-light-img="illustrations/man-with-laptop-light.png"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-lg-4 col-md-4 order-1">
        <div class="row">
          
          <div class="col-lg-6 col-md-12 col-6 mb-4">
            <div class="card">
              <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                  <div class="avatar flex-shrink-0">
                    <img src="../public/assets/img/icons/unicons/chart-success.png" alt="chart success" class="rounded" />
                  </div>
                  <div class="dropdown">
                    <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                      <a class="dropdown-item" href="clientes/clientes.views.php" target="_parent">Ver más</a>
                    </div>
                  </div>
                </div>
                <span class="fw-semibold d-block mb-1">Clientes</span>
                <h3 class="card-title mb-2"><?php echo $totalClientes; ?></h3>
                <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> Activos</small>
              </div>
            </div>
          </div>

          <div class="col-lg-6 col-md-12 col-6 mb-4">
            <div class="card">
              <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                  <div class="avatar flex-shrink-0">
                    <img src="../public/assets/img/icons/unicons/wallet-info.png" alt="Credit Card" class="rounded" />
                  </div>
                </div>
                <span class="fw-semibold d-block mb-1">Vehículos</span>
                <h3 class="card-title text-nowrap mb-1"><?php echo $totalVehiculos; ?></h3>
                <small class="text-success fw-semibold"><i class="bx bx-car"></i> En taller</small>
              </div>
            </div>
          </div>

        </div>
      </div>

      <div class="row">
        
        <div class="col-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                  <img src="../public/assets/img/icons/unicons/paypal.png" alt="Credit Card" class="rounded" />
                </div>
              </div>
              <span class="d-block mb-1">Órdenes de Trabajo</span>
              <h3 class="card-title text-nowrap mb-2"><?php echo $totalOrdenes; ?></h3>
              <small class="text-danger fw-semibold"><i class="bx bx-down-arrow-alt"></i> Pendientes</small>
            </div>
          </div>
        </div>

        <div class="col-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                  <img src="../public/assets/img/icons/unicons/cc-primary.png" alt="Credit Card" class="rounded" />
                </div>
              </div>
              <span class="fw-semibold d-block mb-1">Personal</span>
              <h3 class="card-title mb-2"><?php echo $totalUsuarios; ?></h3>
              <small class="text-success fw-semibold"><i class="bx bx-user"></i> Activos</small>
            </div>
          </div>
        </div>

      </div>

    </div>
  </div>

  <?php require_once('html/scripts2.php'); ?>
</body>