<?php
include_once '../modelo/CandidatoSubAreaVO.class.php';
class CandidatoSubAreaDAO{
    
    //Atributo que recebe a instância de conexão
    private $conexao = null;
    
    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 20/03/2014 - 08:58
     */
    public function __construct(){
        $this->conexao = Conexao::getInstancia();
    }
    
    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 20/03/2014 - 08:58
     * @param CandidatoSubAreaVO $csa Recebe um objeto CandidatoFormacaoVO que será inserido no BD.
     */
    public function cadastrarCandidatoSubarea($csa){
        try{
            
            $stat = $this->conexao->prepare("INSERT INTO candidatosubarea (
    
                                                id_candidatosubarea,
                                                id_candidato,
                                                id_subarea
                                            )VALUES(
                                                null,
                                                $csa->id_candidato,
                                                $csa->id_subarea)");
            
            $stat->execute();
            $this->conexao = null;

        }catch(PDOException $e){
            return 'Erro ao cadastrar os dados de áreas de interesses do candidato.';
        }
    }
    
    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 20/03/2014 - 09:37
     * 
     * @param int $id_candidato Recebe o id do candidato como filtro para busca
     * @return array Retorna um array com todos os CandidatoSubAreaVO de um candidato
     */
    public function buscarCandidatoSubAreas($id_candidato){
        try{

            $stat = $this->conexao->query("select * from candidatosubarea where id_candidato = $id_candidato");
            $array = $stat->fetchAll(PDO::FETCH_CLASS,'CandidatoSubAreaVO');
            $this->conexao = null;
            return $array;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar sub área.';
        }
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 04/10/2013 - 13:10
     * 
     * @param int $id_candidato_formacao Recebe o id do CandidatoFormacaoVO que pretende ser deletado
     * @param int $id_candidato Recebe o id do CandidatoVO logado na sessao
     * @return booleano Retorna true se a busca retornar tiver resultado, caso contrario false 
     */
    public function verificar($id_candidatosubarea, $id_candidato){
        try{
            
            $stat = $this->conexao->query("select id_candidato from candidatosubarea where id_candidatosubarea = $id_candidatosubarea and id_candidato = $id_candidato");
            
            $qtd = $stat->rowCount();
            
            return $qtd;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar sub sub área.';
        }
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 04/10/2013 - 13:55
     * 
     * @param int $id_candidato Recebe o id do candidato
     */
    public function deletarCandidatoSubArea($id_candidato){
        try{
            
            $stat = $this->conexao->prepare("delete from candidatosubarea where id_candidato = $id_candidato");
            
            $stat->execute();
            $this->conexao = null;

        }catch(PDOException $e){
            return 'Erro ao deletar a sub área.';
        }
    }
}
?>
