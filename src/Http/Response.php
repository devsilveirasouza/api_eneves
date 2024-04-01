<?php

namespace App\Http;

/**
 * Uma classe para lidar com respostas HTTP.
 */
class Response
{
    /**
     * Envia uma resposta JSON com os dados e o código de status fornecidos.
     *
     * @param array $data Os dados a serem convertidos em JSON.
     * @param int $status O código de status HTTP da resposta (padrão é 200).
     * @return void
     */
    public static function json(array $data = [], int $status = 200)
    {
        // Define o código de status HTTP
        http_response_code($status);

        // Define o cabeçalho Content-Type para indicar conteúdo JSON
        header("Content-Type: application/json");

        // Codifica o array de dados em formato JSON e o envia
        echo json_encode($data);
    }
}
