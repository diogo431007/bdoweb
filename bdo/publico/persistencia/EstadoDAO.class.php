<?php
include_once 'Conexao.class.php';
include_once '../modelo/EstadoVO.class.php';
class EstadoDao{
    
    private $conexao = null;
    
    public function __construct(){
        $this->conexao = Conexao::getInstancia();
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 27/09/2013 - 14:25
     * @version Banco de Oportunidades 2.0
     * 
     * @param String $query Recebe a query para ordenar os estados pelo nome ou sigla.
     * @return EstadoVO Retorna um array de EstadoVO.
     */
    public function buscarEstados($query){
        try{
            $stat = $this->conexao->query("select * from estado $query");
            
            $array = $stat->fetchAll(PDO::FETCH_CLASS, 'EstadoVO');
            $this->conexao = null;
                        
            return $array;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar estados';
        }
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 21/10/2013 - 14:08
     * @version Banco de Oportunidades 2.0
     * 
     * @param int $id Recebe o id do estado
     * @return EstadoVO Retorna um EstadoVO.
     */
    public function buscarEstadoPorId($id){
        try{
            
            $stat = $this->conexao->query("select * from estado where id_estado = $id");
            
            $estado = $stat->fetchAll(PDO::FETCH_CLASS, 'EstadoVO');
            $this->conexao = null;
            return $estado[0];
            
        }catch(PDOException $e){
            echo 'Erro ao buscar estados';
        }
    }
}
?>