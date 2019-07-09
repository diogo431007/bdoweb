<?php
include (__DIR__.'/../DefineCredenciais.php');

  // configurações do bando de dados
  $servidor = DB_SERVER;
  $banco = DB_BANCO;
  $usuario_db = DB_USER;
  $senha_db = DB_PASSWORD;

  $con = mysql_connect($servidor, $usuario_db, $senha_db) or die('Erro ao conectar no banco de dados, parte interna!');
  mysql_select_db($banco) or die ('Erro ao selecionar a base');
  include("Seguranca.php");
# anti injection post e get
  Seguranca::antiInjectionPostGet();
?>
