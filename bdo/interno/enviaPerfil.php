<?php
require_once 'header.php';
require_once 'conecta.php';
// RECEBENDO OS DADOS PREENCHIDOS DO FORMUL?RIO !

$descricao = utf8_decode($_POST ["perfil"]);
$controle = "S";

//Verifica se o perfil foi preenchido.
if (empty($descricao)) {
  echo "<script>alert('Preencha o campo Descrição');window.location = 'cadastro.php#parte-03';</script>";
} elseif (strlen($descricao) < 3) {
  echo "<script>alert('Descrição não válida');window.location = 'cadastro.php#parte-03';</script>";
} else {

    $sql = "INSERT INTO perfil (
                ds_perfil,
                dt_inclusao,
                ao_controle,
                id_usuarioinclusao
            )
            VALUES (
                '".mb_strtoupper($descricao)."',
                now(),
                '$controle',
                ".$_SESSION['id_usuario']."
            )";
    //echo $sql;die;
    $query = mysql_query($sql);
    $idPerfil = mysql_insert_id();
    // Se inserido com sucesso
    if ($query) {
        if ($_POST["paginas"]) {
            foreach ($_POST["paginas"] as $pagina) {
                $sql_Pagina = "INSERT INTO perfilpagina (
                                    id_perfil,
                                    id_pagina
                                )
                                VALUES (
                                    $idPerfil,
                                    $pagina
                                )";
                $query2 = mysql_query($sql_Pagina);
            }
            if ($query2) {
                echo "<script>alert('Perfil inserido com sucesso');window.location = 'cadastro.php#parte-03';</script>";
            } else {
                echo "<script>alert('Não foi possivel criar o perfil');window.location = 'cadastro.php#parte-03';</script>";
            }
        }
    } else {
        echo "<script>alert('Não foi possivel criar o perfil');window.location = 'cadastro.php#parte-03';</script>";
    }
}


?>
