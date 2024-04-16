<section class="mb-3 d-block text-center border p-3 border-3 border-black rounded-pill bg-white">
    <img src="publico/img/usuarios/<?php if ($_SESSION['foto'] != '') 
    {
        echo $_SESSION['foto'];
    } else {
        echo 'usuario_default.png';
    }
    ?>" alt="" class="rounded-circle mw-100 border border-3 border-black"> 
    <p class="m-1 border border-3 border-black rounded-3 bg-black text-white py-1 mt-2 mb-2"><b><?php echo $_SESSION['usuario'];?></b></p><a href="?c=Usuario&a=cerrarSesion" class="btn btn-info border border-3 border-black text-black mb-2"><b>Cerrar sesión</b></a> 
</section>

<ul class="navbar-nav text-center navbar-nav-scroll" >
    <li class="nav-item btn-primary mb-2 btn border-white" >
        <a href="?c=Juego&a=mostrarJuegos" class="nav-link bi-controller"> Listado Juegos</a>
    </li>
    <?php
    if ($_SESSION['tipo'] == "Administrador") {
    ?>
    <li class="nav-item btn-primary mb-2 btn border-white boton">
        <a href="?c=Usuario&a=altaUsuario" class="nav-link bi-person-plus-fill"> Alta de Usuario</a>
    </li>
    <li class="nav-item btn-primary mb-2 btn border-white">
        <a href="?c=Usuario&a=mostrarInfoUsuarios" class="nav-link bi-person-fill"> Listado Usuarios</a>
    </li>
    <li class="nav-item btn-primary mb-2 btn border-white">
        <a href="?c=Juego&a=altaJuego" class="nav-link bi-controller"> Alta de Juegos</a>
    </li>
    <?php
    }
    ?>
    <li class="nav-item btn-primary mb-2 btn border-white">
        <a href="?c=Juego&a=preferencias" class="nav-link bi-gear-fill"> Preferencias</a>
    </li>
    <li class="nav-item btn-primary mb-2 btn border-white">
        <a href="?c=Juego&a=listarFavoritos" class="nav-link bi-star-fill"> Favoritos</a>
    </li>
</ul>

