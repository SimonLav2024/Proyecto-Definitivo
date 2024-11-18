<?php
session_start();

include_once "../data_log/usuariobd.php";

$usuariobd = new UsuarioBD();

function redirigirConMensaje($url, $success, $mensaje){
    // almacena el resultado en la sesion
    $_SESSION["success"] = $success;
    $_SESSION["message"] = $mensaje;

    // realiza la redireccion
    header("Location: $url");
    exit();
}

// registro usuario
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["registro"])){
    $email = $_POST["email"];
    $password = $_POST["password"];

    $resultado = $usuariobd->registrarUsuario($email, $password);

    redirigirConMensaje("../index_log.php", $resultado['success'], $resultado['message']);
}

// inicio de sesion
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $resultado = $usuariobd->inicioSesion($email, $password);

    if($resultado['success'] == "success"){
        $_SESSION['user_id'] = $resultado['id'];
    }
    redirigirConMensaje("http://localhost/Proyecto-Definitivo/index_admin.php", $resultado['success'], $resultado['message']);
}

// recuperacion de contraseña
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["recuperar"])){
    $email = $_POST['email'];

    $resultado = $usuariobd->recuperarPassword($email);
    redirigirConMensaje("../index_log.php", $resultado['success'], $resultado['message']);
}