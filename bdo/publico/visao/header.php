<?php
header ('Content-type: text/html; charset=ISO-8859-1');
include_once "../persistencia/Conexao.class.php";
include_once '../util/ControleSessao.class.php';
include_once '../util/ControleLoginCandidato.class.php';
include_once '../util/ControleLoginEmpresa.class.php';
include_once '../../interno/define.php';
?>

<html xmlns='http://www.w3.org/1999/xhtml'
      xmlns:og='http://ogp.me/ns#'>
    <head>
        <script type="text/javascript" src="../js/jquery-1.2.1.pack.js"></script>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <?php
            //Metas para os sites de buscas e redes sociais incluindo: <html xmlns='http://www.w3.org/1999/xhtml' xmlns:og='http://ogp.me/ns#'>
            //-----------------------ï¿½NICIO DAS METAS-------------------------------
        ?>
        <meta name="description" content="A Prefeitura Municipal de Canoas, atravï¿½s da Secretaria Municipal de Desenvolvimento Econï¿½mico e da Diretoria de Emprego, Trabalho, Renda e Formaï¿½ï¿½o Profissional apresenta, o Banco de oportunidades."/>
        <meta name="application-name" content="Banco de Oportunidades"/>
        <meta name="author" content="Prefeitura de Canoas">
        <meta name="keywords" content="Banco de Oportunidades, Prefeitura de Canoas, CanoasTec, Vagas, Empregos, Oportunidade, Cidadï¿½o, Empresa, Currï¿½culo"/>
        <?php //------------------------REDES SOCIAIS---------------------------------- ?>
        <meta property='og:title' content='Banco de Oportunidades' />
        <meta property='og:type' content='website' />
        <meta property='og:url' content='http://sistemas.canoas.rs.gov.br/bancodeoportunidades/' />
        <meta property='og:image' content='http://sistemas.canoas.rs.gov.br/Utilidades/Imagens/bancodeoportunidades/logo_banco.png'/>
        <meta property='og:site_name' content='Banco de Oportunidades' />
        <meta property='og:description' content='A Prefeitura Municipal de Canoas, atravï¿½s da Secretaria Municipal de Desenvolvimento Econï¿½mico e da Diretoria de Emprego, Trabalho, Renda e Formaï¿½ï¿½o Profissional apresenta, o Banco de oportunidades.' />
        <?php //---------------------------FIM DAS METAS--------------------------------------------------------- ?>

        <link rel="stylesheet" href="../css/style.css" type="text/css" >
        <link rel="stylesheet" href="../css/jquery.tabs.css" type="text/css" media="print, projection, screen">
        <link rel="stylesheet" href="../css/jquery.tabs-ie.css" type="text/css" media="projection, screen">
        <script type="text/javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" src="../js/jquery.maskedinput.js"></script>
        <script type="text/javascript" src="../js/funcoes.js"></script>
        <script src="../js/jquery-1.3.2.js" type="text/javascript"></script>
        <script src="../js/jquery.history_remote.pack.js" type="text/javascript"></script>
        <script src="../js/jquery.tabs.pack.js" type="text/javascript"></script>
        <script type="text/javascript" src="../js/start.effect.js"></script>
        <script src="../js/clonacampo.js" type="text/javascript"></script>
        <script src="../js/custom-form-elements.js" type="text/javascript"></script>
        <link rel="shortcut icon" href="../../../Utilidades/Imagens/bancodeoportunidades/logo_aba.png"/>
        <script src="../js/jquery.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="../js/jquery.tokeninput.js"></script>
        <link rel="stylesheet" href="../css/token-input.css" type="text/css" />
        <script type="text/javascript">
            //Usado na aba profissï¿½es na busca, pois dï¿½ conflito com outras bibliotecas no jQuery
            var $JQuery = jQuery.noConflict();
        </script>

