<?php
class AdmissaoVO{
    
    //atributos
    private $id_admissao;
    private $id_candidato;
    private $id_empresa;
    private $ds_cargo;
    private $dt_admissao;
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 11/11/2013 - 11:01
     * @version Banco de Oportunidades 2.0
     * @param type $a Recebe o nome do atributo que será retornado.
     * @return type Retorna um atributo da classe.
     */
    public function __get($a) {
        return $this->$a;
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 11/11/2013 - 11:04
     * @version Banco de Oportunidade 2.0
     * @param type $a Recebe o nome do atributo.
     * @param type $v Recebe o valor a ser setado.
     */
    public function __set($a, $v) {
        $this->$a = $v;
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 11/11/2013 - 11:08
     * @version Banco de Talentos 2.0
     * @return String Retorna uma série de atributos da classe.
     */
    public function __toString() {
        return 'id_admissao: '.$this->id_admissao.'<br>'.
                'id_candidato: '.$this->id_candidato.'<br>'.
                'id_empresa: '.$this->id_empresa.'<br>'.
                'ds_cargo: '.$this->ds_cargo.'<br>'.
                'dt_nascimento: '.$this->dt_admissao;
    }
}
?>