<?php
class CandidatoExperienciaVO{
    
    //atributos
    private $id_experiencia;
    private $id_userAlteracao;
    private $id_userInclusao;
    private $id_candidato;
    private $dt_inicio;
    private $dt_termino;
    private $nm_empresa;
    private $ds_atividades;
    private $dt_inclusao;
    private $dt_alteracao;
    private $ao_experiencia;
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 23/09/2013 - 14:35
     * @version Banco de Oportunidades 2.0
     * @param type $a Recebe o nome do atributo que será retornado.
     * @return type Retorna um atributo da classe.
     */
    public function __get($a) {
        return $this->$a;
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 23/09/2013 - 14:37
     * @version Banco de Oportunidade 2.0
     * @param type $a Recebe o nome do atributo.
     * @param type $v Recebe o valor a ser setado.
     */
    public function __set($a, $v) {
        $this->$a = $v;
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 23/09/2013 - 14:39
     * @version Banco de Talentos 2.0
     * @return String Retorna uma série de atributos da classe.
     */
    public function __toString() {
        return  'Data Início: '.$this->dt_inicio.'<br>Data Término: '.
                $this->dt_termino.'<br>Empresa: '.
                $this->nm_empresa.'<br>Candidato: '.
                $this->id_candidato.'<br>Atividades: '.
                $this->ds_atividades;
    }
}
?>