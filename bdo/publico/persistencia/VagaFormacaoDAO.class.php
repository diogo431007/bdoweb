<?php
include_once '../modelo/VagaFormacaoVO.class.php';
class VagaFormacaoDAO{
    
    private $conexao = null;
    
    public function __construct(){
        $this->conexao = Conexao::getInstancia();
    }  
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 23/03/2015 - 15:52
     * 
     * @param VagaFormacaoVO $p Recebe um objeto VagaFormacaoVO que será inserido no BD.
     * @return int Retorna id gerado
    */
    public function cadastrarVagaFormacao($a){
        try{            
            $stat = $this->conexao->prepare("insert into vagaformacao(
                                                id_vagaformacao, 
                                                id_vaga,                                                 
                                                id_formacao
                                             )
                                             values(
                                                    null,
                                                    '$a->id_vaga',
                                                    '$a->id_formacao'                                                    
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
     * @since 23/03/2015 - 15:54
     * @version Banco de Oportunidades 2.0
     * 
     * @return array Retorna um array de vaga formação.
     */
    public function buscarVagaFormacoes(){
        try{
            
            $stat = $this->conexao->query("select * from vagaformacao");

            $array = $stat->fetchAll(PDO::FETCH_CLASS, 'VagaFormacaoVO');
            $this->conexao = null;
            return $array;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar vaga formação';
        }
    }
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 23/03/2015 - 15:56
     * @version Banco de Oportunidades 2.0
     * 
     * @param int $id Recebe o id do vaga formação
     * @return VagaFormacaoVO Retorna um objeto VagaFormacaoVO
     */
    public function buscarVagaFormacaoPorIdVaga($id_vaga, $id_formacao){
        try{
            $stat = $this->conexao->query("select * from vagaformacao where id_vaga = $id_vaga and id_formacao = $id_formacao");
            
            $array = $stat->fetchAll(PDO::FETCH_CLASS,'VagaFormacaoVO');
            $this->conexao = null;
            return $array;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar vaga formação';
        }
    }
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 24/03/2015 - 10:26
     * @version Banco de Oportunidades 2.0
     * 
     * @param int $id Recebe o id do vaga formação
     * @return VagaFormacaoVO Retorna um objeto VagaFormacaoVO
     */
    public function buscarVagaFormacaoPorId($id_vaga){
        try{
            $stat = $this->conexao->query("select * from vagaformacao where id_vaga = $id_vaga");
            
            $array = $stat->fetchAll(PDO::FETCH_CLASS,'VagaFormacaoVO');
            $this->conexao = null;
            return $array;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar vaga Formação';
        }
    }
    
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 24/03/2015 - 10:27
     * 
     * @param int $id_vaga Recebe o id do objeto VagaFormacaoVO que será excluido do BD.
    */
    public function deletarVagaFormacao($id_vaga){
        try{            
            $stat = $this->conexao->prepare("delete from vagaformacao where id_vaga = $id_vaga");
            
            $stat->execute();
            $this->conexao = null;

        }catch(PDOException $e){
            return 'Erro ao deletar a vaga formação';
        }
    }
}
?>
