<?php

require_once __DIR__ . "/vendor/autoload.php";

$result = [];

use Rota\Rota;
use Services\Usuarios;
use Utility\Json;

if(!empty($_GET))
{
    $url = Rota::getUrl();
    $dados = Rota::getRota($url);

    if(Rota::validaRota($dados['rota']) == false)
    {
        http_response_code(400);
        $result['status'] = "ERROR";
        $result['mensagem'] = "Rota não valida";
        exit;
    }

    if(Rota::validaMetodo($dados['metodo']) == false)
    {
        http_response_code(400);
        $result['status'] = "ERROR";
        $result['mensagem'] = "Metodo não valido";
        exit;
    }


    if($dados['rota'] == "usuarios")
    {
        $services = new Usuarios;

        switch ($dados['recurso']) 
        {
            case 'cadastro':

                $services->nome = filter_input(INPUT_POST, 'nome');
                $services->idade = filter_input(INPUT_POST, 'idade');
                $services->sexo = filter_input(INPUT_POST, 'sexo');
                $services->email = filter_input(INPUT_POST, 'email');
                $services->senha = filter_input(INPUT_POST, 'senha');

                $resposta = $services->POST();

                $result = $resposta;

                break;

            case 'listar':
                
                if(!empty($dados['identificador']))
                {
                    $services->idUsuario = filter_var($dados['identificador']);
                    $result = $services->GETID();
                }
                else
                {
                    $result = $services->GET();
                }

                break;

            case 'atualizar':
                parse_str(file_get_contents("php://input"),$putData);
                
                $services->idUsuario = filter_var($putData['id']);
                $services->nome = filter_var($putData['nome']);
                $services->idade = filter_var($putData['idade']);
                $services->sexo = filter_var($putData['sexo']);
                $services->email = filter_var($putData['email']);
                $services->senha = filter_var($putData['senha']);
                $result = $services->PUT();

                break;

            case 'deletar':
                $services->idUsuario= $dados['identificador'];
                $resposta = $services->DELETE();
                $result['result'] = $resposta;
                break;
            
            default:
                http_response_code(400);
                $result['status'] = "ERROR";
                $dados['metodo'] = $_SERVER['REQUEST_METHOD'];
                $result['mensagem'] = "Recurso não informado";
                break;
        }
    }
    elseif (empty($dados))
    {
        http_response_code(400);
        $result['status'] = "ERROR";
        $result['metodo'] = $_SERVER['REQUEST_METHOD'];
        $result['mensagem'] = "Informe a rota";
    }
    else
    {
        http_response_code(400);
        $result['status'] = "ERROR";
        $result['metodo'] = $_SERVER['REQUEST_METHOD'];
        $result['mensagem'] = "Rota desconhecida";
    }

}
else
{
    http_response_code(400);
    $result['status'] = "ERROR";
    $result['metodo'] = $_SERVER['REQUEST_METHOD'];
    $result['mensagem'] = "Nem um parametro passado";
}


Json::dadosJson($result);

