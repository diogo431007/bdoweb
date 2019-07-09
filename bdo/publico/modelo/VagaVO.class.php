<?php
class VagaVO{
    //atributos
    private $id_vaga;
    private $id_empresa;
    private $id_profissao;
    private $ds_atribuicao;
    private $nr_salario;
    private $ds_adicional;
    private $ds_beneficio;
    private $ds_observacao;
    private $qt_vaga;
    private $ao_ativo;
    private $ao_exibeemail;
    private $ao_exibenome;
    private $ao_exibetelefone;
    private $ao_sexo;
    private $dt_cadastro;    
    private $ao_deficiente;    
    private $profissao;
    private $ds_estado_civil;
    private $ds_idade;
    private $ao_experiencia;
    private $ds_cnh;
    
    /**
     * @author Ricardo K.Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 31/03/2014 - 11:08
     * @version Banco de Oportunidades 2.0
     * @param type $a Recebe o nome do atributo que será retornado.
     * @return type Retorna um atributo da classe.
     */
    public function __get($a) {
        return $this->$a;
    }
    
    /**
     * @author Ricardo K.Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 31/03/2014 - 11:08
     * @version Banco de Oportunidade 2.0
     * @param type $a Recebe o nome do atributo.
     * @param type $v Recebe o valor a ser setado.
     */
    public function __set($a, $v) {
        $this->$a = $v;
    }
    
    
    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 16/09/2014 - 12:41
     * 
     * @param string $transacao Recebe a descrição da transação realizada
     * @param string $id_empresa Recebe o id da empresa que a vaga pertence
     * @param string $id_profissao Recebe o id da profissao da vaga
     * @return string Retorna a descrição do log
     */
//    public function montarLogVaga($transacao, $id_empresa, $id_profissao){
//        $log = $transacao.'#';
//        $log .= 'Empresa: '. $id_empresa .'#';
//        $log .= 'Profissão: '. Servicos::buscarProfissaoPorId($this->id_profissao)->nm_profissao .'#';
//        $log .= 'Atribuição: '. $this->ds_atribuicao .'#';
//        $log .= 'Gênero: '. Servicos::verificarGenero($this->ao_sexo) .'#';
//        $log .= 'Salário: '. Validacao::converterMoedaPhp($this->nr_salario) .'#';
//        $log .= 'Adicional: '. $this->ds_adicional .'#';
//        $log .= 'Benefício: '. $this->ds_beneficio .'#';
//        $log .= 'Observação: '. $this->ds_observacao .'#';
//        $log .= 'Qtd. vagas: '. $this->qt_vaga .'#';
//        $log .= 'Status: '. $this->ao_ativo .'#';
//        $log .= 'Exibe empresa: '. $this->ao_exibenome .'#';
//        $log .= 'Exibe fone: '. $this->ao_exibetelefone .'#';
//        $log .= 'Exibe email: '. $this->ao_exibeemail .'#';        
//        
//        return $log;
//    }
}
?>
