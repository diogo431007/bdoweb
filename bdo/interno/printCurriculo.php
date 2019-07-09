<?php
require_once 'conecta.php';
include "funcoes.php";
include "../../Utilidades/mPDF/mpdf.php";

$arrayId = $_POST['ids'];
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

$msg = '<html>';
$msg .= '<head>';
$msg .= '<title>New document</title>';
$msg .= '<style>	<!--
			.texto {
			color: #000000;
			text-decoration: none;
			font-size: 12px;
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
                        .linha_cabecalho{
                        background-color:#EEEEE0;
                        }
                        .linha_nome{
                        background-color:#8B8B83;
                        color:#fff;
                        height: 35px;
                        font-size: 14px;
                        }
			-->
	</style>';

$msg .= '</head>';
$msg .= '<body>';

    foreach ($arrayId as $idAux) {
      $contaArray--; 
$sql = "SELECT 
                c.id_candidato,
                c.nm_candidato,
                c.ds_email,
                c.nr_telefone,
                c.nr_celular,
                CASE c.ds_estado_civil
                WHEN 'C' THEN 'Casado'
                WHEN 'S' THEN 'Solteiro'
                WHEN 'D' THEN 'Divorciado'
                WHEN 'V' THEN 'Viúvo'
                WHEN 'P' THEN 'Separado'
                WHEN 'O' THEN 'Outros'
                END as estado_civil,
                c.dt_nascimento,
                IF(c.ao_sexo = 'M','Masculino','Feminino') AS genero,
                c.ds_nacionalidade,
                c.ds_logradouro,
                c.nr_logradouro,
                c.ds_complemento,
                c.ds_bairro,
                c.dt_validade,
                c.ds_objetivo,
                c.nr_cpf,
                c.nr_rg,
                c.nr_ctps,
                cid.nm_cidade,
                e.sg_estado
        FROM 
                candidato c
        JOIN 
                cidade cid ON (c.id_cidade = cid.id_cidade)
        JOIN 
                estado e ON (cid.id_estado = e.id_estado)
        WHERE 
                c.id_candidato = ".$idAux;
$query = mysql_query($sql);
//echo $sql;die;


while($row = mysql_fetch_object($query)) {	
    $nomeCand = $row->nm_candidato;
        
	$msg .= '<table border="0" width="800px" cellpadding="2" cellspacing="2" align="center" class="texto">
		<tr>
                    <td align="center" colspan="4" class="linha_nome" ><b>'.$row->nm_candidato.'</b></td>
		</tr>
                <tr>
                    <td align="center" colspan="4" class="linha" ><b>Dados Pessoais</b></td>
		</tr>';
                
                $msg .= '<tr>
                   <td class="line" width="20%">Nome</td>
                   <td class="line2" width="30%">'.$row->nm_candidato.'</td>
                   <td class="line"  width="20%">E-mail</td>
                   <td class="line2" width="30%">
                      '.$row->ds_email.'
                   </td>
                </tr>
                <tr>
                   <td class="line">Telefone</td>
                   <td class="line2">
                      '.$row->nr_telefone.'
                   </td>
                   <td class="line">Celular</td>
                   <td class="line2">
                      '.$row->nr_celular.'
                   </td>
                </tr>
                <tr>
                   <td class="line">CPF</td>
                   <td class="line2">
                      '.$row->nr_cpf.'
                   </td>
                   <td class="line">RG</td>
                   <td class="line2">
                       '.$row->nr_rg.'
                   </td>
                </tr>
                <tr>
                   <td class="line">CTPS</td>
                   <td class="line2">
                      '.$row->nr_ctps.'
                   </td>
                   <td class="line">Gênero</td>
                   <td class="line2">
                      '.$row->genero.'
                   </td>
                </tr>  
                <tr>
                   <td class="line">Logradouro</td>
                   <td class="line2">
                     '.$row->ds_logradouro.'
                   </td>
                   <td class="line">Número / Comp.</td>
                   <td class="line2">';                       
                    $msg .= ($row->nr_logradouro == null) ? '******' : $row->nr_logradouro;
                    $msg .= ($row->ds_complemento == null) ? '/ ******' : ' / ' . $row->ds_complemento;
                 $msg .= '</td>
                </tr>
                <tr>
                   <td class="line">Bairro</td>
                   <td class="line2">
                      '.$row->ds_bairro.'
                   </td>
                   <td class="line">Cidade / UF</td>
                   <td class="line2">';
                    $msg .= ($row->nm_cidade == null) ? '******' : $row->nm_cidade;
                    $msg .= ($row->sg_estado == null) ? '/ ******' : ' / ' . $row->sg_estado;                   
                  $msg .= '</td>
                 </tr>
                 <tr>
                   <td class="line">Estado Civil</td>
                   <td class="line2">
                      '.$row->estado_civil.'
                   </td>
                   <td class="line">Data de Nascimento</td>
                   <td class="line2">
                      '.mysql_to_data($row->dt_nascimento).'
                   </td>
                 </tr>
                 <tr>
                   <td class="line">Nacionalidade</td>
                   <td class="line2">
                      '.$row->ds_nacionalidade.'
                   </td>                   
                 </tr>
                 <tr>
                    <td colspan="4" align="center">&nbsp;</td>
                </tr>';
                if($row->ds_objetivo != ''){  
                            $msg .= '<tr>
                            <td class="line">Objetivos</td>                                               
                            <td colspan="4" class="line2">
                                ' . $row->ds_objetivo . '&nbsp;
                            </td>
                             </tr>';
                         }
                        $msg .= '<tr>
                            <td colspan="4">&nbsp;</b>
                        </tr>
                    </table>';
           }
           
            /*******************************************************************************************************
            * DADOS AREAS DE INTERESSE
            * ******************************************************************************************************/
            
            /*$sql_areasCand = "SELECT 
                                a.id_area, 
                                a.nm_area, 
                                c.id_candidato
                            FROM 
                                area a, 
                                subarea s, 
                                candidatosubarea c
                            WHERE 
                                a.id_area = s.id_area AND 
                                s.id_subarea = c.id_subarea AND
                                c.id_candidato = ".$idAux."
                            GROUP BY a.id_area";            
                 
            $query_areasCand = mysql_query($sql_areasCand);
            $num_rows_areasCand = mysql_num_rows($query_areasCand);
            
            if($num_rows_areasCand){
            $msg .='<table border="0" width="800px" cellpadding="0" cellspacing="0" align="center" class="texto">
                <tr>
                    <td>
                        <table border="0" width="800px" cellpadding="2" cellspacing="2" align="center" class="texto">
                            <tr>
                                <td align="center" colspan="4" class="linha"><b>Áreas de Interesses</b></td>
                            </tr>';
                            $msg.= '
                                <tr>
                                    <td class="line" width="90px">Áreas</td>
                                    <td class="line" width="130px">Sub-Área</td>
                                </tr>';
                            while($row_areasCand = mysql_fetch_object($query_areasCand)) {
                                $msg.= '<tr>                                                        
                                    <td class="line2" width="290px">'. $row_areasCand->nm_area. '</td>                                                            
                                    <td class="line2" width="290px">';

                                    $sql_subareasCand = "SELECT 
                                                            s.id_subarea,
                                                            s.nm_subarea, 
                                                            a.id_area
                                                        FROM 
                                                            area a,
                                                            subarea s,
                                                            candidatosubarea c
                                                        WHERE 
                                                            a.id_area = s.id_area AND
                                                            s.id_subarea = c.id_subarea AND
                                                            a.id_area = ".$row_areasCand->id_area."
                                                        ";

                                    $query_subareasCand = mysql_query($sql_subareasCand);
                                    $num_rows_subareasCand = mysql_num_rows($query_subareasCand);

                                    if($num_rows_subareasCand){
                                        while($row_subareasCand = mysql_fetch_object($query_subareasCand)) {
                                            $msg.= ''. $row_subareasCand->nm_subarea .'<br>';
                                        }
                                    }                                                    
                                $msg.= '</td>
                                </tr>';
                            }            
                        $msg.= '
                        </table>
                        <tr>
                            <td colspan="4">&nbsp;</b>
                        </tr>
                    </td>
                </tr>
            </table>';     
            }*/
            
           /********************************************************************************************************
            * PROFISSÃO
            * ***************************************************************************************************** */
            
           $sql_profissao = "SELECT 
                                cp.*, p.nm_profissao 
                            FROM 
                                candidatoprofissao cp, profissao p 
                            WHERE 
                                cp.id_profissao = p.id_profissao AND 
                                cp.id_candidato = ".$idAux;
           
           $query_profissao = mysql_query($sql_profissao);
           $num_rows_profissao = mysql_num_rows($query_profissao);
           
           if($num_rows_profissao){
               $msg .='<table border="0" width="800px" cellpadding="2" cellspacing="2" align="center" class="texto">
                    <tr>
                       <td align="center" colspan="4" class="linha"><b>Profissão</b></td>
                    </tr>';
                         while($row_profissao = mysql_fetch_object($query_profissao)) {
                             $msg.= '<tr>                                                        
                                 <td class="line2" width="100%">'. $row_profissao->nm_profissao .'</td>
                             </tr>';
                         }                    
                $msg.= '<tr>
                            <td colspan="4" align="center">&nbsp;</td>
                        </tr>
                    </table>';
            }
            
        /********************************************************************************************************
        * FORMACOES
        * ***************************************************************************************************** */
            
           $sql_formacao = "SELECT 
                                    cf.*, 
                                    f.nm_formacao 
                            FROM 
                                    candidatoformacao cf, 
                                    formacao f 
                            WHERE 
                                    cf.id_formacao = f.id_formacao AND 
                                    cf.id_candidato = ".$idAux;
           $query_formacao = mysql_query($sql_formacao);
           $num_rows_formacao = mysql_num_rows($query_formacao);
           
           if($num_rows_formacao){                                
                $msg .='<table border="0" width="800px" cellpadding="2" cellspacing="2" align="center" class="texto">
                            <tr>
                                <td align="center" colspan="4" class="linha"><b>Formação</b></td>
                            </tr> 
                            <tr class="linha_cabecalho">
                               <td>Escolaridade</td>
                               <td>Data Término</td>
                               <td>Escola</td>
                               <td>Cidade Escola</td>
                            </tr>';
                                while($row_formacao = mysql_fetch_object($query_formacao)) {

                                    $dtAux = $row_formacao->dt_termino != null ? mysql_to_data($row_formacao->dt_termino) : null;

                                    $msg.= '
                                    <tr>
                                        <td class="line2">'.$row_formacao->nm_formacao.'</td>

                                        <td class="line2">'. $dtAux .'</td>

                                        <td class="line2">'.$row_formacao->nm_escola.'</td>

                                        <td class="line2">'.$row_formacao->ds_cidadeescola.'</td>
                                    </tr>';
                                }
                $msg.= '<tr>
                        <td colspan="4" align="center">&nbsp;</td>
                    </tr>                    
                </table>';
           }           
        
        /********************************************************************************************************
        * QUALIFICAÇÕES
        * ***************************************************************************************************** */
        
         $sql_qualificacoes = "SELECT 
                                    * 
                               FROM 
                                    candidatoqualificacao cq
                               WHERE 
                                    cq.id_candidato = ".$idAux;
           $query_qualificacoes = mysql_query($sql_qualificacoes);
           $num_rows_qualificacoes = mysql_num_rows($query_qualificacoes);
           if($num_rows_qualificacoes){
                $msg .='<table border="0" width="800px" cellpadding="2" cellspacing="2" align="center" class="texto">
                            <tr>
                                <td align="center" colspan="4" class="linha"><b>Qualificações</b></td>
                             </tr> 

                            <tr class="linha_cabecalho">
                                <td>Descrição</td>
                                <td>Instituição</td>
                                <td>Data Término</td>
                                <td>Qnt. Horas</td>
                            </tr>';                
                            while($row_qualificacoes = mysql_fetch_object($query_qualificacoes)) {
                                $msg.= '<tr>
                                            <td class="line2">'.$row_qualificacoes->ds_qualificacao.'</td>

                                            <td class="line2">'.$row_qualificacoes->nm_instituicao.'</td>

                                            <td class="line2">'.  mysql_to_data($row_qualificacoes->dt_termino).'</td>

                                            <td class="line2">'.$row_qualificacoes->qtd_horas.'</td>
                                        </tr>';
                            }
                $msg.= '<tr>
                            <td colspan="4" align="center">&nbsp;</td>
                        </tr>
                        </table>';
            }
            
        
        /********************************************************************************************************
        * EXPERIÊNCIAS
        * ***************************************************************************************************** */
        
           $sql_experiencia = "SELECT 
                                    * 
                               FROM 
                                    candidatoexperiencia ce
                               WHERE 
                                    ce.id_candidato = ".$idAux;
           $query_experiencia = mysql_query($sql_experiencia);
           $num_rows_experiencia = mysql_num_rows($query_experiencia);
           if($num_rows_experiencia){
                $msg .='<table border="0" width="800px" cellpadding="2" cellspacing="2" align="center" class="texto">
                            <tr>
                                <td align="center" colspan="4" class="linha"><b>Experiência Profissional</b></td>
                             </tr> 

                             <tr class="linha_cabecalho">
                                <td>Empresa</td>
                                <td>Data Início</td>
                                <td>Data Término</td>
                                <td>Principais Atividades</td>
                            </tr>';

                            while($row_experiencia = mysql_fetch_object($query_experiencia)) {
                                $msg.= '<tr>                                                        
                                            <td class="line2">'. $row_experiencia->nm_empresa .'</td>

                                            <td class="line2">'. mysql_to_data($row_experiencia->dt_inicio) .'</td>

                                            <td class="line2">'. mysql_to_data($row_experiencia->dt_termino) .'</td>

                                            <td class="line2">'. $row_experiencia->ds_atividades .'</td>
                                        </tr>';
                            }
                $msg.= '<tr>
                            <td colspan="4" >&nbsp;</b>
                        </tr>
                    </table>';
           }
                       
        
        if ($contaArray !=0){
            $msg.= '<pagebreak type="NEXT-ODD" resetpagenum="0" pagenumstyle="1" suppress="off" />';
        }
    }        
        $msg.= '</body>';
	$msg.= '</html>';
	
        if(count($arrayId)==1){
            $nomeArquivo = $nomeCand.' - '.date('d/m/y');
        }else{
            $nomeArquivo = 'Curriculo(s) - '.date('d/m/y');
        }
        
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
            echo '<script>alert("Você precisa selecionar um candidato!");history.back();</script>';
        }
?>
