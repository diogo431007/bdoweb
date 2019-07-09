<?php
    require_once 'define.php';
    require_once 'conecta.php';
    require_once 'funcoes.php';
    header("Content-Type: text/html; charset=ISO-8859-1",true);
        //var_dump($_POST);
        //recebe os dados da empresa
        $id = $_POST['id_empresa'];
        $nm_razaosocial = utf8_decode($_POST['nm_razaosocial']);//utf8 utilizado para remover problemas de caracteres acentuados
        $nm_fantasia = utf8_decode($_POST['nm_fantasia']);//utf8 utilizado para remover problemas de caracteres acentuados
        $id_ramoatividade = $_POST['id_ramoatividade'];
        $id_empresatipo = $_POST['id_empresatipo'];
        $id_quantidadefuncionario = $_POST['id_quantidadefuncionario'];
        $nm_contato = utf8_decode($_POST['nm_contato']);
        $nr_telefoneempresa = $_POST['nr_telefoneempresa'];
        $nr_cep = $_POST['nr_cep'];
        $ds_logradouro = utf8_decode($_POST['ds_logradouro']);
        $nr_logradouro = $_POST['nr_logradouro'];
        $ds_bairro = utf8_decode($_POST['ds_bairro']);
        $ds_complemento = utf8_decode($_POST['ds_complemento']);
        $estadoEmp = $_POST['estadoEmp'];
        $cidadeEmp = $_POST['cidadeEmp'];
        $ds_email =  utf8_decode($_POST['ds_email']);
        $ds_site = utf8_decode($_POST['ds_site']);
        $nr_inscricaoestadual = utf8_decode($_POST['nr_inscricaoestadual']);
        $nr_inscricaomunicipal = utf8_decode($_POST['nr_inscricaomunicipal']);
        $dt_fundacao = $_POST["dt_fundacao"];
        //recebo os dados do responsável pela empresa
        $nm_proprietario = utf8_decode($_POST['nm_proprietario']);
        $nr_cpf = $_POST['nr_cpf'];
        $dt_nascimento = $_POST['dt_nascimento'];
        $nr_celular = $_POST['nr_celular'];
        $ds_emailproprietario = utf8_decode($_POST['ds_emailproprietario']);
        $ao_status = $_POST['ao_status'];
        $ds_cargo = utf8_decode($_POST['ds_cargo']);
        $quadranteEmp = $_POST['quadranteEmp'];
        $microregiaoEmp = $_POST['microregiaoEmp'];
        $poligonoEmp = $_POST['poligonoEmp'];
        $ao_selo = $_POST['ao_selo'];
        //recebe os dados de moderacao
        $id_empresamoderacao = $_POST['id_empresamoderacao'];
        $ao_liberacao = $_POST['ao_liberacao'];
        $ds_observacao = utf8_decode($_POST['ds_observacao']);
        $dt_moderacao = $_POST['dt_moderacao'];       
        //var_dump($_POST);die;
        //verificando se os campos foram preenchidos corretamente
        if (empty($nm_razaosocial)){
           echo "Informe a Razão Social!";
        }
        elseif(strlen($nm_razaosocial) <= 2){
            echo "Razão Social inválida!";
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
            echo "Informe o email válido!";
        }
        // valida os dados pessoais
        elseif(empty($nm_proprietario)){
            echo "Informe o nome do proprietário!"; 
        }
        elseif(empty($ds_cargo)){
            echo "Informe o cargo!";
        }
        elseif(empty($ds_emailproprietario)){
            echo "Digite um email válido!";
        }
