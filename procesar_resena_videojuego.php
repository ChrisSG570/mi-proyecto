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
<?php
if (isset($_SESSION["usuario"])) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Obtener los datos del formulario
        $id_videojuego = $_POST["id_videojuego"];
        $autor = $_POST["autor"];
        $nombre = $_POST["nombre"];
        $id_usuario = $_SESSION["id_usuario"];
        $texto = $_POST["comentario"];
        $nota = $_POST["nota"];

        // Conectar con la base de datos
        $conn = mysqli_connect($_ENV["DB_DB"], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"], $_ENV["DB_NAME"]);
        if (!$conn) {
            die("Error de conexión: " . mysqli_connect_error());
        }

        // Insertar la reseña en la tabla ResenasVideojuegos utilizando una consulta preparada
        $insert_resena = "INSERT INTO ResenasVideojuegos (id_videojuego, id_usuario, autor, nombre, resena, nota) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $insert_resena);
        mysqli_stmt_bind_param($stmt, "iisssi", $id_videojuego, $id_usuario, $autor, $nombre, $texto, $nota);
        if (mysqli_stmt_execute($stmt)) {

            // Calcular la media de las notas de ese videojuego
            $query_notas = "SELECT AVG(nota) AS media FROM ResenasVideojuegos WHERE id_videojuego = ? AND id_prensa IS NULL";
            $stmt = mysqli_prepare($conn, $query_notas);
            mysqli_stmt_bind_param($stmt, "i", $id_videojuego);
            mysqli_stmt_execute($stmt);
            $result_notas = mysqli_stmt_get_result($stmt);
            $row_notas = mysqli_fetch_assoc($result_notas);
            $nota_media = $row_notas["media"];

            // Actualizar la nota media del videojuego en la tabla Videojuegos
            $update_nota = "UPDATE Videojuegos SET Nota_Usuarios = ? WHERE id_videojuego = ?";
            $stmt = mysqli_prepare($conn, $update_nota);
            mysqli_stmt_bind_param($stmt, "di", $nota_media, $id_videojuego);
            mysqli_stmt_execute($stmt);

            // Redirigir al usuario a la página inicial
            header("Location:inicio.php");
            exit();
        } else {
            echo "Error al insertar la reseña en la base de datos";
        }

        mysqli_close($conn);
    } else {
        echo "Falta el ID del videojuego";
    }
} else if (isset($_SESSION["nombre_prensa"])) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Obtener los datos del formulario
        $id_videojuego = $_POST["id_videojuego"];
        $id_prensa = $_SESSION["id_prensa"];
        $autor = $_POST["autor"];
        $nombre = $_POST["nombre"];
        $texto = $_POST["comentario"];
        $nota = $_POST["nota"];

        // Conectar con la base de datos
        $conn = mysqli_connect($_ENV["DB_DB"], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"], $_ENV["DB_NAME"]);
        if (!$conn) {
            die("Error de conexión: " . mysqli_connect_error());
        }

        // Insertar la reseña en la tabla ResenasVideojuegos utilizando una consulta preparada
        $insert_resena = "INSERT INTO ResenasVideojuegos (id_videojuego, id_prensa, autor, nombre, resena, nota) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $insert_resena);
        mysqli_stmt_bind_param($stmt, "iisssi", $id_videojuego, $id_prensa, $autor, $nombre, $texto, $nota);
        if (mysqli_stmt_execute($stmt)) {

            // Calcular la media de las notas de ese videojuego
            $query_notas = "SELECT AVG(nota) AS media FROM ResenasVideojuegos WHERE id_videojuego = ? AND id_usuario IS NULL";
            $stmt = mysqli_prepare($conn, $query_notas);
            mysqli_stmt_bind_param($stmt, "i", $id_videojuego);
            mysqli_stmt_execute($stmt);
            $result_notas = mysqli_stmt_get_result($stmt);
            $row_notas = mysqli_fetch_assoc($result_notas);
            $nota_media = $row_notas["media"];

            // Actualizar la nota media del videojuego en la tabla Videojuegos
            $update_nota = "UPDATE Videojuegos SET Nota_Prensa = ? WHERE id_videojuego = ?";
            $stmt = mysqli_prepare($conn, $update_nota);
            mysqli_stmt_bind_param($stmt, "di", $nota_media, $id_videojuego);
            mysqli_stmt_execute($stmt);

            // Redirigir al usuario a la página del videojuego
            header("Location:inicio.php");
            exit();
        } else {
            echo "Error al insertar la reseña en la base de datos";
        }

        mysqli_close($conn);
    } else {
        echo "Falta el ID del videojuego";
    }
} else {
    header("Location:inicio.php");
    exit();
}
?>