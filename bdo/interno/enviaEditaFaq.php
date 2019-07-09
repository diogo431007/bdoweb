<?php
header("Content-Type: text/html; charset=ISO-8859-1",true);
require_once 'define.php';
require_once 'conecta.php';
// RECEBENDO OS DADOS PREENCHIDOS DO FORMULÁRIO !
$id_pergunta   = $_POST["id_pergunta"]; // pega a ID do usuário
$pergunta      = utf8_decode($_POST["ds_pergunta"]);
$resposta      = utf8_decode($_POST["ds_resposta"]);
//Quando for excluir o post virá com S, caso contrário ficará 'vazio'
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
//Se não houve nenhum erro
else {
    
    //Se o usuário excluir a pergunta receberá S, caso contrário atualiza.
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
		echo "Não foi possivel alterar a pergunta.";
	}
}
?>

    