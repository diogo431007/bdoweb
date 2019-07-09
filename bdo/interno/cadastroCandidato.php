<div id="cand_load"></div>
<div id="cand_error"></div>
<div id="cand_ok"></div>

<?php
if(in_array(S_CADASTRO_CANDIDATO , $_SESSION[SESSION_ACESSO])){

include("funcoes.php");
if ($_POST['validar']) {

//recebe os dados pessoais
    $nome = $_POST["nome_cand"];
    $cpf = $_POST["cpf_cand"];
    $rg = $_POST["rg_cand"];
    $ctps = $_POST["ctps_cand"];
    $nr_serie = $_POST['nr_serie'];
    $estado_ctps = $_POST['estado_ctps'];
    $ds_cnh = $_POST['cnh_cand'];
    $email = $_POST["email_cand"];
    $telefone = $_POST["tel_cand"];
    $celular = $_POST["cel_cand"];
    $estadocivil = $_POST["estciv_cand"];
    $sexo = $_POST["sexo_cand"];
    $nacio = $_POST["nacio_cand"];
    $nr_cepcand = $_POST["nr_cepcand"];
    $logradouro = $_POST["logra_cand"];
    $numero = $_POST["num_cand"];
    $complemento = $_POST["comp_cand"];
    $bairro = $_POST["bairro_cand"];
    $cidade = $_POST["cidade_cand"];
    $estado = $_POST["estado_cand"];
    //$profissao = $_POST["pro_cand"];
    $deficiencia = $_POST["def_cand"];
    $objetivo = $_POST["obj_cand"];
    $dtanascimento = $_POST["dtanasc_cand"];



//recebe os dados das áreas de interesse;
    $profissoes= $_POST['profissoes'];

//recebe os dados da formacao
    $id = $_POST['id_formacao'];
    $form_cand = $_POST['form_cand'];
    $dtatermform_cand = $_POST['dtatermform_cand'];
    $escolaform_cand = $_POST['escolaform_cand'];
    $cidesc_cand = $_POST['cidesc_cand'];
    $ds_curso = $_POST['curso_cand'];
    $ds_semestre = $_POST['semestre_cand'];

//recebe os dados de qualificacao
    $descquali_cand = $_POST['descquali_cand'];
    $instquali_cand = $_POST['instquali_cand'];
    $dtatermquali_cand = $_POST['dtatermquali_cand'];
    $qnthsquali_cand = $_POST['qnthsquali_cand'];

//recebe os dados de experiencia
    $dtainiexp_cand = $_POST['dtainiexp_cand'];
    $dtaterexp_cand = $_POST['dtaterexp_cand'];
    $empresaexp_cand = $_POST['empresaexp_cand'];
    $prinativexp_cand = $_POST['prinativexp_cand'];
//recebe os dados de login
//    $ds_loginportal = $_POST['ds_loginportal'];
//    $ds_senhaportal = $_POST['ds_senhaportal'];
//    $ao_interno = $_POST['ao_interno'];


//valida os dados pessoais
    if (empty($nome)) {
        echo "<script>alert('Preencha o campo Nome');window.location = 'cadastro.php#parte-00';</script>";
    } else if (strlen($nome) <= 3) {
        echo "Digite o nome completo";
    } else if (empty($cpf)) {
        echo "<script>alert('Preencha o campo CPF');window.location = 'cadastro.php#parte-00';</script>";
    } else if (strlen($cpf) > 14) {
        echo "<script>alert('Digite um CPF válido!');window.location = 'cadastro.php#parte-00';</script>";
    }elseif(empty ($email)){
       echo "<script>alert('Informe o email!');window.location = 'cadastro.php#parte-00';</script>";
    }elseif  (!preg_match ("/^[A-Za-z0-9]+([_.-][A-Za-z0-9]+)*@[A-Za-z0-9]+([_.-][A-Za-z0-9]+)*\\.[A-Za-z0-9]{2,4}$/", $email))  {
       echo "<script>alert('Digite um email válido');window.location = 'cadastro.php#parte-00';</script>";
    } else if (empty($dtanascimento)) {
        echo "<script>alert('Preencha o campo Data de nascimento');window.location = 'cadastro.php#parte-00';</script>";
    }
//    else if (empty($profissao)) {
//        echo "<script>alert('Preencha o campo profissão');window.location = 'cadastro.php#parte-00';</script>";
//    }

//valida os dados de formacao
      else if (empty($form_cand)) {
        echo "<script>alert('Selecione a escolaridade');window.location = 'cadastro.php#parte-00';</script>";
    } else if (in_array('', $form_cand)) {
        echo "<script>alert('Selecione a escolaridade');window.location = 'cadastro.php#parte-00';</script>";
    } else if (in_array('Selecione...', $form_cand)) {
        echo "<script>alert('Selecione a escolaridade');window.location = 'cadastro.php#parte-00';</script>";
    } else if (($id == 6 || $id == 7 || $id == 8) && empty($ds_curso)){
        echo "<script>alert('Informe o curso');window.location = 'cadastro.php#parte-00';</script>";
    } else if (($id == 6 || $id == 7) && empty($ds_semestre)){
        echo "<script>alert('Informe o semestre');window.location = 'cadastro.php#parte-00';</script>";
    } else {
        // Se não houver nenhum erro
        // Inserimos no banco de dados os dados do candidato
        $dt = data_to_mysql($dtanascimento);
        $idDef = (empty($deficiencia)) ? 'null' : $deficiencia;
        $auxEstadoCivil = (empty($estadocivil)) ? 'null' : "'$estadocivil'";
        $auxIdCidade = (empty($cidade)) ? 'null' : $cidade;
        $auxEstadoCtps = (empty($estado_ctps)) ? 'null' : $estado_ctps;
        $auxCnh = (empty($ds_cnh)) ? 'null' : "'".$ds_cnh."'";
        $ds_senhaportalemail = geraSenha();
        $ds_senhaportal = md5($ds_senhaportalemail);
        $sql_candidato = "INSERT INTO
                                candidato (
                                id_usuarioinclusao,
                                nm_candidato,
                                ds_email,
                                nr_telefone,
                                nr_celular,
                                ds_estado_civil,
                                ao_sexo,
                                ds_nacionalidade,
                                ds_profissao,
                                nr_cep,
                                ds_logradouro,
                                nr_logradouro,
                                ds_complemento,
                                ds_bairro,
                                dt_nascimento,
                                id_deficiencia,
                                ds_objetivo,
                                nr_cpf,
                                nr_rg,
                                dt_cadastro,
                                dt_validade,
                                nr_ctps,
                                id_cidade,
                                nr_serie,
                                id_estadoctps,
                                ds_loginportal,
                                pw_senhaportal,
                                ao_interno,
                                ds_cnh)
                            VALUES (
                                " . $_SESSION['id_usuario'] . ",
                                '".mb_strtoupper($nome)."',
                                '".mb_strtoupper($email)."',
                                '$telefone',
                                '$celular',
                                $auxEstadoCivil,
                                '$sexo',
                                '".mb_strtoupper($nacio)."',
                                '$nr_cepcand',
                                '".mb_strtoupper($logradouro)."',
                                '$numero',
                                '".mb_strtoupper($complemento)."',
                                '".mb_strtoupper($bairro)."',
                                '$dt',
                                '".mb_strtoupper($profissao)."',
                                 $idDef,
                                 '".mb_strtoupper($objetivo)."',
                                '$cpf',
                                '$rg',
                                 now(),
                                 CURDATE() + INTERVAL 60 DAY,
                                '$ctps',
                                $auxIdCidade,
                                '$nr_serie',
                                $auxEstadoCtps,
                                '".mb_strtoupper($email)."',
                                '$ds_senhaportal',
                                'S',
                                $auxCnh)";
echo $sql_candidato;die;
        $executa_candidato = mysql_query($sql_candidato);
        die(mysql_error()." ".$dt);
        // A varivel $idCandidato é preenchida com o id do candidato

        if($executa_candidato){
            //===========Envia Email================//
            include_once './Email.class.php';
               $assunto = 'Cadastro no Sistema Banco de Oportunidades';
               $corpo = 'Seu cadastro foi realizado com sucesso!<br>
                   Seguem credenciais de acesso:<br>
                   Link: <a href="http://canoastec.rs.gov.br/bancodeoportunidades" target="_blank" style="color: #000; font-weight: bold;">canoastec.rs.gov.br/bancodeoportunidades</a><br>
                   Login de Acesso:'.$email.'<br>
                   Senha:'.$ds_senhaportalemail;
               //Email::enviarEmail($email, $assunto, $corpo, $nome);
            $idCandidato = mysql_insert_id();



            if(is_array($_POST['profissoes'])){
                foreach ($_POST['profissoes'] as $cp) {

                    if(is_numeric($cp)){
                        $sql_profissao = "INSERT INTO candidatoprofissao (
                                                id_candidatoprofissao,
                                                id_candidato,
                                                id_profissao
                                            )VALUES(
                                                null,
                                                " . $idCandidato . ",
                                                " . $cp . "
                                            )";

                        //echo $sql_profissao;die;

                        $executa_profissao = mysql_query($sql_profissao);

                    }
                }
            }
            //if($executa_subareas){
            // Inserimos no banco de dados os dados da formacao
            //print_r($_POST['form_cand']);die;

            if(is_array($_POST['form_cand'])){
                foreach ($_POST['form_cand'] as $i => $formacao) {
                    if($_POST["dtatermform_cand"][$i] != ''){
                        $terminoformaca = "'".data_to_mysql($_POST["dtatermform_cand"][$i])."'";
                    }else{
                        $terminoformaca = 'null';
                    }
                    $sql_formacao = "INSERT INTO candidatoformacao (
                                            id_candidato,
                                            id_formacao,
                                            id_usuarioinclusao,
                                            dt_termino,
                                            nm_escola,
                                            ds_cidadeescola,
                                            dt_inclusao,
                                            ds_curso,
                                            ds_semestre
                                      )
                                      VALUES ( " . $idCandidato . ",
                                                " . $formacao . ",
                                                '" . $_SESSION['id_usuario'] . "',
                                                " . $terminoformaca . ",
                                                '" . mb_strtoupper($_POST['escolaform_cand'][$i]) . "',
                                                '" . mb_strtoupper($_POST['cidesc_cand'][$i]) . "',
                                                now(),
                                                '" . mb_strtoupper($_POST['curso_cand'][$i]) . "',
                                                '" . mb_strtoupper($_POST['semestre_cand'][$i]) . "'
                                      )";
                    //echo $sql_formacao;die;
                    $executa_formacao = mysql_query($sql_formacao);
                }
            }

            if($executa_formacao){

                // Inserimos no banco de dados os dados da formacao
                if(is_array($_POST['descquali_cand'])){

                    foreach ($descquali_cand as $j => $qualificacao) {
                        $terminoquali = data_to_mysql($_POST["dtatermquali_cand"][$j]);
                        $sql_qualificacao = "INSERT INTO candidatoqualificacao (
                                                id_candidato,
                                                id_usuarioinclusao,
                                                ds_qualificacao,
                                                dt_termino,
                                                qtd_horas,
                                                nm_instituicao,
                                                dt_inclusao
                                            )
                                            VALUES ( '" . $idCandidato . "',
                                                     '" . $_SESSION['id_usuario'] . "',
                                                     '" . mb_strtoupper($qualificacao) . "',
                                                     '" . $terminoquali . "',
                                                     '" . $_POST['qnthsquali_cand'][$j] . "',
                                                     '" . mb_strtoupper($_POST['instquali_cand'][$j]) . "',
                                                     now()
                                            )";

                        if($qualificacao != ''){
                            $executa_qualificacao = mysql_query($sql_qualificacao);
                        }else{
                            $executa_qualificacao = true;
                        }

                    }
                }else{
                    $executa_qualificacao = true;
                }

                if($executa_qualificacao){
                    // Inserimos no banco de dados os dados da formacao
                    if(is_array($_POST['empresaexp_cand'])){

                            foreach ($empresaexp_cand as $k => $experiencia) {
                                $inicioexp = data_to_mysql($_POST["dtainiexp_cand"][$k]);
                                $terminoexp = data_to_mysql($_POST["dtaterexp_cand"][$k]);
                                $sql_experiencia = "INSERT INTO candidatoexperiencia (
                                                        id_usuarioinclusao,
                                                        id_candidato,
                                                        dt_inicio,
                                                        dt_termino,
                                                        nm_empresa,
                                                        ds_atividades,
                                                        dt_inclusao
                                                    )
                                                    VALUES ('" . $_SESSION['id_usuario'] . "',
                                                            '" . $idCandidato . "',
                                                            '" . $inicioexp . "',
                                                            '" . $terminoexp . "',
                                                            '" . mb_strtoupper($experiencia) . "',
                                                            '" . mb_strtoupper($_POST['prinativexp_cand'][$k]) . "',
                                                            now()
                                                    )";

                                if($experiencia != ''){
                                    $executa_experiencia = mysql_query($sql_experiencia);
                                }else{
                                    $executa_experiencia = true;
                                }

                            }
                    }else{
                        $executa_experiencia = true;
                    }



                    // Se inserido com sucesso
                    if ($executa_formacao &&
                            $executa_candidato &&
                            $executa_qualificacao &&
                            $executa_experiencia) {

                        $_POST["nome_cand"] = '';
                        //$_POST["nome_cand"];
                        $_POST['validar'] = '';
                        $_POST["nome_cand"] = '';
                        //$_POST["nome_cand"];
                        $_POST["cpf_cand"] = "";
                        $_POST["rg_cand"] = "";
                        $_POST["ctps_cand"] = "";
                        $_POST["cnh_cand"] = "";
                        $_POST["email_cand"] = "";
                        $_POST["tel_cand"] = "";
                        $_POST["cel_cand"] = "";
                        $_POST["estciv_cand"] = "";
                        $_POST["sexo_cand"] = "";
                        $_POST["nacio_cand"] = "";
                        $_POST["nr_cepcand"] = "";
                        $_POST["logra_cand"] = "";
                        $_POST["num_cand"] = "";
                        $_POST["comp_cand"] = "";
                        $_POST["bairro_cand"] = "";
                        $_POST["cidade_cand"] = "";
                        $_POST["estado_cand"] = "";
                        $_POST["pro_cand"] = "";
                        $_POST["def_cand"] = "";
                        $_POST["obj_cand"] = "";
                        $_POST["dtanasc_cand"] = "";

                        //limpa sessao do post
                        unset($_POST);

                        //redireciona
                        echo "<script>alert('Cadastro concluído');window.location = 'cadastro.php#parte-00';</script>";
                    }
                    // Se houver algum erro ao inserir
                    else {
                        echo "<script>alert('1Não foi possível realizar o cadastro, tente mais tarde!');window.location = 'cadastro.php#parte-00';</script>";
                    }

                }//executa_qualificacao
                else {
                    echo "<script>alert('2Não foi possível realizar o cadastro, tente mais tarde!');window.location = 'cadastro.php#parte-00';</script>";
                }
            }//executa_formacao
            else{
                echo "<script>alert('3Não foi possível realizar o cadastro, tente mais tarde!');window.location = 'cadastro.php#parte-00';</script>";
            }
        }//executa_candidato
        else {
            echo "<script>alert('4Não foi possível realizar o cadastro, tente mais tarde!');window.location = 'cadastro.php#parte-00';</script>";
        }
    }//else dos erros
}//validar

