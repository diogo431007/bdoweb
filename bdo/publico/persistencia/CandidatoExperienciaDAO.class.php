<?php
include_once '../modelo/CandidatoExperienciaVO.class.php';
class CandidatoExperienciaDAO{
    
    //Atributo que recebe a instância de conexão
    private $conexao = null;
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 24/09/2013 - 11:10
     */
    public function __construct(){
        $this->conexao = Conexao::getInstancia();
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 24/09/2013 - 11:13
     * @param CandidatoExperienciaVO $ce Recebe um objeto CandidatoExperienciaVO que será inserido no BD.
     */
    public function cadastrarCandidatoExperiencia($ce){
        try{
            
            $stat = $this->conexao->prepare("INSERT INTO candidatoexperiencia (
                                                id_experiencia, 
                                                id_usuarioalteracao, 
                                                id_usuarioinclusao, 
                                                id_candidato, 
                                                dt_inicio, 
                                                dt_termino, 
                                                nm_empresa, 
                                                ds_atividades, 
                                                dt_inclusao, 
                                                dt_alteracao,
                                                ao_experiencia
                                             ) 
                                             VALUES(null,
                                                    $ce->id_userAlteracao,
                                                    $ce->id_userInclusao,
                                                    $ce->id_candidato,
                                                    $ce->dt_inicio,
                                                    $ce->dt_termino,
                                                    '$ce->nm_empresa',
                                                    '$ce->ds_atividades',
                                                    $ce->dt_inclusao,
                                                    $ce->dt_alteracao,
                                                    '$ce->ao_experiencia')");
            
            $stat->execute();
            $this->conexao = null;

        }catch(PDOException $e){
            echo 'Erro ao cadastrar os dados das experiências do candidato';
        }
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 08/10/2013 - 09:30
     * 
     * @param int $id_candidato Recebe o id do candidato como filtro para busca
     * @return array Retorna um array com todos os CandidatoExperienciaVO de um candidato
     */
    public function buscarCandidatoExperiencias($id_candidato){
        try{

            $stat = $this->conexao->query("select * from candidatoexperiencia where id_candidato = $id_candidato and ao_experiencia = 'S'");
            $array = $stat->fetchAll(PDO::FETCH_CLASS,'CandidatoExperienciaVO');
            $this->conexao = null;
            return $array;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar experiencias';
        }
    }
    
        /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 08/10/2013 - 09:30
     * 
     * @param int $id_candidato Recebe o id do candidato como filtro para busca
     * @return array Retorna um array com todos os CandidatoExperienciaVO de um candidato
     */
    public function buscarCandidatoExperienciasNulas($id_candidato){
        try{

            $stat = $this->conexao->query("select * from candidatoexperiencia where id_candidato = $id_candidato and ao_experiencia = 'N'");
            $array = $stat->fetchAll(PDO::FETCH_CLASS,'CandidatoExperienciaVO');
            $this->conexao = null;
            return $array;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar experiencias';
        }
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 08/10/2013 - 11:55
     * 
     * @param int $id_experiencia Recebe o id do CandidatoExperienciaVO que pretende ser deletado
     * @param int $id_candidato Recebe o id do CandidatoVO logado na sessao
     * @return booleano Retorna true se a busca retornar tiver resultado, caso contrario false 
     */
    public function verificar($id_experiencia, $id_candidato){
        try{
            
            $stat = $this->conexao->query("select id_candidato from candidatoexperiencia where id_experiencia = $id_experiencia and id_candidato = $id_candidato");
            
            $qtd = $stat->rowCount();
            
            return $qtd;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar experiencia';
        }
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 08/10/2013 - 13:00
     * 
     * @param int $id_experiencia Recebe o id do objeto CandidatoExperienciaVO que será excluido do BD.
     */
    public function deletarCandidatoFormacao($id_experiencia){
        try{
            
            $stat = $this->conexao->prepare("delete from candidatoexperiencia where id_experiencia = $id_experiencia");
            $stat->execute();
            $this->conexao = null;

        }catch(PDOException $e){
            echo 'Erro ao deletar a formacao';
        }
    }
    
    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 29/09/2014 - 15:56
     * 
     * @param int $id_candidato Recebe o id do candidato como filtro para busca
     * @return array Retorna um array com todos os CandidatoQualificacaoVO de um candidato
     */
    public function deletarExperienciasNulas($id_candidato){
        try{
            
            $stat = $this->conexao->prepare("delete from candidatoexperiencia where id_candidato = $id_candidato and (ao_experiencia='N' or ao_experiencia='')");
            
            $stat->execute();
            $this->conexao = null;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar experiencias';
        }
    }
}
?>
