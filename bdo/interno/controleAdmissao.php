    <?php

session_start();
include_once './conecta.php';
include_once './funcoes.php';

if (isset($_GET['op'])) {
    switch ($_GET['op']) {
        case 'buscar':
            if (isset($_POST)) { 
                            
                $erros = array();

                if (!validarData($_POST['dt_inicio_admissao']) && !empty($_POST['dt_inicio_admissao'])) $erros[] = 'dt_inicio_admissao';
                if (!validarData($_POST['dt_fim_admissao']) && !empty($_POST['dt_fim_admissao'])) $erros[] = 'dt_fim_admissao';
                
                if(!is_numeric($_POST['empresa']) && !empty($_POST['empresa'])) $erros[] = 'empresa';
                
                if(!validarStatusVaga($_POST['ao_status']) && !empty($_POST['ao_status'])) $erros[] = 'ao_status';

                if (count($erros) == 0) {
                    
                    
                    $empresa  = (!empty($_POST['empresa'])) ? " and e.id_empresa = ".$_POST['empresa'] : '';
                    
                    $tipo = (!empty($_POST['ao_status'])) ? " and vc.ao_status = '".$_POST['ao_status']."'" : '';
                    
                    $inicio = (!empty($_POST['dt_inicio_admissao'])) ? "'".converterData($_POST['dt_inicio_admissao']) . " 00:00:00'" : '';
                    $fim = (!empty($_POST['dt_fim_admissao'])) ? "'".converterData($_POST['dt_fim_admissao']) . " 23:59:59'" : '';
                    $periodo = '';
                    if(!empty($inicio) && !empty($fim)){
                        $periodo = ' and vc.dt_status between ' . $inicio . ' and ' . $fim;
                    }else if(!empty($inicio) && empty($fim)){
                        $periodo = ' and vc.dt_status > ' . $inicio;
                    }else if(empty($inicio) && !empty($fim)){
                        $periodo = ' and vc.dt_status < ' . $fim;
                    }
                    
                    //##########################TOTAL DE STATUS###############################
                    
                    /*$sqlT = "SELECT COUNT(vc.id_vagacandidato) as qtd, 
                                vc.ao_status as status                                
                             FROM vaga v  
                             JOIN vagacandidato vc ON (v.id_vaga = vc.id_vaga)
                             WHERE 
                                1=1 
                                $empresa
                                $periodo
                             GROUP BY 
                                vc.ao_status";*/                    
                    
                    $sqlT = "SELECT 
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
                    
                    $queryT = mysql_query($sqlT);
                    
                    $statusT = array();
                    while($rowT = mysql_fetch_object($queryT)) {
                        $statusT[] = $rowT;
                    }
                    
                    //##########################TOTAL DE ENCAMINHADOS###############################
                    $sqlE = "SELECT
                                COUNT(vc.id_vagacandidato) as qtd, 
                                e.id_empresa, 
                                vc.ao_status as status                                
                            FROM 
                                empresa e 
                                JOIN vaga v ON (v.id_empresa = e.id_empresa) 
                                JOIN vagacandidato vc ON (v.id_vaga = vc.id_vaga)
                            WHERE 
                                1=1 
                                $empresa
                                $periodo
                                AND vc.ao_status = 'E'
                            GROUP BY 
                                e.id_empresa, 
                                vc.ao_status
                            ORDER BY 
                                e.nm_razaosocial ASC";
                                        
                    $queryE = mysql_query($sqlE);
                    
                    
                    $statusE = array();
                    while($rowE = mysql_fetch_object($queryE)) {
                        $statusE[] = $rowE;                        
                    }
                    
                    //##########################TOTAL DE BAIXA AUTOMÁTICA###############################
                    $sqlB = "SELECT
                                COUNT(vc.id_vagacandidato) as qtd, 
                                e.id_empresa, 
                                vc.ao_status as status                                
                            FROM 
                                empresa e 
                                JOIN vaga v ON (v.id_empresa = e.id_empresa) 
                                JOIN vagacandidato vc ON (v.id_vaga = vc.id_vaga)
                            WHERE 
                                1=1 
                                $empresa
                                $periodo
                                AND vc.ao_status = 'B'
                            GROUP BY 
                                e.id_empresa, 
                                vc.ao_status";
                    
                    
                    $queryB = mysql_query($sqlB);
                    
                    
                    $statusB = array();
                    while($rowB = mysql_fetch_object($queryB)) {
                        $statusB[] = $rowB;                        
                    }
                    
                    
                    //##########################TOTAL DE PRÉ-SELECIONADOS###############################
                    $sqlP = "SELECT
                                COUNT(vc.id_vagacandidato) as qtd, 
                                e.id_empresa, 
                                vc.ao_status as status                                
                            FROM 
                                empresa e 
                                JOIN vaga v ON (v.id_empresa = e.id_empresa) 
                                JOIN vagacandidato vc ON (v.id_vaga = vc.id_vaga)
                            WHERE 
                                1=1 
                                $empresa
                                $periodo
                                AND vc.ao_status = 'P'
                            GROUP BY 
                                e.id_empresa, 
                                vc.ao_status";
                    
                    
                    $queryP = mysql_query($sqlP);                    
                    
                    $statusP = array();
                    while($rowP = mysql_fetch_object($queryP)) {                                               
                        $statusP[] = $rowP;
                    }
                    
                    //##########################TOTAL DE CONTRATADOS###############################
                    $sqlC = "SELECT
                                COUNT(vc.id_vagacandidato) as qtd, 
                                e.id_empresa, 
                                vc.ao_status as status
                            FROM 
                                empresa e 
                                JOIN vaga v ON (v.id_empresa = e.id_empresa) 
                                JOIN vagacandidato vc ON (v.id_vaga = vc.id_vaga)
                            WHERE 
                                1=1 
                                $empresa
                                $periodo
                                AND vc.ao_status = 'C'
                            GROUP BY 
                                e.id_empresa, 
                                vc.ao_status";
                    
                    
                    $queryC = mysql_query($sqlC);                    
                    
                    $statusC = array();
                    while($rowC = mysql_fetch_object($queryC)) {
                        $statusC[] = $rowC;
                    }
                    
                    //##########################TOTAL DE DISPENSADOS###############################
                    $sqlD = "SELECT
                                COUNT(vc.id_vagacandidato) as qtd, 
                                e.id_empresa, 
                                vc.ao_status as status
                            FROM 
                                empresa e 
                                JOIN vaga v ON (v.id_empresa = e.id_empresa) 
                                JOIN vagacandidato vc ON (v.id_vaga = vc.id_vaga)
                            WHERE 
                                1=1 
                                $empresa
                                $periodo
                                AND vc.ao_status = 'D'
                            GROUP BY 
                                e.id_empresa, 
                                vc.ao_status";
                    
                    
                    $queryD = mysql_query($sqlD);
                    
                    $statusD = array();
                    while($rowD = mysql_fetch_object($queryD)) {
                        $statusD[] = $rowD;
                    }
                    
                    //##########################TOTAL DE ENCAMINHADOS DEFICIENTES###############################
                    $sqlDef = "SELECT
                                COUNT(vc.id_vagacandidato) as qtd, 
                                e.id_empresa, 
                                vc.ao_status as status                                
                            FROM 
                                empresa e 
                                JOIN vaga v ON (v.id_empresa = e.id_empresa) 
                                JOIN vagacandidato vc ON (v.id_vaga = vc.id_vaga)
                                JOIN candidato c ON (vc.id_candidato = c.id_candidato)
                            WHERE 
                                1=1 
                                $empresa
                                $periodo
                                AND (vc.ao_status = 'E' OR vc.ao_status = 'P' OR vc.ao_status = 'C' OR vc.ao_status = 'D' OR vc.ao_status = 'B')
                                AND c.id_deficiencia is not null
                            GROUP BY 
                                e.id_empresa, 
                                vc.ao_status
                            ORDER BY 
                                e.nm_razaosocial ASC";
                                        
                    $queryDef = mysql_query($sqlDef);
                    
                    
                    $statusDef = array();
                    while($rowDef = mysql_fetch_object($queryDef)) {
                        $statusDef[] = $rowDef;                        
                    }
                    
                    $res = array();
                    $res['total'] = $statusT;
                    $res['encaminhados'] = $statusE;
                    $res['baixaAutomatica'] = $statusB;
                    $res['preSelecionados'] = $statusP;
                    $res['contratados'] = $statusC;
                    $res['dispensados'] = $statusD;
                    $res['deficientes'] = $statusDef;
                    
                    $_SESSION['admissoes'] = $res;
                    $_SESSION['datas'] = $_POST;
                    header("location:relatorio.php#parte-02");
                    
                } else {
                    $_SESSION['erros'] = $erros;
                    $_SESSION['post'] = $_POST;
                    header('location:relatorio.php#parte-02');
                }
            }
            break;
    }
}
?>
