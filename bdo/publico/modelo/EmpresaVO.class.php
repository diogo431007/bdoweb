<?php
class EmpresaVO{
    
    //atributos
    private $id_empresa;
    private $nm_razaosocial;
    private $nm_fantasia;
    private $nr_cnpj;
    private $nm_contato;
    private $nr_telefoneempresa;
    private $nr_cep;
    private $ds_logradouro;
    private $nr_logradouro;
    private $ds_bairro;
    private $ds_complemento;
    private $id_cidade;
    private $ds_email;
    private $ds_site;
    private $nr_inscricaoestadual;
    private $nr_inscricaomunicipal;
    private $dt_fundacao;
    private $ao_liberacao;
    private $pw_senhaportal;
    private $ao_interno;
    private $id_ramoatividade;
    private $id_quantidadefuncionario;
    private $dt_cadastro;
    
    private $nm_proprietario;
    private $ds_cargo;
    private $nr_cpf;
    private $dt_nascimento;
    private $nr_celular;
    private $ds_emailproprietario;
    private $ao_status;
    private $ao_recrutador;
    private $id_microregiao;
    private $id_poligono;

    private $empresa_moderacoes;
    private $empresa_admissoes;
    private $empresa_vagas;
    
//    private $empresa_microregioes;
//    private $empresa_poligonos;
    


    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 14/10/2013 - 14:39
     * @version Banco de Oportunidades 2.0
     * @param type $a Recebe o nome do atributo que será retornado.
     * @return type Retorna um atributo da classe.
     */
    public function __get($a) {
        return $this->$a;
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 14/10/2013 - 14:41
     * @version Banco de Oportunidade 2.0
     * @param type $a Recebe o nome do atributo.
     * @param type $v Recebe o valor a ser setado.
     */
    public function __set($a, $v) {
        $this->$a = $v;
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 14/10/2013 - 14:43
     * @version Banco de Talentos 2.0
     * @return String Retorna uma série de atributos da classe.
     */
    public function __toString() {
        return 'id_empresa: '.$this->id_empresa.'<br>'.
                'nm_razaosocial: '.$this->nm_razaosocial.'<br>'.
                'nm_fantasia: '.$this->nm_fantasia.'<br>'.
                'nr_cnpj: '.$this->nr_cnpj.'<br>'.
                'nm_ramoatividade: '.$this->nm_ramoatividade.'<br>'.
                'nm_quantidadefuncionario: '.$this->nm_quantidadefuncionario.'<br>'.
                'nm_contato: '.$this->nm_contato.'<br>'.
                'nr_telefoneempresa: '.$this->nr_telefoneempresa.'<br>'.
                'nr_cep: '.$this->nr_cep.'<br>'.
                'ds_logradouro: '.$this->ds_logradouro.'<br>'.
                'nr_logradouro: '.$this->nr_logradouro.'<br>'.
                'ds_bairro: '.$this->ds_bairro.'<br>'.
                'ds_complemento: '.$this->ds_complemento.'<br>'.
                'id_cidade: '.$this->id_cidade.'<br>'.
                'ds_email: '.$this->ds_email.'<br>'.
                'ds_site: '.$this->ds_site.'<br>'.
                'nr_inscricaoestadual: '.$this->nr_inscricaoestadual.'<br>'.
                'nr_inscricaomunicipal: '.$this->nr_inscricaomunicipal.'<br>'.
                'dt_fundacao: '.$this->dt_fundacao.'<br>'.
                'ao_liberacao: '.$this->ao_liberacao.'<br>'.
                'pw_senhaportal: '.$this->pw_senhaportal.'<br>'.
                'ao_interno: '.$this->ao_interno.'<br>'.                
                'dt_cadastro: '.$this->dt_cadastro.'<br>'.
                'nm_proprietario: '.$this->nm_proprietario.'<br>'.
                'ds_cargo: '.$this->ds_cargo.'<br>'.
                'nr_cpf: '.$this->nr_cpf.'<br>'.
                'dt_nascimento: '.$this->dt_nascimento.'<br>'.
                'nr_celular: '.$this->nr_celular.'<br>'.
                'ds_emailproprietario: '.$this->ds_emailproprietario.'<br>'.
                'ao_status: '.$this->ao_status.'<br>'.
                'ao_recrutador: '.$this->ao_recrutador.'<br>'.       
                
                'empresa_moderacoes: '.$this->empresa_moderacoes.'<br>'.
                'empresa_admissoes: '.$this->empresa_admissoes.'<br>'.
                'empresa_vagas: '.$this->empresa_vagas.'<br>';
//                'empresa_microregioes: '.$this->empresa_microregioes.'<br>'.
//                'empresa_poligonos: '.$this->empresa_poligonos.'<br>';
    }
}
?>