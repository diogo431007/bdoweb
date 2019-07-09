<?php
class RamoAtividadeVO{
    
    //atributos
    private $id_ramoatividade;
    private $nm_ramoatividade;
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 04/11/2013 - 10:51
     * @version Banco de Oportunidades 2.0
     * @param type $a Recebe o nome do atributo que será retornado.
     * @return type Retorna um atributo da classe.
     */
    public function __get($a) {
        return $this->$a;
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 04/11/2013 - 10:53
     * @version Banco de Oportunidade 2.0
     * @param type $a Recebe o nome do atributo.
     * @param type $v Recebe o valor a ser setado.
     */
    public function __set($a, $v) {
        $this->$a = $v;
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 04/11/2013 - 10:55
     * @version Banco de Talentos 2.0
     * @return String Retorna uma série de atributos da classe.
     */
    public function __toString() {
        return  $this->nm_ramoatividade;
    }
}
?>