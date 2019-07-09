<?php
include_once '../modelo/CandidatoFormacaoVO.class.php';
class CandidatoFormacaoDAO{
    
    //Atributo que recebe a instância de conexão
    private $conexao = null;
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 24/09/2013 - 10:30
     */
    public function __construct(){
        $this->conexao = Conexao::getInstancia();
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 24/09/2013 - 10:35
     * @param CandidatoFormacaoVO $cf Recebe um objeto CandidatoFormacaoVO que será inserido no BD.
     */
    public function cadastrarCandidatoFormacao($cf){
        try{
            
            $stat = $this->conexao->prepare("INSERT INTO candidatoformacao (
                                                id_candidato_formacao,
                                                id_candidato,
                                                id_formacao,
                                                id_usuarioalteracao,
                                                id_usuarioinclusao,
                                                dt_termino,
                                                nm_escola,
                                                ds_cidadeescola,
                                                dt_inclusao,
                                                dt_alteracao,
                                                ds_curso,
                                                ds_semestre
                                            )VALUES(
                                                null,
                                                $cf->id_candidato,
                                                $cf->id_formacao,
                                                $cf->id_userAlteracao,
                                                $cf->id_userInclusao,
                                                $cf->dt_termino,
                                                '$cf->nm_escola',
                                                '$cf->ds_cidadeescola',
                                                $cf->dt_inclusao,
                                                $cf->dt_alteracao,
                                                '$cf->ds_curso',
                                                '$cf->ds_semestre')");
            
            $stat->execute();
            $this->conexao = null;

        }catch(PDOException $e){
            return 'Erro ao cadastrar os dados escolares do candidato';
        }
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 04/10/2013 - 10:36
     * 
     * @param int $id_candidato Recebe o id do candidato como filtro para busca
     * @return array Retorna um array com todos os CandidatoFormacaoVO de um candidato
     */
    public function buscarCandidatoFormacoes($id_candidato){
        try{

            $stat = $this->conexao->query(" SELECT 
                                                *
                                            FROM 
                                                candidatoformacao 
                                            WHERE 
                                                id_candidato = $id_candidato ");
            
            $array = $stat->fetchAll(PDO::FETCH_CLASS,'CandidatoFormacaoVO');
            $this->conexao = null;
            return $array;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar formacoes';
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
    public function verificar($id_candidato_formacao, $id_candidato){
        try{
            
            $stat = $this->conexao->query("select id_candidato from candidatoformacao where id_candidato_formacao = $id_candidato_formacao and id_candidato = $id_candidato");
            
            $qtd = $stat->rowCount();
            
            return $qtd;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar formacao';
        }
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 04/10/2013 - 13:55
     * 
     * @param int $id_candidato_formacao Recebe o id do objeto CandidatoFormacaoVO que será excluido do BD.
     */
    public function deletarCandidatoFormacao($id_candidato_formacao){
        try{
            
            $stat = $this->conexao->prepare("delete from candidatoformacao where id_candidato_formacao = $id_candidato_formacao");
            
            $stat->execute();
            $this->conexao = null;

        }catch(PDOException $e){
            return 'Erro ao deletar a formacao';
        }
    }
}
?>
