<?php
session_start();
require_once 'conecta.php';
include "funcoes.php";
include "../../Utilidades/mPDF/mpdf.php";

$tipo = $_SESSION['datas']['ao_status'];
$empresa = $_SESSION['datas']['empresa'];
$auxInicio = $_SESSION['datas']['dt_inicio_admissao'];
$auxFim = $_SESSION['datas']['dt_fim_admissao'];
                    

                    
                    $arrayEncaminhado = $_SESSION['admissoes']['encaminhados'];
                    $arrayBaixaAutomatica = $_SESSION['admissoes']['baixaAutomatica'];
                    $arrayPreSelecionado = $_SESSION['admissoes']['preSelecionados'];
                    $arrayContratado = $_SESSION['admissoes']['contratados'];
                    $arrayDispensado = $_SESSION['admissoes']['dispensados'];
                    $arrayDeficientes = $_SESSION['admissoes']['deficientes'];
                    
                    
                    //Faz um foreach dos encaminhados e joga num array
                    $idEmpresaEncaminhado = array();
                    foreach($arrayEncaminhado as $e){
                        $idEmpresaEncaminhado[$e->id_empresa] = $e->qtd;
                        $totalEncaminhados = $totalEncaminhados + $e->qtd;
                    }
                    
                    //Faz um foreach dos baixa automática e joga num array
                    $idEmpresaBaixaAutomatica = array();
                    foreach($arrayBaixaAutomatica as $b){
                        $idEmpresaBaixaAutomatica[$b->id_empresa] = $b->qtd;
                        $totalBaixaAutomatica = $totalBaixaAutomatica + $b->qtd;
                    }
                    
                    //Faz um foreach dos pré-selecionados e joga num array
                    $idEmpresaPreSelecionado = array();
                    foreach($arrayPreSelecionado as $p){
                        $idEmpresaPreSelecionado[$p->id_empresa] = $p->qtd;
                        $totalPreSelecionado = $totalPreSelecionado + $p->qtd;
                    }
                    
                    //Faz um foreach dos contratados e joga num array
                    $idEmpresaContratado = array();
                    foreach($arrayContratado as $c){
                        $idEmpresaContratado[$c->id_empresa] = $c->qtd;
                        $totalContratado = $totalContratado + $c->qtd;
                    }
                    
                    //Faz um foreach dos dispensados e joga num array
                    $idEmpresaDispensado = array();
                    foreach($arrayDispensado as $d){
                        $idEmpresaDispensado[$d->id_empresa] = $d->qtd;
                        $totalDispensado = $totalDispensado + $d->qtd;
                    }
                    
                    //Faz um foreach dos deficientes e joga num array
                    $idEmpresaDeficiente = array();
                    foreach($arrayDeficientes as $def){
                        $idEmpresaDeficiente[$def->id_empresa] = $def->qtd;
                        $totalDeficientes = $totalDeficientes + $def->qtd;                        
                    }


$mpdf=new mPDF('iso-8859-2','A4','','',10,10,15,20,2,2);
$cabecalho = '<table border="0" width="100%" cellpadding="6" cellspacing="6" align="center">
                <tr>
		<td align="center" class="titulo">Banco de Oportunidades</td>
		</tr>
                </table>
	';

$footer = '<table border="0" width="100%" align="center" class="texto">
            <tr>
            <td width="10%" align="left">{DATE j-m-Y}</td>
            <td width="10%" align="right">{PAGENO}/{nbpg}</td>
            </tr>
	</table>';

$nomeArquivo = 'Relatório Analítico de Admissões';
$desc_periodo =   'Período: ';

$empresa  = (!empty($empresa)) ? " and e.id_empresa = ".$empresa : '';
                    
        //$tipo = (!empty($tipo)) ? " and vc.ao_status = '".$tipo."'" : '';
                    
        $inicio = (!empty($auxInicio)) ? "'".converterData($auxInicio) . " 00:00:00'" : '';
        $fim = (!empty($auxFim)) ? "'".converterData($auxFim) . " 23:59:59'" : '';
        
        if(!empty($inicio) && !empty($fim)){
            $periodo = ' and vc.dt_status between ' . $inicio . ' and ' . $fim;
            $desc_periodo = $auxInicio . ' até ' . $auxFim;
        }else if(!empty($inicio) && empty($fim)){
            $periodo = ' and vc.dt_status >= ' . $inicio;
            $desc_periodo = $auxInicio . ' até Hoje';
        }else if(empty($inicio) && !empty($fim)){
            $periodo = ' and vc.dt_status <= ' . $fim;
            $desc_periodo = 'Até ' . $auxFim;
        }else if(empty($inicio) && empty($fim)){
            $desc_periodo = 'Todo o período';
        }

        $sql = "SELECT 
                    COUNT(vc.id_vagacandidato) as qtd, 
                    e.id_empresa,
                    e.nm_razaosocial, 
                    e.nm_fantasia, 
                    vc.ao_status as status
                FROM                                 
                    empresa e
                    JOIN vaga v ON (v.id_empresa = e.id_empresa)
                    JOIN vagacandidato vc ON (v.id_vaga = vc.id_vaga)
                WHERE 
                    1=1
                    $empresa                    
                    $periodo
                GROUP BY e.id_empresa
                ORDER BY e.nm_razaosocial ASC, e.nm_fantasia ASC";

