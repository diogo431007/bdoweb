<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">

<link rel="stylesheet" href="css/style.css" type="text/css" >
<link rel="stylesheet" href="css/jquery.tabs.css" type="text/css" media="print, projection, screen">      
<link rel="stylesheet" href="css/jquery.tabs-ie.css" type="text/css" media="projection, screen">
<link href="css/jquery.click-calendario-1.0.css" rel="stylesheet" type="text/css"/>


<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.click-calendario-1.0-min.js"></script>		
<script type="text/javascript" src="js/exemplo-calendario.js"></script>


<script src="js/jquery-1.1.3.1.pack.js" type="text/javascript"></script>
<script src="js/jquery.history_remote.pack.js" type="text/javascript"></script>
<script src="js/jquery.tabs.pack.js" type="text/javascript"></script>
<script type="text/javascript" src="js/start.effect.js"></script>

<script src="js/clonacampo.js" type="text/javascript"></script>

<script src="js/custom-form-elements.js" type="text/javascript"></script>
        
<link rel="shortcut icon" href="../../Utilidades/Imagens/bancodeoportunidades/logo_aba.png"/>

<title>Banco de Oportunidades</title>
</head>
<body class="body_login" >
      
      	<div id="login">
         <form name="loginSistema" id="loginSistema" action="envialogin.php" method="post">
	   <table >
    	     <tr class="texto">
	       <td>Usuario:</td>
    	       <td><input name="username" class="campo" type="text"  size="30" maxlength="30" />
             </tr>
             <tr class="texto">
    	       <td>Senha:</td>
               <td><input name="senha" class="campo" type="password"  size="30" maxlength="30"/>
             </tr>
	     <tr>
               <td>
	         <input type="submit" class="botao" value="Entrar"/>
                 <input type="reset"  class="botao" value="Limpar" />
	       </td>
	     </tr>
             <tr>
	       <td>&nbsp;</td>
	       <td><a href="mudarsenha.php" class="link" title="Clique para mudar sua senha." >Mudar Senha. </a></td>
	     </tr>
          </table>
        </form>
      </div>
 
 
<?php require_once 'footer.php';  ?>