<?php

namespace Model;

class Bd extends \PDO
{
    //Atributos
    private $host = HOST;
    private $banco = BANCO;
    private $usuario = USUARIO;
    private $senha = SENHA;

    // Metodos

    // Construtor que inicia a conexâo com o banco de dados
    public function __construct()
    {
        parent::__construct("mysql:host=$this->host;dbname=$this->banco", "$this->usuario", "$this->senha");
    }

    // Responsavel por Executar o comando passado por parametro no banco de dados
    public function executaComando($sql, $parametros = array())
    {
        // Preparando a instrução sql
        $stmt = $this->prepare($sql);

        // Trocando os parametros pelos valores
        foreach($parametros as $indice => $valor)
        {
            $stmt->bindValue($indice, $valor);
        }

        $stmt->execute();

        // Executando e verificando ser a execução foi bem sucedida
        if($stmt->rowCount() > 0)
        {
            return $mensagem = true;
        }
        else
        {
            return $mensagem =  false;
        }
        
    }

    // Respnsavel por selecionar os dados no banco de dados e trazer eles em formato de array
    public function select($sql, $parametros = array())
    {
        // Preparando a instrução sql
        $stmt = $this->prepare($sql);

        // Trocando os parametros pelos valores
        foreach($parametros as $indice => $valor)
        {
            $stmt->bindValue($indice, $valor);
        }

        // Executando 
        $stmt->execute();
        
        // retornando os dados do SELECT
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    // Respnsavel por selecionar os dados no banco de dados e trazer eles em formato de array
    public function selectId($sql, $parametros = array())
    {
        // Preparando a instrução sql
        $stmt = $this->prepare($sql);

        // Trocando os parametros pelos valores
        foreach($parametros as $indice => $valor)
        {
            $stmt->bindValue($indice, $valor);
        }

        // Executando 
        $stmt->execute();
        
        // retornando os dados do SELECT
        return $stmt->fetch(\PDO::FETCH_ASSOC);

    }

}