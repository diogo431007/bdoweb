<?php

include_once '../../../Utilidades/mPDF/mpdf.php';

class Imprimir {

    public static function imprimirCurriculo($candidatos) {
        
        $qtdCand = count($candidatos);
        
        $mpdf = new mPDF('iso-8859-2', 'A4', '', '', 10, 10, 2, 20, 2, 2);

        $headerPdf = '<table width="100%" cellpadding="6" cellspacing="6" align="center">
                        <tr>
                            <td align="left"><img src="../imagens/imprimir_header.png" width="40%"></td>
                        </tr>
                      </table>';

        $footerPdf = '<table border="0" width="100%" align="center" class="texto">
                        <tr>
                            <td align="center" colspan="2"></td>
                        </tr>
                        <tr>
                        <td width="10%" align="left">{DATE j-m-Y}</td>
                        <td width="10%" align="right">{PAGENO}/{nbpg}</td>
                        </tr>
                    </table>';

        $pdf = '<html>
                    <head>
                        <title>New document</title>
                        <style>	
                            <!--
                            .texto {
                            color: #000000;
                            text-decoration: none;
                            font-size: 12px;
                            font-family: verdana,helvetica, sans-serif, Helvetica;
                            text-align: justify;
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
                            color:#000;
                            font-size: 30px;
                            }
                            -->
                        </style>
                    </head>
                <body>';

        foreach ($candidatos as $c) {
            
            //$foto = '../fotos/' . $c->id_candidato . '.jpg';
            //$foto = (file_exists($foto)) ? "$foto" : "../fotos/foto_null.jpg";
            
            $qtdCand--;
            
            /********************************************************************************************************
            * DADOS PESSOAIS
            ********************************************************************************************************/
            $pdf .= '<table border="0" width="800px" cellpadding="2" cellspacing="2" align="center" class="texto"> 
                        <tr>
                            <td align="center" colspan="4" class="linha_nome">' . $c->nm_candidato . '&nbsp;</td>                            
                        </tr>
                        <tr>
                            <td align="center" colspan="4" class="linha" ><b>Dados Pessoais</b></td>
                        </tr>                    

                        <tr>
                            <td class="line" width="20%">Código</td>
                            <td class="line2" width="30%">' . $c->id_candidato . '&nbsp;</td>

                            <td class="line" width="20%">Data de Nascimento</td>
                            <td class="line2" width="30%">' . Validacao::explodirDataMySql($c->dt_nascimento) . '&nbsp;</td>                            
                        </tr>  

                        <tr>
                            <td class="line">Estado Civil</td>
                            <td class="line2">' . Servicos::verificarEstadoCivil($c->ds_estado_civil) . '&nbsp;</td>

                            <td class="line">CNH</td>
                            <td class="line2">' . $c->ds_cnh . '&nbsp;</td>
                        </tr>

                        <tr>                            
                            <td class="line">Gênero</td>
                            <td class="line2">' . Servicos::verificarGenero($c->ao_sexo) . '&nbsp;</td>

                            <td class="line">Cidade / UF</td>
                            <td class="line2">';
                                $pdf .= ($c->id_cidade == null) ? '******' : Servicos::buscarCidadePorId($c->id_cidade)->nm_cidade . '&nbsp;';
                                $pdf .= ($c->id_cidade == null) ? ' / ******' : ' / '. Servicos::buscarEstadoPorId(Servicos::buscarIdEstado($c->id_cidade))->sg_estado . '&nbsp;'; 
                            '</td>
                        </tr>';

                        if($c->ds_objetivo != ''){  
                            $pdf .= '<tr>
                                <td class="line">Objetivos</td>                                               
                                <td colspan="4" class="line2">
                                    ' . $c->ds_objetivo . '&nbsp;
                                </td>
                            </tr>';
                        }
                        $pdf .= '<tr>
                                    <td colspan="4">&nbsp;</b>
                                </tr>
                    </table>';
                                    
            /********************************************************************************************************
            * PROFISSAO
            ********************************************************************************************************/
            if(count($c->profissoes) > 0){
                $pdf .= '<table border="0" width="800px" cellpadding="2" cellspacing="2" align="center" class="texto">
                                        <tr>
                                            <td align="center" colspan="4" class="linha"><b>Profissão</b></td>
                                        </tr>';                           
                                        foreach ($c->profissoes as $cp) {   
                                            $pdf .= '<tr>
                                                        <td class="line2" width="100%">' . Servicos::buscarProfissaoPorId($cp->id_profissao) . '&nbsp;</td>
                                                    </tr>';
                                        }                                
                                        $pdf .= '<tr>
                                                    <td colspan="4" align="center">&nbsp;</td>
                                                </tr>
                                    </table>';
            }            
            /********************************************************************************************************
            * FORMACOES
            *******************************************************************************************************/
            if(count($c->formacoes) > 0){
                $pdf .= '<table border="0" width="800px" cellpadding="2" cellspacing="2" align="center" class="texto">
                            <tr>
                                <td align="center" colspan="4" class="linha"><b>Formação</b></td>
                            </tr>
                            <tr class="linha_cabecalho">
                                <td>Escolaridade</td>
                                <td>Data Término</td>
                                <td>Escola</td>
                                <td>Cidade Escola</td>
                            </tr>';
                
                            foreach($c->formacoes as $f){
                                $pdf .= '<tr>
                                            <td class="line2">' . Servicos::converterStrtoupper(Servicos::verificarFormacao($f->id_formacao)) . '&nbsp;</td>

                                            <td class="line2">' . Validacao::explodirDataMySqlNaoObg($f->dt_termino) . '&nbsp;</td>

                                            <td class="line2">' . $f->nm_escola . '&nbsp;</td>

                                            <td class="line2">' . $f->ds_cidadeescola . '&nbsp;</td>
                                        </tr>';
                            }

                            $pdf .= '<tr>
                                        <td colspan="4" align="center">&nbsp;</b>
                                    </tr>
                        </table>';
            }            
            /********************************************************************************************************
            * QUALIFICACOES
            ********************************************************************************************************/
            if(count($c->qualificacoes) > 0){
                $pdf .= '<table border="0" width="800px" cellpadding="2" cellspacing="2" align="center" class="texto">
                            <tr>
                                <td align="center" colspan="4" class="linha"><b>Qualificações</b></td>
                            </tr>
                            <tr class="linha_cabecalho">
                                <td>Descrição</td>
                                <td>Instituição</td>
                                <td>Data Término</td>
                                <td>Qnt. Horas</td>
                            </tr>';

                            foreach($c->qualificacoes as $q){
                                $pdf .= '<tr>                                        
                                            <td class="line2" width="">' . $q->ds_qualificacao . '&nbsp;</td>

                                            <td class="line2" width="">' . $q->nm_instituicao . '&nbsp;</td>

                                            <td class="line2" width="">' . Validacao::explodirDataMySqlNaoObg($q->dt_termino) . '&nbsp;</td>    

                                            <td class="line2" width="">' . $q->qtd_horas . '&nbsp;</td>
                                        </tr>';
                            }
                            $pdf .= '<tr>
                                        <td colspan="4" align="center">&nbsp;</b>
                                    </tr>
                        </table>';
            }
            /********************************************************************************************************
            * EXPERIENCIAS
            *******************************************************************************************************/
            if(count($c->experiencias) > 0){
                $pdf .= '<table border="0" width="800px" cellpadding="2" cellspacing="2" align="center" class="texto">
                            <tr>
                                <td align="center" colspan="4" class="linha"><b>Experiência Profissional</b></td>
                            </tr>   
                            <tr class="linha_cabecalho">
                                <td>Empresa</td>
                                <td>Data Início</td>
                                <td>Data Término</td>
                                <td>Principais Atividades</td>
                            </tr>';

                            foreach($c->experiencias as $e){
                                $pdf .= '<tr>
                                            <td class="line2" width="">' . $e->nm_empresa . '&nbsp;</td>

                                            <td class="line2" width="">' . Validacao::explodirDataMySqlNaoObg($e->dt_inicio) . '&nbsp;</td>

                                            <td class="line2" width="">' . Validacao::explodirDataMySqlNaoObg($e->dt_termino) . '&nbsp;</td>

                                            <td class="line2" width="">' .nl2br($e->ds_atividades). '&nbsp;</td>
                                        </tr>';
                            }
                            $pdf .= '<tr>
                                        <td colspan="4" align="center">&nbsp;</b>
                                    </tr>
                        </table>';
            }
            
            if ($qtdCand != 0){
                $pdf.= '<pagebreak type="NEXT-ODD" resetpagenum="0" pagenumstyle="1" suppress="off" />';
            }
        }//foreach candidatos

        $pdf .= '</body></html>';

        //echo $pdf;die;

        $nm_arquivo = null;
        if (count($candidatos) == 1) {
            $nm_arquivo = $candidatos[0]->nm_candidato . ' - ' . date('d/m/y');
        } else {
            $nm_arquivo = 'Curriculo(s) - ' . date('d/m/y');
        }

        //$headerPdf = utf8_encode($headerPdf);
        //$mpdf->SetHTMLHeader($headerPdf);

        $footerPdf = utf8_encode($footerPdf);
        $mpdf->SetHTMLFooter($footerPdf);

        $pdf = utf8_encode($pdf);
        $mpdf->WriteHTML($pdf);

        $mpdf->Output($nm_arquivo . '.pdf', 'D');

        exit;
    }
    
