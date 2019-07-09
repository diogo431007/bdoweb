<?php
include_once 'Conexao.class.php';
include_once '../modelo/ContatoVO.class.php';
class ContatoDao{
    
    private $conexao = null;
    
    public function __construct(){
        $this->conexao = Conexao::getInstancia();
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 29/10/2013 - 14:18
     * 
     * @param ContatoVO $c Recebe um objeto ContatoVO que será inserido no BD.
     * @return int Retorna id gerado
     */
    public function cadastrarContato($c){
        try{
            
            $stat = $this->conexao->prepare("insert into contato(
                                                id_contato, 
                                                nm_contato, 
                                                ds_email, 
                                                nr_telefone, 
                                                ds_assunto,
                                                nr_cpf,
                                                ds_mensagem, 
                                                dt_cadastro
                                             )
                                             values(
                                                    $c->id_contato,
                                                    '$c->nm_contato',
                                                    '$c->ds_email',
                                                    '$c->nr_telefone',
                                                    '$c->ds_assunto',
                                                    '$c->nr_cpf',
                                                    '$c->ds_mensagem',
                                                    $c->dt_cadastro
                                            )");
            
            $stat->execute();
            
            $idGerado = $this->conexao->lastInsertId();
            $this->conexao = null;
            return $idGerado;
            
        }catch(PDOException $e){
            return false;
        }
    }
}
?>