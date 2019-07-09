<?php
// Incluimos o arquivo de conexÃ£o
require_once "conecta.php";
require_once 'define.php';
header("Content-Type: text/html; charset=ISO-8859-1",true);

 $user  = $_POST["user"];
 $pass  = md5($_POST["pass"]);

// Verifica se o nome foi preenchido
if (empty($user)) {
	echo "Digite o login";
}
elseif (strlen($user) <= 3) {
	echo "Digite um login válido";
}
elseif (empty($pass)) {
	echo "Digite a senha";
}
elseif (strlen($pass) <= 3) {
	echo "Digite uma senha válida";
}

// Se não houver nenhum erro
else {
	// buscamos usuário no banco de dados
	$sql  = "SELECT     u.nm_usuario, 
                            u.id_usuario, 
                            p.ds_perfil,
                            p.id_perfil,
                            u.ao_trocasenha
                       FROM 
                            usuario u, 
                            perfil p 
                       WHERE 
                            u.ds_login = '$user' 
                        and 
                            u.pw_senha = '$pass'
                        and 
                            u.id_perfil = p.id_perfil
                       and
                            u.ao_controle = 'S'";
        //echo $sql;die;
        $resultado = mysql_query($sql);
        $linha = mysql_num_rows ($resultado);
        if ($linha) {
            $row = mysql_fetch_object($resultado);
            //echo $row->troca_senha;die;
  	if ($row->ao_trocasenha == 'S'){
              echo "<script>window.location = 'trocaSenha.php';</script>";
  	}else{
  		session_start();
   		$_SESSION['id_usuario']  = $row->id_usuario;
  		$_SESSION['nome_usuario']  = $row->nm_usuario;
  		$_SESSION['perfil'] = $row->ds_perfil;
                $_SESSION['id_perfil'] = $row->id_perfil;
                
                // CONSULTA AS PAGINAS QUE O PERFIL DO USUARIO TEM ACESSO
               $sql_acesso = "SELECT 
                                    pg.ds_pagina as nome_pagina, 
                                    pg.id_pagina as id_pagina 
                                FROM 
                                    perfilpagina pp, 
                                    pagina pg
                                WHERE 
                                    pg.id_pagina = pp.id_pagina AND 
                                    pp.id_perfil =".$_SESSION['id_perfil']."
                                    AND pg.ao_ativo='S'    
                                ORDER BY 
                                    id_pagina";
               
                $query_acesso = mysql_query($sql_acesso);
                $a=0;
                while($row_acesso = mysql_fetch_object($query_acesso)) {
                    $_SESSION[SESSION_ACESSO][$a] = $row_acesso->id_pagina;
                    $a++;
                }
                
                
                //var_dump($_SESSION[SESSION_ACESSO]);                
    
    
                foreach ($_SESSION[SESSION_ACESSO] as $permissao) {
                    
                    if($permissao == S_CADASTRO){
                        echo "<script>window.location = 'cadastro.php';</script>";
                    }else if($permissao == S_PESQUISA){
                        echo "<script>window.location = 'busca.php';</script>";
                    }else if($permissao == S_RELATORIO){
                        echo "<script>window.location = 'relatorio.php';</script>";
                    }
                }
//                die;;
                
                // COLOCAR TESTE SE NAO RETORNAR NADA NA CONSULTAS DAR MENSAGEM, SE RETORNAR....
  		// direciona para a página inicial
//  		echo "<script>window.location = 'cadastro.php';</script>";
                
                
  	}
		//echo false;
	}
	// Se houver algum erro ao inserir
	else {
		echo "Usuário ou senha incorretos";
	}
}
?>
