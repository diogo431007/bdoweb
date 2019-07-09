<?php
//if($_SERVER["REMOTE_ADDR"] != "172.30.0.22" || $_SERVER["SERVER_ADDR"] != "172.30.0.22"){
//    die("Acesso Não Autorizado");
//}

$contCandidato = 0;
$contEmpresa = 0;
$contEmpresaFalso = 0;
$contCandidatoFalso = 0;

include_once './conecta.php';
//include_once './Email.class.php';
include_once '../publico/util/Email.class.php';

ini_set('memory_limit', '-1');
set_time_limit(300);
ini_set('max_input_time', '-1');

$sql = "SELECT
            v.id_vaga,
            v.id_empresa,
            v.id_profissao,
            v.ds_atribuicao,
            v.nr_salario,
            v.ds_adicional,
            v.ds_beneficio,
            v.ds_observacao,
            v.ao_sexo,
            v.qt_vaga,
            v.ds_estado_civil,
            v.ds_idade,
            v.ao_experiencia,
            v.ds_cnh,
            e.nm_razaosocial,
            e.nm_fantasia,
            e.nm_proprietario,
            e.ds_emailproprietario,
            e.nr_celular,
            e.ao_selo,
            p.nm_profissao,
            v.ao_exibenome,
            v.ao_exibetelefone,
            v.ao_exibeemail,
            v.ao_deficiente
        FROM
            vaga v
            JOIN empresa e ON (v.id_empresa = e.id_empresa) 
            JOIN profissao p ON (v.id_profissao = p.id_profissao)
        WHERE
            v.ao_ativo = 'S' and p.ao_ativo = 'S'";

$query = mysql_query($sql);

$vagas = array();
while($row = mysql_fetch_object($query)) {
    $vagas[] = $row;
}


