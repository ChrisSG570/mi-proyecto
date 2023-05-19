<?php

$conn = mysqli_connect($_ENV["DB_NAME"], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"], $_ENV["DB_DB"]);

if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}

if (isset($_GET["id_votoVideojuego"])) {
    $id_resena = $_GET['id_votoVideojuego'];

    // Obtener información de la reseña antes de borrarla
    $sql = "SELECT * FROM ResenasVideojuegos WHERE id_votoVideojuego=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_resena);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        die("Error al obtener información de la reseña: " . mysqli_error($conn));
    }

    $resena = mysqli_fetch_assoc($result);
    $id_juego = $resena['id_videojuego'];
    $puntuacion = $resena['nota'];

    // Borrar la reseña
    $sql = "DELETE FROM ResenasVideojuegos WHERE id_votoVideojuego=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_resena);
    mysqli_stmt_execute($stmt);

    if (!mysqli_stmt_affected_rows($stmt)) {
        die("Error al borrar la reseña: " . mysqli_error($conn));
    }

    // Actualizar la puntuación media del juego
    $sql = "SELECT AVG(nota) AS puntuacion_media FROM ResenasVideojuegos WHERE id_videojuego=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_juego);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        die("Error al obtener la puntuación media del juego: " . mysqli_error($conn));
    }

    $puntuacion_media = mysqli_fetch_assoc($result)['puntuacion_media'];

    $sql = "UPDATE Videojuegos SET Nota_Usuarios=? WHERE id_videojuego=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "di", $puntuacion_media, $id_juego);
    mysqli_stmt_execute($stmt);

    if (!mysqli_stmt_affected_rows($stmt)) {
        die("Error al actualizar la puntuación media del juego: " . mysqli_error($conn));
    }

    mysqli_close($conn);

    // Redirigir al usuario de vuelta al historial de reseñas
    header('Location: historial.php');
    exit();
} else if (isset($_GET["id_votoPelicula"])) {
    $id_resena = $_GET['id_votoPelicula'];

    // Obtener información de la reseña antes de borrarla
    $sql = "SELECT * FROM ResenasPeliculas WHERE id_votoPelicula=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_resena);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        die("Error al obtener información de la reseña: " . mysqli_error($conn));
    }

    $resena = mysqli_fetch_assoc($result);
    $id_pelicula = $resena['id_pelicula'];
    $puntuacion = $resena['nota'];

    // Borrar la reseña
    $sql = "DELETE FROM ResenasPeliculas WHERE id_votoPelicula=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_resena);
    mysqli_stmt_execute($stmt);

    if (!mysqli_stmt_affected_rows($stmt)) {
        die("Error al borrar la reseña: " . mysqli_error($conn));
    }

    // Actualizar la puntuación media de la película
    $sql = "SELECT AVG(nota) AS puntuacion_media FROM ResenasPeliculas WHERE id_pelicula=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_pelicula);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        die("Error al obtener la puntuación media de la película: " . mysqli_error($conn));
    }

    $puntuacion_media = mysqli_fetch_assoc($result)['puntuacion_media'];

    $sql = "UPDATE Peliculas SET Nota_Usuarios=? WHERE id_pelicula=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "di", $puntuacion_media, $id_pelicula);
    mysqli_stmt_execute($stmt);

    if (!mysqli_stmt_affected_rows($stmt)) {
        die("Error al actualizar la puntuación media de la película: " . mysqli_error($conn));
    }

    mysqli_close($conn);

    // Redirigir al usuario de vuelta al historial de reseñas
    header('Location: historial.php');
    exit();
}
?>