<!--        <script src="js/jquery-ui-autocomplete.js"></script>
        <script src="js/jquery.select-to-autocomplete.min.js"></script>-->

        <title>Banco de Oportunidades</title>
    </head>
    <body>

        <div id="corpo">
            <div id="header">
                <!--<div id="logo2">
                     <img id="cabecalho-logo" alt="CanoasTec" src="../imagens/Novologoct.png">
                </div>-->
                <div id="logo2">
                    <img id="cabecalho-logo" alt="Banco de Oportunidades" src="../../../Utilidades/Imagens/bancodeoportunidades/logo_banco.png" width="266" height="77" style="margin-top: -25px; margin-left: -50px;">
                </div>
                <div id="logo">
                    <img id="cabecalho-logo" alt="Brasï¿½o da Prefeitura" src="../../../Utilidades/Imagens/bancodeoportunidades/brasao_prefeitura.png" width="210"  height="110">
                </div>
            </div>
            <div id="menu">

                <ul>
                    <?php
                    if(!ControleLoginCandidato::verificarAcesso() && !ControleLoginEmpresa::verificarAcesso()){
                    ?>
                        <li><a href="../../index.php">Início</a></li>
                        <li><a href="GuiContato.php">Fale Conosco</a></li>
                    <?php
                    }else if(ControleLoginCandidato::verificarAcesso()){
                    ?>
                        <li><a href="GuiManutencaoCandidato.php">Atualização de Candidato</a></li>
                        <li><a href="GuiProcessosCandidato.php">Meus Processos</a></li>
                    <?php
                    }else if(ControleLoginEmpresa::verificarAcesso() && ControleSessao::buscarObjeto('privateEmp')->ao_liberacao == 'S'){
                    ?>
                        <li><a href="GuiManutencaoEmpresa.php">Atualização de Empresa</a></li>
                        <li><a href="GuiCurriculos.php">Buscar Currículos</a></li>
                <?php
                        if(!isset($_SESSION['cadVaga'])){
                        ?>
                            <li><a href="GuiVagas.php">Vagas</a></li>
                            <li><a href="GuiContratar.php"><b>Contratar</b></a></li>
                        <?php
                        }else{
                        ?>
                            <li><a href="GuiCadVaga.php">Vagas</a></li>
                            <li><a href="GuiContratar.php"><b>Contratar</b></a></li>
                        <?php
                        }
                        ?>
                    <?php
                    }else if(ControleLoginEmpresa::verificarAcesso() && ControleSessao::buscarObjeto('privateEmp')->ao_liberacao == 'N'){
                    ?>
                        <li><a href="GuiManutencaoEmpresa.php">Atualização de Empresa</a></li>
                    <?php
                    }
                    ?>
                        <li>
                            <div style="text-align: right; margin-right: 5px;">
                            <?php
                                if($_SESSION['nome_usuario']){
                                    echo "<small>USUÁRIO DO INTERNO: </small><b>".$_SESSION['nome_usuario']."</b>";
                                }
                            ?>
                            </div>
                        </li>
                </ul>
            </div>

            <?php
            if(ControleLoginCandidato::verificarAcesso()){
                include_once '../modelo/CandidatoVO.class.php';
            ?>
                <div class="sessao">
                    <small>CANDIDATO:</small>
                    <b style="color: black;">
                        <?php echo ControleSessao::buscarObjeto('privateCand')->nm_candidato; ?>
                    </b>
                    &nbsp;-&nbsp;

                    <?php

                        $c = ControleSessao::buscarObjeto('privateCand');

                        $ao_ativo = $c->ao_ativo;
                        $ao_abaformacao = $c->ao_abaformacao;
                        $ao_abaqualificacao = $c->ao_abaqualificacao;
                        $ao_abaexperiencia = $c->ao_abaexperiencia;



                    ?>
                    <a class="logout" href="../controle/ControleCandidato.php?op=deslogar"
                       onclick="
                           <?php
                               //Verifica se nï¿½o foi cadastrado nada
                               if(($ao_abaformacao == '') && ($ao_abaqualificacao == '') && ($ao_abaexperiencia == '')){
                           ?>
                               if(confirm('Seu currículo está incompleto, tem certeza que deseja sair?') === true){
                                   return true;
                               }else{
                                   return false;
                               }

                           <?php
                               }
                                //Verifica se o currï¿½culo estï¿½ incompleto
                               if (($ao_abaformacao == 'N') || ($ao_abaqualificacao == 'N') || ($ao_abaexperiencia == 'N')){
                           ?>
                               if(confirm('Seu currículo está incompleto! Deseja realmente sair?') === true){
                                   return true;
                               }else{
                                   return false;
                               }
                           <?php
                               }
                                //Verifica se o currï¿½culo estï¿½ inativo
                                if (($ao_abaexperiencia == 'S') && ($ao_ativo == 'N')){
                           ?>
                               if(confirm('Seu currículo está inativo! Deseja realmente sair?') === true){
                                   return true;
                               }else{
                                   return false;
                               }
                           <?php
                               }
                               //Verifica se a experiï¿½ncia foi cadastrada para ativar o currï¿½culo
                               if (($ao_abaexperiencia == 'S') && ($ao_ativo == '')){
                           ?>
                               if(confirm('Seu currículo está incompleto! Deseja realmente sair?') === true){
                                   return true;
                               }else{
                                   return false;
                               }
                           <?php
                               }
                               //Se o usuï¿½rio for antigo verifica se faltou algum passo para ele cadastrar
                               if (($ao_abaformacao == 'A') || ($ao_abaqualificacao == 'A') || ($ao_abaexperiencia == 'A')){
                           ?>
                               if(confirm('Seu currículo está incompleto! Deseja realmente sair?') === true){
                                   return true;
                               }else{
                                   return false;
                               }
                           <?php
                               }
                           ?>
                       " title="Sair do banco de oportunidades"><small>SAIR</small></a>
                </div>
            <?php
            }else if(ControleLoginEmpresa::verificarAcesso()){
            ?>
                <div class="sessao">
                    <small>EMPRESA:</small>
                    <b style="color: black;">
                        <?php
                            if(ControleSessao::buscarObjeto('privateEmp')->nm_fantasia == ""){
                                echo ControleSessao::buscarObjeto('privateEmp')->nm_razaosocial;
                            }else{
                                echo ControleSessao::buscarObjeto('privateEmp')->nm_fantasia;

                            }

                        ?>
                    </b>
                    &nbsp;
                    <br>
                        <div style="border-top: solid 1px #EE7228; width: 50%; margin-left: 25%"></div>
                    <?php if(in_array(S_VISUALIZAR_EMP, $_SESSION[SESSION_ACESSO])){ ?>
                        <a class="logout right" href="../controle/ControleEmpresa.php?op=destruir" title="Voltar ao ambiente de administraï¿½ï¿½o interna"><small>VOLTAR AO INTERNO</small></a>
                        |
                        <a class="logout right" href="../../interno/logout.php" title="Sair do sistema"><small>SAIR</small></a>
                    <?php }else{ ?>
                        <a class="logout right" href="../controle/ControleEmpresa.php?op=deslogar" title="Sair do banco de oportunidades"><small>SAIR</small></a>
                    <?php } ?>
                </div>
                <?php
                if(ControleSessao::buscarObjeto('privateEmp')->ao_liberacao == 'N'){
                ?>
                <div class="msgL">
                        <b>
                            <u>ATENÇÃO!</u>
                            <br>Sua conta no momento não está liberada para acessar os currículos.
                            Aguarde e-mail de confirmação.
                        </b>

                </div>

            <?php
                }
            }
            ?>
