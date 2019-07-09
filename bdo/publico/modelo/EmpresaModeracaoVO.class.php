<?php
class EmpresaModeracaoVO{
    
    //atributos
    private $id_empresamoderacao;
    private $id_usuario;
    private $id_empresa;
    private $ao_liberacao;
    private $dt_moderacao;
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 14/10/2013 - 14:54
     * @version Banco de Oportunidades 2.0
     * @param type $a Recebe o nome do atributo que será retornado.
     * @return type Retorna um atributo da classe.
     */
    public function __get($a) {
        return $this->$a;
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 14/10/2013 - 14:57
     * @version Banco de Oportunidade 2.0
     * @param type $a Recebe o nome do atributo.
     * @param type $v Recebe o valor a ser setado.
     */
    public function __set($a, $v) {
        $this->$a = $v;
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 14/10/2013 - 14:59
     * @version Banco de Talentos 2.0
     * @return String Retorna uma série de atributos da classe.
     */
    public function __toString() {
        return 'id_empresamoderacao: '.$this->id_empresamoderacao.'<br>'.
                'id_usuario: '.$this->id_usuario.'<br>'.
                'id_empresa: '.$this->id_empresa.'<br>'.
                'ao_liberacao: '.$this->ao_liberacao.'<br>'.
                'dt_moderacao: '.$this->dt_moderacao;
    }
}
?>