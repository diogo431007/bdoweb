<?php
class VagaFormacaoVO{
    
    //atributos
    private $id_vagaformacao;
    private $id_vaga;
    private $id_formacao;

    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 24/03/2015 - 10:30
     * @param type $a Recebe o nome do atributo que será retornado.
     * @return type Retorna um atributo da classe.
     */
    public function __get($a) {
        return $this->$a;
    }
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 24/03/2015 - 10:30
     * @param type $a Recebe o nome do atributo.
     * @param type $v Recebe o valor a ser setado.
     */
    public function __set($a, $v) {
        $this->$a = $v;
    }
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 24/03/2015 - 10:30
     * @return String Retorna o nome da 
     */
    public function __toString() {
                return 'id_vagaformacao: '.$this->id_vagaformacao.'<br>'.
                'id_vaga: '.$this->id_vaga.'<br>'.                
                'id_formacao: '.$this->id_formacao;
    }
}
?>