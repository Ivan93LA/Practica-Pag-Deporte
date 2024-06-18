<?php
if (!isset($_GET['producto'])) {
    header("Location: principal.php");
} else {
    $idProducto = $_GET['producto'];

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

    //Se leen los datos de la BBDD

    $select = "SELECT * from producto where idProducto = '$idProducto'";
    $resultado = mysqli_query($conexion, $select);

    while ($row = $resultado->fetch_assoc()) {
        $titulo = $row['nombre'];
        $desc = $row['descripcion'];
        $imagen = $row['imagen'];
        $precio = $row['precio'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Producto</title>
    <link rel="stylesheet" href="../CSS/producto.css">
</head>

<body>

    <div class="container-principal">

        <nav class="nav">

            <div>
                <img class="Logo" src="../IMG/Logo.png" alt="">
            </div>
            <div class="jig">
                <h1>JIG NUTRISPORTS</h1>
            </div>

            <div class="lista-des">
                <ul>
                    <li>
                        <a class="" href="principal.php"><span>Principal<span></a>
                    </li>
                    <li>
                        <a class="" href="producto1.html"><span>Shop<span></a>
                    </li>
                    <li>
                        <a class="" href="#Seleccion"><span>categorías<span></a>
                    </li>
                    <li>
                        <a class="" href="aboutUS V2.html"><span>¡Conócenos! <span></a>
                    </li>

                </ul>

            </div>


            <div class="contenedor-BUL">



                <div class="barraBusqueda">
                    <p>Buscar: </p>

                    <input type="text" name="" id="">

                </div>

                <div class="usuario">
                    <a href="userHome.php"><img class="img-icono" src="../IMG/icono.jpg" alt=""></a>
                </div>

                <div class="login-active">
                    <a class="login" href="login.php">LOGIN</a>


                </div>
            </div>








        </nav>



        <div class="escaparate">
            <div class="imagen-producto">
                <img src="<?php echo $imagen ?>" alt="Imagen del producto">
            </div>
            <div class="detalles-producto">
                <h2>
                    <?php echo $titulo ?>
                </h2>
                <p>
                    <?php echo $desc ?>
                </p>
                <p class="precio">
                    <?php echo $precio ?> €
                </p>
                <button>Añadir al carrito</button>
            </div>
        </div>



    </div>



</body>

</html>