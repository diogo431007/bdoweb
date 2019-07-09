<?php
require_once "conecta.php";
require_once 'define.php';

?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">

        <link   rel="stylesheet" href="css/style.css" type="text/css" >
        <link   rel="stylesheet" href="css/jquery.tabs.css" type="text/css" media="print, projection, screen">      
        <link   rel="stylesheet" href="css/jquery.tabs-ie.css" type="text/css" media="projection, screen">
        <!--<script type="text/javascript" src="js/jquery.js"></script>-->
        <!--script src="js/jquery-1.3.2.js" type="text/javascript"></script-->
        <script type="text/javascript" src="js/jquery-1.6.2.js"></script>
        <script type="text/javascript" src="js/jquery.maskedinput.js"></script>
        <script type="text/javascript" src="js/funcoes.js"></script>
        
        <script src="js/jquery.history_remote.pack.js" type="text/javascript"></script>
        <script src="js/jquery.tabs.pack.js" type="text/javascript"></script>
        <script type="text/javascript" src="js/start.effect.js"></script>
        <script src="js/clonacampo.js" type="text/javascript"></script>
        <script src="js/custom-form-elements.js" type="text/javascript"></script>     
        <link   rel="shortcut icon" href="../../Utilidades/Imagens/bancodeoportunidades/logo_aba.png" type="image/x-icon"/>
        
        <link href="css/ui-lightness/jquery-ui-1.10.3.custom.css" rel="stylesheet">
        <!--	<script src="js/jquery-1.9.1.js"></script>-->
	<script src="js/jquery-ui-1.10.3.custom.js"></script>

        <script>
            
        
        
        //função para pegar o objeto ajax do navegador
            function xmlhttp()
            {
                // XMLHttpRequest para firefox e outros navegadores
                if (window.XMLHttpRequest)
                {
                    return new XMLHttpRequest();
                }

                // ActiveXObject para navegadores microsoft
                var versao = ['Microsoft.XMLHttp', 'Msxml2.XMLHttp', 'Msxml2.XMLHttp.6.0', 'Msxml2.XMLHttp.5.0', 'Msxml2.XMLHttp.4.0', 'Msxml2.XMLHttp.3.0', 'Msxml2.DOMDocument.3.0'];
                for (var i = 0; i < versao.length; i++)
                {
                    try
                    {
                        return new ActiveXObject(versao[i]);
                    }
                    catch (e)
                    {
                        alert("Seu navegador não possui recursos para o uso do AJAX!");
                    }
                } // fecha for
                return null;
            } // fecha função xmlhttp

        //função para fazer a requisição da página que efetuará a consulta no DB
            function carregar()
            {
                a = document.getElementById('busca').value;
                ajax = xmlhttp();
                if (ajax)
                {
                    ajax.open('get', 'buscaUsuario.php?busca=' + a, true);
                    ajax.onreadystatechange = trazconteudo;
                    ajax.send(null);
                }
            }
        //função para incluir o conteúdo na pagina
            function trazconteudo()
            {
                if (ajax.readyState == 4)
                {
                    if (ajax.status == 200)
                    {
                        document.getElementById('resultados').innerHTML = ajax.responseText;
                    }
                }
            }
        //função para fazer a requisição da página que efetuará a consulta no DB
            function carregarPerfil()
            {
                a = document.getElementById('buscaPerfil').value;
                ajax = xmlhttp();
                if (ajax)
                {
                    ajax.open('get', 'buscaPerfil.php?buscaPerfil=' + a, true);
                    ajax.onreadystatechange = trazconteudoPerfil;
                    ajax.send(null);
                }
            }
        //função para incluir o conteúdo na pagina de perfil
            function trazconteudoPerfil()
            {
                if (ajax.readyState == 4)
                {
                    if (ajax.status == 200)
                    {
                        document.getElementById('resultadoPerfil').innerHTML = ajax.responseText;
                    }
                }
            }
            function carregarProfissao()
            {
                a = document.getElementById('buscaProfissao').value;
                ajax = xmlhttp();
                if (ajax)
                {
                    ajax.open('get', 'buscaProfissao.php?buscaProfissao=' + a, true);
                    ajax.onreadystatechange = trazconteudoProfissao;
                    ajax.send(null);
                }
            }
            
            function carregarDeficiencia()
            {
                a = document.getElementById('buscaDeficiencia').value;
                ajax = xmlhttp();
                if (ajax)
                {
                    ajax.open('get', 'buscaDeficiencia.php?buscaDeficiencia=' + a, true);
                    ajax.onreadystatechange = trazconteudoDeficiencia;
                    ajax.send(null);
                }
            }
            
            
        //função para incluir o conteúdo na pagina de Profissoes
            function trazconteudoProfissao()
            {
                if (ajax.readyState == 4)
                {
                    if (ajax.status == 200)
                    {
                        document.getElementById('resultadoProfissao').innerHTML = ajax.responseText;
                    }
                }
            }
            
        //função para incluir o conteúdo na pagina de Deficiencias
            function trazconteudoDeficiencia()
            {
                if (ajax.readyState == 4)
                {
                    if (ajax.status == 200)
                    {
                        document.getElementById('resultadoDeficiencia').innerHTML = ajax.responseText;
                    }
                }
            }
            function carregarCandidato()
            {
                a = document.getElementById('buscaCandidato').value;
                ajax = xmlhttp();
                if (ajax)
                {
                    ajax.open('get', 'buscaCandidato.php?buscaCandidato=' + a, true);
                    ajax.onreadystatechange = trazconteudoCandidato;
                    ajax.send(null);
                }
            }
        //função para incluir o conteúdo na pagina de Profissoes
            function trazconteudoCandidato()
            {
                if (ajax.readyState == 4)
                {
                    if (ajax.status == 200)
                    {
                        document.getElementById('resultadoCandidato').innerHTML = ajax.responseText;
                    }
                }
            }
            function carregarEmpresa()
            {
                a = document.getElementById('buscaEmpresa').value;
                ajax = xmlhttp();
                if (ajax)
                {
                    ajax.open('get', 'buscaEmpresa.php?buscaEmpresa=' + a, true);
                    ajax.onreadystatechange = trazconteudoEmpresa;
                    ajax.send(null);
                }
            }
        //função para incluir o conteúdo na pagina de Profissoes
            function trazconteudoEmpresa()
            {
                if (ajax.readyState == 4)
                {
                    if (ajax.status == 200)
                    {
                        document.getElementById('resultadoEmpresa').innerHTML = ajax.responseText;
                    }
                }
            }
            
            
            

        </script>

        <title>Banco de Oportunidades</title>
    </head>
    <body>

        <div id="corpo">
            <div id="header">
                 <div id="logo2">
                     <img id="cabecalho-logo" alt="CanoasTec" src="imagens/Novologoct.png">
                </div>
                <div id="logo">
                    <img id="cabecalho-logo" alt="Brasão da Prefeitura" src="imagens/logoCanoas.png">
                </div>
            </div>
            <div id="menu">

                <ul>
                    <?PHP
                    
                    if (in_array(S_CADASTRO, $_SESSION[SESSION_ACESSO])) {
                        echo '<li><a href="cadastro.php">Cadastros</a></li>';
                    }
                    if (in_array(S_PESQUISA, $_SESSION[SESSION_ACESSO])) {
                        echo '<li><a href="busca.php">Pesquisas</a></li>';
                    }
                    if (in_array(S_RELATORIO, $_SESSION[SESSION_ACESSO])) {
                        echo '<li><a href="relatorio.php">Relatórios</a></li>';
                    }
                    if (in_array(S_EMAIL, $_SESSION[SESSION_ACESSO])){
                        echo '<li><a href="email.php">Email</a></li>';
                    } 
                    if (in_array(S_MANUAIS, $_SESSION[SESSION_ACESSO])){
                        echo '<li><a href="ListaManuais.php">Manuais</a></li>';
                    }                    
                    
                    ?>
                    
                    <!--<li><a href="#">Sobre</a></li>-->
                </ul>
            </div>
             <div class="sessao" >
                <?php echo "Usuário: <b>".$_SESSION['nome_usuario']."</b>";  
             
                 echo"&nbsp;<a class='logout' href='logout.php'>Sair</a> ";

                ?>
                </div>
