<?php
require_once 'define.php';
require_once 'conecta.php';
header("Content-Type: text/html; charset=ISO-8859-1",true);
// RECEBENDO OS DADOS PREENCHIDOS DO FORMULÁRIO !
$id             = $_POST ["id"]; // pega a ID do usuário
$secretaria      = utf8_decode($_POST ["secretaria"]);

if (empty($secretaria)) {
    echo "Digite a Secretaria";
}elseif(strlen($secretaria) < 4){
    echo "Secretaria inválida!";
}

//Se não houve rnenhum erro

else {
    $sql = "UPDATE 
                secretaria 
            SET 
                id_usuarioalteracao = ".$_SESSION['id_usuario'].", 
                nm_secretaria = '".mb_strtoupper($secretaria)."', 
                dt_alteracao = now() 
            WHERE 
                id_secretaria = $id";
    $query = mysql_query($sql);
	// Se inserido com sucesso
	if ($query) {
		echo false;
	}
	// Se houver algum erro ao inserir
	else {
		echo "Não foi possivel alterar a Secretaria.";
	}

}

   ?>

    