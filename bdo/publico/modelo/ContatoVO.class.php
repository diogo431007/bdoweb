<?php
class ContatoVO{
    
    //atributos
    private $id_contato;
    private $nm_contato;
    private $ds_email;
    private $nr_telefone;
    private $ds_assunto;
    private $ds_mensagem;
    private $dt_cadastro;


    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 29/10/2013 - 14:10
     * @version Banco de Oportunidades 2.0
     * 
     * @param type $a Recebe o nome do atributo que será retornado.
     * @return type Retorna um atributo da classe.
     */
    public function __get($a) {
        return $this->$a;
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 29/10/2013 - 14:13
     * @version Banco de Oportunidade 2.0
     * 
     * @param type $a Recebe o nome do atributo.
     * @param type $v Recebe o valor a ser setado.
     */
    public function __set($a, $v) {
        $this->$a = $v;
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 23/09/2013 - 14:15
     * @version Banco de Talentos 2.0
     * 
     * @return String Retorna uma série de atributos da classe.
     */
    public function __toString() {
        return  '<p>
                    Código: '.$this->id_contato.'<br>'.
                    'Nome: '.$this->nm_contato.'<br>'.
                    'E-mail: '.$this->ds_email.'<br>'.
                    'Telefone: '.$this->nr_telefone.'<br>'.
                    'Assunto: '.$this->ds_assunto.'<br>'.
                    'Mensagem: '.nl2br($this->ds_mensagem).
                '</p>';
    }
    
}
?>
