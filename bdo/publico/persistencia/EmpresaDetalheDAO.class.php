<?php
include_once '../modelo/EmpresaDetalheVO.class.php';

class EmpresaDetalheDAO{
    
    //Atributo que recebe a instância de conexão
    private $conexao = null;
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 16/10/2013 - 10:04
     */
    public function __construct(){
        $this->conexao = Conexao::getInstancia();
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 14/10/2013 - 10:05
     * 
     * @param EmpresaDetalheVO $ed Recebe um objeto EmpresaDetalheVO que será inserido no BD.
     * @return boolean Retorna true se cadastrado com exito, caso contrario false
     */
    public function cadastrarEmpresaDetalhe($ed){
        try{
                                                
            $stat = $this->conexao->prepare("INSERT INTO empresadetalhe (
                                                id_empresadetalhe,
                                                nm_proprietario,
                                                ds_cargo,
                                                nr_cpf,
                                                dt_nascimento,
                                                nr_celular,
                                                ds_emailproprietario,
                                                id_empresa,
                                                ao_status,
                                                ao_recrutador
                                            )VALUES(
                                                null,
                                                '$ed->nm_proprietario',
                                                '$ed->ds_cargo',
                                                '$ed->nr_cpf',
                                                $ed->dt_nascimento,
                                                '$ed->nr_celular',
                                                '$ed->ds_emailproprietario',
                                                $ed->id_empresa,
                                                '$ed->ao_status',
                                                '$ed->ao_recrutador'
                                            )");
            
            $stat->execute();
            $this->conexao = null;
            
            //seto para N o ao_liberacao da empresa
            $eDAO = new EmpresaDAO();
            $eDAO->bloquearEmpresa($ed->id_empresa);
            
            return true;

        }catch(PDOException $e){
            return false;
        }
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 16/10/2013 - 11:28
     * 
     * @param int $id_empresa Recebe o id da empresa como filtro para busca
     * @return array Retorna um array com todos os EmpresaDetalheVO de uma empresa
     */
    public function buscarEmpresaDetalhes($id_empresa){
        try{

            $stat = $this->conexao->query("select * from empresadetalhe where id_empresa = $id_empresa order by ao_status asc, nm_proprietario asc");
            $array = $stat->fetchAll(PDO::FETCH_CLASS,'EmpresaDetalheVO');
            $this->conexao = null;
            return $array;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar formacoes';
        }
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 16/10/2013 - 13:35
     * 
     * @param int $id_empresadetalhe Recebe o id do EmpresaDetalheVO como filtro da busca
     * @param int $id_empresa Recebe o id da EmpresaVO como filtro da busca
     * @return EmpresaDetalheVO Retorna um EmpresaDetalheVO
     */
    public function trazerEmpresaDetalhe($id_empresadetalhe,$id_empresa){
        try{
            
            $stat = $this->conexao->query("select * from empresadetalhe where id_empresadetalhe = $id_empresadetalhe and id_empresa = $id_empresa");
            $ed = $stat->fetchObject('EmpresaDetalheVO');
            return $ed;

        }catch(PDOException $e){
            return false;
        }
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 17/10/2013 - 09:54
     * 
     * @param int $id_empresadetalhe Recebe o id do EmpresaDetalheVO que pretende ser atualizado
     * @param int $id_empresa Recebe o id do EmpresaVO logado na sessao
     * @return booleano Retorna true se a busca retornar tiver resultado, caso contrario false 
     */
    public function verificar($id_empresadetalhe, $id_empresa){
        try{
            
            $stat = $this->conexao->query("select id_empresadetalhe from empresadetalhe where id_empresadetalhe = $id_empresadetalhe and id_empresa = $id_empresa");
            
            $qtd = $stat->rowCount();
            
            return $qtd;
            
        }catch(PDOException $e){
            echo false;
        }
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 17/10/2013 - 10:15
     * 
     * @param EmpresaDetalheVO $ed Recebe um objeto EmpresaDetalheVO que será atualizado no BD.
     * @return boolean Retorna true se bem sucessido a alteração.
     */
    public function alterarEmpresaDetalhe($ed){
        try{
           
            $stat = $this->conexao->prepare("update empresadetalhe set 
                                                nm_proprietario = '$ed->nm_proprietario',
                                                ds_cargo = '$ed->ds_cargo',
                                                nr_cpf = '$ed->nr_cpf',
                                                dt_nascimento = $ed->dt_nascimento,
                                                nr_celular = '$ed->nr_celular',
                                                ds_emailproprietario = '$ed->ds_emailproprietario',
                                                ao_status = '$ed->ao_status',
                                                ao_recrutador = '$ed->ao_recrutador'
                                            where id_empresadetalhe = $ed->id_empresadetalhe
                                        ");
            
            $stat->execute();
            $this->conexao = null;
            
            //seto para N o ao_liberacao da empresa
            
            $eDAO = new EmpresaDAO();
            $eDAO->bloquearEmpresa($ed->id_empresa);
            
            return true;
        }catch(PDOException $e){
            return false;
        }
    }
}
?>
