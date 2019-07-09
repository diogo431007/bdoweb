<?php
include_once '../modelo/AdicionalVO.class.php';
class AdicionalDAO{
    
    private $conexao = null;
    
    public function __construct(){
        $this->conexao = Conexao::getInstancia();
    }     
   
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 19/02/2015 - 09:25
     * @version Banco de Oportunidades 2.0
     * 
     * @return array Retorna um array de adicional.
     */
    public function buscarAdicionais(){
        try{
            
            $stat = $this->conexao->query("select * from adicional");

            $array = $stat->fetchAll(PDO::FETCH_CLASS, 'AdicionalVO');
            $this->conexao = null;
            return $array;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar adicional';
        }
    }
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 19/02/2015 - 09:26
     * @version Banco de Oportunidades 2.0
     * 
     * @param int $id Recebe o id do adicional
     * @return AdicionalVO Retorna um objeto AdicionalVO
     */
    public function buscarAdicionalPorId($id){
        try{
            $stat = $this->conexao->query("select * from adicional where id_adicional = $id");
            
            $adicional = $stat->fetchObject('AdicionalVO');
            $this->conexao = null;
            return $adicional;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar adicional';
        }
    }
}
?>