?>

<form  name="cadastroCandidato" id="cadastroCandidato" method="post" action="cadastro.php#parte-00">
    <div id="cand_load"></div>
<div id="cand_error"></div>
<div id="cand_ok"></div>
    <input type="hidden" name="validar" value='1'>
    <fieldset>
        <legend class="legend">Dados Pessoais</legend>
        <table class="tabela">
            <tr>
                <td><span class="style1">*</span></td>
                <td width="69">Nome:</td>
                <td width="546"><input name="nome_cand" id="nome_cand" value="<?php echo $_POST['nome_cand'] ?>" class="campo" type="text"  size="71" maxlength="60" /></td>
            </tr>

            <tr>
                <td><span class="style1">*</span></td>
                <td>CPF:</td>
                <td>
                    <input name="cpf_cand" id="cpf_cand" value="<?php echo $_POST['cpf_cand'] ?>" onblur="validarCPF(this.value);" onkeypress='return valCPF(event,this);' class="campo" type="text"  size="20" maxlength="11" />
                </td>
            </tr>

             <tr>
                <td><span class="style1"></span></td>
                <td>RG:</td>
                <td>
                    <input name="rg_cand" id="cpf_cand" value="<?php echo $_POST['rg_cand'] ?>" class="campo" type="text"  size="20" maxlength="10" />
                </td>
            </tr>

            <tr>
                <td><span class="style1"></span></td>
                <td>CTPS Nº:</td>
                <td>
                    <input name="ctps_cand" id="ctps_cand" value="<?php echo $_POST['ctps_cand'] ?>" onkeypress="return valida_numero(event);" class="campo" type="text"  size="20" maxlength="10" />
                    &nbsp;&nbsp;
                    <span class="style1"></span>&nbsp;Série Nº:
                    <input name="nr_serie" id="nr_serie" value="<?php echo $_POST['nr_serie'] ?>" class="campo" type="text"  size="7" maxlength="5" />
                    &nbsp;
                    <span class="style1"></span>&nbsp;UF:
                    <select name="estado_ctps" id="estado_ctps" class="campo">
                        <option value="">----</option>
                        <?php
                        $sqlUf = "SELECT * FROM estado ORDER BY nm_estado";
                        $query = mysql_query($sqlUf);
                        while ($rowUf = mysql_fetch_object($query)) {
                        ?>
                        <option value="<?php echo $rowUf->id_estado;?>" <?php if ($_POST['estado_ctps'] == $rowUf->id_estado) echo "selected" ?>>
                            <?php
                            echo $rowUf->sg_estado;
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
                <td>CNH:</td>
                <td>
                    <select name="cnh_cand" id="cnh_cand" class="campo"  >
                        <option value="">Selecione</option>
                        <option value="ACC" <?php if ($_POST['cnh_cand'] == 'ACC') echo "selected" ?>>ACC</option>
                        <option value="A" <?php if ($_POST['cnh_cand'] == 'A') echo "selected" ?>>A</option>
                        <option value="B" <?php if ($_POST['cnh_cand'] == 'B') echo "selected" ?>>B</option>
                        <option value="C" <?php if ($_POST['cnh_cand'] == 'C') echo "selected" ?>>C</option>
                        <option value="D" <?php if ($_POST['cnh_cand'] == 'D') echo "selected" ?>>D</option>
                        <option value="E" <?php if ($_POST['cnh_cand'] == 'E') echo "selected" ?>>E</option>
                        <option value="AB" <?php if ($_POST['cnh_cand'] == 'AB') echo "selected" ?>>AB</option>
                        <option value="AC" <?php if ($_POST['cnh_cand'] == 'AC') echo "selected" ?>>AC</option>
                        <option value="AD" <?php if ($_POST['cnh_cand'] == 'AD') echo "selected" ?>>AD</option>
                        <option value="AE" <?php if ($_POST['cnh_cand'] == 'AE') echo "selected" ?>>AE</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><span class="style1">*</span></td>
                <td>Email:</td>
                <td><input name="email_cand"  id="email_cand" value="<?php echo $_POST['email_cand'] ?>" class="campo" type="text"  size="71" maxlength="60" /></td>
            </tr>

            <tr>
                <td><span class="style1"></span></td>
                <td>Telefone:</td>
                <td><input name="tel_cand" id="tel_cand" value="<?php echo $_POST['tel_cand'] ?>" class="campo" onkeypress="return valida_numero(event);" type="text" maxlength="14" /> <!-- onBlur="ValidaTelefone(cadastro.tel);" /--></td>
            </tr>
            <tr>
                <td><span class="style1"></span></td>
                <td>Celular:</td>
                <td><input name="cel_cand" id="cel_cand" value="<?php echo $_POST['cel_cand'] ?>" class="campo" onkeypress="return valida_numero(event);" type="text" maxlength="14" /> <!-- onBlur="ValidaTelefone(cadastro.tel);" /--></td>
            </tr>
            <tr>
                <td><span class="style1"></span></td>
                <td>Estado Civil:</td>
                <td>
                    <select name="estciv_cand" id="estciv_cand" class="campo"  >
                        <option value="">Selecione</option>
                        <option value="S" <?php if ($_POST['estciv_cand'] == 'S') echo "selected" ?>>Solteiro</option>
                        <option value="C" <?php if ($_POST['estciv_cand'] == 'C') echo "selected" ?>>Casado</option>
                        <option value="V" <?php if ($_POST['estciv_cand'] == 'V') echo "selected" ?>>Viúvo</option>
                        <option value="D" <?php if ($_POST['estciv_cand'] == 'D') echo "selected" ?>>Divorciado</option>
                        <option value="P" <?php if ($_POST['estciv_cand'] == 'P') echo "selected" ?>>Separado</option>
                        <option value="O" <?php if ($_POST['estciv_cand'] == 'O') echo "selected" ?>>Outros</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><span class="style1">*</span></td>
                <td>Nascimento:</td>
                <td><input type="text" name="dtanasc_cand" id="dtanasc_cand" value="<?php echo $_POST['dtanasc_cand'] ?>" onkeypress="return valida_numero(event);" onkeydown="formata_data(this, event);" onblur="valida_data(this.value)" class="campo data" size="11" maxlength="10"/></td>
            </tr>
            <tr>
                <td><span class="style1">*</span></td>
                <td>Sexo:</td>
                <td><input name="sexo_cand" id="sexo_cand" type="radio" value="M" checked <?php if ($_POST['sexo_cand'] == 'M') echo "checked" ?>>Masculino
                    <input name="sexo_cand" id="sexo_cand" type="radio" value="F" <?php if ($_POST['sexo_cand'] == 'F') echo "checked" ?>/>Feminino
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>Nacionalidade:</td>
                <td><input name="nacio_cand"  id="nacio_cand" value="<?php echo $_POST['nacio_cand'] ?>" class="campo" type="text"/></td>
            </tr>

            <tr>
                <td>
                    <span class="style1"></span>
                </td>
                <td>
                    <label>Cep:</label>
                </td>
                <td>
                    <input type="text" name="nr_cepcand" value="<?php echo $_POST['nr_cepcand'] ?>" id="nr_cepcand" class="campo" maxlength='9' onBlur="ValidaCep(this.value)" onkeypress="return BloqueiaLetras(this.value);" />
                </td>
            </tr>

            <tr>
                <td><span class="style1"></span></td>
                <td>Estado:</td>
                <td>
                    <select name="estado_cand" id="estado_cand" class="campo select">
                        <option value="">Selecione</option>
                        <?php
                        $sqlUf = "SELECT * FROM estado ORDER BY nm_estado";
                        $query = mysql_query($sqlUf);
                        while ($rowUf = mysql_fetch_object($query)) {
                        ?>
                        <option value="<?php echo $rowUf->id_estado;?>" <?php if ($_POST['estado_cand'] == $rowUf->id_estado) echo "selected" ?>>
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
                <td><span class="style1"></span></td>
                <td>Cidade:</td>
                <td>
                    <select name="cidade_cand" id="cidade_cand" class="campo select">
                    <?php
                    if($_POST['cidade_cand']){
                        $sqlCidade = "SELECT * FROM cidade WHERE id_estado IN (SELECT id_estado FROM cidade WHERE id_cidade = ".$_POST['cidade_cand'].")";
                        $queryCidade = mysql_query($sqlCidade);
                        if($queryCidade){
                            $cidades = '';
                            while ($rowCidade = mysql_fetch_object($queryCidade)) {
                                if($rowCidade->id_cidade == $_POST['cidade_cand']){
                                    $cidades.= "<option selected value='$rowCidade->id_cidade'>".$rowCidade->nm_cidade."</option>";
                                }
                                $cidades.= "<option value='$rowCidade->id_cidade'>".$rowCidade->nm_cidade."</option>";
                            }
                            echo $cidades;
                        }
                    }
                    ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><span class="style1"></span></td>
                <td>Bairro:</td>
                <td><input name="bairro_cand" id="bairro_cand" value="<?php echo $_POST['bairro_cand'] ?>" class="campo" type="text"  maxlength="20" /></td>
            </tr>
            <tr>
                <td><span class="style1"></span></td>
                <td>Logradouro:</td>
                <td><input name="logra_cand" id="logra_cand" value="<?php echo $_POST['logra_cand'] ?>" class="campo" type="text"  size="70" maxlength="70" /></td>
            </tr>
            <tr>
                <td><span class="style1"></span></td>
                <td>Nº:</td>
                <td><input name="num_cand" id="num_cand" value="<?php echo $_POST['num_cand'] ?>" onkeypress="return valida_numero(event);" class="campo" type="text"  size="10" maxlength="10" /></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>Complemento:</td>
                <td><input name="comp_cand" id="comp_cand" value="<?php echo $_POST['comp_cand'] ?>" class="campo" type="text"  size="70" maxlength="70" /></td>
            </tr>
            <?php /*
            <tr>
                <td><span class="style1">*</span></td>
                <td>Profissão:</td>
                <td><input name="pro_cand"  id="pro_cand" value="<?php echo $_POST['pro_cand'] ?>" class="campo" type="text"/></td>
            </tr>
            */ ?>
            <tr>
                <td><span class="style1"></span></td>
                <td>Deficiência:</td>
                <td>
                    <select name="def_cand" id="def_cand" class="campo select">
                        <option value="">Nenhuma</option>
                        <?php
                        $sql = "SELECT * FROM deficiencia d ORDER BY d.nm_deficiencia ASC";
                        $query = mysql_query($sql);
                        while ($row = mysql_fetch_object($query)) {
                            ?>
                            <option value="<?php echo $row->id_deficiencia; ?>" <?php if ($_POST['def_cand'] == $row->id_deficiencia) echo "selected"; ?>><?php echo $row->nm_deficiencia; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><span class="style1"></span></td>
                <td>Objetivo:</td>
                <td><textarea name="obj_cand" id="obj_cand" cols="50" rows="3" class="campo"><?php echo $_POST['obj_cand'] ?></textarea></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><span class="style1">Campos com * são obrigatórios!</span></td>
            </tr>
        </table>
    </fieldset>

    <!-- ################ ÁREAS DE INTERESSE  ##################### -->

    <fieldset>
        <legend class="legend">Profissões</legend>

        <table class="tab_form" width="100%">
            <tr>
                <td><span class="style1">*</span></td>
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

                    $sql = "select p.id_profissao, p.nm_profissao from profissao p where ao_ativo = 'S' order by p.nm_profissao ASC";
                    //die($sql);
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

            <?php /*--- OUTRO ---

            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>
                    <div class="checkProfissaoOutroCand">
                        <input type="checkbox" class="oProf" name="ao_outro" value="S"
                                <?php
//                                if (isset($_SESSION['post']['ao_outro'])) {
//                                    echo 'checked';
//                                }else if(count(ControleSessao::buscarObjeto('privateCand')->profissoes)>0){
//                                    foreach (ControleSessao::buscarObjeto('privateCand')->profissoes as $cp) {
//                                        if($cp->profissao->ao_ativo == 'V') echo 'checked';
//                                    }
//                                 }
                                 ?> onclick="desmarcar();" />OUTRO

                        <input <?php
//                                    if(ControleSessao::buscarObjeto('privateCand')->profissoes>0){
//                                        foreach (ControleSessao::buscarObjeto('privateCand')->profissoes as $cp) {
//                                            if($cp->profissao->ao_ativo == 'V'){
//                                                $aux = '';
//                                            }else{
                                                $aux = 'style="display: none;"';
//                                            }
//                                        }
//                                    }else if(!(isset($_SESSION['errosPR']) && in_array('ds_outro',$_SESSION['errosPR']))){
//                                        $aux = 'style="display: none;"';
//                                    }
                                    echo $aux;
                                    ?>
                            name="ds_outro"  id="ds_outro" value="<?php
//                                                                    if(isset($_SESSION['errosPR'])){
//                                                                        echo $_SESSION['post']['ds_outro'];
//                                                                    }else if(count(ControleSessao::buscarObjeto('privateCand')->profissoes)>0){
//                                                                        foreach (ControleSessao::buscarObjeto('privateCand')->profissoes as $cp){
//                                                                            if($cp->profissao->ao_ativo == 'V') echo $cp->profissao;
//                                                                        }
//                                                                    }
                                                                    ?>"
                        type="text" />

                    </div>
                </td>
            </tr>
            */ ?>

        </table>

    </fieldset>

    <!-- ################ FORMACAO  ##################### -->

    <fieldset>
        <legend class="legend">Formação</legend>

        <?php if(!isset($_POST['form_cand'])){ ?>
        <div id="origem_formacao">
            <table class="tabela">
                <tr>
                    <td><span class="style1">*</span></td>
                    <td width="69">Escolaridade:</td>
                    <td width="546">
                        <select name="form_cand[]" id="form_cand" class="campo">
                            <option value="">Selecione...</option>
                            <?php
                                $sqlform = "SELECT * FROM formacao ORDER BY nm_formacao";
                                $queryform = mysql_query($sqlform);
                                while ($rowform = mysql_fetch_object($queryform)) {
                            ?>
                            <option value="<?php echo $rowform->id_formacao; ?>" <?php if ($_POST['form_cand'][$i] == $rowform->id_formacao) echo "selected"; ?>>
                                <?php echo $rowform->nm_formacao; ?>
                            </option>
                            <?php
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr id="auxCurso" <?php echo "style='display: none;'";?>>
                    <td><span class="style1">*</span></td>
                    <td>Curso:</td>
                    <td><input value="<?php echo $_POST['curso_cand'][$i];?>" type="text" name="curso_cand[]"  id="curso_cand" class="campo" size="35" maxlength="30"/></td>
                </tr>
                <tr id="auxSemestre" <?php echo "style='display: none;'";?>>
                    <td><span class="style1">*</span></td>
                    <td>Semestre:</td>
                    <td><input value="<?php echo $_POST['semestre_cand'][$i];?>" type="text" name="semestre_cand[]" id="semestre_cand" class="campo" onkeypress="return valida_numero(event);" size="20" maxlength="2"/></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>Data Termino:</td>
                    <td><input value="<?php echo $_POST['dtatermform_cand'][$i];?>" type="text" name="dtatermform_cand[]"  id="dtatermform_cand" onkeypress="return valida_numero(event);" onkeydown="formata_data(this, event);" class="campo" size="10" maxlength="10"/></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>Escola:</td>
                    <td><input value="<?php echo $_POST['escolaform_cand'][$i]; ?>" name="escolaform_cand[]" id="escolaform_cand" class="campo" type="text"  size="70" maxlength="60" /></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>Cidade Escola:</td>
                    <td><input value="<?php echo $_POST['cidesc_cand'][$i]; ?>" name="cidesc_cand[]" id="cidesc_cand" class="campo" type="text"  size="70" maxlength="60" /></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><span class="style1">* Campos com * são obrigatórios!</span></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><img  src="../../Utilidades/Imagens/bancodeoportunidades/add.png" width="25" height="25" style="cursor: pointer;" onclick="duplicarFormacao();">
                        <img  src="../../Utilidades/Imagens/bancodeoportunidades/cross.png" width="25" height="25" style="cursor: pointer;" onclick="removerFormacao(this);"></td>
                </tr>
            </table>
        </div>
        <div id="destino_formacao"></div>
        <?php }else{?>
        <div id="formacao_candidato">
        <?php

            for($i = 0; count($_POST['form_cand']) > $i; $i++) {

                if($_POST['form_cand'][$i] === '1' ||
                        $_POST['form_cand'][$i] === '2' ||
                        $_POST['form_cand'][$i] === '3' ||
                        $_POST['form_cand'][$i] === '4' ||
                        $_POST['form_cand'][$i] === '5' ||
                        $_POST['form_cand'][$i] === '6' ||
                        $_POST['form_cand'][$i] === '7' ||
                        $_POST['form_cand'][$i] === '8'){

        ?>
        <div id="origem_formacao<?php echo $i;?>" name="origem_formacao<?php echo $i;?>">
            <table class="tabela">
                <tr>
                    <td><span class="style1">*</span></td>
                    <td width="69">Escolaridade:</td>
                    <td width="546">
                        <select name="form_cand[]" id="form_cand" class="campo">
                            <option value="">Selecione...</option>
                            <?php
                                $sql = "SELECT * from formacao f order by f.id_formacao";
                                $query = mysql_query($sql);

                                while ($row = mysql_fetch_object($query)) {
                            ?>
                            <option value="<?php echo $row->id_formacao; ?>" <?php if ($_POST['form_cand'][$i] == $row->id_formacao) echo "selected"; ?>> <?php echo $row->nm_formacao; ?></option>
                            <?php
                                }
                            ?>
                        </select></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>Data Termino:</td>
                    <td><input value="<?php echo $_POST['dtatermform_cand'][$i];?>" type="text" name="dtatermform_cand[]"  id="dtatermform_cand" onkeypress="return valida_numero(event);" onkeydown="formata_data(this, event);" class="campo" size="10" maxlength="10"/></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>Escola:</td>
                    <td><input value="<?php echo $_POST['escolaform_cand'][$i]; ?>" name="escolaform_cand[]" id="escolaform_cand" class="campo" type="text"  size="70" maxlength="60" /></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>Cidade Escola:</td>
                    <td><input value="<?php echo $_POST['cidesc_cand'][$i]; ?>" name="cidesc_cand[]" id="cidesc_cand" class="campo" type="text"  size="70" maxlength="60" /></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><span class="style1">* Campos com * são obrigatórios!</span></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><img  src="../../Utilidades/Imagens/bancodeoportunidades/add.png" width="25" height="25" style="cursor: pointer;" onclick="duplicarFormacao2('<?php echo $i;?>');">
                        <img  src="../../Utilidades/Imagens/bancodeoportunidades/cross.png" width="25" height="25" style="cursor: pointer;" onclick="removerFormacao2(<?php echo "origem_formacao$i"; ?>)"></td>
                </tr>
            </table>
        </div>
        <?php }else{ ?>

            <div id="destino_formacao">
            <table class="tabela">
                <tr>
                    <td><span class="style1">*</span></td>
                    <td width="69">Escolaridade:</td>
                    <td width="546">
                        <select name="form_cand[]" id="form_cand" class="campo">
                            <option value="">Selecione...</option>
                            <?php
                                $sql = "SELECT * from formacao f order by f.id_formacao";
                                $query = mysql_query($sql);

                                while ($row = mysql_fetch_object($query)) {
                            ?>
                            <option value="<?php echo $row->id_formacao; ?>" <?php if ($_POST['form_cand'][$i] == $row->id_formacao) echo "selected"; ?>> <?php echo $row->nm_formacao; ?></option>
                            <?php
                                }
                            ?>
                        </select></td>
                </tr>
                <tr id="auxCurso" <?php echo "style='display: none;'";?>>
                    <td><span class="style1">*</span></td>
                    <td>Curso:</td>
                    <td><input value="<?php echo $_POST['curso_cand'][$i];?>" type="text" name="curso_cand"  id="curso_cand" class="campo" size="35" maxlength="30"/></td>
                </tr>
                <tr id="auxSemestre" <?php echo "style='display: none;'";?>>
                    <td><span class="style1">*</span></td>
                    <td>Semestre:</td>
                    <td><input value="<?php echo $_POST['semestre_cand'][$i];?>" type="text" name="semestre_cand"  class="campo" size="20" maxlength="20"/></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>Data Termino:</td>
                    <td><input value="<?php echo $_POST['dtatermform_cand'][$i];?>" type="text" name="dtatermform_cand[]"  id="dtatermform_cand" onkeypress="return valida_numero(event);" onkeydown="formata_data(this, event);" class="campo" size="10" maxlength="10"/></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>Escola:</td>
                    <td><input value="<?php echo $_POST['escolaform_cand'][$i]; ?>" name="escolaform_cand[]" id="escolaform_cand" class="campo" type="text"  size="70" maxlength="60" /></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>Cidade Escola:</td>
                    <td><input value="<?php echo $_POST['cidesc_cand'][$i]; ?>" name="cidesc_cand[]" id="cidesc_cand" class="campo" type="text"  size="70" maxlength="60" /></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><span class="style1">* Campos com * são obrigatórios!</span></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><img  src="../../Utilidades/Imagens/bancodeoportunidades/add.png" width="25" height="25" style="cursor: pointer;" onclick="duplicarFormacao3();">
                        <img  src="../../Utilidades/Imagens/bancodeoportunidades/cross.png" width="25" height="25" style="cursor: pointer;" onclick="removerFormacao2('destino_formacao');"></td>
                </tr>
            </table>
        </div>

        <?php }} ?>
        </div>
        <?php } ?>
        <div id="destino_formacao"></div>

    </fieldset>

    <!-- ################ QUALIFICACAO ##################### -->
    <fieldset>
        <legend class="legend">Qualificações e Atividades Profissionais</legend>

        <?php if(!isset($_POST['descquali_cand'])){ ?>
        <div id="origem_qualificacao">
            <table class="tabela">
                <tr>
                    <td>&nbsp;</td>
                    <td width="69">Descrição:</td>
                    <td width="546"><input name="descquali_cand[]" id="descquali_cand" class="campo" type="text"  size="70" maxlength="60" /></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>Instituição:</td>
                    <td><input name="instquali_cand[]" id="instquali_cand" class="campo" type="text"  size="70" maxlength="60" /></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>Data Termino:</td>
                    <td><input type="text" name="dtatermquali_cand[]" onkeypress="return valida_numero(event);" onkeydown="formata_data(this, event);" id="dtatermquali_cand" class="campo data" size="10" maxlength="10"/></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>Qnt. Horas:</td>
                    <td><input type="text" name="qnthsquali_cand[]" onkeypress="return valida_numero(event);" id="qnthsquali_cand"  class="campo" size="10" maxlength="10"/>Hrs.</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><span class="style1">* Campos com * são obrigatórios!</span></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><img  src="../../Utilidades/Imagens/bancodeoportunidades/add.png" width="25" height="25" style="cursor: pointer;" onclick="duplicarQualificacao();">
                        <img  src="../../Utilidades/Imagens/bancodeoportunidades/cross.png" width="25" height="25" style="cursor: pointer;" onclick="removerQualificacao(this);"></td>
                </tr>
            </table>
        </div>
        <div id="destino_qualificacao"></div>
        <?php }else{ ?>

        <div id="qualificacao">
            <?php
                for ($i = 0; count($_POST['descquali_cand']) > $i; $i++) {
                    $ori_quali = 'origem_qualificacao';
                    $des_quali = 'destino_qualificacao';
            ?>

            <div id="<?php if(!empty($_POST['descquali_cand'][$i])) { echo $ori_quali.$i; } else { echo $des_quali; }?>">
                <table class="tabela">
                    <tr>
                        <td>&nbsp;</td>
                        <td width="69">Descrição:</td>
                        <td width="546"><input value="<?php echo $_POST['descquali_cand'][$i];?>" name="descquali_cand[]" id="descquali_cand" class="campo" type="text"  size="70" maxlength="60" /></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>Instituição:</td>
                        <td><input value="<?php echo $_POST['instquali_cand'][$i];?>" name="instquali_cand[]" id="instquali_cand" class="campo" type="text"  size="70" maxlength="60" /></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>Data Termino:</td>
                        <td><input value="<?php echo $_POST['dtatermquali_cand'][$i];?>" type="text" name="dtatermquali_cand[]" onkeypress="return valida_numero(event);" onkeydown="formata_data(this, event);" id="dtatermquali_cand" class="campo data" size="10" maxlength="10"/></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>Qnt. Horas:</td>
                        <td><input value="<?php echo $_POST['qnthsquali_cand'][$i];?>" type="text" name="qnthsquali_cand[]" onkeypress="return valida_numero(event);" id="qnthsquali_cand"  class="campo" size="10" maxlength="10"/>Hrs.</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><span class="style1">* Campos com * são obrigatórios!</span></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><img  src="../../Utilidades/Imagens/bancodeoportunidades/add.png" width="25" height="25" style="cursor: pointer;" onclick="duplicarQualificacao2('<?php echo $i ?>');">
                            <img  src="../../Utilidades/Imagens/bancodeoportunidades/cross.png" width="25" height="25" style="cursor: pointer;" onclick="removerQualificacao(this);"></td>
                    </tr>
                </table>
            </div>
            <?php } ?>
        <div id="destino_qualificacao"></div>
        </div>
        <?php } ?>


    </fieldset>

    <!-- ################ EXPERIENCIA  ##################### -->
    <fieldset>
        <legend class="legend">Experiência Profissional</legend>

        <?php if(!isset($_POST['empresaexp_cand'])){ ?>
        <div id="origem_experiencia">
            <table class="tabela">
                <tr>
                    <td>&nbsp;</td>
                    <td width="69">Data Início:</td>
                    <td width="546"><input type="text" onkeypress="return valida_numero(event);" onkeydown="formata_data(this, event);" name="dtainiexp_cand[]" id="dtainiexp_cand" class="campo" size="10" maxlength="10"/></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>Data Termino:</td>
                    <td><input type="text" name="dtaterexp_cand[]" onkeypress="return valida_numero(event);" onkeydown="formata_data(this, event);" id="dtaterexp_cand" class="campo" size="10" maxlength="10"/></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>Empresa:</td>
                    <td><input name="empresaexp_cand[]" id="empresaexp_cand" class="campo" type="text" size="70" maxlength="60" /></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>Principais Atividades:</td>
                    <td><textarea name="prinativexp_cand[]" id="prinativexp_cand" cols="50" rows="3" class="campo"></textarea></td>
                </tr>
                <tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><span class="style1">* Campos com * são obrigatórios!</span></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><img  src="../../Utilidades/Imagens/bancodeoportunidades/add.png" width="25" height="25" style="cursor: pointer;" onclick="duplicarExperiencia();">
                        <img  src="../../Utilidades/Imagens/bancodeoportunidades/cross.png" width="25" height="25" style="cursor: pointer;" onclick="removerExperiencia(this);"></td>
                </tr>
            </table>
        </div>
        <div id="destino_experiencia"></div>
        <?php }else{ ?>

        <div id="experiencia">
            <?php
                for ($i = 0; count($_POST['empresaexp_cand']) > $i; $i++) {
                    $ori_exp = 'origem_experiencia';
                    $des_exp = 'destino_experiencia';
            ?>
            <div id="<?php if(!empty($_POST['empresaexp_cand'][$i])) { echo $ori_exp.$i; } else { echo $des_exp; }?>">
                <table class="tabela">
                    <tr>
                        <td>&nbsp;</td>
                        <td width="69">Data Início:</td>
                        <td width="546"><input value="<?php echo $_POST['dtainiexp_cand'][$i];?>" type="text" onkeypress="return valida_numero(event);" onkeydown="formata_data(this, event);" name="dtainiexp_cand[]" id="dtainiexp_cand" class="campo" size="10" maxlength="10"/></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>Data Termino:</td>
                        <td><input value="<?php echo $_POST['dtaterexp_cand'][$i];?>" type="text" name="dtaterexp_cand[]" onkeypress="return valida_numero(event);" onkeydown="formata_data(this, event);" id="dtaterexp_cand" class="campo" size="10" maxlength="10"/></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>Empresa:</td>
                        <td><input value="<?php echo $_POST['empresaexp_cand'][$i];?>" name="empresaexp_cand[]" id="empresaexp_cand" class="campo" type="text" size="70" maxlength="60" /></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>Principais Atividades:</td>
                        <td><textarea name="prinativexp_cand[]" id="prinativexp_cand" cols="50" rows="3" class="campo"><?php echo $_POST['prinativexp_cand'][$i];?></textarea></td>
                    </tr>
                    <tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><span class="style1">* Campos com * são obrigatórios!</span></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><img  src="../../Utilidades/Imagens/bancodeoportunidades/add.png" width="25" height="25" style="cursor: pointer;" onclick="duplicarExperiencia2('<?php echo $i; ?>');">
                            <img  src="../../Utilidades/Imagens/bancodeoportunidades/cross.png" width="25" height="25" style="cursor: pointer;" onclick="removerExperiencia(this);"></td>
                    </tr>
                </table>
            </div>
            <?php } ?>
            <div id="destino_experiencia"></div>
        </div>
        <?php } ?>

    </fieldset>
                <input name="cadastrar" class="botao" type="submit" id="cadastrar" value="Enviar" />
                <input name="limpar"  class="botao" type="reset" id="limpar" value="Limpar" />
</form>
<?php

 }else{

     session_destroy();
     header('Location:index.php');
 }
?>
