<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>MetaScore - Videojuegos</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</head>

<body>
<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
  <div class="container-fluid">
  <a class="navbar-brand" href="inicio.php"><img src="img/logo/logo.png" style="width: 50px" alt=""></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
      <div class="navbar-toggler-icon"></div>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="inicio.php">Inicio</a>
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

        if(isset($_SESSION["id_usuario"])){
          echo "<li class='nav-item'>";
          echo "<a class='nav-link' href='favoritos.php'>Favoritos</a>";
          echo "</li>";
        }

        if($_SESSION["admin"] == "si"){
          echo "<li class='nav-item'>";
          echo "<a class='nav-link' href='admin/opcAdmin.php'>Opciones ADMIN</a>";
          echo "</li>";
        }

        ?>
        ?>
      </ul>
      <div class="navbar-text">
          <a class="nav-link" href="login_usuario.php">Login</a>
      </div>
    </div>
  </div>
</nav><br>
    <?php
    $conn = mysqli_connect("localhost", "root", "", "MetaScore");

    if (!$conn) {
        die('Error de conexión: ' . mysqli_connect_error());
    }

    // Obtener el ID de la película de la URL
    $id_pelicula = $_GET['id'];
    $nombre = $_GET['nombre'];

    $sql = "SELECT COUNT(*) as num FROM ResenasPeliculas WHERE id_pelicula = ? and id_usuario is null";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_pelicula);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = $row['num'];

    // Realizar una consulta SQL para obtener los detalles de la película
    $sql = "SELECT * FROM Peliculas WHERE id_pelicula = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_pelicula);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result->num_rows > 0) {
        echo "<div class='presentacion'>";
        while ($row = $result->fetch_assoc()) {
            echo "<div class='portada'>";
            echo "<img src='" . $row["imagen"] . "'><br>";
            echo "</div>";
            echo "<div class='info'>";
            echo "<h1>" . $row["nombre"] . "</h1>";
            echo "<p><h3>" . $row["distribuidora"] . "</h3></p>";
            echo "<p>" . $row["descripcion"] . "</p>";
            echo "<p>Nota de la prensa: " . $row["Nota_Prensa"] . " -> Basado en " . $count . " reseñas.</p>";
            echo "<p>Nota de los usuarios: " . $row["Nota_Usuarios"] . "</p>";
        }
    }

    if (isset($_SESSION["id_usuario"])) {
        $id_usuario = $_SESSION["id_usuario"];
        $sql = "SELECT * FROM ResenasPeliculas WHERE id_usuario = ? && id_pelicula = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $id_usuario, $id_pelicula);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($result->num_rows > 0) {
            echo "Ya has escrito una reseña.\n";
        } else {
            echo "<a href='escribir_resena_pelicula.php?id_pelicula=$id_pelicula&nombre=$nombre' class='btn btn-primary'>Escribir una reseña</a>\n";
        }

        $sql = "SELECT * FROM Favoritos WHERE id_usuario = ? && id_pelicula = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $id_usuario, $id_pelicula);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($result->num_rows > 0) {
            echo "Ya lo has añadido a favoritos. <br>";
        } else {
            echo "<a href='favoritos.php?id_pelicula=$id_pelicula' class='btn btn-success'>Añadir a favoritos</a>";
        }
        echo "</div></div>";
    } else if (isset($_SESSION["id_prensa"])) {
        $id_prensa = $_SESSION["id_prensa"];
        $sql = "SELECT * FROM ResenasPeliculas WHERE id_prensa = ? && id_pelicula = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $id_prensa, $id_pelicula);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($result->num_rows > 0) {
            echo "Ya has escrito una reseña.\n";
        } else {
            echo "<a href='escribir_resena_pelicula.php?id_pelicula=$id_pelicula&nombre=$nombre' class='btn btn-primary'>Escribir una reseña</a>\n";
        }

        echo "</div></div>";
    }else{
        echo "</div></div>";
    }
    


    $sql = "SELECT * FROM ResenasPeliculas WHERE id_pelicula = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_pelicula);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='review'>";
            echo "<h3>" . $row["nombre"] . "</h3>";
            echo "<p>Opinión: " . $row["resena"] . "</p>";
            echo "<p>Nota: " . $row["nota"] . "</p>";
            echo "<p>Por " . $row["autor"] . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No se encontraron reseñas para este videojuego.</p>";
    }
    $conn->close();
?>
</body>
</html>