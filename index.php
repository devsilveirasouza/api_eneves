<?php

// Inclui o arquivo autoload.php que carrega automaticamente as classes do Composer
require_once __DIR__ . '/vendor/autoload.php';

// Inclui o arquivo que contém as definições de rotas do aplicativo
require_once __DIR__ . '/src/routes/main.php';

// Usa os namespaces necessários
use App\Core\Core;
use App\Http\Route;

// Inicia o despacho das solicitações usando o Core do aplicativo
// O método dispatch recebe as rotas definidas no arquivo de rotas e as despacha de acordo com a solicitação atual
Core::dispatch(Route::routes());
