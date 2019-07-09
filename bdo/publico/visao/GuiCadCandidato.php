<?php
include_once '../util/ControleSessao.class.php';
include_once '../util/ControleLoginCandidato.class.php';
ControleSessao::abrirSessao();
if(ControleLoginCandidato::verificarAcesso()){
    ControleLoginCandidato::deslogar();
}
include_once 'header.php';
include_once '../util/Servicos.class.php';
include_once '../util/Validacao.class.php';
include_once '../modelo/CandidatoVO.class.php';
?>
<div id="conteudo">    
    <!--<img id="cabecalho-logo" alt="Brasão da Prefeitura" src="../imagens/Orange wave.png">-->
    <div class="subtitulo"></div>
        <div id="principal">
            <ul>
              <li><a href="#parte-01"><span>Dados Pessoais</span></a></li>
            </ul>        
            
            <!-- DADOS PESSOAIS -->
            <div id="parte-01">
                
                <form name="formDadosPessoais" id="formDadosPessoais" method="post" action="../controle/ControleCandidato.php?op=cadastrar">
                    <fieldset>
                        <legend class="legend">Dados Pessoais</legend>
                        <table class="tabela_cand" style="width: 100%;">
                            <tr>
                                <td width="2%"><span class="style1">*</span></td>
                                <td width="8%">Nome:</td>
                                <td width="90%">
                                    <input name="nm_candidato" id="nome_cand" value="<?php if(isset($_SESSION['errosP'])){ echo $_SESSION['post']['nm_candidato'];}?>" type="text"  size="71" maxlength="60" <?php echo (isset($_SESSION['errosP']) && in_array('nm_candidato',$_SESSION['errosP'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                    <?php echo Servicos::verificarErro('errosP', 'nm_candidato'); ?>
                                </td>  
                            </tr>

                            <tr>
                                <td><span class="style1">*</span></td>
                                <td>CPF:</td>
                                <td>
                                    <input name="nr_cpf" id="nr_cpf" value="<?php if(isset($_SESSION['errosP'])){ echo $_SESSION['post']['nr_cpf'];} ?>" onblur="validarCPF(this.value);" onkeypress='return valCPF(event,this);' type="text"  size="20" <?php echo (isset($_SESSION['errosP']) && in_array('nr_cpf',$_SESSION['errosP'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                    <?php if(isset($_SESSION['errosP']) && in_array('nr_cpf',$_SESSION['errosP'])){ ?>
                                        <span class="style1">* Preencha corretamente este campo</span>
                                    <?php }else if(isset($_SESSION['errosP']) && in_array('cpf_cadastrado',$_SESSION['errosP'])){ ?>
                                        <span class="style1">* Este CPF já está cadastrado!</span>
                                    <?php } ?>
                                </td>  
                            </tr>

                            <tr>
                                <td><span class="style1"></span></td>
                                <td>RG:</td>
                                <td>
                                    <input name="nr_rg" id="nr_rg" value="<?php if(isset($_SESSION['errosP'])){ echo $_SESSION['post']['nr_rg'];} ?>" type="text"  size="20" maxlength="10" <?php echo (isset($_SESSION['errosP']) && in_array('nr_rg',$_SESSION['errosP'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                    <?php echo Servicos::verificarErro('errosP', 'nr_rg'); ?>
                                </td>  
                            </tr>
                            
                            <tr>
                                <td><span class="style1"></span></td>
                                <td>CTPS Nº:</td>
                                <td>
                                    <input name="nr_ctps" id="nr_ctps" value="<?php if(isset($_SESSION['errosP'])){ echo $_SESSION['post']['nr_ctps'];} ?>" onkeypress="return valida_numero(event);" type="text"  size="20" maxlength="10" <?php echo (isset($_SESSION['errosP']) && in_array('nr_ctps',$_SESSION['errosP'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                    &nbsp;&nbsp;
                                    <span class="style1"></span>&nbsp;Série Nº:
                                    <input name="nr_serie" id="nr_serie" value="<?php if(isset($_SESSION['errosP'])){ echo $_SESSION['post']['nr_serie'];} ?>" type="text"  size="7" maxlength="5" <?php echo (isset($_SESSION['errosP']) && in_array('nr_serie',$_SESSION['errosP'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                    &nbsp;
                                    <span class="style1"></span>&nbsp;UF:
                                    <select name="id_estadoctps" id="id_estadoctps" <?php echo (isset($_SESSION['errosP']) && in_array('id_estadoctps',$_SESSION['errosP'])) ? 'class="campo_erro"' : 'class="campo"'; ?>>
                                        <option value="" selected>----</option>
                                        <?php
                                        $estadosSg = array();
                                        $estadosSg = Servicos::buscarEstadosPorSg();
                                        foreach ($estadosSg as $e) {
                                        ?>
                                            <option value="<?php echo $e->id_estado; ?>" <?php if(isset($_SESSION['errosP']) && $_SESSION['post']['id_estadoctps'] == $e->id_estado){ echo 'selected';} ?>><?php echo $e->sg_estado; ?></option>
                                        <?php
                                        }                                    
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            
                            <tr>
                                <td><span class="style1"></span></td>
                                <td>PIS/PASEP:</td>
                                <td>
                                    <input name="nr_pis" id="nr_pis" value="<?php if(isset($_SESSION['errosP'])){ echo $_SESSION['post']['nr_pis'];} ?>" onkeypress="return valida_numero(event);" type="text"  size="20" maxlength="50" <?php echo (isset($_SESSION['errosP']) && in_array('nr_pis',$_SESSION['errosP'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                </td>         
                            </tr>
                            
                            <tr>
                                <td><span class="style1"></span></td>
                                <td>CNH:</td>
                                <td>
                                    <select name="ds_cnh" id="ds_cnh" class="campo"  >
                                        <option value="">Selecione</option>
                                        <option value="ACC" <?php if ($_SESSION['post']['ds_cnh'] == 'ACC') echo "selected" ?>>ACC</option>
                                        <option value="A" <?php if ($_SESSION['post']['ds_cnh'] == 'A') echo "selected" ?>>A</option>
                                        <option value="B" <?php if ($_SESSION['post']['ds_cnh'] == 'B') echo "selected" ?>>B</option>
                                        <option value="C" <?php if ($_SESSION['post']['ds_cnh'] == 'C') echo "selected" ?>>C</option>
                                        <option value="D" <?php if ($_SESSION['post']['ds_cnh'] == 'D') echo "selected" ?>>D</option>
                                        <option value="E" <?php if ($_SESSION['post']['ds_cnh'] == 'E') echo "selected" ?>>E</option>
                                        <option value="AB" <?php if ($_SESSION['post']['ds_cnh'] == 'AB') echo "selected" ?>>AB</option>
                                        <option value="AC" <?php if ($_SESSION['post']['ds_cnh'] == 'AC') echo "selected" ?>>AC</option>
                                        <option value="AD" <?php if ($_SESSION['post']['ds_cnh'] == 'AD') echo "selected" ?>>AD</option>
                                        <option value="AE" <?php if ($_SESSION['post']['ds_cnh'] == 'AE') echo "selected" ?>>AE</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="style1">*</span></td>
                                <td>Email:</td>
                                <td>
                                    <input name="ds_email"  id="ds_email" value="<?php if(isset($_SESSION['errosP'])){ echo $_SESSION['post']['ds_email'];} ?>" type="text"  size="71" maxlength="60" <?php echo (isset($_SESSION['errosP']) && in_array('ds_email',$_SESSION['errosP'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                    <?php echo Servicos::verificarErro('errosP', 'ds_email'); ?>
                                </td>
                            </tr>

                            <tr>
                                <td><span class="style1"></span></td>
                                <td>Telefone:</td>
                                <td>
                                    <input name="nr_telefone" id="nr_telefone" value="<?php if(isset($_SESSION['errosP'])){ echo $_SESSION['post']['nr_telefone'];} ?>" onkeypress="return valida_numero(event);" type="text" maxlength="14" <?php echo (isset($_SESSION['errosP']) && in_array('nr_telefone',$_SESSION['errosP'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                    <?php echo Servicos::verificarErro('errosP', 'nr_telefone'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="style1"></span></td>
                                <td>Celular:</td>
                                <td>
                                    <input name="nr_celular" id="nr_celular" value="<?php if(isset($_SESSION['errosP'])){ echo $_SESSION['post']['nr_celular'];} ?>" onkeypress="return valida_numero(event);" type="text" maxlength="14" <?php echo (isset($_SESSION['errosP']) && in_array('nr_celular',$_SESSION['errosP'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                    <?php echo Servicos::verificarErro('errosP', 'nr_celular'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="style1"></span></td>
                                <td>Estado Civil:</td>
                                <td>
                                    <select name="ds_estado_civil" id="ds_estado_civil" <?php echo (isset($_SESSION['errosP']) && in_array('ds_estado_civil',$_SESSION['errosP'])) ? 'class="campo_erro"' : 'class="campo"'; ?>>
                                        <option value="" selected>Selecione</option>
                                        <option value="S" <?php if(isset($_SESSION['errosP']) && $_SESSION['post']['ds_estado_civil'] == 'S') echo 'selected'; ?>>Solteiro</option>
                                        <option value="C" <?php if(isset($_SESSION['errosP']) && $_SESSION['post']['ds_estado_civil'] == 'C') echo 'selected'; ?>>Casado</option>
                                        <option value="V" <?php if(isset($_SESSION['errosP']) && $_SESSION['post']['ds_estado_civil'] == 'V') echo 'selected'; ?>>Viúvo</option>
                                        <option value="D" <?php if(isset($_SESSION['errosP']) && $_SESSION['post']['ds_estado_civil'] == 'D') echo 'selected'; ?>>Divorciado</option>
                                        <option value="P" <?php if(isset($_SESSION['errosP']) && $_SESSION['post']['ds_estado_civil'] == 'P') echo 'selected'; ?>>Separado</option>
                                        <option value="O" <?php if(isset($_SESSION['errosP']) && $_SESSION['post']['ds_estado_civil'] == 'O') echo 'selected'; ?>>Outros</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="style1">*</span></td>
                                <td>Nascimento:</td>
                                <td>
                                    <input type="text" name="dt_nascimento" id="dt_nascimento" value="<?php if(isset($_SESSION['errosP'])){ echo $_SESSION['post']['dt_nascimento'];} ?>" onkeypress="return valida_numero(event);" onkeydown="formata_data(this, event);" size="11" maxlength="10" <?php echo (isset($_SESSION['errosP']) && in_array('dt_nascimento',$_SESSION['errosP'])) ? 'class="campo_erro data"' : 'class="campo data"'; ?> />
                                    <?php if(isset($_SESSION['errosP']) && in_array('dt_nascimento',$_SESSION['errosP'])){ ?>
                                        <span class="style1">* Preencha corretamente este campo</span>
                                    <?php }else if(isset($_SESSION['errosP']) && in_array('menor_idade',$_SESSION['errosP'])){ ?>
                                        <span class="style1">* Você deve ter no mínimo 14 anos.</span>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="style1"></span></td>
                                <td>Gênero:</td>
                                <td>
                                    <input name="ao_sexo" id="ao_sexo" type="radio" value="M" checked />Masculino
                                    <input name="ao_sexo" id="ao_sexo" type="radio" value="F" <?php if(isset($_SESSION['errosP']) && $_SESSION['post']['ao_sexo'] == 'F') echo 'checked'; ?> />Feminino
                                    <?php echo Servicos::verificarErro('errosP', 'ao_sexo'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="style1"></span></td>
                                <td>
                                    <label>Cep:</label>
                                </td>
                                <td>
                                    <input value="<?php if(isset($_SESSION['errosP'])) echo $_SESSION['post']['nr_cep'];?>" type="text" name="nr_cep" id="nr_cep" maxlength='9' onBlur="ValidaCep(this.value)" onkeypress="return BloqueiaLetras(this.value);" <?php echo (isset($_SESSION['errosP']) && in_array('nr_cep',$_SESSION['errosP'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                    <?php echo Servicos::verificarErro('errosP', 'nr_cep'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="style1">*</span></td>	      
                                <td>Logradouro:</td>
                                <td>
                                    <input name="ds_logradouro" id="ds_logradouro" value="<?php if(isset($_SESSION['errosP'])){ echo $_SESSION['post']['ds_logradouro'];} ?>" type="text"  size="70" maxlength="70" <?php echo (isset($_SESSION['errosP']) && in_array('ds_logradouro',$_SESSION['errosP'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                    <?php echo Servicos::verificarErro('errosP', 'ds_logradouro'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="style1">*</span></td>
                                <td>Nº:</td>
                                <td>
                                    <input name="nr_logradouro" id="nr_logradouro" value="<?php if(isset($_SESSION['errosP'])){ echo $_SESSION['post']['nr_logradouro'];} ?>" onkeypress="return valida_numero(event);" type="text"  size="10" maxlength="8" <?php echo (isset($_SESSION['errosP']) && in_array('nr_logradouro',$_SESSION['errosP'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                    <?php echo Servicos::verificarErro('errosP', 'nr_logradouro'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>Complemento:</td>
                                <td>
                                    <input name="ds_complemento" id="ds_complemento" value="<?php if(isset($_SESSION['errosP'])){ echo $_SESSION['post']['ds_complemento'];} ?>" type="text"  size="70" maxlength="70" <?php echo (isset($_SESSION['errosP']) && in_array('ds_complemento',$_SESSION['errosP'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                    <?php echo Servicos::verificarErro('errosP', 'ds_complemento'); ?>
                                </td>
                            </tr>
							
                            <tr>
                                <td><span class="style1">*</span></td>
                                <td>Estado:</td>
                                <td>
                                    <select name="id_estado" id="id_estado" <?php echo (isset($_SESSION['errosP']) && in_array('id_estado',$_SESSION['errosP'])) ? 'class="campo_erro select"' : 'class="campo select"'; ?>>
                                        <option value="" selected>Selecione</option>
                                        <?php
                                        $estadosNm = array();
                                        $estadosNm = Servicos::buscarEstadosPorNm();
                                        foreach ($estadosNm as $e) {
                                        ?>
                                        <option value="<?php echo $e->id_estado; ?>" <?php if(isset($_SESSION['errosP']) && $_SESSION['post']['id_estado'] == $e->id_estado) echo 'selected'; ?>><?php echo $e->nm_estado; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <?php echo Servicos::verificarErro('errosP', 'id_estado'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="style1">*</span></td>
                                <td>Cidade:</td>
                                <td>                                    
                                    <select onload="teste()" name="id_cidade" id="id_cidade" <?php echo (isset($_SESSION['errosP']) && in_array('id_cidade',$_SESSION['errosP'])) ? 'class="campo_erro select"' : 'class="campo select"'; ?>>
                                        <option value="" selected>Selecione</option>
                                        <?php
                                        if(isset($_SESSION['errosP']) && isset($_SESSION['post']) && !empty($_SESSION['post']['id_estado'])){
                                            $cidades = array();
                                            $cidades = Servicos::buscarCidadesPorIdEstado($_SESSION['post']['id_estado']);
                                            
                                            foreach ($cidades as $c) {
                                               
                                        ?>
                                        <option value="<?php echo $c->id_cidade;?>" <?php if(isset($_SESSION['errosP']) && $_SESSION['post']['id_cidade'] == $c->id_cidade) echo 'selected'; ?>><?php echo utf8_decode($c->nm_cidade); ?></option>
                                                <?php

                                            }
                                        }
                                        ?>                                  

                                    </select>
                                    <?php echo Servicos::verificarErro('errosP', 'id_cidade'); ?>
                                </td>
                            </tr
                            
                             <tr>
                                <td><span class="style1">*</span></td>
                                <td>Bairro:</td>
                                
                                
                                <td>           
                                    
                                    <select style="display:none" <?php /*if($_SESSION['post']['id_cidade']) { echo 'style="display:block'; } else { echo 'style="display:none"'; };*/?> name="id_bairro" id="id_bairro" <?php echo (isset($_SESSION['errosP']) && in_array('id_bairro',$_SESSION['errosP'])) ? 'class="campo_erro select"' : 'class="campo select"'; ?>>
                                        <option value="" selected>Selecione</option>
                                        <?php
                                                                                                                       
                                       
                                        if(isset($_SESSION['errosP']) && isset($_SESSION['post']) && !empty($_SESSION['post']['id_cidade'])){
                                            $bairros = array();
                                            $bairros = Servicos::buscarBairrosPorIdCidade($_SESSION['post']['id_cidade']);
                                            
                                            
                                            
                                            foreach ($bairros as $b) {
                                               
                                        ?>
                                                <option value="<?php echo $b->id_bairro;?>" <?php if(isset($_SESSION['errosP']) && $_SESSION['post']['id_bairro'] == $b->id_bairro) echo 'selected'; ?>><?php echo $b->nm_bairro; ?></option>
                                        <?php
                                            }
                                       }
                                        ?>
                                        
                                    </select>
                                    
                                    <input onclick="bairroChange()" style="display:block" name="ds_bairro" id="ds_bairro" value="<?php if(isset($_SESSION['errosP'])){ echo $_SESSION['post']['ds_bairro'];} ?>" type="text"  maxlength="20" <?php echo (isset($_SESSION['errosP']) && in_array('ds_bairro',$_SESSION['errosP'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                    <?php echo Servicos::verificarErro('errosP', 'ds_bairro'); echo Servicos::verificarErro('errosP', 'id_bairro'); ?>
                                </td>
                            </tr>
                            
                            <tr>
                                <td>&nbsp;</td>
                                <td>Nacionalidade:</td>
                                <td>
                                    <input  name="ds_nacionalidade"  id="ds_nacionalidade" value="<?php if(isset($_SESSION['errosP'])){ echo $_SESSION['post']['ds_nacionalidade'];} ?>" type="text" <?php echo (isset($_SESSION['errosP']) && in_array('ds_nacionalidade',$_SESSION['errosP'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                    <?php echo Servicos::verificarErro('errosP', 'ds_nacionalidade'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="style1"></span></td>
                                <td>Deficiência:</td>
                                <td>
                                    <select name="id_deficiencia" id="id_deficiencia" <?php echo (isset($_SESSION['errosP']) && in_array('id_deficiencia',$_SESSION['errosP'])) ? 'class="campo_erro select"' : 'class="campo select"'; ?>>
                                        <option value="" selected>Nenhuma</option>
                                        <?php
                                        $deficiencias = array();
                                        $deficiencias = Servicos::buscarDeficiencias();
                                        foreach ($deficiencias as $d) {
                                        ?>
                                        <option value="<?php echo $d->id_deficiencia; ?>" <?php if(isset($_SESSION['errosP']) && $_SESSION['post']['id_deficiencia'] == $d->id_deficiencia) echo 'selected'; ?>><?php echo $d->nm_deficiencia; ?></option>
                                        <?php
                                        }
                                        ?>
                                        <?php echo Servicos::verificarErro('errosP', 'id_deficiencia'); ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="style1"></span></td>
                                <td>Objetivo:</td>
                                <td>
                                    <textarea name="ds_objetivo" id="ds_objetivo" cols="50" rows="3" <?php echo (isset($_SESSION['errosP']) && in_array('ds_objetivo',$_SESSION['errosP'])) ? 'class="campo_erro"' : 'class="campo"'; ?>><?php if(isset($_SESSION['errosP'])){ echo $_SESSION['post']['ds_objetivo'];} ?></textarea>
                                    <?php echo Servicos::verificarErro('errosP', 'ds_objetivo'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="style1">*</span></td>
                                <td>Possui Bolsa Família:</td>
                                <td>
                                    <input name="ao_bolsafamilia" id="ao_bolsafamilia_n" type="radio" onclick="mostrarCampoNIS();" value="N" checked />Não
                                    <input name="ao_bolsafamilia" id="ao_bolsafamilia_s" type="radio" onclick="mostrarCampoNIS();" value="S" <?php if(isset($_SESSION['errosP']) && $_SESSION['post']['ao_bolsafamilia'] == 'S') echo 'checked'; ?> />Sim
                                    <?php echo Servicos::verificarErro('errosP', 'ao_bolsafamilia'); ?>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span id="numeroNis" <?php echo 'style="display: none"'; ?>>
                                        NIS:
                                        <input name="nr_nis" id="nr_nis" value="<?php if(isset($_SESSION['errosP'])){ echo $_SESSION['post']['nr_nis'];} ?>" type="text"  size="20" maxlength="11" <?php echo (isset($_SESSION['errosP']) && in_array('nr_nis',$_SESSION['errosP'])) ? 'class="campo_erro"' : 'class="campo"'; ?>/>
                                        <?php echo Servicos::verificarErro('errosP', 'nr_nis'); ?>
                                    </span>                                    
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td><span class="style1">* Campos com * são obrigatórios!</span></td>
                            </tr>
                        </table>
                    </fieldset>
                    <fieldset>
                        <legend class="legend">Dados de Acesso</legend>
                        <table class="tabela_cand">
                            <tr>
                                <td width="2%"><span class="style1">*</span></td>
                                <td width="8%">Login:</td>
                                <td width="90%">
                                    <input name="ds_loginportal" id="ds_loginportal" value="<?php if(isset($_SESSION['errosP'])){ echo $_SESSION['post']['ds_loginportal'];} ?>" type="text"  size="30" maxlength="20" <?php echo (isset($_SESSION['errosP']) && in_array('ds_loginportal',$_SESSION['errosP'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                    Ex: nome.sobrenome (joão.silva)
                                    <?php if(isset($_SESSION['errosP']) && in_array('ds_loginportal',$_SESSION['errosP'])){ ?>
                                        <span class="style1">* Preencha corretamente este campo</span>
                                    <?php }else if(isset($_SESSION['errosP']) && in_array('login_cadastrado',$_SESSION['errosP'])){ ?>
                                        <span class="style1">* Este Login já está cadastrado!</span>
                                    <?php } ?>
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                    <table>
                        <tr>
                            <td colspan="2">
                                <input name="next" class="botao" type="submit" id="next_0" value="Cadastrar" />
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <!-- FIM DADOS PESSOAIS -->
        </div>
    </div>

<?php 
include_once 'footer.php';
ControleSessao::destruirVariavel('errosP');
ControleSessao::destruirVariavel('post');
?>