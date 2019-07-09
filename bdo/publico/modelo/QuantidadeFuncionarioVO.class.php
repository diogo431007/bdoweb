<?php
class QuantidadeFuncionarioVO{
    
    //atributos
    private $id_quantidadefuncionario;
    private $nm_quantidadefuncionario;
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 30/01/2015 - 11:01
     * @version Banco de Oportunidades 2.0
     * @param type $a Recebe o nome do atributo que ser� retornado.
     * @return type Retorna um atributo da classe.
     */
    public function __get($a) {
        return $this->$a;
    }
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 30/01/2015 - 11:02
     * @version Banco de Oportunidade 2.0
     * @param type $a Recebe o nome do atributo.
     * @param type $v Recebe o valor a ser setado.
     */
    public function __set($a, $v) {
        $this->$a = $v;
    }
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 30/01/2015 - 11:03
     * @version Banco de Talentos 2.0
     * @return String Retorna uma s�rie de atributos da classe.
     */
    public function __toString() {
        return  $this->nm_quantidadefuncionario;
    }
}
?>