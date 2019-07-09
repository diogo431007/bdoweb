<?php
include_once '../modelo/HistoricoVagaVO.class.php';
class HistoricoVagaDAO{
    
    private $conexao = null;
    
    public function __construct(){
        $this->conexao = Conexao::getInstancia();
    }
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 27/08/2015 - 14:30     
     * @param HistoricoVagaVO $p Recebe um objeto HistoricoVagaVO que será inserido no BD.
     * @return int Retorna id gerado
    */
    public function cadastrarHistoricoVaga($a){
        try{            
            $stat = $this->conexao->prepare("insert into historicovaga(
                                                id_historicovaga, 
                                                id_vaga,                                                 
                                                qt_vaga,
                                                ao_ativo,
                                                ao_deficiente,
                                                dt_status
                                             )
                                             values(
                                                    null,
                                                    '$a->id_vaga',
                                                    '$a->qt_vaga',
                                                    '$a->ao_ativo',
                                                    '$a->ao_deficiente',
                                                    now()
                                            )");
            
            $stat->execute();
            $this->conexao = null;
            
        }catch(PDOException $e){
            return false;
        }
    }
}
?>
