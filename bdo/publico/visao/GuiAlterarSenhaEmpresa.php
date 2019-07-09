<?php
include_once '../util/ControleSessao.class.php';
ControleSessao::abrirSessao();

include_once './header_index.php';
?>
<div id="conteudo">
    <!--<img id="cabecalho-logo" alt="Brasão da Prefeitura" src="../imagens/Orange wave.png" />-->
    <!--<div class="subtitulo"></div>-->
    <div id="tudo">

        <div id="content">

            <div id="areaAlterar">
                <input type="button" class="botao" value="Cadastre seu currículo" onclick="window.location = ('../visao/GuiCadCandidato.php');" style="margin-left: -31px;" />
                <input type="button" class="botao" value="Fale Conosco" onclick="window.location = ('../visao/GuiContato.php');" style="margin-left: 12px;" />
                <input type="button" id="contato" class="botao" value="Voltar" onclick="window.location = ('../../index.php');" />
                <fieldset>
                    <legend class="legend">Alterar Senha de Empresas</legend>
                    <form name="trocaSenha" method="post" action="../controle/ControleEmpresa.php?op=alterarSenha">
                        <table>
                            <tr>
                                <td>Login:</td>
                                <td>
                                    <input name="login" type="text" maxlength="40" <?php echo (isset($_SESSION['erros']) && in_array('login', $_SESSION['erros'])) ? 'class="campo_erro largura_login"' : 'class="campo largura_login"'; ?> />
                                </td>
                            </tr>
                            <tr>
                                <td>Senha Atual:</td>
                                <td>
                                    <input name="senha" type="password" maxlength="12" <?php echo (isset($_SESSION['erros']) && in_array('senha', $_SESSION['erros'])) ? 'class="campo_erro largura_login"' : 'class="campo largura_login"'; ?> />
                                </td>
                            </tr>
                            <tr>
                                <td>Nova senha:</td>
                                <td>
                                    <input name="nova_senha" type="password" maxlength="12" <?php echo (isset($_SESSION['erros']) && in_array('nova_senha', $_SESSION['erros'])) ? 'class="campo_erro largura_login"' : 'class="campo largura_login"'; ?> />
                                </td>
                            </tr>
                            <tr>
                                <td>Confirma senha:</td>
                                <td>
                                    <input name="confirma_senha" type="password" maxlength="12" <?php echo (isset($_SESSION['erros']) && in_array('confirma_senha', $_SESSION['erros'])) ? 'class="campo_erro largura_login"' : 'class="campo largura_login"'; ?> />
                                </td>
                            </tr>
                            <tr>
                                <td align="right" colspan="2">
                                    <?php
                                    if (isset($_SESSION['erros']) && (in_array('login', $_SESSION['erros']) ||
                                                                        in_array('senha', $_SESSION['erros']) ||
                                                                        in_array('nova_senha', $_SESSION['erros']) ||
                                                                        in_array('confirma_senha', $_SESSION['erros']))) {
                                    ?>
                                        <span class="style1">* Preencha corretamente os campos</span>
                                    <?php
                                    }else if (isset($_SESSION['msg'])) {
                                        $msg = ControleSessao::buscarVariavel('msg');
                                    ?>
                                        <span class="style1"><?php echo '* '.$msg; ?></span>
                                    <?php
                                    } else if (isset($_SESSION['erros']) && in_array('senhas_diferentes', $_SESSION['erros'])) {
                                    ?>
                                        <span class="style1">* Senhas não coincidiram</span>
                                    <?php
                                    }
                                    ?>
                                    <input type="submit" class="botao" value="Alterar"/>
                                </td>
                            </tr>
                        </table>
                    </form>
                </fieldset>
            </div>
            <br/>
            <h2 class="subtitulo_index">Cidadão</h2>
            <p class="texto-justificado">
                A Prefeitura Municipal de Canoas, através da Secretaria Municipal de Desenvolvimento Econômico e da Diretoria de Emprego, Trabalho, Renda e Formação Profissional apresenta, o Banco de oportunidades.<br> Mais uma ferramenta de gestão disponibilizada aos canoenses, com o objetivo de expandir as oportunidades na busca de uma colocação profissional no mercado de trabalho de nosso município.
            </p>
            <h2 class="subtitulo_index">Empresa</h2>
            <p class="texto-justificado">
            A Prefeitura Municipal de Canoas através do Banco de oportunidades, disponibiliza às empresas o acesso a esta ferramenta de gestão estratégica de pessoas na busca de encontrar profissionais qualificados nas mais diversas áreas de trabalho.
            </p>
            <h2 class="subtitulo_index">Observações</h2>
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
ControleSessao::destruirVariavel('erros');
?>
