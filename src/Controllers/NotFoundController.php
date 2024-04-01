<?php

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;

class NotFoundController 
{    
    // Método index para lidar com a rota não encontrada
    public function index(Request $request, Response $response)
    {
        // Retorna uma resposta JSON indicando que a rota não foi encontrada
        $response::json([
            'error' => true,
            'success' => false,
            'message' => 'Sorry, route not found'
        ], 404);
        return;
    }
}
