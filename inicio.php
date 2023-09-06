<?php
if (isset($_POST['publicar'])) {
    $sql = "INSERT INTO publicacion (id_autor, titulo, cuerpo, fecha_publicacion) VALUES (:id_autor, :titulo, :cuerpo, :fecha_publicacion)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_autor', $user['id']);
    $stmt->bindParam(':titulo', $_POST['titulo']);
    $stmt->bindParam(':cuerpo', $_POST['cuerpo']);
    $fecha = date('y/m/d');
    $stmt->bindParam(':fecha_publicacion', $fecha);
    //  str_replace('-','/',date('d-m-y' strtotime($fecha)))

    if ($stmt->execute()) {
        $_sql = "UPDATE usuarios SET publicaciones = publicaciones + 1 WHERE id = " . $user['id'];
        $_stmt = $conn->prepare($_sql);
        if ($_stmt->execute()) {
            header("Location: /EcoDemandas/index.php?op=1");
        }
    } else {
        $mensaje = 'Lo sentimos, ocurrió un error al intertar publicar';
    }
}



if (isset($_POST['guardar'])) {
    $tipo = '.jpg';
    $fotoPerfil = $_FILES['perfil']['tmp_name'];
    $nombrePerfil = $user['id'] . $tipo;

    $fotoPortada = $_FILES['portada']['tmp_name'];
    $nombrePortada = $user['id'] . $tipo;

    if (is_uploaded_file($fotoPerfil)) {
        $destino = 'img/contenedor/perfil/' . $nombrePerfil;
        $perfil = $nombrePerfil;
        copy($fotoPerfil, $destino);
    } else {
        $perfil = $user['perfil'];
    }

    if (is_uploaded_file($fotoPortada)) {
        $destino = 'img/contenedor/portada/' . $nombrePortada;
        $portada = $nombrePerfil;
        copy($fotoPortada, $destino);
    } else {
        $portada = $user['portada'];
    }

    $sql = "UPDATE usuarios SET usuario = :usuario, correo = :correo , telefono = :telefono , 
    ubicacion = :ubicacion , descripcion = :descripcion , perfil = :perfil , portada = :portada  WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $user['id']);
    $stmt->bindParam(':usuario', $_POST['usuario']);
    $stmt->bindParam(':correo', $_POST['correo']);
    $stmt->bindParam(':telefono', $_POST['telefono']);
    $stmt->bindParam(':ubicacion', $_POST['ubicacion']);
    $stmt->bindParam(':descripcion', $_POST['descripcion']);
    $stmt->bindParam(':perfil', $perfil);
    $stmt->bindParam(':portada', $portada);
    if ($stmt->execute()) {
        header("Location: /EcoDemandas/index.php?op=2");
    }
}
if (isset($_POST['actualizarcon'])) {
    $records = $conn->prepare('SELECT contrasena FROM usuarios WHERE id = :id');
    $records->bindParam(':id', $user['id']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $messager = '';

    if (is_countable($results) > 0 && password_verify($_POST['actual'], $results['contrasena'])) {
        $__sql = "UPDATE usuarios SET contrasena = :contrasena WHERE id = " . $user['id'];
        $__stmt = $conn->prepare($__sql);
        $contrasena = password_hash($_POST['nueva'], PASSWORD_BCRYPT);
        $__stmt->bindParam(':contrasena', $contrasena);
        if ($__stmt->execute()) {
            $messager = 'Contraseña actualizada';
        }
    } else {
        $messager = 'Contraseña actual incorrecta';
    }
}

if (isset($_POST['actnot'])) {
    $sql = "UPDATE publicacion SET titulo=:titulo, cuerpo=:cuerpo WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $_POST['id']);
    $stmt->bindParam(':titulo', $_POST['titulonue']);
    $stmt->bindParam(':cuerpo', $_POST['cuerponue']);
    if ($stmt->execute()) {
        header("Location: /EcoDemandas/index.php?op=1");
    }
}

?>
<div class="container">
    <div class="navegacion">
        <ul>
            <li>
                <a href="#">
                    <span class="icono"><img src="img/logo.svg" id="logo"></span>
                </a>
            </li>
            <li>
                <a href="index.php?op=0&estado=0">
                    <span class="icono">
                        <ion-icon name="document-text-outline"></ion-icon>
                    </span>
                    <span class="titulo">Publicar</span>
                </a>
            </li>
            <li>
                <a href="index.php?op=1">
                    <span class="icono">
                        <ion-icon name="home-outline"></ion-icon>
                    </span>
                    <span class="titulo">Inicio</span>
                </a>
            </li>
            <li>
                <a href="index.php?op=2">
                    <span class="icono">
                        <ion-icon name="people-outline"></ion-icon>
                        </ion-icon>
                    </span>
                    <span class="titulo">perfil</span>
                </a>
            </li>
            <li>
                <a href="index.php?op=5">
                    <span class="icono">
                        <ion-icon name="settings-outline"></ion-icon>
                    </span>
                    <span class="titulo">Configuración</span>
                </a>
            </li>
            <li>
                <a href="salir.php">
                    <span class="icono">
                        <ion-icon name="log-out-outline"></ion-icon>
                        </ion-icon>
                    </span>
                    <span class="titulo">Salir</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <span class="titulo">&copy; 2021 EcoDemandas</span>
                </a>
            </li>
        </ul>
    </div>
</div>

<div class="main">
    <div class="barraSuperior">
        <div class="barra">Bienvenido <?= $user['usuario']; ?></div>
        <div class="busqueda">
            <label>
                <input type="text" placeholder="Buscar">
                <ion-icon name="search-outline"></ion-icon>
            </label>
        </div>
        <div class="usuario">
            <img src="img/contenedor/perfil/<?= $user['perfil']; ?>">
        </div>
    </div>


    <?php
    $op = $_GET['op'];

    switch ($op) {
        case 0:
            switch ($_GET['estado']) {
                case 0: ?>
                    <div class="publicacion_">
                        <form method="POST">
                            <div class="contenedor_publicacion">
                                <h2 class="login__title">Publicar noticia</h2>
                                <div class="login__box">
                                    <ion-icon name="text-outline" class="login__icon"></ion-icon>
                                    <input type="text" placeholder="Titulo" name="titulo" class="login__input" required />
                                </div>
                                <div class="login__box">
                                    <ion-icon name="document-text-outline" class="login__icon"></ion-icon>
                                    <textarea name="cuerpo" cols="130" rows="18" placeholder="Cuerpo" class="login__textarea"></textarea>
                                </div>
                                <input type="submit" class="login__button" value="Publicar" name="publicar">
                            </div>
                        </form>
                    </div>
                <?php
                    break;
                case 1:
                    $records = $conn->prepare('SELECT id, titulo, cuerpo FROM publicacion WHERE id = :id');
                    $records->bindParam(':id', $_GET['id']);
                    $records->execute();
                    $results = $records->fetch(PDO::FETCH_ASSOC); ?>
                    <div class="publicacion_">
                        <form method="POST">
                            <div class="contenedor_publicacion">
                                <h2 class="login__title">Publicar noticia</h2>
                                <div class="login__box">
                                    <ion-icon name="text-outline" class="login__icon"></ion-icon>
                                    <input type="text" placeholder="Titulo" name="titulonue" class="login__input" required value="<?= $results['titulo']; ?>" />
                                    <input type="text" name="id" value="<?= $results['id']; ?>" hidden>
                                </div>
                                <div class="login__box">
                                    <ion-icon name="document-text-outline" class="login__icon"></ion-icon>
                                    <textarea name="cuerponue" cols="130" rows="18" placeholder="Cuerpo" class="login__textarea" ><?= $results['cuerpo']; ?></textarea>
                                </div>
                                <input type="submit" class="login__button" value="Actualizar" name="actnot">
                            </div>
                        </form>
                    </div>
            <?php
                    break;
                default:
            }
            break;
        case 1: ?>
            <div class="cuerpo" id="publi">


            </div>

        <?php
            break;
        case 2: ?>
            <section class="perfil-usuario" id="con">
                <div class="barra_"></div>
                <div class="contenedor-perfil">
                    <div class="portada-perfil" style="background-image: url('img/contenedor/portada/<?= $user['portada']; ?>');">
                        <div class="sombra"></div>
                        <div class="avatar-perfil">
                            <img src="img/contenedor/perfil/<?= $user['perfil']; ?>" alt="img">

                        </div>
                        <div class="datos-perfil">
                            <h4 class="titulo-usuario"><?= $user['usuario']; ?></h4>
                            <p class="bio-usuario"><?= $user['descripcion']; ?></p>
                            <ul class="lista-perfil">
                                <li><?= $user['publicaciones']; ?> Publicaciones</li>
                            </ul>
                        </div>
                        <div class="opcciones-perfil">
                            <button onclick="toggle()" type="">Editar</button>
                        </div>
                    </div>
                    <div class="perfil-usuario-footer">
                        <ul class="lista-datos">
                            <li>
                                <ion-icon name="mail-outline"></ion-icon></i> Correo: <?= $user['correo']; ?>
                            </li>
                            <li>
                                <ion-icon name="call-outline"></ion-icon></i> Telefono: <?= $user['telefono']; ?>
                            </li>
                            <li>
                                ⠀⠀
                            </li>
                        </ul>
                        <ul class="lista-datos">

                            <li>
                                <ion-icon name="location-outline"></ion-icon></i> Ubicacion: <?= $user['ubicacion']; ?>
                            </li>
                            <li>
                                <ion-icon name="calendar-outline"></ion-icon></i> Registro: <?= $user['registro']; ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
            <div class="modal" id="modal">
                <form action="" method="post" id="form" enctype="multipart/form-data">
                    <section class="form-register">


                        <a href="" onclick="toggle()" type="">
                            <ion-icon name="close-outline"></ion-icon>
                        </a>
                        <h2>Editar</h2>
                        <div class="otro">
                            <div class="portadacon" id="image2">
                                <div class="portada_" style="background-image:url('img/contenedor/portada/<?= $user['portada']; ?>'); ">
                                    <div class="editarPortada">
                                        <ion-icon name="camera-outline"></ion-icon>
                                    </div>
                                </div>
                            </div>
                            <input type="file" class="file" id="file2" name="portada">
                        </div>
                        <div class="usuario_">
                            <div id="image">
                                <img src="img/contenedor/perfil/<?= $user['perfil']; ?>">
                            </div>

                            <a href="#" class="cambiar-foto">
                                <input type="file" id="file" name="perfil">
                                <ion-icon name="camera-outline"></ion-icon>
                            </a>

                        </div>
                        <input class="controls" type="text" name="usuario" id="usuario" placeholder="Usuario" value="<?= $user['usuario']; ?>">
                        <input class="controls" type="text" name="descripcion" id="descripcion" placeholder="Descripcón" value="<?= $user['descripcion']; ?>">
                        <input class="controls" type="email" name="correo" id="correo" placeholder="Correo" value="<?= $user['correo']; ?>">
                        <input class="controls" type="text" name="telefono" id="telefono" placeholder="Teléfono" value="<?= $user['telefono']; ?>">
                        <input class="controls" type="texto" name="ubicacion" id="ubicacion" placeholder="Ubicación" value="<?= $user['ubicacion']; ?>">

                        <input class="botons" type="submit" name="guardar" value="Guardar">

                </form>
                </section>
            </div>

            <script type="text/javascript">
                function toggle() {
                    var dis = document.getElementById('con');
                    dis.classList.toggle('active')

                    var modal = document.getElementById('modal');
                    modal.classList.toggle('active')

                }
            </script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <script type="text/javascript">
                (function() {
                    function filePreview(input) {
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();

                            reader.onload = function(e) {
                                $('#image').html("<img src='" + e.target.result + "' /> <a href='#' class='cambiar-foto'><ion-icon name='camera-outline'></ion-icon></a> ");
                            }
                            reader.readAsDataURL(input.files[0]);
                        }
                    }

                    $('#file').change(function() {
                        filePreview(this);
                    });
                })();


                (function() {
                    function filePreview2(input) {
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();

                            reader.onload = function(e) {
                                $('#image2').html("<div class='portada_'  style='background-image: url(" + e.target.result + ");' />  <div class='editarPortada'> <ion-icon name='camera-outline'></ion-icon> </div> ");
                            }
                            reader.readAsDataURL(input.files[0]);
                        }
                    }

                    $('#file2').change(function() {
                        filePreview2(this);
                        console.log('hola')
                    });
                })();
            </script>
        <?php
            break;
        case 4:
            $records = $conn->prepare('SELECT publicacion.id, publicacion.id_autor, publicacion.titulo, publicacion.cuerpo, usuarios.usuario FROM publicacion INNER JOIN usuarios ON publicacion.id = :id AND publicacion.id_autor = usuarios.id');

            $records->bindParam(':id', $_GET['id']);
            $records->execute();
            $results = $records->fetch(PDO::FETCH_ASSOC); ?>
            <div class="lectura">
                <div class="cabecera_">
                    <div class="titulo_">
                        <h1><?= $results['titulo']; ?></h1>
                        <p>Autor(a): <b><?= $results['usuario']; ?></b></p>
                    </div>

                    <ul class="iconos_">
                        <li><a href="pdf.php?id=<?= $results['id']; ?>" target="_blank">
                        <ion-icon name="cloud-download-outline"></ion-icon>
                            </a></li>
                        <?php if ($user['id'] == $results['id_autor']) : ?>
                            <li><a href="index.php?op=0&estado=1&id=<?= $results['id']; ?>">
                                    <ion-icon name="document-text-outline"></ion-icon>
                                </a></li>
                            <li><a href="eliminar.php?id=<?= $results['id']; ?>" onclick=" return coneliminar()">
                                    <ion-icon name="trash-outline"></ion-icon>
                                </a></li>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="cuerpo_">
                    <?= str_replace("\n", "<br>", $results['cuerpo']);  ?>
                </div>
            </div>

            <script type="text/javascript">
                function coneliminar() {
                    var respuesta = confirm("¿Estas Seguro que deseas eliminar esta publicacion?");
                    if (respuesta == true) {
                        return true;
                    } else {
                        return false;
                    }
                }
            </script>
        <?php
            break;
        case 5: ?>
            <div class="ajustes-contenedor">
                <form action="" method="post">
                    <div class="ajustes">
                        <h2 class="login__title">Cambiar Contraseña</h2>
                        <div class="login__box">
                            <ion-icon name="key-outline" class="login__icon"></ion-icon>
                            <input type="password" placeholder="Contraseña Actual" name="actual" class="login__input" required />
                        </div>

                        <div class="login__box">
                            <ion-icon name="key-outline" class="login__icon"></ion-icon>
                            <input type="password" placeholder="Contraseña Nueva" name="nueva" class="login__input" required />
                        </div>

                        <input type="submit" class="login__button" value="Guardar" name="actualizarcon">

                    </div>
                </form>
            </div>
            <?php if (!empty($messager)) : ?>
                <div class="resultado">
                    <h3><?= $messager ?></h3>
                </div>
            <?php endif; ?>
    <?php
            break;
        default:

            header("Location: /EcoDemandas/index.php?op=1");
    }
    ?>
    <div id="maspublicaciones">

    </div>

</div>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="js/other.js"></script>