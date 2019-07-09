<?php
include_once '../util/Validacao.class.php';
include_once '../util/ControleSessao.class.php';
include_once '../persistencia/LogDAO.class.php';

class ControleLoginCandidato{
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 24/09/2013 - 13:36
     * 
     * Este metodo loga um candidato na sessao ou destrui a sessao
     * 
     * @param CandidatoVO $c Recebe o candidato a ser logado no sistema.
     */
    public static function acessarSessao($c){
        $cDAO = new CandidatoDao();
        $candidato = $cDAO->verificarCandidato($c);
        
        if($candidato && !is_null($candidato)){
            $cfDAO = new CandidatoFormacaoDAO();
            $candidato->formacoes = $cfDAO->buscarCandidatoFormacoes($candidato->id_candidato);
            
            $cqDAO = new CandidatoQualificacaoDAO();
            $candidato->qualificacoes = $cqDAO->buscarCandidatoQualificacoes($candidato->id_candidato);
            
            $ceDAO = new CandidatoExperienciaDAO();
            $candidato->experiencias = $ceDAO->buscarCandidatoExperiencias($candidato->id_candidato);
                        
            $cp = new CandidatoProfissaoDAO();
            $candidato->profissoes = $cp->buscarCandidatoProfissoes($candidato->id_candidato);            
            
            ControleSessao::inserirObjeto('privateCand',$candidato);
            
        }else{
            ControleLoginCandidato::deslogar();
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 03/10/2013 - 09:15
     * 
     * Desloga o candidato do sistema.
     */
    public static function deslogar(){
        ControleSessao::destruirVariavel('privateCand');
        ControleSessao::destruirSessao();
        header('location:../../');
    }		
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 24/09/2013 - 13:42
     *
     * Verifica se há um candidato logado. 
     */
    public static function verificarAcesso(){
        if(isset($_SESSION['privateCand'])){
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 09/10/2013 - 09:44
     * 
     * @param CandidatoVO $c Recebe o candidato a ser logado no sistema.
     */
    public static function logar($c){
        $cDAO = new CandidatoDao();
        $candidato = $cDAO->verificarCandidato($c);

        if($candidato && !is_null($candidato)){
            
            //busco as formacoes do candidato
            $cfDAO = new CandidatoFormacaoDAO();
            $candidato->formacoes = $cfDAO->buscarCandidatoFormacoes($candidato->id_candidato);
            
            //busco as qualificacoes do candidato
            $cqDAO = new CandidatoQualificacaoDAO();
            $candidato->qualificacoes = $cqDAO->buscarCandidatoQualificacoes($candidato->id_candidato);
            
            //busco as experiencias do candidato
            $ceDAO = new CandidatoExperienciaDAO();
            $candidato->experiencias = $ceDAO->buscarCandidatoExperiencias($candidato->id_candidato);
            
            $cp = new CandidatoProfissaoDAO();
            $candidato->profissoes = $cp->buscarCandidatoProfissoes($candidato->id_candidato);
            
            //atualizo a validade do candidato
            $cDAO = new CandidatoDao();
            $cDAO->atualizarValidade($candidato->id_candidato);
            
            $l = new LogVO();
            $l->id_acesso = $candidato->id_candidato;
            $l->ao_tipo = 'C';
            $l->dt_log = 'now()';
            
            $lDAO = new LogDAO();
            $lDAO->cadastrarLog($l);
            
            if($candidato->ao_interno == 'N'){
                ControleSessao::inserirObjeto('privateCand',$candidato);
                header('location:../visao/GuiManutencaoCandidato.php');
            }else{
                ControleSessao::inserirVariavel('msg','Por favor, altere sua senha para acessar o portal.');
                header('location:../visao/GuiAlterarSenhaCandidato.php');
            }
            
        }else{
            ControleSessao::inserirVariavel('msg','Login e/ou Senha incorretos');
            header('location:../../index.php');
        }
    }
	
}
?>
