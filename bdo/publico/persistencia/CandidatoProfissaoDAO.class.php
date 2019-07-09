<?php
include_once '../modelo/CandidatoProfissaoVO.class.php';
class CandidatoProfissaoDAO{
    
    //Atributo que recebe a instância de conexão
    private $conexao = null;
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 31/03/2014 - 14:30
     */
    public function __construct(){
        $this->conexao = Conexao::getInstancia();
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 24/09/2013 - 10:35
     * @param CandidatoProfissaoVO $cp Recebe um objeto CandidatoProfissaoVO que será inserido no BD.
     */
    public function cadastrarCandidatoProfissao($cp){
        try{
            
            $stat = $this->conexao->prepare("INSERT INTO candidatoprofissao (
                                                id_candidatoprofissao,
                                                id_candidato,
                                                id_profissao
                                            )VALUES(
                                                null,
                                                $cp->id_candidato,
                                                $cp->id_profissao
                                            )");
            
            $stat->execute();
            $this->conexao = null;

        }catch(PDOException $e){
            return 'Erro ao cadastrar a profissão';
        }
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 31/03/2014 - 14:36
     * 
     * @param int $id_candidato Recebe o id do candidato como filtro para busca
     * @return array Retorna um array com todos os CandidatoProfissaoVO de um candidato
     */
    public function buscarCandidatoProfissoes($id_candidato){
        try{
            
            $stat = $this->conexao->query("select 
                                                cp.id_candidatoprofissao, 
                                                cp.id_candidato,
                                                cp.id_profissao,
                                                p.nm_profissao,
                                                p.ds_profissao,
                                                p.ao_ativo 
                                           from 
                                                candidatoprofissao cp
                                                LEFT JOIN profissao p ON (cp.id_profissao = p.id_profissao)
                                           where 
                                                cp.id_candidato = $id_candidato");
            
            function montarProfissao($id_candidatoprofissao, $id_candidato, $id_profissao, $nm_profissao, $ds_profissao, $ao_ativo){
        
                $cp = new CandidatoProfissaoVO();
                $cp->id_candidatoprofissao = $id_candidatoprofissao;
                $cp->id_candidato = $id_candidato;
                $cp->id_profissao = $id_profissao;

                $p = new ProfissaoVO();
                $p->id_profissao = $id_profissao;
                $p->nm_profissao = $nm_profissao;
                $p->ds_profissao = $ds_profissao;
                $p->ao_ativo = $ao_ativo;

                $cp->profissao = $p;

                return $cp;
            }

            $array = $stat->fetchAll(PDO::FETCH_FUNC,'montarProfissao');
            $this->conexao = null;
            return $array;
            
            
        }catch(PDOException $e){
            echo 'Erro ao buscar profissões';
        }
    }
    
     /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 31/03/2014 - 14:36
     * 
     * @param int $id_candidato Recebe o id do candidato como filtro para busca
     * @return array Retorna um array com todos os CandidatoProfissaoVO de um candidato
     */
    public function buscarCandidatoProfissoesSimples($id_candidato){
        try{

            $stat = $this->conexao->query("select 
                                                cp.id_candidatoprofissao, 
                                                cp.id_candidato,
                                                cp.id_profissao,
                                                p.nm_profissao, 
                                                p.ao_ativo 
                                           from 
                                                candidatoprofissao cp
                                                LEFT JOIN profissao p ON (cp.id_profissao = p.id_profissao)
                                           where 
                                                cp.id_candidato = $id_candidato");
            
            

            $array = $stat->fetchAll(PDO::FETCH_CLASS,'CandidatoProfissaoVO');
            $this->conexao = null;
            return $array;
            
            
        }catch(PDOException $e){
            echo 'Erro ao buscar profissões';
        }
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 31/03/2014 - 15:12
     * 
     * @param int $id_candidato Recebe o id do candidato.
     */
    public function deletar($id_candidato){
        try{
            
            $stat = $this->conexao->prepare("delete from candidatoprofissao where id_candidato = $id_candidato");
            
            $stat->execute();
            $this->conexao = null;

        }catch(PDOException $e){
            return 'Erro ao deletar a profissao';
        }
    }
    
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 04/05/2015 - 15:56
     * 
     * @param int $id_candidato Recebe o id do candidato.
     * @param int $id_profissao Recebe o id do candidato.
    */
    public function deletarCandidatoProfissaoPorId($id_candidato, $id_profissao){
        try{
            
            $stat = $this->conexao->prepare("delete from candidatoprofissao where id_candidato = $id_candidato and id_profissao = $id_profissao");
            
            $stat->execute();
            $this->conexao = null;

        }catch(PDOException $e){
            return 'Erro ao deletar a profissão';
        }
    }
    
    
}
?>
