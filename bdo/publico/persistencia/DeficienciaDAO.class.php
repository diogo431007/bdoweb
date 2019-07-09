<?php
include_once 'Conexao.class.php';
include_once '../modelo/DeficienciaVO.class.php';
class DeficienciaDao{
    
    private $conexao = null;
    
    public function __construct(){
        $this->conexao = Conexao::getInstancia();
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 30/09/2013 - 10:10
     * @version Banco de Oportunidades 2.0
     * 
     * @return DeficienciaVO Retorna um array de todas as deficiencias.
     */
    public function buscarDeficiencias(){
        try{
            $stat = $this->conexao->query("select * from deficiencia");

            $array = $stat->fetchAll(PDO::FETCH_CLASS, 'DeficienciaVO');
            $this->conexao = null;
            return $array;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar deficiencias';
        }
    }
    
    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 16/09/2014 - 11:01
     * 
     * @return DeficienciaVO Retorna um array de todas as deficiencias.
     */
    public function buscarDeficienciaPorId($id){
        try{
            $stat = $this->conexao->query("select * from deficiencia where id_deficiencia = $id");

            $deficiencia = $stat->fetchAll(PDO::FETCH_CLASS, 'DeficienciaVO');
            $this->conexao = null;
            return $deficiencia[0];
            
        }catch(PDOException $e){
            echo 'Erro ao buscar deficiencia';
        }
    }
}
?>