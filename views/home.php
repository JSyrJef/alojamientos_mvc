<?php
require_once '../config/database.php';
$database = new Database();
$pdo = $database->getConnection();

session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

$usuario_id = $_SESSION['usuario_id']; 

// Verificar si el usuario es un administrador
$is_admin = ($_SESSION['usuario_tipo'] === 'administrador');  // Tipo de usuario

// Obtener la lista de alojamientos disponibles
$query = "SELECT * FROM alojamientos";
$stmt = $pdo->prepare($query);
$stmt->execute();
$alojamientos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alojamiento MVC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-light">
    <?php include './layouts/navbar.php'?>
    <main class="container mt-2">
        <?php if ($is_admin): ?>
            <!-- Para los administradores, mostramos las opciones de agregar, editar y eliminar -->
            <a href="./index.php?action=create" class="btn btn-success">Agregar Alojamiento</a>
        <?php endif; ?>

        <table class="table m-2">
            <thead>
                <tr>
                    <th scope="col">#ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Descripcion</th>
                    <th scope="col">Ubicacion</th>
                    <th scope="col">Imagen</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alojamientos as $alojamiento): ?>
                    <tr>
                        <th scope="row"><?php echo $alojamiento['id'] ?></th>
                        <td><?php echo $alojamiento['nombre'] ?></td>
                        <td><?php echo $alojamiento['descripcion'] ?></td>
                        <td><?php echo $alojamiento['ubicacion'] ?></td>
                        <td><img src="<?php echo $alojamiento['image_url']; ?>" alt="Imagen de <?php echo $alojamiento['nombre']; ?>" style="width: 100px; height: auto;"></td>
                        <td>
                            <?php if (!$is_admin): ?>
                                <!-- Solo los usuarios normales pueden seleccionar -->
                                <a href="./index.php?action=select&id=<?php echo $alojamiento['id'] ?>" class="btn btn-primary">Seleccionar</a>
                            <?php else: ?>
                                <!-- Administradores pueden editar y eliminar -->
                                <a href="./index.php?action=update&id=<?php echo $alojamiento['id'] ?>" class="btn btn-warning">Editar</a>
                                <a href="./index.php?action=delete&id=<?php echo $alojamiento['id'] ?>" class="btn btn-danger">Eliminar</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>