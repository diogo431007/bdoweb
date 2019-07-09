<?php
header("Content-Type: application/json; charset=ISO-8859-1",true);

if(!isset($_POST['empresa'])){
    echo json_encode(array('erro' => 'Erro'));die;
}

$id_empresa = (int) $_POST['empresa'];

if($id_empresa <= 0){
    echo json_encode(array('erro' => 'Erro'));die;
}

session_start();
require_once 'conecta.php';
require_once 'define.php';
include_once "funcoes.php";

$auxInicio = $_SESSION['datas']['dt_inicio_admissao'];
$auxFim = $_SESSION['datas']['dt_fim_admissao'];

$inicio = (!empty($auxInicio)) ? "'".converterData($auxInicio) . " 00:00:00'" : '';
$fim = (!empty($auxFim)) ? "'".converterData($auxFim) . " 23:59:59'" : '';

if(!empty($inicio) && !empty($fim)){
    $periodo = ' vc.dt_status between ' . $inicio . ' and ' . $fim;
    $desc_periodo = $auxInicio . ' até ' . $auxFim;
}else if(!empty($inicio) && empty($fim)){
    $periodo = ' vc.dt_status >= ' . $inicio;
    $desc_periodo = $auxInicio . ' até Hoje';
}else if(empty($inicio) && !empty($fim)){
    $periodo = ' vc.dt_status <= ' . $fim;
    $desc_periodo = 'Até ' . $auxFim;
}else if(empty($inicio) && empty($fim)){
    $periodo = "1 = 1";
    $desc_periodo = 'Todo o Período';
}

$sql = "SELECT 
            c.id_candidato, c.nm_candidato, 
            d.nm_deficiencia, 
            e.id_empresa, e.nm_razaosocial, e.nm_fantasia, 
            p.id_profissao, p.nm_profissao, 
            vc.ao_status, 
            case vc.ao_status
                when 'E' then 'Encaminhado'
                when 'D' then 'Dispensado'
                when 'C' then 'Contratado'
                when 'P' then 'Pré-Selecionado'
                when 'B' then 'Baixa Automática'
                end as 'ds_status'
         FROM 
            vagacandidato vc 
            JOIN candidato c ON (c.id_candidato = vc.id_candidato)
            JOIN deficiencia d ON (d.id_deficiencia = c.id_deficiencia)
            JOIN vaga v ON (v.id_vaga = vc.id_vaga)
            JOIN empresa e ON (e.id_empresa = v.id_empresa)
            JOIN profissao p ON (p.id_profissao = v.id_profissao)
         WHERE
                 e.id_empresa = $id_empresa and $periodo";

$query = mysql_query($sql);
$quantidadeLinhas = mysql_num_rows($query);
$retorno = array();
if($query){
    if($quantidadeLinhas >  0){
        $deficientes = array();
        while ($deficiente = mysql_fetch_object($query)) {
            
            $nm_empresa = (!empty($deficiente->nm_fantasia)) ? $deficiente->nm_razaosocial . " / " . $deficiente->nm_fantasia : $deficiente->nm_razaosocial;
            
            $empresa = array(
                'id_empresa' => $deficiente->id_empresa,
                'nm_empresa' => utf8_encode($nm_empresa),
            );
            
            $deficientes[] = array(
                'nm_candidato' => utf8_encode($deficiente->nm_candidato),
                'tp_deficiencia' => utf8_encode($deficiente->nm_deficiencia),
                'ao_status' => utf8_encode($deficiente->ao_status),
                'ds_status' => utf8_encode($deficiente->ds_status),
                'nm_profissao' => utf8_encode($deficiente->nm_profissao)
            );
            
        }
        $empresa['deficientes'] = $deficientes;
        $retorno = $empresa;
    }
}else{
    $retorno['erro'] = ('Erro ao buscar dados');
}

echo $json = json_encode($retorno);die();