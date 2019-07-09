<?php
class EmpresaDetalheVO{
    
    //atributos
    private $id_empresadetalhe;
    private $nm_proprietario;
    private $ds_cargo;
    private $nr_cpf;
    private $dt_nascimento;
    private $nr_celular;
    private $ds_emailproprietario;
    private $id_empresa;
    private $ao_status;
    private $ao_recrutador;


    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 14/10/2013 - 14:46
     * @version Banco de Oportunidades 2.0
     * @param type $a Recebe o nome do atributo que será retornado.
     * @return type Retorna um atributo da classe.
     */
    public function __get($a) {
        return $this->$a;
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 14/10/2013 - 14:48
     * @version Banco de Oportunidade 2.0
     * @param type $a Recebe o nome do atributo.
     * @param type $v Recebe o valor a ser setado.
     */
    public function __set($a, $v) {
        $this->$a = $v;
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 14/10/2013 - 14:50
     * @version Banco de Talentos 2.0
     * @return String Retorna uma série de atributos da classe.
     */
    public function __toString() {
        return 'id_empresadetalhe: '.$this->id_empresadetalhe.'<br>'.
                'nm_proprietario: '.$this->nm_proprietario.'<br>'.
                'ds_cargo: '.$this->ds_cargo.'<br>'.
                'nr_cpf: '.$this->nr_cpf.'<br>'.
                'dt_nascimento: '.$this->dt_nascimento.'<br>'.
                'nr_celular: '.$this->nr_celular.'<br>'.
                'ds_emailproprietario: '.$this->ds_emailproprietario.'<br>'.
                'ao_status: '.$this->ao_status.'<br>'.
                'id_empresa: '.$this->id_empresa;
    }
}
?>