<?php
require 'config.php';
require 'dao/UsuarioDaoMysql.php';

$id = filter_input(INPUT_GET, 'id');
if ($id) {

    $usuarioDao = new UsuarioDaoMysql($pdo);
    $usuarioDao->delete($id);
}

header("Location: index.php");
exit;
