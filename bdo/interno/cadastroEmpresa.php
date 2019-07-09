<?php
require_once 'header.php';
require_once 'funcoes.php';

if(in_array(S_CADASTRO_EMPRESA, $_SESSION[SESSION_ACESSO])){
    if ($_POST['validarEmpresa']) {
        //echo var_dump($_POST);
        $id = $_POST['id_empresa'];
        $nm_razaosocial = $_POST['nm_razaosocial'];//utf8 utilizado para remover problemas de caracteres acentuados
        $nm_fantasia = $_POST['nm_fantasia'];//utf8 utilizado para remover problemas de caracteres acentuados
        $nr_cnpj = $_POST['nr_cnpj'];
        $ds_ramo = $_POST['ds_ramo'];
        $ds_empresatipo = $_POST['ds_empresatipo'];
        $ds_quantidadefuncionario = $_POST['ds_quantidadefuncionario'];
        $nm_contato = $_POST['nm_contato'];
        $nr_telefoneempresa = $_POST['nr_telefoneempresa'];
        $nr_cep = $_POST['nr_cep'];
        $ds_logradouro = $_POST['ds_logradouro'];
        $nr_logradouro = $_POST['nr_logradouro'];
        $ds_bairro = $_POST['ds_bairro'];
        $ds_complemento = $_POST['ds_complemento'];
        $estadoEmp = $_POST['estadoEmp'];
        $cidadeEmp = $_POST['cidadeEmp'];
        $ds_email =  $_POST['ds_email'];
        $ds_site = $_POST['ds_site'];
        $nr_inscricaoestadual = $_POST['nr_inscricaoestadual'];
        $nr_inscricaomunicipal = $_POST['nr_inscricaomunicipal'];
        $dt_fundacao = $_POST['dt_fundacao'];
        $ds_loginportal = $_POST["ds_loginportal"];
        $pw_senhaportal = $_POST["pw_senhaporta"];
        $ao_interno = $_POST["ao_interno"];        
        $nm_proprietario =  $_POST['nm_proprietario'];
        $nr_cpf = $_POST['nr_cpf'];
        $dt_nascimento= $_POST['dt_nascimento'];
        $nr_celular = $_POST['nr_celular'];
        $ds_emailproprietario = $_POST['ds_emailproprietario'];
        $ao_status = $_POST['ao_status'];
        $ds_cargo = $_POST['ds_cargo'];
        $quadranteEmp = $_POST['quadranteEmp'];
        $microregiaoEmp = $_POST['microregiaoEmp'];
        $poligonoEmp = $_POST['poligonoEmp'];
        $ao_selo = $_POST['ao_selo'];
        $dt_cadastro = 'NOW()';
                
        //recebe os dados de moderação
        $id_empresamoderacao = $_POST['id_empresamoderacao'];
        $id_usuario = $_SESSION['id_usuario'];
        $ao_liberacao = $_POST['ao_liberacao'];
        $dt_moderacao = $_POST['dt_moderacao'];
        $ds_observacao = $_POST["ds_observacao"];
        
        //verificando se os campos foram preenchidos corretamente 
        if (empty($nm_razaosocial)){
           echo "Informe a Razão Social!";
        }
        elseif(strlen($nm_razaosocial) <= 4){
            echo "Razão Social inválida!";
        }
        elseif(empty ($nr_cnpj)){
            echo "Informe o CNPJ!";
        }  
        elseif(empty ($ds_ramo)){
            echo 'Informe o ramo em que a empresa atua!';
        }
        elseif(empty ($ds_empresatipo)){
            echo 'Informe o tipo da empresa!';
        }
        elseif(empty ($ds_quantidadefuncionario)){
            echo 'Informe a quantidade de funcionários da empresa!';
        }
        elseif(empty ($nm_contato)){
            echo "Informe o contato!";
        }   
        elseif(strlen($nm_contato) <= 3){
            echo "Contato Inválido!";
        }
        elseif(empty ($nr_telefoneempresa)){
            echo "Informe o telefone da empresa!";
        }
        elseif(empty ($nr_cep)){
            echo "Informe o CEP!";
        }   
        elseif (!preg_match('/^[0-9]{5,5}([- ]?[0-9]{3,3})?$/', $nr_cep)){
            echo "Cep inválido";
        }
        elseif (empty ($ds_logradouro)){
            echo "Informe o Logradouro!";
        }
        elseif (empty ($nr_logradouro)) {
            echo "Informe o Número!";
        }
        elseif (empty ($ds_bairro)){
            echo "Informe o Bairro!";
        }
        elseif (empty ($estadoEmp)){    
            echo "Selecione um Estado!";
        }
        elseif (empty ($cidadeEmp)) {
            echo "Selecione uma Cidade!";
        }
        elseif(empty ($ds_email)){
            echo "Informe o email!";
        }   
        elseif(!preg_match ("/^[A-Za-z0-9]+([_.-][A-Za-z0-9]+)*@[A-Za-z0-9]+([_.-][A-Za-z0-9]+)*\\.[A-Za-z0-9]{2,4}$/", $ds_email))  {
            echo "Digite um email válido!";
        
       // valida os dados pessoais
        }
        elseif(empty($nm_proprietario)){
            echo "Informe o nome do proprietário!"; 
        }
        elseif(empty($ds_cargo)){
            echo "Informe o cargo!";
        }
        elseif(empty($ds_emailproprietario)){
            echo "Digite um email válido!";
        }       
        elseif ($ao_liberacao == 'N' && empty($ds_observacao)){
            echo "Preencha a observação!";
        }
        else{
            if(empty($dt_fundacao)){ //testa data vazia
                $dt = 'NULL';
            }else{
                $auxDt = data_to_mysql($dt_fundacao); //convertendo o formato da data para salvar no banco
                $dt = "'$auxDt'";
            }
            
            if(empty($dt_nascimento)){
                $dt_nasc = 'NULL';
            }else{
                $auxDtNascimento = data_to_mysql($dt_nascimento);
                $dt_nasc = "'$auxDtNascimento'";
            }
            
            if(empty($microregiaoEmp)){
                $mr = 'NULL';
            }else{
                $mr = $microregiaoEmp;
            }
            
            if(empty($poligonoEmp)){
                $pol = 'NULL';
            }else{
                $pol = $poligonoEmp;
            }
            
            $ds_senhaportalemail = geraSenha();
            $ds_senhaportal = md5($ds_senhaportalemail);
            $sql = "INSERT INTO empresa (
                                id_empresa, 
                                nm_razaosocial, 
                                nm_fantasia,
                                nr_cnpj, 
                                id_ramoatividade,
                                id_empresatipo,
                                id_quantidadefuncionario,
                                nm_contato, 
                                nr_telefoneempresa, 
                                nr_cep, 
                                ds_logradouro, 
                                nr_logradouro, 
                                ds_bairro, 
                                ds_complemento, 
                                id_cidade, 
                                ds_email, 
                                ds_site, 
                                nr_inscricaoestadual, 
                                nr_inscricaomunicipal, 
                                dt_fundacao, 
                                pw_senhaportal,
                                ao_liberacao,
                                ao_interno,
                                nm_proprietario,
                                nr_cpf,
                                dt_nascimento,
                                nr_celular,
                                ds_emailproprietario,
                                ao_status,
                                ds_cargo,
                                id_microregiao,
                                id_poligono,
                                ao_selo,
                                dt_cadastro)
                      VALUES 
                         (null, '".mb_strtoupper($nm_razaosocial)."',
                                '".mb_strtoupper($nm_fantasia)."',
                                '$nr_cnpj',
                                '".mb_strtoupper($ds_ramo)."',
                                '".mb_strtoupper($ds_empresatipo)."',
                                '".mb_strtoupper($ds_quantidadefuncionario)."',
                                '".mb_strtoupper($nm_contato)."',
                                '$nr_telefoneempresa',
                                '$nr_cep',
                                '".mb_strtoupper($ds_logradouro)."', 
                                '$nr_logradouro', 
                                '".mb_strtoupper($ds_bairro)."', 
                                '".mb_strtoupper($ds_complemento)."',
                                '$cidadeEmp', 
                                '".mb_strtoupper($ds_email)."', 
                                '".mb_strtoupper($ds_site)."', 
                                '$nr_inscricaoestadual', 
                                '$nr_inscricaomunicipal', 
                                $dt,
                                '$ds_senhaportal',
                                '$ao_liberacao',
                                '".S."',
                                '".mb_strtoupper($nm_proprietario)."',
                                '$nr_cpf',
                                $dt_nasc,
                                '$nr_celular',
                                '".mb_strtoupper($ds_emailproprietario)."',
                                '".S."',
                                '".mb_strtoupper($ds_cargo)."',
                                $mr,
                                $pol,
                                '".$ao_selo."',
                                NOW() )";           
            //echo $sql;die;
            $executa_empresa = mysql_query($sql); 
            
            $id_empresa = mysql_insert_id(); // função para chamar o id gerado
            
            if($executa_empresa){

//            if(is_array($_POST['nm_proprietario'])){
//                foreach ($_POST['nm_proprietario'] as $i => $proprietario) {
//                    
//                    if($_POST["dt_nascimento"][$i] != ''){
//                        $dataNascimento = "'".data_to_mysql($_POST["dt_nascimento"][$i])."'";
//                    }else{
//                        $dataNascimento = 'null';
//                    }
//                    $sql_proprietario= "INSERT INTO empresadetalhe ( 
//                                            nm_proprietario,
//                                            nr_cpf,
//                                            dt_nascimento,
//                                            nr_celular,
//                                            ds_emailproprietario,
//                                            id_empresa,
//                                            ao_status,
//                                            ds_cargo
//                                           
//                                      )
//                                      VALUES ( 
//                                                '" . mb_strtoupper($proprietario) . "',
//                                                '" . $_POST['nr_cpf'][$i] . "',
//                                                " . $dataNascimento . ",
//                                                '" . $_POST['nr_celular'][$i] . "',
//                                                '" . mb_strtoupper($_POST['ds_emailproprietario'][$i]) . "',
//                                                " . $id_empresa . ",
//                                                '".S."',
//                                                '". mb_strtoupper($_POST['ds_cargo'][$i])."'
//                                      )";
//                   // echo $sql_proprietario;die;
//                    $executa_proprietario = mysql_query($sql_proprietario);
//                }
//            }      
               
            $auxObs = ($ao_liberacao == 'S') ? 'null' : "'".$ds_observacao."'";
            
            $sql_empresamoderacao = "INSERT INTO empresamoderacao 
                                                VALUES(null,
                                                        '".$_SESSION['id_usuario']."',
                                                        '".$id_empresa."', 
                                                        '$ao_liberacao',
                                                        now(),
                                                        ".mb_strtoupper($auxObs)."
                                                        )";
          //  echo $sql_empresamoderacao;die;
            $executa_empresa = mysql_query($sql_empresamoderacao);
       
                    //limpa sessao do post
                    unset($_POST);
                    //redireciona
                    echo "<script>alert('Cadastro concluído');window.location = 'cadastro.php#parte-06';</script>";
             
        // Se houver algum erro ao inserir
            }else{
                echo "<script>alert('Não foi possível realizar o cadastro, tente mais tarde!');window.location = 'cadastro.php#parte-06';</script>";
            }
       //===========Envia Email================//
            if($ao_liberacao == 'S'){
                include_once './Email.class.php';
                $assunto = 'Cadastro Sistema Banco de Oportunidades';
                $corpo = 'Seu cadastro foi realizado com sucesso!.<br>
                   Seguem credenciais de acesso:<br>
                   www.canoastec.rs.gov.br/bancodeoportunidades<br>
                   Login de Acesso:'.$ds_email.'<br>
                   Senha:'.$ds_senhaportalemail;
               Email::enviarEmail($ds_email, $assunto, $corpo, $nm_razaosocial);
               $id = mysql_insert_id();
               }
        } 
    }
