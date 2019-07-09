<?php
class CandidatoQualificacaoVO{
    
    //atributos
    private $id_qualificacao;
    private $id_candidato;
    private $id_userAlteracao;
    private $id_userInclusao;
    private $ds_qualificacao;
    private $dt_termino;
    private $qtd_horas;
    private $nm_instituicao;
    private $dt_inclusao;
    private $dt_alteracao;
    private $ao_pronatec;
    private $ao_qualificacao;
    
    
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 23/09/2013 - 14:47
     * @version Banco de Oportunidades 2.0
     * @param type $a Recebe o nome do atributo que será retornado.
     * @return type Retorna um atributo da classe.
     */
    public function __get($a) {
        return $this->$a;
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 23/09/2013 - 14:48
     * @version Banco de Oportunidade 2.0
     * @param type $a Recebe o nome do atributo.
     * @param type $v Recebe o valor a ser setado.
     */
    public function __set($a, $v) {
        $this->$a = $v;
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 23/09/2013 - 14:49
     * @version Banco de Talentos 2.0
     * @return String Retorna uma série de atributos da classe.
     */
    public function __toString() {
        return  $this->ds_qualificacao. '-' .
                $this->nm_instituicao. '-' .
                $this->dt_termino. '-' .
                $this->qtd_horas. ';';
    }
}
?>