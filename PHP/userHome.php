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


  //Se comprueba si se ha enviado el formulario de actualizar datos.

  if (isset($_POST['actualizar'])) {
    $contrasena = $_POST['contrasena'];
    //Se comprueba si la contraseña es correcta
    if (password_verify($contrasena, $hash)) {
      //Se comprueba si se ha cambiado el nombre
      if (isset($_POST['nombre']) && !empty($_POST['nombre'])) {
        $nombre = $_POST['nombre'];
        //Se actualiza
        $sql = "UPDATE usuario SET nombre = '$nombre' where id = '$id'";
        try {
          mysqli_query($conexion, $sql);
        } catch (Exception $e) {
          return "<p>Ha habido un error</p>";
        }
      }

      //Se comprueba si se ha cambiado la contraseña
      if (isset($_POST['nuevacontrasena']) && !empty($_POST['nuevacontrasena'])) {
        //Se encripta la contraseña
        $nuevacontrasena = $_POST['nuevacontrasena'];
        $hasnuevacontrasenah = password_hash($nuevacontrasena, PASSWORD_DEFAULT);

        //Se actualiza
        $sql = "UPDATE usuario SET contrasena = '$nuevacontrasena' where id = '$id'";
        try {
          mysqli_query($conexion, $sql);
        } catch (Exception $e) {
          return "<p>Ha habido un error</p>";
        }
      }

      //Se comprueba si se ha cambiado el correo
      if (isset($_POST['email']) && !empty($_POST['email'])) {
        $email = $_POST['email'];
        //Se actualiza
        $sql = "UPDATE usuario SET email = '$email' where id = '$id'";
        try {
          mysqli_query($conexion, $sql);
        } catch (Exception $e) {
          return "<p>Ha habido un error</p>";
        }
      }

      //Se comprueba si se ha cambiado el telefono
      if (isset($_POST['telefono']) && !empty($_POST['telefono'])) {
        $telefono = $_POST['telefono'];
        //Se actualiza
        $sql = "UPDATE usuario SET telefono = '$telefono' where id = '$id'";
        try {
          mysqli_query($conexion, $sql);
        } catch (Exception $e) {
          return "<p>Ha habido un error</p>";
        }
      }

      //Se comprueba si se ha cambiado la foto
      if (isset($_FILES['foto']) && $_FILES['foto']['name'] != "") {
        $imagenTemporal = $_FILES['foto']['tmp_name'];
        move_uploaded_file($imagenTemporal, $imagen);
      }
    } else {
      echo "contraseña incorrecta";
    }
  }

  //Se comprueba si se ha enviado el formulario de eliminar cuenta
  if (isset($_POST["eliminar"])) {
    $contrasena = $_POST['contrasenaeliminar'];
    //Se comprueba si la contraseña es correcta
    if (password_verify($contrasena, $hash)) {
      $delete = "DELETE FROM usuario where id = '$id'";
      //Se elimina la cuenta y se redirige al index
      try {
        mysqli_query($conexion, $delete);
        header("Location:./login.php");
      } catch (Exception $e) {
        return "<p>Ha habido un error</p>";
      }
    } else {
      echo "contraseña incorrecta";
    }
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
        <div style='background-image: url(<?php echo $imagen ?>); background-position: center; background-size: cover'
          class="perfil-usuario-avatar">
        </div>
      </div>
    </div>
    </div>
    <div class="user-profile-body">


      <div class="user-profile-bio">
        <h3 class="titulo">
          <?php echo $nombre ?>
        </h3>
      </div>
      <div class="user-profile-footer">
        <h2>Actualizar datos</h2>
        <form method="POST" action="" enctype="multipart/form-data">
          <!-- Lista de campos -->
          <ul>
            <li class="fila">
              <!-- text -->
              <input type="text" id="nombre" name="nombre" maxlength="30" size="30"
                placeholder="<?php echo $nombre ?>" />
              <label for="nombre" class="propiedad">Nombre</label>


            </li>
            <!-- password -->
            <li class="fila">
              <input type="password" id="nuevacontrasena" name="nuevacontrasena" size="30"
                placeholder="(nueva contraseña)" />
              <label for="nuevacontrasena" class="propiedad">Nueva Contraseña</label>
            </li>

            <li class="fila">
              <input type="email" id="email" name="email" maxlength="30" size="30" placeholder="<?php echo $email ?>" />
              <label for="email" class="propiedad">Email</label>
            </li>

            <li class="fila">
              <input type="tel" id="telefono" name="telefono" maxlength="9" size="11"
                placeholder="<?php echo $telefono ?>" pattern="[0-9]{9}" />
              <label for="telefono" class="propiedad">Teléfono</label>
            </li>


            <li class="fila">
              <input type="file" id="foto" name="foto" />
              <label for="foto" class="propiedad">Foto de perfil</label>
            </li>

            <li class="fila">
              <input type="submit" value="Actualizar datos" name="actualizar">
            </li>

            <li class="fila">
              <input type="password" id="contrasena" name="contrasena" size="30" placeholder="(contraseña actual)"
                required />
              <label for="password" class="propiedad">Contraseña actual</label>
            </li>
          </ul>

        </form>

      </div>

      <div class="user-profile-footer">
        <h2>Eliminar cuenta</h2>
        <form action="" method="post">
          <ul>
            <li>
              <input type="password" id="contrasenaeliminar" name="contrasenaeliminar" size="30"
                placeholder="(contraseña actual)" required />
              <label for="contrasenaeliminar" class="propiedad">Contraseña actual</label>
            </li>
            <li>
              <input type="submit" value="Eliminar cuenta" name="eliminar">
            </li>
          </ul>

        </form>
      </div>

      <?php
      if ($rol == "admin") {
        echo '
        <div class="user-profile-footer">
        <a href="admin.php">Ir al panel de admin</a>
        </div>
        ';
      }
      ?>

      <div class="user-profile-footer">
        <a href="logout.php">Cerrar sesión</a>
      </div>

    </div>
  </section>
</body>

</html>