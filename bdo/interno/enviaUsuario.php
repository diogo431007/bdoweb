<?php
// Incluimos o arquivo de conexão
require_once 'conecta.php';
header("Content-Type: text/html; charset=ISO-8859-1",true);
// Recuperamos os valores dos campos através do método POST

 $nome   = utf8_decode($_POST ["nome"]);//atribui��o do campo "nome" vindo do formul�rio para variavel
 $login  = utf8_decode($_POST ["login"]);
 $email  = utf8_decode($_POST ["email"]);//atribui��o do campo "email" vindo do formul�rio para variavel
 $senha  = utf8_decode($_POST ["senha"]);//atribui��o do campo "senha" vindo do formul�rio para variavel
 $perfil =  $_POST ["perfil"];
 $secretaria = $_POST["secretaria"];

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
// Verifica se o email � v�lido
elseif  (!preg_match ("/^[A-Za-z0-9]+([_.-][A-Za-z0-9]+)*@[A-Za-z0-9]+([_.-][A-Za-z0-9]+)*\\.[A-Za-z0-9]{2,4}$/", $email))  {
	echo "Digite um email v�lido";
}
elseif (empty($login)) {
	echo "Digite o login";
}
elseif (strlen($login) <= 4) {
	echo "Digite um login v�lido";
}
// Verifica se a mensagem foi digitada
elseif (empty($senha)) {
	echo "Digite sua senha";
}
// Verifica se a mensagem nao ultrapassa o limite de caracteres
elseif (strlen($senha) < 4) {
	echo "A senha deve conter no m�nimo 5 caracteres";
}
elseif (empty($perfil)) {
	echo "Selecione um perfil";
}
elseif ($perfil == "Selecione...") {
	echo "Selecione um perfil";
}
elseif (empty($secretaria)) {
	echo "Selecione um secretaria";
}
elseif ($secretaria == "Selecione...") {
	echo "Selecione uma secretaria";
}
// Se n�o houver nenhum erro
else {
    
     $query = "SELECT u.ds_login FROM usuario u WHERE u.ds_login = '".$login."'";
     $result = mysql_query($query);
     $row = mysql_num_rows($result);
     if ($row){
  	echo "O login ".$login." j� est� em uso!";
     }
     else{
         
         
	// Inserimos no banco de dados
	 $sql = "INSERT INTO usuario ( 
                    nm_usuario, 
                    ds_email, 
                    pw_senha, 
                    id_perfil,
                    ds_login, 
                    dt_inclusao, 
                    ao_controle, 
                    ao_trocasenha,
                    id_secretaria
                )
                VALUES (
                    '".mb_strtoupper($nome)."', 
                    '".mb_strtoupper($email)."', 
                    '".md5($senha)."', 
                    '$perfil', 
                    '".mb_strtoupper($login)."', 
                    now(), 
                    'S', 
                    'S', 
                    '$secretaria'
                )";
	
	$query = mysql_query($sql);
	// Se inserido com sucesso
	if ($query) {
		echo false;
	}
	// Se houver algum erro ao inserir
	else {
		echo "N�o foi possivel realizar o cadastro no momento, tente mais tarde.";
	}
     }     
}

?>
