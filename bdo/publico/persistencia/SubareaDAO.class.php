<?php
include_once 'Conexao.class.php';
include_once '../modelo/SubareaVO.class.php';
//include_once '../modelo/AreaVO.class.php';
//include_once './AreaDAO.class.php';
class SubareaDAO{
    
    private $conexao = null;
    
    public function __construct(){
        $this->conexao = Conexao::getInstancia();
    }
    
    /**
     * @author Ricardo K.Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 20/03/2014 - 09:57
     * @version Banco de Oportunidades 2.0
     * 
     * @param String $id_area Recebe o id_area como filtro da busca.
     * @return SubareaVO Retorna um array de SubareaVO.
     */
    public function buscarSubareaPorIdArea($id_area){
        try{
            $stat = $this->conexao->query("select * from subarea where id_area = $id_area");
            
            $subareas = $stat->fetchAll(PDO::FETCH_CLASS, 'SubareaVO');
            $this->conexao = null;
            return $subareas;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar sub area.';
        }
    }
    
    /**
     * @author Ricardo K.Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 20/03/2014 - 10:00
     * @version Banco de Oportunidades 2.0
     * 
     * @param String $id_subarea Recebe o id_subarea como filtro da busca.
     * @return SubareaVO Retorna um array de SubareaVO.
     */
    public function buscarSubareaPorIdSubarea($id_subarea){
        try{
            $stat = $this->conexao->query("select * from subarea as sa where sa.id_area in (select id_area from subarea where id_subarea = $id_subarea)");
            
            $subarea = $stat->fetchAll(PDO::FETCH_CLASS, 'SubareaVO');
            $this->conexao = null;
            return $subarea;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar sub area.';
        }
    }
    
    /**
     * @author Ricardo K.Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 20/03/2014 - 10:03
     * @version Banco de Oportunidades 2.0
     * 
     * @param String $id_subarea Recebe o id_subarea como filtro da busca.
     * @return int Retorna o id da area que a subarea pertence
     */
    public function buscarIdArea($id_subarea){
        try{
            $stat = $this->conexao->query("select id_area from subarea where id_subarea = $id_subarea");
            
            $id = $stat->fetchAll(PDO::FETCH_COLUMN, 'id_area');
            $this->conexao = null;
            return $id;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar sub area.';
        }
    }
    
    /**
     * @author Ricardo K.Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 20/03/2014 - 10:05
     * @version Banco de Oportunidades 2.0
     * 
     * @param int $id Recebe o id da subarea
     * @return SubareaVO Retorna um SubareaVO
     */
    public function buscarSubareaPorId($id){
        try{
            
            $stat = $this->conexao->query("select * from subarea where id_subarea = $id");
            
            $subarea = $stat->fetchObject('SubareaVO');
            $this->conexao = null;
            
            return $subarea;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar sub area.';
        }
    }
    
    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 20/03/2014 - 09:37
     * 
     * @param int $id_candidato Recebe o id do candidato como filtro para busca
     * @return array Retorna um array com todos os CandidatoSubAreaVO de um candidato
     */
    public function buscarSubAreasPorCandidato($id_candidato, $id_area){
        try{
            
            $stat = $this->conexao->query("SELECT
                                            s.id_subarea, 
                                            s.nm_subarea, 
                                            a.id_area
                                        FROM 
                                            area a, 
                                            subarea s, 
                                            candidatosubarea c
                                        WHERE 
                                            a.id_area = s.id_area
                                        AND s.id_subarea = c.id_subarea
                                        AND c.id_candidato = $id_candidato
                                        AND a.id_area = $id_area");            
                       
            $array = $stat->fetchAll(PDO::FETCH_CLASS,'SubareaVO');
            $this->conexao = null;
            return $array;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar sub área.';
        }
    }
}
?>