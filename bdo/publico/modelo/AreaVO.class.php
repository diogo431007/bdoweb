<?php
class AreaVO{
    
    //atributos
    private $id_area;
    private $nm_area;
    private $ao_ativo;
    private $dt_cadastro;
    private $dt_alteracao;
    private $id_usuariocadastro;
    private $id_usuarioalteracao;
    
    private $subareas;
    
    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 20/03/2014 - 08:38
     * @version Banco de Oportunidades 2.0
     * @param type $a Recebe o nome do atributo que será retornado.
     * @return type Retorna um atributo da classe.
     */
    public function __get($a) {
        return $this->$a;
    }
    
    /**
     * @author @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 20/03/2014 - 08:38
     * @version Banco de Oportunidade 2.0
     * @param type $a Recebe o nome do atributo.
     * @param type $v Recebe o valor a ser setado.
     */
    public function __set($a, $v) {
        $this->$a = $v;
    }
    
    /**
     * @author @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 20/03/2014 - 08:38
     * @version Banco de Talentos 2.0
     * @return String Retorna uma série de atributos da classe.
     */
    public function __toString() {
        return  $this->nm_area;
    }
}
?>