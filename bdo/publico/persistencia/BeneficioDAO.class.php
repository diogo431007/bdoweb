<?php
include_once '../modelo/BeneficioVO.class.php';
class BeneficioDAO{
    
    private $conexao = null;
    
    public function __construct(){
        $this->conexao = Conexao::getInstancia();
    }
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 19/02/2015 - 10:42
     * @version Banco de Oportunidades 2.0
     * 
     * @return array Retorna um array de beneficio.
     */
    public function buscarBeneficios(){
        try{
            
            $stat = $this->conexao->query("select * from beneficio");

            $array = $stat->fetchAll(PDO::FETCH_CLASS, 'BeneficioVO');
            $this->conexao = null;
            return $array;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar benefício';
        }
    }
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 19/02/2015 - 10:43
     * @version Banco de Oportunidades 2.0
     * 
     * @param int $id Recebe o id do beneficio
     * @return BeneficioVO Retorna um objeto BeneficioVO
     */
    public function buscarBeneficioPorId($id){
        try{
            $stat = $this->conexao->query("select * from beneficio where id_beneficio = $id");
            
            $beneficio = $stat->fetchObject('BeneficioVO');
            $this->conexao = null;
            return $beneficio;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar benefício';
        }
    }
}
?>
