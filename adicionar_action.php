<?php
require 'config.php';
require 'dao/UsuarioDaoMysql.php';

$name = filter_input(INPUT_POST, 'name');
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

if($name && $email) {

    $usuarioDao = new UsuarioDaoMysql($pdo);
    $usuario = new Usuario();
    $usuario->setEmail($email);
    $info = $usuarioDao->findByEmail($email);
    
    if($info === false) {
        $usuario = new Usuario();
        $usuario->setNome($name);
        $usuario->setEmail($email);
        $usuarioDao->add($usuario);
        
        header("Location: index.php");
        exit;
    } else {
        header("Location: adicionar.php");
        exit;
    }

} else {
    header("Location: adicionar.php");
    exit;
}