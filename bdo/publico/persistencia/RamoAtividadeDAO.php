<?php
include_once '../modelo/RamoAtividadeVO.class.php';
class RamoAtividadeDAO{
    
    private $conexao = null;
    
    public function __construct(){
        $this->conexao = Conexao::getInstancia();
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 04/11/2013 - 10:57
     * @version Banco de Oportunidades 2.0
     * 
     * @return array Retorna um array de ramos atividade.
     */
    public function buscar(){
        try{
            
            $stat = $this->conexao->query("select * from ramoatividade");

            $array = $stat->fetchAll(PDO::FETCH_CLASS, 'RamoAtividadeVO');
            $this->conexao = null;
            return $array;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar ramo atividade';
        }
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 04/11/2013 - 11:01
     * @version Banco de Oportunidades 2.0
     * 
     * @param int $id Recebe o id do ramo atividade
     * @return RamoAtividadeVO Retorna um objeto RamoAtividadeVO
     */
    public function buscarRamoPorId($id){
        try{
            $stat = $this->conexao->query("select * from ramoatividade where id_ramoatividade = $id");
            
            $ramo = $stat->fetchObject('RamoAtividadeVO');
            $this->conexao = null;
            return $ramo;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar ramo atividade';
        }
    }
}
?>
