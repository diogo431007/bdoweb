<?php
require_once 'header.php';
require_once 'conecta.php';

// RECEBENDO OS DADOS PREENCHIDOS DO FORMUL�RIO !
$id= $_POST["id_perfil"]; // pega a ID do usu�rio  
$descricao = utf8_decode($_POST ["descricao"]);
$controle  = $_POST ["controle"];

if (empty($descricao)) {
    echo "<script>alert('Preencha o campo Descri��o');window.location = 'editaPerfil.php?edita=$id;#parte-03';</script>";
}elseif (strlen($descricao) < 3) {
    echo "<script>alert('Descri��o inv�lida!');window.location = 'editaPerfil.php?edita=$id;#parte-03';</script>";
}else {
    
//Query que realiza a inser��o dos dados no banco de dados na tabela indicada acima
    $query = "UPDATE 
                    perfil 
              SET 
                    id_usuarioalteracao = ".$_SESSION['id_usuario'].", 
                    ds_perfil = '".mb_strtoupper($descricao)."', 
                    dt_alteracao = now(), 
                    ao_controle = '$controle' 
              WHERE 
                    id_perfil = $id";
 
    $executa = mysql_query($query);
    // Se inserido com sucesso
   // echo $query;die;
    if ($executa) {
        
        $delete = "DELETE FROM 
                        perfilpagina 
                   WHERE 
                        id_perfil = $id";
        $executaDelete = mysql_query($delete);   
        
        if($_POST ["paginas"]){
            foreach ($_POST ["paginas"] as $pagina) {
                $sql_Pagina = "INSERT INTO perfilpagina (
                                    id_perfil, 
                                    id_pagina
                               ) 
                               VALUES (
                                    $id, 
                                    $pagina
                               )";
                $query2 = mysql_query($sql_Pagina); 
            } 
        }
        echo "<script>alert('Altera��o de perfil conclu�da com sucesso!');window.location = 'busca.php#parte-03';</script>";        
    }
    // Se houver algum erro ao inserir
    else {
        echo "N�o foi possivel alterar o perfil.";
    }
    
}
?>
