<?php
require_once 'conecta.php';
require_once 'define.php';
header("Content-Type: text/html; charset=ISO-8859-1",true);
  // RECEBENDO OS DADOS PREENCHIDOS DO FORMULÁRIO !
 $deficiencia = utf8_decode($_POST ["deficiencia"]);
 
 $user = $_SESSION['id_usuario'];
//Verifica se a deficiencia foi preenchida.
 if (empty($deficiencia)) {
     echo "Preencha o campo deficiência";
 }
 elseif (strlen($deficiencia) <4) {
     echo "Deficiência não válida";
 }
 
 // Se não houver nenhum erro
else {
	// Inserimos no banco de dados
	$sql = "INSERT INTO deficiencia ( 
                        nm_deficiencia, 
                        dt_inclusao, 
                        id_usuarioinclusao
                )
                VALUES (
                    '".strtoupper($deficiencia)."', 
                    now(), 
                    ".$user."
                )";

        $query = mysql_query($sql);
	// Se inserido com sucesso
	
        if ($query) {
		echo false;
	}
	// Se houver algum erro ao inserir
	else {
		echo "Não foi possivel cadastrar a deficiência no momento, tente mais tarde.";
	}
}
?>