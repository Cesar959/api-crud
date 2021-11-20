<?php

namespace Utility;

class Json 
{
    // Função responsavel por exibir os dados no formato json
    public static function dadosJson($dados)
    {
        header('Content-Type: application/json');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE');
        echo json_encode($dados);
        exit;
    }
}