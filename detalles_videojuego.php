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
    // Establecer conexión a la base de datos
    $conn = mysqli_connect($_ENV["DB_DB"], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"], $_ENV["DB_NAME"]);
    if (!$conn) {
        die('Error de conexión: ' . mysqli_connect_error());
    }

    // Obtener el id del videojuego desde la URL
    $id_videojuego = mysqli_real_escape_string($conn, $_GET['id']);
    $nombre = mysqli_real_escape_string($conn, $_GET["nombre"]);

    // Consultar la cantidad de reseñas del videojuego sin usuario asociado
    $sql = "SELECT COUNT(*) as num FROM ResenasVideojuegos WHERE id_videojuego = ? AND id_usuario IS NULL";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $id_videojuego);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = $row['num'];

    // Consultar información del videojuego
    $sql = "SELECT * FROM Videojuegos WHERE id_videojuego = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $id_videojuego);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result->num_rows > 0) {
        echo "<div class='presentacion'>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='portada'>";
            echo "<img src='" . $row["imagen"] . "'><br>";
            echo "</div>";
            echo "<div class='info'>";
            echo "<h1>" . $row["nombre"] . "</h1>";
            echo "<p><h3>" . $row["desarrolladora"] . "</h3></p>";
            echo "<p>" . $row["descripcion"] . "</p>";
            echo "<p>Nota de la prensa: " . $row["Nota_Prensa"] . " -> Basado en " . $count . " reseñas.</p>";
            echo "<p>Nota de los usuarios: " . $row["Nota_Usuarios"] . "</p>";
        }
    }

    // Verificar si hay un usuario logueado
    if (isset($_SESSION["id_usuario"])) {
        $id_usuario = $_SESSION["id_usuario"];

        // Consultar si el usuario ya ha escrito una reseña para este videojuego
        $sql = "SELECT * FROM ResenasVideojuegos WHERE id_usuario = ? AND id_videojuego = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $id_usuario, $id_videojuego);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result->num_rows > 0) {
            echo "Ya has escrito una reseña. <br>\n";
        } else {
            ?>
            <a href="escribir_resena_videojuego.php?id_videojuego=<?php echo $id_videojuego ?>&nombre=<?php echo $nombre ?>"
                class='btn btn-primary'>Escribir una reseña</a>
            <?php
        }

        // Consultar si el videojuego está en favoritos del usuario
        $sql = "SELECT * FROM Favoritos WHERE id_usuario = ? AND id_videojuego = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $id_usuario, $id_videojuego);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result->num_rows > 0) {
            echo "Ya lo has añadido a favoritos. <br>";
        } else {
            ?>
            <a href="favoritos.php?id_videojuego=<?php echo $id_videojuego ?>" class='btn btn-success'>Añadir a favoritos</a>
            <?php
        }
        ?>

        </div>
        </div>
        <?php
    } else if (isset($_SESSION["id_prensa"])) {
        $id_prensa = $_SESSION["id_prensa"];
        // Consultar si la prensa ya ha escrito una reseña para este videojuego
        $sql = "SELECT * FROM ResenasVideojuegos WHERE id_prensa = ? AND id_videojuego = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $id_prensa, $id_videojuego);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result->num_rows > 0) {
            echo "Ya has escrito una reseña. <br>";
        } else {
            ?>
                <a href="escribir_resena_videojuego.php?id_videojuego=<?php echo $id_videojuego ?>&nombre=<?php echo $nombre ?>"
                    class='btn btn-primary'>Escribir una reseña</a>
            <?php
        }
        echo "</div></div>";

        } else {
            
        echo "</div></div>";
    }

    // Mostrar reseñas de usuarios para el videojuego
    $conn = mysqli_connect($_ENV["DB_DB"], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"], $_ENV["DB_NAME"]);

    if (!$conn) {
        die('Error de conexión: ' . mysqli_connect_error());
    }

    $sql = "SELECT * FROM ResenasVideojuegos WHERE id_videojuego = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $id_videojuego);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='review'>";
            echo "<h3>" . $row["nombre"] . "</h3>";
            echo "<p> Opinión: " . $row["resena"] . "</p>";
            echo "<p> Nota: " . $row["nota"] . "</p>";
            echo "<p>Por " . $row["autor"] . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No se encontraron reseñas para este videojuego.</p>";
    }
    $conn->close();
    ?>
    </div>
    </div>
    </section>
    </body>

    </html>