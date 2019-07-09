<?php
class CidadeVO{
    
    //atributos
    private $id_cidade;
    private $nm_cidade;
    private $id_estado;
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 23/09/2013 - 14:52
     * @version Banco de Oportunidades 2.0
     * @param type $a Recebe o nome do atributo que será retornado.
     * @return type Retorna um atributo da classe.
     */
    public function __get($a) {
        return $this->$a;
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 23/09/2013 - 14:53
     * @version Banco de Oportunidade 2.0
     * @param type $a Recebe o nome do atributo.
     * @param type $v Recebe o valor a ser setado.
     */
    public function __set($a, $v) {
        $this->$a = $v;
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 23/09/2013 - 14:54
     * @version Banco de Talentos 2.0
     * @return String Retorna uma série de atributos da classe.
     */
    public function __toString() {
        return  'Cidade: '.$this->nm_cbo;
    }
}
?>