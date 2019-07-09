<?php
class EmpresaTipoVO{
    
    //atributos
    private $id_empresatipo;
    private $nm_empresatipo;
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 18/02/2015 - 15:28
     * @version Banco de Oportunidades 2.0
     * @param type $a Recebe o nome do atributo que será retornado.
     * @return type Retorna um atributo da classe.
     */
    public function __get($a) {
        return $this->$a;
    }
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 18/02/2015 - 15:28
     * @version Banco de Oportunidade 2.0
     * @param type $a Recebe o nome do atributo.
     * @param type $v Recebe o valor a ser setado.
     */
    public function __set($a, $v) {
        $this->$a = $v;
    }
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 18/02/2015 - 15:29
     * @version Banco de Talentos 2.0
     * @return String Retorna uma série de atributos da classe.
     */
    public function __toString() {
        return  $this->nm_empresatipo;
    }
}
?>