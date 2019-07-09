<?php
include_once '../modelo/VagaBeneficioVO.class.php';
class VagaBeneficioDAO{
    
    private $conexao = null;
    
    public function __construct(){
        $this->conexao = Conexao::getInstancia();
    }  
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 23/02/2015 - 09:25
     * 
     * @param VagaBeneficioVO $p Recebe um objeto VagaBeneficioVO que será inserido no BD.
     * @return int Retorna id gerado
    */
    public function cadastrarVagaBeneficio($b){
                       
        try{            
            $stat = $this->conexao->prepare("insert into vagabeneficio(
                                                id_vagabeneficio, 
                                                id_vaga,                                                 
                                                id_beneficio
                                             )
                                             values(
                                                    null,
                                                    '$b->id_vaga',
                                                    '$b->id_beneficio'                                                    
                                            )");
            
            $stat->execute();
            
            $idGerado = $this->conexao->lastInsertId();
            $this->conexao = null;
            return $idGerado;
            
        }catch(PDOException $e){
            return false;
        }
    }
   
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 23/02/2015 - 09:26
     * @version Banco de Oportunidades 2.0
     * 
     * @return array Retorna um array de vaga beneficio.
     */
    public function buscarVagaBeneficios(){
        try{
            
            $stat = $this->conexao->query("select * from vagabeneficio");

            $array = $stat->fetchAll(PDO::FETCH_CLASS, 'VagaBeneficioVO');
            $this->conexao = null;
            return $array;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar vaga beneficio';
        }
    }
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 23/02/2015 - 09:26
     * @version Banco de Oportunidades 2.0
     * 
     * @param int $id Recebe o id do vaga beneficio
     * @return VagaBeneficioVO Retorna um objeto VagaBeneficioVO
     */
    public function buscarVagaBeneficioPorIdVaga($id_vaga, $id_beneficio){        
        try{
            $stat = $this->conexao->query("select * from vagabeneficio where id_vaga = $id_vaga and id_beneficio = $id_beneficio");
            
            $array = $stat->fetchAll(PDO::FETCH_CLASS,'VagaBeneficioVO');
            $this->conexao = null;
            return $array;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar vaga beneficio';
        }
    }
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 25/02/2015 - 09:09
     * @version Banco de Oportunidades 2.0
     * 
     * @param int $id Recebe o id do vaga beneficio
     * @return VagaBeneficioVO Retorna um objeto VagaBeneficioVO
    */
    public function buscarVagaBeneficioPorId($id_vaga){        
        try{
            $stat = $this->conexao->query("select * from vagabeneficio where id_vaga = $id_vaga");
            
            $array = $stat->fetchAll(PDO::FETCH_CLASS,'VagaBeneficioVO');
            $this->conexao = null;
            return $array;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar vaga beneficio';
        }
    }
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 24/02/2015 - 15:02
     * 
     * @param int $id_vaga Recebe o id do objeto VagaBeneficioVO que será excluido do BD.
    */
    public function deletarVagaBeneficio($id_vaga){
        try{            
            $stat = $this->conexao->prepare("delete from vagabeneficio where id_vaga = $id_vaga");
            
            $stat->execute();
            $this->conexao = null;

        }catch(PDOException $e){
            return 'Erro ao deletar a vaga beneficio';
        }
    }    
}
?>
