<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
</head>

<body>
  <section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card bg-dark text-white" style="border-radius: 1rem;">
            <h1 class=" fw-bold mb-2 text-uppercase" style="text-align:center">MetaScore</h1>
          </div><br>
          <div class="card bg-dark text-white" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">
              <div class="mb-md-5 mt-md-4 pb-5">
                <h2 class="fw-bold mb-2 text-uppercase">Login: Prensa</h2>
                <p class="text-white-50 mb-5">Introduzca su usuario y contraseña!</p>
                <form action="" method="post">
                  <div class="form-outline form-white mb-4">
                    <input type="text" name="nombre_prensa" class="form-control form-control-lg" />
                    <label class="form-label" for="Nombre Prensa">Nombre Prensa</label>
                  </div>
                  <div class="form-outline form-white mb-4">
                    <input type="password" name="contrasenia" class="form-control form-control-lg" />
                    <label class="form-label" for="contrasenia">Contraseña</label>
                  </div>
                  <input type="submit" name="inicio_sesion" value="Login">
                </form><br><br>
                <p class="mb-0"><a href="index.php " class="text-white-50 fw-bold">Entra directamente!</a></p><br>
                <p class="mb-0"><a href="login_usuario.php" class="text-white-50 fw-bold">Quieres entrar como
                    usuario?</a></p>
              </div>
              <div>
                <p class="mb-0">No tienes cuenta? <a href="register-prensa.php"
                    class="text-white-50 fw-bold">Registrate!</a>
                </p><br>
              </div>

              <?php
              // Validación de los datos para pasarlos a index.php 
              if (isset($_POST["inicio_sesion"]) && isset($_POST["nombre_prensa"]) && isset($_POST["contrasenia"])) {
                $nombre = $_POST["nombre_prensa"];
                $contrasenia = $_POST["contrasenia"];
                // Abrimos la base de datos
                $mysqli =  mysqli_connect($_ENV["DB_DB"], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"], $_ENV["DB_NAME"]);
                if ($mysqli->connect_error) {
                  echo "Error al conectar a la base de datos</p>";
                } else {
                  // Sentencia SQL con parámetros preparados
                  $sql = "SELECT * FROM prensa WHERE nombre = ? AND contrasenia = ?";
                  $stmt = $mysqli->prepare($sql);
                  $stmt->bind_param("ss", $nombre, $contrasenia);
                  $stmt->execute();
                  $result = $stmt->get_result();
                  if ($result->num_rows === 1) {
                    $fila = $result->fetch_assoc();
                    // Creo una sesión para almacenar si es admin o no y lo redirige a index.php 
                    $_SESSION["nombre_prensa"] = $nombre;
                    $_SESSION["id_prensa"] = $fila["id_prensa"];
                    header("location:index.php ");
                    exit;
                  } else {
                    echo "<p style='color: red'>Ha habido un error al iniciar sesión</p>";
                  }
                  $stmt->close();
                }
                $mysqli->close();
              } else if (isset($_SESSION["nombre_prensa"]) || isset($_SESSION["usuario"])) {
                session_destroy();
              }
              ?>
</body>
</div>
</div>
</div>
</div>
</div>
</section>

</html>