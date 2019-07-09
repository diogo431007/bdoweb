<?php

session_start();
include_once './conecta.php';
include_once './funcoes.php';
include_once '../publico/util/Email.class.php';

if (isset($_GET['op'])) {
    switch ($_GET['op']) {
        case 'buscar':
            if (isset($_POST)) {
                $erros = array();
                
                if (!validarNomeProprietario($_POST['busca_candidato']) && !empty($_POST['busca_candidato'])) $erros[] = 'busca_candidato';
                
                if (count($erros) == 0) {                                      
                    
                    //Uso replace para pegar qualquer parte que o usuário digitou.
                    $busca_candidato = str_replace(' ', '%', $_POST['busca_candidato']);
                    
                    //Busca os candidatos do post.
                    $sql = "SELECT "
                            . "id_candidato, "
                            . "id_deficiencia, "
                            . "nm_candidato, "
                            . "ds_email, "
                            . "nr_telefone, "
                            . "nr_celular, "
                            . "ao_ativo, "
                            . "ds_loginportal, "
                            . "ao_sexo, "
                            . "(DATE_FORMAT(NOW(),'%Y')-DATE_FORMAT(dt_nascimento,'%Y'))-(DATE_FORMAT(NOW(),'00-%m-%d')< DATE_FORMAT(dt_nascimento,'00-%m-%d')) as idade, "
                            . "dt_alteracao, "
                            . "dt_cadastro "
                            . "FROM candidato WHERE nm_candidato LIKE '%".$busca_candidato."%' ORDER BY nm_candidato";
                    
                    $candidatos = mysql_query($sql);
                    
                    $res = array();
                    while($sqlCandidato = mysql_fetch_object($candidatos)){
                        $res[] = $sqlCandidato;                        
                    }                  
                    
                    $_SESSION['candidatos'] = $res;                    
                    $_SESSION['post_busca_candidato'] = $_POST['busca_candidato'];
                    
                    header("location:busca.php#parte-00");
                    
                }else {
                    $_SESSION['erros'] = $erros;
                    $_SESSION['post'] = $_POST;
                    header('location:busca.php#parte-00');
                }
                
            }
            break;
            
       case 'resetarSenha':
           if (isset($_POST)) {
                $erros = array();
                
                if (!validarIdCandidato($_POST['id_candidato']) && empty($_POST['id_candidato'])) $erros[] = 'id_candidato';
                if (!validarNomeProprietario($_POST['nm_candidato']) && !empty($_POST['nm_candidato'])) $erros[] = 'nm_candidato';
                
                if (count($erros) == 0) {
                    
                    $senha = geraSenha(6, false, true);
                    $senhaCriptografada = md5($senha);
                    $login = $_POST['ds_loginportal'];
                    
                    $sqlSenha = "UPDATE candidato SET "
                              . "pw_senhaportal = '$senhaCriptografada', "
                              . "ao_interno = 'S' "
                              . "WHERE id_candidato = '".$_POST['id_candidato']."'";
                    
                    $novasenha = mysql_query($sqlSenha);                    
                    
                    //gravo o log do usuario do interno que resetou a senha e a qual candidato.
                    $sql_logresetarsenha = "INSERT INTO logresetarsenhacandidato "
                                         . "(id_usuario, "
                                         . "id_candidato, "
                                         . "dt_logresetarsenhacandidato) "
                                         . "VALUES("                                         
                                         . "'".$_SESSION['id_usuario']."', "
                                         . "'".$_POST['id_candidato']."', "
                                         . "now())";
                    
                    $query_logresetarsenha = mysql_query($sql_logresetarsenha);
                                                            
                    //assunto do email
                    $assunto = "Banco de Oportunidades - Nova senha solicitada";
                    //mensagem do email
                    $corpo = "<p>
                            Você solicitou uma nova senha para o administrativo do banco de oportunidades,
                            ao acessar sua conta será solicitado a alteração da mesma para sua segurança.
                            </p>
                            Seu login: <b>$login</b><br />
                            Sua nova senha: <b>$senha</b>";
                        
                    //envia o email
                    Email::enviarEmail($_POST['ds_email'], $assunto, $corpo, $_POST['nm_candidato']);
                    //header('location:busca.php#parte-00');
                                        
                }
           }else {
                    $_SESSION['erros'] = $erros;
                    $_SESSION['post'] = $_POST;
                    header('location:busca.php#parte-00');
           }
           break;
    case 'enviarEmail':
        if (isset($_POST)) {
            $erros = array();
            
            if (!validarIdCandidato($_GET['edita']) && empty($_GET['edita'])) $erros[] = 'id_candidato';
            if(empty($_POST['ds_assunto'])) $erros[] = 'ds_assunto';
            if(empty($_POST['ds_emailindividual'])) $erros[] = 'ds_emailindividual';
            
            if (count($erros) == 0) {
                
                $sqlEmail = "SELECT id_candidato, nm_candidato, ds_email FROM candidato where id_candidato = '".$_GET['edita']."'";
                
                $queryEmail = mysql_query($sqlEmail);

                $emailCandidato = mysql_fetch_object($queryEmail);
                                
                
                $arquivo = isset($_FILES['arquivo']) ? $_FILES['arquivo'] : FALSE;
                
                //verifico se o nome foi passado, se não coloca na tabela como não enviou anexo, caso contrário sim.
                if($_FILES['arquivo']['name'] == ""){
                    $anexo = "N";
                }else{
                    $anexo = "S";
                }
                
                //assunto do email
                $assunto = $_POST['ds_assunto'];
                //mensagem do email, nl2br: se tiver quebra de linhas para mostrar.
                $corpo = "<p>".
                        nl2br($_POST['ds_emailindividual'])
                        ."</p>";
                                                
                //envia o email
                Email::enviarEmail($emailCandidato->ds_email, $assunto, $corpo, $emailCandidato->nm_candidato, $arquivo);
                
                //gravo o log do usuario ao enviar o email individual ao candidato
                $sql_logenviaremailcandidato = "INSERT INTO logenviaremailcandidato "
                                     . "(id_usuario, "
                                     . "id_candidato, "
                                     . "ds_assunto, "
                                     . "ds_email, "
                                     . "ao_anexo, "
                                     . "dt_logenviaremailcandidato) "
                                     . "VALUES("                                         
                                     . "'".$_SESSION['id_usuario']."', "
                                     . "'".$emailCandidato->id_candidato."', "
                                     . "'".$assunto."', "                                     
                                     . "'".$corpo."', "
                                     . "'".$anexo."', "
                                     . "now())";
                
                $query_logenviaremailcandidato = mysql_query($sql_logenviaremailcandidato);
                
                $_SESSION['erros'] = $erros;
                $_SESSION['post'] = $_POST;
                $_SESSION['enviouEmail'] = 'ENVIOUEMAIL';
                
                header('location:editaCandidato.php?edita='.$_GET['edita'].'#parte-02');
                
                
            }else {
                $_SESSION['erros'] = $erros;
                $_SESSION['post'] = $_POST;
                header('location:editaCandidato.php?edita='.$_GET['edita'].'#parte-02');
           }        
        }
        break;
        case 'destruirSessaoBuscaCandidato':
            
            if($_POST['destruirSessaoBuscaCandidato']){
                unset($_SESSION["candidatos"]);
                unset($_SESSION["post_busca_candidato"]);
            }
        break;    
    }
}