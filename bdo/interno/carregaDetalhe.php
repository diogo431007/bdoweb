<?php

session_start();
include_once './conecta.php';
include_once './funcoes.php';
if (isset($_GET['op']) && isset($_GET['id'])) {
    switch ($_GET['op']) {
        case 'carregar':
            if (isset($_POST)) {

                if (is_numeric($_POST['idEmpDet']) && is_numeric($_GET['id'])) {
                    $id_empresa = $_GET['id'];

                    $id = $_POST['idEmpDet'];

                    $sql = "select * from empresadetalhe where id_empresadetalhe = $id";
                    //echo $sql;die;
                    $query = mysql_query($sql);
                    $row = mysql_fetch_object($query);

                    $_SESSION['row_detalhe'] = $row;

                    header("location:editaEmpresa.php?edita=$id_empresa#proprietario");
                }
            }
            break;

        case 'adicionar':
            if (isset($_POST)) {

                $id = $_GET['id'];
  
                //array de erros
                $errosP = array();
                
                if (empty($nm_proprietario) || strlen($nm_proprietario) <= 3) {
                    $errosP[] = 'nm_proprietario';
                }
                
//                if (empty($nr_cpf)){
//                    $errosP[] = 'nr_cpf';
//                }
                
                if(!validarEmailNaoObg($_POST['ds_emailproprietario'])){
                    $errosP[] = 'ds_emailproprietario';
                }
                
                if (!empty($nr_cpf)){
                    $nr_cpf = str_replace('-','',str_replace('.', '', $nr_cpf));
                    if(!valida_cpf($nr_cpf)){
                        $errosP[] = 'nr_cpf';
                    }
                } 
                if (empty($ds_cargo)){
                    $errosP[] = 'ds_cargo';
                }
                if(count($errosP) == 0){
                    
                    $dt = (empty($dt_nascimento)) ? 'null' : "'".data_to_mysql($dt_nascimento)."'";
                    
                    $sql = "INSERT INTO empresadetalhe ( 
                                            nm_proprietario,
                                            nr_cpf,
                                            dt_nascimento,
                                            nr_celular,
                                            ds_emailproprietario,
                                            id_empresa,
                                            ao_status,
                                            ds_cargo
                                      )
                                      VALUES ( 
                                                '".mb_strtoupper($nm_proprietario)."',
                                                '$nr_cpf',
                                                " . $dt . ",
                                                '$nr_celular',
                                                '".mb_strtoupper($ds_emailproprietario)."',
                                                '$id',
                                                'S',
                                                '".mb_strtoupper($ds_cargo)."'
                                      )";
                     //echo $sql;die;
                    $query = mysql_query($sql);
                    
                    $_SESSION['msg'] = 'Proprietário cadastrado com sucesso!';
                    
                    //redireciona para a página
                    header("location:editaEmpresa.php?edita=$id#proprietario");
    
                }else{
                    //registra na sessao o array de erros e o post
                    $_SESSION['errosP'] = $errosP;
                    $_SESSION['post'] = $_POST;
                    //redireciona para a página
                    header("location:editaEmpresa.php?edita=$id#proprietario");
                }
            }
            break;
  
        case 'alterar':
            if (isset($_POST)) {
                
                $errosP = array();
                
               // echo var_dump($_POST);
                                //die();
                
                if (!empty($ds_emailproprietario)){
                    if (!preg_match ("/^[A-Za-z0-9]+([_.-][A-Za-z0-9]+)*@[A-Za-z0-9]+([_.-][A-Za-z0-9]+)*\\.[A-Za-z0-9]{2,4}$/", $ds_emailproprietario))
                        $errosP[] = 'ds_emailproprietario';
                } 
                if (empty($ds_cargo)){
                    $errosP[] = 'ds_cargo';
                }
                if(count($errosP) == 0){
                 
                $dt = (empty($dt_nascimento)) ? 'null' : "'".data_to_mysql($dt_nascimento)."'";
                
//                echo converterData($dt_nascimento);die;
                $sql = "UPDATE
                                  empresadetalhe
                                         SET   
                                                dt_nascimento = " . $dt . ",
                                                nr_celular   = '" . $nr_celular . "',
                                                ds_emailproprietario = '" . mb_strtoupper($ds_emailproprietario) . "',
                                                ao_status = '" . $ao_status . "',
                                                ds_cargo = '" . mb_strtoupper($ds_cargo) . "'
                                         WHERE
                                                id_empresadetalhe = " . $idDetalhe;
//echo $sql;die;
                $query = mysql_query($sql);

                $id = $_GET['id'];
                
                $_SESSION['msg'] = 'Proprietário alterado com sucesso!';
                
                header("location:editaEmpresa.php?edita=$id#proprietario");
                
                }else{
                    //registra na sessao o array de erros e o post
                    $_SESSION['errosP'] = $errosP;
                    $_SESSION['post'] = $_POST;
                    $_SESSION['row_detalhe'] = $_POST;
                    
                    //redireciona para a página
                 header("location:editaEmpresa.php?edita=$id#proprietario");
                }
            }
            break;

        default:
            session_destroy();
            header('location:index.php');
            break;
    }
}
?>
