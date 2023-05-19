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
      <a class="navbar-brand" href="index.php "><img src="img/logo/logo.png" style="width: 50px" alt=""></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02"
        aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
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
          // Verificar si hay un usuario logueado
          if (isset($_SESSION["id_usuario"])) {
            echo "<li class='nav-item'>";
            echo "<a class='nav-link' href='favoritos.php'>Favoritos</a>";
            echo "</li>";
          }
          
          // Verificar si el usuario es un administrador
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

  <?php
  // Mostrar panel de usuario o prensa si están logueados
  if (isset($_SESSION["usuario"]) && isset($_SESSION["id_usuario"])) {
    echo "<div class='user-panel'>";
    echo "<h3>Bienvenido, " . $_SESSION["usuario"] . "</h3><br>";
    echo "</div>";
  } else if (isset($_SESSION["nombre_prensa"]) && isset($_SESSION["id_prensa"])) {
    echo "<div class='press-panel'>";
    echo "<h3>Bienvenido, " . $_SESSION["nombre_prensa"] . "</h3><br>";
    echo "</div>";
  }
  ?>

  <main>
    <section class="latest-games">
      <h2>Últimos videojuegos</h2>
      <div class="card-container">
        <?php
        $conn = mysqli_connect($_ENV["DB_DB"], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"], $_ENV["DB_NAME"]);

        if (!$conn) {
          die('Error de conexión: ' . mysqli_connect_error());
        }

        $sql = "SELECT * FROM Videojuegos ORDER BY id_videojuego DESC LIMIT 5";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          echo "<div class='todo'>";
          while ($row = $result->fetch_assoc()) {
            echo "<div class='contenedor'><br>";
            echo "<img src='" . $row["imagen"] . "' class='card-img-top' style='width: 200px; class='card-img-top'>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-title'>" . $row["nombre"] . "</h5>";
            echo "<p class='card-text'>Nota de la prensa: " . $row["Nota_Prensa"] . "</p>";
            echo "<a href='detalles_videojuego.php?id=" . $row["id_videojuego"] . "&nombre=" . $row["nombre"] . "' class='btn btn-primary'>Ver detalles</a>";
            echo "</div>";
            echo "</div>";
          }
          echo "</div>";
        }
        $conn->close();
        ?>
      </div>
    </section>
    <section class="latest-movies">
      <h2>Últimas películas</h2>
      <div class="card-container">
        <?php
        // Establecer conexión a la base de datos
        $conn = mysqli_connect("localhost", "root", "", "MetaScore");

        if (!$conn) {
          die('Error de conexión: ' . mysqli_connect_error());
        }

        $sql = "SELECT * FROM Peliculas ORDER BY id_pelicula DESC LIMIT 5";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          echo "<div class='todo'>";
          while ($row = $result->fetch_assoc()) {
            echo "<div class='contenedor'><br>";
            echo "<img src='" . $row["imagen"] . "' class='card-img-top' style='width: 200px; class='card-img-top'>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-title'>" . $row["nombre"] . "</h5>";
            echo "<p class='card-text'>Nota de la prensa: " . $row["Nota_Prensa"] . "</p>";
            echo "<a href='detalles_pelicula.php?id=" . $row["id_pelicula"] . "&nombre=" . $row["nombre"] . "' class='btn btn-primary'>Ver detalles</a>";
            echo "</div>";
            echo "</div>";
          }
          echo "</div>";
        }

        $conn->close();
        ?>
      </div>
    </section>
  </main>
  <footer>
    <p>MetaScore &copy; 2023</p>
  </footer>
</body>

</html>