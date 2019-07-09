<?php

session_start();
include_once './conecta.php';
include_once './funcoes.php';

if (isset($_GET['op'])) {
    switch ($_GET['op']) {
        case 'buscar':
            if (isset($_POST)) {
                $erros = array();
                
                
                if (!validarData($_POST['dt_inicio_periodo']) && !empty($_POST['dt_inicio_periodo'])) $erros[] = 'dt_inicio_periodo';
                if (!validarData($_POST['dt_fim_periodo']) && !empty($_POST['dt_fim_periodo'])) $erros[] = 'dt_fim_periodo';
                
                if (count($erros) == 0) {
                    
                    
                    
                    $inicio = (!empty($_POST['dt_inicio_periodo'])) ? "'".converterData($_POST['dt_inicio_periodo']) . " 00:00:00'" : '';
                    $fim = (!empty($_POST['dt_fim_periodo'])) ? "'".converterData($_POST['dt_fim_periodo']) . " 23:59:59'" : '';
                    $periodo = '';
                    
                    
                    if(!empty($inicio) && !empty($fim)){
                        $periodo = ' dt_cadastro BETWEEN ' . $inicio . ' and ' . $fim;
                        $periodoDeficiente = ' hc.dt_cadastro BETWEEN ' . $inicio . ' and ' . $fim;
                        
                        //na tabela vagacandidato esta dt_status
                        $dt_status = ' dt_status BETWEEN ' . $inicio . ' and ' . $fim;
                    }else if(!empty($inicio) && empty($fim)){
                        $periodo = ' dt_cadastro >= ' . $inicio;
                        $periodoDeficiente = ' hc.dt_cadastro >= ' . $inicio;
                        
                        //na tabela vagacandidato esta dt_status
                        $dt_status = ' dt_status >= ' . $inicio;
                    }else if(empty($inicio) && !empty($fim)){
                        $periodo = ' dt_cadastro <= ' . $fim;
                        $periodoDeficiente = ' hc.dt_cadastro <= ' . $fim;
                        
                        //na tabela vagacandidato esta dt_status
                        $dt_status = ' dt_status <= ' . $fim;
                    }  else {
                        $periodo = ' 1 = 1';
                        $periodoDeficiente = ' 1 = 1';
                        $dt_status = ' 1 = 1';
                    }
                    
                    //Número de currículos cadastrados no banco por período
                    $sqlCurriculosCad = "SELECT count(*) as totalCandidatos FROM candidato WHERE $periodo";
                    $resCurriculosCad = mysql_fetch_object(mysql_query($sqlCurriculosCad));
                                                            
                    //Número de empresas cadastradas no banco por período
                    $sqlEmpresa = "SELECT count(*) as empresasCadastradas FROM empresa WHERE $periodo";
                    $resEmpresaCad = mysql_fetch_object(mysql_query($sqlEmpresa));                                                           
                    
                    //Número de empregos efetivados no banco
                    $sqlContratados = "SELECT count(*) as contratados FROM vagacandidato WHERE ao_status = 'C' AND $dt_status";
                    $resContratados = mysql_fetch_object(mysql_query($sqlContratados));

                    //Número de vagas ofertadas no banco
                    #$sqlTotalVagas = "SElECT sum(qt_vaga) as vagas FROM vaga WHERE $periodo";                    
                    
                    $sqlTotalVagas = "SELECT SUM(qt_vaga) AS vagas FROM
                                        (SELECT id_vaga,qt_vaga FROM                                      
                                                (SELECT id_vaga,qt_vaga FROM historicovaga 
                                                 WHERE $dt_status
                                                 ORDER BY dt_status desc) AS ordena_vagamaisatualnoperiodo 
                                    GROUP BY id_vaga) AS agrupa_vagas";
                    
                    $resTotalVagas = mysql_fetch_object(mysql_query($sqlTotalVagas));
                    
                    
                    //Número de encaminhamentos para entrevista através do banco
                    $sqlNumEncaminhamentos = "SELECT count(*) as encaminhamentos FROM historicocandidato WHERE $periodo AND ao_status = 'E'";
                    $resNumEncaminhamentos = mysql_fetch_object(mysql_query($sqlNumEncaminhamentos));
                    
                    //Número de deficientes encaminhados para entrevista através do banco
                    $sqlNumDeficientes = "SELECT COUNT(*) AS encaminhamentosDeficientes
                                            FROM historicocandidato hc
                                            JOIN vagacandidato vc ON (vc.id_vagacandidato = hc.id_vagacandidato)
                                            JOIN candidato c ON (c.id_candidato = vc.id_candidato)
                                            WHERE c.id_deficiencia is not null AND 
                                            $periodoDeficiente AND hc.ao_status = 'E'";
                    $resNumDeficientes = mysql_fetch_object(mysql_query($sqlNumDeficientes));
                    
                    
                    //Caso a soma dos resultados de vazio no sum, colocar um "0"
                    if ($resTotalVagas->vagas == ""){
                        $resTotalVagas->vagas = 0;
                    }
                    
                    //Joga os resultados dos sqls no array
                    $res = array();
                    $res['totalCandidatos'] = $resCurriculosCad->totalCandidatos;
                    $res['empresasCadastradas'] = $resEmpresaCad->empresasCadastradas;
                    $res['contratados'] = $resContratados->contratados;
                    $res['totalVagas'] = $resTotalVagas->vagas;
                    $res['numEncaminhamentos'] = $resNumEncaminhamentos->encaminhamentos;
                    $res['numEncaminhamentosDeficientes'] = $resNumDeficientes->encaminhamentosDeficientes;
                                        
                    $_SESSION['periodo'] = $res;
                    $_SESSION['datas'] = $_POST;                                      
                    
                    header("location:relatorio.php#parte-05");
                    
                }else {
                    $_SESSION['erros'] = $erros;
                    $_SESSION['post'] = $_POST;
                    header('location:relatorio.php#parte-02');
                }
                
            }
            break;
    }
}