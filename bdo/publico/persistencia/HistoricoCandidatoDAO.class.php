<?php
include_once 'Conexao.class.php';
include_once '../modelo/HistoricoCandidatoVO.class.php';
class HistoricoCandidatoDAO{
    
    //Atributo que recebe a instância de conexão
    private $conexao = null;

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 09/12/2013 - 15:08
     * 
     */
    public function __construct(){
        $this->conexao = Conexao::getInstancia();
    }
    
    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 16/09/2014 - 10:14
     * 
     * @param historicoCandidatoVO $hc Recebe um objeto historicoCandidatoVO que será inserido no BD.
     */
    public function cadastrarHistoricoCandidato($hc){
        try{
            $stat = $this->conexao->prepare("INSERT INTO historicocandidato(
                                                id_historico,
                                                id_vagacandidato,
                                                id_usuario,
                                                id_motivo,
                                                ds_motivodispensa,
                                                ao_status,
                                                dt_cadastro
                                             )VALUES(null,
                                                $hc->id_vagacandidato, 
                                                $hc->id_usuario,
                                                $hc->id_motivo,
                                                '$hc->ds_motivodispensa',
                                                '$hc->ao_status',
                                                now()
                                            )");
            
            $stat->execute();
            $this->conexao = null;            
        }catch(PDOException $e){
            echo 'ocorreu em erro ao salvar o histórico';
        }
    }
    
    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 18/09/2014 - 12:59
     * 
     * @return HistoricoCandidatoVO Retorna um array de todos com todos os historicos de um candidato na empresa.
     */
    public function verificarHistoricoCandidatoEmpresa($id_candidato, $id_empresa){
        try{
            $stat = $this->conexao->query(" SELECT 
                                                hc.* 
                                            FROM 
                                                historicocandidato hc
                                                LEFT JOIN vagacandidato vc ON (vc.id_vagacandidato = hc.id_vagacandidato)
                                                LEFT JOIN vaga v ON (v.id_vaga = vc.id_vaga)
                                                LEFT JOIN empresa e ON (e.id_empresa = v.id_empresa)
                                            WHERE 
                                                vc.id_candidato = $id_candidato AND v.id_empresa = $id_empresa");

            $historicoCandidatoEmpresa = $stat->fetchAll(PDO::FETCH_CLASS,'HistoricoCandidatoVO');
            $this->conexao = null;
            return count($historicoCandidatoEmpresa);
            
        }catch(PDOException $e){
            echo 'Erro ao buscar historico';
        }
    }
    
    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 19/09/2014 - 09:37
     * 
     * @return HistoricoCandidatoVO Retorna um array de todos com todos os historicos de um candidato na empresa.
     */
    public function montarHistoricoCandidatoEmpresa($id_candidato, $id_empresa){
        try{
            
            $stat = $this->conexao->query("select hc.id_historico, c.id_candidato,e.nm_fantasia, p.id_profissao, p.nm_profissao, 
                                                c.nm_candidato, hc.id_motivo,
                                                hc.ds_motivodispensa, hc.ao_status, vc.dt_status, hc.dt_cadastro
                                                from candidato c 
                                                join vagacandidato vc on (vc.id_candidato = c.id_candidato)
                                                join vaga v on (vc.id_vaga = v.id_vaga)
                                                join empresa e on (v.id_empresa = e.id_empresa and e.id_empresa = $id_empresa)
                                                join profissao p on (v.id_profissao = p.id_profissao)
                                                join historicocandidato hc on (hc.id_vagacandidato = vc.id_vagacandidato)
                                                left join motivodispensa md on (hc.id_motivo = md.id_motivo)
                                                where 
                                                c.id_candidato = $id_candidato
                                                order by hc.id_historico, vc.dt_status desc");
            
            $historicoCandidatoEmpresa = $stat->fetchAll();
            $this->conexao = null;
            
            return $historicoCandidatoEmpresa;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar historico';
        }
    }
    
    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 25/09/2014 - 14:44
     * 
     * @return HistoricoCandidatoVO Retorna um array de todos com todos os historicos de um candidato na empresa.
     *
    public function buscarHistoricoCandidatoCompleto($id_candidato){
        try{
            $stat = $this->conexao->query(" select 
                                            hc.id_historico, hc.id_motivo, hc.ds_motivodispensa, hc.ao_status, hc.dt_cadastro, 
                                            vc.id_candidato, v.id_vaga, 
                                            e.id_empresa, e.nm_fantasia, 
                                            p.id_profissao, p.nm_profissao
                                                    from historicocandidato hc
                                                    join vagacandidato vc ON (hc.id_vagacandidato = vc.id_vagacandidato)
                                                    join vaga v ON (vc.id_vaga = v.id_vaga)
                                                    join empresa e ON (v.id_empresa = e.id_empresa)
                                                    join profissao p ON (v.id_profissao = p.id_profissao)
                                                    left join motivodispensa md ON (hc.id_motivo = md.id_motivo)
                                            where
                                            vc.id_candidato = $id_candidato
                                            order by hc.id_historico, hc.dt_cadastro desc ");

            $historicoCandidatoEmpresa = $stat->fetchAll();
            $this->conexao = null;
            return $historicoCandidatoEmpresa;
            
        }catch(PDOException $e){
            echo 'Erro ao buscar historico';
        }
    }*/
    
}
?>
