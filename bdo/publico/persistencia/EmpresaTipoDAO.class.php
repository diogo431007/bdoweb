<?php
include_once '../modelo/EmpresaTipoVO.class.php';
class EmpresaTipoDAO{
    
    private $conexao = null;
    
    public function __construct(){
        $this->conexao = Conexao::getInstancia();
    }
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 18/02/2015 - 15:30
     * @version Banco de Oportunidades 2.0
     * 
     * @return array Retorna um array de ramos atividade.
     */
    public function buscar(){
        try{
            
            $stat = $this->conexao->query("select * from empresatipo");

            $array = $stat->fetchAll(PDO::FETCH_CLASS, 'EmpresaTipoVO');
            $this->conexao = null;
            return $array;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar a tipo de empresa';
        }
    }
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 18/02/2015 - 15:31
     * @version Banco de Oportunidades 2.0
     * 
     * @param int $id Recebe o id do tipo de empresa
     * @return EmpresaTipoVO Retorna um objeto EmpresaTipoVO
     */
    public function buscarEmpresaTipoPorId($id){
        try{
            $stat = $this->conexao->query("select * from empresatipo where id_empresatipo = $id");
            
            $empresatipo = $stat->fetchObject('EmpresaTipoVO');
            $this->conexao = null;
            return $empresatipo;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar o tipo de empresa';
        }
    }
}
?>
