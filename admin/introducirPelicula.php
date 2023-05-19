<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css.css">
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
                    <h1 class="card bg-dark text-white" style="border-radius: 1rem; text-align:center;">Introducir nueva película</h1>
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <div class="mb-md-5 mt-md-4 pb-5">
                                <form action="" method="POST">
                                    <div class="form-outline form-white mb-4">
                                        <input type="text" name="nombre_pelicula" class="form-control form-control-lg" />
                                        <label class="form-label" for="nombre_pelicula">Nombre de la película:</label>
                                    </div>
                                    <div class="form-outline form-white mb-4">
                                        <input type="text" name="distribuidora" class="form-control form-control-lg" />
                                        <label class="form-label" for="distribuidora">Distribuidora:</label>
                                    </div>
                                    <div class="form-outline form-white mb-4">
                                        <input type="text" name="caratula" class="form-control form-control-lg" />
                                        <label class="form-label" for="caratula">Caratula:</label>
                                    </div>
                                    <div class="form-outline form-white mb-4">
                                        <label for="">Descripcion:</label>
                                        <textarea class="form-control form-control-lg" name="descripcion"></textarea><br>
                                        <input type="submit" name="añadir" value="Insertar Película">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
    if (isset($_POST["añadir"])) {
        //Recogemos los post del formulario
        $nombre = $_POST["nombre_pelicula"];
        $distribuidora = $_POST["distribuidora"];
        $caratula = $_POST["caratula"];
        $descripcion = $_POST["descripcion"];
        //Abrimos la base de datos
        $mysqli = mysqli_connect($_ENV["DB_NAME"], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"], $_ENV["DB_DB"]);
        if ($mysqli->connect_error) {
            echo "Error al entrar a la base de datos";
        } else {
            //Creamos la sentencia SQL con sentencias preparadas
            $sql = "INSERT INTO peliculas (nombre, distribuidora, imagen, descripcion) VALUES (?, ?, ?, ?)";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ssss", $nombre, $distribuidora, $caratula, $descripcion);
            $resultado = $stmt->execute();

            if ($resultado) {
                header("location:opcAdmin.php");
            } else {
                echo "Error al insertar la película";
            }

            $stmt->close();
            $mysqli->close();
        }
    }
    ?>
</body>

</html>
