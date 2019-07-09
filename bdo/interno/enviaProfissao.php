<?php
require_once 'conecta.php';
require_once 'define.php';
header("Content-Type: text/html; charset=ISO-8859-1",true);

  // RECEBENDO OS DADOS PREENCHIDOS DO FORMULÁRIO !
 $profissao = utf8_decode($_POST ["profissao"]);
 $descricao = utf8_decode($_POST ["descricao"]);
 $user = $_SESSION['id_usuario'];
//Verifica se a profissão foi preenchida.
 if (empty($profissao)) {
     echo "Preencha o campo profissão";
 }
 if (empty($descricao)) {
     echo "Preencha o campo descrição";
 }
// elseif (strlen($profissao) <=4) {
//     echo "Profissão não válida";
// }
 
 // Se não houver nenhum erro
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
		echo "Não foi possivel cadastrar a profissão no momento, tente mais tarde.";
	}
}
?>