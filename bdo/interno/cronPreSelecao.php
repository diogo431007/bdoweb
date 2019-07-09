<?php
//if($_SERVER["REMOTE_ADDR"] != "172.30.0.22" || $_SERVER["SERVER_ADDR"] != "172.30.0.22"){
//    die("Acesso Não Autorizado");
//}

include_once './conecta.php';
include_once '../publico/util/Email.class.php';

ini_set('memory_limit', '-1');
set_time_limit(300);
ini_set('max_input_time', '-1');

$sql = "SELECT
            vc.id_vaga, vc.id_candidato, vc.ao_status, c.id_candidato, v.id_vaga, p.nm_profissao, c.nm_candidato, c.ds_email, c.ao_sexo
        FROM
            vagacandidato vc, candidato c, vaga v, profissao p
        WHERE
            vc.ao_status = 'P' AND
            vc.id_candidato = c.id_candidato AND
            vc.id_vaga = v.id_vaga AND
            v.id_profissao = p.id_profissao AND
            c.ao_ativo = 'S' AND
            DATEDIFF(now(), vc.dt_status) = 15";


$query = mysql_query($sql);

while($row = mysql_fetch_object($query)){
    
    
    $assunto = 'Banco de Oportunidades - Pergunta';
    $nomeCand = $row->nm_candidato;
    $emailCand = $row->ds_email;    
    
    if($row->ao_sexo == "M"){
        $prezado = "Prezado";
    }else{
        $prezado = "Prezada";
    }
    
    $corpo = "$prezado $nomeCand, <br/><br/>
        
                A Prefeitura Municipal de Canoas por intermédio da Secretaria Municipal de Desenvolvimento Econômico
               lhe faz a segunte pergunta:<br/><br/>
               
               <b>Notamos que faz 15 dias que você foi pré-selecionado para a vaga de $row->nm_profissao, você foi contratado?</b><br/><br/>
               
               *Este email é automático e informativo, pedimos que responda para esse email: <b>canoasqualificar.smde@gmail.com</b><br/>
               Obrigado.<br/><br/>";
        
    //Envia o email para o candidato a 15 dias pré-selecionado com a pergunta.
    Email::enviarEmail($emailCand, $assunto, $corpo, $nomeCand);
}

?>