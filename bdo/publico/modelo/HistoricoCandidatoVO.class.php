<?php
include_once '../persistencia/HistoricoCandidatoDAO.class.php';
class HistoricoCandidatoVO{
    //Atributos
    private $id_historico;
    private $id_vagacandidato;
    private $id_usuario;
    private $id_motivo;
    private $ds_motivodispensa;
    private $ao_status;
    private $dt_cadastro;
    
    /**
     * 
     * @param String $a Recebe o nome do atributo que será retornado.
     * @return type Retorna um atributo da classe.
     */
    public function __get($a) {
        return $this->$a;
    }
    
    /**
     * 
     * @param String $a Recebe o nome do atributo.
     * @param type $v Recebe o valor a ser setado.
     */
    public function __set($a, $v) {
        $this->$a = $v;
    }
    
    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 16/09/2014 - 10:03
     * 
     * @param int $id_usuario Recebe o id do usuario logado
     * @param string $ds_ocorrenciausuario Recebe a sql executada
     * @param string $nm_tabela Recebe o nome da tabela
     * @param int $id_tabela Recebe o id da tabela
     */
    public function salvarHistorico($id_vagacandidato, $id_motivo, $ds_motivodispensa, $ao_status){
        
        $this->id_vagacandidato = $id_vagacandidato;
        $this->id_motivo = $id_motivo;
        $this->ds_motivodispensa = $ds_motivodispensa;
        $this->ao_status = $ao_status;
        
        $hcDAO = new HistoricoCandidatoDAO();
        $hcDAO->cadastrarHistoricoCandidato($this);
        
    }
    
    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 16/09/2014 - 10:26
     * 
     * @param string $historico Recebe a descrição do historico
     * @return string Retorna a transação realizada
     */
    public function retornarTransação(){
        $historico = explode('#', $this->ds_motivodispensa);
        return $historico[0];
    }
    
    
}
?>
