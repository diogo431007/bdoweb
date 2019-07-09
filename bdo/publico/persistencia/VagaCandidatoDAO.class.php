<?php
include_once '../modelo/VagaCandidatoVO.class.php';
class VagaCandidatoDAO{
    
    private $conexao = null;
    
    public function __construct(){
        $this->conexao = Conexao::getInstancia();
    }
    
   /*
    * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
    * @since 09/04/2014 - 15:16
    * 
    * @param int $id_vaga Recebe o id da vaga
    * @return array Retorna um array de CandidatoVO
    */
    public function buscarTodosCandidatos($id_vaga, $query=''){
        try{
            
           $stat = $this->conexao->query(" SELECT
                                                c.id_candidato, 
                                                c.nm_candidato, 
                                                c.nr_telefone, 
                                                c.nr_celular,
                                                c.ds_email, 
                                                c.id_deficiencia, 
                                                c.ao_sexo, 
                                                vc.*
                                            FROM
                                                candidato c,
                                                vagacandidato vc
                                            WHERE
                                                c.id_candidato = vc.id_candidato
                                                AND vc.id_vaga = $id_vaga
                                                $query
                                            ORDER BY
                                                vc.ao_status ASC,
                                                vc.dt_status DESC");
           
            $array = $stat->fetchAll(PDO::FETCH_CLASS, 'VagaCandidatoVO');
            $this->conexao = null;
            return $array;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar candidatos';
        }
   }
    
   /*
    * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
    * @since 13/03/2015 - 10:31
    * 
    * @param int $id_vaga Recebe o id da vaga
    * @return array Retorna um array de CandidatoVO
    */
    public function buscarCandidatosTodos($id_vaga, $query=''){
        try{
            
           $stat = $this->conexao->query(" SELECT
                                                c.id_candidato, 
                                                c.nm_candidato, 
                                                c.nr_telefone, 
                                                c.nr_celular,
                                                c.ds_email, 
                                                c.id_deficiencia, 
                                                c.ao_sexo, 
                                                vc.*
                                            FROM
                                                candidato c,
                                                vagacandidato vc
                                            WHERE
                                                c.id_candidato = vc.id_candidato
                                                AND vc.id_vaga = $id_vaga
                                            ORDER BY
                                                vc.ao_status ASC,
                                                vc.dt_status DESC");
           
            $array = $stat->fetchAll(PDO::FETCH_CLASS, 'VagaCandidatoVO');
            $this->conexao = null;
            return $array;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar candidatos';
        }
   }
   
    /*
    * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
    * @since 29/12/2014 - 09:38
    * 
    * @param int $id_vaga Recebe o id da vaga
    * @return array Retorna um array de CandidatoVO
    */
    public function buscarCandidatosEncaminhados($id_vaga, $query=''){
        try{
            
           $stat = $this->conexao->query(" SELECT
                                                c.id_candidato, 
                                                c.nm_candidato, 
                                                c.nr_telefone, 
                                                c.nr_celular,
                                                c.ds_email, 
                                                c.id_deficiencia, 
                                                c.ao_sexo, 
                                                vc.*
                                            FROM
                                                candidato c,
                                                vagacandidato vc
                                            WHERE
                                                c.id_candidato = vc.id_candidato
                                                AND vc.id_vaga = $id_vaga
                                                AND vc.ao_status = 'E'
                                            ORDER BY
                                                vc.ao_status ASC,
                                                vc.dt_status DESC");
           
            $array = $stat->fetchAll(PDO::FETCH_CLASS, 'VagaCandidatoVO');
            $this->conexao = null;
            return $array;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar candidatos encaminhados';
        }
   }
   
    /*
    * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
    * @since 29/12/2014 - 09:38
    * 
    * @param int $id_vaga Recebe o id da vaga
    * @return array Retorna um array de CandidatoVO
    */
    public function buscarCandidatosBaixasAutomaticas($id_vaga, $query=''){
        try{
            
           $stat = $this->conexao->query(" SELECT
                                                c.id_candidato, 
                                                c.nm_candidato, 
                                                c.nr_telefone, 
                                                c.nr_celular,
                                                c.ds_email, 
                                                c.id_deficiencia, 
                                                c.ao_sexo, 
                                                vc.*
                                            FROM
                                                candidato c,
                                                vagacandidato vc
                                            WHERE
                                                c.id_candidato = vc.id_candidato
                                                AND vc.id_vaga = $id_vaga
                                                AND vc.ao_status = 'B'
                                            ORDER BY
                                                vc.ao_status ASC,
                                                vc.dt_status DESC");
           
            $array = $stat->fetchAll(PDO::FETCH_CLASS, 'VagaCandidatoVO');
            $this->conexao = null;
            return $array;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar candidatos com baixas automáticas';
        }
   }
   
    /*
    * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
    * @since 26/12/2014 - 17:07
    * 
    * @param int $id_vaga Recebe o id da vaga
    * @return array Retorna um array de CandidatoVO
    */
    public function buscarCandidatosPreSelecionados($id_vaga, $query=''){
        try{
            
           $stat = $this->conexao->query(" SELECT
                                                c.id_candidato, 
                                                c.nm_candidato, 
                                                c.nr_telefone, 
                                                c.nr_celular,
                                                c.ds_email, 
                                                c.id_deficiencia, 
                                                c.ao_sexo, 
                                                vc.*
                                            FROM
                                                candidato c,
                                                vagacandidato vc
                                            WHERE
                                                c.id_candidato = vc.id_candidato
                                                AND vc.id_vaga = $id_vaga
                                                AND vc.ao_status = 'P'
                                            ORDER BY
                                                vc.ao_status ASC,
                                                vc.dt_status DESC");
           
            $array = $stat->fetchAll(PDO::FETCH_CLASS, 'VagaCandidatoVO');
            $this->conexao = null;
            return $array;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar candidatos pré-selecionados';
        }
   }

    /*
    * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
    * @since 26/12/2014 - 17:23
    * 
    * @param int $id_vaga Recebe o id da vaga
    * @return array Retorna um array de CandidatoVO
    */
    public function buscarCandidatosContratados($id_vaga, $query=''){
        try{
            
           $stat = $this->conexao->query(" SELECT
                                                c.id_candidato, 
                                                c.nm_candidato, 
                                                c.nr_telefone, 
                                                c.nr_celular,
                                                c.ds_email, 
                                                c.id_deficiencia, 
                                                c.ao_sexo, 
                                                vc.*
                                            FROM
                                                candidato c,
                                                vagacandidato vc
                                            WHERE
                                                c.id_candidato = vc.id_candidato
                                                AND vc.id_vaga = $id_vaga
                                                AND vc.ao_status = 'C'
                                            ORDER BY
                                                vc.ao_status ASC,
                                                vc.dt_status DESC");
           
            $array = $stat->fetchAll(PDO::FETCH_CLASS, 'VagaCandidatoVO');
            $this->conexao = null;
            return $array;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar candidatos contratados';
        }
   }
   
   /*
    * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
    * @since 26/12/2014 - 17:45
    * 
    * @param int $id_vaga Recebe o id da vaga
    * @return array Retorna um array de CandidatoVO
    */
    public function buscarCandidatosDispensados($id_vaga, $query=''){
        try{
            
           $stat = $this->conexao->query(" SELECT
                                                c.id_candidato, 
                                                c.nm_candidato, 
                                                c.nr_telefone, 
                                                c.nr_celular,
                                                c.ds_email, 
                                                c.id_deficiencia, 
                                                c.ao_sexo, 
                                                vc.*
                                            FROM
                                                candidato c,
                                                vagacandidato vc
                                            WHERE
                                                c.id_candidato = vc.id_candidato
                                                AND vc.id_vaga = $id_vaga
                                                AND vc.ao_status = 'D'
                                            ORDER BY
                                                vc.ao_status ASC,
                                                vc.dt_status DESC");
           
            $array = $stat->fetchAll(PDO::FETCH_CLASS, 'VagaCandidatoVO');
            $this->conexao = null;
            return $array;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar candidatos dispensados';
        }
   }
   
   /*
    * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
    * @since 11/04/2014 - 10:16
    * 
    * @param VagaCandidatoVO $vc Recebe a VagaCandidatoVO
    */
    public function alterarStatus($vc){
        try{
            
            $stat = $this->conexao->prepare("update vagacandidato set 
                                                ao_status = '$vc->ao_status',
                                                dt_status = '$vc->dt_status'
                                            where id_vagacandidato = $vc->id_vagacandidato
                                        ");
            
            $stat->execute();
            $this->conexao = null;
            
        }catch(PDOException $e){
            echo 'erro ao atualizar candidato';
        }
    }
    
    /*
    * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
    * @since 10/03/2015 - 17:18
    * 
    * @param VagaCandidatoVO $vc Recebe a VagaCandidatoVO
    */
    public function contratarDireto($id_vagacandidato){
        try{            
            $stat = $this->conexao->prepare("update vagacandidato set 
                                                ao_status = 'C',
                                                dt_status = now()
                                            where id_vagacandidato = $id_vagacandidato
                                        ");
            
            $stat->execute();
            $this->conexao = null;
            
        }catch(PDOException $e){
            echo 'erro ao atualizar candidato';
        }
    }
    
    
    
    
       /*
    * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
    * @since 12/02/2015 - 14:14
    * 
    * @param VagaCandidatoVO $vc Recebe a VagaCandidatoVO
    */
    public function salvarLogInterno($vc){
        try{
            
            $stat = $this->conexao->prepare("INSERT INTO vagacandidatologinterno (
                                                id_vagacandidatologinterno,
                                                id_vagacandidato,
                                                id_internousuario,
                                                ao_status,
                                                dt_vagacandidatologinterno
                                             )VALUES(
                                                null,
                                                '$vc->id_vagacandidato',
                                                '$vc->id_interno',
                                                '$vc->ao_status',
                                                now()
                                             )");
            
                                    
            $stat->execute();
            $this->conexao = null;
            
        }catch(PDOException $e){
            echo 'erro ao cadastrar o log do interno';
        }
    }
    
    /*
    * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
    * @since 01/08/2014 - 10:12
    * 
    * @param int $id_vaga Recebe o id da vaga
    * @return array Retorna um array de CandidatoVO
    */
    public function montarListaEncaminhados($id_vaga){
        try{

           $stat = $this->conexao->query(" SELECT 
                                               vc.*,
                                               c.nm_candidato,
                                               c.nr_telefone,
                                               c.ds_email
                                            FROM 
                                               candidato c
                                               JOIN vagacandidato vc ON (c.id_candidato = vc.id_candidato)
                                            WHERE
                                               vc.id_vaga = $id_vaga
                                            ORDER BY 
                                               vc.ao_status ASC,
                                               c.nm_candidato ASC");
           
           function montarEncaminhado($id_vagacandidato, $id_vaga, $id_candidato, $ao_status, $dt_status, $nm_candidato,
                                        $nr_telefone, $ds_email){
               
                $vc = new VagaCandidatoVO();
                $vc->id_vagacandidato = $id_vagacandidato;
                $vc->id_candidato = $id_candidato;
                $vc->id_vaga = $id_vaga;
                $vc->ao_status = $ao_status;
                $vc->dt_status = $dt_status;
                
                $c = new CandidatoVO();
                $c->nm_candidato = $nm_candidato;
                $c->nr_telefone = $nr_telefone;
                $c->ds_email = $ds_email;
                
                $vc->candidato = $c;
                
                return $vc;
           }

           $array = $stat->fetchAll(PDO::FETCH_FUNC,'montarEncaminhado');
           $this->conexao = null;
           return $array;

       }catch(PDOException $e){
           echo 'Erro ao buscar candidatos';
       }
   }
   
    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 25/09/2014 - 14:44
     * 
     * @return VagaCandidatoVO Retorna um array dos ultimos status de vagacandidato.
     */
    public function buscarUltimaAtualizacaoCandidato($id_candidato){
        try{
            $stat = $this->conexao->query(" select 
                                                vc.id_candidato, vc.ao_status, vc.dt_status, v.id_vaga, p.id_profissao, p.nm_profissao, 
                                                e.id_empresa, e.nm_fantasia
                                            from vagacandidato vc 
                                                join vaga v ON (vc.id_vaga = v.id_vaga)
                                                join empresa e ON (v.id_empresa = e.id_empresa)
                                                join profissao p ON (v.id_profissao = p.id_profissao)
                                            where
                                                vc.id_candidato = $id_candidato
                                            order by vc.dt_status desc ");                       
            
            $historicoCandidatoEmpresa = $stat->fetchAll();
            $this->conexao = null;
            return $historicoCandidatoEmpresa;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar historico';
        }
    }
   
}
?>
