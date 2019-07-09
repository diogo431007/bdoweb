<?php
session_start();
require_once 'conecta.php';
include "funcoes.php";
include "../../Utilidades/mPDF/mpdf.php";
require_once '../publico/util/ControleSessao.class.php';

$sql = ControleSessao::buscarVariavel('consultaBuscaEmpresas');

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

$nomeArquivo = 'Relatório de Empresas';
$desc_periodo =   'Empresas: ';

$msg = '<html>';
$msg .= '<head>';
$msg .= '<title>Busca de Empresas</title>';
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
                        .centralizar-texto{
                            text-align:center;
                        }
			-->
	</style>';

$msg .= '</head>';
$msg .= '<body>';

$msg .= '<table border="0" width="100%" cellpadding="2" cellspacing="2" align="center" class="texto">';
$msg .= '
        <tr>
            <td align="center" colspan="7" class="linha_nome" ><b>Relatório de Empresas</b></td>
        </tr>
        ';#<tr>
         #   <td align="center" colspan="7" class="linha_periodo" ><b>Variável</b></td>
        #</tr>';


        $msg .= '<tr>
            <td class="line" width="40%" align = "center"><b>Empresa</b></td>
            <td class="line" width="10%" align = "center"><b>Cidade / Logradouro</b></td>            
            <td class="line" width="30%" align = "center"><b>Email / Telefone</b></td>
        </tr>';
        
$query = mysql_query($sql);


while($a = mysql_fetch_object($query)) {
    $msg .= '<tr>
                <td width="40%"><b>'.$a->nm_razaosocial.'</b></td>                
                <td class="centralizar-texto" width="30%" style="text-center">'.$a->nm_cidade.'<br><br>'.$a->ds_logradouro.' - '.$a->nr_logradouro.'</td>                
                <td class="centralizar-texto" width="30%" style="text-center">'.$a->ds_email.'<br><br>'.$a->nr_telefoneempresa.'</td>
            </tr>
            <tr>
                <td colspan="3">
                    <hr>
                </td>
            </tr>            
';
}

$msg.= '<tr>
            <td align="center" colspan="5" class="linha_nome" width="100%" >
                TOTAL DE EMPRESAS: <b>'.mysql_num_rows($query).'</b>                
            </td>
        </tr>';

$msg .= '</table>';

$msg .= '</body>';
$msg .= '</html>';

$cabecalho = utf8_encode($cabecalho);						
$mpdf->SetHTMLHeader($cabecalho); 
$footer = utf8_encode($footer);
$mpdf->SetHTMLFooter($footer);
$msg = utf8_encode($msg);


#########################
# DOWLOAD DO ARQUIVO
#########################
$mpdf->WriteHTML($msg);
$dt = date("d-m-Y");
$mpdf->Output($nomeArquivo.'.pdf','D');

exit;
        
?>