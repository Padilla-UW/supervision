<?php
session_start();
$userType = $_SESSION["userType"];
?>
<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="./assets/img/logoUwipes.png" style="max-width: 70px;" alt=""></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                <li class="nav-item">
                    <a class="nav-link" href="visitas.php">Visitas</a>
                </li>
                <?php
                if ($userType == 'admin') :
                ?>
                    <li class="nav-item">
                        <a class="nav-link" href="usuarios.php">Usuarios</a>
                    </li>
                <?php
                endif;
                ?>
            </ul>
            <form class="d-flex">
                <button id="cerrarSession" type="button" class="btn btn-outline-info">Salir -></button>
            </form>
        </div>
    </div>
</nav> <br>
<script>
    let btnCerrarSession = document.querySelector("#cerrarSession");
    btnCerrarSession.addEventListener("click", async () => {
        const data = new FormData();
        data.append("action", "cerrarSession");
        await codigo.postData("loginAjax.php", data);
        window.location = "index.php";
    });
</script>