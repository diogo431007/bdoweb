<?php

if(!isset($_POST['id_empresa'])){
    header('location:relatorio.php#parte-02');
}

$id_empresa = (int) $_POST['id_empresa'];

if($id_empresa <= 0){
    header('location:relatorio.php#parte-02');
}

session_start();

require_once 'conecta.php';
include "funcoes.php";
include "../../Utilidades/mPDF/mpdf.php";

$auxInicio = $_SESSION['datas']['dt_inicio_admissao'];
$auxFim = $_SESSION['datas']['dt_fim_admissao'];

$mpdf = new mPDF('iso-8859-2','A4','','',10,10,15,20,2,2);

$header = "<div class='header'>Banco de Oportunidades</div>";	

$footer = '<table border="0" width="100%" align="center" class="texto">
                <tr>
                    <td width="10%" align="left">{DATE j-m-Y}</td>
                    <td width="10%" align="right">{PAGENO}/{nbpg}</td>
                </tr>
           </table>';

$nomeArquivo = 'Relatório Detalhado de Deficientes Encaminhados Por Empresa';
$desc_periodo =   'Período: ';

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
    
    $pdf = "<html>";
    $pdf .= "<head>";
    $pdf .= "<title>Relatório Encaminhamentos Deficientes</title>";
    $pdf .= "<style>
                body{font-family: verdana, sans-serif, Helvetica;}
                .header{color: #EE7228; text-align: center; font-size: 30px; width: 100%; padding: 10px;}
                .header-nome {background: #F1F1F1; color: #2D3E27; font-weight: bold; text-align: center; border: 1px solid #FFF;}
                .header-periodo{background: #F1F1F1; color: #2D3E27; font-weight: bold; text-align: center; border: 1px solid #FFF;padding: 10px;}
                .header-nome{height: 70px;}
                .tabela-deficientes{width: 100%; border-collapse: collapse; font-size: 14px; border: 1px solid #F1F1F1;}                
                .tabela-deficientes tbody td{padding: 10px;} 
                .tabela-deficientes thead td{padding: 10px;} 
                .nome-candidato{background: #FFA54F; color: #FFF; border: 1px solid #F1F1F1;}
                .nome-empresa{background: #3D8B40; color: #FFF;}
                .encaminhados{width: 160px; text-align: right;}                
                .profissao{border-bottom: 1px solid #F1F1F1; border-top: 1px solid #F1F1F1; background: #F1F1F1; color: #4F4F4F;}
            </style>";
    $pdf .= "</head>";
    $pdf .= "<body><br/>";
    
    $pdf .= "<table class='tabela-deficientes'>
                <thead>
                    <tr>
                        <th colspan='4' class='header-nome'>{$nomeArquivo}</th>
                    </tr>
                    <tr>
                        <th colspan='4' class='header-periodo'>{$desc_periodo}</th>
                    </tr>";

    $addEmpresa = true;
    
    
    while($deficiente = mysql_fetch_object($query)) {
        
        if($addEmpresa){
            $pdf .= "<tr>";
            $pdf .= "<td colspan='4' class='nome-empresa'>";
            $pdf .= "Razão Social / Fantasia: ";
            $pdf .= (!empty($deficiente->nm_fantasia)) ? "<b>".$deficiente->nm_razaosocial . "</b> / <b>" . $deficiente->nm_fantasia : $deficiente->nm_razaosocial."</b>";
            $pdf .= "</td>";
            $pdf .= "</tr>";
            
            $addEmpresa = false;
            
            $pdf .= "<tr>";
            $pdf .= "<td class='nome-candidato'>Candidato</td>";
            $pdf .= "<td class='nome-candidato'>Deficiência</td>";
            $pdf .= "<td class='nome-candidato'>Status</td>";
            $pdf .= "<td class='nome-candidato'>Vaga</td>";
            $pdf .= "</tr>";
            $pdf .= "</thead><tbody>";
        }
        
        
        $pdf .= "<tr>";
        $pdf .= "<td class=''>".  ($deficiente->nm_candidato) ."</td>";
        $pdf .= "<td class=''>".  ($deficiente->nm_deficiencia) ."</td>";
        $pdf .= "<td class=''>".  ($deficiente->ds_status) ."</td>";
        $pdf .= "<td class=''>".  ($deficiente->nm_profissao) ."</td>";
        $pdf .= "</tr>";
        
    }
        
    $pdf .= "</tbody>";                
    
    $pdf .= "</table></body></html>";

    //var_dump($header);
    //var_dump($pdf);die;
    
$nomeArquivoComData = $nomeArquivo.' - '.$desc_periodo;

#########################
# DOWLOAD DO ARQUIVO
#########################
$mpdf->SetHTMLHeader(utf8_encode($header)); 
$mpdf->SetHTMLFooter(utf8_encode($footer));
$mpdf->WriteHTML(utf8_encode($pdf));
$dt = date("d-m-Y");
$mpdf->Output($nomeArquivoComData.'.pdf','D');

exit;