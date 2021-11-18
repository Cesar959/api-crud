<?php

// Configurações do Crud


// Conexão com o banco de dados

define("HOST","localhost");
define("BANCO","api_crud");
define("USUARIO","root");
define("SENHA","");



// Base da URl
define("BASEURL", "http://localhost/api_crud/");


// Mensagens de Sucesso e Erro da API

define("STATUS_SUCESSO", "SUCESSO");
define("STATUS_ERROR", "ERROR");

define("POST_SUCESSO", "Dados Cadastrados com Sucesso");
define("POST_ERROR", "Falha ao Cadastrar");

define("GET_ERROR", "Nem um Registro Encontrado");

define("DELETE_SUCESSO", "Dados Excluidos com Sucesso");
define("DELETE_ERROR", "Falha ao Excluir");

define("PUT_SUCESSO", "O Registro foi Atualizado com Sucesso");
define("PUT_ERROR", "Falha na Atualização do Registro");
define("PUT_ALERTA", "Todos os Campos são obrigatorios");

define("ROTA_DESCONHECIDA" , "Rota Desconhecida");
define("PARAMETRO" , "Nem um Parametro Passado");
define("RECURSO_INFORMADO" , "Recurso não Informado");

define("METODO_ERROR", "Metodo não valido");
define("ROTA_INVALIDA", "Rota Invalida");
define("ROTA_INFORMADA", "Rota não Informada");



?>