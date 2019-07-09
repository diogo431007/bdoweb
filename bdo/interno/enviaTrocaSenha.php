<?php
   
  include 'conecta.php';
  
  $senha         = md5($_POST['senha']);
  $novasenha     = $_POST['nova_senha'];
  $confirmasenha = $_POST['confirma'];
  $login         = $_POST['username'];
  
  if(empty($login) || empty($senha) || empty($novasenha) || empty($confirmasenha)){
      echo "<script>alert('Preecha todos os campos!');window.location = 'trocaSenha.php';</script>";
  }else{ 
          
  $query = "SELECT 
                u.pw_senha 
            FROM 
                usuario u 
            WHERE 
                u.ds_login = '".$login."' AND 
                u.pw_senha = '".$senha."'";
  $result = mysql_query($query);
  $row = mysql_num_rows($result);

  if ($row){
  	  
  	if (isset($login) && isset($senha)  && isset($novasenha)  && isset($confirmasenha)) { 
        if ($novasenha == $confirmasenha){
  	  	
  	  	$senha = md5($novasenha);
  	  	$sql = "UPDATE 
                            usuario 
                        SET 
                            pw_senha = '".$senha."', 
                            ao_trocasenha = 'N' 
                        WHERE 
                            ds_login = '".$login."' ";
  	  	$query = mysql_query($sql);
  	  	
  	  		if ($query){
                             echo "<script>alert('Senha alterada com sucesso!');window.location = 'index.php';</script>";
  	  		}
  	  		else{
  	  		 echo "<script>alert('Erro ao trocar a senha !');window.location = 'trocaSenha.php';</script>";
  	  		
  	  		}
  	  	
  	  }
  	  else{
  	  	
  	  	echo "<script>alert('As senhas não coincidiram!');window.location = 'trocaSenha.php';</script>";
  	  	
  	  }
  	
  }
  else{
  	
  	echo "<script>alert('A senha ou login incorretos!');window.location = 'trocaSenha.php';</script>";
  }
  }else{
  	
  	echo "<script>alert('A senha ou login incorretos!');window.location = 'trocaSenha.php';</script>";
  }
  
  }
?>  
