<?php
//if($_SERVER["REMOTE_ADDR"] != "172.30.0.22" || $_SERVER["SERVER_ADDR"] != "172.30.0.22"){
//    die("Acesso Não Autorizado");
//}

include_once './conecta.php';
include_once '../publico/util/Email.class.php';

ini_set('memory_limit', '-1');
set_time_limit(300);
ini_set('max_input_time', '-1');

//Passa todos candidatos que estão a mais de 30 dias como encaminhado para baixa automática.
$sql = "UPDATE "
        . "vagacandidato "
        . "SET ao_status = 'B' "
        . "WHERE ao_status = 'E' "
        . "and DATEDIFF(now(), dt_status) > 30";

//$query = mysql_query($sql);

//Lista todos os candidatos que estão encaminhados a mais de 30 dias no histórico e não estão com baixa automática.
$sqlHistorico = "SELECT * FROM historicocandidato AS vc WHERE ao_status = 'E' AND ao_status <> 'B'
                        AND DATEDIFF(now(), dt_cadastro) > 30
                            AND NOT EXISTS(SELECT id_vagacandidato 
                            FROM historicocandidato AS hc WHERE hc.id_vagacandidato = vc.id_vagacandidato 
                            AND ao_status = 'B')";

$queryHistorico = mysql_query($sqlHistorico);

while($row = mysql_fetch_object($queryHistorico)) {
        
               //No banco está como padrão 'NULL' então vazio ele não está aceitando, resolvido com a variável $empresa.
               if($row->id_usuario == ""){
                   $empresa = 'NULL';
               }else{
                   $empresa = $row->id_usuario;
               }
                
               //Insere na tabela histórico do candidato a baixa automática.
               $sqlHistoricoBaixa = "INSERT INTO historicocandidato
                                        (                                               
                                            id_vagacandidato, 
                                            id_usuario,
                                            id_motivo,
                                            ds_motivodispensa,
                                            ao_status, 
                                            dt_cadastro
                                         )VALUES(                                                             
                                            $row->id_vagacandidato,
                                            $empresa, 
                                            NULL, 
                                            NULL,
                                            'B',
                                            now())";
                                               
                //$queryHistoricoBaixa = mysql_query($sqlHistoricoBaixa);

}

//###################################################################################################
//Lista todos os candidatos que estão com 25 dias de encaminhamento faltando 5 dias para baixa
// e avisa a empresa qua cadastrou a vaga mostrando todos.


//lista a empresa que tem vaga com candidato faltando 5 dias para baixa automática
$sqlListar = "SELECT 
                 vc.id_vaga, v.id_empresa, p.nm_profissao, e.nm_razaosocial, e.ds_email 
              FROM 
                 vagacandidato vc, vaga v, empresa e, profissao p
              WHERE
                 vc.id_vaga = v.id_vaga AND
                 v.id_empresa = e.id_empresa AND
                 v.id_profissao = p.id_profissao AND
                 v.ao_ativo = 'S' AND
                 vc.ao_status = 'E' AND                 
                 DATEDIFF(now(), vc.dt_status) = '25'
              GROUP BY
                 vc.id_vaga";

$queryListar  = mysql_query($sqlListar);

while($listar = mysql_fetch_object($queryListar)){
    
        $nomeEmpresa = $listar->nm_razaosocial;
        $emailEmpresa = $listar->ds_email;
        $assunto = 'Banco de Oportunidades - Baixa Automática';
        
        
        $corpoEmpresa = "A Prefeitura Municipal de Canoas por intermédio da Secretaria Municipal de Desenvolvimento Econômico
                            lhe encaminha os seguintes candidatos faltando 5 dias para baixa automática da vaga de <b>$listar->nm_profissao</b>:
                                <br/><br/>";
    
        $sqlQuaseBaixa = "SELECT 
                                    v.id_vaga, vc.id_vagacandidato, c.id_candidato, c.id_deficiencia, c.nm_candidato, c.ao_sexo
                            FROM
                                    vagacandidato vc, vaga v, candidato c
                            WHERE
                                    vc.id_vaga = v.id_vaga AND                                    
                                    vc.id_candidato = c.id_candidato AND
                                    vc.ao_status = 'E' AND                                    
                                    c.ao_ativo = 'S' AND
                                    v.id_vaga = '$listar->id_vaga' AND
                                    DATEDIFF(now(), vc.dt_status) = 25
                            ORDER BY
                                    vc.id_vaga";

        $queryQuaseBaixa  = mysql_query($sqlQuaseBaixa);
       
        while($quaseBaixa = mysql_fetch_object($queryQuaseBaixa)){
            
            if($quaseBaixa->id_deficiencia <> NULL){                
                $sqlDeficiencia = "SELECT id_deficiencia, nm_deficiencia "
                            . "FROM deficiencia WHERE id_deficiencia = $quaseBaixa->id_deficiencia";
                                        
                $deficiencia = mysql_fetch_object(mysql_query($sqlDeficiencia));
                    
                if($quaseBaixa->ao_sexo == 'M'){
                    $generoPNE = "Candidato";
                }else{
                    $generoPNE = "Candidata";
                }
                
                //Avisa para empresa que o candidato possui deficiência
                $candDeficiente = $generoPNE." com deficiência $deficiencia->nm_deficiencia<br />";
                
            }else{
                $candDeficiente = "";
            }
            
            $corpoEmpresa .= "<p>
                                <b>$candDeficiente</b>
                                <b>Nome:</b> $quaseBaixa->nm_candidato <br/>
                                <b>Código:</b> $quaseBaixa->id_candidato
                              </p>";                
            $corpoEmpresa."<br>";
            
        }
        
        $corpoEmpresa .= "*Baixas automáticas acontecem quando o candidato fica 30 dias com o status de encaminhado para esta vaga.<br><br>";
               
        //Envia o email para a empresa com a vaga e os candidatos que faltam 5 dias para a baixa.
        Email::enviarEmail($emailEmpresa, $assunto, $corpo, $nomeEmpresa);        
    
}

?>