<?php
session_start();

if (isset($_SESSION["id_usuario"])) {
    $id_usuario = $_SESSION["id_usuario"];

    // Iniciamos la base de datos
    $mysqli = new mysqli("localhost", "root", "", "MetaScore");

    if ($mysqli->connect_error) {
        echo "Error al entrar a la base de datos";
    } else {
    
        if (isset($_GET["id_videojuego"])) {
            $id = $_GET["id_videojuego"];

            $sql = "DELETE FROM Favoritos WHERE id_videojuego = ? AND id_usuario = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ii", $id, $id_usuario);
            $resultado = $stmt->execute();

            if ($resultado) {
                header("location:favoritos.php");
            } else {
                echo "Error al borrar.";
            }

        } else if (isset($_GET["id_pelicula"])) {
            $id = $_GET["id_pelicula"];

            $sql = "DELETE FROM Favoritos WHERE id_pelicula = ? AND id_usuario = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ii", $id, $id_usuario);
            $resultado = $stmt->execute();

            if ($resultado) {
                header("location:favoritos.php");
            } else {
                echo $id;
            }
        } else {
            echo "Error al borrar.";
        }
    }
} else {
    echo "Error";
}
?>