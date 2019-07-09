<?php
class VagaCandidatoVO{
    
    //atributos
    private $id_vagacandidato;
    private $id_candidato;
    private $id_motivo;
    private $id_vaga;
    private $ao_status;
    private $dt_status;    
    private $nm_candidato;
    private $nr_telefone;
    private $nr_celular;
    private $ds_email;
    private $id_deficiencia;
    private $ao_sexo;

    private $candidato;


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
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 16/09/2014 - 13:40
     * 
     * @param string $transacao Recebe a descrição da transação realizada
     * @param string $id_candidato Recebe o id do candidato que a vaga pertence
     * @return string Retorna a descrição do log
     */
//    public function montarLogVagaCandidato($transacao, $id_candidato){
//        $log = $transacao.'#';
//        $log .= 'Candidato: '. $id_candidato .'#';
//        $log .= 'Vaga: '. $this->id_vaga .'#';
//        $log .= 'Motivo: '. Servicos::buscarMotivoPorId($this->id_motivo)->ds_motivo .'#';
//        $log .= 'Status candidato: '. $this->ao_status .'#';
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