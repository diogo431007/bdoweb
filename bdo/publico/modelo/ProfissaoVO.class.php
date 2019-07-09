<?php
class ProfissaoVO{
    
    //atributos
    private $id_profissao;
    private $nm_profissao;
    private $ds_profissao;
    private $ao_ativo;
    
    private $dt_inclusao;
    private $id_usuarioinclusao;
    private $id_usuarioalteracao;
    private $dt_alteracao;


    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 31/03/2014 - 11:48
     * @param type $a Recebe o nome do atributo que será retornado.
     * @return type Retorna um atributo da classe.
     */
    public function __get($a) {
        return $this->$a;
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 31/03/2014 - 11:49
     * @param type $a Recebe o nome do atributo.
     * @param type $v Recebe o valor a ser setado.
     */
    public function __set($a, $v) {
        $this->$a = $v;
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 31/03/2014 - 11:49
     * @return String Retorna o nome da 
     */
    public function __toString() {
        return $this->nm_profissao;
        
    }
}
?>