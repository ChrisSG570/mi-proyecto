<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    //Recogemos el valor que hemos recibido por parametros
    if(isset($_GET["id_videojuego"])){
        $id = $_GET["id_videojuego"];

        //Iniciamos la base de datos
        $mysqli = new mysqli("localhost", "root", "", "MetaScore");

        if($mysqli -> connect_error){
            echo "Error al entrar a la base de datos";
        }else{

            $sql = "DELETE FROM ResenasVideojuegos WHERE id_videojuego = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", $id);
            $resultado = $stmt->execute();
            $stmt->close();

            if($resultado){

                $sql = "DELETE FROM videojuegos WHERE id_videojuego = ?";
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param("i", $id);
                $resultado = $stmt->execute();
                $stmt->close();

                //Si esto se realiza de manera exitosa nos redirige a opcAdmin.php
                if($resultado){
                    header("location:opcAdmin.php");
                }else{
                    echo $id;
                }
            }

            $sql = "DELETE FROM Favoritos WHERE id_videojuego = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", $id);
            $resultado = $stmt->execute();
            $stmt->close();

            if($resultado){

                $sql = "DELETE FROM videojuegos WHERE id_videojuego = ?";
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param("i", $id);
                $resultado = $stmt->execute();
                $stmt->close();

                //Si esto se realiza de manera exitosa nos redirige a opcAdmin.php
                if($resultado){
                    header("location:opcAdmin.php");
                }else{
                    echo $id;
                }
            }

            $mysqli->close();
        }
    }
    ?>
</body>
</html>
