<?php
session_start();
if (isset($_SESSION['emailUser']) != "") {
  include('../config/config.php');
  $IdUser     = $_SESSION['IdUser'];
  $rolUser     = $_SESSION['rol'];
  $email      = $_SESSION['emailUser'];
?>
  <!DOCTYPE html>
  <html lang="es">
  <?php
  include('bases/head.html');
  include('bases/toastr.html');
  ?>
  <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
  <style>
    .gj-picker-md table tr td.today div {
      color: #BDBDBD;
    }
  </style>

  <body>
    <?php
    include('../msjs.php');
    include('bases/loader.html');
    ?>
    <div class="container-scroller">
      <?php include 'bases/navbar.php' ?>
      <div class="container-fluid page-body-wrapper">
        <?php
        include 'bases/config.html';
        include 'bases/nav.php';
        ?>
        <div class="main-panel">
          <div class="content-wrapper">
            <?php
            include 'funciones.php';
            if ($rolUser == 1) {
              $num_activas = getCountReservasPorEstado($con, 1);
              $num_pendientes = getCountReservasPorEstado($con, 0);
              $num_historial = getCountReservasPorEstado($con, 2);
              $num_clientes = getCountClientes($con);
              $reservasPorMes = getReservasPorMes($con);
              $chartReservasMes = htmlspecialchars(json_encode($reservasPorMes), ENT_QUOTES, 'UTF-8');
              $chartEstadoReservas = htmlspecialchars(json_encode([
                'labels' => ['Activas', 'Pendientes', 'Historial'],
                'data' => [$num_activas, $num_pendientes, $num_historial]
              ]), ENT_QUOTES, 'UTF-8');
            ?>
              <div class="parking-dashboard-admin">
                <h1 class="mb-4" style="font-size: 1.75rem; font-weight: 600; color: var(--parking-secondary, #1e293b);">Panel de administración</h1>
                <p class="text-muted mb-4">Resumen general del sistema</p>
                <div class="row g-3 g-md-4 mb-4">
                  <div class="col-12 col-sm-6 col-xl-3">
                    <a href="Agenda.php" class="text-decoration-none">
                      <div class="card parking-dashboard-card h-100 border-0 shadow-sm">
                        <div class="card-body d-flex align-items-center">
                          <div class="flex-shrink-0 rounded-3 parking-dashboard-card-primary p-3 me-3">
                            <i class="bi bi-calendar2-check text-white" style="font-size: 1.75rem;"></i>
                          </div>
                          <div>
                            <div class="fw-bold text-dark" style="font-size: 1.5rem;"><?php echo $num_activas; ?></div>
                            <div class="text-muted small">Reservas activas</div>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                  <div class="col-12 col-sm-6 col-xl-3">
                    <a href="ReservasPendientes.php" class="text-decoration-none">
                      <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                          <div class="flex-shrink-0 rounded-3 bg-warning bg-opacity-25 p-3 me-3">
                            <i class="bi bi-calendar2-week" style="font-size: 1.75rem; color: #b45309;"></i>
                          </div>
                          <div>
                            <div class="fw-bold text-dark" style="font-size: 1.5rem;"><?php echo $num_pendientes; ?></div>
                            <div class="text-muted small">Pendientes</div>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                  <div class="col-12 col-sm-6 col-xl-3">
                    <a href="CrearCliente.php" class="text-decoration-none">
                      <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                          <div class="flex-shrink-0 rounded-3 bg-success bg-opacity-25 p-3 me-3">
                            <i class="bi bi-people" style="font-size: 1.75rem; color: #15803d;"></i>
                          </div>
                          <div>
                            <div class="fw-bold text-dark" style="font-size: 1.5rem;"><?php echo $num_clientes; ?></div>
                            <div class="text-muted small">Clientes</div>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                  <div class="col-12 col-sm-6 col-xl-3">
                    <a href="HistorialReservas.php" class="text-decoration-none">
                      <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                          <div class="flex-shrink-0 rounded-3 bg-secondary bg-opacity-25 p-3 me-3">
                            <i class="bi bi-calendar3" style="font-size: 1.75rem; color: #4b5563;"></i>
                          </div>
                          <div>
                            <div class="fw-bold text-dark" style="font-size: 1.5rem;"><?php echo $num_historial; ?></div>
                            <div class="text-muted small">Historial</div>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
                <div class="card border-0 shadow-sm">
                  <div class="card-body">
                    <h2 class="h6 fw-bold text-dark mb-3">Accesos rápidos</h2>
                    <div class="d-flex flex-wrap gap-2">
                      <a href="CrearReserva.php" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> Nueva reserva
                      </a>
                      <a href="CrearCliente.php" class="btn btn-outline-primary">
                        <i class="bi bi-person-plus me-1"></i> Nuevo cliente
                      </a>
                      <a href="Agenda.php" class="btn btn-outline-secondary">
                        <i class="bi bi-calendar2-check me-1"></i> Mi agenda
                      </a>
                      <a href="ReservasPendientes.php" class="btn btn-outline-secondary">
                        <i class="bi bi-calendar2-week me-1"></i> Pendientes
                      </a>
                    </div>
                  </div>
                </div>
                <div class="row g-3 g-md-4 mt-2">
                  <div class="col-12 col-lg-8">
                    <div class="card border-0 shadow-sm h-100">
                      <div class="card-body">
                        <h2 class="h6 fw-bold text-dark mb-3">
                          <i class="bi bi-graph-up me-1 text-primary"></i> Reservas por mes
                        </h2>
                        <div class="position-relative" style="height: 280px;">
                          <canvas id="chartReservasMes"></canvas>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                      <div class="card-body">
                        <h2 class="h6 fw-bold text-dark mb-3">
                          <i class="bi bi-pie-chart me-1 text-primary"></i> Estado de reservas
                        </h2>
                        <div class="position-relative d-flex align-items-center justify-content-center" style="height: 280px;">
                          <canvas id="chartEstadoReservas"></canvas>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <script>
                  window.ParkingCharts = {
                    reservasPorMes: <?php echo $chartReservasMes; ?>,
                    estadoReservas: <?php echo $chartEstadoReservas; ?>
                  };
                </script>
              </div>
            <?php
            } elseif ($rolUser == 0) { ?>
              <div class="row justify-content-md-center">
                <div class="col-md-8 grid-margin">
                  <div class="card">
                    <div class="card-body">
                      <h1 class="card-title text-center mb-5">Crea tu reserva aquí en segundos
                        <hr>
                      </h1>

                      <form action="funciones.php" method="post" autocomplete="off">
                        <input type="hidden" name="email_cliente" value="<?php echo $email; ?>">
                        <input type="hidden" name="IdUser" value="<?php echo $IdUser; ?>">
                        <input type="hidden" name="accion" value="crearReservaClienteDashboard">
                        <input type="hidden" name="total_pago_reserva" id="total_pago_reserva">
                        <div class="row mb-2">
                          <div class="col-12 col-md-6 col-lg-6 col-xl-3 col-xxl-3 mb-2">
                            <label for="fecha-entrega">Fecha de entrega</label>
                            <input type="text" name="fecha_entrega" id="fecha_entrega" onchange="calcularDiferenciaDias()" class="borderInput form-control form-control-lg campo_obligatorio" required />
                          </div>
                          <div class="col-12 col-md-6 col-lg-6 col-xl-3 col-xxl-3 mb-2">
                            <label for="hora_entrega">Hora de entrega</label>
                            <select name="hora_entrega" id="hora_entrega" class="form-control form-control-lg campo_obligatorio" required>
                              <option value="" selected="">Seleccione</option>
                              <?php
                              $start_time = strtotime('05:00');
                              $end_time     = strtotime('24:00');
                              $interval = 15 * 60; // 15 minutos en segundos
                              for ($time = $start_time; $time <= $end_time; $time += $interval) {
                                $hora_militar = date("H:i", $time);
                                $hora_am_pm = date("h:i A", $time);
                                echo '<option value="' . $hora_militar . '">' . $hora_am_pm . '</option>';
                              }
                              ?>
                            </select>
                          </div>
                          <div class="col-12 col-md-6 col-lg-6 col-xl-3 col-xxl-3 mb-2">
                            <label for="fecha-recogida">Fecha de recogida</label>
                            <input type="text" name="fecha_recogida" id="fecha_recogida" onchange="calcularDiferenciaDias()" class="borderInput form-control form-control-lg campo_obligatorio" required />
                          </div>
                          <div class="col-12 col-md-6 col-lg-6 col-xl-3 col-xxl-3 mb-2">
                            <label for="hora-recogida">Hora de recogida</label>
                            <select name="hora_recogida" id="hora_recogida" class="form-control form-control-lg campo_obligatorio" required>
                              <option value="" selected="">Seleccione</option>
                              <?php
                              $start_time = strtotime('05:00');
                              $end_time     = strtotime('24:00');
                              $interval = 15 * 60; // 15 minutos en segundos
                              for ($time = $start_time; $time <= $end_time; $time += $interval) {
                                $hora_militar = date("H:i", $time);
                                $hora_am_pm = date("h:i A", $time);
                                echo '<option value="' . $hora_militar . '">' . $hora_am_pm . '</option>';
                              }
                              ?>
                            </select>
                          </div>
                        </div>

                        <div class="row mb-2">
                          <div class="col-12 col-md-6 col-lg-6 col-xl-3 col-xxl-3 mb-2">
                            <label for="">Tipo de plaza</label>
                            <select name="tipo_plaza" id="tipo_plaza" onchange="calcularPago(this.value)" class="form-control form-control-lg campo_obligatorio" required>
                              <option value="" selected>Seleccione</option>
                              <option value="Plaza Aire Libre">Plaza Aire Libre</option>
                              <option value="Plaza Cubierto">Plaza Cubierto</option>
                            </select>
                          </div>
                          <div class="col-12 col-md-6 col-lg-6 col-xl-3 col-xxl-3 mb-2">
                            <label for="">Terminal de entrega</label>
                            <select name="terminal_entrega" class="form-control form-control-lg campo_obligatorio" required>
                              <option value="" selected>Seleccione</option>
                              <option value="Aeropuerto 2">Aeropuerto 1</option>
                            </select>
                          </div>
                          <div class="col-12 col-md-6 col-lg-6 col-xl-3 col-xxl-3 mb-2">
                            <label for="">Terminal de recogida</label>
                            <select name="terminal_recogida" class="form-control form-control-lg campo_obligatorio" required>
                              <option value="" selected>Seleccione</option>
                              <option value="Aeropuerto 2">Aeropuerto 2</option>
                            </select>
                          </div>
                          <div class="col-12 col-md-6 col-lg-6 col-xl-3 col-xxl-3 mb-2">
                            <label for="">Matrícula</label>
                            <input type="text" name="matricula" class="form-control form-control-lg campo_obligatorio" required />
                          </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col-12 col-md-4 col-lg-6 col-xl-3 col-xxl-3 mb-2">
                            <label for="">Color</label>
                            <input type="text" name="color" class="form-control form-control-lg campo_obligatorio" required />
                          </div>
                          <div class="col-md-6 mb-2">
                            <label for="">Marca - Modelo</label>
                            <input type="text" name="marca_modelo" class="form-control form-control-lg campo_obligatorio" required />
                          </div>

                          <div class="col-12 col-md-4 col-lg-6 col-xl-3 col-xxl-3 mb-2">
                            <label for="">Nº Vuelo de Vuelta</label>
                            <input type="text" name="numero_vuelo_de_vuelta" class="form-control form-control-lg campo_obligatorio" />
                          </div>
                        </div>

                        <div class="row mb-2">
                          <div class="col-md-6 mb-2">
                            <label for="">Servicios Adicionales</label>
                            <div class="mb-3 form-check">
                              <input type="checkbox" name="servicio_adicional" id="servicio_adicional" class="form-check-input" style="margin-left: 0;" value="Si">
                              <label class="form-check-label" for="servicio_adicional">Lavado Exterior Básico (Gratuito)</label>
                            </div>
                          </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                          <button type="submit" class="btn btn-primary mr-2">Crear mi Reserva Ahora</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="card card-light-danger">
                    <div class="card-body">
                      <h2 class="mb-4 text-center">Total a Pagar
                        <hr>
                      </h2>
                      <p id="totalReserva" class="fs-30 mb-2" style="line-height: 1.8rem;"></p>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>


    <?php include 'bases/PageJs.html'; ?>
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <script src="https://unpkg.com/gijgo@1.9.14/js/messages/messages.es-es.js" type="text/javascript"></script>
    <script src="../assets/custom/js/custom_date_time.js"></script>
    <script src="../assets/custom/js/reserva_cliente.js"></script>
    <?php if (isset($rolUser) && $rolUser == 1): ?>
      <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          if (typeof window.ParkingCharts === 'undefined') return;
          var primary = getComputedStyle(document.documentElement).getPropertyValue('--parking-primary').trim() || '#1e40af';
          var reservas = window.ParkingCharts.reservasPorMes;
          var estado = window.ParkingCharts.estadoReservas;
          var canvasMes = document.getElementById('chartReservasMes');
          var canvasEstado = document.getElementById('chartEstadoReservas');
          if (reservas && canvasMes) {
            new Chart(canvasMes, {
              type: 'bar',
              data: {
                labels: reservas.labels,
                datasets: [{
                  label: 'Reservas',
                  data: reservas.data,
                  backgroundColor: primary + '33',
                  borderColor: primary,
                  borderWidth: 1
                }]
              },
              options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                  legend: {
                    display: false
                  }
                },
                scales: {
                  y: {
                    beginAtZero: true,
                    ticks: {
                      stepSize: 1
                    }
                  },
                  x: {}
                }
              }
            });
          }
          if (estado && canvasEstado) {
            new Chart(canvasEstado, {
              type: 'doughnut',
              data: {
                labels: estado.labels,
                datasets: [{
                  data: estado.data,
                  backgroundColor: [primary, '#eab308', '#6b7280'],
                  borderWidth: 0
                }]
              },
              options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                  legend: {
                    position: 'bottom'
                  }
                },
                cutout: '60%'
              }
            });
          }
        });
      </script>
    <?php endif; ?>

  </body>

  </html>
<?php
} else { ?>
  <script type="text/javascript">
    location.href = "../acciones/login/exit.php";
  </script>
<?php }  ?>