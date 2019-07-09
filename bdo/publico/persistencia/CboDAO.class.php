<?php
include_once '../modelo/CboVO.class.php';
class CboDao{
    
    private $conexao = null;
    
    public function __construct(){
        $this->conexao = Conexao::getInstancia();
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 30/09/2013 - 09:45
     * @version Banco de Oportunidades 2.0
     * 
     * @param String $query Recebe o filtro(nm_cbo) da busca.
     * @return CboVO Retorna um array de cbo.
     */
    public function buscarCbos($query){
        try{
            $stat = $this->conexao->query("select nm_cbo, id_cbo from cbo where nm_cbo like '%$query%' ");

            $array = $stat->fetchAll(PDO::FETCH_CLASS, 'CboVO');
            $this->conexao = null;
            return $array;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar cbo';
        }
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 02/10/2013 - 09:54
     * @version Banco de Oportunidades 2.0
     * 
     * @param int $id Recebe o id do cbo.
     * @return CboVO Retorna um objeto CboVO
     */
    public function buscarCboEspecifica($id){
        try{
            $stat = $this->conexao->query("select * from cbo where id_cbo = $id");

            $array = $stat->fetchAll(PDO::FETCH_CLASS,'CboVO');
            $this->conexao = null;
            return $array;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar cbo';
        }
    }
}
?>