    public static function imprimirCurriculoCompletoCandidato($candidatos){
        $qtdCand = count($candidatos);
        
        $mpdf = new mPDF('iso-8859-2', 'A4', '', '', 10, 10, 2, 20, 2, 2);

        $headerPdf = '<table width="100%" cellpadding="6" cellspacing="6" align="center">
                        <tr>
                            <td align="left"><img src="../imagens/imprimir_header.png" width="40%"></td>
                        </tr>
                      </table>';

        $footerPdf = '<table border="0" width="100%" align="center" class="texto">
                        <tr>
                            <td align="center" colspan="2"></td>
                        </tr>
                        <tr>
                        <td width="10%" align="left">{DATE j-m-Y}</td>
                        <td width="10%" align="right">{PAGENO}/{nbpg}</td>
                        </tr>
                    </table>';

        $pdf = '
              <html>
                <head>
                    <title>New document</title>
                    <style>	
                        <!--
                        .texto {
                        color: #000000;
                        text-decoration: none;
                        font-size: 12px;
                        font-family: verdana,helvetica, sans-serif, Helvetica;
                        text-align: justify;
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
                        color:#000;
                        font-size: 30px;
                        }
                        -->
                    </style>
                </head>
                <body>';

        foreach ($candidatos as $c) {
            
            $foto = '../fotos/' . $c->id_candidato . '.jpg';
            $foto = (file_exists($foto)) ? "$foto" : "../fotos/foto_null.jpg";
            
            $qtdCand--;            
            /********************************************************************************************************
            * DADOS PESSOAIS
            ********************************************************************************************************/
            $pdf .= '<table border="0" width="800px" cellpadding="2" cellspacing="2" align="center" class="texto"> 
                        <tr>
                            <td align="" colspan="3" class="linha_nome">
                            ' . $c->nm_candidato . '&nbsp;
                            </td>
                            <td align="right">
                                <img src="'. $foto .'">                            
                            </td>
                        </tr>
                    </table>
                    <table border="0" width="800px" cellpadding="2" cellspacing="2" align="center" class="texto"> 
                        <tr>
                            <td align="center" colspan="4" class="linha" ><b>Dados Pessoais</b></td>
                        </tr>
                        <tr>
                            <td class="line" width="20%">Nome</td>
                            <td class="line2" width="30%">' . $c->nm_candidato . '&nbsp;</td>

                            <td class="line"  width="20%">E-mail</td>
                            <td class="line2" width="30%">' . $c->ds_email . '&nbsp;</td>
                        </tr>
                        <tr>
                           <td class="line">Telefone</td>
                           <td class="line2">' . $c->nr_telefone . '&nbsp;</td>

                           <td class="line">Celular</td>
                           <td class="line2">' . $c->nr_celular . '&nbsp;</td>
                        </tr>
                        <tr>
                           <td class="line">CPF</td>
                           <td class="line2">' . $c->nr_cpf . '&nbsp;</td>

                           <td class="line">RG</td>
                           <td class="line2">' . $c->nr_rg . '&nbsp;</td>
                        </tr>
                        <tr> 
                            <td class="line">CTPS / Nº Série / UF</td>
                            <td class="line2">';                               
                            $pdf .= ($c->nr_ctps == null) ? '*******' : $c->nr_ctps;
                            $pdf .= ($c->nr_serie == null) ? '/ ****' : ' / '. $c->nr_serie;
                            $pdf .= ($c->id_estadoctps == null) ? '/ **' : ' / '. Servicos::buscarEstadoPorId($c->id_estadoctps)->sg_estado;
                            $pdf .= '</td>

                            <td class="line">Gênero</td>
                            <td class="line2">' . Servicos::verificarGenero($c->ao_sexo) . '&nbsp;</td>
                        </tr>  
                        <tr>
                           <td class="line">Logradouro</td>
                           <td class="line2">' . $c->ds_logradouro . '&nbsp;</td>

                           <td class="line">Número / Comp.</td>
                           <td class="line2">';
                            $pdf .= ($c->nr_logradouro == null) ? '****' : $c->nr_logradouro;
                            $pdf .= ($c->ds_complemento == null) ? ' / ****' : ' / '. $c->ds_complemento;
                            $pdf .= '</td>                            
                        </tr>
                        <tr>
                            <td class="line">Bairro</td>
                            <td class="line2">' . $c->ds_bairro . '&nbsp;</td>

                            <td class="line">Cidade / UF</td>
                            <td class="line2">';
                                $pdf .= ($c->id_cidade == null) ? '******' : Servicos::buscarCidadePorId($c->id_cidade)->nm_cidade;
                                $pdf .= ($c->id_cidade == null) ? ' / ******' : ' / '. Servicos::buscarEstadoPorId(Servicos::buscarIdEstado($c->id_cidade))->sg_estado; 
                            $pdf .= '</td>
                        </tr>
                        <tr>
                            <td class="line">Estado Civil</td>
                            <td class="line2">' . Servicos::verificarEstadoCivil($c->ds_estado_civil) . '&nbsp;</td>

                            <td class="line">Data de Nascimento</td>
                            <td class="line2">' . Validacao::explodirDataMySql($c->dt_nascimento) . '&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="line">Nacionalidade</td>
                            <td class="line2">' . $c->ds_nacionalidade . '&nbsp;</td>                            
                        </tr>
                        <tr>
                            <td colspan="4" align="center">&nbsp;</td>
                        </tr>';                           
                        if($c->ds_objetivo != ''){  
                            $pdf .= '<tr>
                                        <td class="line">Objetivos</td>                                               
                                        <td colspan="4" class="line2">' . nl2br($c->ds_objetivo) . '&nbsp;</td>
                                    </tr>';
                        }
                        $pdf .= '<tr>
                                    <td colspan="4">&nbsp;</b>
                                </tr>
                    </table>';
                                    
            /********************************************************************************************************
            * PROFISSAO
            *******************************************************************************************************/
            if(count($c->profissoes) > 0){
                $pdf .= '<table border="0" width="800px" cellpadding="2" cellspacing="2" align="center" class="texto">
                                        <tr>
                                            <td align="center" colspan="4" class="linha"><b>Profissão</b></td>
                                        </tr>';                           
                
                                        foreach($c->profissoes as $cp){                    
                                            $pdf .= '<tr>
                                                        <td class="line2" width="100%">' .Servicos::buscarProfissaoPorId($cp->id_profissao). '&nbsp;</td>                           
                                                    </tr>';
                                        }
                                
                                        $pdf .= '<tr>
                                                    <td colspan="4" align="center">&nbsp;</td>
                                                </tr>
                                    </table>';
            }                
            /********************************************************************************************************
            * FORMACOES
            ********************************************************************************************************/
            if (count($c->formacoes) > 0) {
                $pdf .= '<table border="0" width="800px" cellpadding="2" cellspacing="2" align="center" class="texto">
                            <tr>
                                <td align="center" colspan="4" class="linha"><b>Formação</b></td>
                            </tr>
                            <tr class="linha_cabecalho">
                                <td>Escolaridade</td>
                                <td>Data Término</td>
                                <td>Escola</td>
                                <td>Cidade Escola</td>
                            </tr>';

                            foreach($c->formacoes as $f){
                                $pdf .= '<tr>
                                            <td class="line2">' . Servicos::verificarFormacao($f->id_formacao) . '&nbsp;</td>

                                            <td class="line2">' . Validacao::explodirDataMySqlNaoObg($f->dt_termino) . '&nbsp;</td>

                                            <td class="line2">' . $f->nm_escola . '&nbsp;</td>

                                            <td class="line2">' . $f->ds_cidadeescola . '&nbsp;</td>
                                        </tr>';
                            }
                            $pdf .= '<tr>
                                        <td colspan="4" align="center">&nbsp;</td>
                                    </tr>
                        </table>';
            }            
            /********************************************************************************************************
            * QUALIFICACOES
            *********************************************************************************************************/
            if(count($c->qualificacoes) > 0){
                $pdf .= '<table border="0" width="800px" cellpadding="2" cellspacing="2" align="center" class="texto">
                            <tr>
                                <td align="center" colspan="4" class="linha"><b>Qualificações</b></td>
                            </tr>
                            <tr class="linha_cabecalho">
                                <td>Descrição</td>
                                <td>Instituição</td>
                                <td>Data Término</td>
                                <td>Qnt. Horas</td>
                            </tr>';

                            foreach($c->qualificacoes as $q){
                                $pdf .= '<tr>                                        
                                            <td class="line2">' . $q->ds_qualificacao . '&nbsp;</td>

                                            <td class="line2">' . $q->nm_instituicao . '&nbsp;</td>

                                            <td class="line2">' . Validacao::explodirDataMySqlNaoObg($q->dt_termino) . '&nbsp;</td>    

                                            <td class="line2">' . $q->qtd_horas . '&nbsp;</td>
                                        </tr>';
                            }
                            $pdf .= '<tr>
                                        <td colspan="4" align="center">&nbsp;</td>
                                    </tr>
                        </table>';
            }else{
                $pdf .= '<table border="0" width="800px" cellpadding="2" cellspacing="2" align="center" class="texto">
                            <tr>
                                <td align="center" class="linha"><b>Qualificações</b></td>
                            </tr>
                            <tr class="linha_cabecalho">
                                <td>Candidato não possui qualificações.</td>
                            <tr>
                        </table>';
            }
            /********************************************************************************************************
            * EXPERIENCIAS
            *********************************************************************************************************/
            if(count($c->experiencias) > 0){
                $pdf .= '<table border="0" width="800px" cellpadding="2" cellspacing="2" align="center" class="texto">
                            <tr>
                                <td align="center" colspan="4" class="linha"><b>Experiência Profissional</b></td>
                            </tr>
                            <tr class="linha_cabecalho">
                                <td>Empresa</td>
                                <td>Data Início</td>
                                <td>Data Término</td>
                                <td>Principais Atividades</td>
                            </tr>';

                            foreach($c->experiencias as $e){
                                $pdf .= '<tr>
                                            <td class="line2">' . $e->nm_empresa . '&nbsp;</td>

                                            <td class="line2">' . Validacao::explodirDataMySqlNaoObg($e->dt_inicio) . '&nbsp;</td>

                                            <td class="line2">' . Validacao::explodirDataMySqlNaoObg($e->dt_termino) . '&nbsp;</td>

                                            <td class="line2">' . nl2br($e->ds_atividades) . '&nbsp;</td>
                                        </tr>';
                            }
                            $pdf .= '<tr>
                                        <td colspan="4" align="center">&nbsp;</b>
                                    </tr>
                        </table>';
            }else{
                $pdf .= '<table border="0" width="800px" cellpadding="2" cellspacing="2" align="center" class="texto">
                            <tr>
                                <td align="center" class="linha"><b>Experiências</b></td>
                            </tr>
                            <tr class="linha_cabecalho">
                                <td>Candidato não possui experiências anteriores.</td>
                            <tr>
                        </table>';
            }

            if ($qtdCand != 0){
                $pdf.= '<pagebreak type="NEXT-ODD" resetpagenum="0" pagenumstyle="1" suppress="off" />';
            }
        }//foreach candidatos

        $pdf .= '</body></html>';
        
        //echo $pdf;die;

        $nm_arquivo = null;
        if (count($candidatos) == 1) {
            $nm_arquivo = $candidatos[0]->nm_candidato . ' - ' . date('d/m/y');
        } else {
            $nm_arquivo = 'Curriculo(s) - ' . date('d/m/y');
        }

        //$headerPdf = utf8_encode($headerPdf);
        //$mpdf->SetHTMLHeader($headerPdf);

        $footerPdf = utf8_encode($footerPdf);
        $mpdf->SetHTMLFooter($footerPdf);

        $pdf = utf8_encode($pdf);
        $mpdf->WriteHTML($pdf);

        $mpdf->Output($nm_arquivo . '.pdf', 'D');

        exit;
    }
    
