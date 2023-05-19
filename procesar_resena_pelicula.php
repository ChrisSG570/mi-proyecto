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
    <nav class="navbar navbar-expand-lg bg-dark" class="navbar navbar-dark bg-dark">
        <!-- Código HTML del navbar -->
    </nav><br>

    <?php
    // Verificar si el usuario ha iniciado sesión
    if (isset($_SESSION["usuario"])) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id_pelicula = $_POST["id_pelicula"];
            $autor = $_POST["autor"];
            $nombre = $_POST["nombre"];
            $id_usuario = $_SESSION["id_usuario"];
            $texto = $_POST["comentario"];
            $nota = $_POST["nota"];
            $conn = mysqli_connect($_ENV["DB_DB"], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"], $_ENV["DB_NAME"]);

            // Verificar si la conexión a la base de datos fue exitosa
            if (!$conn) {
                die("Error de conexión: " . mysqli_connect_error());
            }

            // Utilizar sentencias preparadas para insertar la reseña de un usuario
            $insert_resena = "INSERT INTO ResenasPeliculas (id_pelicula, id_usuario, autor, nombre, resena, nota) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $insert_resena);
            mysqli_stmt_bind_param($stmt, "iisssd", $id_pelicula, $id_usuario, $autor, $nombre, $texto, $nota);

            // Ejecutar la sentencia preparada para insertar la reseña de un usuario
            if (mysqli_stmt_execute($stmt)) {
                // Calcular la media de las notas de las reseñas de la película
                $query_notas = "SELECT AVG(nota) AS media FROM ResenasPeliculas WHERE id_pelicula = ? and id_prensa is null";
                $stmt = mysqli_prepare($conn, $query_notas);
                mysqli_stmt_bind_param($stmt, "i", $id_pelicula);
                mysqli_stmt_execute($stmt);
                $result_notas = mysqli_stmt_get_result($stmt);
                $row_notas = mysqli_fetch_assoc($result_notas);
                $nota_media = $row_notas["media"];

                // Actualizar la nota de la película con la media calculada
                $update_nota = "UPDATE Peliculas SET Nota_Usuarios = ? WHERE id_pelicula = ?";
                $stmt = mysqli_prepare($conn, $update_nota);
                mysqli_stmt_bind_param($stmt, "di", $nota_media, $id_pelicula);
                mysqli_stmt_execute($stmt);

                // Redireccionar al usuario a la página de inicio
                header("Location:inicio.php");
            } else {
                echo "Error al insertar la reseña en la base de datos";
            }
            mysqli_close($conn);
        } else {
            echo "Falta el ID de la película";
        }
    }
    // Verificar si la prensa ha iniciado sesión
    else if (isset($_SESSION["nombre_prensa"])) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id_pelicula = $_POST["id_pelicula"];
            $autor = $_POST["autor"];
            $nombre = $_POST["nombre"];
            $id_prensa = $_SESSION["id_prensa"];
            $texto = $_POST["comentario"];
            $nota = $_POST["nota"];
            $conn = mysqli_connect($_ENV["DB_DB"], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"], $_ENV["DB_NAME"]);

            // Verificar si la conexión a la base de datos fue exitosa
            if (!$conn) {
                die("Error de conexión: " . mysqli_connect_error());
            }

            // Utilizar sentencias preparadas para insertar la reseña de la prensa
            $insert_resena = "INSERT INTO ResenasPeliculas (id_pelicula, id_prensa, autor, nombre, resena, nota) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $insert_resena);
            mysqli_stmt_bind_param($stmt, "iisssd", $id_pelicula, $id_prensa, $autor, $nombre, $texto, $nota);

            // Ejecutar la sentencia preparada para insertar la reseña de la prensa
            if (mysqli_stmt_execute($stmt)) {
                // Calcular la media de las notas de las reseñas de la película
                $query_notas = "SELECT AVG(nota) AS media FROM ResenasPeliculas WHERE id_pelicula = ? and id_usuario is null";
                $stmt = mysqli_prepare($conn, $query_notas);
                mysqli_stmt_bind_param($stmt, "i", $id_pelicula);
                mysqli_stmt_execute($stmt);
                $result_notas = mysqli_stmt_get_result($stmt);
                $row_notas = mysqli_fetch_assoc($result_notas);
                $nota_media = $row_notas["media"];

                // Actualizar la nota de la película con la media calculada
                $update_nota = "UPDATE Peliculas SET Nota_Prensa = ? WHERE id_pelicula = ?";
                $stmt = mysqli_prepare($conn, $update_nota);
                mysqli_stmt_bind_param($stmt, "di", $nota_media, $id_pelicula);
                mysqli_stmt_execute($stmt);

                // Redireccionar al usuario a la página de inicio
                header("Location:inicio.php");
            } else {
                echo "Error al insertar la reseña en la base de datos";
            }
            mysqli_close($conn);
        } else {
            echo "Falta el ID de la película";
        }
    } else {
        // Redireccionar al usuario a la página de inicio si no ha iniciado sesión
        header("Location: inicio.php");
    }
    ?>
</body>

</html>