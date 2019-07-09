<?php
session_start();
//var_dump($_SESSION);
require_once 'header.php';
if(in_array(S_EMAIL , $_SESSION[SESSION_ACESSO])){
?>
<div id="conteudo">    
    <div class="subtitulo">Banco de Oportunidades</div>
    <div style="padding: 1em 8px;">
        <form name="email" id="email" method="post" action="controleEmail.php?op=enviar" enctype="multipart/form-data">    
            <fieldset>
                <legend class="legend">Email em grupo</legend>
                <table class="tabela">
                    <tr>
                        <td><span class="style1"></span></td>
                        <td>Enviar para:</td>
                        <td>
                            <input type="checkbox" name="" id="todos" value="" onclick="marcarTodos();"> Todos
                            <input type="checkbox" name="enviaEmail[]" class="marcar" id="candidatos" value="candidatos" onchange="mostrarProfissoes();"/> Candidatos 
                            <input type="checkbox" name="enviaEmail[]" class="marcar" id="empresas" value="empresas"/> Empresas 
                        </td>
                    </tr>
                    <tr>
                        <td><span class="style1">*</span></td>
                        <td>Assunto:</td>
                        <td>                            
                            <input value="<?php if(isset($_SESSION['erros'])) echo $_SESSION['post']['ds_assunto'];?>" type="text" name="ds_assunto" id="ds_assunto" size="50" maxlength="50" <?php echo (isset($_SESSION['erros']) && in_array('ds_assunto',$_SESSION['erros'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                            <?php 
                            if(isset($_SESSION['erros']) && in_array('ds_assunto',$_SESSION['erros'])){ 
                            ?>
                                <span class="style1">* Preencha corretamente este campo</span>
                            <?php
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="style1">*</span></td>
                        <td>Mensagem:</td>
                        <td>
                            <textarea name="ds_mensagem" id="ds_mensagem" cols="50" rows="3" style="resize: none;" <?php echo (isset($_SESSION['erros']) && in_array('ds_mensagem',$_SESSION['erros'])) ? 'class="campo_erro"' : 'class="campo"'; ?>><?php echo $_POST['ds_mensagem']?></textarea>
                            <?php 
                            if(isset($_SESSION['erros']) && in_array('ds_mensagem',$_SESSION['erros'])){ 
                            ?>
                                <span class="style1"><br>* Preencha corretamente este campo</span>
                            <?php
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Selecione um arquivo:</td>
                        <td>
                            Anexo:<br><input type="file" size="50" name="arquivo" id="arquivo" />
                            <br>
                            <span class="style1">Somente arquivos .png .jpg .pdf</span>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><span class="style1">Campos com * são obrigatórios!</span></td>
                    </tr>
                    <!--tr>
                        <td colspan="2">
                            <input class="botao" type="submit" id="enviar" value="Enviar" onmousedown="validarChecks();"/>
                        </td>                    
                        <td colspan="2"> <?php if(isset($_SESSION['msgEmail'])){ echo $_SESSION['msgEmail']; } ?> </td>
                    </tr-->
                </table>
                
                <span id="span_prof" style="display: none;">
                    <fieldset>
                    <legend class="legend">Profissões</legend>
                        <table class="tab_form" width="100%">
                            <tr>
                                <td><span class="style1"></span></td>
                                <td>Profissões:</td>
                                <td>
                                    <input type="checkbox" name="" id="tdProf" value="" onclick="marcarTodosProfissao();" /> MARCAR TODOS
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>
                                    <?php
                                    $sql = "SELECT
                                                p.id_profissao, p.nm_profissao 
                                            FROM 
                                                profissao p 
                                            WHERE 
                                                ao_ativo = 'S' 
                                            ORDER BY 
                                                p.nm_profissao ASC";
                                    
                                    $query = mysql_query($sql);

                                    $auxProfissoes = array();
                                    while($row = mysql_fetch_object($query)) {
                                        $auxProfissoes[] = $row;
                                    }

                                    foreach($auxProfissoes as $p) {
                                    ?>
                                    <div class="checkProfissaoCand">
                                        <input type="checkbox" class="mProf" id="" name="profissoes[]" value="<?php echo $p->id_profissao; ?>" 
                                            <?php if (isset($_POST['profissoes']) && in_array($p->id_profissao, $_POST['profissoes'])) { echo 'checked'; } ?> /> 
                                            <?php echo $p->nm_profissao; ?>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                        </table>        
                    </fieldset>
                </span>
                 <table>                
                    <tr>
                        <td>
                            <input class="botao" type="submit" id="enviar" value="Enviar" onmousedown="validarChecks();"/>
                        </td>                    
                        <td> <?php if(isset($_SESSION['msgEmail'])){ echo $_SESSION['msgEmail']; } ?> </td>
                    </tr>
               </table>
            </fieldset>
        </form>    
    </div>    
</div>
<?php

unset($_SESSION['erros']);
unset($_SESSION['post']);
unset($_SESSION['msgEmail']);

}else{    
    session_destroy();
    header('Location:index.php');
}
?>