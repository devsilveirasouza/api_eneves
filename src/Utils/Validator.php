<?php

namespace App\Utils;

/**
 * Classe responsável por validar campos.
 */
class Validator
{
    /**
     * Valida os campos fornecidos.
     *
     * @param array $fields Os campos a serem validados.
     * @return array Os campos validados.
     * @throws \Exception Se um campo obrigatório estiver vazio ou nulo.
     */
    public static function validate(array $fields)
    {
        foreach ($fields as $field => $value) {
            if (empty(trim($value))) {
                throw new \Exception("O campo ($field) é obrigatório.");
            }
        }
        return $fields;
    }
}
