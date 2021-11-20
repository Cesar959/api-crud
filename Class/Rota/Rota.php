<?php

namespace Rota;

class Rota
{
    // constantes
    public const rotasPermitidas = ['usuarios'];
    public const metodosPermitidos = ['POST', 'GET', 'PUT', 'DELETE'];

    //Faz a separação das rotas forme o getUrl()
    public static function getRota($url)
    {
        $dados['metodo'] =  $_SERVER['REQUEST_METHOD'];
        $dados['rota'] =  isset($url[0]) ? $url[0] : "";
        $dados['identificador'] =  isset($url[1]) ? $url[1] : "";

        return $dados;
    }

    //Pega a rota baseado na url
    public static function getUrl()
    {
        $url = explode( "/", $_GET['url']);
        return $url;
    }

    // Valida ser a rota existe
    public static function validaRota($rota)
    {
        if(in_array($rota, self::rotasPermitidas))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    // Valida ser o metodo existe
    public static function validaMetodo($metodo)
    {
        if(in_array($metodo, self::metodosPermitidos))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

}