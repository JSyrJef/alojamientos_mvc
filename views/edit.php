<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Alojamiento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <?php include './views/layouts/navbar.php'?>
    <main class="container mt-2"> 
            <!-- <?php print_r($alojamiento)?> -->
            <h2 class="text-center">Editar alojamiento</h2>
        <section class="d-flex justify-content-center">
            <article class="card col-8" >
            <form class="form-control" action="./index.php?action=update&id=<?php echo $alojamiento['id'] ?>" method="POST">
                <label class="form-label" for="">Nombre</label>
                <input class='form-control' type="text" name="nombre" value="<?php echo $alojamiento['nombre'] ?> ">
                <label class="form-label" for="">Descripcion</label>
                <input class='form-control' type="text" name="descripcion" value="<?php echo $alojamiento['descripcion'] ?> ">
                <label class="form-label" for="">Ubicacion</label>
                <input class='form-control' type="text" name="ubicacion" value="<?php echo $alojamiento['ubicacion'] ?> ">
                <label class="form-label" for="">URL de la imagen</label>
                <input class='form-control' type="text" name="image_url" value="<?php echo $alojamiento['image_url'] ?> ">
                <button class="btn btn-success mt-2" type="submit">Editar</button>
            </form>
            </article>
        </section>
    </main>


</body>
</html>