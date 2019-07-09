<?php
include_once '../modelo/ProfissaoVO.class.php';
class ProfissaoDAO{
    
    private $conexao = null;
    
    public function __construct(){
        $this->conexao = Conexao::getInstancia();
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 31/03/2014 - 12:54
     * 
     * @return array Retorna um array com todas as formacoes.
     */
    public function buscarProfissoes($query){
        try{
            $stat = $this->conexao->query("select p.id_profissao, p.nm_profissao, p.ds_profissao from profissao p where 1=1 $query order by p.nm_profissao asc");

            $array = $stat->fetchAll(PDO::FETCH_CLASS, 'ProfissaoVO');
            $this->conexao = null;
            return $array;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar profissão';
        }
    }
    
    /**
     * @author Douglas Carlos <douglas.carlos@canoastec.rs.gov.br>
     * @since 02/04/2014 - 11:01
     * 
     * @param ProfissaoVO $p Recebe um objeto ProfissaoVO que será inserido no BD.
     * @return int Retorna id gerado
     */
    public function cadastrarProfissao($p){
        try{
            
            $stat = $this->conexao->prepare("insert into profissao(
                                                id_profissao, 
                                                nm_profissao, 
                                                ao_ativo,
                                                dt_inclusao
                                             )
                                             values(
                                                    null,
                                                    '$p->nm_profissao',
                                                    '$p->ao_ativo',
                                                    now()
                                            )");
            
            $stat->execute();
            
            $idGerado = $this->conexao->lastInsertId();
            $this->conexao = null;
            return $idGerado;
            
        }catch(PDOException $e){
            return false;
        }
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 09/04/2014 - 09:24
     * 
     * @return array Retorna um array com todas as formacoes.
     */
    public function buscarProfissao($id_profissao){
        try{
            $stat = $this->conexao->query("select p.id_profissao, p.nm_profissao, p.ao_ativo from profissao p where p.id_profissao = $id_profissao order by p.nm_profissao asc");

            $profissao = $stat->fetchObject('ProfissaoVO');
            $this->conexao = null;
            return $profissao;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar profissão';
        }
    }
    
    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 01/08/2014 - 13:45
     * 
     * @return array Retorna a profissão daquela vaga.
     */
    public function buscarProfissaoPorIdVaga($id_vaga){
        try{
            $stat = $this->conexao->query(" SELECT 
                                                p.id_profissao, p.nm_profissao, p.ao_ativo 
                                            FROM
                                                profissao p 
                                                LEFT JOIN vaga v ON (v.id_profissao = p.id_profissao)
                                            WHERE 
                                                v.id_vaga = $id_vaga
                                            ORDER BY
                                                p.nm_profissao ASC ");

            $profissao = $stat->fetchObject('ProfissaoVO');
            $this->conexao = null;
            return $profissao;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar profissão';
        }
    }
    
        /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 04/05/2015 - 10:55
     * 
     * @return array Retorna um array com todas as profissões que não foram selecionadas pelo candidato e
     * não mostrando as que ele selecionou.
    */
    public function buscarProfissoesPorIdCandidatoNaoCadastradas($id_candidato){        
        try{
            $stat = $this->conexao->query("SELECT
                            p.id_profissao, p.nm_profissao
                          FROM
                            profissao p
                          WHERE
                            p.id_profissao 
                            NOT IN (SELECT cp.id_profissao FROM candidatoprofissao cp WHERE cp.id_candidato = '$id_candidato') AND
                            p.ao_ativo = 'S' ORDER BY p.nm_profissao ASC");

            $array = $stat->fetchAll(PDO::FETCH_CLASS, 'ProfissaoVO');
            $this->conexao = null;
            return $array;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar profissões';
        }
    }
    
    
}
?>