?>
<form  name="cadastroEmpresa" id="cadastroEmpresa"  method="post" action="cadastro.php#parte-06" >
<input type="hidden" name="validarEmpresa" value='1'>
<div id="emp_load"></div>
<div id="emp_ok"></div>
<div id="emp_error"></div>

    <fieldset>
        <legend class="legend">Dados da Empresa</legend>
            <table border="0" class="tabela">
            <tr>
                <td><span class="style1">*</span></td>
                <td width="120">
                    <label>Razão Social:</label>
                </td>
                <td>
                    <input class="campo" type="text" name="nm_razaosocial" id="nm_razaosocial" value="<?php if($_POST){ echo $_POST['nm_razaosocial'];} ?>" size="50" maxlength="50" />
                </td>
            </tr>
            <tr>
                <td><span class="style1"></span></td>
                <td>
                    <label>Nome da Fantasia:</label>
                </td>
                <td>
                    <input class="campo" type="text" name="nm_fantasia" id="nm_fantasia" value="<?php if($_POST){ echo $_POST['nm_fantasia'];} ?>" size="50" maxlength="50" />
                </td>
            </tr>
            <tr>
                <td><span class="style1">*</span></td>
                <td>
                    <label>CNPJ:</label>
                </td>
                <td>                                                                                                                                                  
                    <input type="text" name="nr_cnpj" value="<?php if($_POST['nr_cnpj']){ echo $_POST['nr_cnpj'];} ?>" id="nr_cnpj" class="campo" size='20' maxlength='18' onblur="ValidarCNPJ(this.value);" onkeypress=" return BloqueiaLetras(this.value);"  />
                </td>
            </tr>
            
            <tr>
                <td><span class='style1'>*</span></td>
                <td>
                    <label>Ramo de Atividade:</label>
                </td>
                <td>
                    <select name="ds_ramo" id="ds_ramo" class="campo select">
                         <option value="">Selecione</option>
                         <?php
                            $sql = "SELECT * FROM ramoatividade 
                                    ORDER BY nm_ramoatividade ASC";
                            $query = mysql_query($sql);
                           while($row = mysql_fetch_object($query)){
                            ?>
                               <option value="<?php echo $row->id_ramoatividade; ?>" <?php if($row->id_ramoatividade == $_POST['ds_ramo']) echo 'selected'; ?>><?php echo $row->nm_ramoatividade; ?></option>
                               <?php
                           }
                         ?>
                    </select>
                </td>
            </tr>
            
            <tr>
                <td><span class='style1'>*</span></td>
                <td>
                    <label>Tipo de Empresa</label>
                </td>
                <td>
                    <select name="ds_empresatipo" id="ds_empresatipo" class="campo select">
                         <option value="">Selecione</option>
                         <?php
                            $sqlEmpresaTipo = "SELECT * FROM empresatipo 
                                    ORDER BY id_empresatipo ASC";
                            $queryEmpresaTipo = mysql_query($sqlEmpresaTipo);
                           while($rowEmpresaTipo = mysql_fetch_object($queryEmpresaTipo)){
                            ?>
                               <option value="<?php echo $rowEmpresaTipo->id_empresatipo; ?>" <?php if($rowEmpresaTipo->id_empresatipo == $_POST['ds_empresatipo']) echo 'selected'; ?>><?php echo $rowEmpresaTipo->nm_empresatipo; ?></option>
                               <?php
                           }
                         ?>
                    </select>
                </td>
            </tr>
            
            <tr>
                <td><span class='style1'>*</span></td>
                <td>
                    <label>Quantidade de Funcionários</label>
                </td>
                <td>
                    <select name="ds_quantidadefuncionario" id="ds_quantidadefuncionario" class="campo select">
                         <option value="">Selecione</option>
                         <?php
                            $sqlQuantidadeFuncionario = "SELECT * FROM quantidadefuncionario 
                                    ORDER BY id_quantidadefuncionario ASC";
                            $queryQuantidadeFuncionario = mysql_query($sqlQuantidadeFuncionario);
                           while($rowQuantidadeFuncionario = mysql_fetch_object($queryQuantidadeFuncionario)){
                            ?>
                               <option value="<?php echo $rowQuantidadeFuncionario->id_quantidadefuncionario; ?>" <?php if($rowQuantidadeFuncionario->id_quantidadefuncionario == $_POST['ds_quantidadefuncionario']) echo 'selected'; ?>><?php echo $rowQuantidadeFuncionario->nm_quantidadefuncionario; ?></option>
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
                    <input type="text" name="nm_contato" id="nm_contato" value="<?php if($_POST['nm_contato']){ echo $_POST['nm_contato'];} ?>" class="campo" size='20' maxlength='18'/>
                </td>
            </tr>
            
            <tr>
                <td><span class="style1">*</span></td>
                <td>
                    <label>Telefone da empresa:</label>
                </td>
                <td>
                    <input type="text" name="nr_telefoneempresa" id="nr_telefoneempresa" value="<?php echo $_POST['nr_telefoneempresa'];?>" class="campo"/>
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
                    <input type="text" name="nr_cep" value="<?php echo $_POST['nr_cep'] ?>" id="nr_cep" class="campo" maxlength='9' onBlur="ValidaCep(this.value)" onkeypress="return BloqueiaLetras(this.value);" />
                </td>
            </tr>
            
            <tr>
                <td> <span class="style1">*</span></td>
                <td>
                  <label> Logradouro: </label>                     
              </td>
              <td>
                  <input type="text" name="ds_logradouro" value="<?php echo $_POST['ds_logradouro'] ?>" id="ds_logradouro" class="campo" size="50" maxlength="50"/>
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
                    <input type="text" name="nr_logradouro" value="<?php if($_POST ['nr_logradouro']) { echo $_POST['nr_logradouro'];} ?>" id="nr_logradouro" class="campo" size="10" maxlength="10" onkeypress="return valida_numero(event);"/>
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
                    <input type="text" name="ds_bairro" value="<?php echo $_POST['ds_bairro'] ?> "id="ds_bairro" class="campo" size="50" maxlength="50"/>
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
                    <input type="text" name="ds_complemento" value="<?php echo $_POST['ds_complemento'] ?> " id="ds_complemento" class="campo" size="50" maxlength="50"/>
                </td>
            </tr>
            
            <tr>
                <td>
                    <span class="style1">*</span>
                </td> 
                <td>
                    <label>Estado:</label>
                </td>
                
                <td>
                     <select name="estadoEmp" id="estadoEmp" class="campo select">
                         <option value="">Selecione</option>
                         <?php
                            $sqlUf="select * from estado order by nm_estado asc";
                            $query=  mysql_query($sqlUf);
                            while($rowUf = mysql_fetch_object($query)){
                             ?>    
                            <option value="<?php echo $rowUf->id_estado;?>" <?php if($rowUf->id_estado == $_POST['estadoEmp']){ echo 'selected';} ?>>
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
                <td>Cidade</td>
                <td>
                    <select name="cidadeEmp" id="cidadeEmp" class="campo select">
                        <?php 
                            if($_POST['cidadeEmp'] != ''){
                            $sqlCid="select * from cidade where id_estado = ". $_POST['estadoEmp']." order by nm_cidade asc";
                            $query= mysql_query($sqlCid);
                            while($rowCid = mysql_fetch_object($query)){
                         ?>     
                        <option value="<?php echo $rowCid->id_cidade;?>" <?php if($rowCid->id_cidade == $_POST['cidadeEmp']) { echo 'selected';} ?>>
                            <?php
                                echo $rowCid->nm_cidade;
                                ?>
                        </option>
                        
                      <?php
                            }}
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
                    <input type="text" name="ds_email" value="<?php echo $_POST['ds_email'] ?>" id="ds_email" class="campo" size="50" maxlength="50"/>
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
                    <input type="text" name="ds_site"  id="ds_site" value="<?php echo $_POST['ds_site'] ?>"  class="campo" size="50" maxlength="50"/>
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
                    <input type="text" name="nr_inscricaoestadual" value="<?php echo $_POST['nr_inscricaoestadual'] ?> "id="nr_inscricaoestadual" class="campo" size="50" maxlength="50" onkeypress="return valida_numero(event);" />
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
                    <input type="text" name="nr_inscricaomunicipal" value="<?php echo $_POST['nr_inscricaomunicipal'] ?> "id="nr_inscricaomunicipal" class="campo" size="50" maxlength="20"/>
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
                    <input type="text" name="dt_fundacao" id="dt_fundacao" class="campo" value="<?php echo $_POST['dt_fundacao'] ?>" onblur="valida_data(this.value)" size="11" maxlength="10" onkeydown="formata_data(this,event)" />
                </td>
            </tr>
            
               <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><span class="style1">Campos com * são obrigatórios!</span></td>
                </tr>
            
        </table>
    </fieldset>

    <!-- ################ Dados Pessoais  ##################### -->

    <fieldset>
        <legend class="legend">Dados Pessoais</legend>
            <div id="origem_proprietario">
                <table  class="tabela">
                    <tr>
                        <td><span class="style1">*</span></td>
                        <td  width="173">
                            <label>Responsável:</label>
                        </td>
                        <td>
                            <input type="text" name="nm_proprietario" id="nm_proprietario" value="<?php echo $_POST['nm_proprietario'];?>" class="campo" size="50" maxlength="50"/>
                        </td>
                    </tr>

                    <tr>
                        <td><span class="style1"></span></td>
                        <td>
                            <label>CPF:</label>
                        </td>
                        <td>
                            <input type="text" name="nr_cpf" id="nr_cpf" value="<?php echo $_POST['nr_cpf'];?>" class="campo"  onblur="validarCPF(this.value);" onkeypress="MascaraCpf(this); return valida_numero(event);"  size="20" maxlength="14" />

                        </td>
                    </tr>

                    <tr>
                        <td><span class="style1"></span></td>
                        <td>
                            <label>Data de Nascimento:</label>
                        </td>
                        <td>
                            <input type="text" name="dt_nascimento" id="dt_nascimento" value="<?php echo $_POST['dt_nascimento'];?>" class="campo data" onkeypress="return valida_numero(event);" onkeydown="formata_data(this, event);" onblur="valida_data(this.value)" size="11" maxlength="10"/> 
                        </td>
                    </tr>

                    <tr>
                        <td><span class="style1"></span></td>
                        <td>
                            <label>Telefone:</label>
                        </td>
                        <td>
                            <input type="text" name="nr_celular" id="nr_celular" value="<?php echo $_POST['nr_celular'];?>"  class="campo"  onkeypress="Mascara(this);return valida_numero(event);" maxlength="13"/>
                        </td>
                    </tr>

                    <tr>
                        <td><span class="style1">*</span></td>
                        <td>
                            <label>Email:</label>
                        </td>
                        <td>
                            <input type="text" name="ds_emailproprietario" id="ds_emailproprietario" value="<?php echo $_POST['ds_emailproprietario'];?>" class="campo" size="50" maxlength="50"/>

                        </td>
                    </tr>

                    <tr>
                        <td><span class="style1">*</span></td>
                        <td>
                            <label>Cargo:</label>
                        </td>
                        <td>
                            <input type='text' name='ds_cargo' id='ds_cargo' value="<?php echo $_POST['ds_cargo'];?>" class='campo' size='50' maxlength='30'/>
                        </td>
                    </tr>                

                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><span class="style1">Campos com * são obrigatórios!</span></td>
                    </tr>                
                </table>   
            </div> 
    </fieldset>
    
    <fieldset>
        <legend class="legend">Moderação</legend>
            <table border="0" class="tabela">
                <tr>
                    <td><span class="style1">*</span></td>
                    <td width="170">
                        <label>Liberar empresa:</label>                     
                    </td>
                    <td width='439'>
                        <input onclick="teste(this.value);" type="radio" name="ao_liberacao" id="ao_liberacao" value="N" checked="checked" <?php if ($_POST['ao_liberacao'] == 'N') echo "checked"?>/>Não <br>
                        <input onclick="teste(this.value);" type="radio" name="ao_liberacao" id="ao_liberacao" value="S" <?php if ($_POST['ao_liberacao'] == 'S') echo "checked"?>/>Sim
                    </td>
                </tr>

                <tr id="ds_observacao" <?php if(isset($_POST) && $_POST['ao_liberacao'] == 'S') echo "style='display: none;'"; ?>>
                    <td><span class="style1">*</span></td>
                    <td>
                        <label>Observação:</label>                  
                    </td>
                    <td>
                        <textarea name="ds_observacao" id="ds_observacao" cols="50" rows="3" class="campo"><?php echo $_POST['ds_observacao']?></textarea>
                    </td>
                </tr>
                
                <tr>
                    <td><span class="style1"></span></td>
                    <td width="170">
                        <label>Quadrante:</label>
                    </td>
                    <td width="439">
                        <select name="quadranteEmp" id="quadranteEmp" class="campo select">
                        <option value="">Selecione</option>
                        <?php
                            $sqlQUAD="select * from quadrante order by nm_quadrante asc";
                            $queryQUAD =  mysql_query($sqlQUAD);
                            while($row = mysql_fetch_object($queryQUAD)){
                        ?>    
                            <option value="<?php echo $row->id_quadrante;?>" <?php if($row->id_quadrante == $_POST['quadranteEmp']){ echo 'selected';} ?>>
                               <?php
                                   echo $row->nm_quadrante;
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
                        <select name="microregiaoEmp" id="microregiaoEmp" class="campo select">
                        <?php 
                        if($_POST['microregiaoEmp'] != ''){
                        $sqlMR=" SELECT * FROM microregiao 
                                 WHERE id_microregiao = ". $_POST['quadranteEmp']." 
                                 ORDER BY nm_microregiao ASC ";
                        $queryMR= mysql_query($sqlMR);
                            while($row = mysql_fetch_object($queryMR)){
                        ?>     
                            <option value="<?php echo $row->id_microregiao;?>" <?php if($row->id_microregiao == $_POST['microregiaoEmp']) { echo 'selected';} ?>>
                                <?php
                                    echo $row->nm_microregiao;
                                ?>
                            </option>
                        <?php
                            }
                        }
                        ?>
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td><span class="style1"></span></td>
                    <td width="170">
                        <label>Poligono:</label>
                    </td>
                    <td width="439">
                        <select name="poligonoEmp" id="poligonoEmp" class="campo select">
                        <option value="">Selecione</option>
                        <?php
                            $sqlPoligono="select * from poligono order by nm_poligono asc";
                            $queryPoligono =  mysql_query($sqlPoligono);
                            while($row = mysql_fetch_object($queryPoligono)){
                        ?>    
                            <option value="<?php echo $row->id_poligono;?>" <?php if($row->id_poligono == $_POST['poligonoEmp']){ echo 'selected';} ?>>
                               <?php
                                   echo $row->nm_poligono;
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
                    <td width="170">
                        <label>A empresa possui selo:</label>                     
                    </td>
                    <td width='439'>
                        <input type="radio" name="ao_selo" id="ao_selo" value="N" checked="checked" <?php if ($_POST['ao_selo'] == 'N') echo "checked"?>/>Não <br>
                        <input type="radio" name="ao_selo" id="ao_selo" value="S" <?php if ($_POST['ao_selo'] == 'S') echo "checked"?>/>Sim
                    </td>
                </tr>
            </table>
    </fieldset>
    </br>
    <input name="cadastrar" class="botao" type="submit" id="cadastrar" value="Enviar" />
    <input name="limpar" class="botao" type="reset" id="limpar" value="Limpar" />    
</form>

<?php
}else{
    session_destroy();
    header('Location:index.php');
}
?>