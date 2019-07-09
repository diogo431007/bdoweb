<?php
header("Content-Type: text/html; charset=ISO-8859-1",true);
require_once 'define.php';
require_once 'conecta.php';
// RECEBENDO OS DADOS PREENCHIDOS DO FORMULÁRIO !
$id_texto   = $_POST["id_texto"]; // pega a ID do usuário
$titulo      = utf8_decode($_POST["ds_titulo"]);
$texto    = utf8_decode($_POST["ds_texto"]);
//Quando for excluir o post virá com S, caso contrário ficará 'vazio'
$ao_ativo      = utf8_decode($_POST['ao_ativo']);


if((empty($titulo)) && (empty($texto))){
    echo "Preencha os campos título e texto";   
}
else if(empty($titulo)){
     echo "Preencha o campo título";
}
else if(empty($texto)){
     echo "Preencha o campo texto";
}
//Se não houve nenhum erro
else {
    
    //Se o usuário excluir o texto receberá S, caso contrário atualiza.
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
		echo "Não foi possivel alterar o texto.";
	}
}
?>

    