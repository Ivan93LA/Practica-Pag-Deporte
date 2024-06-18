<!DOCTYPE html>
<html lang="es">
<?php
// Iniciar la sesion
session_start();

if (isset($_POST['nombre']) && isset($_POST['contrasena']) && isset($_POST['email']) && isset($_POST['telefono'])) {
  $nombre_usuario = strip_tags($_POST['nombre']);
  $contrasena = strip_tags($_POST['contrasena']);
  $email = strip_tags($_POST['email']);
  $tel = strip_tags($_POST['telefono']);

  if (strlen(trim($nombre_usuario)) == 0 || strlen(trim($contrasena)) == 0) {
    header('Location: Registro.php');
    exit;
  }

  // Encripto la contraseña
  $hash = password_hash($contrasena, PASSWORD_DEFAULT);

  $servername = "localhost";
  $username = "root";
  $password = ""; // poner vuestra contraseña
  $dbname = "jig";

  $conexion = mysqli_connect($servername, $username, $password, $dbname);

  // Verifico la conexion por si no se conecta
  if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
  }

  // esta es el insert a la base de datos de user
  try {
    $sql = "INSERT INTO usuario (nombre, contrasena, email , telefono, rol) VALUES ('$nombre_usuario', '$hash' , '$email', '$tel', 'user')";

    if (mysqli_query($conexion, $sql)) {
      echo "Registro exitoso";

      //Se extrae el id del usuario y se pone en la ruta de la foto
      $sql = "SELECT id from usuario where nombre = '$nombre_usuario'";
      $resultado = mysqli_query($conexion, $sql);
      while ($row = $resultado->fetch_assoc()) {
        $id = $row['id'];
        $foto = "../IMG/usuarios/$id.jpg";
      }

      //Se sube la foto
      $imagenTemporal = $_FILES['foto']['tmp_name'];
      move_uploaded_file($imagenTemporal, $foto);

      //Se pone actualiza el campo imagen en la bbdd
      $sql = "update usuario set imagen = '$foto' where id = '$id'";
      try {
        mysqli_query($conexion, $sql);
      } catch (Exception $e) {
        echo "<p>Ha habido un error</p>";
      }

      header('Location: login.php');
    } else {
      echo "Error al registrar usuario: " . mysqli_error($conexion);
    }
  } catch (Exception $e) {
    if (mysqli_errno($conexion) == 1062) {
      echo "Ya existe este usuario";
    } else {
      echo "Error al registrar usuario: " . $e->getMessage();
    }
  }

}



?>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro</title>
  <link rel="stylesheet" href="../CSS/Registro.css">
</head>

<body>
  <nav class="nav">
    <div><img class="Logo" src="../IMG/Logo.png" alt=""></div>
    <div class="jig">
      <h1>JIG NUTRISPORTS</h1>
    </div>
    <div class="lista-des">
      <ul>
        <li><a class="" href="principal.php"><span>Principal<span></a> </li>
        <li>
          <a class="" href="producto1.html"><span>Shop<span></a>
        </li>
        <li> <a class="" href="principal.php"><span>categorías<span></a> </li>
        <li>
          <a class="" href="aboutUS V2.html"><span>¡Conócenos! <span></a>
        </li>
      </ul>
    </div>
  </nav>

  <div class="contenedor">
    <h1 class="Perfil">Registro de usuario</h1>
    <form method="POST" action="Registro.php" id="formulario" enctype="multipart/form-data">
      <!-- Lista de campos -->
      <ul>
        <li class="fila">
          <!-- text -->
          <input type="text" id="nombre" name="nombre" maxlength="30" size="30" placeholder="(nombre)"
            required="required" autofocus="autofocus" />
          <label for="nombre" class="propiedad">Nombre</label>


        </li>

        <!-- password -->
        <li class="fila">
          <input type="password" id="contrasena" name="contrasena" size="30" placeholder="(contraseña)"
            required="required" />
          <label for="password" class="propiedad">Contraseña</label>
        </li>

        <li class="fila">
          <input type="email" id="email" name="email" maxlength="30" size="30" placeholder="(email)" />
          <label for="email" class="propiedad">Email</label>
        </li>

        <li class="fila">
          <input type="tel" id="telefono" name="telefono" maxlength="9" size="11" placeholder="(teléfono)"
            pattern="[0-9]{9}" />
          <label for="telefono" class="propiedad">Teléfono</label>
        </li>

        <li class="fila">
          <input type="file" id="foto" name="foto" />
          <label for="foto" class="propiedad">Foto de perfil</label>
        </li>

        <li class="fila">
          <input type="submit" value="Enviar">
          <label for="" class="propiedad"></label>
        </li>
      </ul>

    </form>

  </div>
</body>

</html>