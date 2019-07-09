<?php
include_once '../modelo/CandidatoQualificacaoVO.class.php';
class CandidatoQualificacaoDAO{

    //Atributo que recebe a instância de conexão
    private $conexao = null;

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 24/09/2013 - 10:50
     */
    public function __construct(){
        $this->conexao = Conexao::getInstancia();
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 07/10/2013 - 11:20
     * @param CandidatoQualificacaoVO $cq Recebe um objeto CandidatoQualificacaoVO que será inserido no BD.
     */
    public function cadastrarCandidatoQualificacao($cq){
        try{
            $pronatec = var_export($cq->ao_pronatec, true);
            $sql = "INSERT INTO candidatoqualificacao (
                                                id_qualificacao,
                                                id_candidato,
                                                id_usuarioalteracao,
                                                id_usuarioinclusao,
                                                ds_qualificacao,
                                                dt_termino,
                                                qtd_horas,
                                                dt_inclusao,
                                                dt_alteracao,
                                                nm_instituicao,
                                                ao_pronatec,
                                                ao_qualificacao
                                             )
                                             VALUES(null,
                                                    $cq->id_candidato,
                                                    $cq->id_userAlteracao,
                                                    $cq->id_userInclusao,
                                                    '$cq->ds_qualificacao',
                                                    $cq->dt_termino,
                                                    $cq->qtd_horas,
                                                    $cq->dt_inclusao,
                                                    $cq->dt_alteracao,
                                                    '$cq->nm_instituicao',
                                                    $pronatec,
                                                    '$cq->ao_qualificacao')";
        
            $stat = $this->conexao->prepare($sql);


            $stat->execute();
            $this->conexao = null;

        }catch(PDOException $e){
            return 'Erro ao cadastrar os dados das qualificações do candidato';
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 07/10/2013 - 11:35
     *
     * @param int $id_candidato Recebe o id do candidato como filtro para busca
     * @return array Retorna um array com todos os CandidatoQualificacaoVO de um candidato
     */
    public function buscarCandidatoQualificacoes($id_candidato){
        try{

            $stat = $this->conexao->query("select * from candidatoqualificacao where id_candidato = $id_candidato and ao_qualificacao = 'S'");
            $array = $stat->fetchAll(PDO::FETCH_CLASS,'CandidatoQualificacaoVO');
            $this->conexao = null;
            return $array;

        }catch(PDOException $e){
            echo 'Erro ao buscar qualificacoe';
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 08/10/2013 - 10:50
     *
     * @param int $id_candidato Recebe o id do candidato como filtro para busca
     * @return array Retorna um array com todos os CandidatoQualificacaoVO de um candidato
     */
    public function buscarQualificacoesNulas($id_candidato){
        try{

            $stat = $this->conexao->query("select * from candidatoqualificacao where id_candidato = $id_candidato and ao_qualificacao = 'N'");
            $array = $stat->fetchAll(PDO::FETCH_CLASS,'CandidatoQualificacaoVO');
            $this->conexao = null;
            return $array;

        }catch(PDOException $e){
            echo 'Erro ao buscar qualificacoe';
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 07/10/2013 - 13:24
     *
     * @param int $id_qualificacao Recebe o id do CandidatoQualificacaoVO que pretende ser deletado
     * @param int $id_candidato Recebe o id do CandidatoVO logado na sessao
     * @return booleano Retorna true se a busca retornar tiver resultado, caso contrario false
     */
    public function verificar($id_qualificacao, $id_candidato){
        try{

            $stat = $this->conexao->query("select id_candidato from candidatoqualificacao where id_qualificacao = $id_qualificacao and id_candidato = $id_candidato");

            $qtd = $stat->rowCount();

            return $qtd;

        }catch(PDOException $e){
            echo 'Erro ao buscar formacao';
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 07/10/2013 - 14:03
     *
     * @param int $id_qualificacao Recebe o id do objeto CandidatoQualificacaoVO que será excluido do BD.
     */
    public function deletarCandidatoQualificacao($id_qualificacao){
        try{

            $stat = $this->conexao->prepare("delete from candidatoqualificacao where id_qualificacao = $id_qualificacao");

            $stat->execute();
            $this->conexao = null;

        }catch(PDOException $e){
            return 'Erro ao deletar a qualificacao';
        }
    }

    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 25/09/2014 - 12:58
     *
     * @param int $id_candidato Recebe o id do candidato como filtro para busca
     * @return array Retorna um array com todos os CandidatoQualificacaoVO de um candidato
     */
    public function deletarQualificacoesNulas($id_candidato){
        try{

            $stat = $this->conexao->prepare("delete from candidatoqualificacao where id_candidato = $id_candidato and (ao_qualificacao='N' or ao_qualificacao='')");

            $stat->execute();
            $this->conexao = null;

        }catch(PDOException $e){
            echo 'Erro ao buscar qualificacoe';
        }
    }

    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 29/09/2014 - 14:34
     *
     * @param RelatoVO $r Recebe um objeto RelatoVO que será alterado no BD.
     * @return booleano Retorna true se alterado com sucesso.
     */
//    public function alterarCandidatoQualificacao($cq){
//        try{
//            $stat = $this->conexao->prepare("UPDATE candidatoqualificacao SET
//                                                id_candidato = $cq->id_candidato,
//                                                id_usuarioalteracao = $cq->id_usuarioalteracao,
//                                                id_usuarioinclusao = $cq->id_usuarioinclusao,
//                                                ds_qualificacao = '$cq->ds_qualificacao',
//                                                dt_termino = '$cq->dt_termino',
//                                                qtd_horas = '$cq->qtd_horas',
//                                                dt_inclusao = '$cq->dt_inclusao',
//                                                dt_alteracao = '$cq->dt_alteracao',
//                                                ao_qualificacao = '$cq->ao_qualificacao',
//                                                nm_instituicao = '$cq->nm_instituicao',
//                                                ao_pronatec = '$cq->ao_pronatec'
//                                            WHERE id_qualificacao = $cq->id_qualificacao");
//
//            $stat->execute();
//            $this->conexao = null;
//            return true;
//        }catch(PDOException $e){
//            return false;
//        }
//    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 07/10/2013 - 14:03
     *
     * @param int $id_qualificacao Recebe o id do objeto CandidatoQualificacaoVO que será excluido do BD.
     */
    public function deletarQualificacoesCandidato($id_candidato){
        try{

            $stat = $this->conexao->prepare("delete from candidatoqualificacao where id_candidato = $id_candidato");

            $stat->execute();
            $this->conexao = null;

        }catch(PDOException $e){
            return 'Erro ao deletar a qualificacao';
        }
    }
}
?>
