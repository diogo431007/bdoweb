<?php
class HistoricoVagaVO{
    
    //atributos
    private $id_historicovaga;
    private $id_vaga;
    private $qt_vaga;
    private $ao_ativo;
    private $ao_deficiente;
    private $dt_status;

    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 27/08/2015 - 14:27
     * @param type $a Recebe o nome do atributo que será retornado.
     * @return type Retorna um atributo da classe.
     */
    public function __get($a) {
        return $this->$a;
    }
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 27/08/2015 - 14:27
     * @param type $a Recebe o nome do atributo.
     * @param type $v Recebe o valor a ser setado.
     */
    public function __set($a, $v) {
        $this->$a = $v;
    }
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 27/08/2015 - 14:27
     * @return String Retorna o nome da 
     */
    public function __toString() {
                return 'id_historicovaga: '.$this->id_historicovaga.'<br>'.
                'id_vaga: '.$this->id_vaga.'<br>'.
                'qt_vaga: '.$this->qt_vaga.'<br>'.
                'ao_ativo: '.$this->ao_ativo.'<br>'.
                'ao_deficiente: '.$this->ao_deficiente.'<br>'.
                'dt_status: '.$this->dt_status;
    }
}
?>