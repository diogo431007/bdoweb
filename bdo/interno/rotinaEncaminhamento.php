<?php
//if($_SERVER["REMOTE_ADDR"] != "189.38.85.36"){
//    die("Acesso nao Autorizado");
//}

include_once './conecta.php';
include_once './Email.class.php';

$sql = "SELECT
            v.id_vaga,
            v.id_empresa,
            v.id_profissao,
            v.ds_atribuicao,
            v.nr_salario,
            v.ds_adicional,
            v.ds_beneficio,
            v.ds_observacao,
            v.qt_vaga,
            v.ao_sexo,
            e.nm_razaosocial,
            e.nm_fantasia,
            e.nm_proprietario,
            e.ds_emailproprietario,
            e.nr_celular,
            e.ao_selo,
            p.nm_profissao
        FROM
            vaga v
            JOIN empresa e ON (v.id_empresa = e.id_empresa) 
            JOIN profissao p ON (v.id_profissao = p.id_profissao) 
        WHERE
            v.ao_ativo = 'S'";
//die($sql);
$query = mysql_query($sql);

$vagas = array();
while($row = mysql_fetch_object($query)) {
    $vagas[] = $row;
}

if(count($vagas)>0){
    
    foreach ($vagas as $v) {
        $filtro_sexo = ($v->ao_sexo != 'I') ? " c.ao_sexo = '$v->ao_sexo' and " : '' ;
        $sql = "SELECT 
                    c.id_candidato,
                    c.nm_candidato,
                    c.ds_email,
                    c.id_deficiencia
                FROM 
                    candidato c
                    LEFT JOIN candidatoprofissao cp ON (c.id_candidato = cp.id_candidato)
                WHERE
                    $filtro_sexo
                    cp.id_profissao = $v->id_profissao
                    and (c.id_candidato not in (select id_candidato from vagacandidato where id_vaga = $v->id_vaga) and
                        c.id_candidato not in (select id_candidato from vagacandidato cv, vaga v where v.id_vaga  <> $v->id_vaga
                                                                                        and cv.id_vaga = v.id_vaga
                                                                                        and v.id_empresa =   $v->id_empresa
                                                                                        and cv.ao_status = 'C')
                        )

                ORDER BY 
                    c.nm_candidato ASC";
        //echo($sql);die;
        $query = mysql_query($sql);

        $candidatos = array();

        while($row = mysql_fetch_object($query)){
            $candidatos[] = $row;
        }

        $v->candidatos = $candidatos;

    }
    
    foreach ($vagas as $v) {
        
        if(count($v->candidatos)>0){
            
            $assunto = 'Banco de Oportunidade - Encaminhamento';
            
            //Email para empresa
            $corpoEmpresa = "A Prefeitura Municipal de Canoas por intermédio da Secretaria Municipal de Desenvolvimento Econômico
                            lhe encaminha os seguintes candidatos para vaga de <b>$v->nm_profissao</b>:
                                <br/><br/>";
            
            $corpoDeficiente = "A Prefeitura Municipal de Canoas por intermédio da Secretaria Municipal de Desenvolvimento Econômico
                            lhe encaminha os seguintes candidatos PCD (Pessoa com Deficiência) para vaga de <b>$v->nm_profissao</b>:
                                <br/><br/>";
            
            
            //Emaim para candidatos
            $nm_empresa = (!empty($v->nm_fantasia)) ? $v->nm_fantasia : $v->nm_razaosocial;
            $nr_salario = (!empty($v->nr_salario)) ? 'R$ '.number_format($v->nr_salario,2,',','.') : 'Confidencial';
            
            $corpoCand = "A Prefeitura Municipal de Canoas por intermédio da Secretaria Municipal de Desenvolvimento Econômico
                            lhe encaminha a seguinte oportunidade de trabalho:
                                <br/><br/>
                                Profiissão: $v->nm_profissao
                                <br/>
                                Empresa: $nm_empresa
                                <br/>
                                Atribuições: $v->ds_atribuicao
                                <br/>
                                Salário: $nr_salario
                                <br/>
                                Adicional: $v->ds_adicional
                                <br/>
                                Benefício: $v->ds_beneficio
                            <p>Para maiores informações entre em contato com:<br/>
                                <p>
                                    <b>$v->nm_proprietario</b>
                                    <br/>
                                    Telefone: $v->nr_celular
                                    <br/>
                                    E-mail: $v->ds_emailproprietario
                              </p>
                            </p>";
            
            foreach ($v->candidatos as $c){
                
                $sql = "INSERT INTO vagacandidato(id_vagacandidato, 
                                                        id_vaga, 
                                                        id_candidato, 
                                                        ao_status, 
                                                        dt_status
                                                    )VALUES(
                                                        null, 
                                                        $v->id_vaga, 
                                                        $c->id_candidato, 
                                                        'E', 
                                                        now())";
                        
                $query = mysql_query($sql);
                
                
                if($c->id_deficiencia != null || !is_null($c->id_deficiencia)){
                    
                    //Email para empresa ou coordenadoria
                    $corpoDeficiente .= "<p>
                                    <b>Nome:</b> $c->nm_candidato<br/>
                                    <b>Código</b>: $c->id_candidato
                                  </p>";
                    
                    //Email para a coordenadoria
                    //Email::enviarEmail('coomped.canoas@gmail.com', $assunto, $corpoEmpresa, 'COORDENADORIA');
                    Email::enviarEmail('dnevescarlos@gmail.com', $assunto, $corpoCand, 'COORDENADORIA');
                    
                }else if($c->id_deficiencia == null || is_null($c->id_deficiencia)){
                    
                    //Email para empresa
                    $corpoEmpresa .= "<p>
                                    <b>Nome:</b> $c->nm_candidato<br/>
                                    <b>Código</b>: $c->id_candidato
                                  </p>";
                    
                    //Email para candidatos
                    $emailCand = $c->ds_email;
                    $nomeCand = $c->nm_candidato;
                    //Email::enviarEmail($emailCand, $assunto, $corpoCand, $nomeCand);
                    Email::enviarEmail('flavio.treib@canoastec.rs.gov.br', $assunto, $corpoCand, $nomeCand);
                    
                }               
                
            }
            
            
            //Email para empresa com candidatos sem deficiencia
            $contatoEmpresa = $v->nm_proprietario;
            $emailEmpresa = $v->ds_emailproprietario;
            //Email::enviarEmail($emailEmpresa, $assunto, $corpoEmpresa, $contatoEmpresa);
            Email::enviarEmail('douglas.carlos@canoastec.rs.gov.br', $assunto, $corpoEmpresa, $contatoEmpresa);
            
            if($v->ao_selo == 'S'){
                
                //Email para empresa com candidatos deficientes
                //Email::enviarEmail($emailEmpresa, $assunto, $corpoDeficiente, $contatoEmpresa);
                Email::enviarEmail('douglas.carlos@canoastec.rs.gov.br', $assunto, $corpoDeficiente, $contatoEmpresa);
                
            }
//            else if($v->ao_selo == 'N'){
//                
//                //Email para a coordenadoria
//                //Email::enviarEmail('coomped.canoas@gmail.com', $assunto, $corpoEmpresa, 'COORDENADORIA');
//                Email::enviarEmail('flavio.treib@canoastec.rs.gov.br', $assunto, $corpoDeficiente, 'COORDENADORIA');
//                
//            }
            
        }
    }
    
}
?>
