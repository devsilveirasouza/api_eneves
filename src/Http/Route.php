<?php

namespace App\Http;

class Route
{
    // Array estático para armazenar as definições de rota
    private static array $routes = [];

    // Método para adicionar uma rota do tipo GET
    public static function get(string $path, string $action)
    {
        // Adiciona a rota ao array de rotas, especificando o caminho, a ação e o método HTTP
        self::$routes[] = [
            'path' => $path,
            'action' => $action,
            'method' => 'GET'
        ];
    }

    // Método para adicionar uma rota do tipo POST
    public static function post(string $path, string $action)
    {
        // Adiciona a rota ao array de rotas, especificando o caminho, a ação e o método HTTP
        self::$routes[] = [
            'path' => $path,
            'action' => $action,
            'method' => 'POST'
        ];
    }

    // Método para adicionar uma rota do tipo PUT
    public static function put(string $path, string $action)
    {
        // Adiciona a rota ao array de rotas, especificando o caminho, a ação e o método HTTP
        self::$routes[] = [
            'path' => $path,
            'action' => $action,
            'method' => 'PUT'
        ];
    }

    // Método para adicionar uma rota do tipo DELETE
    public static function delete(string $path, string $action)
    {
        // Adiciona a rota ao array de rotas, especificando o caminho, a ação e o método HTTP
        self::$routes[] = [
            'path' => $path,
            'action' => $action,
            'method' => 'DELETE'
        ];
    }

    // Método para retornar todas as rotas definidas
    public static function routes()
    {
        // Retorna o array de rotas
        return self::$routes;
    }
}
