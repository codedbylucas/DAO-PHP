<?php

require_once 'models/Usuario.php';



class UsuarioDaoMysql implements UsuarioDAO
{
    private $pdo;

    public function __construct(PDO $driver)
    {
        $this->pdo = $driver;
    }

    public function add(Usuario $u) {
        $sql = $this->pdo->prepare('INSERT INTO usuarios (nome, email) VALUES (:nome, :email)');
        $sql->bindValue(':nome', $u->getNome());
        $sql->bindValue(':email', $u->getEmail());
        $sql->execute();

        $u->setId($this->pdo->lastInsertId());
        return $u;
    }

    public function findAll()
    {
        $array = [];

        $sql = $this->pdo->query('SELECT * FROM usuarios');
        if ($sql->rowCount() > 0) {
            $dados = $sql->fetchAll(PDO::FETCH_ASSOC);

            foreach ($dados as $item) {
                $u = new Usuario();
                $u->setId($item['id_user']);
                $u->setNome($item['nome']);
                $u->setEmail($item['email']);

                $array[] = $u;
            }
        }

        return $array;
    }

    public function findById($id)
    {
        $sql = $this->pdo->prepare('SELECT * FROM usuarios WHERE id_user = :id');
        $sql->bindValue(':id', $id);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $data = $sql->fetch(PDO::FETCH_ASSOC);

            $u = new Usuario();
            $u->setId($data['id_user']);
            $u->setNome($data['nome']);
            $u->setEmail($data['email']);

            return $u;
        }

        return false;
    }

    public function findByEmail($email)
    {
        $sql = $this->pdo->prepare('SELECT * FROM usuarios WHERE email = :email');
        $sql->bindValue(':email', $email);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $data = $sql->fetch(PDO::FETCH_ASSOC);

            $u = new Usuario();
            $u->setId($data['id_user']);
            $u->setNome($data['nome']);
            $u->setEmail($data['email']);

            return $u;
        }

        return false;
    }

    public function update(Usuario $u)
    {
        $sql = $this->pdo->prepare('UPDATE usuarios SET nome = :nome, email = :email WHERE id_user = :id');
        $sql->bindValue(':nome', $u->getNome());
        $sql->bindValue(':email', $u->getEmail());
        $sql->bindValue(':id', $u->getId());
        $sql->execute();
    }

    public function delete($id)
    {
        $sql = $this->pdo->prepare('DELETE FROM usuarios WHERE id_user = :id');
        $sql->bindValue(':id', $id);
        $sql->execute();
    }
}