$msg = '<html>';
$msg .= '<head>';
$msg .= '<title>New document</title>';
$msg .= '<style>	<!--
			.texto {
			color: #000000;
			text-decoration: none;
			font-size: 11px;
                        font-family: verdana,helvetica, sans-serif, Helvetica;
			text-align: left;
			}
                        .titulo {
			color: #ee7228;
			text-decoration: none;
			font-size: 30px;
                        font-family: verdana,helvetica, sans-serif, Helvetica;
			text-align: center;
			}
                        .line{
                         border-bottom:solid;
                         border-bottom-color:#CDCDC1;
                         text-align: center;
                        }
                        .line_footer{
                         text-align: right;
                         background:#CDCDC1;
                        }
                        .line2{
                         border-bottom:solid;
                         border-color: #EEEEE0;
                        }
                         .line3{
                         border-bottom:dotted;
                         border-color: #000;
                        }
                        .linha{
                        background-color:#CDCDC1;
                        color:#666;
                        }
                        .linha_nome{
                        background-color:#8B8B83;
                        color:#fff;
                        height: 35px;
                        font-size: 14px;
                        }
                        .linha_periodo{
                        background-color:#8B8B83;
                        color:#fff;
                        height: 25px;
                        font-size: 14px;
                        }
			-->
	</style>';

$msg .= '</head>';
$msg .= '<body>';

$msg .= '<table border="0" width="800px" cellpadding="2" cellspacing="2" align="center" class="texto">
        <tr>
            <td align="center" colspan="8" class="linha_nome" ><b>'.$nomeArquivo.'</b></td>
        </tr>
        <tr>
            <td align="center" colspan="8" class="linha_periodo" ><b>'.$desc_periodo.'</b></td>
        </tr>';


        $msg .= '<tr>
            <td class="line" width="40%"><b>Empresa</b></td>
            <td class="line" width="10%" align = "center"><b>Encaminhados</b></td>
            <td class="line" width="10%" align = "center"><b>Baixas Automáticas</b></td>
            <td class="line" width="10%" align = "center"><b>Pré-Selecionados</b></td>
            <td class="line" width="10%" align = "center"><b>Contratados</b></td>
            <td class="line" width="10%" align = "center"><b>Dispensados</b></td>
            <td class="line" width="10%" align = "center"><b>Total de Deficientes</b></td>
            <td class="line" width="10%" align = "center"><b>Total</b></td>
        </tr>';
        
        //die($sql);

$query = mysql_query($sql);

$contAdmissoes = 0;

while($a = mysql_fetch_object($query)) {
    
    if(array_key_exists($a->id_empresa, $idEmpresaEncaminhado)){
        $auxEncaminhados = $idEmpresaEncaminhado[$a->id_empresa];
    }else{
        $auxEncaminhados = "-";
    }    
    
    if(array_key_exists($a->id_empresa, $idEmpresaBaixaAutomatica)){
        $auxBaixaAutomatica = $idEmpresaBaixaAutomatica[$a->id_empresa];
    }else{
        $auxBaixaAutomatica = "-";
    }
    
    if(array_key_exists($a->id_empresa, $idEmpresaPreSelecionado)){
        $auxPreSelecionados = $idEmpresaPreSelecionado[$a->id_empresa];                                                
    }else{
        $auxPreSelecionados = "-";
    }
    
    if(array_key_exists($a->id_empresa, $idEmpresaContratado)){
        $auxContratados = $idEmpresaContratado[$a->id_empresa];                                                
    }else{
        $auxContratados = "-";
    }

    if(array_key_exists($a->id_empresa, $idEmpresaDispensado)){
        $auxDispensados = $idEmpresaDispensado[$a->id_empresa];                                                
    }else{
        $auxDispensados = "-";
    }
    
    if(array_key_exists($a->id_empresa, $idEmpresaDeficiente)){
        $auxDeficientes = $idEmpresaDeficiente[$a->id_empresa];                                                
    }else{
        $auxDeficientes = "-";
    }
                                    
    
    $contAdmissoes = $contAdmissoes + $a->qtd;
    $auxNmEmpresa = $a->nm_razaosocial;
    $msg .= '<tr>
                <td class="line2">'. $auxNmEmpresa .'</td>
                <td class="line2" align="center">'. $auxEncaminhados .'</td>
                <td class="line2" align="center">'. $auxBaixaAutomatica .'</td>
                <td class="line2" align="center">'. $auxPreSelecionados .'</td>
                <td class="line2" align="center">'. $auxContratados .'</td>
                <td class="line2" align="center">'. $auxDispensados .'</td>
                <td class="line2" align="center">'. $auxDeficientes .'</td>
                <td class="line2" align="center">'. $a->qtd .'</td>
            </tr>';
}


   $msg .= '<tr>
            <td class="line_footer" style="text-align: left;"><b>Total Geral</b></td>
            <td class="line_footer"><b><center>' . $totalEncaminhados . '</center></b></td>
            <td class="line_footer"><b><center>' . $totalBaixaAutomatica . '</center></b></td>
            <td class="line_footer"><b><center>' . $totalPreSelecionado . '</center></b></td>
            <td class="line_footer"><b><center>' . $totalContratado . '</center></b></td>
            <td class="line_footer"><b><center>' . $totalDispensado . '</center></b></td>
            <td class="line_footer"><b><center>' . $totalDeficientes . '</center></b></td>
            <td class="line_footer"><b><center>' . $contAdmissoes . '</center></b></td>
           </tr>';

$msg.= '<tr>
            <td colspan="6">&nbsp;</b>
        </tr>
    </table>';

$msg.= '</body>';
$msg.= '</html>';

$cabecalho = utf8_encode($cabecalho);						
$mpdf->SetHTMLHeader($cabecalho); 
$footer = utf8_encode($footer);
$mpdf->SetHTMLFooter($footer);
$msg2 = $msg;
$msg = utf8_encode($msg);

#########################
# DOWLOAD DO ARQUIVO
#########################
$mpdf->WriteHTML($msg);
$dt = date("d-m-Y");
$mpdf->Output($nomeArquivo.'.pdf','D');

exit;
        
?>