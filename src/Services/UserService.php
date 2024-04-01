<?php

namespace App\Services;

use App\Utils\Validator;
use Exception;
use PDOException;
use App\Models\User;
use PDO;

/**
 * Classe responsável por fornecer serviços relacionados aos usuários.
 */
class UserService
{
    /**
     * Cria um novo usuário com base nos dados fornecidos.
     *
     * @param array $data Os dados do usuário a serem criados.
     * @return array|string Retorna uma mensagem de sucesso ou um array contendo uma mensagem de erro, se aplicável.
     */
    public static function create(array $data)
    {
        try {
            $fields = Validator::validate([
                'name'      => $data['name']        ?? '',
                'email'     => $data['email']       ?? '',
                'password'  => $data['password']    ?? '',
            ]);

            $fields['password'] = password_hash($fields['password'], PASSWORD_DEFAULT);

            $user = User::save($fields);

            if (!$user) return ['error' => 'Desculpe, não foi possível criar sua conta.'];

            return "Usuário criado com sucesso!";
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '08006') return ['error' => 'Desculpe, não foi possível conectar ao banco de dados.'];
            if ($e->errorInfo[0] === '23505') return ['error' => 'Desculpe, o usuário já existe.'];
            return ['error' => $e->getMessage()];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Autentica um usuário com base nos dados fornecidos.
     *
     * @param array $data Os dados de autenticação do usuário.
     * @return array Retorna os dados do usuário autenticado ou uma mensagem de erro, se aplicável.
     */
    public static function auth(array $data)
    {
        try {
            $fields = Validator::validate([
                'email' => $data['email'] ?? '',
                'password' => $data['password'] ?? '',
            ]);

            $user = User::authentication($fields);

            if (!$user) return ['error' => 'Desculpe, não foi possível autenticar você.'];

            return $user;
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '08006') return ['error' => 'Desculpe, não foi possível conectar ao banco de dados.'];
            return ['error' => $e->errorInfo[0]];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
