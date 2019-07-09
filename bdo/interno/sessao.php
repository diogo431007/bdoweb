<?php

  session_start();
  if (isset($_SESSION["nome_usuario"]))
  	$nome_usuario = $_SESSION["nome_usuario"];
  
  if (isset($_SESSION["senha_usuario"]))
  	$senha_usuario = $_SESSION["senha_usuario"];
  
  if (!(empty($nome_usuario) or empty($senha_usuario)))
  {
  	include 'conecta.php';
  	
  	$sql = "SELECT 
                    * 
                FROM 
                    usuario u 
                WHERE 
                    u.nm_usuario = '$nome_usuario'";
  	
  	$resultado = mysql_query($sql);
  	if (mysql_num_rows($resultado)==1)
  	{
  		if ($senha_usuario != mysql_result($resultado, 0, "pw_senha"))
  		{
  			unset($_SESSION['nome_usuario']);
  			unset($_SESSION['senha_usuario']);
  			echo "<script>alert('Você não efetuou o login!');window.location = 'login.php';</script>";
  			exit;
  			
  		}
  	}
  	else
  	{
  		unset($_SESSION['nome_usuario']);
  		unset($_SESSION['senha_usuario']);
  		echo "<script>alert('Você não efetuou o login!');window.location = 'login.php';</script>";
  		exit;
  	}  
  }
  else
  {
  	echo "<script>alert('Você não efetuou o login!');window.location = 'login.php';</script>";
  	exit;
  }
  mysql_close($con);
  
  
  class ControleSessao{
    public static function abrirSessao(){
        session_start();
    }
  }
  
?>
