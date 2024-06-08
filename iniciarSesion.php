<?php
session_start();
include ("Conexion.php");

if (isset($_POST['Usuario']) && isset($_POST['Clave'])) {

    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $Usuario = validate($_POST['Usuario']);
    $Clave = validate($_POST['Clave']);

    if (empty($Usuario)) {
        header("Location: inicio_sesion.php?error=El usuario es requerido");
        exit();
    } elseif (empty($Clave)) {
        header("Location: inicio_sesion.php?error= La calve es requerida");
        exit();
    } else {
        //$Clave = md5($Clave);

        $Sql = "SELECT * FROM usuarios WHERE Usuario = '$Usuario' AND Clave='$Clave'";
        $result = mysqli_query($con, $Sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if ($row['Usuario'] === $Usuario && $row['Clave'] === $Clave) {
                $_SESSION['Usuario'] = $row['Usuario'];
                $_SESSION['Id'] = $row['Id'];
                header("Location: Inicio.php");
                exit();
            } else {
                header("Location: inicio_sesion.php?error=El usuario o la clave son incorrectas");
                exit();
            }
        } else {
            header("Location: inicio_sesion.php?error= El usuario o la clave son incorrectas");
            exit();
        }
    }

} else {
    header("Location: inicio_sesion.php");
    exit();
}