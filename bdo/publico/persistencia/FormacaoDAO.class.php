<?php

include_once '../modelo/FormacaoVO.class.php';
class FormacaoDao{
    
    private $conexao = null;
    
    public function __construct(){
        $this->conexao = Conexao::getInstancia();
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 30/09/2013 - 10:20
     * @version Banco de Oportunidades 2.0
     * 
     * @return FormacaoVO Retorna um array com todas as formacoes.
     */
    public function buscarFormacoes(){
        try{
            $stat = $this->conexao->query("select * from formacao order by nm_formacao");

            $array = $stat->fetchAll(PDO::FETCH_CLASS, 'FormacaoVO');
            $this->conexao = null;
            return $array;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar formacao';
        }
    }
}
?>