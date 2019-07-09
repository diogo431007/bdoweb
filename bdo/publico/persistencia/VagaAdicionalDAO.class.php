<?php
include_once '../modelo/VagaAdicionalVO.class.php';
class VagaAdicionalDAO{
    
    private $conexao = null;
    
    public function __construct(){
        $this->conexao = Conexao::getInstancia();
    }  
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 20/02/2015 - 14:05
     * 
     * @param VagaAdicionalVO $p Recebe um objeto VagaAdicionalVO que será inserido no BD.
     * @return int Retorna id gerado
    */
    public function cadastrarVagaAdicional($a){
        try{            
            $stat = $this->conexao->prepare("insert into vagaadicional(
                                                id_vagaadicional, 
                                                id_vaga,                                                 
                                                id_adicional
                                             )
                                             values(
                                                    null,
                                                    '$a->id_vaga',
                                                    '$a->id_adicional'                                                    
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
     * @since 20/02/2015 - 14:49
     * @version Banco de Oportunidades 2.0
     * 
     * @return array Retorna um array de vaga adicional.
     */
    public function buscarVagaAdicionais(){
        try{
            
            $stat = $this->conexao->query("select * from vagaadicional");

            $array = $stat->fetchAll(PDO::FETCH_CLASS, 'VagaAdicionalVO');
            $this->conexao = null;
            return $array;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar vaga adicional';
        }
    }
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 20/02/2015 - 14:51
     * @version Banco de Oportunidades 2.0
     * 
     * @param int $id Recebe o id do vaga adicional
     * @return VagaAdicionalVO Retorna um objeto VagaAdicionalVO
     */
    public function buscarVagaAdicionalPorIdVaga($id_vaga, $id_adicional){
        try{
            $stat = $this->conexao->query("select * from vagaadicional where id_vaga = $id_vaga and id_adicional = $id_adicional");
            
            $array = $stat->fetchAll(PDO::FETCH_CLASS,'VagaAdicionalVO');
            $this->conexao = null;
            return $array;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar vaga adicional';
        }
    }
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 25/02/2015 - 08:44
     * @version Banco de Oportunidades 2.0
     * 
     * @param int $id Recebe o id do vaga adicional
     * @return VagaAdicionalVO Retorna um objeto VagaAdicionalVO
     */
    public function buscarVagaAdicionalPorId($id_vaga){
        try{
            $stat = $this->conexao->query("select * from vagaadicional where id_vaga = $id_vaga");
            
            $array = $stat->fetchAll(PDO::FETCH_CLASS,'VagaAdicionalVO');
            $this->conexao = null;
            return $array;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar vaga adicional';
        }
    }
    
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 24/02/2015 - 14:28
     * 
     * @param int $id_vaga Recebe o id do objeto VagaAdicionalVO que será excluido do BD.
    */
    public function deletarVagaAdicional($id_vaga){
        try{            
            $stat = $this->conexao->prepare("delete from vagaadicional where id_vaga = $id_vaga");
            
            $stat->execute();
            $this->conexao = null;

        }catch(PDOException $e){
            return 'Erro ao deletar a vaga adicional';
        }
    }
}
?>
