<?php
session_start();

if (!isset($_SESSION["id"])) {
    //Si no hay sesion iniciada. Se redirige al login.
    header("Location:./login.php");
} else {
    //Si hay sesion iniciada, se extraen los datos.

    $id = $_SESSION["id"];

    // Conexion a la base de datos
    $mysql_host = "localhost:3307";
    $mysql_database = "jig";
    $mysql_user = "root";
    $mysql_password = "";

    $conexion = mysqli_connect($mysql_host, $mysql_user, $mysql_password);
    mysqli_select_db($conexion, $mysql_database);

    if (mysqli_connect_errno()) {
        echo "Error al conectar con la base de datos: " . mysqli_connect_error();
        exit();
    }

    //Se extraen los datos
    $select = "SELECT * FROM usuario WHERE id = '$id'";

    $resultado = mysqli_query($conexion, $select);

    while ($row = $resultado->fetch_assoc()) {
        $nombre = $row['nombre'];
        $hash = $row['contrasena'];
        $email = $row['email'];
        $telefono = $row['telefono'];
        $imagen = $row['imagen'];
        $rol = $row['rol'];
    }

    //Si el usuario no es admin, se redirige al userHome
    if ($rol != "admin") {
        header("Location: userHome.php");
    }

}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Meu Perfil</title>
    <meta charset="utf-8">

    <link rel="stylesheet" href="../CSS/userHome.css">
</head>

<body>
    <!-- PERFIL DO USUÁRIO -->
    <section class="user-profile">
        <div class="header">
            <div class="cover">
                <div class="perfil-usuario-avatar">
                    <img src="http://www.coopernortetelecom.com.br/assets/images/author-1.png" alt="img-avatar">
                </div>
            </div>
        </div>
        </div>
        <div class="user-profile-body">


            <div class="user-profile-bio">
                <h3 class="titulo">
                    <?php echo $nombre ?>
                </h3>
                <h4 class="titulo">Panel de admin</h4>
            </div>
            <div class="user-profile-footer">
                <h2>Usuarios</h2>
                <div>
                    <?php
                    //Se cargan todos los usuarios
                    $selectAll = "SELECT * from usuario";
                    $resultado = mysqli_query($conexion, $selectAll);

                    while ($row = $resultado->fetch_assoc()) {
                        $idU = $row['id'];
                        $nombreU = $row['nombre'];
                        $hashU = $row['contrasena'];
                        $emailU = $row['email'];
                        $telefonoU = $row['telefono'];
                        $imagenU = $row['imagen'];
                        $rolU = $row['rol'];

                        //Se comprueba si se ha pedido cambiar admin/user
                        if (isset($_POST["admin$idU"])) {

                            //Si no es admin, se hace admin
                            if ($rolU != "admin") {
                                $sql = "UPDATE usuario SET rol = 'admin' where id = '$idU'";
                                try {
                                    mysqli_query($conexion, $sql);
                                    $rolU = "admin";
                                } catch (Exception $e) {
                                    return "<p>Ha habido un error</p>";
                                }
                            } else {

                                //Si ya es admin, se le cambia a user
                                $sql = "UPDATE usuario SET rol = 'user' where id = '$idU'";
                                try {
                                    mysqli_query($conexion, $sql);
                                    $rolU = "user";
                                } catch (Exception $e) {
                                    return "<p>Ha habido un error</p>";
                                }
                            }
                        }

                        //Se comprueba si se ha pedido eliminar la cuenta
                        if (isset($_POST["delete$idU"])) {
                            $delete = "DELETE FROM usuario where id = '$idU'";
                            //Se elimina la cuenta y se redirige al index
                            try {
                                mysqli_query($conexion, $delete);
                                //Si se elimina la cuenta, ya no se carga la ficha
                                continue;
                            } catch (Exception $e) {
                                return "<p>Ha habido un error</p>";
                            }
                        }

                        //Se imrpime la caja con la informacion del usuario, junto con el boton para hacer y quitar admin
                        echo "<div class='user-box'>";
                        echo "<ul>";
                        echo "
                        <li>
                            Nombre: $nombreU
                        </li>
                        <li>
                            Email: $emailU
                        </li>
                        <li>
                            Telefono: $telefonoU
                        </li>
                        <li>
                            Rol: $rolU
                        </li>
                        <form action='' method='post'>
                            <input type = 'submit' value='Hacer / quitar admin' name='admin$idU'/>
                        </form>
                        <form action='' method='post'>
                            <input type = 'submit' value='Eliminar cuenta' name='delete$idU'/>
                        </form>
                        ";
                        echo "</ul>";
                        echo "</div>";
                    }

                    ?>
                </div>
            </div>

            <div class="user-profile-footer">
                <a href="userHome.php">Volver a Mi perfil</a>
            </div>

        </div>
    </section>
</body>

</html>