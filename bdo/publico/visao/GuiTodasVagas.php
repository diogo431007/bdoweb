<?php
header ('Content-type: text/html; charset=ISO-8859-1');
// FERRAMENTA EM MANUTEN??O
//
//if($_GET['teste']!=1){
//header("Location:atualizacao.php");
//}
//Conex?o com o Banco de Dados
include("../../interno/conecta.php");
include_once '../util/ControleSessao.class.php';
include_once '../util/Servicos.class.php';
ControleSessao::abrirSessao();
?>
<html>
    <head>
        <script type="text/javascript" src="../js/jquery-1.2.1.pack.js"></script>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
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
        <link rel="shortcut icon" href="../../../Utilidades/Imagens/bancodeoportunidades/logo_aba.png" type="image/x-icon"/>
        <title>Banco de Oportunidades</title>
    </head>
    <body>
        <div id="corpo">
            <div id="header">
                <div id="logo2">
                    <img id="cabecalho-logo" alt="Banco de Oportunidades" src="../../../Utilidades/Imagens/bancodeoportunidades/logo_banco.png" height="70%" style="margin-top: -25px; margin-left: -50px;">
                </div>
                <div id="logo">
                    <img id="cabecalho-logo" alt="Bras?o da Prefeitura" src="../../../Utilidades/Imagens/bancodeoportunidades/brasao_prefeitura.png">
                </div>
            </div>
            <div id="menu">
                <ul>
                    <li><a href="../../index.php" title="Clique aqui para voltar ? p?gina principal do Banco de Oportunidades de Canoas">Banco de Oportunidades</a></li>
                </ul>
            </div>
            <div id="conteudo">
                <!--<img id="cabecalho-logo" alt="Bras?o da Prefeitura" src="./publico/imagens/Orange wave.png" />-->
                <div id="tudo">
                    <div id="content">
                        <h2 class="subtitulo_TodasVagas">Vagas oferecidas</h2>
                        <?php
                        //Seleciona toda a tabela
                         $sql = "select p.nm_profissao, sum(v.qt_vaga) as totalVagas , v.ds_atribuicao
                                             from vaga v, profissao p
                                             where v.id_profissao = p.id_profissao
                                             and v.ao_ativo = 'S'
                                             and p.ao_ativo = 'S'
                                             and v.qt_vaga is not null
                                             and v.qt_vaga > 0
                                             group by p.id_profissao,v.ds_atribuicao
                                             order by totalVagas desc";
                         //die($sql);
                         $query = mysql_query($sql);

                             //echo $a->nm_profissao."&nbsp;&nbsp;(".$a->totalVagas.")<br>";

                         //Mostra o valor
                         //echo $vaga;
                         //echo $total_vagas;
                        ?>
                        <!-- TODAS AS VAGAS -->


                        <div class="tab_adiciona" style="margin-left: 240px;">
                            <table width="100%">
                                <tr class="table_formacao_cab">
                                    <td align='left'>&nbsp;&nbsp;Vaga</td>
                                    <td align='center' width="15%">Quantidade</td>
                                </tr>
                                <?php while($a = mysql_fetch_object($query)) { ?>
                                <tr class="table_formacao_row linhaTodasVagas">
                                        <td align="left" style="border-left: solid 2px #EE7228;">&nbsp;&nbsp;<?php echo $a->nm_profissao; ?></td>
                                        <td align="center"><?php echo $a->totalVagas; ?></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td colspan="8" align="center">
                                        <span id="paginacao">
                                        <?php
                                        //crio a paginacao propriamente dita
                                        //echo Servicos::criarPaginacao(ControleSessao::buscarObjeto('privateEmp')->empresa_detalhes, $qtd, $page,'#parte-02');
                                        ?>
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    </div>
                </div>
            </div>
        </div>
        <div id="footer">
             <div id="rodape">
                 <!--<span id="assinatura">Banco de Oportunidades &copy; 2014</span>-->
                <img src="../../../Utilidades/Imagens/bancodeoportunidades/logo_prefeitura.png" height="40px">
                <img src="../../../Utilidades/Imagens/bancodeoportunidades/logo_canoastec.png" height="40px" style=" margin-top: 13px;float:left; margin-right: 638px;">
                <?php
                    // l? todo o conte?do do arquivo
                    // atribui ? vari?vel $arquivo
                    $arquivo = file_get_contents('../../version.txt');
                    // imprime o conte?do do arquivo
                    // no navegador
                    echo "<div style='border: solid 1px #E4E2CD; margin-top: 60px; width: 950px; margin-left: 10px;'></div>";
                    echo "<div class='versao_rodape'>Versão: ".$arquivo."</div>";
                ?>
             </div>
         </div>
    </body>
</html>
