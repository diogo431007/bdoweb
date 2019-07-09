<?php
class LogVO{
    //atributos
    private $id_log;
    private $id_acesso;
    private $ao_tipo;
    private $dt_log;
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 06/11/2013 - 11:00
     * @version Banco de Oportunidades 2.0
     * 
     * @param string $a Recebe o nome do atributo que será retornado.
     * @return type Retorna um atributo da classe.
     */
    public function __get($a) {
        return $this->$a;
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 06/11/2013 - 11:04
     * @version Banco de Oportunidades 2.0
     * 
     * @param string $a Recebe o nome do atributo.
     * @param type $v Recebe o valor a ser setado.
     */
    public function __set($a, $v) {
        $this->$a = $v;
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 06/11/2013 - 11:10
     * @version Banco de Oportunidades 2.0
     * 
     * @return String Retorna uma série de atributos da classe.
     */
    public function __toString() {
        return  'Log: ' . $this->id_log .' - '. $this->ao_tipo .' - '. $this->id_acesso .' - '. $this->dt_log .';';
    }
}
?>
