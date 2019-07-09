<?php
include_once '../util/Validacao.class.php';
class CandidatoFormacaoVO{
    
    //atributos
    private $id_candidato_formacao;
    private $id_candidato;
    private $id_formacao;
    private $id_userAlteracao;
    private $id_userInclusao;
    private $dt_termino;
    private $nm_escola;
    private $ds_cidadeescola;
    private $dt_inclusao;
    private $dt_alteracao;
    private $ds_curso;
    private $ds_semestre;
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 23/09/2013 - 14:42
     * @version Banco de Oportunidades 2.0
     * @param type $a Recebe o nome do atributo que será retornado.
     * @return type Retorna um atributo da classe.
     */
    public function __get($a) {
        return $this->$a;
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 23/09/2013 - 14:44
     * @version Banco de Oportunidade 2.0
     * @param type $a Recebe o nome do atributo.
     * @param type $v Recebe o valor a ser setado.
     */
    public function __set($a, $v) {
        $this->$a = $v;
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 23/09/2013 - 14:46
     * @version Banco de Talentos 2.0
     * @return String Retorna uma série de atributos da classe.
     */
    public function __toString() {
        //id+'-'+dt+'-'+esc+'-'+cid+';'
        return $this->id_formacao . '<br>' .
                $this->dt_termino . '<br>' .
                $this->nm_escola . '<br>' .
                $this->ds_cidadeescola . '<br>' .
                $this->ds_curso . '<br>' .
                $this->ds_semestre;
    }
}
?>