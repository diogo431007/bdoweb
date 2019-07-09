<?php
include_once 'Conexao.class.php';
include_once '../modelo/CidadeVO.class.php';
class CidadeDao{
    
    private $conexao = null;
    
    public function __construct(){
        $this->conexao = Conexao::getInstancia();
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 27/09/2013 - 14:00
     * @version Banco de Oportunidades 2.0
     * 
     * @param String $id_estado Recebe o id_estado como filtro da busca.
     * @return CidadeVO Retorna um array de CidadeVO.
     */
    public function buscarCidadesPorIdEstado($id_estado){
        try{
            $stat = $this->conexao->query("select * from cidade where id_estado = $id_estado");
            
            $cidades = $stat->fetchAll(PDO::FETCH_CLASS, 'CidadeVO');            
            $this->conexao = null;
            
            return $cidades;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar cidades';
        }
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 03/10/2013 - 11:28
     * @version Banco de Oportunidades 2.0
     * 
     * @param String $id_cidade Recebe o id_cidade como filtro da busca.
     * @return CidadeVO Retorna um array de CidadeVO.
     */
    public function buscarCidadesPorIdCidade($id_cidade){
        try{
            $stat = $this->conexao->query("select * from cidade as c where c.id_estado in (select id_estado from cidade where id_cidade = $id_cidade)");
            
            $cidades = $stat->fetchAll(PDO::FETCH_CLASS, 'CidadeVO');
            $this->conexao = null;
            return $cidades;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar cidades';
        }
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 03/10/2013 - 11:39
     * @version Banco de Oportunidades 2.0
     * 
     * @param String $id_cidade Recebe o id_cidade como filtro da busca.
     * @return int Retorna o id do estado que a cidade pertence
     */
    public function buscarIdEstado($id_cidade){
        try{
            $stat = $this->conexao->query("select id_estado from cidade where id_cidade = $id_cidade");
            
            $id = $stat->fetchAll(PDO::FETCH_COLUMN, 'id_estado');
            $this->conexao = null;
            return $id;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar cidades';
        }
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 21/10/2013 - 14:13
     * @version Banco de Oportunidades 2.0
     * 
     * @param int $id Recebe o id da cidade
     * @return CidadeVO Retorna um CidadeVO
     */
    public function buscarCidadePorId($id){
        try{
            
            $stat = $this->conexao->query("select * from cidade where id_cidade = $id");
            
            $cidade = $stat->fetchAll(PDO::FETCH_CLASS, 'CidadeVO');
            $this->conexao = null;
            return $cidade[0];
            
        }catch(PDOException $e){
            echo 'Erro ao buscar cidade';
        }
    }
}
?>