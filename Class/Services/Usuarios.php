<?php

namespace Services;

use Model\Bd;

class Usuarios 
{
    // atributos
    private $idUsuario;
    private $nome;
    private $idade;
    private $sexo;
    private $email;
    private $senha;
    private $dados = [];

    // Seta o valor do atributo
    public function __set($campo, $valor)
    {
        $this->$campo = $valor;
    }
    //Pega o valor do atributo
    public function __get($name)
    {
        return $this->$name;
    }

    // Função de cadastro
    public function POST()
    {
        // Instancia a class do banco
        $Bd = new Bd();

        // Cria um array com os valores
        $parametros = array(
            ":NOME" => $this->nome,
            ":IDADE" => $this->idade,
            ":SEXO" => strtolower($this->sexo),
            ":EMAIL" => $this->email,
            ":SENHA" => $this->senha
        );

        // Cria um SQL 
        $sql = "INSERT INTO usuarios (nome, idade, sexo, email, senha) VALUES (:NOME, :IDADE, :SEXO, :EMAIL, :SENHA)";
        
        //Executa o SQl no banco e armazena resposta (true ou false)
        $resposta = $Bd->executaComando($sql, $parametros);

        if($resposta)
        {
            // Cria as informações para serem exibidas ao usuario
            http_response_code(200);
            $this->dados['status'] = STATUS_SUCESSO;
            $this->dados['metodo'] = $_SERVER['REQUEST_METHOD'];
            $this->dados['result'] = POST_SUCESSO;
        }
        else
        {
            // Cria as informações para serem exibidas ao usuario
            http_response_code(404);
            $this->dados['status'] = STATUS_ERROR;
            $this->dados['metodo'] = $_SERVER['REQUEST_METHOD'];
            $this->dados['result'] = POST_ERROR;
        }

        return $this->dados;

    }

    // Função de visualização
    public function GET()
    {
        // Instancia a class do banco
        $Bd = new Bd();

        // Cria um array com os valores
        $parametros = array();

        // Cria um SQL 
        $sql = "SELECT * FROM usuarios";

        //Executa o SQl no banco e armazena resposta (true ou false)
        $resposta = $Bd->select($sql, $parametros);

        // Cria as informações para serem exibidas ao usuario
        $this->dados['status'] = STATUS_SUCESSO;
        $this->dados['metodo'] = $_SERVER['REQUEST_METHOD'];
        $this->dados['result'] = $resposta;

        http_response_code(200);

        return $this->dados;
    }

    // Função de visualização para um registro
    public function GETID()
    {
        // Instancia a class do banco
        $Bd = new Bd();

        // Cria um array com os valores
        $parametros = array(
            ":ID" => $this->idUsuario
        );

        // Cria um SQL 
        $sql = "SELECT * FROM usuarios WHERE id_usuarios = :ID";

        //Executa o SQl no banco e armazena resposta (true ou false)
        $resposta = $Bd->selectId($sql, $parametros);

        if($resposta)
        {
            // Cria as informações para serem exibidas ao usuario
            http_response_code(200);
            $this->dados['status'] = STATUS_SUCESSO;
            $this->dados['metodo'] = $_SERVER['REQUEST_METHOD'];
            $this->dados['result'] = $resposta;
        }
        else
        {
            // Cria as informações para serem exibidas ao usuario
            http_response_code(404);
            $this->dados['status'] = STATUS_ERROR;
            $this->dados['metodo'] = $_SERVER['REQUEST_METHOD'];
            $this->dados['result'] = GET_ERROR;
        }

        return $this->dados;
    }

    // Função para excluir
    public function DELETE()
    {
        // Instancia a class do banco
        $Bd = new Bd();

        // Cria um array com os valores
        $parametros = array(
            ":ID" => $this->idUsuario,
        );

        // Cria um SQL 
        $sql = "DELETE FROM usuarios WHERE id_usuarios = :ID";

        //Executa o SQl no banco e armazena resposta (true ou false)
        $resposta = $Bd->executaComando($sql, $parametros);

        if($resposta)
        {
            // Cria as informações para serem exibidas ao usuario
            http_response_code(200);
            $this->dados['status'] = STATUS_SUCESSO;
            $this->dados['metodo'] = $_SERVER['REQUEST_METHOD'];
            $this->dados['result'] = DELETE_SUCESSO;
        }
        else
        {
            // Cria as informações para serem exibidas ao usuario
            http_response_code(404);
            $this->dados['status'] = STATUS_ERROR;
            $this->dados['metodo'] = $_SERVER['REQUEST_METHOD'];
            $this->dados['result'] = DELETE_ERROR;
        }

        return $this->dados;

    }

    // Função para atualizar
    public function PUT()
    {
        // Instancia a class do banco
        $Bd = new Bd();

        // Cria um array com os valores
        $parametros = array(
            ":ID" => $this->idUsuario,
            ":NOME" => $this->nome,
            ":IDADE" => $this->idade,
            ":SEXO" => strtolower($this->sexo),
            ":EMAIL" => $this->email,
            ":SENHA" => $this->senha
        );

        // Cria um SQL 
        $sql = "UPDATE usuarios SET nome=:NOME,idade=:IDADE,sexo=:SEXO,email=:EMAIL,senha=:SENHA WHERE id_usuarios = :ID";

        //Executa o SQl no banco e armazena resposta (true ou false)
        $resposta = $Bd->executaComando($sql, $parametros);

        if($resposta)
        {
            // Cria as informações para serem exibidas ao usuario
            http_response_code(200);
            $this->dados['status'] = STATUS_SUCESSO;
            $this->dados['metodo'] = $_SERVER['REQUEST_METHOD'];
            $this->dados['result'] = PUT_SUCESSO;
        }
        else
        {
            // Cria as informações para serem exibidas ao usuario
            http_response_code(404);
            $this->dados['status'] = STATUS_ERROR;
            $this->dados['metodo'] = $_SERVER['REQUEST_METHOD'];
            $this->dados['result'] = PUT_ERROR;
        }

        return $this->dados;
    }
}