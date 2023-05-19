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

                    if (isset($_SESSION["id_usuario"])) {
                        echo "<li class='nav-item'>";
                        echo "<a class='nav-link' href='favoritos.php'>Favoritos</a>";
                        echo "</li>";
                    }

                    if ($_SESSION["admin"] == "si") {
                        echo "<li class='nav-item'>";
                        echo "<a class='nav-link' href='admin/opcAdmin.php'>Opciones ADMIN</a>";
                        echo "</li>";
                    }

                    ?>
                    ?>
                </ul>
                <div class="navbar-text">
                    <a class="nav-link" href="login_usuario.php">Login</a>
                </div>
            </div>
        </div>
    </nav><br>
    <div class="container py-5 h-50" style="text-align:center">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <?php
            $conn = mysqli_connect($_ENV["DB_DB"], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"], $_ENV["DB_NAME"]);

            if (!$conn) {
                die('Error de conexión: ' . mysqli_connect_error());
            }

            if (isset($_SESSION["id_usuario"])) {
                $id_usuario = $_SESSION["id_usuario"];

                // Realizar una consulta SQL para obtener las reseñas de videojuegos del usuario actual
                $stmt = $conn->prepare("SELECT r.*, v.nombre AS nombre_videojuego FROM ResenasVideojuegos r JOIN Videojuegos v ON r.id_videojuego = v.id_videojuego WHERE r.id_usuario = ?");
                $stmt->bind_param("i", $id_usuario);
                $stmt->execute();
                $result = $stmt->get_result();
                ?>
                <!DOCTYPE html>
                <html>

                <head>
                    <title>Historial de reseñas</title>
                </head>

                <body>
                    <h1>Historial de reseñas</h1>

                    <?php if ($result->num_rows > 0): ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope='col'>Videojuego</th>
                                    <th scope='col'>Reseña</th>
                                    <th scope='col'>Nota</th>
                                    <th scope='col'>Borrar reseña</th>
                                </tr>
                            <tbody>
                                </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <th scope='row'>
                                            <?php echo $row["nombre_videojuego"]; ?>
                                        </th>
                                        <td>
                                            <?php echo $row["resena"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["nota"]; ?>
                                        </td>
                                        <td><a href="borrar_resena.php?id_votoVideojuego=<?php echo $row["id_votoVideojuego"]; ?>"
                                                class='btn btn-danger'>Borrar reseña</a></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No se encuentran reseñas de videojuegos</p>
                    <?php endif; ?>
                </body>

                </html>
                <?php
                // Obtener las reseñas de películas del usuario actual
                $stmt = $conn->prepare("SELECT r.*, p.nombre AS nombre_pelicula FROM ResenasPeliculas r JOIN Peliculas p ON r.id_pelicula = p.id_pelicula WHERE r.id_usuario = ?");
                $stmt->bind_param("i", $id_usuario);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0):
                    ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Película</th>
                                <th>Reseña</th>
                                <th>Nota</th>
                                <th>Borrar reseña</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <th scope="row">
                                        <?php echo $row["nombre_pelicula"]; ?>
                                    </th>
                                    <td>
                                        <?php echo $row["resena"]; ?>
                                    </td>
                                    <td>
                                        <?php echo $row["nota"]; ?>
                                    </td>
                                    <td><a href="borrar_resena.php?id_votoPelicula=<?php echo $row["id_votoPelicula"]; ?>"
                                            class='btn btn-danger'>Borrar reseña</a></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No se encuentran reseñas de películas</p>
                <?php endif; ?>

                <?php
                $stmt->close();
                $conn->close();

            } else if (isset($_SESSION["id_prensa"])) {
                $conn = mysqli_connect($_ENV["DB_DB"], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"], $_ENV["DB_NAME"]);

                if (!$conn) {
                    die('Error de conexión: ' . mysqli_connect_error());
                }

                $id_prensa = $_SESSION["id_prensa"];

                // Obtener las reseñas de videojuegos de la prensa actual
                $stmt = $conn->prepare("SELECT r.*, v.nombre AS nombre_videojuego FROM ResenasVideojuegos r JOIN Videojuegos v ON r.id_videojuego = v.id_videojuego WHERE r.id_prensa = ?");
                $stmt->bind_param("i", $id_prensa);
                $stmt->execute();
                $result = $stmt->get_result();
                ?>

                    <body>
                        <h1>Historial de reseñas</h1>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Videojuego</th>
                                    <th scope="col">Reseña</th>
                                    <th scope="col">Nota</th>
                                    <th scope="col">Borrar reseña</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <th scope="row">
                                            <?php echo $row["nombre_videojuego"]; ?>
                                            </th>
                                            <td>
                                            <?php echo $row["resena"]; ?>
                                            </td>
                                            <td>
                                            <?php echo $row["nota"]; ?>
                                            </td>
                                            <td><a href="borrar_resena_prensa.php?id_votoVideojuego=<?php echo $row["id_votoVideojuego"]; ?>"
                                                    class='btn btn-danger'>Borrar reseña</a></td>
                                        </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                    <tr>
                                        <td colspan="4">No hay reseñas registradas</td>
                                    </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </body>

        </html>
        <?php
        // Obtener las reseñas de películas de la prensa actual
        $stmt = $conn->prepare("SELECT r.*, p.nombre AS nombre_pelicula FROM ResenasPeliculas r JOIN Peliculas p ON r.id_pelicula = p.id_pelicula WHERE r.id_prensa = ?");
        $stmt->bind_param("i", $id_prensa);
        $stmt->execute();
        $result = $stmt->get_result();
        ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Pelicula</th>
                    <th scope="col">Reseña</th>
                    <th scope="col">Nota</th>
                    <th scope="col">Borrar reseña</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <th scope="row">
                            <?php echo $row["nombre_pelicula"]; ?>
                            </th>
                            <td>
                            <?php echo $row["resena"]; ?>
                            </td>
                            <td>
                            <?php echo $row["nota"]; ?>
                            </td>
                            <td><a href="borrar_resena_prensa.php?id_votoPelicula=<?php echo $row["id_votoPelicula"]; ?>"
                                    class='btn btn-danger'>Borrar reseña</a></td>
                        </tr>
                <?php endwhile; ?>
            <?php else: ?>
                    <tr>
                        <td colspan="4">No hay reseñas registradas</td>
                    </tr>
            <?php endif; ?>
            </tbody>
        </table>
        <?php
        $stmt->close();
        $conn->close();

            } else {
                echo "Debe iniciar sesión como usuario o prensa para acceder a esta página.";
            }
            ?>

</div>
</body>

</html>