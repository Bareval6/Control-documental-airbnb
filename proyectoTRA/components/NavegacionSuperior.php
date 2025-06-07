<?php
// components/NavegacionSuperior.php
  $currentPage = basename($_SERVER['PHP_SELF']);
?>

<div class="navbar">
  <nav>
    <ul>
      <li><a href="dashboard.php" class="<?= $currentPage == 'dashboard.php' ? 'active' : '' ?>">Inicio</a></li>
      <li><a href="crear_formulario.php" class="<?= $currentPage == 'crear_formulario.php' ? 'active' : '' ?>">Formularios</a></li>
      <li><a href="aprobaciones.php" class="<?= $currentPage == 'aprobaciones.php' ? 'active' : '' ?>">Aprobaciones</a></li>
      <li><a href="logout.php" class="<?= $currentPage == 'logout.php' ? 'active' : '' ?>">Cerrar sesión</a></li>
    </ul>
  </nav>
</div>