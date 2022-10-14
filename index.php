<?php
include 'includes/header.php';
?>

<div class="container">
    <div class="row justify-content-center align-items-center" style="height:70vh;">
        <div class="col-12 col-md-5 col-lg-4">
            <h1 class="text-center">Login</h1>
            <form>
                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuario</label>
                    <input type="text" class="form-control" id="usuario" placeholder="Usuario">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" placeholder="Contraseña"><br>
                </div>
                <div class="row">
                    <div id="msjLogin" class="col-12 text-center alert">

                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-6 d-grid">
                        <button type="button" id="ingresar" class="btn btn-outline-primary">Ingresar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="./assets/js/codigo.js"></script>
<script src="./assets/js/login.js?codigo"></script>

</body>

</html>