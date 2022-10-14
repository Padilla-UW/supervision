<?php
session_start();
include './includes/conecction.php';

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';

if ($action == 'login') {
    $datos = (isset($_REQUEST['datos']) && $_REQUEST['datos'] != NULL) ? json_decode($_REQUEST['datos'], true) : '';
    extract($datos);

    $queryLogin = mysqli_query($con, "SELECT * FROM user u INNER JOIN user_type ut ON u.idUserType = ut.idUserType 
	WHERE u.user='$user' AND u.password = SHA1('$password')");
    if (mysqli_num_rows($queryLogin) == 1) {
        $usuario = mysqli_fetch_assoc($queryLogin);
        $_SESSION['idUser'] = $usuario['idUser'];
        $_SESSION['userType'] = $usuario['userType'];
        $array = array("status" => 1, "msj" => "Ingresar");
    } else {
        $array = array("status" => 0, "msj" => "Datos errones");
    }
    echo json_encode($array);
} elseif ($action == 'cerrarSession') {
    session_destroy();
    echo json_encode("entra a cerrar");
}
