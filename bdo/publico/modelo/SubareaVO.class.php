<?php
class SubareaVO{
    
    //atributos
    private $id_subarea;
    private $nm_subarea;
    private $id_area;
    private $ao_ativo;
    private $dt_cadastro;
    private $dt_alteracao;
    private $id_usuariocadastro;
    private $id_usuarioalteracao;
     
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 23/09/2013 - 14:52
     * @version Banco de Oportunidades 2.0
     * @param type $a Recebe o nome do atributo que ser� retornado.
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
     * @return String Retorna uma s�rie de atributos da classe.
     */
    public function __toString() {
        return $this->nm_subarea;
    }
}
?>