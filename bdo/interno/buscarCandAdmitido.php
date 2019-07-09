<?php
session_start();
include_once './conecta.php';
include_once './funcoes.php';

if (isset($_GET['op'])) {
    switch ($_GET['op']) {
        case 'buscar':
                
                if (isset($_POST)) {
                    
                    $cpf = $_POST['cpf_cand'];
                    
                    $errosP = array();
                
                    if (empty($cpf)) {
                        $errosP[] = 'cpf_cand';
                    }
                    
                    $id_empresa = $_GET['id'];
       
                    if(count($errosP) == 0){

                        $sql = "SELECT
                                    c.id_candidato,
                                    c.nm_candidato,
                                    c.nr_cpf
                                FROM
                                    candidato c
                                WHERE 
                                   c.nr_cpf = '$cpf'";
                       // echo $sql;die;

                        $query = mysql_query($sql);

                        $res = mysql_fetch_object($query);
                        $_SESSION['carregar'] = $res;
                        header("location:editaEmpresa.php?edita=$id_empresa#parte-07");

                }else{
                    //registra na sessao o array de erros e o post
                    $_SESSION['errosP'] = $errosP;
                    $_SESSION['post'] = $_POST;
                    header("location:editaEmpresa.php?edita=$id_empresa#parte-07");
                }
             }
            break;
            
        case 'cadastrar':
            
            if (isset($_POST)) {
                
                //echo var_dump($_POST);
                $id_empresa = $_GET['id'];
                
                $id_candidato = $_POST['candidato'];
                $ds_cargo = $_POST['ds_cargo'];
                $dt_admissao = $_POST['dt_admissao'];
                
                $errosP = array();
                
                if (empty($ds_cargo)) {
                    $errosP[] = 'ds_cargo';
                }
                
                if (!validarData($dt_admissao)){
                    $errosP[] = 'dt_admissao';
                }
                
                
                
                if(count($errosP) == 0){
                
                    $dt_admissao = data_to_mysql($dt_admissao);
                    
                    $sqlCadastro = "INSERT INTO admissao ( 
                                            id_admissao,
                                            id_candidato,
                                            id_empresa,
                                            ds_cargo,
                                            dt_admissao
                                      )
                                      VALUES ( 
                                            null,
                                            $id_candidato,  
                                            $id,
                                            '$ds_cargo',
                                            '$dt_admissao'           
                                      )";
//                    echo $sqlCadastro;die;
                    
                    $query = mysql_query($sqlCadastro);
                    $_SESSION['msgAdm'] = 'Cadastro realizado com sucesso!';
                    header("location:editaEmpresa.php?edita=$id_empresa#parte-07");
                    
                }else{
                    
                    //registra na sessao o array de erros e o post
                    $_SESSION['errosC'] = $errosP;
                    $_SESSION['carregar'] = true;
                    $_SESSION['post'] = $_POST;
                    header("location:editaEmpresa.php?edita=$id_empresa#parte-07");
                }
            }
        break;

    }
}

?>