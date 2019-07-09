<?php
include_once '../util/ControleSessao.class.php';
ControleSessao::abrirSessao();

include_once './header_index.php';
?>
<div id="conteudo">
    <!--<img id="cabecalho-logo" alt="Bras�o da Prefeitura" src="../imagens/Orange wave.png" />-->
    <!--<div class="subtitulo"></div>-->
    <div id="tudo">

        <div id="content">

            <div id="areaAlterar">
                <input type="button" class="botao" value="Cadastre seu curr�culo" onclick="window.location = ('../visao/GuiCadCandidato.php');" style="margin-left: -31px;" />
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
                                        <span class="style1">* Senhas n�o coincidiram</span>
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
            <h2 class="subtitulo_index">Cidad�o</h2>
            <p class="texto-justificado">
                A Prefeitura Municipal de Canoas, atrav�s da Secretaria Municipal de Desenvolvimento Econ�mico e da Diretoria de Emprego, Trabalho, Renda e Forma��o Profissional apresenta, o Banco de oportunidades.<br> Mais uma ferramenta de gest�o disponibilizada aos canoenses, com o objetivo de expandir as oportunidades na busca de uma coloca��o profissional no mercado de trabalho de nosso munic�pio.
            </p>
            <h2 class="subtitulo_index">Empresa</h2>
            <p class="texto-justificado">
            A Prefeitura Municipal de Canoas atrav�s do Banco de oportunidades, disponibiliza �s empresas o acesso a esta ferramenta de gest�o estrat�gica de pessoas na busca de encontrar profissionais qualificados nas mais diversas �reas de trabalho.
            </p>
            <h2 class="subtitulo_index">Observa��es</h2>
            <p class="texto-justificado">
                � de extrema import�ncia manter seus dados cadastrais atualizados no banco de oportunidades, para podermos aprimorar e desenvolver esta ferramenta de gest�o.<br> Principalmente na empregabilidade. Quanto mais completo e atualizado seu curr�culo mais chances voc� ter�.
                <br><br><br>
                * A Prefeitura Municipal de Canoas n�o se responsabiliza pelos dados cadastrais fornecidos pelos candidatos e pelas empresas. 
            </p>
        </div>

    </div>
</div>
<?php
include_once './footer.php';
ControleSessao::destruirVariavel('msg');
ControleSessao::destruirVariavel('erros');
?>
