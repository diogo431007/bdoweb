<?php
//if($_SERVER["REMOTE_ADDR"] != "172.30.0.22" || $_SERVER["SERVER_ADDR"] != "172.30.0.22"){
//    die("Acesso Não Autorizado");
//}

include_once './conecta.php';
include_once '../publico/util/Email.class.php';

ini_set('memory_limit', '-1');
set_time_limit(900);
ini_set('max_input_time', '-1');

//######################MANDA EMAIL QUANDO ESTIVER 60 OU 70 OU 80 DIAS SEM ACESSO #########################
$sqlaviso = "SELECT 
            l.id_log,
            l.id_acesso,
            l.ao_tipo,            
            MAX(DATE_FORMAT(l.dt_log, '%d/%m/%Y')) as data,
            MAX(DATE_FORMAT(l.dt_log, '%H:%i:%s')) as hora,
            DATEDIFF(now(), l.dt_log) as diasacesso,
            c.nm_candidato as nome,
            c.ao_sexo,
            c.ds_email
        FROM 
            log l, 
            candidato c 
        WHERE
            l.id_acesso = c.id_candidato AND 
            l.ao_tipo = 'C' AND 
            ((DATEDIFF(now(), l.dt_log) = 60) OR (DATEDIFF(now(), l.dt_log) = 70) OR (DATEDIFF(now(), l.dt_log) = 80)) AND
            c.ao_ativo <> 'A' AND
            c.ao_ativo <> 'N' AND
            NOT EXISTS
            (SELECT * FROM log lg 
                           WHERE lg.id_acesso = l.id_acesso AND
                           DATEDIFF(now(), lg.dt_log) <= 90)
            GROUP BY
                    l.id_acesso                                 		
        ORDER BY l.dt_log ASC";

$queryaviso = mysql_query($sqlaviso);

$candidatosaviso = array();
while($rowaviso = mysql_fetch_object($queryaviso)) {
    $candidatosaviso[] = $rowaviso;
}

if(count($candidatosaviso)>0){
    foreach ($candidatosaviso as $ca) {
               
      $nomeCandaviso = $ca->nome;
      $emailCandaviso = $ca->ds_email;
             
      
      $assuntoaviso = "Banco de Oportunidade - Inativação";
      
      if($ca->ao_sexo == "M"){
          $prezadoaviso = "Prezado";
      }else{
          $prezadoaviso = "Prezada";
      }      
            
      $corpoaviso = "$prezadoaviso $nomeCandaviso, <br/><br/>";
      $corpoaviso.= "Seu currículo está a $ca->diasacesso dias sem acesso, lembramos que com 90 dias sem acessar o sistema ele será inativado,"
              . " deste modo você não estará concorrendo a novas vagas como inativo. Acesse o Banco de Oportunidades e atualize seu currículo.";
            
      Email::enviarEmail($emailCandaviso, $assuntoaviso, $corpoaviso, $nomeCandaviso);
      
    }    
}

//######################INATIVA O CANDIDATO COM MAIS DE 90 DIAS SEM ACESSO#########################

//Seleciona todos os candidatos que estão sem acesso no sistema a mais de 90 dias.
$sql = "SELECT 
            l.id_log,
            l.id_acesso,
            l.ao_tipo,            
            MAX(DATE_FORMAT(l.dt_log, '%d/%m/%Y')) as data,
            MAX(DATE_FORMAT(l.dt_log, '%H:%i:%s')) as hora,
            c.nm_candidato as nome,
            c.ao_sexo,
            c.ds_email            
        FROM 
            log l, 
            candidato c 
        WHERE
            l.id_acesso = c.id_candidato AND 
            l.ao_tipo = 'C' AND 
            DATEDIFF(now(), l.dt_log) > 90 AND
            c.ao_ativo <> 'A' AND
            c.ao_ativo <> 'N' AND
            NOT EXISTS
            (SELECT * FROM log lg 
                           WHERE lg.id_acesso = l.id_acesso AND 
                           DATEDIFF(now(), lg.dt_log) <= 90)
            GROUP BY
                    l.id_acesso                                 		
        ORDER BY l.dt_log ASC";

$query = mysql_query($sql);

$candidatos = array();
while($row = mysql_fetch_object($query)) {
    $candidatos[] = $row;
}

if(count($candidatos)>0){
    foreach ($candidatos as $c) {
      
      $nomeCand = $c->nome;
      $emailCand = $c->ds_email;
      
              
      //Inativa todos os candidatos que não acessaram o banco a mais de 90 dias.
      $sqlInativacao = "UPDATE
                            candidato
                          SET
                            ao_ativo = 'S'
                          WHERE
                            id_candidato = '$c->id_acesso' AND
                            ao_ativo <> 'A'";
        
        $queryInativacao = mysql_query($sqlInativacao);
        
        
        $assunto = "Banco de Oportunidade - Inativação";
        
        if($c->ao_sexo == "M"){
            $prezadoavisoinativacao = "Prezado";
        }else{
            $prezadoavisoinativacao = "Prezada";
        }      
            
        $corpo = "$prezadoavisoinativacao $nomeCand, <br/><br/>";
                
        $corpo .= "Seu currículo esta sendo inativado por falta de acesso a mais de 90 dias,"
               . " deste modo você não estará concorrendo a novas vagas. Para ativá-lo entre com seu"
               . " login normalmente e na aba dados pessoais ative-o novamente.";
                
        Email::enviarEmail($emailCand, $assunto, $corpo, $nomeCand);
      
    }    
}

?>