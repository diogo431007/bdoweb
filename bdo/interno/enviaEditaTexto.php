<?php
header("Content-Type: text/html; charset=ISO-8859-1",true);
require_once 'define.php';
require_once 'conecta.php';
// RECEBENDO OS DADOS PREENCHIDOS DO FORMUL�RIO !
$id_texto   = $_POST["id_texto"]; // pega a ID do usu�rio
$titulo      = utf8_decode($_POST["ds_titulo"]);
$texto    = utf8_decode($_POST["ds_texto"]);
//Quando for excluir o post vir� com S, caso contr�rio ficar� 'vazio'
$ao_ativo      = utf8_decode($_POST['ao_ativo']);


if((empty($titulo)) && (empty($texto))){
    echo "Preencha os campos t�tulo e texto";   
}
else if(empty($titulo)){
     echo "Preencha o campo t�tulo";
}
else if(empty($texto)){
     echo "Preencha o campo texto";
}
//Se n�o houve nenhum erro
else {
    
    //Se o usu�rio excluir o texto receber� S, caso contr�rio atualiza.
    if($ao_ativo == 'N'){
        $sql = "UPDATE 
                texto
            SET                 
                id_usuarioalteracao = '".$_SESSION['id_usuario']."',
                dt_alteracao = now(),                
                ao_ativo = 'N'
            WHERE 
                id_texto = '$id_texto'" ;
    }else{
        $sql = "UPDATE 
                texto
            SET                 
                id_usuarioalteracao = '".$_SESSION['id_usuario']."',
                dt_alteracao = now(),
                ds_titulo = '".$titulo."', 
                ds_texto = '".$texto."'
            WHERE 
                id_texto = '$id_texto'" ;
    }
   
    $query = mysql_query($sql);
	// Se inserido com sucesso
	if ($query) {
		echo false;
	}
	// Se houver algum erro ao inserir
	else {
		echo "N�o foi possivel alterar o texto.";
	}
}
?>

    