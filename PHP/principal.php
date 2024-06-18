<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../CSS/principal.css" />
  <link rel="stylesheet" href="../CSS/principalResponsive.css" />

  <title>JIG NUTRISPORTS</title>
</head>

<body>
  <!-- Header -->
  <header class="header">
    <div class="header__containerLeft">
      <div class="header__containerLogo">
        <img class="header__logo" src="../IMG/Logo.png" alt="Logo Perfil" />
      </div>
      <div class="header__title">
        <h1 class="header__h1">JIG NUTRISPORTS</h1>
      </div>
      <nav class="header__nav">
        <ul class="header__ul">
          <li class="header__li">
            <a class="header__a" href="principal.php">Principal</a>
          </li>
          <li class="header__li">
            <a class="header__a" href="PlanesEntreno.html">Entrenamiento</a>
          </li>
          <li class="header__li">
            <a class="header__a" href="principal.php">categorías</a>
          </li>
          <li class="header__li">
            <a class="header__a" href="aboutUS V2.html">¡Conócenos!</a>
          </li>
        </ul>
      </nav>
    </div>
    <div class="header__containerBus">
      <div class="header__barraBusqueda">
        <label for="buscar" class="header__p">Buscar: </label>
        <input class="header__input" type="text" name="buscar" id="buscar" />
      </div>
      <?php
      //Se muestra login si no se ha iniciado sesion
      if (isset($_SESSION["id"])) {
        echo '
        <div class="header__containerUsuario">
          <a class="header__a" href="userHome.php">
            <img class="header__Usuario" class="img-icono" src="../IMG/icono.jpg" alt="" />
          </a>
        </div>
        ';
      } else {
        echo '
        <div class="header__containerLogin">
          <a class="header__a" href="login.php">LOGIN</a>
        </div>
        ';
      }
      ?>
    </div>
  </header>
  <!-- Video -->
  <section class="video">
    <video class="video__video" autoplay muted loop>
      <source class="video__videoSrc" src="../VIDEO/Find Your Limit _ Nike (Running Commercial_Short Film).mp4"
        type="video/mp4" />
    </video>
  </section>
  <!-- News -->
  <section class="news">

    <?php
    // Conexion a la base de datos
    $mysql_host = "localhost:3306";
    $mysql_database = "jig";
    $mysql_user = "root";
    $mysql_password = "";

    $conexion = mysqli_connect($mysql_host, $mysql_user, $mysql_password);
    mysqli_select_db($conexion, $mysql_database);

    if (mysqli_connect_errno()) {
      echo "Error al conectar con la base de datos: " . mysqli_connect_error();
      exit();
    }

    //Se cargan todos los productos
    $selectAll = "SELECT * from producto";
    $resultado = mysqli_query($conexion, $selectAll);

    while ($row = $resultado->fetch_assoc()) {
      $idProducto = $row['idProducto'];
      $titulo = $row['nombre'];
      $desc = $row['descripcion'];
      $imagen = $row['imagen'];
      $precio = $row['precio'];

      //Se carga la tarjeta del producto, que es un formulario que envia el id.
      echo "
      
      <form action='producto.php' method='get' class='news__containerProducto'>
        <input type = 'hidden' name='producto' value='$idProducto'/>
        <div class='news__contenedorImg'>
          <img class='news__img' src='$imagen' alt='' />
        </div>
        <div class='news__loremContainer'>
          <h1>$titulo</h1>
          <p class='news__p'>
            $desc
          </p>
          <h3>$precio €</h3>
        </div>
        <div class='news__buttonContainer'>
          <button class='news__button'>
            Mas informacion
          </button>
        </div>
      </form>

      ";

    }
    ?>
  </section>
  <section class="frase">
    <div class="frase__fraseContainer">
      <h1 class="frase__h1">¡ Buscando La excelencia en cada Deporte !</h1>
    </div>
    <div class="frase__imgContainer">
      <div class="frase__fotoEx">
        <img class="frase__img" src="../IMG/4488902-Benz.jpg" alt="" />
      </div>
      <div class="frase__fotoEx">
        <img class="frase__img frase__img--especial" src="../IMG/foto beisbol.jpg" alt="" />
      </div>
      <div class="frase__fotoEx">
        <img class="frase__img" src="../IMG/maravilla.jpg" alt="" />
      </div>
    </div>
  </section>
  <footer class="footer">
    <p>Derechos reservados &copy; 2023 Guilbert@Ivan@Pesca</p>
  </footer>
</body>

</html>