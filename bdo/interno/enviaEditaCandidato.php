<?php require_once 'define.php';
require_once 'conecta.php';
require_once 'funcoes.php';

    $id = $_POST[idEditaCandidato];			 
    $nome = ($_POST["nome_cand"]); //utf8 utilizado para remover problemas de caracteres acentuados
    $cpf = $_POST["cpf_cand"];
    $rg = $_POST["rg_cand"];
    $ctps = $_POST["ctps_cand"];
    $pis = $_POST["pis_cand"];
    $nr_serie = $_POST['nr_serie'];
    $estado_ctps = $_POST['estado_ctps'];
    $email = ($_POST["email_cand"]);
    $telefone = $_POST["tel_cand"];
    $celular = $_POST["cel_cand"];
    $estadocivil = $_POST["estciv_cand"];
    $sexo = $_POST["sexo_cand"];
    $nacio = utf8_decode($_POST["nacio_cand"]);
    $nr_cepcand = $_POST["nr_cepcand"];
    $logradouro = utf8_decode($_POST["logra_cand"]);
    $numero = $_POST["num_cand"];
    $complemento = utf8_decode($_POST["comp_cand"]);
    $bairro = utf8_decode($_POST["bairro_cand"]);
    $cidade = $_POST["cidade_cand"];
    $estado = $_POST["estado_cand"];
    //$profissao = utf8_decode($_POST["pro_cand"]);
    $deficiencia = $_POST["def_cand"];
    $objetivo = utf8_decode($_POST["obj_cand"]);
    $dtanascimento = $_POST["dtanasc_cand"];
    $ds_loginportal = $_POST["ds_loginportal"];
    $pw_senhaportal = $_POST["pw_senhaporta"];
    $ao_interno = $_POST["ao_interno"];
    $ds_cnh = $_POST["cnh_cand"];
    
    $erro = 0;
    
    if(is_array($_POST['profissoes'])){
        foreach ($_POST['profissoes'] as $p) {
            if(!is_numeric($p)) $erros++;
        }
    }else if(!is_null($_POST['profissoes'])){
        $erros++;
    }
    
    if (empty($nome)) {
        echo "<script>alert('Preencha o campo Nome');window.location = 'editaCandidato.php?edita=$id';</script>";
        $erro++;
    } else if (strlen($nome) <= 3) {
        echo "<script>alert('Digite o nome completo');window.location = 'editaCandidato.php?edita=$id';</script>";
        $erro++;
    } else if (empty($cpf)) {
        echo "<script>alert('Preencha o campo CPF');window.location = 'editaCandidato.php?edita=$id';</script>";
        $erro++;
    } else if (strlen($cpf) > 14) {
        echo "<script>alert('Digite um CPF válido!');window.location = 'editaCandidato.php?edita=$id';</script>";
        $erro++;
    } else if (empty($dtanascimento)) {
        echo "<script>alert('Preencha o campo Data de nascimento');window.location = 'editaCandidato.php?edita=$id';</script>";
        $erro++;
//    } else if (empty($profissao)) {
//        echo "<script>alert('Preencha o campo profissão');window.location = 'editaCandidato.php?edita=$id';</script>";
//        $erro++;
//    } else if ($profissao == '') {
//        echo "<script>alert('Preencha o campo profissão corretamente');window.location = 'editaCandidato.php?edita=$id';</script>";
//        $erro++;
    }else{
        
        if($erro == 0){
        
            $idDef = (empty($deficiencia)) ? 'null' : $deficiencia;
            $auxEstadoCivil = (empty($estadocivil)) ? 'null' : "'$estadocivil'";
            $auxIdCidade = (empty($cidade)) ? 'null' : $cidade;
            $auxEstadoCtps = (empty($estado_ctps)) ? 'null' : $estado_ctps;
            $auxCnh = (empty($ds_cnh)) ? 'null' : "'$ds_cnh'";
            $dt = data_to_mysql($dtanascimento);
         $sql_candidato  = "UPDATE 
                                    candidato 
                            SET 
                                    nm_candidato = '".mb_strtoupper($nome)."', 
                                    ds_email = '".mb_strtoupper($email)."', 
                                    nr_telefone = '".$telefone."',
                                    nr_celular = '".$celular."',
                                    ds_estado_civil = ".$auxEstadoCivil.", 
                                    ao_sexo = '".$sexo."', 
                                    ds_nacionalidade ='".mb_strtoupper($nacio)."',
                                    ds_profissao ='".mb_strtoupper($profissao)."',    
                                    nr_cep = '".$nr_cepcand."',
                                    ds_logradouro ='".mb_strtoupper($logradouro)."',
                                    nr_logradouro ='".$numero."', 
                                    ds_complemento ='".mb_strtoupper($complemento)."', 
                                    ds_bairro ='".mb_strtoupper($bairro)."', 
                                    dt_nascimento ='".$dt."', 
                                    id_deficiencia = ".$idDef.", 
                                    ds_objetivo ='".mb_strtoupper($objetivo)."', 
                                    nr_cpf ='".$cpf."',
                                    nr_rg = '".$rg."',
                                    dt_alteracao = now(),
                                    nr_ctps = '".$ctps."',
                                    nr_pis = '".$pis."',
                                    id_estadoctps = ".$auxEstadoCtps.",
                                    nr_serie = '$nr_serie',
                                    id_cidade = ".$auxIdCidade.",
                                    id_usuarioalteracao = ".$_SESSION['id_usuario'].",
                               /*** ds_loginportal = '".mb_strtoupper($ds_loginportal)."', ***/
                               /*** pw_senhaportal = '".$pw_senhaportal."', ***/
                                    ao_interno = '".S."',
                                    ds_cnh = ".$auxCnh."
                            WHERE 
                                    id_candidato = ".$id;
           
           $executa_candidato = mysql_query($sql_candidato); 
           //echo $sql_candidato;die;
           if($executa_candidato){
               
           }
           else{
             echo "<script>alert('Não foi possível realizar o cadastro, tente mais tarde!');window.location = 'editaCandidato.php?edita=".$id."';</script>";
           }
           // A varivel $idCandidato é preenchida com o id do candidato 
           
           
           if(is_array($_POST['profissoes'])){
               $sql = "delete from candidatoprofissao where id_candidato = $id";
               $query = mysql_query($sql);
               if(($_POST['profissoes'])>0){
                    foreach ($_POST['profissoes'] as $p) {
                        if(is_numeric($p)){
                             $sql = "INSERT INTO candidatoprofissao (
                                                     id_candidatoprofissao,
                                                     id_candidato,
                                                     id_profissao
                                                 )VALUES(
                                                     null,
                                                     $id,
                                                     $p
                                                 )";

                             $query = mysql_query($sql);
                        }
                    }
               }
           }else if(is_null($_POST['profissoes'])){
               $sql = "delete from candidatoprofissao where id_candidato = $id";
               $query = mysql_query($sql);
           }
           
           
           // Inserimos no banco de dados os dados da formacao 
           
         if(!empty($_POST['form_cand'])){
           
           foreach ($_POST['form_cand'] as $i=>$formacao){
          //   $terminoformaca  = data_to_mysql($_POST["dtatermform_cand"][$i]);
            if(empty($_POST["dtatermform_cand"][$i])){ //testa data vazia
                $dt = 'NULL';
            }else{
                $auxDt = data_to_mysql($_POST["dtatermform_cand"][$i]); //convertendo o formato da data para salvar no banco
                $dt = "'$auxDt'";
            } 
                 $sql_formacao  = "INSERT INTO candidatoformacao (
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
                                   VALUES ( 
                                        ".$id.",
                                        ".$formacao.",
                                        '".$_SESSION['id_usuario']."',
                                        ".$dt.",
                                        '".mb_strtoupper($_POST['escolaform_cand'][$i])."',
                                        '".mb_strtoupper($_POST['cidesc_cand'][$i])."',
                                        now(),
                                        '".mb_strtoupper($_POST['curso_cand'][$i])."',
                                        '".mb_strtoupper($_POST['semestre_cand'][$i])."'
                                   )";
	  if($formacao!=''){
             //echo $sql_formacao;
             $executa_formacao = mysql_query($sql_formacao);
             if ($executa_formacao) {
                    }
                    // Se houver algum erro ao inserir
                    else {
                            echo "<script>alert('Não foi possível realizar o cadastro, tente mais tarde!');window.location = 'editaCandidato.php?edita=".$id."';</script>";
                    }
          }
          }
          }
       
           // Inserimos no banco de dados os dados da formacao 
          if($_POST['descquali_cand']){
          foreach ($_POST['descquali_cand'] as $j=>$qualificacao){
         // $terminoquali    = data_to_mysql($_POST["dtatermquali_cand"][$j]);
            if(empty($_POST["dtatermquali_cand"][$j])){ //testa data vazia
                  $dt = 'NULL';
            }else{
                 $auxDt = data_to_mysql($_POST["dtatermquali_cand"][$j]); //convertendo o formato da data para salvar no banco
                 $dt = "'$auxDt'";
            } 
            if(empty($_POST["qnthsquali_cand"][$j])){ 
                  $qnths = 'NULL';
            }else{
                 $auxQntHs = ($_POST["qnthsquali_cand"][$j]);
                 $qnths = "'$auxQntHs'";
            }
         $sql_qualificacao = "INSERT INTO candidatoqualificacao ( 
                                    id_candidato,
                                    id_usuarioinclusao,
                                    ds_qualificacao,
                                    dt_termino,
                                    qtd_horas,
                                    nm_instituicao, 
                                    dt_inclusao
                              )
                              VALUES ( 
                                    '".$id."',
                                    '".$_SESSION['id_usuario']."',
                                    '".mb_strtoupper($qualificacao)."',
                                    ".$dt.",
                                    ".$qnths.",
                                    '".mb_strtoupper($_POST['instquali_cand'][$j])."',
                                    now()
                              )";
             
            //echo $sql_qualificacao;die;
            if($qualificacao){
                $executa_qualificacao = mysql_query($sql_qualificacao);
                 if ($executa_qualificacao) {                     
                 }
                    // Se houver algum erro ao inserir
                    else {
                            echo "<script>alert('Não foi possível realizar o cadastro, tente mais tarde!');window.location = 'editaCandidato.php?edita=".$id."';</script>";
                    }
            }
         }
         }

           // Inserimos no banco de dados os dados da formacao 
          if($_POST['empresaexp_cand']){
              foreach ($_POST['empresaexp_cand'] as $k=>$experiencia){
            
              if(empty($_POST["dtainiexp_cand"][$k])){ //testa data vazia
                  $dtIni = 'NULL';
             }else{
                 $auxDtIni = data_to_mysql($_POST["dtainiexp_cand"][$k]); //convertendo o formato da data para salvar no banco
                 $dtIni = "'$auxDtIni'";
             } 
             if(empty($_POST["dtaterexp_cand"][$k])){ //testa data vazia
                  $dtTer = 'NULL';
             }else{
                 $auxDtTer = data_to_mysql($_POST["dtaterexp_cand"][$k]); //convertendo o formato da data para salvar no banco
                 $dtTer = "'$auxDtTer'";
             } 
              $sql_experiencia = "INSERT INTO candidatoexperiencia ( 
                                        id_usuarioinclusao,
                                        id_candidato,
                                        dt_inicio,
                                        dt_termino,
                                        nm_empresa,
                                        ds_atividades,
                                        dt_inclusao
                                  ) 
                                  VALUES (
                                        '".$_SESSION['id_usuario']."',
                                        '".$id."',
                                        ".$dtIni.",
                                        ".$dtTer.",
                                        '".mb_strtoupper($experiencia)."',
                                        '".mb_strtoupper($_POST['prinativexp_cand'][$k])."',
                                        now()
                                  )"; 
        //  echo $sql_experiencia;die;
            if($experiencia){
                $executa_experiencia = mysql_query($sql_experiencia);
                    if ($executa_experiencia) {
                    }
                    // Se houver algum erro ao inserir
                    else {
                            echo "<script>alert('Não foi possível realizar o cadastro, tente mais tarde!');window.location = 'editaCandidato.php?edita=".$id."';</script>";
                    }
            }
          }
          }
	// Se inserido com sucesso
	//if ($executa_formacao && $executa_candidato && $executa_qualificacao && $executa_experiencia) {
       
		echo "<script>alert('Edição concluída com sucesso!');window.location = 'busca.php#parte-00';</script>";
	
    }else{
        echo "<script>alert('Não foi possível realizar o cadastro, tente mais tarde!');window.location = 'editaCandidato.php?edita=".$id."';</script>";
    }
    
}
?>
