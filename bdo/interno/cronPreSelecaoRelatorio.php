<?php
//if($_SERVER["REMOTE_ADDR"] != "172.30.0.22" || $_SERVER["SERVER_ADDR"] != "172.30.0.22"){
//    die("Acesso Não Autorizado");
//}

include_once './conecta.php';
include_once '../publico/util/Email.class.php';

ini_set('memory_limit', '-1');
set_time_limit(300);
ini_set('max_input_time', '-1');

//verifica as empresas que tem candidatos pré-selecionados nos últimos 15 dias.
$sql = "SELECT
            vc.id_vaga, vc.ao_status, v.id_empresa, e.nm_razaosocial, e.ds_email, p.nm_profissao
        FROM
            vagacandidato vc, vaga v, empresa e, profissao p
        WHERE
            vc.ao_status = 'P' AND
            v.ao_ativo = 'S' AND
            p.ao_ativo = 'S' AND
            vc.id_vaga = v.id_vaga AND
            v.id_empresa = e.id_empresa AND
            v.id_profissao = p.id_profissao AND
            DATEDIFF(now(), vc.dt_status) <= '15'
        GROUP BY
            vc.id_vaga";


$query = mysql_query($sql);




while($row = mysql_fetch_object($query)){
    $nomeEmpresa = $row->nm_razaosocial;
    $emailEmpresa = $row->ds_email;
    $assunto = "Banco de Oportunidades - Relatório de Pré-Seleção dos últimos 15 dias";
    
    $corpoEmpresa = "$nomeEmpresa, os candidatos abaixo foram pré-selecionados nos últimos 15 dias para a vaga de <b>$row->nm_profissao</b>, solicitamos que faça atualização com relação a contração ou despensa dos mesmos.
                    Acesse a ferramenta para realizar essas atualizações ou envie a lista dos contratados para o email <b>canoasqualificar.smde@gmail.com</b><br/>";
    
    $sqlLista = "SELECT 
                    v.id_vaga, vc.id_vagacandidato, c.id_candidato, c.id_deficiencia, c.nm_candidato, c.ao_sexo
                 FROM
                    vagacandidato vc, vaga v, candidato c
                 WHERE
                    vc.id_vaga = v.id_vaga AND                                    
                    vc.id_candidato = c.id_candidato AND
                    vc.ao_status = 'P' AND                                    
                    c.ao_ativo = 'S' AND
                    v.id_vaga = '$row->id_vaga' AND
                    DATEDIFF(now(), vc.dt_status) <= 15
                 ORDER BY
                    vc.id_vaga";

        $queryLista  = mysql_query($sqlLista);
        
        while($lista = mysql_fetch_object($queryLista)){
            
            if($lista->id_deficiencia <> NULL){                
                $sqlDeficiencia = "SELECT id_deficiencia, nm_deficiencia "
                            . "FROM deficiencia WHERE id_deficiencia = $lista->id_deficiencia";
                                        
                $deficiencia = mysql_fetch_object(mysql_query($sqlDeficiencia));
                    
                if($lista->ao_sexo == 'M'){
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
                                <b>Nome:</b> $lista->nm_candidato <br/>
                                <b>Código:</b> $lista->id_candidato
                              </p>";                
            $corpoEmpresa."<br>";                        
            
        }
            
    //Envia o email para a empresa com a vaga e os candidatos pré-selecionados nos últimos 15 dias
    Email::enviarEmail($emailEmpresa, $assunto, $corpo, $nomeEmpresa);
    
    //Cópia para a pessoa moderadora
    Email::enviarEmail('canoasqualificar.smde@gmail.com', $assunto, $corpo, 'SMDE');
    Email::enviarEmail('alisson.vieira@canoastec.rs.gov.br', $assunto, $corpo, 'Alisson Vieira');
    Email::enviarEmail('flavio.treib@canoastec.rs.gov.br', $assunto, $corpo, 'Flavio Treib');
    
}

?>