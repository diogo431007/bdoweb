<?php

include (__DIR__.'/../../DefineCredenciais.php');

class Conexao extends PDO{
    
    //Instancia de conexão
    private static $instancia;
                     
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 24/09/2013 - 09:28
     * @param String $dbn 
     * @param String $usuario
     * @param String $senha
     */
    public function Conexao($adsn, $usuario, $senha){
        parent::__construct($adsn, $usuario, $senha);
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 24/09/2013 - 09:30
     * @return type Retorna uma instância de conexão com BD
     */
    public static function getInstancia(){
        
        if(!isset(self::$instancia)){
            try{
                self::$instancia = new Conexao("mysql:host=".DB_SERVER.";dbname=".DB_BANCO,DB_USER,DB_PASSWORD);
                
                include("Seguranca.php");
                # anti injection post e get
                Seguranca::antiInjectionPostGet();
                
            }catch(Exception $e){
                echo 'Erro ao conectar 2';
                exit();
            }
        }
        return self::$instancia;
    }
}
?>
