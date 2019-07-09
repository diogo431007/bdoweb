<?php
require_once 'conecta.php';
require_once 'define.php';
header("Content-Type: text/html; charset=ISO-8859-1",true);

  // RECEBENDO OS DADOS PREENCHIDOS DO FORMULÁRIO !
 $pergunta = utf8_decode($_POST ["ds_pergunta"]);
 $resposta = utf8_decode($_POST ["ds_resposta"]);
  
 $user = $_SESSION['id_usuario'];
//Verifica se a pergunta foi preenchida.

if((empty($pergunta)) && (empty($resposta))){
    echo "Preencha os campos pergunta e resposta";
}
else if(empty($pergunta)){
     echo "Preencha o campo pergunta";
}
else if(empty($resposta)){
     echo "Preencha o campo resposta";
} 
 // Se não houver nenhum erro
else{
	// Inserimos no banco de dados
	$sql = "INSERT INTO pergunta ( 
                    id_usuarioinclusao,
                    dt_inclusao,                    
                    ds_pergunta,
                    ds_resposta
                )
                VALUES (
                    '".$_SESSION['id_usuario']."',
                    now(),                    
                    '".$pergunta."',
                    '".$resposta."'                    
                )";
        //die($sql);
        $query = mysql_query($sql);
	// Se inserido com sucesso
	
        if ($query) {
		echo false;                
	}
	// Se houver algum erro ao inserir
	else {
		echo "Não foi possivel cadastrar a pergunta no momento, tente mais tarde.";
	}
}
?>