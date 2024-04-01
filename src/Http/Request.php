<?php

namespace App\Http;

class Request
{
    /**
     * Obtém o método HTTP da requisição.
     *
     * @return string O método HTTP da requisição (por exemplo, 'GET', 'POST', etc.).
     */
    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Obtém o corpo da requisição, seja ele enviado como parâmetros GET, ou no corpo da requisição.
     *
     * @return array Os dados da requisição.
     */
    public static function body()
    {
        // Decodifica o JSON do corpo da requisição, se houver, caso contrário, define um array vazio.
        $json = json_decode(file_get_contents('php://input'), true) ?? [];

        // Utiliza uma expressão match para determinar os dados da requisição com base no método HTTP.
        $data = match(self::method()) {
            'GET' => $_GET, // Se o método for GET, retorna os parâmetros GET.
            'POST', 'PUT', 'DELETE' => $json, // Se o método for POST, PUT ou DELETE, retorna o JSON decodificado do corpo da requisição.
        };

        return $data;
    }
}
