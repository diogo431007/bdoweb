<?php
//Conexão com o Banco de Dados
include("./interno/conecta.php");
include_once './publico/util/ControleSessao.class.php';
ControleSessao::abrirSessao();
?>
<html>
    <head>
        
        <script type="text/javascript" src="./publico/js/jquery-1.2.1.pack.js"></script>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <link rel="stylesheet" href="./publico/css/style.css" type="text/css" >
        <link rel="stylesheet" href="./publico/css/jquery.tabs.css" type="text/css" media="print, projection, screen">      
        <link rel="stylesheet" href="./publico/css/jquery.tabs-ie.css" type="text/css" media="projection, screen">
        <script type="text/javascript" src="./publico/js/jquery.js"></script>
        <script type="text/javascript" src="./publico/js/jquery.maskedinput.js"></script>
        <script type="text/javascript" src="./publico/js/funcoes.js"></script>
        <script src="./publico/js/jquery-1.3.2.js" type="text/javascript"></script>
        <script src="./publico/js/jquery.history_remote.pack.js" type="text/javascript"></script>
        <script src="./publico/js/jquery.tabs.pack.js" type="text/javascript"></script>
        <script type="text/javascript" src="./publico/js/start.effect.js"></script>
        <script src="./publico/js/clonacampo.js" type="text/javascript"></script>
        <script src="./publico/js/custom-form-elements.js" type="text/javascript"></script>
        <link rel="shortcut icon" href="../Utilidades/Imagens/bancodeoportunidades/logo_aba.png" type="image/x-icon"/>
        <title>Banco de Oportunidades</title>
    </head>
    <body>

        <div id="corpo">
            <div id="header">
                 <div id="logo2">
                     <img id="cabecalho-logo" alt="CanoasTec" src="../Utilidades/Imagens/bancodeoportunidades/logo_canoastec.png">
                </div>
                <div id="logo">
                    <img id="cabecalho-logo" alt="Brasão da Prefeitura" src="../Utilidades/Imagens/bancodeoportunidades/brasao_prefeitura.png">
                </div>
            </div>
            <div id="conteudo">
                <!--<img id="cabecalho-logo" alt="Brasão da Prefeitura" src="./publico/imagens/Orange wave.png" />-->
                <div id="tudo">
                    
                    <div id="content">
                        <h2>BANCO DE OPORTUNIDADES</h2>
                      Ferramenta em atualização.<br><br>
                      Previsão de liberação: 30 minutos.
                      <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        </div>
                    </div>
                </div>
        <div id="footer">
            <div id="rodape">
                <span id="assinatura">Banco de Oportunidades &copy; 2014</span>
                <img src="../Utilidades/Imagens/bancodeoportunidades/logo_prefeitura.png" height="40px" />
            </div>
        </div>

    </body>
</html>
<?php
ControleSessao::destruirVariavel('msg');
ControleSessao::destruirVariavel('msgEmpresa');
?>