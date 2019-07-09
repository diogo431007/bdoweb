<?php
include_once 'Conexao.class.php';
include_once '../modelo/MotivoVO.class.php';
class MotivoDao{
    
    private $conexao = null;
    
    public function __construct(){
        $this->conexao = Conexao::getInstancia();
    }
    
    /**
     * @author Felipe Stroff <felipe.stroff@canoastec.rs.gov.br>
     * @author Ricardo Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 15/09/2014 - 10:37
     * @version Banco de Oportunidades 
     * 
     * @param String $id_motivo Recebe o id_motivo como filtro da busca.
     * @return MotivoVO Retorna um array de MotivoVO.
     */
    public function buscarMotivos(){
        try{
            $stat = $this->conexao->query("select * from motivodispensa");
            
            $motivos = $stat->fetchAll(PDO::FETCH_CLASS, 'MotivoVO');
            $this->conexao = null;
            return $motivos;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar motivo de dispensa';
        }
    }
    
    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 16/09/2014 - 13:49
     * 
     * @return MotivoVO Retorna um array de todos os motivos.
     */
    public function buscarMotivoPorId($id){
        try{
            $stat = $this->conexao->query("select * from motivodispensa where id_motivo = $id");

            $motivo = $stat->fetchAll(PDO::FETCH_CLASS, 'MotivoVO');
            $this->conexao = null;
            return $motivo[0];
            
        }catch(PDOException $e){
            echo 'Erro ao buscar motivo';
        }
    }
    
}
?>