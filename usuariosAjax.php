<?php
include './includes/conecction.php';

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';


if ($action == 'getTblUsuario') {
    $datos = (isset($_REQUEST['datos']) && $_REQUEST['datos'] != NULL) ? json_decode($_REQUEST['datos'], true) : '';
    extract($datos);
    $sqlUserType = ($userType != '') ? " WHERE ut.userType = '$userType'" : '';
    $queryUsers = mysqli_query($con, "SELECT CONCAT(p.nombre,' ',p.apellido) AS nombre, u.idUser, u.user AS usuario,  p.telefono FROM user u INNER JOIN user_type ut ON u.idUserType = ut.idUserType INNER JOIN persona p ON u.idPersona = p.idPersona" . $sqlUserType);
    $tbl = '';
    while ($r = mysqli_fetch_assoc($queryUsers)) {
        $idUser = $r['idUser'];
        $tbl .= "<tr>
                    <td>" . $r['nombre'] . "</td>
                    <td>" . $r['usuario'] . "</td>
                    <td>" . $r['telefono'] . "</td>
                    <td><button type='button' class='btn btn-outline-warning mb-1' onclick ='" . 'usuarios.showUsuarioEdit(this)' . "' data-id='" . $idUser . "'>Editar usuario</button>
                    <button type='button' class='btn btn-outline-dark mb-1' onclick ='" . 'usuarios.showPasswordEdit(this)' . "' data-id='" . $idUser . "'>Editar Contraseña</button></td>
                </tr>";
    }

    $array = array('tbl' => $tbl);
    echo json_encode($array);
} elseif ($action == 'agregarUsuario') {
    $datos = (isset($_REQUEST['datos']) && $_REQUEST['datos'] != NULL) ? json_decode($_REQUEST['datos'], true) : '';
    extract($datos);
    date_default_timezone_set("America/Mexico_City");
    $fecha = date('Y-m-d');

    $con->query("BEGIN");
    $queryPersona = mysqli_query($con, "INSERT INTO persona (nombre, apellido,telefono) VALUES ('$nombre','$apellido','$telefono')");
    $status = '';
    if ($queryPersona) {
        $idPersona = mysqli_insert_id($con);

        $queryUsuario = mysqli_query($con, "INSERT INTO user (idUserType,idPersona, user, password, fechaRegistro) VALUES  (1,'$idPersona', '$usuario', sha1('$password'),'$fecha') ");
        if ($queryUsuario) {
            $status = '1';
            $con->query("COMMIT");
        } else {
            $status = "0";
            $con->query("ROLLBACK");
        }
    } else {
        $status = '0';
    }

    echo json_encode(array("status" => $status));
} elseif ($action == 'getUsuario') {
    $datos = (isset($_REQUEST['datos']) && $_REQUEST['datos'] != NULL) ? json_decode($_REQUEST['datos'], true) : '';
    extract($datos);

    $queryUser = mysqli_query($con, "SELECT u.idUser, u.user AS usuario,p.nombre,p.apellido,p.telefono, p.idPersona FROM user u INNER JOIN persona p ON u.idPersona = p.idPersona WHERE u.idUser = '$idUser'");

    echo json_encode(mysqli_fetch_assoc($queryUser));
} elseif ($action == 'editarUsuario') {
    $datos = (isset($_REQUEST['datos']) && $_REQUEST['datos'] != NULL) ? json_decode($_REQUEST['datos'], true) : '';
    extract($datos);


    $persona = mysqli_fetch_assoc(mysqli_query($con, "SELECT idPersona FROM user WHERE idUser = '$idUser'"));
    $idPersona = $persona['idPersona'];

    if ($idPersona != '') {
        $con->query("BEGIN");
        $queryUpdateUser = mysqli_query($con, "UPDATE user SET user='$usuario' WHERE idUser = '$idUser'");
        if ($queryUpdateUser) {
            $queryUpdatePersona = mysqli_query($con, "UPDATE persona SET nombre = '$nombre', apellido = '$apellido', telefono = '$telefono' WHERE idPersona = '$idPersona'");
            if ($queryUpdatePersona) {
                $con->query("COMMIT");
                $status = "1";
            } else {
                $status = "0";
                $con->query("ROLLBACK");
            }
        } else {
            $status = "0";
            $con->query("ROLLBACK");
        }
    } else {
        $status = "0";
    }

    echo json_encode(array("status" => $status));
} elseif ($action == "editarPassword") {
    $datos = (isset($_REQUEST['datos']) && $_REQUEST['datos'] != NULL) ? json_decode($_REQUEST['datos'], true) : '';
    extract($datos);

    $queryUpdate = mysqli_query($con, "UPDATE user SET password = sha1('$password') WHERE idUser = '$idUser'");
    if ($queryUpdate) {
        echo json_encode(array("status" => 1));
    } else {
        echo json_encode(array("status" => 0));
    }
}
