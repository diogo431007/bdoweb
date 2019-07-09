<?php
session_start();
include_once './conecta.php';
include_once './funcoes.php';
include_once './Email.class.php';

if (isset($_GET['op'])) {
    switch ($_GET['op']) {
        case 'enviar':            
            if(isset($_POST)){
                
              $erros = array();
                
                if(empty($_POST['ds_assunto'])) $erros[] = 'ds_assunto';
                if(empty($_POST['ds_mensagem'])) $erros[] = 'ds_mensagem';
                
                if(count($erros) == 0){
                   $assunto = $_POST['ds_assunto'];
                    $corpoEmail = nl2br($_POST['ds_mensagem']);
                    $arquivo = isset($_FILES['arquivo']) ? $_FILES['arquivo'] : FALSE;
                    
                    /**********************************************************/
                    /************* Dispara email para candidatos **************/
                    /**********************************************************/
                    if(in_array('candidatos', $_POST['enviaEmail'])){
                        
                        if(isset($_POST['profissoes'])){
                            $filtro_prof = '';
                            foreach ($_POST['profissoes'] as $id_profissao) {
                                if(is_numeric($id_profissao)) $filtro_prof .= " and cp.id_profissao = $id_profissao ";
                            }
                        }                        
                        $sqlCand = "SELECT
                                        c.id_candidato,
                                        c.nm_candidato,
                                        c.ds_email,
                                        c.dt_validade                                       
                                    FROM
                                        candidato c
                                    LEFT JOIN 
                                        candidatoprofissao cp ON (c.id_candidato = cp.id_candidato)
                                    WHERE
                                        c.dt_validade BETWEEN DATE(NOW()) AND c.dt_validade 
                                        $filtro_prof
										group by c.id_candidato limit 1";
                        $queryCand = mysql_query($sqlCand);
                        $cand = array();

                        while($rowCand = mysql_fetch_object($queryCand)){
                            $cand[] = $rowCand;
                        }
                        
                        if(count($cand) > 0){
                            foreach($cand as $c){
                                $emailCand = $c->ds_email;
                                $nomeCand = $c->nm_candidato;
                                Email::enviarEmail($emailCand, $assunto, $corpoEmail, $nomeCand,$arquivo);
                                
                            }
                        }
                    }
                    /**********************************************************/
                    /************** Dispara email para empresas ***************/
                    /**********************************************************/
                    if(in_array('empresas', $_POST['enviaEmail'])){                        
                       $sqlEmp  = "SELECT
                                        e.id_empresa,
                                        e.nm_razaosocial,
                                        e.nm_fantasia,
                                        e.ds_email,
                                        e.ds_emailproprietario,
                                        e.nm_proprietario,
                                        e.ao_status
                                    FROM 
                                        empresa e
                                    WHERE
                                        e.ao_liberacao = 'S' limit 1";
                        $queryEmp = mysql_query($sqlEmp);
                        $emp = array();

                        while($rowEmp = mysql_fetch_object($queryEmp)){
                            $emp[] = $rowEmp;
                        }
                        
                        if(count($emp) > 0){
                            foreach($emp as $e){
                                $emailEmp = $e->ds_email;
                                $emailPropEmp = $e->ds_emailproprietario;

                                $nomeEmp = (!empty($e->nm_fantasia)) ? $e->nm_fantasia : $e->nm_razaosocial;
                                $nomeProp = $e->nm_proprietario;

                                Email::enviarEmail($emailEmp, $assunto, $corpoEmail, $nomeEmp,$arquivo);
                               Email::enviarEmail($emailPropEmp, $assunto, $corpoEmail, $nomeProp,$arquivo);
                            }
                        }
                    }                    
                    $_SESSION['msgEmail'] = 'Email enviado com sucesso!';
                }else{
                    $_SESSION['erros'] = $erros;
                    header('location:email.php');
                    $_SESSION['msgEmail'] = 'Ocorreu um erro! Tente novamente.';
                }
                header('location:email.php');
            }
            break;
    }
}
?>