<?php
require_once 'conecta.php';
require_once 'define.php';
header("Content-Type: text/html; charset=ISO-8859-1",true);

  // RECEBENDO OS DADOS PREENCHIDOS DO FORMUL�RIO !
 $profissao = utf8_decode($_POST ["profissao"]);
 $descricao = utf8_decode($_POST ["descricao"]);
 $user = $_SESSION['id_usuario'];
//Verifica se a profiss�o foi preenchida.
 if (empty($profissao)) {
     echo "Preencha o campo profiss�o";
 }
 if (empty($descricao)) {
     echo "Preencha o campo descri��o";
 }
// elseif (strlen($profissao) <=4) {
//     echo "Profiss�o n�o v�lida";
// }
 
 // Se n�o houver nenhum erro
else {
	// Inserimos no banco de dados
	$sql = "INSERT INTO profissao ( 
                    nm_profissao,
                    ao_ativo,
                    dt_inclusao, 
                    id_usuarioinclusao,
                    ds_profissao,
                    dt_moderacao
                )
                VALUES (
                    '".mb_strtoupper($profissao)."', 
                    'S',
                    now(), 
                    '".$user."', 
                    '".mb_strtoupper($descricao)."',
                    now()
                )";
        //die($sql);
        $query = mysql_query($sql);
	// Se inserido com sucesso
	
        if ($query) {
		echo false;
	}
	// Se houver algum erro ao inserir
	else {
		echo "N�o foi possivel cadastrar a profiss�o no momento, tente mais tarde.";
	}
}
?>