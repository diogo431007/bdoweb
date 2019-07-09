<?php
require_once 'conecta.php';
require_once 'define.php';
header("Content-Type: text/html; charset=ISO-8859-1",true);
  // RECEBENDO OS DADOS PREENCHIDOS DO FORMULÁRIO !
 $secretaria = utf8_decode($_POST ["secretaria"]);
 $user = $_SESSION['id_usuario'];
//Verifica se a profissão foi preenchida.
 if (empty($secretaria)) {
     echo "Preencha o campo Secretaria";
 }elseif (strlen($secretaria) < 3) {
     echo "Secretaria não válida. ";
 }

 // Se não houver nenhum erro
else {
	// Inserimos no banco de dados
	$sql = "INSERT INTO secretaria (
                    nm_secretaria,
                    dt_inclusao,
                    id_usuarioinclusao
                )
                VALUES (
                    '".mb_strtoupper($secretaria)."',
                    now(),
                    ".$user."
                )";

        $query = mysql_query($sql);
        //echo $sql;die;
	// Se inserido com sucesso

        if ($query) {
		echo false;
	}
	// Se houver algum erro ao inserir
	else {
		echo "Não foi possivel cadastrar a Secretaria no momento, tente mais tarde.";
	}
}
?>
