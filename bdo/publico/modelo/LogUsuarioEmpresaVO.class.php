<?php
class LogUsuarioEmpresaVO{
    
    //atributos
    private $id_logusuarioempresa;
    private $id_usuario;
    private $id_empresa;
    private $dt_logusuarioempresa;

    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 09/04/2015 - 14:00
     * @param type $a Recebe o nome do atributo que será retornado.
     * @return type Retorna um atributo da classe.
     */
    public function __get($a) {
        return $this->$a;
    }
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 09/04/2015 - 14:00
     * @param type $a Recebe o nome do atributo.
     * @param type $v Recebe o valor a ser setado.
     */
    public function __set($a, $v) {
        $this->$a = $v;
    }
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 09/04/2015 - 14:00
     * @return String Retorna o nome da 
     */
    public function __toString() {
        return $this->dt_logusuarioempresa;
        
    }
}
?>