<?php
session_start();
include_once './conecta.php';
include_once './funcoes.php';

if (isset($_GET['op'])) {
    switch ($_GET['op']) {
        case 'buscar':
            if (isset($_POST)) {
                
                $erros = array();
                
                if(!validarData($_POST['dt_inicio'])) $erros[] = 'dt_inicio';
                if(!validarData($_POST['dt_fim'])) $erros[] = 'dt_fim';
                if(!validarOrigemAcesso($_POST['ao_origem'])) $erros[] = 'ao_origem';
                if(!validarTipoRelatorio($_POST['ao_tipo'])) $erros[] = 'ao_tipo';
                
                if(count($erros)==0){
                    
                   //echo var_dump($_POST);die;
                    
                    $inicio = converterData($_POST['dt_inicio']).' 00:00:00';
                    $fim = converterData($_POST['dt_fim']).' 23:59:59';
                    $origem = $_POST['ao_origem'];
                    $tipo = $_POST['ao_tipo'];
                    
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
                                        l.ao_tipo = '$origem' AND 
                                        l.dt_log >= '$inicio' AND 
                                        l.dt_log <= '$fim'
                                    ORDER BY l.dt_log ASC";
                            
                        }else{
                            $sql = "SELECT 
                                    l.id_log,
                                    l.id_acesso,
                                    COUNT(l.id_acesso) as qt_acessos,
                                    c.nm_candidato as nome 
                                FROM 
                                    log l, 
                                    candidato c 
                                WHERE 
                                    l.id_acesso = c.id_candidato AND 
                                    l.ao_tipo = '$origem' AND 
                                    l.dt_log >= '$inicio' AND 
                                    l.dt_log <= '$fim'
                                GROUP BY l.id_acesso";
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
                                        l.ao_tipo = '$origem' AND 
                                        l.dt_log >= '$inicio' AND 
                                        l.dt_log <= '$fim'
                                    ORDER BY l.dt_log ASC";
                            }else{
                                $sql = "SELECT
                                            l.id_log,
                                            l.id_acesso,
                                            COUNT(l.id_acesso) as qt_acessos,
                                            e.nm_razaosocial as nome
                                        FROM
                                            log l,
                                            empresa e
                                        WHERE 
                                            l.id_acesso = e.id_empresa AND
                                            l.ao_tipo = '$origem' AND 
                                            l.dt_log >= '$inicio' AND 
                                            l.dt_log <= '$fim'
                                        GROUP BY l.id_acesso";
                              
                                        
                            }
                    }
                    
                    $query = mysql_query($sql);
                    
                    $res = array();
                    while($row = mysql_fetch_object($query)) {
                        $res[] = $row;
                    }
                    $_SESSION['log'] = $res;
                    $_SESSION['post'] = $_POST;
                    header("location:relatorio.php#parte-01");
                    
                }else{
                    $_SESSION['erros'] = $erros;
                    $_SESSION['post'] = $_POST;
                    header('location:relatorio.php#parte-01');
                }
                
                
            }
            break;

        case 'imprimir':
            if (isset($_POST)) {
                echo 'imprimir';
                echo var_dump($_SESSION);
                echo var_dump($_POST);
            }
            break;

        default:
            session_destroy();
            header('location:index.php');
            break;
    }
}
?>
