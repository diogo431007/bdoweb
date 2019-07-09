<?php
class BeneficioVO{
    
    //atributos
    private $id_beneficio;
    private $nm_beneficio;

    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 19/02/2015 - 10:41
     * @param type $a Recebe o nome do atributo que será retornado.
     * @return type Retorna um atributo da classe.
     */
    public function __get($a) {
        return $this->$a;
    }
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 19/02/2015 - 10:41
     * @param type $a Recebe o nome do atributo.
     * @param type $v Recebe o valor a ser setado.
     */
    public function __set($a, $v) {
        $this->$a = $v;
    }
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 19/02/2015 - 10:41
     * @return String Retorna o nome da 
     */
    public function __toString() {
        return $this->nm_beneficio;
    }
}
?>