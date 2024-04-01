<?php

namespace App\Core;

use App\Http\Request;
use App\Http\Response;

class Core
{
    // Método estático para despachar as rotas
    public static function dispatch(array $routes)
    {
        // Define a URL base como "/"
        $url = '/';

        // Verifica se o parâmetro 'url' está presente na query string
        isset($_GET['url']) && $url .= $_GET['url'];

        // Remove a barra final da URL se houver
        $url !== '/' && $url = rtrim($url, '/');

        // Define o prefixo para os controladores
        $prefixController = 'App\\Controllers\\';

        // Define uma variável para verificar se a rota foi encontrada
        $routeFound = false;

        // Itera sobre as rotas definidas
        foreach ($routes as $route) {
            // Cria um padrão de expressão regular com base no caminho da rota
            $pattern = '#^' . preg_replace('/{id}/', '([\w-]+)', $route['path']) . '$#';

            // Verifica se a URL corresponde ao padrão da rota atual
            if (preg_match($pattern, $url, $matches)) {
                // Remove o primeiro elemento de $matches (o próprio URL)
                array_shift($matches);

                // Marca a rota como encontrada
                $routeFound = true;

                // Verifica se o método da requisição corresponde ao método da rota
                if ($route['method'] !== Request::method()) {
                    // Se não corresponder, retorna uma resposta JSON indicando o erro 405 (Método não permitido)
                    Response::json([
                        'error'     => true,
                        'success'   => false,
                        'message'   => 'Sorry, method not allowed.'
                    ], 405);
                    return;
                }

                // Divide o controlador e a ação da rota
                [$controller, $action] = explode('@', $route['action']);

                // Monta o nome completo do controlador com o prefixo
                $controller = $prefixController . $controller;

                // Instancia o controlador e chama a ação correspondente
                $extendController = new $controller();
                $extendController->$action(new Request, new Response, $matches);
            }
        }

        // Se nenhuma rota for encontrada, instancia o NotFoundController
        if (!$routeFound) {
            $controller = $prefixController . 'NotFoundController';
            $extendController = new $controller();
            $extendController->index(new Request, new Response, $matches);
        }
    }
}
