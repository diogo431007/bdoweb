<?php
include_once 'Conexao.class.php';
include_once '../modelo/CandidatoVO.class.php';
//include_once './SubareaDAO.class.php';
class CandidatoDAO{

    //Atributo que recebe a instância de conexão
    private $conexao = null;

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 24/09/2013 - 09:33
     */
    public function __construct(){
        $this->conexao = Conexao::getInstancia();
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 26/09/2013 - 13:15
     * @param CandidatoVO $c Recebe um objeto CandidatoVO que será inserido no BD.
     * @return int Retorna o id gerado na insercao
     */
    public function cadastrarCandidato($c){
        try{
           $sql = "insert into candidato(
                                                id_deficiencia,
                                                id_usuarioinclusao,
                                                nm_candidato,
                                                ds_email,
                                                nr_telefone,
                                                nr_celular,
                                                ds_estado_civil,
                                                dt_nascimento,
                                                ao_sexo,
                                                ds_nacionalidade,
                                                nr_cep,
                                                ds_logradouro,
                                                nr_logradouro,
                                                ds_complemento,
                                                ds_bairro,
                                                id_bairro,
                                                id_cidade,
                                                dt_cadastro,
                                                dt_validade,
                                                ds_objetivo,
                                                nr_cpf,
                                                nr_rg,
                                                nr_ctps,
                                                nr_pis,
                                                nr_serie,
                                                id_estadoctps,
                                                ds_loginportal,
                                                pw_senhaportal,
                                                ao_interno,
                                                ds_cnh,
                                                ao_bolsafamilia,
                                                nr_nis,
                                                ao_ativo
                                             )
                                             values($c->id_deficiencia,
                                                    $c->id_userInclusao,
                                                    '$c->nm_candidato',
                                                    '$c->ds_email',
                                                    '$c->nr_telefone',
                                                    '$c->nr_celular',
                                                    $c->ds_estado_civil,
                                                    '$c->dt_nascimento',
                                                    '$c->ao_sexo',
                                                    '$c->ds_nacionalidade',
                                                    '$c->nr_cep',
                                                    '$c->ds_logradouro',
                                                    '$c->nr_logradouro',
                                                    '$c->ds_complemento',
                                                    '$c->ds_bairro',
                                                     $c->id_bairro,
                                                    $c->id_cidade,
                                                    $c->dt_cadastro,
                                                    $c->dt_validade,
                                                    '$c->ds_objetivo',
                                                    '$c->nr_cpf',
                                                    '$c->nr_rg',
                                                    '$c->nr_ctps',
                                                    '$c->nr_pis',
                                                    '$c->nr_serie',
                                                    $c->id_estadoctps,
                                                    '$c->ds_loginportal',
                                                    '$c->pw_senhaportal',
                                                    '$c->ao_interno',
                                                    $c->ds_cnh,
                                                    '$c->ao_bolsafamilia',
                                                    $c->nr_nis,
                                                    $c->ao_ativo)";

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
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 03/10/2013 - 10:18
     *
     * @param CandidatoVO $c Recebe o candidato para verificar login e senha
     * @return CandidatoVO Retorna um CandidatoVO
     */
    public function verificarCandidato($c){
        try{

            $stat = $this->conexao->query("select * from candidato where ds_loginportal = '$c->ds_loginportal' and pw_senhaportal = '$c->pw_senhaportal'");
            $candidato = $stat->fetchObject('CandidatoVO');
            $this->conexao = null;
            return $candidato;

        }catch(PDOException $e){
            echo 'erro ao verificar candidato no banco';
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 04/10/2013 - 09:13
     *
     * @param CandidatoVO $c Recebe um objeto CandidatoVO que será atualizado no BD.
     */
    public function alterarCandidato($c){
        try{

            $stat = $this->conexao->prepare("update candidato set
                                                id_deficiencia = $c->id_deficiencia,
                                                nm_candidato = '$c->nm_candidato',
                                                ds_email = '$c->ds_email',
                                                nr_telefone = '$c->nr_telefone',
                                                nr_celular = '$c->nr_celular',
                                                ds_estado_civil = $c->ds_estado_civil,
                                                dt_nascimento = '$c->dt_nascimento',
                                                ao_sexo = '$c->ao_sexo',
                                                ds_nacionalidade = '$c->ds_nacionalidade',
                                                nr_cep = '$c->nr_cep',
                                                ds_logradouro = '$c->ds_logradouro',
                                                nr_logradouro = '$c->nr_logradouro',
                                                ds_complemento = '$c->ds_complemento',
                                                ds_bairro = '$c->ds_bairro',
												id_bairro = $c->id_bairro,
                                                id_cidade = $c->id_cidade,
                                                dt_alteracao = $c->dt_alteracao,
                                                ds_objetivo = '$c->ds_objetivo',
                                                nr_rg = '$c->nr_rg',
                                                nr_ctps = '$c->nr_ctps',
                                                nr_pis = '$c->nr_pis',
                                                nr_serie = '$c->nr_serie',
                                                id_estadoctps = $c->id_estadoctps,
                                                ds_cnh = $c->ds_cnh,
                                                ao_bolsafamilia = '$c->ao_bolsafamilia',
                                                nr_nis = $c->nr_nis,
                                                ao_ativo = '$c->ao_ativo'
                                            where id_candidato = $c->id_candidato");

            $stat->execute();
            $this->conexao = null;

        }catch(PDOException $e){
            echo 'erro ao atualizar candidato';
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 09/10/2013 - 13:28
     *
     * @param CandidatoVO $c Recebe um objeto CandidatoVO que será atualizado no BD.
     */
    public function alterarSenha($c){
        try{

            $stat = $this->conexao->prepare("update candidato set
                                                pw_senhaportal = '$c->pw_senhaportal',
                                                ao_interno = '$c->ao_interno'
                                            where id_candidato = $c->id_candidato
                                        ");

            $stat->execute();
            $this->conexao = null;

        }catch(PDOException $e){
            echo 'erro ao atualizar candidato';
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 09/10/2013 - 15:23
     *
     * @param CandidatoVO $c Recebe o candidato para verificar cpf e email
     * @return CandidatoVO Retorna um CandidatoVO
     */
    public function verificarNrCpfCandidato($c){
        try{

            $stat = $this->conexao->query("select * from candidato where nr_cpf = '$c->nr_cpf' and ds_email = '$c->ds_email'");

            $candidato = $stat->fetchObject('CandidatoVO');
            $this->conexao = null;
            return $candidato;

        }catch(PDOException $e){
            echo 'erro ao verificar candidato no banco';
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 18/10/2013 - 15:16
     *
     * @param string $query Recebe a query da busca
     * @return array Retorna um array de CandidatoVO
     */
    public function buscarPorFiltro($query){
        try{

            $stat = $this->conexao->query("SELECT
                                            DISTINCT(c.id_candidato),
                                            c.nm_candidato,
                                            c.ds_email,
                                            c.nr_telefone,
                                            c.nr_celular,
                                            IF(c.ao_sexo = 'M','Masculino','Feminino') as ao_sexo,
                                            (YEAR(now()) - YEAR(c.dt_nascimento) - if( DATE_FORMAT(now(), '%m%d') > DATE_FORMAT(c.dt_nascimento, '%m%d') ,0 , -1)) as dt_nascimento,
                                            CASE c.ds_estado_civil
                                                WHEN 'C' THEN 'Casado(a)'
                                                WHEN 'S' THEN 'Solteiro(a)'
                                                WHEN 'D' THEN 'Divorciado(a)'
                                                WHEN 'V' THEN 'Viúvo(a)'
                                                WHEN 'P' THEN 'Separado(a)'
                                                WHEN 'O' THEN 'Outros'
                                            END as ds_estado_civil,
                                            cid.*
                                          FROM
                                            candidato c
                                            LEFT JOIN
                                                    candidatoprofissao cp ON (c.id_candidato = cp.id_candidato)
                                            LEFT JOIN
                                                    candidatoformacao cf ON (c.id_candidato = cf.id_candidato)
                                            LEFT JOIN
                                                    cidade cid ON (c.id_cidade = cid.id_cidade)
                                          WHERE
                                            c.dt_validade >= now()
                                            $query
                                          ORDER BY c.nm_candidato ASC");
            $array = $stat->fetchAll(PDO::FETCH_CLASS,'CandidatoVO');
            $this->conexao = null;
            return $array;

        }catch(PDOException $e){
            echo 'Erro ao buscar candidatos';
        }
    }

    /**
    * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
    * @version Banco de Oportunidades 2.0
    * @since 10/03/2015 - 10:42
    *
    * @param string $query Recebe a query da busca
    * @return array Retorna um array de CandidatoVO
    */
    public function buscarContratado($query, $id_empresa){
        try{
            $stat = $this->conexao->query("select c.id_candidato, c.nm_candidato, c.ds_email, c.id_deficiencia, c.ao_sexo, c.id_cidade, vc.id_vagacandidato, vc.ao_status, v.id_vaga, v.ao_ativo, p.nm_profissao, e.nm_fantasia
                            from candidato c, vagacandidato vc, vaga v, profissao p, empresa e
                            where c.id_candidato = vc.id_candidato
                            and vc.id_vaga = v.id_vaga
                            and v.id_empresa = $id_empresa
                            $query
                            and v.id_profissao=p.id_profissao
                            and v.id_empresa = e.id_empresa
                            order by nm_candidato");


            $array = $stat->fetchAll(PDO::FETCH_CLASS,'CandidatoVO');
            $this->conexao = null;
            return $array;

        }catch(PDOException $e){
            echo 'Erro ao buscar candidatos';
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 18/10/2013 - 15:16
     *
     * @param string $query Recebe a query da busca
     * @return array Retorna um array de CandidatoVO
     */
    public function buscarPorFiltroBackup($query){
        try{

            $stat = $this->conexao->query("SELECT
                                            DISTINCT(c.id_candidato) as id_candidato,
                                            c.nm_candidato,
                                            c.ds_email,
                                            c.nr_telefone,
                                            c.nr_celular
                                          FROM
                                            candidato c
                                            LEFT JOIN
                                                    cbo p ON (c.id_cbo = p.id_cbo)
                                            LEFT JOIN
                                                    candidatoformacao cf ON (c.id_candidato = cf.id_candidato)
                                            LEFT JOIN
                                                    cidade cid ON (c.id_cidade = cid.id_cidade)
                                          WHERE
                                            c.dt_validade >= now()
                                            $query
                                          ORDER BY c.nm_candidato ASC");

            function montarCandidato($id_candidato, $nm_candidato, $ds_email, $nr_telefone, $nr_celular){

                $c = new CandidatoVO();
                $c->id_candidato = $id_candidato;
                $c->nm_candidato = $nm_candidato;
                $c->ds_email = $ds_email;
                $c->nr_telefone = $nr_telefone;
                $c->nr_celular = $nr_celular;
                //$aDAO = new AreaDAO();
                //$c->areas = $aDAO->buscarAreasPorCandidato($c->id_candidato);
                return $c;
            }


            $array = $stat->fetchAll(PDO::FETCH_FUNC,'montarCandidato');
            $this->conexao = null;
            return $array;

        }catch(PDOException $e){
            echo 'Erro ao buscar candidatos';
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 21/10/2013 - 10:49
     *
     * @param int $id_candidato Recebe o id do candidato
     * @return CandidatoVO Retorna um CandidatoVO
     */
    public function buscarPorId($id_candidato){
        try{
            $stat = $this->conexao->query(" SELECT
                                                c.*
                                            FROM
                                                candidato c
                                            WHERE
                                                c.id_candidato = $id_candidato ");

            $candidato = $stat->fetchObject('CandidatoVO');
            $this->conexao = null;
            return $candidato;

        }catch(PDOException $e){
            echo 'Erro ao buscar candidato';
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 24/10/2013 - 10:20
     *
     * @param string $login Recebe um login
     * @return boolean Retorna true se o cpf/login nao estiver cadastrado no banco
     */
    public function verificarLogin($login){
        try{

            $stat = $this->conexao->query("select 1 from candidato where ds_loginportal = '$login'");
            $qtd = $stat->rowCount();

            if($qtd > 0){
                return false;
            }else{
                return true;
            }

        }catch(PDOException $e){
            echo 'erro ao verificar candidato no banco';
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 01/11/2013 - 14:50
     *
     * @param string $cpf Recebe um cpf
     * @return boolean Retorna true se o cpf nao estiver cadastrado no banco
     */
    public function verificarCpf($cpf){
        try{

            $stat = $this->conexao->query("select 1 from candidato where nr_cpf = '$cpf'");
            $qtd = $stat->rowCount();

            if($qtd > 0){
                return false;
            }else{
                return true;
            }

        }catch(PDOException $e){
            echo 'erro ao verificar candidato no banco';
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 24/10/2013 - 11:33
     *
     * @param int $id_candidato Recebe o id do candidato que atualizou seu curriculo
     */
    public function atualizarValidade($id_candidato){
        try{

            $stat = $this->conexao->prepare("update candidato set
                                                dt_validade = CURDATE() + INTERVAL 61 DAY,
                                                qt_lembrete = 0
                                            where id_candidato = $id_candidato");

            $stat->execute();
            $this->conexao = null;

        }catch(PDOException $e){
            echo 'erro ao atualizar candidato';
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 24/10/2013 - 13:28
     *
     * @param int $id_candidato Recebe o id do candidato que atualizou seu curriculo
     */
    public function atualizarDtAlteracao($id_candidato){
        try{

            $stat = $this->conexao->prepare("update candidato set
                                                dt_alteracao = NOW()
                                            where id_candidato = $id_candidato");

            $stat->execute();
            $this->conexao = null;

        }catch(PDOException $e){
            echo 'erro ao atualizar candidato';
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 29/10/2013 - 09:57
     *
     * @return array Retorna um array de CandidatoVO
     */
    public function buscarPorValidadeVencida(){
        try{

            $stat = $this->conexao->query("SELECT
                                            c.nm_candidato, c.ds_email, c.id_candidato
                                         FROM
                                            candidato c
                                         WHERE
                                            c.dt_validade < now() AND c.qt_lembrete <= 3");

            $array = $stat->fetchAll(PDO::FETCH_CLASS,'CandidatoVO');
            $this->conexao = null;
            return $array;

        }catch(PDOException $e){
            echo 'Erro ao buscar candidato';
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 06/11/2013 - 13:50
     *
     * @param int $id_candidato Recebe o id do candidato
     */
    public function incrementarQtLembrete($id_candidato){
        try{

            $stat = $this->conexao->prepare("update candidato set
                                                qt_lembrete = (qt_lembrete + 1)
                                            where id_candidato = $id_candidato");

            $stat->execute();
            $this->conexao = null;

        }catch(PDOException $e){
            echo 'erro ao atualizar candidato';
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 11/11/2013 - 11:35
     *
     * @param string $cpf Recebe o cpf do candidato
     * @return CandidatoVO Retorna um CandidatoVO
     */
    public function buscarPorNrCpf($cpf){
        try{

            $stat = $this->conexao->query("SELECT
                                            id_candidato,
                                            nm_candidato,
                                            nr_cpf
                                          FROM
                                            candidato
                                          WHERE
                                            nr_cpf = '$cpf'");

            $candidato = $stat->fetchObject('CandidatoVO');
            $this->conexao = null;
            return $candidato;

        }catch(PDOException $e){
            echo 'erro ao buscar candidato';
        }
    }

    /**
     * @author Felipe Stroff <felipe.stroff@canoastec.rs.gov.br>
     * @since 25/07/2014 - 13:59
     *
     * @return array Retorna um array com todas as formacoes.
     */
    public function buscarDadosCandidatoPorId($id_candidato){
        try{
            $stat = $this->conexao->query(" SELECT
                                                c.nr_telefone,
                                                c.nr_celular,
                                                c.ds_email,
                                                c.ds_estado_civil,
                                                c.dt_nascimento,
                                                c.ao_sexo
                                            FROM
                                                candidato c
                                            WHERE
                                                c.id_candidato = $id_candidato ");

            $candidato = $stat->fetchObject('CandidatoVO');
            $this->conexao = null;
            return $candidato;

        }catch(PDOException $e){
            echo 'Erro ao buscar profissão';
        }
    }

    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 02/10/2014 - 15:00
     *
     * @param CandidatoVO $c Recebe um objeto CandidatoVO que será atualizado no BD.
     */
    public function alterarAbas($c){
        $ao_ativo = $c->ao_ativo != 'null' ? var_export($c->ao_ativo,true) : $c->ao_ativo;
        try{
            $sql = "update candidato set
                                                ao_ativo = $ao_ativo,
                                                ao_abaformacao = '$c->ao_abaformacao',
                                                ao_abaqualificacao = '$c->ao_abaqualificacao',
                                                ao_abaexperiencia = '$c->ao_abaexperiencia'
                                            where id_candidato = $c->id_candidato";

            $stat = $this->conexao->prepare($sql);
            $stat->execute();
            $this->conexao = null;

        }catch(PDOException $e){
            echo 'erro ao atualizar candidato';
        }
    }

    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 03/10/2014 - 10:18
     *
     * @param CandidatoVO $c Recebe um objeto CandidatoVO que será atualizado no BD.
     */
    public function alterarStatus($c){
        try{

            $stat = $this->conexao->prepare("update candidato set
                                                ao_ativo = '$c->ao_ativo'
                                            where id_candidato = $c->id_candidato");

            $stat->execute();
            $this->conexao = null;

        }catch(PDOException $e){
            echo 'erro ao atualizar status';
        }
    }
}
?>
