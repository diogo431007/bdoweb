<?php
header("Content-Type: text/html; charset=ISO-8859-1",true);
require_once 'define.php';
require_once 'conecta.php';
// RECEBENDO OS DADOS PREENCHIDOS DO FORMULÁRIO !
$id             = $_POST ["id"]; // pega a ID do usuário
$deficiencia      = utf8_decode($_POST ["deficiencia"]);

  if (empty($deficiencia)) {
	echo "Digite a deficiência";
}
else if (strlen($deficiencia) < 4) {
	echo "Deficiência inválida";
}

//Se não houve rnenhum erro

else {
    $sql = "UPDATE 
                deficiencia 
            SET 
                id_usuarioalteracao = ".$_SESSION['id_usuario'].", 
                nm_deficiencia = '".mb_strtoupper($deficiencia)."', 
                dt_alteracao = now() 
            WHERE 
                id_deficiencia = '$id' " ;
    
    $query = mysql_query($sql);
	// Se inserido com sucesso
	if ($query) {
		echo false;
	}
	// Se houver algum erro ao inserir
	else {
		echo "Não foi possivel alterar a deficiência.";
	}

}

   ?>

    