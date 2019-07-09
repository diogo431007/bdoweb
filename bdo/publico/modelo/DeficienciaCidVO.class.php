<?php
class DeficienciaCidVO{
    
    //atributos
    private $id_deficienciacid;
    private $nm_cid;
    private $ds_cid;
    private $id_deficiencia;
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 16/03/2015 - 16:46
     * @version Banco de Oportunidades 2.0
     * @param type $a Recebe o nome do atributo que será retornado.
     * @return type Retorna um atributo da classe.
     */
    public function __get($a) {
        return $this->$a;
    }
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 16/03/2015 - 16:47
     * @version Banco de Oportunidade 2.0
     * @param type $a Recebe o nome do atributo.
     * @param type $v Recebe o valor a ser setado.
     */
    public function __set($a, $v) {
        $this->$a = $v;
    }
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 16/03/2015 - 16:48
     * @version Banco de Talentos 2.0
     * @return String Retorna uma série de atributos da classe.
     */
    public function __toString() {
        return 'id_deficienciacid: '.$this->id_deficienciacid.'<br>'.
                'nm_cid: '.$this->nm_cid.'<br>'.
                'ds_cid: '.$this->ds_cid.'<br>'.
                'nr_cpf: '.$this->nr_cpf.'<br>'.                
                'id_deficiencia: '.$this->id_deficiencia;
    }
}
?>