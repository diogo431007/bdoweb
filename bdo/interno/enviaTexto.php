<?php
require_once 'conecta.php';
require_once 'define.php';
header("Content-Type: text/html; charset=ISO-8859-1",true);

  // RECEBENDO OS DADOS PREENCHIDOS DO FORMULÁRIO !
 $titulo = utf8_decode($_POST ["ds_titulo"]);
 $texto = utf8_decode($_POST ["ds_texto"]);

 $user = $_SESSION['id_usuario'];
//Verifica se a pergunta foi preenchida.

if((empty($titulo)) && (empty($texto))){
    echo "Preencha os campos título e texto";
}
else if(empty($titulo)){
     echo "Preencha o campo título";
}
else if(empty($texto)){
     echo "Preencha o campo texto";
}
 // Se não houver nenhum erro
else{
	// Inserimos no banco de dados
	$sql = "INSERT INTO texto (
                    id_usuarioinclusao,
                    dt_inclusao,
                    ds_titulo,
                    ds_texto
                )
                VALUES (
                    '".$_SESSION['id_usuario']."',
                    now(),
                    '".$titulo."',
                    '".$texto."'
                )";
        //die($sql);
        $query = mysql_query($sql);
	// Se inserido com sucesso

        if ($query) {
		echo false;
	}
	// Se houver algum erro ao inserir
	else {
		echo "Não foi possivel cadastrar o texto no momento, tente mais tarde.";
	}
}
?>
