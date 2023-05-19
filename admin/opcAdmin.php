<?php
session_start();
//Esto sirve para confirmar si hay una cuenta iniciada que sea admin
if (isset($_SESSION["usuario"]) && ($_SESSION["admin"] == "si")) {
    ?>
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
            <div class="container py-5 h-50" style="text-align:center">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <form action="" method="post">
                        <button class="btn btn-primary btn-lg btn-block" name="introducir-videojuego" type="submit">Introducir nuevo videojuego</button>
                        <button class="btn btn-primary btn-lg btn-block" name="introducir-pelicula" type="submit">Introducir nueva pelicula</button>
                        <button class="btn btn-primary btn-lg btn-block" name="mostrar" type="submit">Mostrar o borrar videojuegos y películas</button>
                        <button class="btn btn-primary btn-lg btn-block" name="salir" type="submit">Salir</button>
                    </form>
                    <?php

                    if (isset($_POST["introducir-videojuego"])) {
                        header("location:introducirVideojuego.php");
                    }


                    if (isset($_POST["introducir-pelicula"])) {
                        header("location:introducirPelicula.php");
                    }

                    if (isset($_POST["mostrar"])) {
                        $mysqli = mysqli_connect($_ENV["DB_DB"], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"], $_ENV["DB_NAME"]);
                        if ($mysqli->connect_error) {
                            echo "Error al entrar a la base de datos";
                        } else {
                           //Sentencia SQL para mostrar todos los clientes con un boton de borrar (el botón solo aparecera si el usuario no es admin)
                           $sql = "SELECT * from videojuegos";
                           $stmt = $mysqli->prepare($sql);
                           $stmt->execute();
                           $resultado = $stmt->get_result();
                           //Creamos la tabla para imprimirlo
                           echo "<h1>Tabla Videojuegos</h1>";
                           echo "<table class='table'>";
                           echo "<thead>";
                           echo "<tr><th scope='col'>ID_videojuego</th><th scope='col'>Nombre</th><th scope='col'>Desarrolladora</th><th scope='col'>Nota_Prensa</th><th scope='col'>Nota_Usuarios</th></tr></thead>";
                           echo "<tbody>";
                           while ($row = $resultado->fetch_assoc()) {
                               //Imprimo valores
                               echo "<tr>";
                               echo "<th scope='row'>{$row['id_videojuego']}</th>";
                               echo "<td>{$row['nombre']}</td>";
                               echo "<td>{$row['desarrolladora']}</td>";
                               echo "<td>{$row['Nota_Prensa']}</td>";
                               echo "<td>{$row['Nota_Usuarios']}</td>";
                               echo "<td><a href='eliminarVideojuego.php?id_videojuego=" . $row["id_videojuego"] . "' class='btn btn-danger'>Borrar</a></td></tr>";
                           }
                           echo "</tbody></table><br>";

                           //Sentencia SQL para mostrar todos los clientes con un boton de borrar (el botón solo aparecera si el usuario no es admin)
                           $sql = "SELECT * from peliculas";
                           $stmt = $mysqli->prepare($sql);
                           $stmt->execute();
                           $resultado = $stmt->get_result();
                           //Creamos la tabla para imprimirlo
                           echo "<h1>Tabla Peliculas</h1>";
                           echo "<table class='table'>";
                           echo "<thead>";
                           echo "<tr><th scope='col'>ID_pelicula</th><th scope='col'>Nombre</th><th scope='col'>Distribuidora</th><th scope='col'>Nota_Prensa</th><th scope='col'>Nota_Usuarios</th></tr></thead>";
                           echo "<tbody>";
                           while ($row = $resultado->fetch_assoc()) {
                               //Imprimo valores
                               echo "<tr>";
                               echo "<th scope='row'>{$row['id_pelicula']}</th>";
                               echo "<td>{$row['nombre']}</td>";
                               echo "<td>{$row['distribuidora']}</td>";
                               echo "<td>{$row['Nota_Prensa']}</td>";
                               echo "<td>{$row['Nota_Usuarios']}</td>";
                               echo "<td><a href='eliminarPelicula.php?id_pelicula=" . $row["id_pelicula"] . "' class='btn btn-danger'>Borrar</a></td></tr>";
                           }
                           echo "</tbody></table>";

                           $resultado->close();
                       }

                        $mysqli->close();
                    }

                    //Botón que nos lleva a un formulario para meter nuevos productos
                    if (isset($_POST["introducir"])) {
                        header("location:introducir.php");
                    }
                    //Botón que nos lleva al catálogo
                    if (isset($_POST["salir"])) {
                        header("location:../inicio.php");
                    }


} else {
    header("location:catalogo.php");
}
?>
            </div>
        </div>
    </section>
</body>

</html>
