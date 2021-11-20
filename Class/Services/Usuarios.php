<?php

namespace Services;

use Model\Bd;

class Usuarios 
{
    private $idUsuario;
    private $nome;
    private $idade;
    private $sexo;
    private $email;
    private $senha;
    private $dados = [];

    public function __set($campo, $valor)
    {
        $this->$campo = $valor;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function POST()
    {
        $Bd = new Bd();

        $parametros = array(
            ":NOME" => $this->nome,
            ":IDADE" => $this->idade,
            ":SEXO" => strtolower($this->sexo),
            ":EMAIL" => $this->email,
            ":SENHA" => $this->senha
        );

        $sql = "INSERT INTO usuarios (nome, idade, sexo, email, senha) VALUES (:NOME, :IDADE, :SEXO, :EMAIL, :SENHA)";

        $resposta = $Bd->executaComando($sql, $parametros);

        if($resposta)
        {
            http_response_code(200);
            $this->dados['status'] = STATUS_SUCESSO;
            $this->dados['metodo'] = $_SERVER['REQUEST_METHOD'];
            $this->dados['result'] = POST_SUCESSO;
        }
        else
        {
            http_response_code(404);
            $this->dados['status'] = STATUS_ERROR;
            $this->dados['metodo'] = $_SERVER['REQUEST_METHOD'];
            $this->dados['result'] = POST_ERROR;
        }

        return $this->dados;

    }

    public function GET()
    {
        $Bd = new Bd();

        $parametros = array();

        $sql = "SELECT * FROM usuarios";

        $resposta = $Bd->select($sql, $parametros);

        $this->dados['status'] = STATUS_SUCESSO;
        $this->dados['metodo'] = $_SERVER['REQUEST_METHOD'];
        $this->dados['result'] = $resposta;

        http_response_code(200);

        return $this->dados;
    }

    public function GETID()
    {
        $Bd = new Bd();

        $parametros = array(
            ":ID" => $this->idUsuario
        );

        $sql = "SELECT * FROM usuarios WHERE id_usuarios = :ID";

        $resposta = $Bd->selectId($sql, $parametros);

        if($resposta)
        {
            http_response_code(200);
            $this->dados['status'] = STATUS_SUCESSO;
            $this->dados['metodo'] = $_SERVER['REQUEST_METHOD'];
            $this->dados['result'] = $resposta;
        }
        else
        {
            http_response_code(404);
            $this->dados['status'] = STATUS_ERROR;
            $this->dados['metodo'] = $_SERVER['REQUEST_METHOD'];
            $this->dados['result'] = GET_ERROR;
        }

        return $this->dados;
    }

    public function DELETE()
    {
        $Bd = new Bd();

        $parametros = array(
            ":ID" => $this->idUsuario,
        );

        $sql = "DELETE FROM usuarios WHERE id_usuarios = :ID";

        $resposta = $Bd->executaComando($sql, $parametros);

        if($resposta)
        {
            http_response_code(200);
            $this->dados['status'] = STATUS_SUCESSO;
            $this->dados['metodo'] = $_SERVER['REQUEST_METHOD'];
            $this->dados['result'] = DELETE_SUCESSO;
        }
        else
        {
            http_response_code(404);
            $this->dados['status'] = STATUS_ERROR;
            $this->dados['metodo'] = $_SERVER['REQUEST_METHOD'];
            $this->dados['result'] = DELETE_ERROR;
        }

        return $this->dados;

    }

    public function PUT()
    {
        $Bd = new Bd();

        $parametros = array(
            ":ID" => $this->idUsuario,
            ":NOME" => $this->nome,
            ":IDADE" => $this->idade,
            ":SEXO" => strtolower($this->sexo),
            ":EMAIL" => $this->email,
            ":SENHA" => $this->senha
        );

        $sql = "UPDATE usuarios SET nome=:NOME,idade=:IDADE,sexo=:SEXO,email=:EMAIL,senha=:SENHA WHERE id_usuarios = :ID";

        $resposta = $Bd->executaComando($sql, $parametros);

        if($resposta)
        {
            http_response_code(200);
            $this->dados['status'] = STATUS_SUCESSO;
            $this->dados['metodo'] = $_SERVER['REQUEST_METHOD'];
            $this->dados['result'] = PUT_SUCESSO;
        }
        else
        {
            http_response_code(404);
            $this->dados['status'] = STATUS_ERROR;
            $this->dados['metodo'] = $_SERVER['REQUEST_METHOD'];
            $this->dados['result'] = PUT_ERROR;
        }

        return $this->dados;
    }
}