<?php
// Iniciar la sesion
session_start();

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

// Comprobamos que los inputs del formulario no estan vacios
if (!empty($_POST['usuario'])) {
  $usuario = $_POST['usuario'];
}
if (!empty($_POST['passwd'])) {

  $passwd = $_POST['passwd'];

  // Comprovamos si se trata del nombre de ususario o por lo contrario de un correo electronico
  if (str_contains($usuario, "@")) {
    $select_hash = "SELECT contrasena FROM usuario WHERE email LIKE '$usuario'";
  } else {
    $select_hash = "SELECT contrasena FROM usuario WHERE nombre LIKE '$usuario'";
  }

  //Peticion a la BBDD 
  $resultado = mysqli_query($conexion, $select_hash);

  while ($row = $resultado->fetch_assoc()) {
    $dbPasswd = $row['contrasena'];
  }



}

// Comprobamos que existen y ademas no son nulos
if (isset($usuario) && isset($passwd) && isset($dbPasswd)) {
  if (password_verify($passwd, $dbPasswd)) {
    //Añadimos el id a la sesion
    if (str_contains($usuario, "@")) {
      $resultado = mysqli_query($conexion, "SELECT id FROM usuario WHERE email LIKE '$usuario'");

      while ($row = $resultado->fetch_assoc()) {
        $id = $row['id'];
      }
      $_SESSION["id"] = $id;
    } else {
      $resultado = mysqli_query($conexion, "SELECT id FROM usuario WHERE nombre LIKE '$usuario'");

      while ($row = $resultado->fetch_assoc()) {
        $id = $row['id'];
      }
      $_SESSION["id"] = $id;
    }
    //Redirigir al index
    header("Location:./principal.php");
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="stylesheet" href="../CSS/login.css">
  <title>Inicio Sesion</title>
</head>

<body>
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
          <a class="" href="principal.php"><span class="q">Principal<span></a>
        </li>
        <li>
          <a class="" href="producto.html"><span>Shop<span></a>
        </li>
        <li>
          <a class="" href="Mini-pag-about.html"><span>categorías<span></a>
        </li>
        <li>
          <a class="" href="aboutUS.html"><span>¡Conócenos! <span></a>
        </li>
      </ul>
    </div>
  </nav>
  <div class="iniciar">
    <h2>
      INICIAR SESION
    </h2>
  </div>
  <div class="form">
    <form class="login-form" method="post" action="../PHP/login.php">
      <input type="text" placeholder="username" name="usuario" />
      <input type="password" placeholder="password" name="passwd" />
      <button>login</button>
      <p class="message">¿No estás registrado? <a href="Registro.php">Registrate</a></p>
    </form>
  </div>
  </div>
  </head>
</body>

</html>