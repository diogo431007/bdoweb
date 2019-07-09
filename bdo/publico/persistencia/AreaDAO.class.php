<?php
include_once '../modelo/AreaVO.class.php';
//include_once './SubareaDAO.class.php';
class AreaDAO{
    
    private $conexao = null;
    
    public function __construct(){
        $this->conexao = Conexao::getInstancia();
    }
    
    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 20/03/2014 - 08:36
     * @version Banco de Oportunidades 2.0
     * 
     * @return AreaVO Retorna um array com todas as areas.
     */
    public function buscarAreas(){
        try{
            $stat = $this->conexao->query("select * from area order by nm_area");

            $array = $stat->fetchAll(PDO::FETCH_CLASS, 'AreaVO');
            $this->conexao = null;
            return $array;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar a área.';
        }
    }
    
    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 20/03/2014 - 11:50
     * 
     * @param int $id Recebe o id da area
     * @return AreaVO Retorna um AreaVO.
     */
    public function buscarAreaPorId($id_area){
        try{
            $stat = $this->conexao->query("select * from area where id_area = $id_area");
            
            $area = $stat->fetchObject('AreaVO');
            $this->conexao = null;
            return $area;
            
            //$marca = $stat->fetchAll(PDO::FETCH_CLASS, 'MarcaVO');
            //$this->conexao = null;
            //return $marca[0];
            
        }catch(PDOException $e){
            echo 'Erro ao buscar marcas';
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
    public function buscarAreasPorCandidato($id_candidato){
        try{
            
            $stat = $this->conexao->query("SELECT 
                                                a.id_area, 
                                                a.nm_area
                                            FROM 
                                                area a, 
                                                subarea s, 
                                                candidatosubarea c
                                            WHERE 
                                                a.id_area = s.id_area
                                            AND s.id_subarea = c.id_subarea
                                            AND c.id_candidato = $id_candidato
                                            GROUP BY a.id_area");
            
            function montarArea($id_area, $nm_area) {                
                $a = new AreaVO();
                $a->id_area = $id_area;
                $a->nm_area = $nm_area;                
                //$saDAO = new SubareaDAO();                
                //$a->subareas = $saDAO->buscarSubareasPorCandidato($id_candidato, $a->id_area);                
                return $a;                
            }
            
            $array = $stat->fetchAll(PDO::FETCH_FUNC,'montarArea');
            $this->conexao = null;
            return $array;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar sub área.';
        }
    }
}
?>