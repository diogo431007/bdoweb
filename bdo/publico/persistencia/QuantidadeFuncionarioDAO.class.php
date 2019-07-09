<?php
include_once '../modelo/QuantidadeFuncionarioVO.class.php';
class QuantidadeFuncionarioDAO{
    
    private $conexao = null;
    
    public function __construct(){
        $this->conexao = Conexao::getInstancia();
    }
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 30/01/2015 - 11:11
     * @version Banco de Oportunidades 2.0
     * 
     * @return array Retorna um array de ramos atividade.
     */
    public function buscar(){
        try{
            
            $stat = $this->conexao->query("select * from quantidadefuncionario");

            $array = $stat->fetchAll(PDO::FETCH_CLASS, 'QuantidadeFuncionarioVO');
            $this->conexao = null;
            return $array;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar a quantidade de funcionários';
        }
    }
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 30/01/2015 - 11:12
     * @version Banco de Oportunidades 2.0
     * 
     * @param int $id Recebe o id da quantidade de funcinários
     * @return QuantidadeFuncionarioVO Retorna um objeto QuantidadeFuncionarioVO
     */
    public function buscarQuantidadeFuncionarioPorId($id){
        try{
            $stat = $this->conexao->query("select * from quantidadefuncionario where id_quantidadefuncionario = $id");
            
            $quantidade = $stat->fetchObject('QuantidadeFuncionarioVO');
            $this->conexao = null;
            return $quantidade;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar a quantidade de funcionários';
        }
    }
}
?>
