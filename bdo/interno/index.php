<?php
header ('Content-type: text/html; charset=ISO-8859-1');
require_once "conecta.php";
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <link   rel="stylesheet" href="css/style.css" type="text/css" >
        <link   rel="stylesheet" href="css/jquery.tabs.css" type="text/css" media="print, projection, screen">
        <link   rel="stylesheet" href="css/jquery.tabs-ie.css" type="text/css" media="projection, screen">
        <script type="text/javascript" src="js/jquery-1.6.2.js"></script>
        <script type="text/javascript" src="js/jquery.maskedinput.js"></script>
        <script type="text/javascript" src="js/funcoes.js"></script>
        <script src="js/jquery.history_remote.pack.js" type="text/javascript"></script>
        <script src="js/jquery.tabs.pack.js" type="text/javascript"></script>
        <script type="text/javascript" src="js/start.effect.js"></script>
        <script src="js/clonacampo.js" type="text/javascript"></script>
        <script src="js/custom-form-elements.js" type="text/javascript"></script>
        <link rel="shortcut icon" href="../../Utilidades/Imagens/bancodeoportunidades/logo_aba.png"/>
        <link href="css/ui-lightness/jquery-ui-1.10.3.custom.css" rel="stylesheet">
        <script src="js/jquery-ui-1.10.3.custom.js"></script>

<link rel="shortcut icon" href="../../Utilidades/Imagens/bancodeoportunidades/logo_aba.png" type="image/x-icon"/>

<title>Banco de Oportunidades</title>
</head>

<body class="body_login" >
    <?php
        // Selecionando a imagem do sistema
        $sql_SE = mysql_query("SELECT imagem FROM imagemsistema WHERE lado = 'SE'");
        $sql_SD = mysql_query("SELECT imagem FROM imagemsistema WHERE lado = 'SD'");
        $sql_IE = mysql_query("SELECT imagem FROM imagemsistema WHERE lado = 'IE'");
        $sql_ID = mysql_query("SELECT imagem FROM imagemsistema WHERE lado = 'ID'");

        $usuario_SE = mysql_fetch_object($sql_SE);
        $usuario_SD = mysql_fetch_object($sql_SD);
        $usuario_IE = mysql_fetch_object($sql_IE);
        $usuario_ID = mysql_fetch_object($sql_ID);
    ?>
    <div id="corpo">
            <div id="header">
                <!--<div id="logo2">
                     <img id="cabecalho-logo" alt="CanoasTec" src="imagens/Novologoct.png">
                </div>-->
                <div id="logo2">
                    <img id="cabecalho-logo" alt="Banco de Oportunidades" src="../../Utilidades/Imagens/bancodeoportunidades/<?php echo $usuario_SD->imagem; ?>" width="266" height="77" style="margin-top: -25px; margin-left: -50px;">
                </div>
                <div id="logo">
                    <img id="cabecalho-logo" alt="Brasão da Prefeitura" src="../../Utilidades/Imagens/bancodeoportunidades/<?php echo $usuario_SE->imagem; ?>" width="210"  height="110" style="margin-top: -35px; margin-left: -10px;">
                </div>
            </div>
            <div id="menu">
                <ul>
                    <li><a href="../index.php">Banco de Oportunidades</a></li>
                </ul>
            </div>
        <br /><br />
        <div id="login">
            <div class="texto" style="margin-right: 192px;">ADMINISTRAÇÃO INTERNA DO SISTEMA</div>
            <hr style="width: 400px; margin-right: 200px; border: 1px solid #9ED0CA; border-collapse: collapse;"></hr>
            <br />
            <div class="caixa_login" style="background-color: #F5F5DC;">
             <form name="sisLog" id="sisLog" method="post" action="javascript:func()" >

             <table border="0">
    	     <tr class="texto">
             <div id="log_aux">
                 <div id="log_error" style="width: 376px; background-color: #F66401; color: white;"></div>
             </div>
	       <td>Usuário:</td>
               <td><input name="user_log" id="user_log" class="campo" type="text" style="border-color: #9ED0CA;" size="43" maxlength="30" />
             </tr>
             <tr class="texto">
    	       <td>Senha:</td>
               <td><input name="pass_log" id="pass_log" class="campo" type="password" style="border-color: #9ED0CA;" size="43" maxlength="30"/>
             </tr>
	     <tr>
               <td align="right" colspan="2">
	         <input type="submit" class="botao" value="Entrar"/>

	       </td>
	     </tr>
             <tr>
	       <td align="right" colspan="2"><a href="trocaSenha.php" class="link" title="Clique para mudar sua senha." >Alterar Senha. </a></td>
	     </tr>
             </table>
             </form>
          </div>
      </div>
      <div id="log_ok"></div>
    </div>
    <div id="footer">
        <div id="rodape">
            <!--<span id="assinatura">Banco de Oportunidades &copy; 2014</span>-->
            <img src="../../Utilidades/Imagens/bancodeoportunidades/<?php echo $usuario_ID->imagem; ?>" height="40px">
            <img src="../../Utilidades/Imagens/bancodeoportunidades/<?php echo $usuario_IE->imagem; ?>" height="40px" style="margin-top: 13px; float:left; margin-right: 638px;">
            <?php
                // lê todo o conteúdo do arquivo
                // atribui à variável $arquivo
                $arquivo = file_get_contents('../version.txt');
                // imprime o conteúdo do arquivo
                // no navegador
                echo "<div style='border: solid 1px #E4E2CD; margin-top: 60px; width: 950px; margin-left: 10px;'></div>";
                echo "<div class='versao_rodape'>Versão: ".$arquivo."</div>";
            ?>
        </div>
    </div>
