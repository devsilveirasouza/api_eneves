<?php

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;
use App\Services\UserService;

class UserController
{
    /**
     * Armazena um novo usuário no sistema.
     * 
     * @param Request $request Objeto contendo os dados da requisição.
     * @param Response $response Objeto para manipulação da resposta da requisição.
     * @return mixed Retorna a resposta da requisição em formato JSON.
     */
    public function store(Request $request, Response $response)
    {
        $body = $request::body();

        // Cria um novo usuário através do serviço UserService.
        $userService = UserService::create($body);

        // Verifica se ocorreu algum erro durante a criação do usuário.
        if (isset($userService['error'])) {
            return $response::json([
                'error'     => true,
                'success'   => false,
                'message'   => $userService['error']
            ], 400);
        }

        // Retorna os dados do usuário criado com sucesso.
        return $response::json([
            'error'     => false,
            'success'   => true,
            'data'      => $userService
        ], 201);
    }

    /**
     * Autentica um usuário no sistema.
     * 
     * @param Request $request Objeto contendo os dados da requisição.
     * @param Response $response Objeto para manipulação da resposta da requisição.
     * @return mixed Retorna a resposta da requisição em formato JSON.
     */
    public function login(Request $request, Response $response)
    {
        $body = $request::body();

        // Autentica o usuário através do serviço UserService.
        $userService = UserService::auth($body);

        // Verifica se ocorreu algum erro durante a autenticação do usuário.
        if (isset($userService['error'])) {
            return $response::json([
                'error' => true,
                'success' => false,
                'message' => $userService['error']
            ], 400);
        }

        // Retorna o token de autenticação JWT do usuário.
        return $response::json([
            'error' => false,
            'success' => true,
            'jwt' => $userService
        ], 200);
    }

    /**
     * Obtém os dados de um usuário específico.
     * 
     * @param Request $request Objeto contendo os dados da requisição.
     * @param Response $response Objeto para manipulação da resposta da requisição.
     * @return mixed Retorna a resposta da requisição em formato JSON.
     */
    public function fetch(Request $request, Response $response)
    {

        $authorization = $request::authorization();

        // Autentica o usuário através do serviço UserService.
        $userService = UserService::fetch($authorization);

        // Verifica se ocorreu algum erro durante a autenticação do usuário.
        if (isset($userService['unauthorized'])) {
            return $response::json([
                'error' => true,
                'success' => false,
                'message' => $userService['unauthorized']
            ], 401);
        }

        // Verifica se ocorreu algum erro durante a autenticação do usuário.
        if (isset($userService['error'])) {
            return $response::json([
                'error' => true,
                'success' => false,
                'message' => $userService['error']
            ], 400);
        }

        // Retorna o token de autenticação JWT do usuário.
        return $response::json([
            'error' => false,
            'success' => true,
            'jwt' => $userService
        ], 200);
    }

    /**
     * Atualiza os dados de um usuário específico.
     * 
     * @param Request $request Objeto contendo os dados da requisição.
     * @param Response $response Objeto para manipulação da resposta da requisição.
     * @return mixed Retorna a resposta da requisição em formato JSON.
     */
    public function update(Request $request, Response $response)
    {

        $authorization = $request::authorization();

        $body = $request::body();

        // Autentica o usuário através do serviço UserService.
        $userService = UserService::update($authorization, $body);

        // Verifica se ocorreu algum erro durante a autenticação do usuário.
        if (isset($userService['error'])) {
            return $response::json([
                'error' => true,
                'success' => false,
                'message' => $userService['error']
            ], 400);
        }

        // Retorna o token de autenticação JWT do usuário.
        return $response::json([
            'error' => false,
            'success' => true,
            'message' => $userService
        ], 200);
    }

    /**
     * Remove um usuário específico do sistema.
     * 
     * @param Request $request Objeto contendo os dados da requisição.
     * @param Response $response Objeto para manipulação da resposta da requisição.
     * @param array $id ID do usuário a ser removido.
     * @return mixed Retorna a resposta da requisição em formato JSON.
     */
    public function remove(Request $request, Response $response, array $id)
    {
        $authorization = $request::authorization();

        // Autentica o usuário através do serviço UserService.
        $userService = UserService::delete($authorization, $id[0]);

        // Verifica se ocorreu algum erro durante a autenticação do usuário.
        if (isset($userService['error'])) {
            return $response::json([
                'error' => true,
                'success' => false,
                'message' => $userService['error']
            ], 400);
        }

        // Retorna o token de autenticação JWT do usuário.
        return $response::json([
            'error' => false,
            'success' => true,
            'message' => $userService
        ], 200);
    }
}
