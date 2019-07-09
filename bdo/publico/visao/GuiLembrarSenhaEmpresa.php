<?php
include_once '../util/ControleSessao.class.php';
ControleSessao::abrirSessao();

include_once './header_index.php';
?>
<div id="conteudo">
    <!--<img id="cabecalho-logo" alt="Brasão da Prefeitura" src="../imagens/Orange wave.png" />-->
    <!--<div class="subtitulo">Banco de Oportunidades</div>-->
    <div id="tudo">

        <div id="content">

            <div id="areaLembrar">
                <input type="button" class="botao" value="Cadastre seu currículo" onclick="window.location = ('../visao/GuiCadCandidato.php');" style="margin-left: -31px;" />
                <input type="button" class="botao" value="Fale Conosco" onclick="window.location = ('../visao/GuiContato.php');" style="margin-left: 12px;" />
                <input type="button" id="contato" class="botao" value="Voltar" onclick="window.location = ('../../index.php');" />
                <fieldset>
                    <legend class="legend">Lembrar Senha de Empresas</legend>
                    <form name="trocaSenha" method="post" action="../controle/ControleEmpresa.php?op=lembrarSenha">
                        <table>
                            <tr>
                                <td>CNPJ:</td>
                                <td>
                                    <input type="text" name="nr_cnpj" value="<?php if (isset($_SESSION['errosL'])) echo $_SESSION['post']['nr_cnpj']; ?>" id="nr_cnpj" maxlength='18' onblur="ValidarCNPJ(this.value);" onkeypress=" return BloqueiaLetras(this.value);" <?php echo (isset($_SESSION['errosL']) && in_array('nr_cnpj', $_SESSION['errosL'])) ? 'class="campo_erro largura_login"' : 'class="campo largura_login"'; ?> />
                                </td>
                            </tr>
                            <tr>
                                <td>Login:</td>
                                <td>
                                    <input name="login" id="login" value="<?php if (isset($_SESSION['errosL'])) { echo $_SESSION['post']['login']; } ?>" type="text" maxlength="60" <?php echo (isset($_SESSION['errosL']) && in_array('login', $_SESSION['errosL'])) ? 'class="campo_erro largura_login"' : 'class="campo largura_login"'; ?> />
                                </td>
                            </tr>
                            <tr>
                                <td align="right" colspan="2">
                                    <?php
                                    if (isset($_SESSION['errosL']) && (in_array('nr_cnpj', $_SESSION['errosL']) || 
                                                                        in_array('login', $_SESSION['errosL']))) {
                                    ?>
                                        <span class="style1">* Preencha corretamente este campo</span>
                                    <?php
                                    }else if (isset($_SESSION['msg'])) {
                                        $msg = ControleSessao::buscarVariavel('msg');
                                    ?>
                                        <span class="style1"><?php echo '* '.$msg; ?></span>
                                    <?php
                                    }
                                    ?>
                                    <input type="submit" class="botao" value="Enviar"/>
                                </td>
                            </tr>
                        </table>
                    </form>
                </fieldset>
            </div>
            <br/>
            <h2 class="subtitulo_index">Cidadão</h2>
            <hr class="linha_subtitulo" style="margin-top: -30px;">
            <p class="texto-justificado">
                A Prefeitura Municipal de Canoas, através da Secretaria Municipal de Desenvolvimento Econômico e da Diretoria de Emprego, Trabalho, Renda e Formação Profissional apresenta, o Banco de oportunidades.<br> Mais uma ferramenta de gestão disponibilizada aos canoenses, com o objetivo de expandir as oportunidades na busca de uma colocação profissional no mercado de trabalho de nosso município.
            </p>
            <h2 class="subtitulo_index">Empresa</h2>
            <hr class="linha_subtitulo" style="margin-top: -30px;">
            <p class="texto-justificado">
            A Prefeitura Municipal de Canoas através do Banco de oportunidades, disponibiliza às empresas o acesso a esta ferramenta de gestão estratégica de pessoas na busca de encontrar profissionais qualificados nas mais diversas áreas de trabalho.
            </p>
            <h2 class="subtitulo_index">Observações</h2>
            <hr class="linha_subtitulo" style="margin-top: -30px;">
            <p class="texto-justificado">
                É de extrema importância manter seus dados cadastrais atualizados no banco de oportunidades, para podermos aprimorar e desenvolver esta ferramenta de gestão.<br> Principalmente na empregabilidade. Quanto mais completo e atualizado seu currículo mais chances você terá.
                <br><br><br>
                * A Prefeitura Municipal de Canoas não se responsabiliza pelos dados cadastrais fornecidos pelos candidatos e pelas empresas. 
            </p>
        </div>

    </div>
</div>
<?php
include_once './footer.php';
ControleSessao::destruirVariavel('msg');
ControleSessao::destruirVariavel('errosL');
ControleSessao::destruirVariavel('post');
?>

