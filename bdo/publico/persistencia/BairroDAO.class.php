<?php
include_once 'Conexao.class.php';
include_once '../modelo/BairroVO.class.php';
class BairroDAO{
    
    private $conexao = null;
    
    public function __construct(){
        $this->conexao = Conexao::getInstancia();
    }
    
    /**
     * @author Giuseppe Menti <giuseppe.menti@canoastec.rs.gov.br>
     * @since 04/05/2013 - 14:00
     * @version Banco de Oportunidades 1.1
     * 
     * @param String $id_cidade Recebe o id_cidade como filtro da busca.
     * @return BairroVO Retorna um array de BairroVO.
     */
    public function buscarBairrosPorIdCidade($id_cidade){
        try{
            $stat = $this->conexao->query("select * from bairro where id_cidade = '$id_cidade'");
            
            $bairros = $stat->fetchAll(PDO::FETCH_CLASS, 'BairroVO');
            $this->conexao = null;
            return $bairros;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar bairros';
        }
    }
    
        /**
     * @author Giuseppe Menti <giuseppe.menti@canoastec.rs.gov.br>
     * @since 04/05/2013 - 11:28
     * @version Banco de Oportunidades 1.1
     * 
     * @param String $id_bairro Recebe o id_bairro como filtro da busca.
     * @return BairroVO Retorna um array de BairroVO.
     */
    public function buscarBairrosPorIdBairro($id_bairro){
        try{
            $stat = $this->conexao->query("select * from bairro as b where b.id_bairro in (select id_bairro from bairro where id_bairro = $id_bairro)");
            
            $bairros = $stat->fetchAll(PDO::FETCH_CLASS, 'BairroVO');
            $this->conexao = null;
            return $bairros;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar bairros';
        }
    }
        
}
?>