if(count($vagas)>0){
    foreach ($vagas as $v) {
        
        //Pego as formações da vaga que a empresa deseja
        $sqlFormacao = "SELECT id_formacao FROM vagaformacao WHERE id_vaga = '$v->id_vaga'";
        
        $queryFormacao = mysql_query($sqlFormacao);
        
        //Jogo num array as formações para a vaga
        $formacao = array();
        while($rowFormacao = mysql_fetch_object($queryFormacao)) {
            $formacao[] = $rowFormacao;
        }
        
        $formacaoCandidato = "";
        //Verifico se o array está vazio, se não estiver atribuo os valores a ele
        if(!empty($formacao)){            
            //Uso o count para verificar se irá precisar do "OR" caso for mais de uma formação na vaga
            if(count($formacao) == 1){
                //apenas um formacao na vaga
                foreach($formacao as $fo){
                    $formacaoCandidato = " and cf.id_formacao = '$fo->id_formacao'";
                }
            }else if(count($formacao) > 2){
                //mais de uma formacao na vaga
                $formacaoCandidato = " and (";
                foreach($formacao as $fo){
                    $formacaoCandidato .= " cf.id_formacao = '$fo->id_formacao' OR";
                }
                $formacaoCandidato = substr($formacaoCandidato,0,-3);
                $formacaoCandidato .= " )";                
            }            
        }     
        
        //Verifico se a vaga é pra ambos os sexos I = indifirente ou se é M = Masculino, F = Feminino
        if($v->ao_sexo == "I"){
            $sexo = "(c.ao_sexo = 'M' or c.ao_sexo = 'F') ";
        }else{
            $sexo = "c.ao_sexo = '$v->ao_sexo' ";
        }
        
        //Verifica se a vaga é I = indifirente, N = não deficiente, S = deficiente                  
        if($v->ao_deficiente == "N"){
           $deficiente = "and c.id_deficiencia is null";
        }else if($v->ao_deficiente == "S"){
           $deficiente = "and c.id_deficiencia is not null";
        }else{
           $deficiente = "";
        }
        
        //Pego os candidatos com experiência, sem experiência ou ambos de acordo com o que foi cadastrado na vaga.
        if($v->ao_experiencia == "S"){
            $experiencia = " and c.ao_abaexperiencia = 'S'";
        }else if($v->ao_experiencia == "N"){
            $experiencia = " and c.ao_abaexperiencia = 'N'";
        }else{
            $experiencia = "";
        }
        
        //Filtra os candidatos por estado civil se estiver na vaga.
        if(!empty($v->ds_estado_civil)){
            $estado_civil = " and c.ds_estado_civil = '$v->ds_estado_civil'";
        }else{
            $estado_civil = "";            
        }
        
        
        //Filtra os candidatos por idade se estiver na vaga estabelecido
        if($v->ds_idade == '16'){
            $idadeMin = " and (DATE_FORMAT(NOW(),'%Y')-DATE_FORMAT(c.dt_nascimento,'%Y')-(DATE_FORMAT(NOW(),'00-%m-%d')< DATE_FORMAT(c.dt_nascimento,'00-%m-%d')) >= '14')";
            $idadeMax = " and (DATE_FORMAT(NOW(),'%Y')-DATE_FORMAT(c.dt_nascimento,'%Y')-(DATE_FORMAT(NOW(),'00-%m-%d')< DATE_FORMAT(c.dt_nascimento,'00-%m-%d')) <= '16')";
        }else if($v->ds_idade == '18'){
            $idadeMin = " and (DATE_FORMAT(NOW(),'%Y')-DATE_FORMAT(c.dt_nascimento,'%Y')-(DATE_FORMAT(NOW(),'00-%m-%d')< DATE_FORMAT(c.dt_nascimento,'00-%m-%d')) >= '16')";
            $idadeMax = " and (DATE_FORMAT(NOW(),'%Y')-DATE_FORMAT(c.dt_nascimento,'%Y')-(DATE_FORMAT(NOW(),'00-%m-%d')< DATE_FORMAT(c.dt_nascimento,'00-%m-%d')) <= '18')";
        }else if($v->ds_idade == '25'){
            $idadeMin = " and (DATE_FORMAT(NOW(),'%Y')-DATE_FORMAT(c.dt_nascimento,'%Y')-(DATE_FORMAT(NOW(),'00-%m-%d')< DATE_FORMAT(c.dt_nascimento,'00-%m-%d')) >= '16')";
            $idadeMax = " and (DATE_FORMAT(NOW(),'%Y')-DATE_FORMAT(c.dt_nascimento,'%Y')-(DATE_FORMAT(NOW(),'00-%m-%d')< DATE_FORMAT(c.dt_nascimento,'00-%m-%d')) <= '25')";
        }else if($v->ds_idade == '30'){
            $idadeMin = " and (DATE_FORMAT(NOW(),'%Y')-DATE_FORMAT(c.dt_nascimento,'%Y')-(DATE_FORMAT(NOW(),'00-%m-%d')< DATE_FORMAT(c.dt_nascimento,'00-%m-%d')) >= '16')";
            $idadeMax = " and (DATE_FORMAT(NOW(),'%Y')-DATE_FORMAT(c.dt_nascimento,'%Y')-(DATE_FORMAT(NOW(),'00-%m-%d')< DATE_FORMAT(c.dt_nascimento,'00-%m-%d')) <= '30')";
        }else if($v->ds_idade == '40'){
            $idadeMin = " and (DATE_FORMAT(NOW(),'%Y')-DATE_FORMAT(c.dt_nascimento,'%Y')-(DATE_FORMAT(NOW(),'00-%m-%d')< DATE_FORMAT(c.dt_nascimento,'00-%m-%d')) >= '16')";
            $idadeMax = " and (DATE_FORMAT(NOW(),'%Y')-DATE_FORMAT(c.dt_nascimento,'%Y')-(DATE_FORMAT(NOW(),'00-%m-%d')< DATE_FORMAT(c.dt_nascimento,'00-%m-%d')) <= '40')";
        }else if($v->ds_idade == '50'){
            $idadeMin = " and (DATE_FORMAT(NOW(),'%Y')-DATE_FORMAT(c.dt_nascimento,'%Y')-(DATE_FORMAT(NOW(),'00-%m-%d')< DATE_FORMAT(c.dt_nascimento,'00-%m-%d')) >= '16')";
            $idadeMax = " and (DATE_FORMAT(NOW(),'%Y')-DATE_FORMAT(c.dt_nascimento,'%Y')-(DATE_FORMAT(NOW(),'00-%m-%d')< DATE_FORMAT(c.dt_nascimento,'00-%m-%d')) <= '50')";
        }else{
            $idadeMin = "";
            $idadeMax = "";
        }
        
        //Filtra os candidatos que possuem cnh de acordo com a especificada na vaga
        if(!empty($v->ds_cnh)){
            $cnh = " and c.ds_cnh = '$v->ds_cnh'";
        }else{
            $cnh = "";            
        }
        
        $sql = "SELECT 
                    c.id_candidato,
                    c.nm_candidato,
                    c.ds_email,
                    c.id_deficiencia,
                    c.ao_sexo,
                    c.ao_abaexperiencia,
                    c.ds_estado_civil,
                    c.ds_cnh,
                    cf.id_formacao
                FROM 
                    candidato c
                    LEFT JOIN candidatoprofissao cp ON (c.id_candidato = cp.id_candidato)
                    LEFT JOIN candidatoformacao cf ON (c.id_candidato = cf.id_candidato)
                WHERE
                    cp.id_profissao = $v->id_profissao 
                    and c.ao_ativo = 'S'
                    and $sexo
                    $deficiente
                    $experiencia
                    $estado_civil
                    $idadeMin
                    $idadeMax
                    $cnh
                    $formacaoCandidato
                    and (c.id_candidato not in  (select id_candidato from vagacandidato where id_vaga = $v->id_vaga) and
                        c.id_candidato not in  (select id_candidato from vagacandidato cv, vaga v where v.id_vaga  <> $v->id_vaga
                                                                                        and cv.id_vaga = v.id_vaga
                                                                                        and v.id_empresa = $v->id_empresa
                                                                                        and cv.ao_status = 'C')
                        )
                    GROUP BY c.id_candidato 
                    ORDER BY 
                    c.nm_candidato ASC";        
        
        $query = mysql_query($sql);        
        
        $candidatos = array();

        while($row = mysql_fetch_object($query)){
            $candidatos[] = $row;
        }
        
        $v->candidatos = $candidatos;

    }
    
    foreach ($vagas as $v) {
        
        if(count($v->candidatos)>0){
           
            $assunto = 'Banco de Oportunidades - Encaminhamento';
            
            //Email para empresa
            $corpoEmpresa = "A Prefeitura Municipal de Canoas por intermédio da Secretaria Municipal de Desenvolvimento Econômico
                            lhe encaminha os seguintes candidatos para vaga de <b>$v->nm_profissao</b>:
                                <br/><br/>";
                        
            //Email para candidatos            
            $corpoCand = "Seu currículo foi encaminhado pelo Banco de Oportunidades para participar de um processo de 
                            seleção para a vaga $v->nm_profissao.
                            <br/><br/>
                            Nesta oportunidade a empresa fará o recrutamento, aguarde o contato da empresa ofertante da vaga
                            para maiores informações.
                            <br/>
                            Lembre-se sempre de manter seu currículo atualizado.
                            <br/>
                            Desejamos SORTE e SUCESSO em sua carreira profissional!";
            
            //Email para candidados com alguma deficiência
            $corpoCandDeficiente = "Seu currículo foi encaminhado pelo Banco de Oportunidades para participar de um processo de 
                            seleção para a vaga $v->nm_profissao que destina-se a portadores de necessidades especiais.
                            <br/><br/>
                            Nesta oportunidade a empresa fará o recrutamento, aguarde o contato da empresa ofertante da vaga
                            para maiores informações.
                            <br/>
                            Lembre-se sempre de manter seu currículo atualizado.
                            <br/>
                            Desejamos SORTE e SUCESSO em sua carreira profissional!";
            
            $corpoCoordenadoria = "Candidatos com deficiências encaminhados para a vaga de $v->nm_profissao "
                    . "para a empresa $v->nm_razaosocial.<br /><br />";

            //Conta quantos deficientes tem para mandar email a coordenadoria
            $qtDeficientes = 0;            
            
            foreach ($v->candidatos as $c){
                
                $sql = "INSERT INTO vagacandidato (id_vagacandidato, 
                                                            id_vaga, 
                                                            id_candidato, 
                                                            ao_status, 
                                                            dt_status
                                                        )VALUES (
                                                            null, 
                                                            $v->id_vaga, 
                                                            $c->id_candidato, 
                                                            'E', 
                                                            now())";
                        
                $query = mysql_query($sql);
                $idGerado = mysql_insert_id();
                                
                $sqlHistorico = "INSERT INTO historicocandidato (id_historico, 
                                                                    id_vagacandidato, 
                                                                    id_usuario,
                                                                    id_motivo,
                                                                    ds_motivodispensa,
                                                                    ao_status, 
                                                                    dt_cadastro
                                                                )VALUES(
                                                                    null,
                                                                    $idGerado,
                                                                    $v->id_empresa, 
                                                                    null, 
                                                                    '',
                                                                    'E',
                                                                    now())";
                
                $queryHistorico = mysql_query($sqlHistorico);
                
                                
                
                //Email para candidatos
                $nomeCand = $c->nm_candidato;
                $emailCand = $c->ds_email;
                
                //Email para empresa
                $contatoEmpresa = $v->nm_proprietario;
                $emailEmpresa = $v->ds_emailproprietario;
                
                                
                //Se candidato for deficiente
                if($c->id_deficiencia <> NULL){
                    
                    $qtDeficientes++;    
                    
                    //Pega o nome da deficiência do candidato
                    $sqlDeficiencia = "SELECT id_deficiencia, nm_deficiencia "
                            . "FROM deficiencia WHERE id_deficiencia = $c->id_deficiencia";
                                        
                    $deficiencia = mysql_fetch_object(mysql_query($sqlDeficiencia));
                                        
                    if($c->ao_sexo == 'M'){
                        $generoPNE = "Candidato";
                    }else{
                        $generoPNE = "Candidata";
                    }
                                        
                    //Avisa para empresa e coordenadoria que o candidato possui deficiência
                    $candDeficiente = $generoPNE." com deficiência $deficiencia->nm_deficiencia<br />";
                    
                    //Lista os candidados no email para coordenadoria
                    $corpoCoordenadoria .= "<p>
                                        <b>$candDeficiente</b>
                                        <b>Nome:</b> $c->nm_candidato<br/>
                                        <b>Código:</b> $c->id_candidato
                                      </p>";

                    $corpoCoordenadoria."<br>";                  
                    
                    //Manda email para o candidato com deficiência
                    if(Email::enviarEmail($emailCand, $assunto, $corpoCandDeficiente, $nomeCand)){
                        $contCandidato++;
                    }else{
                        $contCandidatoFalso++;
                    }                 
                    
                }else{
                    $candDeficiente = "";
                    
                    //Manda email para o candidato  
                    if(Email::enviarEmail($emailCand, $assunto, $corpoCand, $nomeCand)){
                        $contCandidato++;
                    }else{
                        $contCandidatoFalso++;
                    }
                }                               
                
                //Email para empresa
                $corpoEmpresa .= "<p>
                                    <b>$candDeficiente</b>
                                    <b>Nome:</b> $c->nm_candidato<br/>
                                    <b>Código:</b> $c->id_candidato
                                  </p>";
                
                $corpoEmpresa."<br>";
                
            }
                        
            if($qtDeficientes > 0){                
                //Manda email para coordenadoria
                Email::enviarEmail('coomped.canoas@gmail.com', $assunto, $corpoCoordenadoria, false);
                
                Email::enviarEmail('flavio.treib@canoastec.rs.gov.br', $assunto, $corpoCoordenadoria, false);
                Email::enviarEmail('alisson.vieira@canoastec.rs.gov.br', $assunto, $corpoCoordenadoria, false);
            }
            
            //Manda email para empresa
            if(Email::enviarEmail($emailEmpresa, $assunto, $corpoEmpresa, $contatoEmpresa)){
                $contEmpresa++;
            }else{
                $contEmpresaFalso++;
            }
            
        }
    }
    
}
$corpoRelatorio = "<p>
    Contador de envios para candidatos: $contCandidato
        <br/><br/>
    Contador de envios para empresas: $contEmpresa
    </p>";
$corpoRelatorio .= "<p>
    Contador de falhas de envios para candidatos: $contCandidatoFalso
        <br/><br/>
    Contador de falhas de envios para empresas: $contEmpresaFalso
    </p>";
$corpoRelatorio .= "<p>Data da Execução: ".  date('d/m/Y H:i:s') ."</p>";
Email::enviarEmail('flavio.treib@canoastec.rs.gov.br', 'Encaminhamento - Banco de Oportunidade', $corpoRelatorio, 'Flavio Treib');
?>
