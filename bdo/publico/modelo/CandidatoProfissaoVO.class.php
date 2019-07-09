<?php
class CandidatoProfissaoVO{
    
    //atributos
    private $id_candidatoprofissao;
    private $id_candidato;
    private $id_profissao;
    
    private $profissao;


    /**
     * @author Douglas Carlos <douglas.carlos@canoastec.rs.gov.br>
     * @since 31/03/2014 - 14:20
     * @param type $a Recebe o nome do atributo que será retornado.
     * @return type Retorna um atributo da classe.
     */
    public function __get($a) {
        return $this->$a;
    }
    
    /**
     * @author Douglas Carlos <douglas.carlos@canoastec.rs.gov.br>
     * @since 31/03/2014 - 14:21
     * @param type $a Recebe o nome do atributo.
     * @param type $v Recebe o valor a ser setado.
     */
    public function __set($a, $v) {
        $this->$a = $v;
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 31/03/2014 - 14:24
     * @return String Retorna o nome da profissao
     */
    public function __toString() {
        return $this->profissao;
    }
}
?>