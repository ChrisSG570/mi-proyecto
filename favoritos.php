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
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02"
        aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
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

          if (isset($_SESSION["id_usuario"])) {
            echo "<li class='nav-item'>";
            echo "<a class='nav-link' href='favoritos.php'>Favoritos</a>";
            echo "</li>";
          }

          if ($_SESSION["admin"] == "si") {
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
  <h1>Favoritos:</h1><br>
  <?php
  // Conectar a la base de datos
  $conn = mysqli_connect('localhost', 'root', '', 'MetaScore');

  // Obtener los valores enviados por el formulario
  if (isset($_SESSION["id_usuario"])) {
    $id_usuario = $_SESSION['id_usuario'];

    if (isset($_GET["id_videojuego"])) {
      $id_videojuego = $_GET['id_videojuego'];

      // Obtener los datos del videojuego
      $sql = "SELECT nombre, desarrolladora, imagen, Nota_Prensa FROM Videojuegos WHERE id_videojuego = ?";
      $stmt = mysqli_prepare($conn, $sql);
      mysqli_stmt_bind_param($stmt, "i", $id_videojuego);
      mysqli_stmt_execute($stmt);
      $resultado = mysqli_stmt_get_result($stmt);
      $videojuego = mysqli_fetch_assoc($resultado);

      // Insertar el registro en la tabla Favoritos
      $sql = "INSERT INTO Favoritos (id_usuario, id_videojuego, nombre, desarrolladora, imagen, Nota_Prensa) VALUES (?, ?, ?, ?, ?, ?)";
      $stmt = mysqli_prepare($conn, $sql);
      mysqli_stmt_bind_param($stmt, "iissss", $id_usuario, $id_videojuego, $videojuego['nombre'], $videojuego['desarrolladora'], $videojuego['imagen'], $videojuego['Nota_Prensa']);
      mysqli_stmt_execute($stmt);

      if (mysqli_stmt_affected_rows($stmt) > 0) {
        header("location:inicio.php");
      } else {
        echo "Error";
      }
    } else if (isset($_GET["id_pelicula"])) {
      $id_pelicula = $_GET['id_pelicula'];

      // Obtener los datos de la película
      $sql = "SELECT nombre, distribuidora, imagen, Nota_Prensa FROM Peliculas WHERE id_pelicula = ?";
      $stmt = mysqli_prepare($conn, $sql);
      mysqli_stmt_bind_param($stmt, "i", $id_pelicula);
      mysqli_stmt_execute($stmt);
      $resultado = mysqli_stmt_get_result($stmt);
      $pelicula = mysqli_fetch_assoc($resultado);

      // Insertar el registro en la tabla Favoritos
      $sql = "INSERT INTO Favoritos (id_usuario, id_pelicula, nombre, distribuidora, imagen, Nota_Prensa) VALUES (?, ?, ?, ?, ?, ?)";
      $stmt = mysqli_prepare($conn, $sql);
      mysqli_stmt_bind_param($stmt, "iissss", $id_usuario, $id_pelicula, $pelicula['nombre'], $pelicula['distribuidora'], $pelicula['imagen'], $pelicula['Nota_Prensa']);
      mysqli_stmt_execute($stmt);

      if (mysqli_stmt_affected_rows($stmt) > 0) {
        header("location:inicio.php");
      } else {
        echo "Error";
      }
    }

    $sql = "SELECT * from Favoritos WHERE id_usuario = ? and desarrolladora is not null";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_usuario);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Muestra los últimos videojuegos en tarjetas
    if ($result->num_rows > 0) {
      echo "<h3>Videojuegos</h3>";
      echo "<div class='todo'>";
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='contenedor'><br>";
        echo "<img src='" . $row["imagen"] . "' class='card-img-top' style='width: 200px; class='card-img-top'>";
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'>" . $row["nombre"] . "</h5>";
        echo "<p class='card-text'>Nota de la prensa: " . $row["Nota_Prensa"] . "</p>";
        echo "<a href='detalles_videojuego.php?id=" . $row["id_videojuego"] . "&nombre=" . $row["nombre"] . "' class='btn btn-primary'>Ver detalles</a>\n";
        echo "<a href='borrar_favorito.php?id_videojuego=" . $row["id_videojuego"] . "' class='btn btn-danger'>Eliminar</a>";
        echo "<br></div>";
        echo "</div>";
      }
      echo "</div>";
    }

    $sql = "SELECT * from Favoritos WHERE id_usuario = ? and distribuidora is not null";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_usuario);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Muestra las últimas películas en tarjetas
    if ($result->num_rows > 0) {
      echo "<h3>Películas:</h3><br>";
      echo "<div class='todo'>";
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='contenedor'><br>";
        echo "<img src='" . $row["imagen"] . "' class='card-img-top' style='width: 200px; class='card-img-top'>";
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'>" . $row["nombre"] . "</h5>";
        echo "<p class='card-text'>Nota de la prensa: " . $row["Nota_Prensa"] . "</p>";
        echo "<a href='detalles_pelicula.php?id=" . $row["id_pelicula"] . "&nombre=" . $row["nombre"] . "' class='btn btn-primary'>Ver detalles</a>\n";
        echo "<a href='borrar_favorito.php?id_pelicula=" . $row["id_pelicula"] . "' class='btn btn-danger'>Eliminar</a>";
        echo "<br></div>";
        echo "</div>";
      }
      echo "</div>";
    }
    // Cerrar la conexión a la base de datos
    mysqli_close($conn);
  } else {
    header("location:inicio.php");
  }
  ?>
</body>

</html>