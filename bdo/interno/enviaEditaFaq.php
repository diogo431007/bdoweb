<?php
header("Content-Type: text/html; charset=ISO-8859-1",true);
require_once 'define.php';
require_once 'conecta.php';
// RECEBENDO OS DADOS PREENCHIDOS DO FORMUL�RIO !
$id_pergunta   = $_POST["id_pergunta"]; // pega a ID do usu�rio
$pergunta      = utf8_decode($_POST["ds_pergunta"]);
$resposta      = utf8_decode($_POST["ds_resposta"]);
//Quando for excluir o post vir� com S, caso contr�rio ficar� 'vazio'
$ao_ativo      = utf8_decode($_POST['ao_ativo']);


if((empty($pergunta)) && (empty($resposta))){
    echo "Preencha os campos pergunta e resposta";   
}
else if(empty($pergunta)){
     echo "Preencha o campo pergunta";
}
else if(empty($resposta)){
     echo "Preencha o campo resposta";
}
//Se n�o houve nenhum erro
else {
    
    //Se o usu�rio excluir a pergunta receber� S, caso contr�rio atualiza.
    if($ao_ativo == 'N'){
        $sql = "UPDATE 
                pergunta 
            SET                 
                id_usuarioalteracao = '".$_SESSION['id_usuario']."',
                dt_alteracao = now(),                
                ao_ativo = 'N'
            WHERE 
                id_pergunta = '$id_pergunta'" ;
    }else{
        $sql = "UPDATE 
                pergunta 
            SET                 
                id_usuarioalteracao = '".$_SESSION['id_usuario']."',
                dt_alteracao = now(),
                ds_pergunta = '".$pergunta."', 
                ds_resposta = '".$resposta."'
            WHERE 
                id_pergunta = '$id_pergunta'" ;
    }
   
    $query = mysql_query($sql);
	// Se inserido com sucesso
	if ($query) {
		echo false;
	}
	// Se houver algum erro ao inserir
	else {
		echo "N�o foi possivel alterar a pergunta.";
	}
}
?>

    