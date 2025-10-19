<?php
require 'config.php';
require 'dao/UsuarioDaoMysql.php';

$usuarioDao = new UsuarioDaoMysql($pdo);

$id = filter_input(INPUT_GET, 'id');
if ($id) {

    $info = $usuarioDao->findById($id);

    if (!$info) {
        header("Location: index.php");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
?>
<h1>Editar Usuário</h1>

<form method="POST" action="editar_action.php">
    <input type="hidden" name="id" value="<?= $info->getId(); ?>" />

    <label>
        Nome:<br />
        <input type="text" name="name" value="<?= $info->getNome(); ?>" />
    </label><br /><br />

    <label>
        E-mail:<br />
        <input type="email" name="email" value="<?= $info->getEmail(); ?>" />
    </label><br /><br />

    <input type="submit" value="Salvar" />
</form>