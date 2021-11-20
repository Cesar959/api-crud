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
        $result['status'] = STATUS_ERROR;
        $result['metodo'] = $_SERVER['REQUEST_METHOD'];
        $result['result'] = ROTA_INVALIDA;
        exit;
    }

    if(Rota::validaMetodo($dados['metodo']) == false)
    {
        http_response_code(400);
        $result['status'] = STATUS_ERROR;
        $result['metodo'] = $_SERVER['REQUEST_METHOD'];
        $result['result'] = METODO_ERROR;
        exit;
    }


    if($dados['rota'] == "usuarios")
    {

        $services = new Usuarios;

        switch ($dados['metodo']) 
        {
            case 'POST':

                $services->nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
                $services->idade = filter_input(INPUT_POST, 'idade', FILTER_SANITIZE_NUMBER_INT);
                $services->sexo = filter_input(INPUT_POST, 'sexo', FILTER_SANITIZE_SPECIAL_CHARS);
                $services->email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                $services->senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS);

                $resposta = $services->POST();

                $result = $resposta;

                break;

            case 'GET':
                
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

            case 'PUT':
                parse_str(file_get_contents("php://input"),$putData);
                
                if (!empty($putData['id']) and !empty($putData['nome']) and !empty($putData['idade']) and !empty($putData['sexo']) and !empty($putData['email']) and !empty($putData['senha'])) 
                {

                    $services->idUsuario = filter_var($putData['id'], FILTER_SANITIZE_NUMBER_INT);
                    $services->nome = filter_var($putData['nome'], FILTER_SANITIZE_SPECIAL_CHARS);
                    $services->idade = filter_var($putData['idade'] , FILTER_SANITIZE_NUMBER_INT);
                    $services->sexo = filter_var($putData['sexo'], FILTER_SANITIZE_SPECIAL_CHARS);
                    $services->email = filter_var($putData['email'], FILTER_SANITIZE_EMAIL);
                    $services->senha = filter_var($putData['senha'], FILTER_SANITIZE_SPECIAL_CHARS);
                    $result = $services->PUT();

                }
                else
                {
                    http_response_code(404);
                    $result['status'] = STATUS_ERROR;
                    $result['metodo'] = $_SERVER['REQUEST_METHOD'];
                    $result['result'] = PUT_ALERTA;
                }

                break;

            case 'DELETE':
                $services->idUsuario= $dados['identificador'];
                $resposta = $services->DELETE();
                $result = $resposta;
                break;
            
            default:
                http_response_code(400);
                $result['status'] = STATUS_ERROR;
                $result['metodo'] = $_SERVER['REQUEST_METHOD'];
                $result['result'] = RECURSO_INFORMADO;
                break;
        }
    }
    elseif (empty($dados))
    {
        http_response_code(400);
        $result['status'] = "ERROR";
        $result['metodo'] = $_SERVER['REQUEST_METHOD'];
        $result['result'] = ROTA_INFORMADA;
    }
    else
    {
        http_response_code(400);
        $result['status'] = "ERROR";
        $result['metodo'] = $_SERVER['REQUEST_METHOD'];
        $result['mensagem'] = ROTA_DESCONHECIDA;
    }

}
else
{
    http_response_code(400);
    $result['status'] = "Infor";
    $result['metodo'] = $_SERVER['REQUEST_METHOD'];
    $result['result'] = BASEURL . "usuarios";
}


Json::dadosJson($result);
