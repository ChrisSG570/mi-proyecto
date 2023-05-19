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
          <h1 class="card bg-dark text-white" style="border-radius: 1rem; text-align:center">MetaScore</h1>
          <div class="card bg-dark text-white" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">
              <div class="mb-md-5 mt-md-4 pb-5">
                <h2 class="fw-bold mb-2 text-uppercase">Registro: Usuario</h2>
                <p class="text-white-50 mb-5">Introduzca los datos para registrarse correctamente!</p>
                <form action="" method="post">
                  <div class="form-outline form-white mb-4">
                    <input type="text" name="nombre" class="form-control form-control-lg" />
                    <label class="form-label" for="usuario">Nombre de usuario</label>
                  </div>
                  <div class="form-outline form-white mb-4">
                    <input type="email" name="correo" class="form-control form-control-lg" />
                    <label class="form-label" for="correo">Correo Electrónico</label>
                  </div>
                  <div class="form-outline form-white mb-4">
                    <input type="password" name="contrasenia2" class="form-control form-control-lg" />
                    <label class="form-label" for="contrasenia2">Contraseña</label>
                  </div>
                  <div class="form-outline form-white mb-4">
                    <input type="password" name="rep-contrasenia2" class="form-control form-control-lg" />
                    <label class="form-label" for="rep-contrasenia2">Repita la contraseña</label>
                  </div>
                  <div class="form-outline form-white mb-4">
                    <label for="admin">¿Es usted admin?</label>
                    <select name="admin" id="admin">
                      <option value="si">Sí</option>
                      <option value="no">No</option>
                    </select>
                  </div>
                  <input type="submit" name="registrar" value="Registrarse">
                </form>
              </div>
              <div>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php
  //Validamos los POST del formulario
  if (isset($_POST["registrar"]) && isset($_POST["nombre"]) && isset($_POST["correo"]) && isset($_POST["contrasenia2"]) && isset($_POST["rep-contrasenia2"]) && isset($_POST["admin"])) {
    $nombre = $_POST["nombre"];
    $contraseña1 = $_POST["contrasenia2"];
    $contraseña2 = $_POST["rep-contrasenia2"];
    $correo = $_POST["correo"];
    $admin = $_POST["admin"];

    //Validamos si los valores introducidos son correctos
    if ($contraseña1 == $contraseña2 && !empty($nombre) && !empty($correo) && !empty($contraseña1)) {
      //Abrimos la base de datos
      $mysqli = mysqli_connect($_ENV["DB_DB"], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"], $_ENV["DB_NAME"]);
      if ($mysqli->connect_error) {
        echo "Error al conectar a la base de datos";
      } else {
        //Preparamos la consulta SQL con sentencias preparadas
        $sql = "INSERT INTO Usuarios (nombre, correo, contrasenia, admin) VALUES (?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        if ($stmt) {
          //Enlazamos los parámetros con los valores proporcionados por el usuario
          $stmt->bind_param("ssss", $nombre, $correo, $contraseña1, $admin);
          //Ejecutamos la consulta
          if ($stmt->execute()) {
            header("location: login_usuario.php");
            exit();
          } else {
            echo "Error al registrar el usuario";
          }
          $stmt->close();
        } else {
          echo "Error al preparar la consulta";
        }
      }
      $mysqli->close();
    } else {
      echo "Las contraseñas no coinciden.";
    }
  }
  ?>
</body>

</html>