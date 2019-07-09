<?php
include_once '../persistencia/EmpresaDAO.class.php';
include_once '../persistencia/VagaDAO.class.php';
include_once '../util/Validacao.class.php';
include_once '../util/ControleSessao.class.php';
include_once '../persistencia/LogDAO.class.php';

class ControleLoginEmpresa{
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 15/10/2013 - 09:18
     * 
     * Este metodo loga uma empresa na sessao ou destrui a sessao
     * 
     * @param EmpresaVO $e Recebe a empresa a ser logada no sistema.
     */
    public static function acessarSessao($e){
        
        $eDAO = new EmpresaDAO();
        $empresa = $eDAO->verificarEmpresa($e);
        //var_dump($empresa);die;
        if($empresa && !is_null($empresa)){
           
            $aDAO = new AdmissaoDAO();
            $empresa->empresa_admissoes = $aDAO->buscarAdmissoes($empresa->id_empresa);
            
            $vDAO = new VagaDAO();
            $empresa->empresa_vagas = $vDAO->buscarVagasEmpresa($empresa->id_empresa);
            
            ControleSessao::inserirObjeto('privateEmp', $empresa);
            
        }else{
            ControleLoginEmpresa::deslogar();
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 03/10/2013 - 09:19
     * 
     * Desloga a empresa do sistema.
     * 
     */
    public static function deslogar(){
        ControleSessao::destruirSessao();
        header('location:../../');
    }		
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 15/10/2013 - 11:42
     *
     * Verifica se há uma empresa logada.
     * 
     */
    public static function verificarAcesso(){
        if(isset($_SESSION['privateEmp'])){
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 15/10/2013 - 13:22
     * 
     * @param EmpresaVO $e Recebe a empresa a ser logada no sistema.
     */
    public static function logar($e){
        $eDAO = new EmpresaDAO();
        $empresa = $eDAO->verificarEmpresa($e);

        if($empresa && !is_null($empresa)){
            
            if($empresa->ao_interno == 'S'){
                ControleSessao::inserirVariavel('msg','Por favor, altere sua senha para acessar o portal.');
                header('location:../visao/GuiAlterarSenhaEmpresa.php');
            }else{
                
                $aDAO = new AdmissaoDAO();
                $empresa->empresa_admissoes = $aDAO->buscarAdmissoes($empresa->id_empresa);
                
                $vDAO = new VagaDAO();
                $empresa->empresa_vagas = $vDAO->buscarVagasEmpresa($empresa->id_empresa);

                ControleSessao::inserirObjeto('privateEmp',$empresa);
                
                $l = new LogVO();
                $l->id_acesso = $empresa->id_empresa;
                $l->ao_tipo = 'E';
                $l->dt_log = 'now()';
                
                $lDAO = new LogDAO();
                $lDAO->cadastrarLog($l);
                
                $url = 'location:../visao/GuiVagas.php';
                
                if($empresa->ao_liberacao === 'N'){
                    $url = 'location:../visao/GuiManutencaoEmpresa.php';
                }
                
                header($url);
                
            }            
        }else{
            ControleSessao::inserirVariavel('msgEmpresa','Login e/ou Senha incorretos');
            header('location:../../index.php');
        }
    }
}
?>
