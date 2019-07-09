<?php
header('location:./GuiVagas.php');
/* --- Não é mais utilizado! ---
include_once '../util/ControleSessao.class.php';
include_once '../util/ControleLoginEmpresa.class.php';
ControleSessao::abrirSessao();

//verifico se ha candidato na sessao e se foi liberado pela moderacao
if((!ControleLoginEmpresa::verificarAcesso())||(ControleSessao::buscarObjeto('privateEmp')->ao_liberacao == 'N')){
    //se nao tiver candidato na sessao
    ControleLoginEmpresa::deslogar();
}

include_once './header.php';
include_once '../util/Servicos.class.php';
?>
<div id="conteudo">
    <!--<img id="cabecalho-logo" alt="Brasão da Prefeitura" src="../imagens/Orange wave.png">-->
    <div class="subtitulo">Banco de Oportunidades</div>
    <div id="tudo">
<!--    <div id="principal">
        <ul>
            <li>
                <a href="#parte-00"><span>Sinalizar Admissão</span></a>
            </li>
        </ul>-->
        <div id="parte-00">
            
            <?php
            if(is_null(ControleSessao::buscarVariavel('admitido')) && !(isset($_SESSION['errosA']))){
            ?>
            
            <div class="relatorio_filtro">
                <form name="carregarAdmitido" method="post" action="../controle/ControleCandidato.php?op=carregarAdmissao">
                    <fieldset>
                        <legend class="legend">Buscar</legend>

                        <table class="tabela_relatorio">

                            <tr>
                                <td width="12%">
                                    <label class="filtro_label">CPF do Admitido:</label>
                                </td>
                                <td>
                                    <input name="nr_cpf" id="nr_cpf" value="<?php if(isset($_SESSION['erros'])){ echo $_SESSION['post']['nr_cpf'];} ?>" onblur="validarCPF(this.value);" onkeypress='return valCPF(event,this);' <?php echo (isset($_SESSION['erros']) && (in_array('nr_cpf',$_SESSION['erros'])||in_array('msg',$_SESSION['erros']))) ? 'class="campo_erro"' : 'class="campo"'; ?> type="text" size="15" maxlength="14" />
                                    <?php 
                                    if(isset($_SESSION['erros']) && in_array('nr_cpf',$_SESSION['erros'])){ 
                                    ?>
                                        <span class="style1">* Preencha corretamente este campo</span>
                                    <?php
                                    }else if(isset($_SESSION['erros']) && in_array('msg',$_SESSION['erros'])){ 
                                    ?>
                                        <span class="style1">* CPF incorreto!</span>
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="submit" value="Buscar" class="botao"/>
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                </form>
            </div>
            
            <?php
            }else{
                include_once '../modelo/CandidatoVO.class.php';
                $a = ControleSessao::buscarObjeto('admitido');
            ?>
            
            <div class="tabela_relatorio">
                <fieldset>
                    <legend class="legend">Admissão</legend>
                    <form name="cadastrarAdmitido" method="post" action="../controle/ControleEmpresa.php?op=cadastrarAdmissao">
                        <input type="hidden" readonly name="admitido" value="<?php if(isset($_SESSION['errosA'])){ echo $_SESSION['post']['admitido'];}elseif(isset($a)){echo $a->id_candidato;} ?>" />
                        <table class="tabela">
                            <tr>
                                <td width="10px"><span class="style1">*</span></td>
                                <td  width="150px">
                                    <label>Admitido:</label>
                                </td>
                                <td>
                                    <input readonly value="<?php 
                                    if(isset($_SESSION['errosA'])){echo $_SESSION['post']['nm_candidato'];}elseif(isset($a)){echo $a->nm_candidato;}?>" type="text" name="nm_candidato" id="nm_candidato" size="50" maxlength="50" <?php echo (isset($_SESSION['errosA']) && in_array('nm_candidato',$_SESSION['errosA'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                    <?php 
                                    if(isset($_SESSION['errosA']) && in_array('nm_candidato',$_SESSION['errosA'])){ 
                                    ?>
                                        <span class="style1">* Preencha corretamente este campo</span>
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <td><span class="style1">*</span></td>
                                <td>
                                    <label>CPF:</label>
                                </td>
                                <td>
                                    <input readonly name="nr_cpf" id="nr_cpf" value="<?php if(isset($_SESSION['errosA'])){ echo $_SESSION['post']['nr_cpf'];}elseif(isset($a)){echo $a->nr_cpf;} ?>" onblur="validarCPF(this.value);" onkeypress='return valCPF(event,this);' <?php echo (isset($_SESSION['errosA']) && in_array('nr_cpf',$_SESSION['errosA'])) ? 'class="campo_erro"' : 'class="campo"'; ?> type="text" size="15" maxlength="14" />
                                    <?php 
                                    if(isset($_SESSION['errosA']) && in_array('nr_cpf',$_SESSION['errosA'])){ 
                                    ?>
                                        <span class="style1">* Preencha corretamente este campo</span>
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <td width="10px"><span class="style1">*</span></td>
                                <td  width="150px">
                                    <label>Cargo:</label>
                                </td>
                                <td>
                                    <input value="<?php 
                                    if(isset($_SESSION['errosA'])){echo $_SESSION['post']['ds_cargo'];}?>" type="text" name="ds_cargo" id="ds_cargo" size="50" maxlength="50" <?php echo (isset($_SESSION['errosA']) && in_array('ds_cargo',$_SESSION['errosA'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                    <?php 
                                    if(isset($_SESSION['errosA']) && in_array('ds_cargo',$_SESSION['errosA'])){ 
                                    ?>
                                        <span class="style1">* Preencha corretamente este campo</span>
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <td><span class="style1">*</span></td>
                                <td>
                                    <label>Data Admissão:</label>
                                </td>
                                <td>
                                    <input value="<?php if(isset($_SESSION['errosA'])){echo $_SESSION['post']['dt_admissao'];}?>" type="text" name="dt_admissao" id="nascimento" onblur="validaDataEmpresa(this.value, 'nascimento');" size="11" maxlength="10" <?php echo (isset($_SESSION['errosA']) && in_array('dt_admissao',$_SESSION['errosA'])) ? 'class="campo_erro data"' : 'class="campo data"'; ?> /> 
                                    <?php 
                                    if(isset($_SESSION['errosA']) && in_array('dt_admissao',$_SESSION['errosA'])){ 
                                    ?>
                                        <span class="style1">* Preencha corretamente este campo</span>
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td><span class="style1">Campos com * são obrigatórios!</span></td>
                            </tr>

                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>
                                    <input class="botao" type="submit" value="Cadastrar"/>
                                    &nbsp;&nbsp;&nbsp;
                                    <input class="botao" onclick="window.location.reload();" type="button" value="Cancelar"/>
                                    <?php 
                                    if(isset($_SESSION['errosA']) && in_array('msg',$_SESSION['errosA'])){ 
                                    ?>
                                        <span class="style1">* Ocorreu um erro! Tente mais tarde.</span>
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </form>
                </fieldset>
            </div>
            <?php
            }
            ?>
            
            <div class="tab_adiciona">
                <fieldset>
                    <legend class="legend">Lista de Admitidos</legend>
                    <?php
                    if(ControleLoginEmpresa::verificarAcesso() && ControleSessao::buscarObjeto('privateEmp')->empresa_admissoes){
                        include_once '../modelo/AdmissaoVO.class.php';
                    ?>
                    <div>
                        <table width="100%">
                            <tr class="table_formacao_cab">
                                <td align='center' width="35%">Admitido</td>
                                <td align='center' width="35%">Cargo</td>
                                <td align='center' width="15%">CPF</td>
                                <td align='center' width="15%">Data Admissão</td>
                            </tr>
                            <?php
                                //define a quantidade de resultados da lista
                                $qtd = 10;
                                //busca a page atual
                                $page = (isset($_GET['pg'])) ? $_GET['pg'] : 0;
                                //recebo um novo array com apenas os elemento necessarios para essa page atual
                                $admissoes = Servicos::listar(ControleSessao::buscarObjeto('privateEmp')->empresa_admissoes, $qtd, $page);

                                foreach($admissoes as $a){
                                    //testa se o elemento do array não é nulo
                                    if(!Validacao::validarNulo($a)){
                            ?>
                            <tr class="table_formacao_row">
                                <td><?php echo $a->nm_candidato; ?></td>
                                <td><?php echo $a->ds_cargo; ?></td>
                                <td align='center'><?php echo $a->nr_cpf; ?></td>
                                <td align='center'><?php echo $a->dt_admissao; ?></td>
                            </tr>
                            <?php
                                    }
                                }
                            ?>
                            <tr>
                                <td colspan="4" align="center">
                                    <span id="paginacao">
                                    <?php
                                    //crio a paginacao propriamente dita
                                    echo Servicos::criarPaginacao(ControleSessao::buscarObjeto('privateEmp')->empresa_admissoes, $qtd, $page);
                                    ?>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </fieldset>
                <?php
                if(count(ControleSessao::buscarObjeto('privateEmp')->empresa_admissoes)<8){
                ?>
                <div class="clear"></div>
                <?php
                }
                ?>
                <?php
                }else{
                ?>
                <div class="clear" align="center">
                    Não há admitidos cadastrados.
                </div>
                
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php
include_once './footer.php';
ControleSessao::destruirVariavel('msg');
ControleSessao::destruirVariavel('erros');
ControleSessao::destruirVariavel('errosA');
ControleSessao::destruirVariavel('post');
ControleSessao::destruirVariavel('admitido');
*/
?>