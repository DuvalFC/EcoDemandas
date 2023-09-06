<?php
session_start();

include('bd.php');

if (isset($_SESSION['user_id'])) {
  $records = $conn->prepare('SELECT id, usuario, correo, contrasena, telefono, ubicacion, registro, descripcion, publicaciones, perfil, portada FROM usuarios WHERE id = :id');
  $records->bindParam(':id', $_SESSION['user_id']);
  $records->execute();
  $results = $records->fetch(PDO::FETCH_ASSOC);

  $user = null;

  if (count($results) > 0) {
    $user = $results;
  }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>EcoDemandas</title>


  <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</head>

<body>
  <?php if (!empty($user)) : ?>
    <link rel="stylesheet" href="style/styleInterior.css" />
  <?php include("inicio.php");
  else : ?>
    <link rel="stylesheet" href="style.css" />

    <header>
      <a href="#" class="logo"><img src="img/logo.svg"></a>
      <ul>
        <li><a href="#">Inicio</a></li>
        <li><a href="#acerca">Acerca</a></li>
        <li><a href="#contacto">Contacto</a></li>
        <li><a href="ingreso.php" class="inicio_sesion">Ingresar</a></li>
      </ul>
    </header>
    <section>
      <img src="img/sol.png" id="sol" />
      <img src="img/montañas.png" id="montanas" />
      <img src="img/aves1.png" id="aves1" />
      <img src="img/aves2.png" id="aves2" />
      <img src="img/aves3.png" id="aves3" />
      <a href="ingreso.php" id="btn">Unirse</a>
      <img src="img/bosque.png" id="bosque" />
      <img src="img/valle.png" id="valle" />
      <img src="img/relleno.png" id="relleno" />
    </section>
    <div class="container" id="acerca">
      <div class="sec">
        <div class="imagen">
          <img src="img/mapa.svg" alt="" />
        </div>
        <div class="texto">
          <h2>EcoDemandas</h2>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam nisi
            possimus dolorum. Nam adipisci autem nemo animi dolor, quo eum
            beatae molestias, vel quidem maxime saepe repellendus in excepturi
            at reprehenderit voluptatum eveniet qui explicabo culpa accusamus
            praesentium? Numquam commodi tenetur qui fugit omnis eaque ex
            suscipit enim, libero voluptas!Lorem ipsum dolor sit amet
            consectetur adipisicing elit. Totam nisi possimus dolorum. Nam
            adipisci autem nemo animi dolor, quo eum beatae molestias, vel
            quidem maxime saepe repellendus in excepturi at reprehenderit
            voluptatum eveniet qui explicabo culpa accusamus praesentium?
            Numquam commodi tenetur qui fugit omnis eaque ex suscipit enim,
            libero volupta s!
          </p>
        </div>
      </div>

      <div class="sec">
        <div class="texto">
          <h2>EcoDemandas</h2>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam nisi
            possimus dolorum. Nam adipisci autem nemo animi dolor, quo eum
            beatae molestias, vel quidem maxime saepe repellendus in excepturi
            at reprehenderit voluptatum eveniet qui explicabo culpa accusamus
            praesentium? Numquam commodi tenetur qui fugit omnis eaque ex
            suscipit enim, libero voluptas!Lorem ipsum dolor sit amet
            consectetur adipisicing elit. Totam nisi possimus dolorum. Nam
            adipisci autem nemo animi dolor, quo eum beatae molestias, vel
            quidem maxime saepe repellendus in excepturi at reprehenderit
            voluptatum eveniet qui explicabo culpa accusamus praesentium?
            Numquam commodi tenetur qui fugit omnis eaque ex suscipit enim,
            libero volupta s!
          </p>
        </div>
        <div class="imagen" id="derecha">
          <img src="img/red_mundial.svg" />
        </div>
      </div>

      <div class="sec">
        <div class="imagen">
          <img src="img/cambio_climatico.svg" />
        </div>
        <div class="texto">
          <h2>EcoDemandas</h2>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam nisi
            possimus dolorum. Nam adipisci autem nemo animi dolor, quo eum
            beatae molestias, vel quidem maxime saepe repellendus in excepturi
            at reprehenderit voluptatum eveniet qui explicabo culpa accusamus
            praesentium? Numquam commodi tenetur qui fugit omnis eaque ex
            suscipit enim, libero voluptas!Lorem ipsum dolor sit amet
            consectetur adipisicing elit. Totam nisi possimus dolorum. Nam
            adipisci autem nemo animi dolor, quo eum beatae molestias, vel
            quidem maxime saepe repellendus in excepturi at reprehenderit
            voluptatum eveniet qui explicabo culpa accusamus praesentium?
            Numquam commodi tenetur qui fugit omnis eaque ex suscipit enim,
            libero volupta s!
          </p>
        </div>
      </div>
    </div>
    <footer id="contacto">
      <div class="olas">
        <div class="ola" id="ola1"></div>
        <div class="ola" id="ola2"></div>
        <div class="ola" id="ola3"></div>
        <div class="ola" id="ola4"></div>
      </div>
      <ul class="social">
        <li>
          <a href="#">
            <ion-icon name="logo-facebook"></ion-icon>
          </a>
        </li>
        <li>
          <a href="#">
            <ion-icon name="logo-instagram"></ion-icon>
          </a>
        </li>
        <li>
          <a href="#">
            <ion-icon name="logo-twitter"></ion-icon>
          </a>
        </li>
        <li>
          <a href="#">
            <ion-icon name="logo-youtube"></ion-icon>
          </a>
        </li>
      </ul>
      <ul class="menu">
        <li><a href="#">Inicio</a></li>
        <li><a href="#acerca">Acerca</a></li>
        <li><a href="#contacto">contacto</a></li>
      </ul>
      <p>&copy;2021 EcoDemandas | Todos los derechos reservados </p>
    </footer>
    <script>
      let sol = document.getElementById("sol");
      let montanas = document.getElementById("montanas");
      let aves1 = document.getElementById("aves1");
      let aves2 = document.getElementById("aves2");
      let aves3 = document.getElementById("aves3");
      let boton = document.getElementById("btn");
      let bosque = document.getElementById("bosque");
      let valle = document.getElementById("valle");
      let relleno = document.getElementById("relleno");
      let header = document.querySelector("header");

      window.addEventListener("scroll", function() {
        let valor = window.scrollY;
        aves1.style.left = valor * 0.18 + "px";
        aves2.style.left = valor * -0.25 + "px";
        aves3.style.top = valor * 0.25 + "px";
        aves3.style.left = valor * -0.25 + "px";

        sol.style.top = valor * 1.05 + "px";
        montanas.style.top = valor * 0.5 + "px";
        bosque.style.left = valor * -0.25 + "px";
        valle.style.top = valor * 0.08 + "px";
        boton.style.marginTop = valor * 0.5 + "px";
        header.style.top = valor * 0.5 + "px";
      });
    </script>
  <?php endif; ?>


</body>

</html>