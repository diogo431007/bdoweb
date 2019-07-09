<?php
class CandidatoVO{
    
    //Atributos
    private $id_candidato;
    //private $id_cbo;
    private $id_deficiencia;
    private $id_userAlteracao;
    private $dt_alteracao;
    private $id_userInclusao;
    private $dt_cadastro;
    private $dt_validade;
    private $nm_candidato;
    private $ds_email;
    private $nr_telefone;
    private $nr_celular;
    private $ds_estado_civil;
    private $dt_nascimento;
    private $ao_sexo;
    private $ds_nacionalidade;
    private $ds_profissao;
    private $nr_cep;
    private $ds_logradouro;
    private $nr_logradouro;
    private $ds_complemento;
    private $ds_bairro;
    private $id_cidade;
    private $id_estado;
    private $ds_objetivo;
    private $nr_cpf;
    private $nr_rg;
    private $nr_ctps;
    private $nr_pis;
    private $nr_serie;
    private $id_estadoctps;
    private $ao_bolsafamilia;
    private $nr_nis;
    private $ds_cnh;
    private $ao_ativo;
    private $ao_abaformacao;
    private $ao_abaqualificacao;
    private $ao_abaexperiencia;
    
    private $ds_loginportal;
    private $pw_senhaportal;
    private $ao_interno;
    
    private $formacoes;
    private $qualificacoes;
    private $experiencias;
    private $profissoes;


    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 23/09/2013 - 14:21
     * @version Banco de Oportunidades 2.0
     * @param type $a Recebe o nome do atributo que será retornado.
     * @return type Retorna um atributo da classe.
     */
    public function __get($a) {
        return $this->$a;
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 23/09/2013 - 14:22
     * @version Banco de Oportunidade 2.0
     * @param type $a Recebe o nome do atributo.
     * @param type $v Recebe o valor a ser setado.
     */
    public function __set($a, $v) {
        $this->$a = $v;
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 25/09/2013 - 14:53
     * @version Banco de Talentos 2.0
     * @return String Retorna uma série de atributos da classe.
     */
    public function __toString() {
        return 
            '<p>id_candidato: '.$this->id_candidato.'<br>'.
            'id_deficiencia: '.$this->id_deficiencia.'<br>'.
            'id_userAlteracao: '.$this->id_userAlteracao.'<br>'.
            'dt_alteracao: '.$this->dt_alteracao.'<br>'.
            'id_userInclusao: '.$this->id_userInclusao.'<br>'.
            'dt_cadastro: '.$this->dt_cadastro.'<br>'.
            'dt_validade: '.$this->dt_validade.'<br>'.
            'nm_candidato: '.$this->nm_candidato.'<br>'.
            'ds_email: '.$this->ds_email.'<br>'.
            'nr_telefone: '.$this->nr_telefone.'<br>'.
            'nr_celular: '.$this->nr_celular.'<br>'.
            'ds_estado_civil: '.$this->ds_estado_civil.'<br>'.
            'dt_nascimento: '.$this->dt_nascimento.'<br>'.
            'ao_sexo: '.$this->ao_sexo.'<br>'.
            'ds_nacionalidade: '.$this->ds_nacionalidade.'<br>'.
            'nr_cep: '.$this->nr_cep.'<br>'.
            'ds_logradouro: '.$this->ds_logradouro.'<br>'.
            'nr_logradouro: '.$this->nr_logradouro.'<br>'.
            'ds_complemento: '.$this->ds_complemento.'<br>'.
            'ds_bairro: '.$this->ds_bairro.'<br>'.
            'id_cidade: '.$this->id_cidade.'<br>'.
            'id_estado: '.$this->id_estado.'<br>'.
            'ds_objetivo: '.$this->ds_objetivo.'<br>'.
            'nr_cpf: '.$this->nr_cpf.'<br>'.
            'nr_rg: '.$this->nr_rg.'<br>'.
            'nr_ctps: '.$this->nr_ctps.'<br>'.
            'nr_serie: '.$this->nr_serie.'<br>'.
            'id_estadoctps: '.$this->id_estadoctps.'<br>'.
            'ds_lognportal: '.$this->ds_loginportal.'<br>'.
            'pw_senhaportal: '.$this->pw_senhaportal.'<br>'.
            'ao_interno: '.$this->ao_interno.'<br>'.
            'ao_bolsafamilia: '.$this->ao_bolsafamilia.'<br>'.
            'nr_nis: '.$this->nr_nis.'<br>'.
            'formacoes: '.$this->formacoes.'<br>'.
            'qualificacoes: '.$this->qualificacoes.'<br>'.
            'experiencias: '.$this->experiencias.'</p>';
    }
}
?>
