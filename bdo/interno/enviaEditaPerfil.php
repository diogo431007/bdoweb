<?php
require_once 'header.php';
require_once 'conecta.php';

// RECEBENDO OS DADOS PREENCHIDOS DO FORMULÁRIO !
$id= $_POST["id_perfil"]; // pega a ID do usuário  
$descricao = utf8_decode($_POST ["descricao"]);
$controle  = $_POST ["controle"];

if (empty($descricao)) {
    echo "<script>alert('Preencha o campo Descrição');window.location = 'editaPerfil.php?edita=$id;#parte-03';</script>";
}elseif (strlen($descricao) < 3) {
    echo "<script>alert('Descrição inválida!');window.location = 'editaPerfil.php?edita=$id;#parte-03';</script>";
}else {
    
//Query que realiza a inserção dos dados no banco de dados na tabela indicada acima
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
        echo "<script>alert('Alteração de perfil concluída com sucesso!');window.location = 'busca.php#parte-03';</script>";        
    }
    // Se houver algum erro ao inserir
    else {
        echo "Não foi possivel alterar o perfil.";
    }
    
}
?>
