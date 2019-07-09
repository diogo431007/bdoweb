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
                <fieldset style="height: 180px;">
                    <legend class="legend">Lembrar Senha de Candidatos</legend>

                    <form name="trocaSenha" method="post" action="../controle/ControleCandidato.php?op=lembrarSenha">
                        <table border="0">
                            <tr>
                                <td>CPF:</td>
                                <td>
                                    <input name="nr_cpf" id="nr_cpf" value="<?php if (isset($_SESSION['errosL'])) { echo $_SESSION['post']['nr_cpf']; } ?>" onblur="validarCPF(this.value);" onkeypress='return valCPF(event, this);' type="text" maxlength="11" <?php echo (isset($_SESSION['errosL']) && in_array('nr_cpf', $_SESSION['errosL'])) ? 'class="campo_erro largura_login"' : 'class="campo largura_login"'; ?> />
                                </td>
                            </tr>
                            <tr>
                                <td>Email:</td>
                                <td>
                                    <input name="ds_email"  id="ds_email" value="<?php if (isset($_SESSION['errosL'])) { echo $_SESSION['post']['ds_email']; } ?>" type="text" maxlength="50" <?php echo (isset($_SESSION['errosL']) && in_array('ds_email', $_SESSION['errosL'])) ? 'class="campo_erro largura_login"' : 'class="campo largura_login"'; ?> />
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2" align="right">
                                    <input type="submit" class="botao" value="Enviar"/>
                                    <br />
                                    <?php
                                    if (isset($_SESSION['errosL']) && (in_array('nr_cpf', $_SESSION['errosL']) || in_array('ds_email', $_SESSION['errosL']))) {
                                    ?>
                                        <span class="style1">* Preencha corretamente este campo</span>
                                    <?php
                                    }else if (isset($_SESSION['msg'])) {
                                        $msg = ControleSessao::buscarVariavel('msg');
                                    ?>
                                        <div style="font-size: 11.5px; color: #FF0000 ; padding: 3px; width: 100%;"><?php echo '* '.$msg; ?></div>
                                    <?php
                                    }
                                    ?>
                                    
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

