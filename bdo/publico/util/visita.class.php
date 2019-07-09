<?php
/**
     * @author Felipe Stroff <felipe.stroff@canoastec.rs.gov.br>
     * @since 20/03/2014 - 09:28
     * 
     */
class visita
{
    /*
     * variaveis
     **/
     
    //Dados necessarios para verificacao  de visitantes
    var $ip_visita; //armazena o ip do usuario
    var $dt_visita; //armazena a data atual
 
    //Dados necessarios para conexao com db  
//    var $hostdb = "mysql.canoastec.rs.gov.br";
//    var $userdb = "canoastec07";
//    var $passdb = "bt2152523";
//    var $namedb = "canoastec07";
 
    //Nome da tabela
    var $tabVisitas = "visita";
   
    /*
     * construtor
     **/
    function visita($ip)
    {
        //Armazena na variavel 'ip' o ip do visitante atual
        $this->ip_visita=$ip;
        //Pega a data atual e valida o acesso a cada minuto (i)
        $this->dt_visita=date("Y-m-d h:i");
    }
       
    /*
     * conexao com banco
     **/
    function conectar()
    {
        $link= mysql_connect($this->hostdb,$this->userdb,$this->passdb)or die(mysql_error());
        mysql_select_db($this->namedb,$link)or die(mysql_error());
    }  
 
    /*
     * verifica se o usuario ja visitou
     **/
    function verificaVisitante()
    {  
        //Chama a funcao de conexao com db
        //$this->conectar();
        /* Seleciona por ip e data  */
        $sql = mysql_query("SELECT 
                                ip_visita,dt_visita
                            FROM 
                                ".$this->tabVisitas."
                            WHERE 
                                ip_visita='".$this->ip_visita."' AND dt_visita='".$this->dt_visita."'")
                            or die(mysql_error());
        
        /* Verifica se a selecao feita existe, caso nao exista insere novo */
        if(!mysql_num_rows($sql)>0)
            $insereVisita = mysql_query("INSERT INTO ".$this->tabVisitas."(
                                            id_visita,ip_visita,dt_visita
                                       )
                                       VALUES
                                       ('','".$this->ip_visita."','".$this->dt_visita."')");
        //else print("Ja visitou");
    }
    /*
     * imprime numero de visitas
     **/
    function imprime()
    {
        //Chama conexao;
        //$this->conectar();
        //Seleciona todos
        $sql = mysql_query("SELECT * FROM ".$this->tabVisitas);
        //Conta quantos foram selecionados
        $total= mysql_num_rows($sql);
        
        $invertoONumeroDeVisitas = strrev($total);
        $aCadaTresCaracteresAdicionaPontoNaStringDeVisitas = chunk_split($invertoONumeroDeVisitas, 3, ".");                                    
        $invertoONumeroDeVisitasNovamente = strrev($aCadaTresCaracteresAdicionaPontoNaStringDeVisitas);
        $pegoOPrimeiroCaracterDaStringDeVisitas = substr($invertoONumeroDeVisitasNovamente, 0, 1);

        if($pegoOPrimeiroCaracterDaStringDeVisitas == "."){
            $totalVisitas = substr($invertoONumeroDeVisitasNovamente, 1);
        }else{
            $totalVisitas = $invertoONumeroDeVisitasNovamente;
        }
        
        //Imprime numero de visitas (registros na tabela)
        print(" ".$totalVisitas);
    }
}
//'Chama' a classe visita e ja pega o ip do visitante
$visita = new visita($_SERVER['REMOTE_ADDR']);
//Chama a funcao verificaVisitante();
//Ela verifica se por ip e data se o usuario ja visitou
$visita->verificaVisitante();
//Imprime o total de visitas (total de registros na tabela)
$visita->imprime();

?>