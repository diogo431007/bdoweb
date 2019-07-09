<?php
header ('Content-type: text/html; charset=ISO-8859-1');
// FERRAMENTA EM MANUTENÇÃO
//
//if($_GET['teste']!=1){
//header("Location:atualizacao.php");
//}
//Conexão com o Banco de Dados
include("./interno/conecta.php");
include_once './publico/util/ControleSessao.class.php';
ControleSessao::abrirSessao();
?>
<html xmlns='http://www.w3.org/1999/xhtml'
      xmlns:og='http://ogp.me/ns#'>
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">

        <?php
            //Metas para os sites de buscas e redes sociais incluindo: <html xmlns='http://www.w3.org/1999/xhtml' xmlns:og='http://ogp.me/ns#'>
            //-----------------------ÍNICIO DAS METAS-------------------------------
        ?>
        <meta name="description" content="A Prefeitura Municipal de Canoas, através da Secretaria Municipal de Desenvolvimento Econômico e da Diretoria de Emprego, Trabalho, Renda e Formação Profissional apresenta, o Banco de oportunidades."/>
        <meta name="application-name" content="Banco de Oportunidades"/>
        <meta name="author" content="Prefeitura de Canoas">
        <meta name="keywords" content="Banco de Oportunidades, Prefeitura de Canoas, CanoasTec, Vagas, Empregos, Oportunidade, Cidadão, Empresa, Currículo"/>
        <?php //------------------------REDES SOCIAIS---------------------------------- ?>
        <meta property='og:title' content='Banco de Oportunidades' />
        <meta property='og:type' content='website' />
        <meta property='og:url' content='http://sistemas.canoas.rs.gov.br/bancodeoportunidades/' />
        <meta property='og:image' content='http://sistemas.canoas.rs.gov.br/bancodeoportunidades/publico/imagens/new_logo_bdo.png'/>
        <meta property='og:site_name' content='Banco de Oportunidades' />
        <meta property='og:description' content='A Prefeitura Municipal de Canoas, através da Secretaria Municipal de Desenvolvimento Econômico e da Diretoria de Emprego, Trabalho, Renda e Formação Profissional apresenta, o Banco de oportunidades.' />
        <?php //---------------------------FIM DAS METAS--------------------------------------------------------- ?>

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
        <script type="text/javascript" src="./publico/js/jquery-1.2.1.pack.js"></script>

        <link rel="shortcut icon" href="../Utilidades/Imagens/bancodeoportunidades/logo_aba.png"/>
        <title>Banco de Oportunidades</title>
    </head>
    <body onload="Rolar()">
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
                <div id="logo2">
                    <img id="cabecalho-logo" alt="Banco de Oportunidades" src="../Utilidades/Imagens/bancodeoportunidades/<?php echo $usuario_SD->imagem; ?>" width="266" height="77" style="margin-top: -25px; margin-left: -50px;">
                </div>
                <div id="logo">
                    <img id="cabecalho-logo" alt="Brasão da Prefeitura" src="../Utilidades/Imagens/bancodeoportunidades/<?php echo $usuario_SE->imagem; ?>" width="210"  height="110">
                </div>
            </div>

            <div id="conteudo">
                <div id="tudo">
                    <div id="content">
                        <div id="areaLogin">
                            <input type="button" class="botao" value="Cadastre seu currículo" onclick="window.location = ('./publico/visao/GuiCadCandidato.php');" />
                            <input type="button" id="contato" class="botao" value="Fale Conosco" onclick="window.location = ('./publico/visao/GuiContato.php');" />
                            <fieldset>
                                <legend class="legend">Login de Candidatos</legend>
                                <form name="loginCandidato" id="loginCandidato" method="post" action="./publico/controle/ControleCandidato.php?op=logar" >
                                    <table>
                                        <tr>
                                            <td width="10%">Login:</td>
                                            <td width="50%">
                                                <input name="login" id="login" class="campo largura_login" type="text" maxlength="45" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Senha:</td>
                                            <td colspan="2"><input name="senha" id="senha" class="campo largura_login" type="password" maxlength="10"/></td>
                                        </tr>
                                        <tr>
                                            <td align="right" colspan="2">
                                                <span class="style1">
                                                    <?php
                                                    if(isset($_SESSION['msg'])){
                                                        $msg = ControleSessao::buscarVariavel('msg');
                                                        echo $msg;
                                                    }
                                                    ?>
                                                </span>
                                                <input type="submit" class="botao" value="Entrar"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right" colspan="2">
                                                <a href="./publico/visao/GuiLembrarSenhaCandidato.php" class="link_novo" title="Clique aqui para receber uma nova senha.">Esqueceu a senha?</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right" colspan="2">
                                                <a href="./publico/visao/GuiAlterarSenhaCandidato.php" class="link_novo" title="Clique para mudar sua senha.">Alterar Senha</a>
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </fieldset>
                            <input type="button" class="botao" value="Cadastre sua empresa" onclick="window.location = ('./publico/visao/GuiCadEmpresa.php');" />
                            <fieldset>
                                <legend class="legend">Login de Empresas</legend>
                                <form name="loginEmpresa" id="loginEmpresa" method="post" action="./publico/controle/ControleEmpresa.php?op=logar">
                                    <table>
                                        <tr>
                                            <td>Login:</td>
                                            <td><input name="login" id="login" class="campo largura_login" type="text" maxlength="40" /></td>
                                        </tr>
                                        <tr>
                                            <td>Senha:</td>
                                            <td><input name="senha" id="senha" class="campo largura_login" type="password" maxlength="12"/></td>
                                        </tr>
                                        <tr>
                                            <td align="right" colspan="2">
                                                <span class="style1">
                                                    <?php
                                                    if(isset($_SESSION['msgEmpresa'])){
                                                        $msg = ControleSessao::buscarVariavel('msgEmpresa');
                                                        echo $msg;
                                                    }
                                                    ?>
                                                </span>
                                                <input type="submit" class="botao" value="Entrar"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right" colspan="2">
                                                <a href="./publico/visao/GuiLembrarSenhaEmpresa.php" class="link_novo" title="Clique aqui para receber uma nova senha.">Esqueceu a senha?</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right" colspan="2">
                                                <a href="./publico/visao/GuiAlterarSenhaEmpresa.php" class="link_novo" title="Clique para mudar sua senha.">Alterar Senha</a>
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </fieldset>
                        </div>

                        <div style="width: 65.7%;">
                            <div class="div-icones-index">
                                <img src="../Utilidades/Imagens/bancodeoportunidades/empresas.png" width="50px" align="center" title="Empresas Cadastradas"/>
                                <?php

                                    $sql = mysql_query("select e.id_empresa from empresa e where e.ao_liberacao = 'S'");

                                    $total_empresas = mysql_num_rows($sql);

                                    $invertoONumeroDeEmpresas = strrev($total_empresas);
                                    $aCadaTresCaracteresAdicionaPontoNaStringDeEmpresas = chunk_split($invertoONumeroDeEmpresas, 3, ".");
                                    $invertoONumeroDeEmpresasNovamente = strrev($aCadaTresCaracteresAdicionaPontoNaStringDeEmpresas);
                                    $pegoOPrimeiroCaracterDaStringDeEmpresas = substr($invertoONumeroDeEmpresasNovamente, 0, 1);

                                    if($pegoOPrimeiroCaracterDaStringDeEmpresas == "."){
                                        $totalEmpresas = substr($invertoONumeroDeEmpresasNovamente, 1);
                                    }else{
                                        $totalEmpresas = $invertoONumeroDeEmpresasNovamente;
                                    }

                                    if($totalEmpresas <= 1){
                                        echo "<div class='div-numero-index'>".$totalEmpresas."</div> Empresa";
                                    }
                                    else{
                                        echo "<div class='div-numero-index'>".$totalEmpresas."</div> Empresas";
                                    }
                                ?>
                            </div>
                            <div class="div-icones-index">
                                <img src="../Utilidades/Imagens/bancodeoportunidades/curriculos.png" width="50px" title="Currículos Cadastrados"/>
                                <?php
                                    $sql = mysql_query("SELECT id_candidato FROM candidato");

                                    $total_candidatos = mysql_num_rows($sql);

                                    $invertoONumeroDeCandidatos = strrev($total_candidatos);
                                    $aCadaTresCaracteresAdicionaPonto = chunk_split($invertoONumeroDeCandidatos, 3, ".");
                                    $invertoONumeroDeCandidatosNovamente = strrev($aCadaTresCaracteresAdicionaPonto);
                                    $pegoOPrimeiroCaracterDaString = substr($invertoONumeroDeCandidatosNovamente, 0, 1);

                                    if($pegoOPrimeiroCaracterDaString == "."){
                                        $candidatos = substr($invertoONumeroDeCandidatosNovamente, 1);
                                    }else{
                                        $candidatos = $invertoONumeroDeCandidatosNovamente;
                                    }

                                    echo "<div class='div-numero-index'>".$candidatos. "</div> Currículos";
                                ?>
                            </div>
                            <div class="div-icones-index">
                                <img src="../Utilidades/Imagens/bancodeoportunidades/vagas.png" width="50px" title="Total Vagas Cadastradas" />
                                <?php
                                    $sqlVagas = "select SUM(v.qt_vaga) from vaga v, profissao p where v.id_profissao = p.id_profissao and v.ao_ativo = 'S' and p.ao_ativo = 'S'";
                                    $queryVagas = mysql_query($sqlVagas);
                                    $totalVagas = mysql_fetch_row($queryVagas);

                                    $invertoONumeroDeVagas = strrev($totalVagas[0]);
                                    $aCadaTresCaracteresAdicionaPontoNaStringDeVagas = chunk_split($invertoONumeroDeVagas, 3, ".");
                                    $invertoONumeroDeVagasNovamente = strrev($aCadaTresCaracteresAdicionaPontoNaStringDeVagas);
                                    $pegoOPrimeiroCaracterDaStringDeVagas = substr($invertoONumeroDeVagasNovamente, 0, 1);

                                    if($pegoOPrimeiroCaracterDaStringDeVagas == "."){
                                        $totalVagas[0] = substr($invertoONumeroDeVagasNovamente, 1);
                                    }else{
                                        $totalVagas[0] = $invertoONumeroDeVagasNovamente;
                                    }


                                    if($totalVagas[0] > 1){
                                        echo "<div class='div-numero-index'>".$totalVagas[0]. "</div> Vagas";
                                    }
                                    else{
                                        echo "<div class='div-numero-index'>".$totalVagas[0]. "</div> Vaga";
                                    }
                                 ?>

                            </div>
                            <div class="div-icones-index">
                                <img src="../Utilidades/Imagens/bancodeoportunidades/visualizacoes.png" width="50px" title="Visitas"/>
                                <?php
                                    echo "<div class='div-numero-index'>"; include "publico/util/visita.class.php"; echo "</div> Visualizações"; //Mostra na tela a quantidade de visitas armazenadas no banco
                                ?>
                            </div>
                        </div>

                        <script type="text/javascript">
                            i = 0;
                            tempo = 50;
                            tamanho = <?php echo $totalVagas[0] * 10; ?>;

                            function Rolar() {
                              document.getElementById('painel').scrollTop = i;
                              i++;
                              t = setTimeout("Rolar()", tempo);
                              if (i == tamanho) {
                                i = 0;
                              }
                            }
                            function Parar() {
                              clearTimeout(t);
                            }
                        </script>

                        <div class="vagas-index">
                            <a href="publico/visao/GuiTodasVagas.php" title="Clique aqui para visualizar todas vagas cadastradas pelas empresas no Banco de Oportunidades de Canoas">
                                <div class='mais-vagas-img'><img src="../Utilidades/Imagens/bancodeoportunidades/mais-vagas-a.png" width="30px" title="Clique aqui para visualizar todas vagas cadastradas pelas empresas no Banco de Oportunidades de Canoas"/></div>
                                <div class="label-vagas-destaque" title="Clique aqui para visualizar todas vagas cadastradas pelas empresas no Banco de Oportunidades de Canoas">Oportunidades</div>
                            </a>
                            <div class="vagas">
                                    <div id="painel" class="top-vagas" onmouseover="Parar()" onmouseout="Rolar()">

                                        <br /><br /><br /><br />Veja abaixo a lista de vagas<br /><br /><br /><br /><br /><br /><br /><br /><br />

                                        <?php
                                            $sql = "select p.nm_profissao, sum(v.qt_vaga) as totalVagas
                                                                from vaga v, profissao p
                                                                where v.id_profissao = p.id_profissao
                                                                and v.ao_ativo = 'S'
                                                                and p.ao_ativo = 'S'
                                                                and v.qt_vaga is not null
                                                                and v.qt_vaga > 0
                                                                group by p.id_profissao
                                                                order by totalVagas desc";

                                            $query = mysql_query($sql);
                                            while($a = mysql_fetch_object($query)) {
                                                echo "<div class='painel-vaga'>";
                                                echo $a->nm_profissao."&nbsp;&nbsp;(".$a->totalVagas.")<br>";
                                                echo "</div>";
                                            }
                                            //Mostra o valor
                                            //echo $vaga;
                                            $sqlVagas = "select SUM(v.qt_vaga) from vaga v, profissao p where v.id_profissao = p.id_profissao and v.ao_ativo = 'S' and p.ao_ativo = 'S'";
                                            $queryVagas = mysql_query($sqlVagas);
                                            $totalVagas = mysql_fetch_row($queryVagas);
                                        ?>
                                        <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
                                    </div>
                                    <div class="ultima-vaga">
                                        <strong>Última cadastrada:</strong>
                                        <?php
                                            $sqlUltimaVaga = "SELECT
                                                            p.nm_profissao, v.dt_cadastro
                                                    FROM
                                                            vaga v
                                                    INNER JOIN
                                                            profissao p ON (v.id_profissao = p.id_profissao)
                                                    ORDER BY v.dt_cadastro DESC
                                                    LIMIT 1";

                                            $ultimaVaga = mysql_fetch_object(mysql_query($sqlUltimaVaga));

                                            echo $ultimaVaga->nm_profissao;
                                        ?>
                                    </div>
                            </div>
                        </div>
                        <br>
                        <div class="ver-mais">
                            <a href="publico/visao/GuiTodasVagas.php" title="Clique aqui para visualizar todas vagas cadastradas pelas empresas no Banco de Oportunidades de Canoas">
                                <label onmouseover="trocaImagemVerMais('ver-mais-b.png');" onmouseout="trocaImagemVerMais('ver-mais-a.png');" style="cursor: pointer;">Ver mais</label>
                                <img src="../Utilidades/Imagens/bancodeoportunidades/ver-mais-a.png" id="imagem_ver_mais" width="30px" onmouseover="trocaImagemVerMais('ver-mais-b.png');" onmouseout="trocaImagemVerMais('ver-mais-a.png');" />
                            </a>
                        </div>

                        <?php
                        $sql = "SELECT id_texto, ds_titulo, ds_texto "
                                . "FROM texto "
                                . "WHERE ao_ativo = 'S' ";

                        $query = mysql_query($sql);

                        while($row = mysql_fetch_object($query)) { ?>
                            <h2 class="subtitulo_index"><?php echo $row->ds_titulo; ?></h2>
                            <hr class="linha_subtitulo" style="margin-top: -32px;">
                            <p class="texto-justificado">
                                <?php echo $row->ds_texto; ?>
                            </p>
                        <?php } ?>
                        <p class="texto-justificado" >
                            <a href="./manuais/ListaManuais.php" class="link_manual">Manual de Uso</a>
                        </p>
                        <p class="texto-justificado" >
                            <a href="publico/visao/GuiFaq.php" class="link_manual">Perguntas Frequentes</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div id="footer">
            <div id="rodape">
                <!--<span id="assinatura">Banco de Oportunidades &copy; 2014</span>-->
                <img src="../Utilidades/Imagens/bancodeoportunidades/<?php echo $usuario_ID->imagem; ?>" height="40px">
                <img src="../Utilidades/Imagens/bancodeoportunidades/<?php echo $usuario_IE->imagem; ?>" height="40px" style="margin-top: 13px;float:left; margin-right: 638px;">
                <?php
                    // lê todo o conteúdo do arquivo
                    // atribui à variável $arquivo
                    $arquivo = file_get_contents('version.txt');
                    // imprime o conteúdo do arquivo
                    // no navegador
                    echo "<div style='border: solid 1px #E4E2CD; margin-top: 60px; width: 950px; margin-left: 10px;'></div>";
                    echo "<div class='versao_rodape'>Versão: ".$arquivo."</div>";
                ?>
            </div>
        </div>
    </body>
</html>
<?php
ControleSessao::destruirVariavel('msg');
ControleSessao::destruirVariavel('msgEmpresa');
?>
