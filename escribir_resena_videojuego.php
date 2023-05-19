<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>MetaScore - Videojuegos</title>
  <link rel="stylesheet" href="style.css">
  <!-- Inclusión de hojas de estilo de Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!-- Inclusión de archivos JavaScript de Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
</head>

<body>
<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php "><img src="img/logo/logo.png" style="width: 50px" alt=""></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
      <div class="navbar-toggler-icon"></div>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php ">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="mostrarVideojuegos.php">Videojuegos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="mostrarPeliculas.php">Películas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="historial.php">Mis reseñas</a>
        </li>
        <?php
        // Verifica si el usuario ha iniciado sesión
        if(isset($_SESSION["id_usuario"])){
          echo "<li class='nav-item'>";
          echo "<a class='nav-link' href='favoritos.php'>Favoritos</a>";
          echo "</li>";
        }

        // Verifica si el usuario es administrador
        if($_SESSION["admin"] == "si"){
          echo "<li class='nav-item'>";
          echo "<a class='nav-link' href='admin/opcAdmin.php'>Opciones ADMIN</a>";
          echo "</li>";
        }
        ?>
      </ul>
      <div class="navbar-text">
          <a class="nav-link" href="login_usuario.php">Login</a>
      </div>
    </div>
  </div>
</nav><br>

<?php
$id_videojuego = $_GET["id_videojuego"];
$nombre = $_GET["nombre"];

// Verifica si el usuario está autenticado como usuario registrado
if (isset($_SESSION["usuario"])) {
  $autor = $_SESSION["usuario"];
}
// Verifica si el usuario está autenticado como prensa
else if (isset($_SESSION["nombre_prensa"])) {
  $autor = $_SESSION["nombre_prensa"];
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Escribir una reseña</title>
</head>
<body>
  <h2>Escribir una reseña</h2>
  <div class="añadir_reseña">
  <form action="procesar_resena_videojuego.php" method="post">

    <input type="hidden" name="id_videojuego" value="<?php echo $id_videojuego; ?>">
    <input type="hidden" name="autor" value="<?php echo $autor; ?>">
    <input type="hidden" name="nombre" value="<?php echo $nombre; ?>">

    <label for="comentario">Comentario:</label><br>
    <textarea rows="10" cols="50" id="comentario" name="comentario"></textarea><br>

    <label for="nota">Nota:</label>
    <input type="number" id="nota" name="nota" min="0" max="100" step="1" required><br>
    <br>
    <input type="submit" value="Enviar">
  </form>
  <br>
  <a href="index.php " class='btn btn-primary'>Volver atras</a>
  <br>
</div>
</body>
</html>