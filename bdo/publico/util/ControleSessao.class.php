<?php
class ControleSessao{
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 24/09/2013 - 13:14
     * 
     * Starta a sessão
     */
    public static function abrirSessao(){
        //ob_start();
        session_start();
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 24/09/2013 - 13:15
     * 
     * Destroi a sessão
     */
    public static function destruirSessao(){
        session_destroy();
    }	

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 24/09/2013 - 13:16
     * 
     * @param String $nome Recebe o nome da variável na sessão que será destruída.
     */
    public static function destruirVariavel($nome){
        unset($_SESSION[$nome]);
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 24/09/2013 - 13:17
     * 
     * @param String $nome Recebe o nome da variável na sessão a ser criada.
     * @param type $valor Recebe o valor que a variável na sessão receberá;
     */
    public static function inserirVariavel($nome, $valor){
        $_SESSION[$nome] = $valor;
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 24/09/2013 - 13:18
     * 
     * @param String $nome Recebe o nome da variável da sessão.
     * @return type Retorna o valor da variável na sassão.
     */
    public static function buscarVariavel($nome){
        return $_SESSION[$nome];
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 24/09/2013 - 13:19
     * 
     * @param String $nome Recebe o nome do objeto a ser inserida na sessão.
     * @param type $obj Recebe o objeto a ser inserido na sessão.
     */
    public static function inserirObjeto($nome, $obj){
        $_SESSION[$nome] = serialize($obj);
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 24/09/2013 - 13:20
     * 
     * @param String $obj Recebe o nome do objeto que está na sessão.
     * @return type Retorna o objeto na sessão.
     */
    public static function buscarObjeto($obj){
        return unserialize($_SESSION[$obj]);
    }
}
?>