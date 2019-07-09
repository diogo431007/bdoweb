<?php
include_once '../modelo/VagaVO.class.php';

class VagaDAO{

    private $conexao = null;

    public function __construct(){
        $this->conexao = Conexao::getInstancia();
    }

    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 31/03/2014 - 11:21
     * @param VagaVO $v Recebe um objeto VagaVO que será inserido no BD.
     * @return int Retorna o id gerado na inserção
     */
    public function cadastrarVaga($v){
        try{
            $sql = "INSERT INTO vaga(
                                                 id_vaga,
                                                 id_empresa,
                                                 id_profissao,
                                                 ds_atribuicao,
                                                 nr_salario,
                                                 ds_adicional,
                                                 ds_beneficio,
                                                 ds_observacao,
                                                 qt_vaga,
                                                 ao_ativo,
                                                 ao_exibenome,
                                                 ao_exibeemail,
                                                 ao_exibetelefone,
                                                 ao_sexo,
                                                 ao_deficiente,
                                                 ds_estado_civil,
                                                 ds_idade,
                                                 ao_experiencia,
                                                 ds_cnh,
                                                 dt_cadastro
                                              )
                                              values(null,
                                                 $v->id_empresa,
                                                 $v->id_profissao,
                                                 '$v->ds_atribuicao',
                                                 $v->nr_salario,
                                                 '$v->ds_adicional',
                                                 '$v->ds_beneficio',
                                                 '$v->ds_observacao',
                                                 $v->qt_vaga,
                                                 '$v->ao_ativo',
                                                 '$v->ao_exibenome',
                                                 '$v->ao_exibeemail',
                                                 '$v->ao_exibetelefone',
                                                 '$v->ao_sexo',
                                                 '$v->ao_deficiente',
                                                 '$v->ds_estado_civil',
                                                 '$v->ds_idade',
                                                 '$v->ao_experiencia',
                                                 '$v->ds_cnh',
                                                 now())";
           $stat = $this->conexao->prepare($sql);

            $stat->execute();

            $idGerado = $this->conexao->lastInsertId();
            $this->conexao = null;
            return $idGerado;

        }catch(PDOException $e){
            return false;
        }
    }

    /**
     * @author Ricardo K.Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 01/04/2014 - 09:30
     *
     * @param VagaVO $e Recebe um objeto VagaVO que será atualizado no BD.
     * @return boolean Retorna true se bem sucessido a alteração.
     */
    public function alterarVaga($v){
        try{
            $stat = $this->conexao->prepare("UPDATE vaga SET
                                                id_empresa = $v->id_empresa,
                                                id_profissao = $v->id_profissao,
                                                ds_atribuicao = '$v->ds_atribuicao',
                                                nr_salario = $v->nr_salario,
                                                ds_adicional = '$v->ds_adicional',
                                                ds_beneficio = '$v->ds_beneficio',
                                                ds_observacao = '$v->ds_observacao',
                                                qt_vaga = $v->qt_vaga,
                                                ao_ativo = '$v->ao_ativo',
                                                ao_exibenome = '$v->ao_exibenome',
                                                ao_exibeemail = '$v->ao_exibeemail',
                                                ao_exibetelefone = '$v->ao_exibetelefone',
                                                ao_sexo = '$v->ao_sexo',
                                                ao_deficiente = '$v->ao_deficiente',
                                                ds_estado_civil = '$v->ds_estado_civil',
                                                ds_idade = '$v->ds_idade',
                                                ao_experiencia = '$v->ao_experiencia',
                                                ds_cnh = '$v->ds_cnh'
                                            WHERE id_vaga = $v->id_vaga
                                        ");

            $stat->execute();
            $this->conexao = null;

        }catch(PDOException $e){
            echo 'Erro ao atualizar a vaga.';
        }
    }

    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 01/04/2014 - 13:17
     *
     * @param int $id_empresa Recebe o id da empresa como filtro para busca
     * @return array Retorna um array com todas as VagasVO de uma empresa
     */
    public function buscarVagasEmpresa($id_empresa, $query=''){
        try{
            $stat = $this->conexao->query("SELECT
                            v.*, p.ao_ativo as prof_ao_ativo
                        FROM
                            vaga v
                            LEFT JOIN
                              profissao p ON (v.id_profissao = p.id_profissao)
                            LEFT JOIN
                              empresa e ON (v.id_empresa = e.id_empresa)
                        WHERE
                            e.id_empresa = $id_empresa
                            $query
                        ORDER BY
                            v.ao_ativo ASC,
                            p.nm_profissao ASC");//die;
            $array = $stat->fetchAll(PDO::FETCH_CLASS,'VagaVO');
            $this->conexao = null;
            return $array;

        }catch(PDOException $e){
            echo 'Erro ao buscar as vagas.';
        }
    }

    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 01/04/2014 - 13:17
     *
     * @param int $id_vaga Recebe o id da vaga como filtro para busca
     * @return VagaVO Retorna um VagaVO de uma empresa
     */
    public function buscarVaga($id_vaga){
        try{
            $stat = $this->conexao->query(" SELECT
                                                v.*
                                            FROM
                                                vaga v,
                                                empresa e,
                                                profissao p
                                            WHERE
                                                v.id_empresa = e.id_empresa AND
                                                v.id_profissao = p.id_profissao AND
                                                v.id_vaga = $id_vaga
                                            ORDER BY id_vaga ASC ");

            $vaga = $stat->fetchObject('VagaVO');
            $this->conexao = null;
            return $vaga;

        }catch(PDOException $e){
            echo 'Erro ao buscar as vagas.';
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 10/04/2014 - 11:03
     *
     * @param int $id_profissao Recebe um id_profissao para verificar se ja nao tem uma vaga ativa para a profissao
     * @param int $id_vaga Recebe o id_vaga por padrao 'NULL', em caso de alteração deve informar o id
     * @return booleano Retorna true se não estiver cadastrado.
     */
    public function verificarVaga($id_profissao, $id_empresa, $id_vaga=null){
        try{

            if(is_null($id_vaga)){
                $stat = $this->conexao->query("select 1 from vaga v where v.id_profissao = $id_profissao and v.ao_ativo = 'S' and v.id_empresa = $id_empresa");
            }else{
                $stat = $this->conexao->query("select 1 from vaga v where v.id_profissao = $id_profissao and v.ao_ativo = 'S' and v.id_vaga <> $id_vaga and v.id_empresa = $id_empresa");
            }

            $qtd = $stat->rowCount();
            $this->conexao = null;
            if($qtd > 0){
                return false;
            }else{
                return true;
            }

        }catch(PDOException $e){
            echo 'erro ao verificar usuario no banco';
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 29/04/2014 - 15:24
     *
     * @param string $query Recebe a query da busca
     * @return array Retorna um array de VagaVO
     *
    public function buscarVagasPorFiltro($query){
        try{

            $stat = $this->conexao->query("SELECT
                                            v.*,
                                            e.nm_razaosocial,
                                            e.nm_fanta
                                          FROM
                                            vaga v
                                            JOIN empresa e ON (v.id_empresa = e.id_empresa)
                                            JOIN profissao p ON (v.id_profissao = p.id_profissao)
                                          WHERE
                                            1=1
                                            $query");

            function montarVagas(){

            }

            $array = $stat->fetchAll(PDO::FETCH_FUNC,'montarVagas');
            $this->conexao = null;
            return $array;

        }catch(PDOException $e){
            echo 'Erro ao buscar vagas';
        }
    }*/

    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 24/09/2014 - 14:39
     *
     * @param int $id_vaga Recebe o id da vaga como filtro para busca
     * @return count de vagas
     */
    public function buscarQtVaga($id_vaga){
        try{
            $stat = $this->conexao->query(" SELECT
                                                v.qt_vaga
                                            FROM
                                                vaga v
                                            WHERE
                                                v.id_vaga = $id_vaga ");

            $vaga = $stat->fetchObject('VagaVO');
            $this->conexao = null;
            return $vaga;

        }catch(PDOException $e){
            echo 'Erro ao buscar as vagas.';
        }
    }

    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 07/05/2015 - 14:00
     *
     * @param int $id_vaga Recebe o id da vaga como filtro para busca
     * @return count de vagas
    */
    public function buscarTotalVagaPorIdProfissao($id_vaga){
        try{
            $stat = $this->conexao->query("SELECT MAX(v.qt_vaga) as totalvagas, p.nm_profissao FROM
                                                profissao p, vaga v
                                            WHERE
                                                p.id_profissao = v.id_profissao AND
                                                p.id_profissao = '$id_vaga'
                                            GROUP BY
                                                p.id_profissao");

            $vaga = $stat->fetchObject('VagaVO');
            $this->conexao = null;
            return $vaga;

        }catch(PDOException $e){
            echo 'Erro ao buscar as vagas.';
        }
    }

}
?>
