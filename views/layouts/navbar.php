<?php 

$usuario_id = $_SESSION['usuario_id']; 

// Verificar si el usuario es un administrador
$is_admin = ($_SESSION['usuario_tipo'] === 'administrador');  // Tipo de usuario
?>

<nav class="navbar bg-success">
  <div class="container-fluid">
    <span class="navbar-brand mb-0 h1"><a href="./index.php?" style="text-decoration: none; color: white;">Navbar</a></span>
  </div>
  <?php if (!$is_admin): ?>
    <!-- Solo los usuarios normales pueden seleccionar -->
    <a href="/alojamientos_mvc/views/usuario/index.php?action=cuenta" class="btn btn-primary">Cuenta</a>
  <?php else: ?>
    <!-- Administradores pueden editar y eliminar -->
    <a href="/alojamientos_mvc/views/usuario/index.php?action=logout" class="btn btn-primary">Cerrar Sesion</a>
  <?php endif; ?>
</nav>