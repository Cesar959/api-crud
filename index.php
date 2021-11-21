<?php
// Chamando o autoload do composer
require_once __DIR__ . "/vendor/autoload.php";
//criando um array vazio
$result = [];

use Rota\Rota;
use Services\Usuarios;
use Utility\Json;

// verificando ser o $_GET não esta vazio
if(!empty($_GET))
{
    // chamando as funções para a validação e criação da rota
    $url = Rota::getUrl();
    $dados = Rota::getRota($url);

    if(Rota::validaRota($dados['rota']) == false)
    {
        // Cria as informações para serem exibidas ao usuario
        http_response_code(400);
        $result['status'] = STATUS_ERROR;
        $result['metodo'] = $_SERVER['REQUEST_METHOD'];
        $result['result'] = ROTA_INVALIDA;
        exit;
    }

    if(Rota::validaMetodo($dados['metodo']) == false)
    {
        // Cria as informações para serem exibidas ao usuario
        http_response_code(400);
        $result['status'] = STATUS_ERROR;
        $result['metodo'] = $_SERVER['REQUEST_METHOD'];
        $result['result'] = METODO_ERROR;
        exit;
    }

    // Verificando ser a rota é permitida
    if($dados['rota'] == "usuarios")
    {
        //Instanciando a class usuarios
        $services = new Usuarios;
        // Verificando o metodo
        switch ($dados['metodo']) 
        {
            case 'POST':
                // Sentando as informações
                $services->nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
                $services->idade = filter_input(INPUT_POST, 'idade', FILTER_SANITIZE_NUMBER_INT);
                $services->sexo = filter_input(INPUT_POST, 'sexo', FILTER_SANITIZE_SPECIAL_CHARS);
                $services->email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                $services->senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS);
                //chamando a função 
                $resposta = $services->POST();
                //pegando o resultado
                $result = $resposta;

                break;

            case 'GET':
                // vereficando ser o identifacador não é vazio
                if(!empty($dados['identificador']))
                {
                    // Sentando as informações
                    $services->idUsuario = filter_var($dados['identificador']);
                     //chamando a função 
                    $result = $services->GETID();
                }
                else
                {
                    // chamando a função 
                    $result = $services->GET();
                }

                break;

            case 'PUT':
                // Armazenando as informações
                parse_str(file_get_contents("php://input"),$putData);
                
                // Vereficando ser foi enviado todas as informações
                if (!empty($putData['id']) and !empty($putData['nome']) and !empty($putData['idade']) and !empty($putData['sexo']) and !empty($putData['email']) and !empty($putData['senha'])) 
                {
                    // Sentando as informações
                    $services->idUsuario = filter_var($putData['id'], FILTER_SANITIZE_NUMBER_INT);
                    $services->nome = filter_var($putData['nome'], FILTER_SANITIZE_SPECIAL_CHARS);
                    $services->idade = filter_var($putData['idade'] , FILTER_SANITIZE_NUMBER_INT);
                    $services->sexo = filter_var($putData['sexo'], FILTER_SANITIZE_SPECIAL_CHARS);
                    $services->email = filter_var($putData['email'], FILTER_SANITIZE_EMAIL);
                    $services->senha = filter_var($putData['senha'], FILTER_SANITIZE_SPECIAL_CHARS);
                    //chamando a função 
                    $result = $services->PUT();

                }
                else
                {
                    // Cria as informações para serem exibidas ao usuario
                    http_response_code(404);
                    $result['status'] = STATUS_ERROR;
                    $result['metodo'] = $_SERVER['REQUEST_METHOD'];
                    $result['result'] = PUT_ALERTA;
                }

                break;

            case 'DELETE':
                // Sentando as informações
                $services->idUsuario= $dados['identificador'];
                //chamando a função 
                $result = $services->DELETE();
                break;
            
            default:
            // Cria as informações para serem exibidas ao usuario
                http_response_code(400);
                $result['status'] = STATUS_ERROR;
                $result['metodo'] = $_SERVER['REQUEST_METHOD'];
                $result['result'] = RECURSO_INFORMADO;
                break;
        }
    }
    elseif (empty($dados))
    {
        // Cria as informações para serem exibidas ao usuario
        http_response_code(400);
        $result['status'] = "ERROR";
        $result['metodo'] = $_SERVER['REQUEST_METHOD'];
        $result['result'] = ROTA_INFORMADA;
    }
    else
    {
        // Cria as informações para serem exibidas ao usuario
        http_response_code(400);
        $result['status'] = "ERROR";
        $result['metodo'] = $_SERVER['REQUEST_METHOD'];
        $result['mensagem'] = ROTA_DESCONHECIDA;
    }

}
else
{
    // Cria as informações para serem exibidas ao usuario
    http_response_code(400);
    $result['status'] = "Infor";
    $result['metodo'] = $_SERVER['REQUEST_METHOD'];
    $result['result'] = BASEURL . "usuarios";
}

// Exibindo as informações em json
Json::dadosJson($result);

