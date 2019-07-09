<?php
require_once 'conecta.php';
include "funcoes.php";
include "../../Utilidades/mPDF/mpdf.php";
$arrayId = $_POST['ids'];
$tipo = $_POST['tipo_print'];
$origem = $_POST['origem_print'];
$inicio = $_POST['inicio_print'];
$fim = $_POST['fim_print'];

if(!validarTipoRelatorio($tipo) || !validarOrigemAcesso($origem) || !validarData($inicio) || !validarData($fim)){
    echo '<script>alert("Ocorreu um erro! Tente novamente.");history.back();</script>';
}

$contaArray = count($arrayId);


if(!empty($arrayId)) {

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

$nomeArquivo = ($tipo == 'A') ? 'Relatório Analítico de Logs de Acesso' : 'Relatório Sintético de Logs de Acesso';
$periodo =   'Período: ' . $inicio . ' a ' . $fim;

$msg = '<html>';
$msg .= '<head>';
$msg .= '<title>New document</title>';
$msg .= '<style>	<!--
			.texto {
			color: #000000;
			text-decoration: none;
			font-size: 11px;
                        font-family: verdana,helvetica, sans-serif, Helvetica;
			text-align: justify;
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
            <td align="center" colspan="4" class="linha_periodo" ><b>'.$periodo.'</b></td>
        </tr>';


if($tipo == 'A'){
    $msg .= '<tr>
                <td class="line" width="80%"><b>Nome</b></td>
                <td class="line" width="10%" align = "center"><b>Data</b></td>
                <td class="line" width="10%" align = "center"><b>Hora</b></td>
            </tr>';
}else{
    $msg .= '<tr>
                <td class="line" width="80%"><b>Nome</b></td>
                <td class="line" width="20%"><b>Quantidade de Acessos</b></td>
            </tr>';
}

    foreach ($arrayId as $idAux) {
        $contaArray--;
        
        
        if($origem == 'C'){
                        
            if($tipo == 'A'){
                $sql = "SELECT 
                            l.id_log,
                            l.id_acesso,
                            l.ao_tipo,
                            DATE_FORMAT(l.dt_log, '%d/%m/%Y') as data,
                            DATE_FORMAT(l.dt_log, '%H:%i:%s') as hora,
                            c.nm_candidato as nome 
                        FROM 
                            log l, 
                            candidato c 
                        WHERE 
                            l.id_acesso = c.id_candidato AND 
                            l.id_log = $idAux";
            }else{
                $sql = "SELECT 
                        l.id_log,
                        COUNT(l.id_acesso) as qt_acessos,
                        c.nm_candidato as nome 
                    FROM 
                        log l, 
                        candidato c 
                    WHERE 
                        l.id_acesso = c.id_candidato AND 
                        l.id_acesso = $idAux";

            }
        }else{
            if($tipo == 'A'){
                $sql = "SELECT
                            l.id_log,
                            l.id_acesso,
                            l.ao_tipo,
                            DATE_FORMAT(l.dt_log, '%d/%m/%Y') as data,
                            DATE_FORMAT(l.dt_log, '%H:%i:%s') as hora,
                            e.nm_razaosocial as nome
                        FROM
                            log l,
                            empresa e
                        WHERE
                            l.id_acesso = e.id_empresa AND
                            l.id_log = $idAux";
                
                }else{
                    $sql = "SELECT
                                l.id_log,
                                COUNT(l.id_acesso) as qt_acessos,
                                e.nm_razaosocial as nome
                            FROM
                                log l,
                                empresa e
                            WHERE 
                                l.id_acesso = e.id_empresa AND
                                l.id_acesso = $idAux";
                }
        }
        
    $query = mysql_query($sql);
        
    while($log = mysql_fetch_object($query)) {
        
        if($tipo == 'A'){
            $msg .= '<tr>
                        <td class="line2">'. $log->nome .'</td>
                        <td class="line2" align="center">'. $log->data .'</td>
                        <td class="line2" align="center">'.$log->hora.'</td>
                    </tr>';
        }else{
            
            $msg .= '<tr>
                        <td class="line2">'.$log->nome.'</td>
                        <td class="line2" align="center">'.$log->qt_acessos.'</td>
                    </tr>';
                    
        }
    }
        
     
    }//for
        $msg.= '<tr>
                    <td colspan="4">&nbsp;</b>
                </tr>
            </table>';
        
        $msg.= '</body>';
	$msg.= '</html>';
        
        
        //echo $cabecalho;
        //echo $msg;die;
        //echo $msg;die;

        $nomeArquivo = $nomeArquivo.' '.$periodo;
        
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
	//echo $msg;die;
	
	exit;
        
        }else{
            echo '<script>alert("Voc? precisa selecionar um log!");history.back();</script>';
        }
?>