<?php

namespace Rota;

class Rota
{
    public const rotasPermitidas = ['usuarios'];
    public const metodosPermitidos = ['POST', 'GET', 'PUT', 'DELETE'];


    public static function getRota($url)
    {
        $dados['metodo'] =  $_SERVER['REQUEST_METHOD'];
        $dados['rota'] =  isset($url[0]) ? $url[0] : "";
        $dados['recurso'] =  isset($url[1]) ? $url[1] : "";
        $dados['identificador'] = isset($url[2]) ? $url[2] : "";

        return $dados;
    }

    public static function getUrl()
    {
        $url = explode( "/", $_GET['url']);
        return $url;
    }

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