//        elseif (empty ($quadranteEmp)){    
//            echo "Selecione um Quadrante!";
//        }
//        elseif (empty ($microregiaoEmp)) {
//            echo "Selecione uma Microregião!";
//        }
//        elseif (empty ($poligonoEmp)) {
//            echo "Selecione um Poligono!";
//        }
        elseif  (!preg_match ("/^[A-Za-z0-9]+([_.-][A-Za-z0-9]+)*@[A-Za-z0-9]+([_.-][A-Za-z0-9]+)*\\.[A-Za-z0-9]{2,4}$/", $ds_email))  {
            echo "Digite um email válido";
        }
        elseif ($ao_liberacao == 'N' && empty($ds_observacao)){
            echo "Preencha a observação!";
        }else {
            
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
            //echo 'Fazendo update';    
                $sql  = "UPDATE 
                                        empresa 
                                SET 
                                        nm_razaosocial              = '".mb_strtoupper($nm_razaosocial)."', 
                                        nm_fantasia                 = '".mb_strtoupper($nm_fantasia)."',
                                        id_ramoatividade            = ".$id_ramoatividade.",
                                        id_empresatipo              = ".$id_empresatipo.",
                                        id_quantidadefuncionario    = ".$id_quantidadefuncionario.",
                                        nm_contato                  = '".mb_strtoupper($nm_contato)."',
                                        nr_telefoneempresa          = '".$nr_telefoneempresa."',
                                        nr_cep                      = '".$nr_cep."',
                                        ds_logradouro               = '".mb_strtoupper($ds_logradouro)."',
                                        nr_logradouro               = ".$nr_logradouro.", 
                                        ds_bairro                   = '".mb_strtoupper($ds_bairro)."', 
                                        ds_complemento              = '".mb_strtoupper($ds_complemento)."',
                                        id_cidade                   = ".$cidadeEmp.",
                                        ds_email                    = '".mb_strtoupper($ds_email)."',
                                        ds_site                     = '".mb_strtoupper($ds_site)."',
                                        nr_inscricaoestadual        = '".$nr_inscricaoestadual."',
                                        nr_inscricaomunicipal       = '".$nr_inscricaomunicipal."',
                                        dt_fundacao                 = ".$dt.",
                                        nm_proprietario             = '".mb_strtoupper($nm_proprietario)."',
                                        nr_cpf                      = '".$nr_cpf."',
                                        dt_nascimento               = ".$dt_nasc.",
                                        nr_celular                  = '".$nr_celular."',
                                        ds_emailproprietario        = '".mb_strtoupper($ds_emailproprietario)."',
                                        ao_status                   = '".$ao_status."',
                                        ds_cargo                    = '".mb_strtoupper($ds_cargo)."',
                                        id_microregiao              = ".$mr.",
                                        id_poligono                 = ".$pol.",
                                        ao_selo                     = '".$ao_selo."',
                                   /*** pw_senhaportal              = '".$pw_senhaportal."', ***/
                                        ao_liberacao                = '".$ao_liberacao."'                                            
                                WHERE 
                                        id_empresa = ".$id;
             //echo $sql;die;
             $executa_empresa = mysql_query($sql);
             
                
                $auxObs = ($ao_liberacao == 'S') ? 'null' : "'".$ds_observacao."'";
                $sql_empresamoderacao = "INSERT INTO empresamoderacao (id_empresamoderacao,
                                                                    id_usuario,
                                                                    id_empresa,
                                                                    ao_liberacao,
                                                                    dt_moderacao,
                                                                    ds_observacao
                                                                    )
                                            VALUES(null,
                                                    '".$_SESSION['id_usuario']."',
                                                        '".$id."', 
                                                       '$ao_liberacao',
                                                       now(),
                                                        ".mb_strtoupper($auxObs)."
                                                        )";
              //echo $sql_empresamoderacao;die;
            
            $executa_empresamoderacao = mysql_query($sql_empresamoderacao);
          
                if($executa_empresa){
                    echo false;
                }else{
                    echo "Não foi possível alterar a empresa!";
                }
                //===========Envia Email================//
                if($ao_liberacao == 'S'){
                    
                    include_once '../publico/util/Email.class.php';                    
                    $assunto = 'Cadastro Sistema Banco de Oportunidades';
                    $corpo = 'Sua empresa foi liberada pelo moderador do sistema, você já pode acesssar os currículos.
                        Caso tenha esquecido sua senha, <a href="sistemas.canoas.rs.gov.br/bancodeoportunidades/publico/visao/GuiLembrarSenhaEmpresa.php">clique aqui</a><br>';
                    
                   Email::enviarEmail($ds_email, $assunto, $corpo, $nm_razaosocial);
                   $id = mysql_insert_id();
                   
                }    
        }             
 ?>      