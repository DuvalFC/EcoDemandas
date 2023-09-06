<?php
session_start();

if (isset($_SESSION['user_id'])) {
  header("Location: /EcoDemandas/index.php?op=1");
}

include("bd.php");

$mensaje = '';

if (isset($_POST['unirse'])) {
  $telefono ='No registrado';
  $descripcion = 'En Ecodemandas';
  $perfil = 'perfil.jpg';
  $portada = 'portada.jpg';
  $ubicacion = 'Colombia';
  $publicaciones= 0;
  $fecha = date('y/m/d');
  $sql = "INSERT INTO usuarios (usuario, correo, contrasena, telefono, ubicacion, registro, descripcion, publicaciones, perfil, portada) 
  VALUES (:usuario, :correo, :contrasena, :telefono, :ubicacion, :registro, :descripcion, :publicaciones, :perfil, :portada)";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':usuario', $_POST['usuario']);
  $stmt->bindParam(':correo', $_POST['correo']);
  $contrasena = password_hash($_POST['contrasena'], PASSWORD_BCRYPT);
  $stmt->bindParam(':contrasena', $contrasena);
  $stmt->bindParam(':telefono', $telefono);
  $stmt->bindParam(':ubicacion', $ubicacion);
  $stmt->bindParam(':registro', $fecha);
  $stmt->bindParam(':descripcion', $descripcion);
  $stmt->bindParam(':publicaciones', $publicaciones);
  $stmt->bindParam(':perfil', $perfil);
  $stmt->bindParam(':portada', $portada);


  

  if ($stmt->execute()) {
    $mensaje = 'Registro exitoso';
  } else {
    $mensaje = 'Lo sentimos, ocurrió un error al intertar registrar';
  }
}

if (isset($_POST['iniciar'])) {
  $records = $conn->prepare('SELECT id, usuario, correo, contrasena FROM usuarios WHERE usuario = :usuario');
  $records->bindParam(':usuario', $_POST['usuario2']);
  $records->execute();
  $results = $records->fetch(PDO::FETCH_ASSOC);

  $message = '';

  if (is_countable($results) > 0 && password_verify($_POST['contrasena2'], $results['contrasena'])) {
    $_SESSION['user_id'] = $results['id'];
    header("Location: /EcoDemandas/index.php?op=1");
  } else {
    $mensaje = 'Lo sentimos, usuario y/o contrasena erronea';
  }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style/styleAcceso.css" />
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
  <title>EcoDemandas | Ingreso</title>
</head>

<body>

  <?php if (!empty($mensaje)) : ?>
    <div class="resultado">
      <h3><?= $mensaje ?></h3>
    </div>
  <?php endif; ?>

  <div class="login">
    <div class="login__content">
      <div class="login__img">
        <img src="img/users.svg" alt="" />
      </div>

      <div class="login__forms">
        <form action="ingreso.php" class="login__registre" id="login-in" method="POST">
          <h1 class="login__title">Iniciar Sesión</h1>

          <div class="login__box">
            <ion-icon name="person-outline" class="login__icon"></ion-icon>
            <input type="text" placeholder="Usuario" name="usuario2" class="login__input" required />
          </div>

          <div class="login__box">
            <ion-icon name="key-outline" class="login__icon"></ion-icon>
            <input type="password" placeholder="Contraseña" name="contrasena2" class="login__input" required />
          </div>

          <a href="#" class="login__forgot">¿Olvidaste tu contraseña?</a>

          <input type="submit" class="login__button" value="Iniciar" name="iniciar">

          <div>
            <span class="login__account">¿No tienes cuenta aún?</span>
            <span class="login__signin" id="sign-up">Registrate</span>
          </div>
          <div class="login__social">
            <a href="index.php" class="login__social-icon">
              <img src="img/logo.svg" />
            </a>
          </div>
        </form>

        <form action="ingreso.php" class="login__create none" id="login-up" method="POST">
          <h1 class="login__title">Crea tu cuenta</h1>

          <div class="login__box">
            <ion-icon name="person-outline" class="login__icon"></ion-icon>
            <input type="text" placeholder="Ususario" name="usuario" class="login__input" required />
          </div>

          <div class="login__box">
            <ion-icon name="mail-outline" class="login__icon"></ion-icon>
            <input type="email" placeholder="Correo" name="correo" class="login__input" required />
          </div>

          <div class="login__box">
            <ion-icon name="key-outline" class="login__icon"></ion-icon>
            <input type="password" placeholder="Contraseña" name="contrasena" class="login__input" required />
          </div>
          <input type="submit" class="login__button" value="Unirse" name="unirse">
          <div>
            <span class="login__account">¿Ya tienes cuenta?</span>
            <span class="login__signup" id="sign-in">Inicia Sesión</span>
          </div>

          <div class="login__social">
            <a href="index.php" class="login__social-icon">
              <img src="img/logo.svg" />
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!--===== MAIN JS =====-->
  <script src="js/main.js"></script>
</body>


</html>