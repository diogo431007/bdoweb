<?php
//if($_SERVER["REMOTE_ADDR"] != "189.38.85.36"){
//    die("Acesso nao Autorizado");
//}

include_once './conecta.php';
include_once './Email.class.php';

$sql = "SELECT
            p.id_profissao,
            p.nm_profissao,
            p.dt_inclusao,
            p.dt_alteracao
        FROM
            profissao p
        WHERE
            p.ao_ativo = 'S' AND
            datediff(date(now()),p.dt_inclusao) <= 7";

$query = mysql_query($sql);
$profissoes = array();

while($row = mysql_fetch_object($query)){
    $profissoes[] = $row;
}

if(count($profissoes) > 0){    
    
    $assunto = "Banco de Oportunidades - Novas profissões";
            
    $corpoEmail = "<p>
                        A Prefeitura Municipal de Canoas por intermédio da Secretaria Municipal de Desenvolvimento Econômico
                        informa as seguintes profissões cadastradas nesta semana.
                   </p>
                   <b>";
                        foreach($profissoes as $p){
                            $corpoEmail .= $p->nm_profissao.'<br/>';
                        }
    $corpoEmail .= "</b>:
                       <br/><br/>";
    
    
    $sql = "SELECT
                c.id_candidato,
                c.nm_candidato,
                c.ds_email,
                c.dt_validade
            FROM
                candidato c
            WHERE
                c.dt_validade BETWEEN DATE(NOW()) AND c.dt_validade
            ";

    $query = mysql_query($sql);
    $candidatos = array();

    while($row = mysql_fetch_object($query)){
        $candidatos[] = $row;
    }

    if(count($candidatos) > 0){

        foreach($candidatos as $c){
            $emailCand = $c->ds_email;
            $nomeCand = $c->nm_candidato;

            Email::enviarEmail($emailCand, $assunto, $corpoEmail, $nomeCand);
           // Email::enviarEmail('ricardo.cruz@canoastec.rs.gov.br', $assunto, $corpoEmail, $nomeCand);
        }
    }       
    
    $sql = "SELECT
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
                e.ao_status = 'S'
            ";

    $query = mysql_query($sql);
    $empresas = array();

    while($row = mysql_fetch_object($query)){
        $empresas[] = $row;
    }    
    
    if(count($empresas) > 0){
        foreach ($empresas as $e) {

            $emailEmp = $e->ds_email;
            $emailProp = $e->ds_emailproprietario;
            
            $nomeEmp = (!empty($e->nm_fantasia)) ? $e->nm_fantasia : $e->nm_razaosocial;
            $nomeProp = $e->nm_proprietario;

            Email::enviarEmail($emailEmp, $assunto, $corpoEmail, $nomeEmp);
            Email::enviarEmail($emailProp, $assunto, $corpoEmail, $nomeProp);
            //Email::enviarEmail('ricardo.cruz@canoastec.rs.gov.br', $assunto, $corpoEmail, $nomeProp);
        }
    }
    
}



                
            

?>
