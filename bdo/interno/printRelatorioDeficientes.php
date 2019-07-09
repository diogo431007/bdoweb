<?php
session_start();
require_once 'conecta.php';
include "funcoes.php";
include "../../Utilidades/mPDF/mpdf.php";

$auxInicio = $_SESSION['datas']['dt_inicio_periodo'];
$auxFim = $_SESSION['datas']['dt_fim_periodo'];

$mpdf = new mPDF('iso-8859-2','A4','','',10,10,15,20,2,2);

$nomeArquivo = 'RELATÓRIO DETALHADO DE DEFICIENTES ENCAMINHADOS';
$desc_periodo =   'Período: ';

    $inicio = (!empty($auxInicio)) ? "'".converterData($auxInicio) . " 00:00:00'" : '';
    $fim = (!empty($auxFim)) ? "'".converterData($auxFim) . " 23:59:59'" : '';
    
    if(!empty($inicio) && !empty($fim)){
        $periodo = ' hc.dt_cadastro between ' . $inicio . ' and ' . $fim;
        $desc_periodo = $auxInicio . ' até ' . $auxFim;
    }else if(!empty($inicio) && empty($fim)){
        $periodo = ' hc.dt_cadastro >= ' . $inicio;
        $desc_periodo = $auxInicio . ' até Hoje';
    }else if(empty($inicio) && !empty($fim)){
        $periodo = ' hc.dt_cadastro <= ' . $fim;
        $desc_periodo = 'Até ' . $auxFim;
    }else if(empty($inicio) && empty($fim)){
        $periodo = "1 = 1";
        $desc_periodo = 'Todo o Período';
    }
    
    $sql_deficiente = "SELECT 
                            c.id_candidato, c.nm_candidato, 
                            d.nm_deficiencia, 
                            e.id_empresa, e.nm_razaosocial, e.nm_fantasia, 
                            p.id_profissao, p.nm_profissao, 
                            hc.ao_status, DATE_FORMAT(hc.dt_cadastro,'%d/%m/%Y') as dt_cadastro
                       FROM historicocandidato hc
                            JOIN vagacandidato vc ON (vc.id_vagacandidato = hc.id_vagacandidato)
                            JOIN candidato c ON (c.id_candidato = vc.id_candidato)
                            JOIN deficiencia d ON (d.id_deficiencia = c.id_deficiencia)
                            JOIN vaga v ON (v.id_vaga = vc.id_vaga)
                            JOIN empresa e ON (e.id_empresa = v.id_empresa)
                            JOIN profissao p ON (p.id_profissao = v.id_profissao)
                       WHERE
                            $periodo";
    
    $query_deficiente = mysql_query($sql_deficiente);
        
    $pdf = "<html>";
    $pdf .= "<head>";
    $pdf .= "<title>Relatório Encaminhamentos Deficientes</title>";
    $pdf .= "<style>
                body{font-family: verdana, sans-serif, Helvetica;}
                .header{color: #EE7228; text-align: center; font-size: 30px; width: 100%; padding: 10px;}
                .header-nome, .header-periodo{background: #F1F1F1; color: #2D3E27; font-weight: bold; text-align: center; border: 1px solid #FFF;}
                .header-nome{height: 70px;}
                .tabela-deficientes{width: 100%; border-collapse: collapse; font-size: 14px; border: 1px solid #F1F1F1;}                
                .tabela-deficientes tbody td{padding: 10px;}                
                .nome-candidato{background: #FFA54F; color: #FFF; border: 1px solid #F1F1F1;}
                .nome-empresa{background: #3D8B40; color: #FFF;}
                .encaminhados{width: 160px; text-align: right;}                
                .profissao{border-bottom: 1px solid #F1F1F1; border-top: 1px solid #F1F1F1; background: #F1F1F1; color: #4F4F4F;}
                .text-blue, .text-black, .text-yellow, .text-green, .text-red{font-weight: bold;}
                .text-blue{color: #1E90FF;}
                .text-black{color: #000;}
                .text-yellow{color: #B8860B;}
                .text-green{color: #228B22;}
                .text-red{color: #CD5C5C;}
            </style>";
    $pdf .= "</head>";
    $pdf .= "<body>";        
    $pdf .= "<br><table class='tabela-deficientes'>";
    $pdf .= "<tbody>";
    $pdf .= "<tr>";    
    $pdf .= "<td colspan='2' class='header-nome'>";
    $pdf .= "{$nomeArquivo}";
    $pdf .= "</td>";
    $pdf .= "</tr>";
    $pdf .= "<tr>";    
    $pdf .= "<td colspan='2' class='header-periodo'>";
    $pdf .= "{$desc_periodo}";
    $pdf .= "</td>";
    $pdf .= "</tr>";    

    $id_deficiente = 0;
    $id_empresa = 0;
    $id_profissao = 0;
    $id_profissao_empresa = 0;
    
    while($deficiente = mysql_fetch_object($query_deficiente)) {  
        
        if($id_deficiente != $deficiente->id_candidato){
            $pdf .= "<tr>";
            $pdf .= "<td colspan='2' class='nome-candidato'><b>{$deficiente->nm_candidato}</b> com deficiência <b>{$deficiente->nm_deficiencia}</b></td>";        
            $pdf .= "</tr>";
            
            if($id_empresa == $deficiente->id_empresa){
                $pdf .= "<tr>";
                $pdf .= "<td colspan='2' class='nome-empresa'>";
                $pdf .= "Razão Social / Fantasia: ";
                $pdf .= (!empty($deficiente->nm_fantasia)) ? "<b>".$deficiente->nm_razaosocial . "</b> / <b>" . $deficiente->nm_fantasia : $deficiente->nm_razaosocial."</b>";
                $pdf .= "</td>";
                $pdf .= "</tr>";
                
                if($id_profissao == $deficiente->id_profissao){
                    $pdf .= "<tr>";
                    $pdf .= "<td colspan='2' class='profissao'><b>$deficiente->nm_profissao</b></td>";
                    $pdf .= "</tr>";
                }
            }            
            
            $id_deficiente = $deficiente->id_candidato;
        }               
        
        if($id_empresa != $deficiente->id_empresa){
            $pdf .= "<tr>";
            $pdf .= "<td colspan='2' class='nome-empresa'>";
            $pdf .= "Razão Social / Fantasia: ";
            $pdf .= (!empty($deficiente->nm_fantasia)) ? "<b>".$deficiente->nm_razaosocial . "</b> / <b>" . $deficiente->nm_fantasia : $deficiente->nm_razaosocial."</b>";
            $pdf .= "</td>";
            $pdf .= "</tr>";
            
            if($id_profissao == $deficiente->id_profissao){
                $pdf .= "<tr>";
                $pdf .= "<td colspan='2' class='profissao'><b>$deficiente->nm_profissao</b></td>";
                $pdf .= "</tr>";
            }
            
            $id_empresa = $deficiente->id_empresa;
        }
        
        if($id_profissao != $deficiente->id_profissao){
            $pdf .= "<tr>";
            $pdf .= "<td colspan='2' class='profissao'><b>$deficiente->nm_profissao</b></td>";
            $pdf .= "</tr>";
            
            $id_profissao = $deficiente->id_profissao;            
        }
        
        if($deficiente->ao_status == "E"){
            $classEncaminhado = "color: blue;";
        }elseif($deficiente->ao_status == "B"){
            $classEncaminhado = "color: black;";
        }elseif($deficiente->ao_status == "P"){
            $classEncaminhado = "color: yellow;";
        }elseif($deficiente->ao_status == "C"){
            $classEncaminhado = "color: green;";
        }elseif($deficiente->ao_status == "D"){
            $classEncaminhado = "color: red;";
        }
        
        $pdf .= "<tr>";
            if($deficiente->ao_status == "E"){
                $pdf .= "<td class='encaminhados text-blue'>";
                $pdf .= "Encaminhado:";
            }elseif($deficiente->ao_status == "B"){
                $pdf .= "<td class='encaminhados text-black'>";
                $pdf .= "Baixa Automática:";
            }elseif($deficiente->ao_status == "P"){
                $pdf .= "<td class='encaminhados text-yellow'>";
                $pdf .= "Pré-Selecionado:";
            }elseif($deficiente->ao_status == "C"){
                $pdf .= "<td class='encaminhados text-green'>";
                $pdf .= "Contratado:";
            }elseif($deficiente->ao_status == "D"){
                $pdf .= "<td class='encaminhados text-red'>";
                $pdf .= "Dispensado:";
            }
        $pdf .= "</td>";    
        $pdf .= "<td>$deficiente->dt_cadastro</td>";
        $pdf .= "</tr>";
    }

    $pdf .= "</tbody>";                
    
    $pdf .= "</table></body></html>";

    $header = "<div class='header'>Banco de Oportunidades</div>";    

    $footer = '<table border="0" width="100%" align="center" class="texto">
                    <tr>
                        <td width="10%" align="left">{DATE j-m-Y}</td>
                        <td width="10%" align="right">{PAGENO}/{nbpg}</td>
                    </tr>
               </table>';
    
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