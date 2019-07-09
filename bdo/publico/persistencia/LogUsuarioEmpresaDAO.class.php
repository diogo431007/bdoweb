<?php
include_once '../modelo/LogUsuarioEmpresaVO.class.php';
class LogUsuarioEmpresaDAO{
    
    private $conexao = null;
    
    public function __construct(){
        $this->conexao = Conexao::getInstancia();
    }     
   
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 09/04/2015 - 14:06
     * @version Banco de Oportunidades 2.0
     * 
     * @return array Retorna um array de Log Usuário Empresa.
    */
    public function buscarLogsUsuarioEmpresa(){
        try{
            
            $stat = $this->conexao->query("select * from logusuarioempresa");

            $array = $stat->fetchAll(PDO::FETCH_CLASS, 'LogUsuarioEmpresaVO');
            $this->conexao = null;
            return $array;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar log usuário empresa';
        }
    }
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 09/04/2015 - 14:08
     * @version Banco de Oportunidades 2.0
     * 
     * @param int $id Recebe o id do log usuário empresa
     * @return LogUsuarioEmpresaVO Retorna um objeto LogUsuarioEmpresaVO
    */
    public function buscarLogUsuarioEmpresaPorId($id){
        try{
            $stat = $this->conexao->query("select * from logusuarioempresa where id_logusuarioempresa = $id");
            
            $adicional = $stat->fetchObject('LogUsuarioEmpresaVO');
            $this->conexao = null;
            return $adicional;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar log usuário empresa';
        }
    }
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 09/04/2015 - 14:11
     * 
     * @param LogUsuarioEmpresaVO $e Recebe um objeto LogUsuarioEmpresaVO que será inserido no BD.
     * @return int Retorna o id gerado na insercao
    */
    public function cadastrarLogUsuarioEmpresa($lue){
        try{
            
            $stat = $this->conexao->prepare("insert into logusuarioempresa(
                                                    id_logusuarioempresa, 
                                                    id_usuario,
                                                    id_empresa,
                                                    dt_logusuarioempresa
                                             )
                                             values(
                                                    null,
                                                    $lue->id_usuario,
                                                    $lue->id_empresa,    
                                                    now()
                                                    )");
            
            $stat->execute();
            
            $idGerado = $this->conexao->lastInsertId();
            $this->conexao = null;
            return $idGerado;
            
        }catch(PDOException $e){
            return false;
        }
    }
    
}
?>
