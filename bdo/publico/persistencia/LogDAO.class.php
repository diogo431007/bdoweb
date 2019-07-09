<?php
include_once '../modelo/LogVO.class.php';
class LogDAO{
    
    //Atributo que recebe a instância de conexão
    private $conexao = null;
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 06/11/2013 - 10:50
     */
    public function __construct(){
        $this->conexao = Conexao::getInstancia();
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 06/11/2013 - 10:52
     * 
     * @param LogVO $cf Recebe um objeto LogVO que será inserido no BD.
     */
    public function cadastrarLog($l){
        try{
                                                
            $stat = $this->conexao->prepare("INSERT INTO log (
                                                id_log,
                                                id_acesso,
                                                ao_tipo,
                                                dt_log
                                            )VALUES(
                                                null,
                                                $l->id_acesso,
                                                '$l->ao_tipo',
                                                $l->dt_log
                                            )");
            
            $stat->execute();
            $this->conexao = null;

        }catch(PDOException $e){
            return 'Erro ao cadastrar log';
        }
    }
    
}
?>
