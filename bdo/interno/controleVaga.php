<?php
session_start();
include_once './conecta.php';
include_once './funcoes.php';
include_once './Email.class.php';

if (isset($_GET['op'])) {
    switch ($_GET['op']) {
        case 'buscar':
            if (isset($_POST) || isset($_SESSION['dados'])) {
                
                $erros = array();
                
                if(isset($_POST)){
                    if(!is_numeric($_POST['empresa']) && !empty($_POST['empresa'])) $erros[] = 'empresa';
                    //if(!validarStatus($_POST['ao_ativo'])) $erros[] = 'ao_ativo';
                    if(!is_numeric($_POST['profissao']) && !empty($_POST['profissao'])) $erros[] = 'profissao';
                }
                
                if(count($erros)==0){
                   
//                   var_dump($_SESSION);
//                   var_dump($_POST);die;
                    
                    if(isset($_POST['empresa']) && isset($_POST['empresa'])){
                        $id_empresa = (!empty($_POST['empresa'])) ? "and e.id_empresa = ".$_POST['empresa'] : '';
                        //$ao_ativo = ($_POST['ao_ativo'] != 'T') ? "and v.ao_ativo = '".$_POST['ao_ativo']."'" : '';
                        $id_profissao = (!empty($_POST['profissao'])) ? "and p.id_profissao = ".$_POST['profissao'] : '';
//                        die('post');
                        $_SESSION['dados'] = $_POST;
                    }else{
                        $id_empresa = (!empty($_SESSION['dados']['empresa'])) ? "and e.id_empresa = ".$_SESSION['dados']['empresa'] : '';
                        //$ao_ativo = ($_SESSION['dados']['ao_ativo'] != 'T') ? "and v.ao_ativo = '".$_SESSION['dados']['ao_ativo']."'" : '';
                        $id_profissao = (!empty($_SESSION['dados']['profissao'])) ? "and p.id_profissao = ".$_SESSION['dados']['profissao'] : '';
//                        die('sessao');
                    }
                    
                    $ao_ativo = "and v.ao_ativo = 'S'";
                    
                    $sql = "SELECT 
                                e.id_empresa,
                                e.nm_razaosocial,
                                e.nm_fantasia,
                                v.id_vaga,
                                v.qt_vaga,
                                v.ao_sexo,
                                p.id_profissao,
                                p.nm_profissao
                            FROM 
                                empresa e
                                JOIN vaga v ON (v.id_empresa = e.id_empresa)
                                JOIN profissao p ON (v.id_profissao = p.id_profissao)
                            WHERE 
                                1=1
                                $id_empresa
                                $ao_ativo
                                $id_profissao";
                    //die($sql);
                    $query = mysql_query($sql);
                    
                    $auxVagas = array();
                    while($row = mysql_fetch_object($query)) {
                        $auxVagas[] = $row;
                    }
                    //echo "<pre>";
                    //print_r($auxVagas);
                    //echo "</pre>";die;
                    $vagas = array();
                    foreach ($auxVagas as $v) {
                        
                        $filtro_sexo = ($v->ao_sexo != 'I') ? " c.ao_sexo = '$v->ao_sexo' and " : '' ;
                        $sql = "SELECT 
                                    c.id_candidato,
                                    c.nm_candidato
                                FROM 
                                    candidato c
                                    LEFT JOIN candidatoprofissao cp ON (c.id_candidato = cp.id_candidato)
                                WHERE
                                    $filtro_sexo
                                    cp.id_profissao = $v->id_profissao
                                    and (c.id_candidato not in  (select id_candidato from vagacandidato where id_vaga = $v->id_vaga) and
                                        c.id_candidato not in  (select id_candidato from vagacandidato cv, vaga v where v.id_vaga  <> $v->id_vaga
                                                                                                        and cv.id_vaga = v.id_vaga
                                                                                                        and v.id_empresa =   $v->id_empresa
                                                                                                        and cv.ao_status = 'C')
                                        )
                                    
                                ORDER BY 
                                    c.nm_candidato ASC";
                        //echo $sql."<br>";
                        $query = mysql_query($sql);
                        
                        $candidatos = array();
                        
                        while($row = mysql_fetch_object($query)){
                            $candidatos[] = $row;
                        }
                        
                        $v->candidatos = $candidatos;
                        
                        if(count($v->candidatos)>0){
                            $vagas[] = $v;
                        }
                        
                    }
                    //echo "<pre>";
                   // print_r($vagas);
                    //echo "</pre>";
                    //die;
                    $_SESSION['arrayVagas'] = $vagas;
                    
                    header("location:relatorio.php#parte-03");
                    
                }else{
                    $_SESSION['erros'] = $erros;
                    $_SESSION['dados'] = $_POST;
                    header('location:relatorio.php#parte-03');
                }
                
                
            }
            break;
            
        case 'encaminhar':
            if (isset($_POST)) {
                
                $erros = array();
                
                if(!is_numeric($_POST['vaga'])) $erros[] = 'vaga';
                
                if(is_array($_POST['candidatos'])){
                    foreach ($_POST['candidatos'] as $id) {
                        if(!is_numeric($id)) $erros[] = 'candidato';
                    }
                }else{
                    $erros[] = 'candidato';
                }
                
                if(count($erros)==0){
                    
                    $msg = '';
                    
                    /*
                     * registra o encaminhamento da vaga na tabela vagacandidato
                     */
                    $id_vaga = $_POST['vaga'];
                    
                    foreach ($_POST['candidatos'] as $c) {
                        
                        $sql = "INSERT INTO vagacandidato (id_vagacandidato, 
                                                            id_vaga, 
                                                            id_candidato, 
                                                            ao_status, 
                                                            dt_status
                                                        )VALUES (
                                                            null, 
                                                            $id_vaga, 
                                                            $c, 
                                                            'E', 
                                                            now())";
                        
                        $query = mysql_query($sql);
                        
                        if(!$query){
                            $msg = 'Ocorreu um erro, tente novamente';
                            break;
                        }
                        
                    }
                    
                    if($msg == ''){
                        $msg = 'Candidatos encaminhados com sucesso';
                    }
                    
                    $_SESSION['msgE'] = $msg;
                    
                    
                    
                    /*
                     * busca os dados da vaga e empresa
                     */
                    $sql = "SELECT 
                                e.id_empresa,
                                e.nm_razaosocial,
                                e.nm_fantasia,
                                e.nm_contato,
                                e.ds_email,
                                v.id_vaga,
                                v.ds_atribuicao,
                                v.nr_salario,
                                v.ds_adicional,
                                v.ds_beneficio,
                                v.ds_observacao,
                                v.qt_vaga,
                                p.id_profissao,
                                p.nm_profissao
                            FROM 
                                empresa e
                                JOIN vaga v ON (v.id_empresa = e.id_empresa)
                                JOIN profissao p ON (v.id_profissao = p.id_profissao)
                            WHERE 
                                v.id_vaga = $id_vaga";
                    
                    $query = mysql_query($sql);
                    
                    $auxVaga = array();
                    while($row = mysql_fetch_object($query)) {
                        $auxVaga = $row;
                    }
                    
                    
                    /*
                     * busca os contatos recrutadores da empresa
                     */
                    $sql = "SELECT 
                                    ed.nm_proprietario,
                                    ed.nr_celular,
                                    ed.ds_emailproprietario
                            FROM 
                                    empresa e 
                                    JOIN empresadetalhe ed ON (ed.id_empresa = e.id_empresa) 
                            WHERE 
                                    ed.ao_recrutador = 'S'
                                    and ed.ao_status = 'S'
                                    and e.id_empresa = $auxVaga->id_empresa";
                    
                    $query = mysql_query($sql);
                    
                    $auxContatos = array();
                    while($row = mysql_fetch_object($query)) {
                        $auxContatos[] = $row;
                    }
                    
                    /*
                     * busca os dados dos candidatos
                     */
                    $auxCandidatos = array();
                    foreach ($_POST['candidatos'] as $id_cand) {
                        
                        $sql = "SELECT 
                                    c.id_candidato,
                                    c.ds_email, 
                                    c.nm_candidato 
                                FROM 
                                    candidato c 
                                WHERE 
                                    c.id_candidato = $id_cand";
                        
                        $query = mysql_query($sql);

                        
                        while($row = mysql_fetch_object($query)) {
                            $auxCandidatos[] = $row;
                        }
                    }
                    
                    $corpoEmpresa = "A Prefeitura Municipal de Canoas por intermédio da Secretaria Municipal de Desenvolvimento Econômico
                                        lhe encaminha os seguintes candidatos para vaga de <b>$auxVaga->nm_profissao</b>:
                                            <br/><br/>";
                    foreach ($auxCandidatos as $cand) {
                        $corpoEmpresa .= "<p>
                                            <b>Nome:</b> $cand->nm_candidato<br/>
                                            <b>Código</b>: $cand->id_candidato
                                          </p>";
                    }
                    
                    /*
                     * monta os recrutadores
                     */
                    if(count($auxContatos)>0){
                        $contatos = '<p>Para maiores informações entre em contato com:<br/>';
                        foreach ($auxContatos as $cont) {
                            
                            $contatoEmpresa = $cont->nm_proprietario;
                            $emailEmpresa = $cont->ds_emailproprietario;
                            $assunto = 'Banco de Oportunidade - Encaminhamento';
                            Email::enviarEmail($emailEmpresa, $assunto, $corpoEmpresa, $contatoEmpresa);
                            
                            $contatos .= '<p>
                                            <b>'.$cont->nm_proprietario.'</b>
                                            <br/>
                                            Telefone: '.$cont->nr_celular.
                                            '<br/>
                                            E-mail: '.$cont->ds_emailproprietario.
                                          '</p>';
                        }
                        $contatos .= '</p>';
                    }
                    
                    
                    /*
                     * busca os dados dos candidatos
                     */
                    foreach ($auxCandidatos as $cand) {
                        
                        /*
                         * dispara email para os candidatos
                         */
                        $nm_empresa = (!empty($auxVaga->nm_fantasia)) ? $auxVaga->nm_fantasia : $auxVaga->nm_razaosocial;
                        $nr_salario = (!empty($auxVaga->nr_salario)) ? 'R$ '.number_format($auxVaga->nr_salario,2,',','.') : 'Confidencial';
                        $emailCand = $cand->ds_email;
                        $assunto = 'Banco de Oportunidade - Encaminhamento';
                        $corpoCand = "A Prefeitura Municipal de Canoas por intermédio da Secretaria Municipal de Desenvolvimento Econômico
                                        lhe encaminha a seguinte oportunidade de trabalho:
                                            <br/><br/>
                                            Profiissão: $auxVaga->nm_profissao
                                            <br/>
                                            Empresa: $nm_empresa
                                            <br/>
                                            Atribuições: $auxVaga->ds_atribuicao
                                            <br/>
                                            Salário: $nr_salario
                                            <br/>
                                            Adicional: $auxVaga->ds_adicional
                                            <br/>
                                            Benefício: $auxVaga->ds_beneficio
                                        ";
                        $corpoCand .= $contatos;
                        $nomeCand = $cand->nm_candidato;

                        Email::enviarEmail($emailCand, $assunto, $corpoCand, $nomeCand);
                    }
//                    var_dump($_POST);
//                    var_dump($_SESSION);
//                    die('aqui');
                    header("location:controleVaga.php?op=buscar");
                    
                }else{
                    $_SESSION['errosE'] = $erros;
                    header('location:relatorio.php#parte-03');
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
