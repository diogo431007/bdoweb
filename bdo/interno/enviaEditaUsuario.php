<?php
// Incluimos o arquivo de conexÃ£o
//require_once 'header.php';
require_once 'conecta.php';

header("Content-Type: text/html; charset=ISO-8859-1",true);

// Recuperamos os valores dos campos atravÃ©s do mÃ©todo POST
 $id       = $_POST ['id'];
 $nome     = utf8_decode($_POST ['nome']); //utf8 utilizado para remover problemas de caracteres acentuados
 $email    = utf8_decode($_POST ['email']); //utf8 utilizado para remover problemas de caracteres acentuados
 $perfil   = utf8_decode($_POST ['perfil']); //utf8 utilizado para remover problemas de caracteres acentuados
 $secretaria   = utf8_decode($_POST ['secretaria']); //utf8 utilizado para remover problemas de caracteres acentuados
 $controle =  utf8_decode($_POST ['controle']); //utf8 utilizado para remover problemas de caracteres acentuados

// Verifica se o nome foi preenchido
if (empty($nome)) {
	echo "Digite o nome";
}
elseif (strlen($nome) <= 3) {
	echo "Digite o nome completo";
}
elseif (empty($email)) {
	echo "Digite o email";
}
// Verifica se o email é válido
elseif  (!preg_match ("/^[A-Za-z0-9]+([_.-][A-Za-z0-9]+)*@[A-Za-z0-9]+([_.-][A-Za-z0-9]+)*\\.[A-Za-z0-9]{2,4}$/", $email))  {
	echo "Digite um email válido";
}
elseif (empty($perfil)) {
	echo "Selecione um perfil";
}
elseif ($perfil === "Selecione...") {
	echo "Selecione um perfil válido";
}
elseif (empty($secretaria)) {
	echo "Selecione uma secretaria";
}
elseif ($secretaria === "Selecione...") {
	echo "Selecione um perfil válido";
}
elseif (!isset ($controle)) {
	echo "Selecione um modo de controle para o perfil";
}
// Se não houver nenhum erro
else {
    
	// Inserimos no banco de dados
	$sql =  "UPDATE 
                    usuario 
                SET 
                    nm_usuario = '".mb_strtoupper($nome)."', 
                    ds_email = '".mb_strtoupper($email)."', 
                    id_perfil = '$perfil', 
                    dt_alteracao = now(), 
                    ao_controle = '$controle', 
                    id_secretaria = '$secretaria'
                WHERE 
                    id_usuario = $id";
	//echo $sql;die;
	$query = mysql_query($sql);
      
	// Se inserido com sucesso
	if ($query) {
            echo false;
            //echo "<script>alert('Usuário alterado com sucesso');window.location = 'busca.php#parte-02';</script>";
	}
	// Se houver algum erro ao inserir
	else {
            echo 'Não foi possível alterar o usuário';
		//echo "<script>alert('Não foi possível alterar o usuário');window.location = 'busca.php#parte-02';</script>";
	}
         
}	
?>