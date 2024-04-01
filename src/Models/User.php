<?php

namespace App\Models;

use App\Models\Database;
use PDO;

/**
 * Classe que representa a entidade de usuário no banco de dados.
 */
class User extends Database
{
    /**
     * Salva um novo usuário no banco de dados.
     *
     * @param array $data Os dados do usuário a serem salvos.
     * @return bool Retorna verdadeiro se o usuário foi salvo com sucesso, senão retorna falso.
     */
    public static function save(array $data)
    {
        $pdo = self::getConnection();

        $stmt = $pdo->prepare("
            INSERT INTO users (name, email, password)
            VALUES (?,?,?)
        ");

        $stmt->execute([
            $data['name'],
            $data['email'],
            $data['password'],
        ]);

        return $pdo->lastInsertId() > 0 ? true : false;
    }

    /**
     * Realiza a autenticação de um usuário com base no email e senha fornecidos.
     *
     * @param array $data Os dados de autenticação do usuário.
     * @return array|bool Retorna um array com os dados do usuário autenticado se for bem-sucedido, senão retorna falso.
     */
    public static function authentication(array $data)
    {
        $pdo = self::getConnection();

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? ");

        $stmt->execute([$data['email']]);

        if ($stmt->rowCount() < 1) return false;

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!password_verify($data[ 'password' ], $user['password'])) return false;

        return [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
        ];
    }
}
