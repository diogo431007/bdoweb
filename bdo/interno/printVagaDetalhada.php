<?php
session_start();
require_once 'conecta.php';
include "funcoes.php";
include "../../Utilidades/mPDF/mpdf.php";


$auxInicio = $_SESSION['datas']['dt_inicio_periodo'];
$auxFim = $_SESSION['datas']['dt_fim_periodo'];

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

$nomeArquivo = 'Relatório Detalhado de Vagas';
$desc_periodo =   'Período: ';
                    
        //$tipo = (!empty($tipo)) ? " and vc.ao_status = '".$tipo."'" : '';
                    
        $inicio = (!empty($auxInicio)) ? "'".converterData($auxInicio) . " 00:00:00'" : '';
        $fim = (!empty($auxFim)) ? "'".converterData($auxFim) . " 23:59:59'" : '';
        
        if(!empty($inicio) && !empty($fim)){
            $periodo = ' dt_status between ' . $inicio . ' and ' . $fim;
            $desc_periodo = $auxInicio . ' até ' . $auxFim;
        }else if(!empty($inicio) && empty($fim)){
            $periodo = ' dt_status >= ' . $inicio;
            $desc_periodo = $auxInicio . ' até Hoje';
        }else if(empty($inicio) && !empty($fim)){
            $periodo = ' dt_status <= ' . $fim;
            $desc_periodo = 'Até ' . $auxFim;
        }else if(empty($inicio) && empty($fim)){
            $periodo = "1 = 1";
            $desc_periodo = 'Todo o Período';
        }
                
        
        
        $sql_empresa = "SELECT 	
                                historicodavaga.id_vaga, 
                                historicodavaga.dt_status,
                                e.id_empresa,
                                e.nm_razaosocial,
                                e.nm_fantasia,
                                e.ds_email,
                                e.nr_telefoneempresa,
                                count(*) as vagadiferente
                        FROM 
                                (SELECT 
                                        id_vaga, dt_status, qt_vaga, ao_ativo, ao_deficiente
                                 FROM 
                                        historicovaga 
                                 GROUP BY 
                                        id_vaga DESC) AS historicodavaga, vaga v, empresa e
                        WHERE 
                                $periodo AND
                                historicodavaga.id_vaga = v.id_vaga AND
                                v.id_empresa = e.id_empresa
                                group by e.id_empresa desc";
                       
        
        $query_empresa = mysql_query($sql_empresa);       

