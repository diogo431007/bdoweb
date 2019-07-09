<?php
class VagaAdicionalVO{
    
    //atributos
    private $id_vagaadicional;
    private $id_vaga;
    private $id_adicional;

    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 20/02/2015 - 14:42
     * @param type $a Recebe o nome do atributo que será retornado.
     * @return type Retorna um atributo da classe.
     */
    public function __get($a) {
        return $this->$a;
    }
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 20/02/2015 - 14:43
     * @param type $a Recebe o nome do atributo.
     * @param type $v Recebe o valor a ser setado.
     */
    public function __set($a, $v) {
        $this->$a = $v;
    }
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 20/02/2015 - 14:43
     * @return String Retorna o nome da 
     */
    public function __toString() {
                return 'id_vagaadicional: '.$this->id_vagaadicional.'<br>'.
                'id_vaga: '.$this->id_vaga.'<br>'.                
                'id_adicional: '.$this->id_adicional;
    }
}
?>