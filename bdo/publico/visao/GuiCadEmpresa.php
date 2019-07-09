<?php
include_once '../util/ControleSessao.class.php';
ControleSessao::abrirSessao();

include_once './header.php';
include_once '../util/Servicos.class.php';
?>
<div id="conteudo">
    <!--<img id="cabecalho-logo" alt="Brasão da Prefeitura" src="../imagens/Orange wave.png">-->
    <div class="subtitulo">Banco de Oportunidades</div>
    
    <div id="principal">
        <ul>
            <li><a href="#parte-01"><span>Dados da Empresa</span></a></li>
        </ul>

        <div id="parte-01">
            <div class="style1">
                <?php if(isset($_SESSION['msg']))echo ControleSessao::buscarVariavel('msg');?>
                <?php if(isset($_SESSION['errosE']) && in_array('empresa_cadastrada',$_SESSION['errosE'])){ echo 'Este CNPJ e/ou Login já estão cadastrados!'; } ?>
            </div>
            
            <form name="formCadEmpresa" id="formCadEmpresa" method="post" action="../controle/ControleEmpresa.php?op=cadastrar">
                <fieldset>
                    <legend class="legend">Dados da Empresa</legend>
                    
                    <table border="0" class="tabela_empresa" style="width: 100%;">
                        <tr>
                            <td width="1%"><span class="style1">*</span></td>
                            <td width="20%">
                                <label>Razão Social:</label>
                            </td>
                            <td width="79%">
                                <input value="<?php if(isset($_SESSION['errosE'])) echo $_SESSION['post']['nm_razaosocial'];?>" type="text" name="nm_razaosocial" id="nm_razaosocial" size="50" maxlength="50" <?php echo (isset($_SESSION['errosE']) && in_array('nm_razaosocial',$_SESSION['errosE'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                <?php 
                                if(isset($_SESSION['errosE']) && in_array('nm_razaosocial',$_SESSION['errosE'])){ 
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
                                <label>Nome da Fantasia:</label>
                            </td>
                            <td>
                                <input value="<?php if(isset($_SESSION['errosE'])) echo $_SESSION['post']['nm_fantasia'];?>" type="text" name="nm_fantasia" id="nm_fantasia" size="50" maxlength="50" <?php echo (isset($_SESSION['errosE']) && in_array('nm_fantasia',$_SESSION['errosE'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                <?php 
                                if(isset($_SESSION['errosE']) && in_array('nm_fantasia',$_SESSION['errosE'])){ 
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
                                <label>CNPJ:</label>
                            </td>
                            <td>                                                                                                                                                  
                                <input type="text" name="nr_cnpj" value="<?php if(isset($_SESSION['errosE'])) echo $_SESSION['post']['nr_cnpj'];?>" id="nr_cnpj" size='20' maxlength='18' onblur="ValidarCNPJ(this.value);" onkeypress=" return BloqueiaLetras(this.value);" <?php echo (isset($_SESSION['errosE']) && in_array('nr_cnpj',$_SESSION['errosE'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                <?php 
                                if(isset($_SESSION['errosE']) && in_array('nr_cnpj',$_SESSION['errosE'])){ 
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
                                <label>Ramo de Atividade:</label>
                            </td>
                            <td>
                                <select name="id_ramoatividade" id="id_ramoatividade" <?php echo (isset($_SESSION['errosE']) && in_array('id_ramoatividade',$_SESSION['errosE'])) ? 'class="campo_erro select"' : 'class="campo select"'; ?>>
                                    <option value="" selected>Selecione</option>
                                    <?php
                                    $ramos = Servicos::buscarRamoAtividade();
                                    foreach ($ramos as $r) {
                                        ?>
                                        <option value="<?php echo $r->id_ramoatividade; ?>" <?php if (isset($_SESSION['errosE']) && $_SESSION['post']['id_ramoatividade'] == $r->id_ramoatividade) echo 'selected'; ?>><?php echo $r->nm_ramoatividade; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <?php 
                                if(isset($_SESSION['errosE']) && in_array('id_ramoatividade',$_SESSION['errosE'])){ 
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
                                <label>Tipo de Empresa:</label>
                            </td>
                            <td>
                                <select name="id_empresatipo" id="id_empresatipo" <?php echo (isset($_SESSION['errosE']) && in_array('id_empresatipo',$_SESSION['errosE'])) ? 'class="campo_erro select"' : 'class="campo select"'; ?>>
                                    <option value="" selected>Selecione</option>
                                    <?php
                                    $empresatipo = Servicos::buscarEmpresaTipo();
                                    foreach ($empresatipo as $emptipo) {
                                        ?>
                                        <option value="<?php echo $emptipo->id_empresatipo; ?>" <?php if (isset($_SESSION['errosE']) && $_SESSION['post']['id_empresatipo'] == $emptipo->id_empresatipo) echo 'selected'; ?>><?php echo $emptipo->nm_empresatipo; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <?php 
                                if(isset($_SESSION['errosE']) && in_array('id_empresatipo',$_SESSION['errosE'])){ 
                                ?>
                                    <span class="style1">* Preencha corretamente este campo</span>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>
                        
                        <tr>
                            <td><span class="style1">*</span></td>
                            <td>Quantidade de Funcionários</td>
                            <td>
                                <select name="id_quantidadefuncionario" id="id_quantidadefuncionario" <?php echo (isset($_SESSION['errosE']) && in_array('id_quantidadefuncionario',$_SESSION['errosE'])) ? 'class="campo_erro select"' : 'class="campo select"'; ?>>
                                    <option value="" selected>Selecione</option>
                                    <?php
                                    $quantidade = Servicos::buscarQuantidadeFuncionario();
                                    
                                    foreach ($quantidade as $q) {                                        
                                        ?>
                                        <option value="<?php echo $q->id_quantidadefuncionario; ?>" <?php if (isset($_SESSION['errosE']) && $_SESSION['post']['id_quantidadefuncionario'] == $q->id_quantidadefuncionario) echo 'selected'; ?>><?php echo $q->nm_quantidadefuncionario; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <?php 
                                if(isset($_SESSION['errosE']) && in_array('id_quantidadefuncionario',$_SESSION['errosE'])){ 
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
                                <label>Contato:</label>
                            </td>
                            <td>
                                <input value="<?php if(isset($_SESSION['errosE'])) echo $_SESSION['post']['nm_contato'];?>" type="text" name="nm_contato" id="nm_contato" size='20' maxlength='30' <?php echo (isset($_SESSION['errosE']) && in_array('nm_contato',$_SESSION['errosE'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                <?php 
                                if(isset($_SESSION['errosE']) && in_array('nm_contato',$_SESSION['errosE'])){ 
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
                                <label>Telefone da empresa:</label>
                            </td>
                            <td>
                                <input value="<?php if(isset($_SESSION['errosE'])) echo $_SESSION['post']['nr_telefoneempresa'];?>" type="text" name="nr_telefoneempresa" id="nr_telefoneempresa" <?php echo (isset($_SESSION['errosE']) && in_array('nr_telefoneempresa',$_SESSION['errosE'])) ? 'class="campo_erro"' : 'class="campo"'; ?>/>
                                <?php 
                                if(isset($_SESSION['errosE']) && in_array('nr_telefoneempresa',$_SESSION['errosE'])){ 
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
                                <label>Cep:</label>
                            </td>
                            <td>
                                <input value="<?php if(isset($_SESSION['errosE'])) echo $_SESSION['post']['nr_cep'];?>" type="text" name="nr_cep" id="nr_cep" maxlength='9' onBlur="ValidaCep(this.value)" onkeypress="return BloqueiaLetras(this.value);" <?php echo (isset($_SESSION['errosE']) && in_array('nr_cep',$_SESSION['errosE'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                <?php 
                                if(isset($_SESSION['errosE']) && in_array('nr_cep',$_SESSION['errosE'])){ 
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
                                <label> Logradouro: </label>                     
                            </td>
                            <td>
                                <input value="<?php if(isset($_SESSION['errosE'])) echo $_SESSION['post']['ds_logradouro'];?>" type="text" name="ds_logradouro" id="ds_logradouro" size="50" maxlength="50" <?php echo (isset($_SESSION['errosE']) && in_array('ds_logradouro',$_SESSION['errosE'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                <?php 
                                if(isset($_SESSION['errosE']) && in_array('ds_logradouro',$_SESSION['errosE'])){ 
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
                                <label>Número:</label>
                            </td>                           
                            <td>
                                <input value="<?php if(isset($_SESSION['errosE'])) echo $_SESSION['post']['nr_logradouro'];?>" type="text" name="nr_logradouro" id="nr_logradouro" size="10" maxlength="10" onkeypress="return valida_numero(event);" <?php echo (isset($_SESSION['errosE']) && in_array('nr_logradouro',$_SESSION['errosE'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                <?php 
                                if(isset($_SESSION['errosE']) && in_array('nr_logradouro',$_SESSION['errosE'])){ 
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
                                <label>Bairro:</label>
                            </td>
                            <td>
                                <input value="<?php if(isset($_SESSION['errosE'])) echo $_SESSION['post']['ds_bairro'];?>" type="text" name="ds_bairro" id="ds_bairro" size="50" maxlength="50" <?php echo (isset($_SESSION['errosE']) && in_array('ds_bairro',$_SESSION['errosE'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                <?php 
                                if(isset($_SESSION['errosE']) && in_array('ds_bairro',$_SESSION['errosE'])){ 
                                ?>
                                    <span class="style1">* Preencha corretamente este campo</span>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <span class="style1"></span>
                            </td>
                            <td>
                                <label>Complemento:</label>
                            </td>
                            <td>
                                <input value="<?php if(isset($_SESSION['errosE'])) echo $_SESSION['post']['ds_complemento'];?>" type="text" name="ds_complemento" id="ds_complemento" size="50" maxlength="50" <?php echo (isset($_SESSION['errosE']) && in_array('ds_complemento',$_SESSION['errosE'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                <?php 
                                if(isset($_SESSION['errosE']) && in_array('ds_complemento',$_SESSION['errosE'])){ 
                                ?>
                                    <span class="style1">* Preencha corretamente este campo</span>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td><span class="style1">*</span></td>
                            <td>Estado:</td>
                            <td>
                                <select name="id_estado" id="id_estado" <?php echo (isset($_SESSION['errosE']) && in_array('id_estado',$_SESSION['errosE'])) ? 'class="campo_erro select"' : 'class="campo select"'; ?>>
                                    <option value="" selected>Selecione</option>
                                    <?php
                                    $estadosNm = array();
                                    $estadosNm = Servicos::buscarEstadosPorNm();
                                    foreach ($estadosNm as $e) {
                                        ?>
                                        <option value="<?php echo $e->id_estado; ?>" <?php if (isset($_SESSION['errosE']) && $_SESSION['post']['id_estado'] == $e->id_estado) echo 'selected'; ?>><?php echo $e->nm_estado; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <?php 
                                if(isset($_SESSION['errosE']) && in_array('id_estado',$_SESSION['errosE'])){ 
                                ?>
                                    <span class="style1">* Preencha corretamente este campo</span>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="style1">*</span></td>
                            <td>Cidade:</td>
                            <td>
                                <select name="id_cidade" id="id_cidade" <?php echo (isset($_SESSION['errosE']) && in_array('id_cidade',$_SESSION['errosE'])) ? 'class="campo_erro select"' : 'class="campo select"'; ?>>
                                    <option value="" selected>Selecione</option>
                                    <?php
                                    if (isset($_SESSION['errosE']) && isset($_SESSION['post']) && !empty($_SESSION['post']['id_estado'])) {
                                        $cidades = array();
                                        $cidades = Servicos::buscarCidadesPorIdEstado($_SESSION['post']['id_estado']);
                                        foreach ($cidades as $c) {
                                            ?>
                                            <option value="<?php echo $c->id_cidade; ?>" <?php if ($_SESSION['post']['id_cidade'] == $c->id_cidade) echo 'selected'; ?>><?php echo $c->nm_cidade; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <?php 
                                if(isset($_SESSION['errosE']) && in_array('id_cidade',$_SESSION['errosE'])){ 
                                ?>
                                    <span class="style1">* Preencha corretamente este campo</span>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <span class="style1"></span>
                            </td>
                            <td>
                                <label>Site da Empresa:</label>
                            </td>
                            <td>
                                <input value="<?php if(isset($_SESSION['errosE'])) echo $_SESSION['post']['ds_site'];?>" type="text" name="ds_site"  id="ds_site" size="50" maxlength="50" <?php echo (isset($_SESSION['errosE']) && in_array('ds_site',$_SESSION['errosE'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                <?php 
                                if(isset($_SESSION['errosE']) && in_array('ds_site',$_SESSION['errosE'])){ 
                                ?>
                                    <span class="style1">* Preencha corretamente este campo</span>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <span class="style1"></span>
                            </td>
                            <td>
                                <label>Inscrição Estadual:</label>
                            </td>
                            <td>
                                <input value="<?php if(isset($_SESSION['errosE'])) echo $_SESSION['post']['nr_inscricaoestadual'];?>" type="text" name="nr_inscricaoestadual" id="nr_inscricaoestadual" size="50" maxlength="25" onkeypress="return valida_numero(event);" <?php echo (isset($_SESSION['errosE']) && in_array('nr_inscricaoestadual',$_SESSION['errosE'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                <?php 
                                if(isset($_SESSION['errosE']) && in_array('nr_inscricaoestadual',$_SESSION['errosE'])){ 
                                ?>
                                    <span class="style1">* Preencha corretamente este campo</span>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <span class="style1"></span>
                            </td>
                            <td>
                                <label>Inscrição Municipal:</label>
                            </td>
                            <td>
                                <input value="<?php if(isset($_SESSION['errosE'])) echo $_SESSION['post']['nr_inscricaomunicipal'];?>" type="text" name="nr_inscricaomunicipal" id="nr_inscricaomunicipal" size="50" maxlength="20" onkeypress="return valida_numero(event);" <?php echo (isset($_SESSION['errosE']) && in_array('nr_inscricaomunicipal',$_SESSION['errosE'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                <?php 
                                if(isset($_SESSION['errosE']) && in_array('nr_inscricaomunicipal',$_SESSION['errosE'])){ 
                                ?>
                                    <span class="style1">* Preencha corretamente este campo</span>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <span class="style1"></span>
                            </td>
                            <td>
                                <label>Data da Fundação:</label>
                            </td>
                            <td>
                                <input value="<?php if(isset($_SESSION['errosE'])) echo $_SESSION['post']['dt_fundacao'];?>" type="text" name="dt_fundacao" id="dt_fundacao" onblur="validaDataEmpresa(this.value, 'dt_fundacao');" size="11" maxlength="10" <?php echo (isset($_SESSION['errosE']) && in_array('dt_fundacao',$_SESSION['errosE'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                <?php 
                                if(isset($_SESSION['errosE']) && in_array('dt_fundacao',$_SESSION['errosE'])){ 
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
                                <label>Email / Login:</label>
                            </td>
                            <td>
                                <input value="<?php if(isset($_SESSION['errosE'])) echo $_SESSION['post']['ds_email'];?>" type="text" name="ds_email" id="ds_email" size="50" maxlength="50" <?php echo (isset($_SESSION['errosE']) && in_array('ds_email',$_SESSION['errosE'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                <?php 
                                if(isset($_SESSION['errosE']) && in_array('ds_email',$_SESSION['errosE'])){ 
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
                                <label>Senha:</label>
                            </td>
                            <td>
                                <input value="<?php if(isset($_SESSION['errosE'])) echo $_SESSION['post']['pw_senha'];?>" type="password" name="pw_senha" id="pw_senha" size="50" maxlength="12" <?php echo (isset($_SESSION['errosE']) && in_array('pw_senha',$_SESSION['errosE'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                <?php 
                                if(isset($_SESSION['errosE']) && in_array('pw_senha',$_SESSION['errosE'])){ 
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
                </fieldset>
                
                <fieldset>
                    <legend class="legend">Dados do Responsável</legend>
                    <table class="tabela_cand" style="width: 100%;">
                            <tr>
                                <td width="1%"><span class="style1">*</span></td>
                                <td width="20%">
                                    <label>Responsável:</label>
                                </td>
                                <td width="79%">
                                    <input <?php /*if(isset($_SESSION['ErrosE'])) echo 'readonly';*/ ?> value="<?php if(isset($_SESSION['errosE']))echo $_SESSION['post']['nm_proprietario'];?>" type="text" name="nm_proprietario" id="nm_proprietario" size="50" maxlength="50" <?php echo (isset($_SESSION['errosE']) && in_array('nm_proprietario',$_SESSION['errosE'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                    <!--<input value="<?php /* if(isset($_SESSION['errosE'])) echo $_SESSION['post']['ds_complemento'];?>" type="text" name="ds_complemento" id="ds_complemento" size="50" maxlength="50" <?php echo (isset($_SESSION['errosE']) && in_array('ds_complemento',$_SESSION['errosE'])) ? 'class="campo_erro"' : 'class="campo"'; */ ?> />-->
                                    <?php 
                                    if(isset($_SESSION['errosE']) && in_array('nm_proprietario',$_SESSION['errosE'])){ 
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
                                    <label>CPF:</label>
                                </td>
                                <td>
                                    <input <?php /*if(isset($_SESSION['errosE'])) echo 'readonly';*/ ?> value="<?php if(isset($_SESSION['errosE']))echo $_SESSION['post']['nr_cpf'];?>" name="nr_cpf" id="nr_cpf" type="text" onblur="validarCPF(this.value);" size="20" maxlength="11" <?php echo (isset($_SESSION['errosE']) && in_array('nr_cpf',$_SESSION['errosE'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                    <?php 
                                    if(isset($_SESSION['errosE']) && in_array('nr_cpf',$_SESSION['errosE'])){ 
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
                                    <input value="<?php if(isset($_SESSION['errosE']))echo $_SESSION['post']['ds_cargo']; ?>" type="text" name="ds_cargo" id="ds_cargo" size="50" maxlength="50" <?php echo (isset($_SESSION['errosE']) && in_array('ds_cargo',$_SESSION['errosE'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                    <?php 
                                    if(isset($_SESSION['errosE']) && in_array('ds_cargo',$_SESSION['errosE'])){ 
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
                                    <label>Data de Nascimento:</label>
                                </td>
                                <td>
                                    <input value="<?php if(isset($_SESSION['errosE']))echo $_SESSION['post']['dt_nascimento']; ?>" type="text" name="dt_nascimento" id="nascimento" onblur="validaDataEmpresa(this.value, 'anascimento');" size="11" maxlength="10" <?php echo (isset($_SESSION['errosE']) && in_array('dt_nascimento',$_SESSION['errosE'])) ? 'class="campo_erro data"' : 'class="campo data"'; ?> /> 
                                    <?php 
                                    if(isset($_SESSION['errosE']) && in_array('dt_nascimento',$_SESSION['errosE'])){ 
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
                                    <input value="<?php if(isset($_SESSION['errosE']))echo $_SESSION['post']['nr_celular']; ?>" type="text" name="nr_celular" id="nr_celular" <?php echo (isset($_SESSION['errosE']) && in_array('nr_celular',$_SESSION['errosE'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                    <?php 
                                    if(isset($_SESSION['errosE']) && in_array('nr_celular',$_SESSION['errosE'])){ 
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
                                    <label>Email:</label>
                                </td>
                                <td>
                                    <input value="<?php if(isset($_SESSION['errosE']))echo $_SESSION['post']['ds_emailproprietario']; ?>" type="text" name="ds_emailproprietario" id="ds_emailproprietario" size="50" maxlength="50" <?php echo (isset($_SESSION['errosE']) && in_array('ds_emailproprietario',$_SESSION['errosE'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                    <?php 
                                    if(isset($_SESSION['errosE']) && in_array('ds_emailproprietario',$_SESSION['errosE'])){ 
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
                                    <label>Reberá os candidatos?</label>
                                </td>
                                <td>
                                    <input type="radio" name="ao_recrutador" class="campo" value="S" checked />
                                    <label>Sim &nbsp;&nbsp;<font style="font-size:11px">(receberá e-mail com as indicações de candidatos para as vagas disponibilizadas pela empresa)</font></label><br>
                                    <input type="radio" name="ao_recrutador" class="campo" value="N" <?php if(isset($_SESSION['errosE']) && $_SESSION['post']['ao_recrutador'] == 'N') echo 'checked';?> />
                                    <label>Não</label>         
                                    <?php 
                                    if(isset($_SESSION['errosE']) && in_array('ao_recrutador',$_SESSION['errosE'])){ 
                                    ?>
                                        <span class="style1">* Preencha corretamente este campo</span>
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>

                            <?php
                            /* if(isset($_SESSION['errosE'])){
                            ?>
                            <!--<tr>
                                    <td><span class="style1">*</span></td>
                                    <td>
                                        <label>Status:</label>
                                    </td>
                                    <td>
                                        <input type="radio" name="ao_status" class="campo" value="S" checked />
                                        <label>Ativo</label>
                                        <input type="radio" name="ao_status" class="campo" value="N" <?php if(isset($_SESSION['errosE']) && $_SESSION['post']['ao_status'] == 'N') echo 'checked';?> />
                                        <label>Inativo</label>
                                    </td>
                                </tr>-->
                            <?php
                            } */
                            ?>

                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td><span class="style1">Campos com * são obrigatórios!</span></td>
                            </tr>

                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                        <table>
                            <tr>
                                <td colspan="2">
                                    <input class="botao" type="submit" value="Cadastrar" />
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
ControleSessao::destruirVariavel('errosE');
ControleSessao::destruirVariavel('post');
ControleSessao::destruirVariavel('msg');
?>