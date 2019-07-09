<?php
class VagaBeneficioVO{
    
    //atributos
    private $id_vagabeneficio;
    private $id_vaga;
    private $id_beneficio;

    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 23/02/2015 - 09:23
     * @param type $a Recebe o nome do atributo que será retornado.
     * @return type Retorna um atributo da classe.
     */
    public function __get($a) {
        return $this->$a;
    }
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 23/02/2015 - 09:23
     * @param type $a Recebe o nome do atributo.
     * @param type $v Recebe o valor a ser setado.
     */
    public function __set($a, $v) {
        $this->$a = $v;
    }
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 23/02/2015 - 09:23
     * @return String Retorna o nome da 
     */
    public function __toString() {
                return 'id_vagabeneficio: '.$this->id_vagabeneficio.'<br>'.
                'id_vaga: '.$this->id_vaga.'<br>'.                
                'id_beneficio: '.$this->id_beneficio;
    }
}
?>