    public static function imprimirLista($vagasCandidato) {
        
        $mpdf = new mPDF('iso-8859-2', 'A4', '', '', 10, 10, 2, 20, 2, 2);

        $headerPdf = '<table width="100%" cellpadding="6" cellspacing="6" align="center">
                        <tr>
                            <td align="left">&nbsp;</td>
                        </tr>
                      </table>';

        $footerPdf = '<table border="0" width="100%" align="center" class="texto">
                        <tr>
                            <td align="center" colspan="2"></td>
                        </tr>
                        <tr>
                        <td width="10%" align="left">{DATE j-m-Y}</td>
                        <td width="10%" align="right">{PAGENO}/{nbpg}</td>
                        </tr>
                    </table>';

        $pdf = '
              <html>
                <head>
                    <title>New document</title>
                    <style>	
                        <!--
                        .texto {
                        color: #000000;
                        text-decoration: none;
                        font-size: 12px;
                        font-family: verdana,helvetica, sans-serif, Helvetica;
                        text-align: justify;
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
                        color:#000;
                        font-size: 30px;
                        }
                        -->
                    </style>
                </head>
                <body>
                    <table border="0" width="800px" cellpadding="2" cellspacing="2" align="center" class="texto">
                        <tr>
                            <td align="center" colspan="5" class="linha"><b>Candidatos Encaminhados</b></td>
                        </tr>

                        <tr>
                            <td class="line2">Vaga:</td>
                            <td class="line2" colspan="4">'. Servicos::buscarProfissaoPorIdVaga(ControleSessao::buscarObjeto('objVaga')->id_vaga)->nm_profissao .'</td>
                        </tr>
                        <tr>
                            <td colspan="5">&nbsp;</b>
                        </tr>';                                

                        $pdf .= '<tr class="linha_cabecalho">
                                    <td>Código</td>
                                    <td>Nome</td>
                                    <td>Telefone</td>
                                    <td>Email</td>                                        
                                    <td>Status</td>
                                </tr>';

                        foreach ($vagasCandidato as $vc) {

                            $pdf .= '<tr>
                                        <td class="line2">'. $vc->id_candidato .'&nbsp;</td>
                                        <td class="line2">'. $vc->candidato->nm_candidato .'&nbsp;</td>
                                        <td class="line2">'. $vc->candidato->nr_telefone .'&nbsp;</td>
                                        <td class="line2">'. $vc->candidato->ds_email .'&nbsp;</td>
                                        <td class="line2">'. Servicos::verificarStatusEncaminhado($vc->ao_status) .'&nbsp;</td>
                                    </tr>';
                        }
                        $pdf .= '<tr>
                                    <td colspan="5" align="center">&nbsp;</b></td>
                                </tr>
                    </table>
                    </body>
                </html>';
        
        $nm_arquivo = 'Lista_dos_candidatos_encaminhados - ' . date('d/m/y');
        
        $headerPdf = utf8_encode($headerPdf);
        $mpdf->SetHTMLHeader($headerPdf);

        $footerPdf = utf8_encode($footerPdf);
        $mpdf->SetHTMLFooter($footerPdf);

        $pdf = utf8_encode($pdf);
        $mpdf->WriteHTML($pdf);

        $mpdf->Output($nm_arquivo . '.pdf', 'D');

        exit;
    }   

}

?>