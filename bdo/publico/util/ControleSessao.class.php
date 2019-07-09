<?php
class ControleSessao{
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 24/09/2013 - 13:14
     * 
     * Starta a sess�o
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
     * Destroi a sess�o
     */
    public static function destruirSessao(){
        session_destroy();
    }	

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 24/09/2013 - 13:16
     * 
     * @param String $nome Recebe o nome da vari�vel na sess�o que ser� destru�da.
     */
    public static function destruirVariavel($nome){
        unset($_SESSION[$nome]);
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 24/09/2013 - 13:17
     * 
     * @param String $nome Recebe o nome da vari�vel na sess�o a ser criada.
     * @param type $valor Recebe o valor que a vari�vel na sess�o receber�;
     */
    public static function inserirVariavel($nome, $valor){
        $_SESSION[$nome] = $valor;
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 24/09/2013 - 13:18
     * 
     * @param String $nome Recebe o nome da vari�vel da sess�o.
     * @return type Retorna o valor da vari�vel na sass�o.
     */
    public static function buscarVariavel($nome){
        return $_SESSION[$nome];
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 24/09/2013 - 13:19
     * 
     * @param String $nome Recebe o nome do objeto a ser inserida na sess�o.
     * @param type $obj Recebe o objeto a ser inserido na sess�o.
     */
    public static function inserirObjeto($nome, $obj){
        $_SESSION[$nome] = serialize($obj);
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 24/09/2013 - 13:20
     * 
     * @param String $obj Recebe o nome do objeto que est� na sess�o.
     * @return type Retorna o objeto na sess�o.
     */
    public static function buscarObjeto($obj){
        return unserialize($_SESSION[$obj]);
    }
}
?>