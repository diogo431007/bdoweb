<?php
include_once '../persistencia/Conexao.class.php';
include_once '../modelo/EmpresaVO.class.php';
class EmpresaDAO{
    
    //Atributo que recebe a instância de conexão
    private $conexao = null;

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 14/10/2013 - 15:00
     */
    public function __construct(){
        $this->conexao = Conexao::getInstancia();
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 14/10/2013 - 15:01
     * 
     * @param EmpresaVO $e Recebe um objeto EmpresaVO que será inserido no BD.
     * @return int Retorna o id gerado na insercao
     */
    public function cadastrarEmpresa($e){
        try{
            
            $stat = $this->conexao->prepare("insert into empresa(
                                                id_empresa, 
                                                nm_razaosocial, 
                                                nm_fantasia, 
                                                nr_cnpj, 
                                                nm_contato, 
                                                nr_telefoneempresa, 
                                                nr_cep, 
                                                ds_logradouro, 
                                                nr_logradouro, 
                                                ds_bairro, 
                                                ds_complemento, 
                                                id_cidade, 
                                                ds_email, 
                                                ds_site, 
                                                nr_inscricaoestadual, 
                                                nr_inscricaomunicipal, 
                                                dt_fundacao, 
                                                ao_liberacao,
                                                pw_senhaportal,
                                                ao_interno,
                                                id_ramoatividade,
                                                id_empresatipo,
                                                id_quantidadefuncionario,
                                                dt_cadastro,
                                                nm_proprietario,
                                                ds_cargo,
                                                nr_cpf,
                                                dt_nascimento,
                                                nr_celular,
                                                ds_emailproprietario,
                                                ao_status,
                                                ao_recrutador,
                                                id_microregiao,
                                                id_poligono
                                             )
                                             values(
                                                    null,
                                                    '$e->nm_razaosocial',
                                                    '$e->nm_fantasia',
                                                    '$e->nr_cnpj',
                                                    '$e->nm_contato',
                                                    '$e->nr_telefoneempresa',
                                                    '$e->nr_cep',
                                                    '$e->ds_logradouro',
                                                    $e->nr_logradouro,
                                                    '$e->ds_bairro',
                                                    '$e->ds_complemento',
                                                    $e->id_cidade,
                                                    '$e->ds_email',
                                                    '$e->ds_site',
                                                    '$e->nr_inscricaoestadual',
                                                    '$e->nr_inscricaomunicipal',
                                                    $e->dt_fundacao,
                                                    '$e->ao_liberacao',
                                                    '$e->pw_senhaportal',
                                                    '$e->ao_interno',
                                                    $e->id_ramoatividade,
                                                    $e->id_empresatipo,
                                                    $e->id_quantidadefuncionario,
                                                    now(),
                                                    '$e->nm_proprietario',
                                                    '$e->ds_cargo',
                                                    '$e->nr_cpf',
                                                    $e->dt_nascimento,
                                                    '$e->nr_celular',
                                                    '$e->ds_emailproprietario',
                                                    '$e->ao_status',
                                                    '$e->ao_recrutador',
                                                    $e->id_microregiao,
                                                    $e->id_poligono
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
     * @version Banco de Oportunidades 2.0
     * @since 15/10/2013 - 09:14
     * 
     * @param EmpresaVO $e Recebe a empresa para verificar login e senha
     * @return EmpresaVO Retorna uma EmpresaVO
     */
    public function verificarEmpresa($e){
        try{
            
            $stat = $this->conexao->query("select * from empresa where ds_email = '$e->ds_email' and pw_senhaportal = '$e->pw_senhaportal'");
            $empresa = $stat->fetchObject('EmpresaVO');
            return $empresa;

        }catch(PDOException $e){
            echo 'erro ao verificar empresa no banco';
        }
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 15/10/2013 - 11:46
     * 
     * @param EmpresaVO $e Recebe um objeto EmpresaVO que será atualizado no BD.
     * @return boolean Retorna true se bem sucessido a alteração.
     */
    public function alterarEmpresa($e){
        try{
            
            $stat = $this->conexao->prepare("update empresa set 
                                                nm_razaosocial = '$e->nm_razaosocial', 
                                                nm_fantasia = '$e->nm_fantasia', 
                                                nm_contato = '$e->nm_contato', 
                                                nr_telefoneempresa = '$e->nr_telefoneempresa', 
                                                nr_cep = '$e->nr_cep', 
                                                ds_logradouro = '$e->ds_logradouro', 
                                                nr_logradouro = $e->nr_logradouro, 
                                                ds_bairro = '$e->ds_bairro', 
                                                ds_complemento = '$e->ds_complemento', 
                                                id_cidade = $e->id_cidade, 
                                                ds_email = '$e->ds_email', 
                                                ds_site = '$e->ds_site', 
                                                nr_inscricaoestadual = '$e->nr_inscricaoestadual', 
                                                nr_inscricaomunicipal = '$e->nr_inscricaomunicipal', 
                                                dt_fundacao = $e->dt_fundacao,
                                                ao_liberacao = '$e->ao_liberacao',
                                                id_ramoatividade = $e->id_ramoatividade,
                                                id_empresatipo = $e->id_empresatipo,
                                                id_quantidadefuncionario = $e->id_quantidadefuncionario,
                                                nm_proprietario = '$e->nm_proprietario',
                                                ds_cargo = '$e->ds_cargo',
                                                nr_cpf = '$e->nr_cpf',
                                                dt_nascimento = $e->dt_nascimento,
                                                nr_celular = '$e->nr_celular',
                                                ds_emailproprietario = '$e->ds_emailproprietario',
                                                ao_status = '$e->ao_status',
                                                ao_recrutador = '$e->ao_recrutador',
                                                id_microregiao = $e->id_microregiao,
                                                id_poligono = $e->id_poligono
                                            where id_empresa = $e->id_empresa
                                        ");
            
            $stat->execute();
            $this->conexao = null;
            return true;
        }catch(PDOException $e){
            return false;
        }
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 17/10/2013 - 11:58
     * 
     * @param EmpresaVO $e Recebe um objeto EmpresaVO para mudar a senha
     */
    public function alterarSenha($e){
        try{
            
            $stat = $this->conexao->prepare("update empresa set 
                                                pw_senhaportal = '$e->pw_senhaportal',
                                                ao_interno = '$e->ao_interno'
                                            where id_empresa = $e->id_empresa");
            
            $stat->execute();
            $this->conexao = null;
            
        }catch(PDOException $e){
            echo 'erro ao atualizar candidato';
        }
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 17/10/2013 - 14:14
     * 
     * @param EmpresaVO $e Recebe uma empresa para verificar pelo email e a senha se esta cadastrado no banco
     * @return EmpresaVO Retorna um EmpresaVO
     */
    public function verificarNrCnpj($e){
        try{
            
            $stat = $this->conexao->query("select * from empresa where nr_cnpj = '$e->nr_cnpj' and ds_email = '$e->ds_email'");

            $empresa = $stat->fetchObject('EmpresaVO');
            return $empresa;

        }catch(PDOException $e){
            echo false;
        }
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 24/10/2013 - 10:57
     * 
     * @param string $login Recebe um login
     * @param string $cnpj Recebe um cnpj
     * @return boolean Retorna true se o login nao estiver cadastrado no banco
     */
    public function verificarLogin($login,$cnpj){
        try{
            
            $stat = $this->conexao->query("select 1 from empresa where ds_email = '$login' or nr_cnpj = '$cnpj'");
            $qtd = $stat->rowCount();
            
            if($qtd > 0){
                return false;
            }else{
                return true;
            }
            
        }catch(PDOException $e){
            echo 'erro ao verificar empresa no banco';
        }
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 18/11/2013 - 11:05
     * 
     * @param int $id_empresa Recebe o id da empresa que necessita nova moderação
     */
    public function bloquearEmpresa($id_empresa){
        try{
            
            $stat = $this->conexao->prepare("update empresa set 
                                                ao_liberacao = 'N'
                                            where id_empresa = $id_empresa
                                        ");
            
            $stat->execute();
            $this->conexao = null;
            
        }catch(PDOException $e){
            echo 'erro';
        }
    }
    
    /**
     * @author Ricardo K. cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @author Alisson vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 19/09/2014 - 11:37
     * 
     * @param EmpresaVO $e Recebe uma empresa para verificar pelo email e a senha se esta cadastrado no banco
     * @return EmpresaVO Retorna um EmpresaVO
     */
    public function buscarEmpresa($id){
        try{
            
            $stat = $this->conexao->query("select e.* from empresa e where e.id_empresa = $id");

            $empresa = $stat->fetchObject('EmpresaVO');
            return $empresa;

        }catch(PDOException $e){
            echo false;
        }
    }
}
?>