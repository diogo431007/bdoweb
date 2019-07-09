<?php
include_once '../modelo/AdmissaoVO.class.php';
class AdmissaoDAO{
    
    //Atributo que recebe a instância de conexão
    private $conexao = null;
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 11/11/2013 - 13:04
     */
    public function __construct(){
        $this->conexao = Conexao::getInstancia();
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 11/11/2013 - 13:07
     * 
     * @param AdmissaoVO $a Recebe um objeto AdmissaoVO que será inserido no BD.
     * @return boolean Retorna true se cadastrado com exito, caso contrario false
     */
    public function cadastrarAdmissao($a){
        try{
            
            $stat = $this->conexao->prepare("INSERT INTO admissao (
                                                id_admissao,
                                                id_candidato,
                                                id_empresa,
                                                ds_cargo,
                                                dt_admissao
                                            )VALUES(
                                                null,
                                                $a->id_candidato,
                                                $a->id_empresa,
                                                '$a->ds_cargo',
                                                $a->dt_admissao
                                            )");
            
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
     * @since 16/10/2013 - 11:28
     * 
     * @param int $id_empresa Recebe o id da empresa como filtro para busca
     * @return array Retorna um array com todos as AdmissaoVO de uma empresa
     */
    public function buscarAdmissoes($id_empresa){
        try{

            //$stat = $this->conexao->query("select * from admissao where id_empresa = $id_empresa");
            $stat = $this->conexao->query("SELECT 
                                                a.id_admissao,
                                                a.id_candidato,
                                                a.id_empresa,
                                                a.ds_cargo,
                                                DATE_FORMAT(a.dt_admissao, '%d/%m/%Y') as dt_admissao,
                                                c.nm_candidato,
                                                c.nr_cpf
                                           FROM 
                                                admissao a,
                                                candidato c
                                           WHERE 
                                                a.id_candidato = c.id_candidato and
                                                id_empresa = $id_empresa
                                           ORDER BY a.dt_admissao DESC");
            $array = $stat->fetchAll(PDO::FETCH_CLASS,'AdmissaoVO');
            $this->conexao = null;
            return $array;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar admissoes';
        }
    }
    
//    public function buscarDadosAdmitido($id_admissao){
//        try{
//            
//            $stat = $this->conexao->query("select * from admissao where id_admissao = $id_admissao");
//            $a = $stat->fetchObject('AdmissaoVO');
//            $this->conexao = null;
//            return $a;
//            
//        }catch(PDOException $e){
//            echo 'Erro ao buscar admissoes';
//        }
//    }
    
}
?>
