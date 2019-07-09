<?php
include_once '../util/ControleSessao.class.php';
ControleSessao::abrirSessao();
include_once './header.php';


?>
<div id="conteudo" style="height: 500px;" >
    <!--<img id="cabecalho-logo" alt="Brasão da Prefeitura" src="../imagens/Orange wave.png">-->
    <div class="subtitulo"></div>
    <div id="tudo">
        
        <div id="parte-01">
            <div class="style1">
                <?php if(isset($_SESSION['msg'])) echo ControleSessao::buscarVariavel('msg'); ?>
            </div>
            <form name="formContato" id="formContato" method="post" action="../controle/ControleContato.php?op=enviar">
                <fieldset>
                    <legend class="legend">Formulário de Contato</legend>

                    <table border="0" class="tabela_empresa" style="width: 100%;">
                        
                        <tr>
                            <td width="7px"><span class="style1">*</span></td>
                            <td width="75px">
                                <label>Nome:</label>
                            </td>
                            <td>
                                <input value="<?php if(isset($_SESSION['erros'])) echo $_SESSION['post']['nm_contato'];?>" type="text" name="nm_contato" id="nm_contato" size='50' maxlength='30' <?php echo (isset($_SESSION['erros']) && in_array('nm_contato',$_SESSION['erros'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                <?php 
                                if(isset($_SESSION['erros']) && in_array('nm_contato',$_SESSION['erros'])){ 
                                ?>
                                    <span class="style1">* Preencha corretamente este campo</span>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td> <span class="style1">*</span></td>
                            <td>
                                <label> E-mail: </label>
                            </td>
                            <td>
                                <input value="<?php if(isset($_SESSION['erros'])) echo $_SESSION['post']['ds_email'];?>" type="text" name="ds_email" id="ds_email" size="50" maxlength="50" <?php echo (isset($_SESSION['erros']) && in_array('ds_email',$_SESSION['erros'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                <?php 
                                if(isset($_SESSION['erros']) && in_array('ds_email',$_SESSION['erros'])){ 
                                ?>
                                    <span class="style1">* Preencha corretamente este campo</span>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>
                        
                        <tr>
                            <td><span class="style1"></span></td>
                            <td>
                                <label>Telefone:</label>
                            </td>
                            <td>
                                <input value="<?php if(isset($_SESSION['erros'])) echo $_SESSION['post']['nr_telefone'];?>" type="text" name="nr_telefone" id="nr_telefone" <?php echo (isset($_SESSION['erros']) && in_array('nr_telefone',$_SESSION['erros'])) ? 'class="campo_erro select"' : 'class="campo select"'; ?>/>
                                <?php 
                                if(isset($_SESSION['erros']) && in_array('nr_telefone',$_SESSION['erros'])){ 
                                ?>
                                    <span class="style1">* Preencha corretamente este campo</span>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <span class="style1">*</span>
                            </td>
                            <td>
                                <label>Assunto:</label>
                            </td>
                            <td>
                                <div style="float: left;">
                                <select onclick="mostraCpfContato();" id="formacaoContato" name="ds_assunto" <?php echo (isset($_SESSION['erros']) && in_array('ds_assunto',$_SESSION['erros'])) ? 'class="campo_erro select"' : 'class="campo select"'; ?>>
                                    <option value="">Selecione</option>
                                    <option value="Informação" <?php if(isset($_SESSION['erros'])&&($_SESSION['post']['ds_assunto'] == 'Informação')) echo 'selected'; ?>>Informações</option>
                                    <option value="Reclamação" <?php if(isset($_SESSION['erros'])&&($_SESSION['post']['ds_assunto'] == 'Reclamação')) echo 'selected'; ?>>Reclamações</option>
                                    <option value="Sugestão" <?php if(isset($_SESSION['erros'])&&($_SESSION['post']['ds_assunto'] == 'Sugestão')) echo 'selected'; ?>>Sugestões</option>
                                    <option value="Linha de Conduta" <?php if(isset($_SESSION['erros'])&&($_SESSION['post']['ds_assunto'] == 'Linha de Conduta')) echo 'selected'; ?>>Linha de Conduta</option>
                                    <option value="Esqueci Minha Senha" <?php if(isset($_SESSION['erros'])&&($_SESSION['post']['ds_assunto'] == 'Esqueci Minha Senha')) echo 'selected'; ?>>Esqueci Minha Senha</option>
                                </select>
                                <?php 
                                if(isset($_SESSION['erros']) && in_array('ds_assunto',$_SESSION['erros'])){ 
                                ?>
                                    <span class="style1">* Preencha corretamente este campo</span>
                                <?php
                                }
                                ?>
                                </div>
                                 <?php 
                                    if(isset($_SESSION['erros']) && in_array('nr_cpf',$_SESSION['erros'])){
                                        $display = 'block';
                                    }else{
                                        $display = 'none';
                                    }
                                  ?>
                                <div id="cpf_contato" style="display: <?php echo $display; ?>; float: left; margin-left: 30px;">CPF:
                                    <input name="nr_cpf" id="nr_cpf" value="<?php if(isset($_SESSION['erros'])){ echo $_SESSION['post']['nr_cpf'];} ?>" onblur="validarCPF(this.value);" onkeypress='return valCPF(event,this);' type="text"  size="20" <?php echo (isset($_SESSION['erros']) && in_array('nr_cpf',$_SESSION['erros'])) ? 'class="campo_erro"' : 'class="campo"'; ?> placeholder="Digite o seu CPF" />
                                    <?php if(isset($_SESSION['erros']) && in_array('nr_cpf',$_SESSION['erros'])){ ?>
                                        <span class="style1">* Preencha corretamente este campo</span>
                                    <?php } ?>
                                </div>
                                
                            </td>                            
                        </tr>
                        
                        <tr>
                            <td>
                                <span class="style1">*</span>
                            </td>
                            <td>
                                <label>Mensagem:</label>
                            </td>
                            <td>
                                <textarea cols="37" rows="5" name="ds_mensagem" id="ds_mensagem" <?php echo (isset($_SESSION['erros']) && in_array('ds_mensagem',$_SESSION['erros'])) ? 'class="campo_erro"' : 'class="campo"'; ?>><?php if(isset($_SESSION['erros'])) echo $_SESSION['post']['ds_mensagem'];?></textarea>
                                <?php 
                                if(isset($_SESSION['erros']) && in_array('ds_mensagem',$_SESSION['erros'])){ 
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

                    </table>
                    <table>
                        <tr>
                            <td colspan="2">
                                <input class="botao" type="submit" value="Enviar" />
                            </td>
                        </tr>
                    </table>
                </fieldset>
            </form>
        </div>
    </div>
</div>
<?php
include_once './footer.php';
ControleSessao::destruirVariavel('erros');
ControleSessao::destruirVariavel('post');
ControleSessao::destruirVariavel('msg');
?>