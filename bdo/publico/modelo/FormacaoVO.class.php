<?php
class FormacaoVO{
    
    //atributos
    private $id_formacao;
    private $nm_formacao;
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 23/09/2013 - 15:02
     * @version Banco de Oportunidades 2.0
     * @param type $a Recebe o nome do atributo que será retornado.
     * @return type Retorna um atributo da classe.
     */
    public function __get($a) {
        return $this->$a;
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 23/09/2013 - 15:02
     * @version Banco de Oportunidade 2.0
     * @param type $a Recebe o nome do atributo.
     * @param type $v Recebe o valor a ser setado.
     */
    public function __set($a, $v) {
        $this->$a = $v;
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 23/09/2013 - 15:03
     * @version Banco de Talentos 2.0
     * @return String Retorna uma série de atributos da classe.
     */
    public function __toString() {
        return  'Formação: '.$this->nm_formacao;
    }
}
?>