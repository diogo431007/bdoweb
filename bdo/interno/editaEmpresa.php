<?php
require_once 'header.php';
require_once 'funcoes.php';
//header("Content-Type: text/html; charset=ISO-8859-1",true);
//if(in_array(S_ALTERACAO_EMPRESA , $_SESSION[SESSION_ACESSO])){
?>

<div id="conteudo">
 <!--<img id="cabecalho-logo" alt="Brasão da Prefeitura" src="imagens/Orange wave.png"> </img>-->
    <div class="subtitulo">Banco de Oportunidades</div>
        <div id="principal">
            <ul>
                <?php if(in_array(S_PESQUISA_EMPRESA , $_SESSION[SESSION_ACESSO])){ ?>
                    <li>
                        <a href="#parte-06"><span>Dados da Empresa</span></a>
                    </li>    
                <?php } ?>

                <?php if(in_array(S_SINALIZAR_ADMISSAO , $_SESSION[SESSION_ACESSO])){ ?>
                    <li>
                        <a href="#parte-07"><span>Sinalizar Admissão</span></a>
                    </li>
                <?php } ?>
                <li>
                    <a href="busca.php#parte-06"><span>Nova Pesquisa</span></a>
                </li>
            </ul>
            <?php 
            if(in_array(S_PESQUISA_EMPRESA , $_SESSION[SESSION_ACESSO])){
                if(!in_array(S_ALTERACAO_EMPRESA , $_SESSION[SESSION_ACESSO])){ 
                    $readonly = 'readonly';
                    $disabled = 'disabled';
                } 
                ?>
                    <div id="parte-06">
                    <?php
                    $id = $_GET['edita'];
                    
                    if($id != ""){
                        $sql = "SELECT * FROM empresa WHERE id_empresa = $id";
                    
                        $query = mysql_query($sql);
                        //echo $sql;die;
                        while($row = mysql_fetch_object($query)){
                            $login = $row->ds_email;
                            
                            $_SESSION['id_empresa'] = $row->id_empresa;
                    ?>
                        <form name="editaEmpresa" id="editaEmpresa" method="post" action="javascript:func()">
                            <div id="emp_load"></div>
                            <div id="emp_ok"></div>
                            <div id="emp_error"></div>
                                <input name="id_empresa" id="id_empresa" type="hidden" value="<?php echo $row->id_empresa ?>" />
        
                                <fieldset>
                                    <legend class="legend">Dados da empresa</legend>
                                    <?php if(in_array(S_VISUALIZAR_EMP, $_SESSION[SESSION_ACESSO])){ ?>
                                        <div align="right" class="visualizaEmp">
                                            <input type="button" class="botao" value="Acessar Empresa" onclick="location.href='../publico/controle/ControleEmpresa.php?op=visualizarEmp';" />
                                        </div>
                                    <?php } ?>
                                     <table class="tabela">
                                        <tr>
                                            <td width="1%"><span class="style1">*</span></td>
                                            <td width="29%">Razão Social:</td>
                                            <td width="70%"><input class="campo" type="text" <?php echo $readonly;?> name="nm_razaosocial" id="nm_razaosocial" value="<?php echo $row->nm_razaosocial; ?>" size="50" maxlength="50"/></td>
                                        </tr>

                                        <tr>
                                            <td><span class="style1"></span></td>
                                            <td>Nome Fantasia:</td>
                                            <td><input class="campo" type="text" name="nm_fantasia" <?php echo $readonly;?> id="nm_fantasia" value="<?php echo $row->nm_fantasia; ?>" size="50" maxlength="50"/></td>
                                        </tr>

                                        <tr>
                                            <td><span class="style1">*</span></td>
                                            <td>CNPJ:</td>
                                            <td><input readonly class="campo" type="text" name="nr_cnpj" id="cnpj" value="<?php echo $row->nr_cnpj;?>" size='20' maxlength='18'/> </td>
                                        </tr>

                                        <tr>
                                            <td><span class='style1'>*</span></td>
                                            <td>
                                              <label>Ramo de Atividade:</label>
                                            </td>
                                            <td>
                                                <select name="id_ramoatividade" id="id_ramoatividade" class="campo select" <?php echo $disabled;?>>
                                                    <option value="">Selecione</option>
                                                    <?php
                                                    $sql = "SELECT * FROM ramoatividade ORDER BY nm_ramoatividade ASC";
                                                    $query = mysql_query($sql);
                                                    while($row_ramo = mysql_fetch_object($query)){
                                                    ?>
                                                        <option value="<?php echo $row_ramo->id_ramoatividade; //salva o nome no banco?>" <?php if ($row_ramo->id_ramoatividade == $row->id_ramoatividade) echo 'selected'; ?>>  
                                                            <?php
                                                            echo $row_ramo->nm_ramoatividade; //mostra as opç?es para o usuário
                                                            ?>
                                                        </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td><span class='style1'>*</span></td>
                                            <td>
                                              <label>Tipo de Empresa:</label>
                                            </td>
                                            <td>
                                                <select name="id_empresatipo" id="id_empresatipo" class="campo select" <?php echo $disabled;?>>
                                                    <option value="">Selecione</option>
                                                    <?php
                                                    $sqlEmpresaTipo = "SELECT * FROM empresatipo ORDER BY id_empresatipo ASC";
                                                    $queryEmpresaTipo = mysql_query($sqlEmpresaTipo);
                                                    while($row_empt = mysql_fetch_object($queryEmpresaTipo)){
                                                    ?>
                                                        <option value="<?php echo $row_empt->id_empresatipo; //salva o nome no banco?>" <?php if ($row_empt->id_empresatipo == $row->id_empresatipo) echo 'selected'; ?>>  
                                                            <?php
                                                            echo $row_empt->nm_empresatipo; //mostra as opç?es para o usuário
                                                            ?>
                                                        </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td><span class='style1'>*</span></td>
                                            <td>
                                              <label>Quantidade de Funcionários:</label>
                                            </td>
                                            <td>
                                                <select name="id_quantidadefuncionario" id="id_quantidadefuncionario" class="campo select" <?php echo $disabled;?>>
                                                    <option value="">Selecione</option>
                                                    <?php
                                                    $sqlQuantidadeFuncionario = "SELECT * FROM quantidadefuncionario ORDER BY id_quantidadefuncionario ASC";
                                                    $queryQuantidadeFuncionario = mysql_query($sqlQuantidadeFuncionario);
                                                    while($row_qtdfunc = mysql_fetch_object($queryQuantidadeFuncionario)){
                                                    ?>
                                                        <option value="<?php echo $row_qtdfunc->id_quantidadefuncionario; //salva o nome no banco?>" <?php if ($row_qtdfunc->id_quantidadefuncionario == $row->id_quantidadefuncionario) echo 'selected'; ?>>  
                                                            <?php
                                                            echo $row_qtdfunc->nm_quantidadefuncionario; //mostra as opç?es para o usuário
                                                            ?>
                                                        </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><span class="style1">*</span></td>
                                            <td>
                                                <label>Contato:</label>
                                            </td>
                                            <td>
                                                <input <?php echo $readonly;?> type="text" name="nm_contato" id="nm_contato" value="<?php echo $row->nm_contato; ?>" class="campo" size='20' maxlength='18'/>
                                            </td>              
                                        </tr>

                                        <tr>
                                            <td><span class="style1">*</span></td>
                                            <td>
                                                <label>Telefone da empresa:</label>
                                            </td>
                                            <td>
                                                <input <?php echo $readonly;?> type="text" name="nr_telefoneempresa" id="nr_telefoneempresa" value="<?php echo $row->nr_telefoneempresa;?>" class="campo" onkeypress='return valida_numero(event);'/>
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
                                                <input <?php echo $readonly;?> type="text" name="nr_cep" value="<?php echo $row->nr_cep;?> "id="nr_cep" class="campo" size="50" maxlength="9"/>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><span class="style1">*</span></td>
                                            <td>Logradouro:</td>
                                            <td><input <?php echo $readonly;?> class="campo" type="text" name="ds_logradouro" id="ds_logradouro" value="<?php echo $row->ds_logradouro; ?>" size="50" maxlength="50"/></td>
                                        </tr>

                                        <tr>
                                            <td><span class="style1">*</span></td>
                                            <td>Número:</td>
                                            <td><input <?php echo $readonly;?> class="campo" type="text" name="nr_logradouro" id="nr_logradouro" value="<?php echo $row->nr_logradouro; ?>" onkeypress='return BloqueiaLetras(event);' size="10" maxlenght="10"</td>
                                        </tr>

                                        <tr>
                                            <td><span class="style1">*</span></td>
                                            <td>Bairro:</td>
                                            <td><input <?php echo $readonly;?> class="campo" type="text" name="ds_bairro" id="ds_bairro" value="<?php echo $row->ds_bairro; ?>" size="50" maxlenght="50"</td>
                                        </tr>

                                        <tr>
                                           <td>
                                               <span class="style1"></span>
                                           </td>
                                           <td>
                                               <label>Complemento:</label>
                                           </td>
                                           <td>
                                               <input <?php echo $readonly;?> type="text" name="ds_complemento" value=" <?php echo $row->ds_complemento; ?>" id="ds_complemento" class="campo" size="50" maxlength="50"/>
                                           </td>
                                        </tr>

                                        <tr>
                                            <td><span class="style1">*</span></td>
                                            <td>Estado:</td>
                                            <td>
                                                <select <?php echo $disabled;?> name="estadoEmp" id="estadoEmp" class="campo select">
                                                    <option value="">Selecione</option>
                                                    <?php
                                                    $sqlUfAux = "SELECT DISTINCT(id_estado) FROM cidade WHERE id_estado IN (SELECT id_estado FROM cidade WHERE id_cidade = $row->id_cidade)";
                                                    $queryAux = mysql_query($sqlUfAux);
                                                    $auxIdUf = mysql_result($queryAux,0);

                                                    $sqlUf = "SELECT * FROM estado ORDER BY nm_estado";
                                                    $query = mysql_query($sqlUf);

                                                    //echo $sqlUfAux;die;
                                                    while ($rowUf = mysql_fetch_object($query)) {
                                                    ?>
                                                        <option value="<?php echo $rowUf->id_estado;?>" <?php if ($_POST['estadoEmp'] == $rowUf->id_estado || $auxIdUf == $rowUf->id_estado) echo "selected" ?>>
                                                            <?php
                                                            echo $rowUf->nm_estado;
                                                            ?>
                                                        </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><span class="style1">*</span></td>
                                            <td>Cidade:</td>
                                            <td>
                                                <select <?php echo $disabled;?> class="campo select" name="cidadeEmp" id="cidadeEmp">
                                                    <?php
                                                    $sqlCidade = "SELECT * FROM cidade WHERE id_estado IN(SELECT id_estado FROM cidade WHERE id_cidade = $row->id_cidade)";
                                                    $queryCidade = mysql_query($sqlCidade);
                                                    if($queryCidade){
                                                        $cidades = ''; 
                                                        while ($rowCidade = mysql_fetch_object($queryCidade)) {
                                                            if($rowCidade->id_cidade == $row->id_cidade){
                                                                $cidades.= "<option selected value='$rowCidade->id_cidade'>".$rowCidade->nm_cidade."</option>";
                                                            }
                                                            $cidades.= "<option value='$rowCidade->id_cidade'>".$rowCidade->nm_cidade."</option>";
                                                        }
                                                        echo $cidades;
                                                    }
                                                    ?>
                                                </select> 
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <span class="style1">*</span>
                                            </td>
                                            <td>
                                                <label>Email da Empresa:</label>
                                            </td>
                                            <td>
                                                <input <?php echo $readonly;?> type="text" name="ds_email" value="<?php echo $row->ds_email; ?>"id="ds_email" class="campo" size="50" maxlength="50" />
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
                                                <input <?php echo $readonly;?> type="text" name="ds_site" value="<?php echo $row->ds_site; ?> "id="ds_site" class="campo" size="50" maxlength="50"/>
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
                                                <input <?php echo $readonly;?> type="text" name="nr_inscricaoestadual" value="<?php echo $row->nr_inscricaoestadual; ?> "id="nr_inscricaoestadual" class="campo" size="50" maxlength="50" onkeypress="return valida_numero(event);" />
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
                                                <input <?php echo $readonly;?> type="text" name="nr_inscricaomunicipal" value="<?php echo $row->nr_inscricaomunicipal; ?>"id="nr_inscricaomunicipal" class="campo" size="50" maxlength="20"/>
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
                                                <input <?php echo $readonly;?> type="text" name="dt_fundacao" value="<?php if(!empty($row->dt_fundacao)){ echo mysql_to_data($row->dt_fundacao); } ?>" id="dt_fundacao" onkeypress="return valida_numero(event);" onchange="formata_data(this,event);" onblur="valida_data(this.value)"  class="campo data" size="10" maxlength="10" />                                                
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
                                    <legend class="legend">Dados Pessoais</legend>
                                    <table class="tabela">
                                        <tr>
                                            <td width="1%"><span class="style1">*</span></td>
                                            <td width="29%">
                                                <label>Responsável:</label>
                                            </td>
                                            <td width="70%">
                                                <input <?php echo $readonly;?> type="text" name="nm_proprietario" value=" <?php echo $row->nm_proprietario; ?>" id="nm_proprietario" class="campo" size="50" maxlength="50" />
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><span class="style1"></span></td>
                                            <td>
                                                <label>CPF:</label>
                                            </td>
                                            <td>
                                                <input <?php echo $readonly;?> type="text" name="nr_cpf" value=" <?php echo $row->nr_cpf; ?>" id="nr_cpf" class="campo" onblur="validarCPF(this.value);" onkeypress="MascaraCpf(this);return valida_numero(event);" size="20" maxlength="14" />
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><span class="style1"></span></td>
                                            <td>
                                                <label>Data de Nascimento:</label>
                                            </td>
                                            <td>
                                                <input <?php echo $readonly;?> type="text" name="dt_nascimento" value=" <?php echo converterDataMysql($row->dt_nascimento); ?>" id="dt_nascimento" class="campo data" onkeypress="return valida_numero(event);"  onkeydown="formata_data(this, event);" onblur="valida_data(this.value)"  size="11" maxlength="10" />
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><span class="style1"></span></td>
                                            <td>
                                                <label>Telefone:</label>
                                            </td>
                                            <td>
                                                <input <?php echo $readonly;?> type="text" name="nr_celular" value=" <?php echo $row->nr_celular; ?>" id="nr_celular" class="campo" onkeypress="Mascara(this);return valida_numero(event);" maxlength="13"/>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><span class="style1"></span></td>
                                            <td>
                                                <label>Email:</label>
                                            </td>
                                            <td>
                                                <input <?php echo $readonly;?> type="text" name="ds_emailproprietario" value=" <?php echo $row->ds_emailproprietario; ?>" id="ds_emailproprietario" class="campo" size="50" maxlength="50" />
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><span class="style1">*</span></td>
                                            <td>
                                                <label>Cargo:</label>
                                            </td>
                                            <td>
                                                <input <?php echo $readonly;?> type="text" name="ds_cargo" value=" <?php echo $row->ds_cargo; ?>" id="ds_cargo" class="campo" size="50" maxlength="50" /> 
                                            </td>
                                        </tr>
                                        
                                        
                                        
                                        <tr>
                                            <td><span class="style1"></span></td>
                                            <td>
                                                <label>Status:</label>
                                            </td>
                                            <td>
                                                <input <?php echo $disabled;?> type="radio" name="ao_status" id="ao_status" value="S" checked="checked" <?php if($row->ao_status == 'S') echo "checked";?>/>Ativo
                                                <input <?php echo $disabled;?> type="radio" name="ao_status" id="ao_status" value="N" <?php if($row->ao_status == 'N') echo "checked";?>/>Inativo
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
                                    <legend class="legend">Dados de acesso:</legend>
                                        <table class="tabela">
                                        <tr>
                                             <td width="69"><label for="ds_loginportal">Login:</label></td>  
                                             <td width="546"><label><?php echo $login; ?></label></td>
                                        </tr>

                                        <tr>
                                            <td><label for="pw_senhaportal">Senha:</label></td>
                                            <td><label>Sugere-se trocar a senha no primeiro acesso.</label></td>
                                        </tr>
                                        </table>        
                                </fieldset>
           
                                <fieldset>            
                                    <legend class="legend">Moderação</legend>            
                                        <?php   
                                        $id = $_GET['edita'];
                                        if($id != "") {
                                            /*
											$sql = "SELECT 
                                                        *
                                                    FROM 
                                                        empresamoderacao
                                                    WHERE 
                                                        id_empresamoderacao=(SELECT max(id_empresamoderacao) 
                                                                                FROM empresamoderacao 
                                                                                WHERE id_empresa=$id)";*/
											$sql = "SELECT   ao_liberacao
                                                    FROM
                                                        empresa
                                                    WHERE
                                                        id_empresa = $id";

                                            $query = mysql_query($sql);

                                            if(mysql_num_rows($query) > 0){

                                                while($rowMod = mysql_fetch_object($query)) {                                                
                                            ?>

                                                    <table border="0" class="tabela">
                                                        <tr>
                                                            <td width="1%"><span class="style1">*</span></td>
                                                            <td width="29%">
                                                                <label>Liberar empresa:</label>                     
                                                            </td>
                                                            <td width="70%">
                                                                <input <?php echo $disabled; ?> onclick="testeEdita(this.value);" type="radio" name="ao_liberacao" id="ao_liberacao" value="N" <?php if ($rowMod->ao_liberacao == 'N') echo "checked";?> />Não&nbsp;&nbsp;
                                                                <input <?php echo $disabled; ?> onclick="testeEdita(this.value);" type="radio" name="ao_liberacao" id="ao_liberacao" value="S" <?php if($rowMod->ao_liberacao == 'S') echo "checked";?> />Sim
                                                            </td>
                                                        </tr>

                                                        <tr id="observacao" <?php if(isset($_POST) && $_POST['ao_liberacao'] == 'S' || $rowMod->ao_liberacao == 'S') echo "style='display: none;'"; ?>>
                                                            <td><span class="style1">*</span></td>
                                                            <td>
                                                                <label>Observação:</label>                     
                                                            </td>
                                                            <td>
                                                                <textarea name="ds_observacao" id="ds_observacao" cols="50" rows="3" class="campo"><?php echo $rowMod->ds_observacao;?></textarea>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td><span class="style1"></span></td>
                                                            <td>Quadrante:</td>
                                                            <td>
                                                                <select <?php echo $disabled; ?> name="quadranteEmp" id="quadranteEmp" class="campo select">
                                                                    <option value="">Selecione</option>
                                                                    <?php
                                                                    if(is_numeric($row->id_microregiao)){
                                                                        $sqlQuadAux = "SELECT DISTINCT(id_quadrante) FROM microregiao WHERE id_quadrante IN (SELECT id_quadrante FROM microregiao WHERE id_microregiao = $row->id_microregiao)";
                                                                        //$sqlQuadAux = "SELECT id_quadrante FROM microregiao WHERE id_microregiao = $row->id_microregiao";
                                                                        $queryAux = mysql_query($sqlQuadAux);
                                                                        $auxIdQuad = mysql_result($queryAux,0);
                                                                    }else{
                                                                        $auxIdQuad = null;
                                                                    }
                                                                    $sqlQuad = "SELECT * FROM quadrante ORDER BY nm_quadrante";
                                                                    $query = mysql_query($sqlQuad);

                                                                    //echo $sqlQUADAux;die;
                                                                    while ($rowQuad = mysql_fetch_object($query)) {
                                                                    ?>
                                                                    <option value="<?php echo $rowQuad->id_quadrante;?>" 
                                                                        <?php 
                                                                        if ($_POST['quadranteEmp'] == $rowQuad->id_quadrante){ 
                                                                            echo "selected"; 
                                                                        }else if($auxIdQuad == $rowQuad->id_quadrante){
                                                                            echo "selected"; 
                                                                        } ?>>
                                                                        <?php
                                                                        echo $rowQuad->nm_quadrante;
                                                                        ?>
                                                                    </option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>                        
                                                            </td>
                                                        </tr>            

                                                        <tr>
                                                            <td><span class="style1"></span></td>
                                                            <td>Microregião:</td>
                                                            <td>
                                                                <select <?php echo $disabled; ?> class="campo select" name="microregiaoEmp" id="microregiaoEmp">
                                                                    <?php
                                                                    if(is_numeric($row->id_microregiao)){
                                                                        $sqlMR = "SELECT * FROM microregiao WHERE id_quadrante IN(SELECT id_quadrante FROM microregiao WHERE id_microregiao = $row->id_microregiao)";
                                                                        $queryMR = mysql_query($sqlMR);
                                                                        if($queryMR){
                                                                            $microregioes = "<option value=''>Selecione</option>"; 
                                                                            while ($rowMR = mysql_fetch_object($queryMR)){
                                                                                if($rowMR->id_microregiao == $row->id_microregiao){
                                                                                    $microregioes.= "<option selected value='$rowMR->id_microregiao'>".$rowMR->nm_microregiao."</option>";
                                                                                }
                                                                                $microregioes.= "<option value='$rowMR->id_microregiao'>".$rowMR->nm_microregiao."</option>";
                                                                            }
                                                                            echo $microregioes;
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select> 
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td><span class="style1"></span></td>
                                                            <td>Poligono:</td>
                                                            <td>
                                                                <select name="poligonoEmp" id="poligonoEmp" class="campo select" <?php echo $disabled; ?>>
                                                                    <option value="">Selecione</option>
                                                                    <?php
                                                                    $sqlPoligono = "SELECT * FROM poligono ORDER BY nm_poligono ASC";
                                                                    $queryPoligono = mysql_query($sqlPoligono);                                    
                                                                    while($rowPoligono = mysql_fetch_object($queryPoligono)){
                                                                    ?>
                                                                        <option value="<?php echo $rowPoligono->id_poligono;?>" 
                                                                        <?php if($rowPoligono->id_poligono == $row->id_poligono){ echo 'selected'; }?>>  
                                                                        <?php
                                                                            echo $rowPoligono->nm_poligono;
                                                                        ?>
                                                                        </option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </td>
                                                         </tr>
                                                         
                                                         <?php if(in_array(S_COORDENADORIA , $_SESSION[SESSION_ACESSO])){ ?>
                                                         
                                                         <tr>
                                                            <td><span class="style1"></span></td>
                                                            <td><label>A empresa possui selo de inclusão e acessibilidade:</label></td>
                                                            <td>
                                                                <input type="radio" name="ao_selo" id="ao_selo" value="N" <?php if($row->ao_selo == 'N') echo "checked";?> />Não&nbsp;&nbsp;
                                                                <input type="radio" name="ao_selo" id="ao_selo" value="S" <?php if($row->ao_selo == 'S') echo "checked";?> />Sim
                                                            </td>
                                                        </tr>
                                                        
                                                        <?php } ?>

                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td><span class="style1">Campos com * são obrigatórios!</span></td>
                                                        </tr>
                                                    </table>
                                                <?php 
                                                    }

                                                } else { 
                                                ?>
                                                    <table border="0" class="tabela">
                                                        <tr>
                                                            <td><span class="style1">*</span></td>
                                                            <td width="114">
                                                                <label>Liberar empresa:</label>                     
                                                            </td>
                                                            <td width="499">
                                                                <input onclick="testeEdita(this.value);" type="radio" name="ao_liberacao" id="ao_liberacao" checked value="N" />Não<br>
                                                                <input onclick="testeEdita(this.value);" type="radio" name="ao_liberacao" id="ao_liberacao" value="S" />Sim
                                                            </td>
                                                        </tr>

                                                        <tr id="observacao" <?php if(isset($_POST) && $_POST['ao_liberacao'] == 'S') echo "style='display: none;'"; ?>>
                                                            <td><span class="style1">*</span></td>
                                                            <td>
                                                                <label>Observação:</label>                     
                                                            </td>
                                                            <td>
                                                                <textarea name="ds_observacao" id="ds_observacao" cols="50" rows="3" class="campo"><?php echo $row->ds_observacao;?></textarea>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td><span class="style1"></span></td>
                                                            <td>Quadrante:</td>
                                                            <td>
                                                                <select name="quadranteEmp" id="quadranteEmp" class="campo select">
                                                                    <option value="">Selecione</option>
                                                                    <?php
                                                                    if(is_numeric($row->id_microregiao)){
                                                                        $sqlQuadAux = "SELECT DISTINCT(id_quadrante) FROM microregiao WHERE id_quadrante IN (SELECT id_quadrante FROM microregiao WHERE id_microregiao = $row->id_microregiao)";
                                                                        //$sqlQuadAux = "SELECT id_quadrante FROM microregiao WHERE id_microregiao = $row->id_microregiao";
                                                                        $queryAux = mysql_query($sqlQuadAux);
                                                                        $auxIdQuad = mysql_result($queryAux,0);
                                                                    }else{
                                                                        $auxIdQuad = null;
                                                                    }
                                                                    $sqlQuad = "SELECT * FROM quadrante ORDER BY nm_quadrante";
                                                                    $query = mysql_query($sqlQuad);

                                                                    //echo $sqlQUADAux;die;
                                                                    while ($rowQuad = mysql_fetch_object($query)) {
                                                                    ?>
                                                                        <option value="<?php echo $rowQuad->id_quadrante;?>" 
                                                                            <?php 
                                                                            if ($_POST['quadranteEmp'] == $rowQuad->id_quadrante){ 
                                                                                echo "selected"; 
                                                                            }else if($auxIdQuad == $rowQuad->id_quadrante){
                                                                                echo "selected"; 
                                                                            } ?>>
                                                                            <?php
                                                                            echo $rowQuad->nm_quadrante;
                                                                            ?>
                                                                        </option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>                        
                                                            </td>
                                                        </tr>            

                                                        <tr>
                                                            <td><span class="style1"></span></td>
                                                            <td>Microregião:</td>
                                                            <td>
                                                                <select class="campo select" name="microregiaoEmp" id="microregiaoEmp">
                                                                    <?php
                                                                        if(is_numeric($row->id_microregiao)){
                                                                            $sqlMR = "SELECT * FROM microregiao WHERE id_quadrante IN(SELECT id_quadrante FROM microregiao WHERE id_microregiao = $row->id_microregiao)";
                                                                            $queryMR = mysql_query($sqlMR);
                                                                            if($queryMR){
                                                                                $microregioes = "<option value=''>Selecione</option>"; 
                                                                                while ($rowMR = mysql_fetch_object($queryMR)){
                                                                                    if($rowMR->id_microregiao == $row->id_microregiao){
                                                                                        $microregioes.= "<option selected value='$rowMR->id_microregiao'>".$rowMR->nm_microregiao."</option>";
                                                                                    }
                                                                                    $microregioes.= "<option value='$rowMR->id_microregiao'>".$rowMR->nm_microregiao."</option>";
                                                                                }
                                                                                echo $microregioes;
                                                                            }
                                                                        }
                                                                        ?>
                                                                </select> 
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td><span class='style1'></span></td>
                                                            <td>Poligono:</td>
                                                            <td>
                                                                <select name="poligonoEmp" id="poligonoEmp" class="campo select">
                                                                    <option value="">Selecione</option>
                                                                    <?php
                                                                    $sqlPoligono = "SELECT * FROM poligono ORDER BY nm_poligono ASC";
                                                                    $queryPoligono = mysql_query($sqlPoligono);                                    
                                                                    while($rowPoligono = mysql_fetch_object($queryPoligono)){
                                                                    ?>
                                                                        <option value="<?php echo $rowPoligono->id_poligono;?>" 
                                                                        <?php if($rowPoligono->id_poligono == $row->id_poligono){ echo 'selected'; }?>>  
                                                                        <?php echo $rowPoligono->nm_poligono; ?>
                                                                        </option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </td>
                                                         </tr>
                                                        <tr>
                                                            <td><span class="style1"></span></td>
                                                            <td>A empresa possui selo:</td>
                                                            <td>
                                                                <input type="radio" name="ao_selo" id="ao_selo" checked value="N" />Não<br>
                                                                <input type="radio" name="ao_selo" id="ao_selo" value="S" />Sim
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td><span class="style1">Campos com * são obrigatórios!</span></td>
                                                        </tr>
                                                    </table>
                                                <?php
                                                }
                                                ?>
                                </fieldset>

                                <table>
                                    <tr>
                                        <td colspan="2">
                                        <input name="cadastrar" class="botao" type="submit" id="cadastrar" value="Enviar" />
                                        <input name="limpar"  class="botao" type="reset" id="limpar" value="Limpar" />
                                        </td>
                                    </tr>
                                </table>  
        
                            </form>
            <?php
                    }else{
                        echo "<script>alert('Empresa não encontrada!');window.location = 'busca.php#parte-06';</script>";
                    }
                }
            }else{
               echo "<script>alert('Empresa não encontrada!');window.location = 'busca.php#parte-06';</script>";
            }
            ?>
            </div>
    <?php } ?>

<?php if(in_array(S_SINALIZAR_ADMISSAO , $_SESSION[SESSION_ACESSO])){ ?>
        <div id="parte-07">
            <?php
            //echo var_dump($_SESSION);
            if(!isset($_SESSION['carregar'])){
            ?>
                <fieldset>
                    <legend class="legend">Buscar</legend>
                    <form name="carregarAdmitido" id="carregarAdmitido" method="post" action="buscarCandAdmitido.php?op=buscar&id=<?php echo $id; ?>">
                   
                        <table class="tabela">
                            <tr>
                                <td><span class='style1'>*</span></td>
                                <td width="100">
                                    <Label>CPF do Admitido:</Label>
                                </td>
                                <td width="550">
                                    <input  <?php if(isset($_SESSION['errosP']) && in_array('cpf_cand', $_SESSION['errosP'])){echo 'class="campo_erro"';}else{echo 'class="campo"';}?>  value="<?php if(isset($_SESSION['errosP'])){echo $_SESSION['post']['cpf_cand'];}?>" class="campo" name="cpf_cand" id="cpf_cand" type="text" onblur="validarCPF(this.value);" onkeypress="return valida_numero(event);"  size="20" maxlength="14" />
                                    <?php
                                        if(isset($_SESSION['errosP']) && in_array('cpf_cand', $_SESSION['errosP'])){
                                    ?>
                                    <div class="style1">* Preencha corretamente este campo!</div>
                                    <?php  
                                         }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <input name="buscar" class="botao" type="submit" id="buscar" value="Buscar" />
                                </td>

                            </tr>
                        </table>
                    </form>
                </fieldset>
            <?php
            }else{
                include_once './funcoes.php';
                //echo var_dump($_SESSION); 
            ?>
                <fieldset>
                    <legend class="legend">Admissão</legend>
                    
                       <?php
                           if(isset($_SESSION['msgAdm'])){
                      ?>
                           <span class="style5">
                       <?php echo $_SESSION['msgAdm']; ?>
                           </span>
                      <?php
                           }
                      ?>
                    
                    <form name='cadastrarAdmitido' id='cadastrarAdmitido' method="post" action="buscarCandAdmitido.php?op=cadastrar&id=<?php echo $id; ?>">
                        <input name="candidato" value="<?php if(isset($_SESSION['carregar'])){ echo $_SESSION['carregar']->id_candidato;} echo $_SESSION['post']['candidato']; ?>" type="hidden" />
                        <table class="tabela">
                            <tr>
                                <td><span class='style1'>*</span></td>
                                <td>
                                    <label>Admitido:</label>
                                </td>
                                <td width='1000'>
                                    <input readonly class='campo' type="text" name="nm_cand" id="nm_cand" value="<?php if(isset($_SESSION['carregar'])){ echo $_SESSION['carregar']->nm_candidato;} echo $_SESSION['post']['nm_cand']; ?><?php // echo $_SESSION['carregar']->nm_candidato; echo $_SESSION['post']['nm_cand']; ?>" size="50" maxlength="50" /> 
                                </td>
                            </tr>

                            <tr>
                                <td><span class='style1'>*</span></td>
                                <td width="390">
                                    <Label>CPF:</Label>
                                </td>
                                <td width="450">
                                    <input readonly value="<?php if(isset($_SESSION['carregar'])){ echo $_SESSION['carregar']->nr_cpf;} echo $_SESSION['post']['cpf_cand']; ?><?php //echo $_SESSION['carregar']->nr_cpf;?>" class="campo" name="cpf_cand" id="cpf_cand" type="text" onblur="validarCPF(this.value);" onkeypress="return valida_numero(event);"  size="20" maxlength="14" />
                                </td>
                            </tr>

                            <tr>
                                <td><span class='style1'>*</span></td>
                                <td>
                                    <label>Cargo:</label>
                                </td>
                                <td>
                                    <input <?php if (isset($_SESSION['errosP']) && in_array('ds_cargo', $_SESSION['errosP'])){echo 'class="campo_erro"';}else{echo 'class="campo"';} ?>class='campo' type='text' name='ds_cargo' id='ds_cargo' value="<?php  if(isset($_SESSION['errosC'])){echo $_SESSION['post']['ds_cargo'];}?>" size="50" maxlength="50"/>
                                    <?php
                                        if(isset($_SESSION['errosC']) && in_array('ds_cargo', $_SESSION['errosC'])){
                                    ?>
                                    <div class="style1">* Preencha corretamente este campo!</div>
                                    <?php  
                                         }
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <td><span class='style1'>*</span></td>
                                <td>
                                    <label>Data Admissão:</label>
                                </td>
                                <td>
                                    <input <?php if (isset($_SESSION['errosP']) && in_array('dt_admissao', $_SESSION['errosP'])){echo 'class="campo_erro"';}else{echo 'class="campo"';} ?>class='campo' type='text' name='dt_admissao' id='dt_admissao' value='<?php if (isset($_SESSION['errosC'])){echo $_SESSION['post']['dt_admissao'];}?>' onblur="valida_data(this.value)" size="11" maxlength="10"/>
                                    <?php
                                        if(isset($_SESSION['errosC']) && in_array('dt_admissao', $_SESSION['errosC'])){
                                    ?>
                                    <div class="style1">* Preencha corretamente este campo!</div>
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
                                    <input name="cadastrar" class="botao" type="submit" id="cadastrar" value="Cadastrar" />
                                    <input name='cancelar' class='botao' type='reset' id='cancelar' value='Cancelar' onclick="window.location.reload();" />
                                </td>
                            </tr>   

                        </table>
                    </form>
                    <?php } ?>
              </fieldset>

                    <fieldset>
                    <legend class="legend">Lista de Admitidos</legend>
 
                    <div class="tab_adiciona">
                        <?php
                        
                         $sql = "SELECT 
                                    a.id_admissao,
                                    a.id_candidato,
                                    a.id_empresa,
                                    a.ds_cargo,
                                    DATE_FORMAT(a.dt_admissao, '%d/%m/%Y') as dt_admissao,
                                    c.nm_candidato,
                                    c.nr_cpf
                               FROM 
                                    admissao a,
                                    candidato c
                               WHERE 
                                    a.id_candidato = c.id_candidato and
                                    id_empresa = $id
                               ORDER BY a.dt_admissao DESC";
                         // echo $sql;
                        $query = mysql_query($sql); 
                        
                        if(mysql_num_rows($query) > 0){
                            $auxAdmissao = array();
                            while ($row = mysql_fetch_object($query)) {
                                $auxAdmissao[] = $row;
                            }
                            
                        ?>
                        <!--<div class="tab_adiciona">-->
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
                                $admissoes = listar($auxAdmissao, $qtd, $page);

                                foreach($admissoes as $a){
                                    //testa se o elemento do array n?o é nulo
                                    if(!is_null($a)){    
                            
                            ?>
                            <tr class="table_formacao_row">
                                <td align='center'><?php echo $a->nm_candidato;?></td>
                                <td align='center'><?php echo $a->ds_cargo;?></td>
                                <td align='center'><?php echo $a->nr_cpf;?></td>
                                <td align='center'><?php echo $a->dt_admissao;?></td>
                            </tr>
                        <?php
                                
                                    }
                                }
                                
                            }else{ //if(mysql_num_rows($query) > 0){
                                echo 'Não há admissões cadastradas';
                            } //else
                        ?>
                            <tr>
                                <td colspan="4" align="center">
                                    <span id="paginacao">
                                    <?php
                                    //crio a paginacao propriamente dita
                                    $ancora = "&edita=$id#parte-07";
                                    echo criarPaginacao($auxAdmissao, $qtd, $page, $ancora);
                                    ?>
                                    </span>
                                </td>
                            </tr>
                        </table>
                </div>
            </fieldset>
        </div>
    </div>
</div>
<?php
}

require_once 'footer.php';  
unset($_SESSION['row_detalhe']);
unset($_SESSION['errosP']);
unset($_SESSION['errosC']);
unset($_SESSION['post']);
unset($_SESSION['msg']);
unset($_SESSION['carregar']);
unset($_SESSION['msgAdm']);