$msg = '<html>';
$msg .= '<head>';
$msg .= '<title>Empresa Detalhada</title>';
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
            <td align="center" colspan="4" class="linha_nome" ><b>'.$nomeArquivo.'</b></td>
        </tr>
        <tr>
            <td align="center" colspan="4" class="linha_periodo" ><b>'.$desc_periodo.'</b></td>
        </tr>';


        $msg .= '<tr>
                    <td class="line" style="text-align: left;" width="40%"><b>Razão Social</b></td>
                    <td class="line" width="25%"><b>Nome Fantasia</b></td>
                    <td class="line" width="25%"><b>Email</b></td>
                    <td class="line" width="10%" align="center"><b>Telefone</b></td>                    
                </tr>';
        
        $contaNaoPCD = 0;
        $contaPCD = 0;       
        
        while($empresadetalhada = mysql_fetch_object($query_empresa)) {
            
            if($empresadetalhada->nm_fantasia == ""){
                $nomeFantasia = "-";
            }else{
                $nomeFantasia = $empresadetalhada->nm_fantasia;
            }
            
            $msg .= '<tr>
                        <td width="40%"><b>'.$empresadetalhada->nm_razaosocial.'</b></td>
                        <td width="25%" align="center">'.$nomeFantasia.'</td>
                        <td width="25%" align="center">'.$empresadetalhada->ds_email.'</td>
                        <td width="10%" align="center">'.$empresadetalhada->nr_telefoneempresa.'</td>                        
                     </tr>';
            
            $sql_historicovaga = "SELECT 
                                    historicodavaga.id_vaga, 
                                    historicodavaga.dt_status, 
                                    historicodavaga.qt_vaga, 
                                    historicodavaga.ao_ativo, 
                                    historicodavaga.ao_deficiente, 
                                    p.nm_profissao,
                                    v.dt_cadastro
                              FROM 
                                    (SELECT 
                                            id_vaga, dt_status, qt_vaga, ao_ativo, ao_deficiente
                                     FROM 
                                            historicovaga 
                                     GROUP BY 
                                            id_vaga DESC) AS historicodavaga, vaga v, profissao p
                              WHERE 
                                    $periodo AND
                                    historicodavaga.id_vaga = v.id_vaga AND
                                    v.id_profissao = p.id_profissao AND
                                    v.id_empresa = '$empresadetalhada->id_empresa'
                              ";

            $query_historico = mysql_query($sql_historicovaga);
            
            
            $msg .= '<tr>
                        <td width="40%"><br><b>Vaga</b><br></td>
                        <td width="25%" align="center"><br><b>Destinado à</b><br></td>
                        <td width="25%" align="center"><br><b>Não PCD</b><br></td>
                        <td width="10%" align="center"><br><b>PCD</b><br></td>                        
                     </td>
                     </tr>';
                                    
            
            
            while($empresavaga = mysql_fetch_object($query_historico)) {
                                
                if($empresavaga->ao_deficiente == "N"){
                    $vaga = $empresavaga->qt_vaga;
                    $pcd  = "-";
                    $destinado = "Não PCD";
                    $contaNaoPCD = $contaNaoPCD + $empresavaga->qt_vaga;                    
                    $contaGeral = $contaGeral + $empresavaga->qt_vaga;                    
                }else if($empresavaga->ao_deficiente == "S"){
                    $vaga = "-";
                    $pcd  = $empresavaga->qt_vaga;
                    $destinado = "Somente PCD";
                    $contaPCD = $contaPCD + $empresavaga->qt_vaga;                    
                    $contaGeral = $contaGeral + $empresavaga->qt_vaga;                    
                }else{
                    $vaga = $empresavaga->qt_vaga;
                    $pcd  = $empresavaga->qt_vaga;
                    $destinado = "Ambos";
                    $contaNaoPCD = $contaNaoPCD + $empresavaga->qt_vaga;
                    $contaPCD = $contaPCD + $empresavaga->qt_vaga;                    
                    $contaGeral = $contaGeral + $empresavaga->qt_vaga;                    
                }                
                
                
                $data_formatada = date('d/m/Y H:i:s', strtotime($empresavaga->dt_status));
                
                if($empresavaga->ao_ativo == "N"){
                    $vaga_inativa = " - <font color='red'>Vaga inativada pela empresa em $data_formatada</font>";
                }else{
                    $vaga_inativa = "";
                }
                
                
                $msg .= '<tr>
                            <td width="40%">'.$empresavaga->nm_profissao.$vaga_inativa.'</td>
                            <td width="25%" align="center">'.$destinado.'</td>
                            <td width="25%" align="center">'.$vaga.'</td>
                            <td width="10%" align="center">'.$pcd.'</td>                            
                        </tr>
                        ';
                
                             
                
            }            
            $msg .= '<tr>
                        <td colspan="4"><hr></td>
                     </td>
                     </tr>';
        }
        
        
$totalEmpresa = mysql_num_rows($query_empresa);
   
$msg.= '<tr>
            <td align="center" colspan="4" class="linha_nome">
                TOTAL DE EMPRESAS: <b>'.$totalEmpresa.'</b><br><br>
                TOTAL GERAL DE VAGAS: <b>'.$contaGeral.'</b><br>
                DESTINADAS À NÃO PCDs: <b>'.$contaNaoPCD.'</b> | 
                DESTINADAS À PCDs: <b>'.$contaPCD.'</b>
            </td>
        </tr>
    </table>';

$msg.= '</body>';
$msg.= '</html>';

$nomeArquivoComData = $nomeArquivo.' - '.$desc_periodo;

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
$mpdf->Output($nomeArquivoComData.'.pdf','D');

exit;
        
?>