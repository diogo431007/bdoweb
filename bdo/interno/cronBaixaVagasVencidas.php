<?php

include_once './conecta.php';
include_once '../publico/util/Email.class.php';

ini_set('memory_limit', '-1');
set_time_limit(300);
ini_set('max_input_time', '-1');


/* 
CRONTAB PARA BAIXA AUTOM�TICA DAS VAGAS QUE EST�O PUBLICADAS E COM STATUS ATIVO POR LONGO PRAZO
DEVE SER EXECUTADA TODOS OS DIAS
REGRA:
EMPRESAS COM PUBLICA��O DE 1 A 10 VAGAS: PASSAR� PARA STATUS INATIVO AP�S 30 DIAS
EMPRESAS COM PUBLICA��O DE 11 A 50 VAGAS: PASSAR� PARA STATUS INATIVO  AP�S  60 DIAS
EMPRESAS COM PUBLICA��O DE MAIS DE 50 VAGAS: PASSAR� PARA STATUS INATIVO  AP�S 90 DIAS
*/

// CONSULTA AS EMPRESAS, VAGAS E QTDES DE ACORDO COM A REGRA ACIMA
$sql = "select 
                    e.nm_razaosocial,
                    e.ds_emailproprietario,
                    e.nm_proprietario,
                    p.nm_profissao,
                    v.qt_vaga,
                    v.dt_cadastro,
                    datediff(now(),v.dt_cadastro) as prazo,
                    v.id_vaga
                from vaga v
                join empresa e on (v.id_empresa = e.id_empresa)
                join profissao p on (p.id_profissao = v.id_profissao)
                where v.ao_ativo = 'S'
                and ((v.qt_vaga <=10 and datediff(now(),v.dt_cadastro) > 30)
                or (v.qt_vaga > 10 and v.qt_vaga <= 50  and datediff(now(),v.dt_cadastro) > 60)
                or (v.qt_vaga > 50 and datediff(now(),v.dt_cadastro) > 90))
                order by qt_vaga desc";

$query = mysql_query($sql);

while($row = mysql_fetch_object($query)) {
    $vagas['id'][]=$row->id_vaga;
    $empresa[] =$row;
}
 
 if($vagas['id']){
 // DA BAIXA AUTOM�TICA PARA TODOS OS CANDIDATOS QUE FORAM ENCAMINHADOS PARA AS REFERIDAS VAGAS
       $sqlBaixaCandidato = "UPDATE vagacandidato set ao_status = 'B', dt_status=now() where ao_status = 'E' and id_vaga in (".implode(',',$vagas['id']).")";
       $queryBaixaCandidato = mysql_query($sqlBaixaCandidato);

// ALTERA O STATUS DA VAGA PARA INATIVO
       $sqlInativaVaga = "UPDATE vaga set ao_ativo = 'N' where id_vaga in (".implode(',',$vagas['id']).")";
       $queryInativaVaga = mysql_query($sqlInativaVaga);
}

// ENVIA EMAIL PARA A EMPRESA, COMUNICANDO QUE A VAGA FOI INATIVADA
if($empresa){
    foreach ($empresa as $e) {
        $assunto = 'Banco de Oportunidades - Publica��o de Vagas';
        //Email para empresa
        $corpoEmpresa = "<br>A Prefeitura Municipal de Canoas por interm�dio da Secretaria Municipal de Desenvolvimento Econ�mico
        comunica que a vaga para <b>".$e->nm_profissao."</b> cadastrada a ".$e->prazo." dias pela empresa ".$e->nm_razaosocial." foi inativada automaticamente pelo sistema.
        <br/><br/>
        Caso a vaga ainda n�o tenha sido preenchida, basta cadastr�-la novamente no Banco de Oportunidades.<br><br>
        Acesse o sistema clicando <a href='http://sistemas.canoas.rs.gov.br/bancodeoportunidades'>AQUI</a>
        <br><br>
        ";
        $contatoEmpresa = $e->nm_proprietario;
        $emailEmpresa = $e->ds_emailproprietario;
        //Manda email para empresa
        Email::enviarEmail($emailEmpresa, $assunto, $corpoEmpresa, $contatoEmpresa);
    }
}

?>