<?php
include_once '../persistencia/EstadoDAO.class.php';
include_once '../persistencia/CidadeDAO.class.php';
include_once '../persistencia/BairroDAO.class.php';
include_once '../persistencia/CboDAO.class.php';
include_once '../persistencia/DeficienciaDAO.class.php';
include_once '../persistencia/FormacaoDAO.class.php';
include_once '../persistencia/RamoAtividadeDAO.php';
include_once '../persistencia/EmpresaTipoDAO.class.php';
include_once '../persistencia/QuantidadeFuncionarioDAO.class.php';
include_once '../persistencia/AreaDAO.class.php';
include_once '../persistencia/SubareaDAO.class.php';
include_once '../persistencia/ProfissaoDAO.class.php';
include_once '../persistencia/CandidatoFormacaoDAO.class.php';
include_once '../persistencia/CandidatoDAO.class.php';
include_once '../persistencia/CandidatoQualificacaoDAO.class.php';
include_once '../persistencia/CandidatoExperienciaDAO.class.php';
include_once '../persistencia/CandidatoProfissaoDAO.class.php';
include_once '../persistencia/MotivoDAO.class.php';
include_once '../persistencia/HistoricoCandidatoDAO.class.php';
include_once '../persistencia/VagaCandidatoDAO.class.php';
include_once '../persistencia/VagaAdicionalDAO.class.php';
include_once '../persistencia/VagaBeneficioDAO.class.php';
include_once '../persistencia/VagaFormacaoDAO.class.php';
include_once '../persistencia/AdicionalDAO.class.php';
include_once '../persistencia/BeneficioDAO.class.php';

class Servicos{

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 27/09/2013 - 14:40
     * @version Banco de Oportunidades 2.0
     *
     * @return array Retorna um array de EstadoVO
     */
    public static function buscarEstadosPorSg(){
        $estadosSg = array();
        $eDAO = new EstadoDao();
        $estadosSg = $eDAO->buscarEstados('order by sg_estado asc');
        return $estadosSg;
    }

    /**
     * @author RicardoK.Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 20/03/2014 - 11:50
     *
     * @return AreaVO Retorna um AreaVO
     */
    public static function buscarAreaPorId($id_area){
        if(is_numeric($id_area)){
            $aDAO = new AreaDAO();
            $area = $aDAO->buscarAreaPorId($id_area);
            return $area;
        }else{
            return null;
        }
    }

    /**
     * @author Douglas Carlos <douglas.carlos@canoastec.rs.gov.br>
     * @since 31/03/2014 - 13:13
     *
     * @return ProfissaoVO Retorna um array de ProfissaoVO
     */
    public static function buscarProfissoes($ao_ativo='S'){
        $query = "and ao_ativo = '$ao_ativo'";
        $pDAO = new ProfissaoDAO();
        $profissoes = $pDAO->buscarProfissoes($query);
        return $profissoes;
    }

    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 20/03/2014 - 11:52
     *
     * @return ModeloVO Retorna um ModeloVO
     */
    public static function buscarSubareaPorId($id_subarea){
        if(is_numeric($id_subarea)){
            $saDAO = new SubareaDAO();
            $subarea = $saDAO->buscarSubareaPorId($id_subarea);
            return $subarea;
        }else{
            return null;
        }
    }

    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 04/05/2015 - 11:04
     * @version Banco de Oportunidades 2.0
     *
     * @param String $id_candidato Recebe o id do candidato como filtro para busca
     * @return int Retorna as profissões diferentes ao candidato
    */
    public static function buscarProfissoesPorIdCandidatoNaoCadastrada($id_candidato){
        $pDAO = new ProfissaoDAO();
        $profissoes = $pDAO->buscarProfissoesPorIdCandidatoNaoCadastradas($id_candidato);
        return $profissoes;
    }

    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 04/05/2015 - 15:50
     * @version Banco de Oportunidades 2.0
     *
     * @param String $id_candidato Recebe o id do candidato como filtro para busca
     * @param String $id_profissao Recebe o id da profissão como filtro para busca
    */
    public static function deletarProfissaoPorIdCandidato($id_candidato, $id_profissao){
        $pDAO = new ProfissaoDAO();
        $profissoes = $pDAO->buscarProfissoesPorIdCandidatoNaoCadastradas($id_candidato);
        return $profissoes;
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 27/09/2013 - 14:50
     * @version Banco de Oportunidades 2.0
     *
     * @return array Retorna um array de EstadoVO
     */
    public static function buscarEstadosPorNm(){
        $eDAO = new EstadoDAO();
        $estadosNm = $eDAO->buscarEstados('order by nm_estado asc');
        return $estadosNm;
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 27/09/2013 - 15:00
     * @version Banco de Oportunidades 2.0
     *
     * @param String $id_estado Recebe o id do estado como filtro para buscar as cidades.
     * @return array Retorna um array de CidadeVO.
     */
    public static function buscarCidadesPorIdEstado($id_estado){
        $cDAO = new CidadeDAO();
        $cidades = $cDAO->buscarCidadesPorIdEstado($id_estado);
        return $cidades;
    }

     /**
     * @author Giuseppe Menti <giuseppe.menti@canoastec.rs.gov.br>
     * @since 04/05/2015 - 11:05
     * @version Banco de Oportunidades 1.1
     *
     * @param String $id_cidade Recebe o id da cidade como filtro para buscar os bairros.
     * @return array Retorna um array de VO.
     */
       public static function buscarBairrosPorIdCidade($id_cidade){
        $bairros = array();
        $bDAO = new BairroDAO();
        $bairros = $bDAO->buscarBairrosPorIdCidade($id_cidade);
        return $bairros;
    }

    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 16/03/2015 - 16:57
     * @version Banco de Oportunidades 2.0
     *
     * @param String $id_estado Recebe o id da deficiêcia como filtro para buscar os cids.
     * @return array Retorna um array de DeficienciaCidVO.
    */
    public static function buscarCidsPorIdDeficiencia($id_deficiencia){
        $cids = array();
        $cDAO = new DeficienciaCidDao();
        $cids = $cDAO->buscarCidsPorIdDeficiencia($id_deficiencia);
        return $cids;
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 30/09/2013 - 09:55
     * @version Banco de Oportunidades 2.0
     *
     * @param String $query Recebe o filtro da busca.
     * @return String Retorna uma String contendo as cbo na tag li.
     */
    public static function buscarCboComFiltro($query){
        $query = utf8_decode($query);
        $cbos = array();
        $cDAO = new CboDao();
        $cbos = $cDAO->buscarCbos($query);
        $li = '';
        foreach ($cbos as $c) {
            $li .= '<li class="style3" onClick="fill(\''.$c->id_cbo.'\', \''.$c->nm_cbo.'\');">'.$c->nm_cbo.'</li>';
        }
        return utf8_encode($li);
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 30/09/2013 - 10:15
     * @version Banco de Oportunidades 2.0
     *
     * @return array Retorna um array de DeficienciaVO.
     */
    public static function buscarDeficiencias(){
        $deficiencias = array();
        $dDAO = new DeficienciaDao();
        $deficiencias = $dDAO->buscarDeficiencias();
        return $deficiencias;
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 30/09/2013 - 10:25
     * @version Banco de Oportunidades 2.0
     *
     * @return array Retorna um array de FormacaoVO.
     */
    public static function buscarFormacoes(){
        $formacoes = array();
        $fDAO = new FormacaoDao();
        $formacoes = $fDAO->buscarFormacoes();
        return $formacoes;
    }

    /**
     * @author Ricardo K.Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 20/03/2014 - 08:32
     * @version Banco de Oportunidades 2.0
     *
     * @return array Retorna um array de AreaVO.
     */
    public static function buscarAreas(){
        $areas = array();
        $aDAO = new AreaDAO();
        $areas = $aDAO->buscarAreas();
        return $areas;
    }

    /**
     * @author Ricardo K. Cruz<ricardo.cruz@canoastec.rs.gov.br>
     * @since 20/03/2014 - 09:53
     * @version Banco de Oportunidades 2.0
     *
     * @param String $id_area Recebe o id da area como filtro para buscar as subareas.
     * @return array Retorna um array de SubareaVO.
     */
    public static function buscarSubareasPorIdArea($id_area){
        if(is_numeric($id_area)){
            $subarea = array();
            $saDAO = new SubareaDAO();
            $subarea = $saDAO->buscarSubareaPorIdArea($id_area);
            return $subarea;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 02/10/2013 - 10:13
     * @version Banco de Oportunidades 2.0
     *
     * @param int $id Recebe o id do cbo
     * @return CboVO Retorna um CboVO
     */
    public static function buscarCboEspecifica($id){
        $cDAO = new CboDao();
        $c = $cDAO->buscarCboEspecifica($id);
        return $c[0];
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 03/10/2013 - 11:33
     * @version Banco de Oportunidades 2.0
     *
     * @param String $id_cidade Recebe o id do cidade como filtro para buscar as cidades.
     * @return array Retorna um array de CidadeVO.
     */
    public static function buscarCidadesPorIdCidade($id_cidade){
        $cidades = array();
        $cDAO = new CidadeDao();
        $cidades = $cDAO->buscarCidadesPorIdCidade($id_cidade);
        return $cidades;
    }

/**
     * @author Giuseppe Menti <giuseppe.menti@canoastec.rs.gov.br>
     * @since 04/05/2015 - 11:05
     * @version Banco de Oportunidades 1.1
     *
     * @param String $id_bairro Recebe o id do cidade como filtro para buscar os bairros.
     * @return array Retorna um array de BairroVO.
     */
    public static function buscarBairrosPorIdBairro($id_bairro){
        $bairros = array();
        $bDAO = new BairroDao();
        $bairros = $bDAO->buscarBairrosPorIdBairro($id_bairro);
        return $bairros;
    }
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 03/10/2013 - 11:41
     * @version Banco de Oportunidades 2.0
     *
     * @param String $id_cidade Recebe o id do cidade como filtro para busca
     * @return int Retorna o id do estado que a cidade pertence
     */
    public static function buscarIdEstado($id_cidade){
        if(is_numeric($id_cidade)){
            $cDAO = new CidadeDao();
            $id = $cDAO->buscarIdEstado($id_cidade);
            return $id[0];
        }else{
            return null;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 21/10/2013 - 13:50
     * @version Banco de Oportunidades 2.0
     *
     * @return EstadoVO Retorna um EstadoVO
     */
    public static function buscarEstadoPorId($id_estado){
        if(is_numeric($id_estado)){
            $eDAO = new EstadoDao();
            $estado = $eDAO->buscarEstadoPorId($id_estado);
            return $estado;
        }else{
            return null;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 21/10/2013 - 14:21
     * @version Banco de Oportunidades 2.0
     *
     * @return CidadeVO Retorna um CidadeVO
     */
    public static function buscarCidadePorId($id_cidade){
        if(is_numeric($id_cidade)){
            $cDAO = new CidadeDao();
            $cidade = $cDAO->buscarCidadePorId($id_cidade);
            return $cidade;
        }else{
            return null;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 02/10/2013 - 10:55
     *
     * @param int $id_formacao Recebe o id da formacao.
     * @return string Retorna a descricao da formacao conforme seu id
     */
    public static function verificarFormacao($id_formacao){
        if($id_formacao == 1){
            return 'Analfabeto';
        }else if($id_formacao == 2){
            return 'Ensino Fundamental Incompleto';
        }else if($id_formacao == 3){
            return 'Ensino Fundamental Completo';
        }else if($id_formacao == 4){
            return 'Ensino Médio Incompleto';
        }else if($id_formacao == 5){
            return 'Ensino Médio Completo';
        }else if($id_formacao == 6){
            return 'Ensino Superior Incompleto';
        }else if($id_formacao == 7){
            return 'Ensino Superior Cursando';
        }else if($id_formacao == 8){
            return 'Ensino Superior Completo';
        }else if($id_formacao == 9){
            return 'Pós Graduação  Lato Sensu';
        }else if($id_formacao == 10){
            return 'Pós Graduação  Stricto Sensu';
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 21/10/2013 - 14:22
     *
     * @param string $ds Recebe o ds_estado_civil
     * @return string Retorna a descricao do estado civil
     */
    public static function verificarEstadoCivil($ds){
        if($ds == 'S'){
            return 'Solteiro(a)';
        }else if($ds == 'C'){
            return 'Casado(a)';
        }else if($ds == 'V'){
            return 'Viúvo(a)';
        }else if($ds == 'D'){
            return 'Divorciado(a)';
        }else if($ds == 'P'){
            return 'Separado(a)';
        }else if($ds == 'O'){
            return 'Outros';
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 21/10/2013 - 14:26
     *
     * @param string $sexo Recebe o ao_sexo
     * @return string Retorna a descricao do genero
     */
    public static function verificarGenero($sexo){
        if($sexo == 'M'){
            return 'Masculino';
        }else if($sexo == 'F'){
            return 'Feminino';
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 22/10/2013 - 14:14
     *
     * @param string $status Recebe o ao_sexo
     * @return string Retorna a descricao do status
     */
    public static function verificarStatus($status, $profStatus){
        if($status == 'S' && $profStatus == 'S'){
            return 'Ativo';
        }else if($status == 'S' && $profStatus == 'V'){
            return 'Em moderação';
        }else if($status == 'S' && $profStatus == 'N'){
            return 'Inativo';
        }else if($status == 'N'){
            return 'Inativo';
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 04/11/2013 - 11:03
     * @version Banco de Oportunidades 2.0
     *
     * @return RamoAtividadeVO Retorna um RamoAtividadeVO
     */
    public static function buscarRamoAtividadePorId($id_ramoatividade){
        $rDAO = new RamoAtividadeDAO();
        $ramo = $rDAO->buscarRamoPorId($id_ramoatividade);
        return $ramo;
    }

     /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 30/01/2015 - 16:02
     * @version Banco de Oportunidades 2.0
     *
     * @return QuantidadeFuncionarioVO Retorna um QuantidadeFuncionarioVO
     */
    public static function buscarQuantidadeFuncionarioPorId($id_quantidadefuncionario){
        $qDAO = new QuantidadeFuncionarioDAO();
        $quantidade = $qDAO->buscarQuantidadeFuncionarioPorId($id_quantidadefuncionario);
        return $quantidade;
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 04/11/2013 - 11:06
     * @version Banco de Oportunidades 2.0
     *
     * @return array Retorna um array de RamoAtividadeVO
     */
    public static function buscarRamoAtividade(){
        $rDAO = new RamoAtividadeDAO();
        $array = $rDAO->buscar();
        return $array;
    }

    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 19/02/2015 - 09:29
     * @version Banco de Oportunidades 2.0
     *
     * @return array Retorna um array de AdicionalVO
    */
    public static function buscarAdicional(){
        $aDAO = new AdicionalDAO();
        $array = $aDAO->buscarAdicionais();
        return $array;
    }

    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 25/02/2015 - 08:51
     * @version Banco de Oportunidades 2.0
     *
     * @return array Retorna um array de AdicionalVO
    */
    public static function buscarAdicionalPorId($id){
        $aDAO = new AdicionalDAO();
        $array = $aDAO->buscarAdicionalPorId($id);
        return $array;
    }

    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 25/02/2015 - 09:07
     * @version Banco de Oportunidades 2.0
     *
     * @return array Retorna um array de BeneficioVO
    */
    public static function buscarBeneficioPorId($id){
        $bDAO = new BeneficioDAO();
        $array = $bDAO->buscarBeneficioPorId($id);
        return $array;
    }

    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 23/02/2015 - 15:06
     * @version Banco de Oportunidades 2.0
     *
     * @return VagaAdicionalVO Retorna um VagaAdicionalVO
     */
    public static function buscarVagaAdicionalPorIdVaga($id_vagaadicional, $id_adicional){
        $aDAO = new VagaAdicionalDAO();
        $array = $aDAO->buscarVagaAdicionalPorIdVaga($id_vagaadicional, $id_adicional);
        return $array;
    }

    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 25/02/2015 - 08:44
     * @version Banco de Oportunidades 2.0
     *
     * @return VagaAdicionalVO Retorna um VagaAdicionalVO
    */
    public static function buscarVagaAdicionalPorId($id_vaga){
        $aDAO = new VagaAdicionalDAO();
        $array = $aDAO->buscarVagaAdicionalPorId($id_vaga);
        return $array;
    }

    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 24/03/2015 - 10:41
     * @version Banco de Oportunidades 2.0
     *
     * @return VagaFormacaoVO Retorna um VagaFormacaoVO
    */
    public static function buscarVagaFormacaoPorIdVaga($id_vagaformacao, $id_formacao){
        $fDAO = new VagaFormacaoDAO();
        $array = $fDAO->buscarVagaFormacaoPorIdVaga($id_vagaformacao, $id_formacao);
        return $array;
    }

    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 24/03/2015 - 10:51
     * @version Banco de Oportunidades 2.0
     *
     * @return VagaFormacaoVO Retorna um VagaFormacaoVO
    */
    public static function buscarVagaFormacaoPorId($id_vaga){
        $fDAO = new VagaFormacaoDAO();
        $array = $fDAO->buscarVagaFormacaoPorId($id_vaga);
        return $array;
    }

    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 25/02/2015 - 09:10
     * @version Banco de Oportunidades 2.0
     *
     * @return VagaBeneficioVO Retorna um VagaBeneficioVO
    */
    public static function buscarVagaBeneficioPorId($id_vaga){
        $bDAO = new VagaBeneficioDAO();
        $array = $bDAO->buscarVagaBeneficioPorId($id_vaga);
        return $array;
    }

    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 19/02/2015 - 10:38
     * @version Banco de Oportunidades 2.0
     *
     * @return array Retorna um array de BeneficioVO
    */
    public static function buscarBeneficio(){
        $bDAO = new BeneficioDAO();
        $array = $bDAO->buscarBeneficios();
        return $array;
    }

    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 23/02/2015 - 17:05
     * @version Banco de Oportunidades 2.0
     *
     * @return AdicionalVO Retorna um AdicionalVO
    */
    public static function buscarVagaBeneficioPorIdVaga($id_vagabeneficio, $id_beneficio){
        $aDAO = new VagaBeneficioDAO();
        $array = $aDAO->buscarVagaBeneficioPorIdVaga($id_vagabeneficio, $id_beneficio);
        return $array;
    }

    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 18/02/2015 - 15:25
     * @version Banco de Oportunidades 2.0
     *
     * @return array Retorna um array de EmpresaTipoVO
    */
    public static function buscarEmpresaTipo(){
        $emptDAO = new EmpresaTipoDAO();
        $array = $emptDAO->buscar();
        return $array;
    }



     /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 30/01/2015 - 10:53
     * @version Banco de Oportunidades 2.0
     *
     * @return array Retorna um array de QuantidadeFuncionarioVO
     */
    public static function buscarQuantidadeFuncionario(){
        $qDAO = new QuantidadeFuncionarioDAO();
        $array = $qDAO->buscar();
        return $array;
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 12/11/2013 - 14:35
     * @version Banco de Oportunidades 2.0
     *
     * @param array $array Recebe um array para se listado com paginacao
     * @param int $qtd Recebe a quantidade de elementos do array por pagina
     * @param int $page Recebe a pagina atual
     * @return array Retorna um array com os elementos da atual pagina
     */
    public static function listar($array,$qtd,$page){

        $inicio = $page * $qtd;

        $fim = $inicio + $qtd;

        $novoArray = array();

        for($inicio; $inicio<$fim; $inicio++){
            $novoArray[] = $array[$inicio];
        }

        return $novoArray;
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 20/01/2014 - 10:05
     *
     * @param array $array Recebe um array para se listado com paginacao
     * @param int $qtd Recebe a quantidade de elementos do array por pagina
     * @param int $page Recebe a pagina atual
     * @param string $ancora Quando necessario recebe a ancora da pagina atual
     * @return string Retorna uma string com paginacao
     */
    public static function criarPaginacao($array,$qtd,$page,$ancora=''){

        $paginacao = '';

        $nrPaginas = ceil(count($array)/$qtd);

        if($nrPaginas>1){
            $espaco = '&nbsp&nbsp&nbsp';

            $primeira = 0;
            $segunda = 1;

            $ultima = $nrPaginas - 1;
            $penultima = $ultima - 1;

            $auxUltima = $nrPaginas;
            $auxPenultima = $auxUltima - 1;

            $menos = $page - 1;
            $mais = $page + 1;
            $adjacentes = 2;

            if($page > 0) {

                // primeira pagina
                if($nrPaginas > 2){
                    $url_pri = "$PHP_SELF?pg=$primeira$ancora";
                    $paginacao .= '<a href="'.$url_pri.'">Primeira</a>'.$espaco.'|'.$espaco;
                }

                // pagina anterior
                $url = "$PHP_SELF?pg=$menos$ancora";
                $paginacao .= '<a href="'.$url.'">Anterior</a>';
            }

            // 5 paginas ou menos
            if($nrPaginas <= 5){
                for ($i=0; $i<$nrPaginas; $i++){
                    $j = $i + 1;
                    if($i == $page){
                        $paginacao .= $espaco.'|'.$espaco.$j; // pagina atual
                    }else{
                        $url = "$PHP_SELF?pg=$i$ancora";
                        $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url.'">'.$j.'</a>'; // link para outras paginas
                    }
                }
            }

            // mais de 5 paginas
            if ($nrPaginas > 5){

                // intervalo no fim
                if($page < 1 + (2 * $adjacentes)){

                    for($i=0; $i< 2 + (2 * $adjacentes); $i++){
                        $j = $i + 1;
                        if($i == $page){
                            $paginacao .= $espaco.'|'.$espaco.$j; // pagina atual
                        }else{
                            $url = "$PHP_SELF?pg=$i$ancora";
                            $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url.'">'.$j.'</a>'; // link para outras paginas
                        }
                    }

                    $paginacao .= $espaco.'|'.$espaco.'...'.$espaco;

                    $url_pen = "$PHP_SELF?pg=$penultima$ancora";
                    $paginacao .= '|'.$espaco.'<a href="'.$url_pen.'">'.$auxPenultima.'</a>'.$espaco.'|'.$espaco;

                    $url_ult = "$PHP_SELF?pg=$ultima$ancora";
                    $paginacao .= '<a href="'.$url_ult.'">'.$auxUltima.'</a>';


                }
                // intervalo no inicio e no fim
                else if($page > (2 * $adjacentes) && $page < $nrPaginas - 3){

                    $url_pri = "$PHP_SELF?pg=$primeira$ancora";
                    $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url_pri.'">1</a>'.$espaco.'|'.$espaco;

                    $url_seg = "$PHP_SELF?pg=$segunda$ancora";
                    $paginacao .= '<a href="'.$url_seg.'">2</a>'.$espaco.'|'.$espaco.'...';

                    for($i = $page-$adjacentes; $i <= $page + $adjacentes; $i++){
                        $j = $i + 1;
                        if($i == $page){
                            $paginacao .= $espaco.'|'.$espaco.$j; // pagina atual
                        }else{
                            $url = "$PHP_SELF?pg=$i$ancora";
                            $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url.'">'.$j.'</a>'; // link para outras paginas
                        }
                    }

                    $paginacao .= $espaco.'|'.$espaco.'...'.$espaco;

                    $url_pen = "$PHP_SELF?pg=$penultima$ancora";
                    $paginacao .= '|'.$espaco.'<a href="'.$url_pen.'">'.$auxPenultima.'</a>'.$espaco.'|'.$espaco;

                    $url_ult = "$PHP_SELF?pg=$ultima$ancora";
                    $paginacao .= '<a href="'.$url_ult.'">'.$auxUltima.'</a>';

                }
                // intervalo no inicio
                else{

                    $url_pri = "$PHP_SELF?pg=$primeira$ancora";
                    $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url_pri.'">1</a>'.$espaco.'|'.$espaco;

                    $url_seg = "$PHP_SELF?pg=$segunda$ancora";
                    $paginacao .= '<a href="'.$url_seg.'">2</a>'.$espaco.'|'.$espaco.'...';

                    for($i = $nrPaginas - (4 + (2 * adjacentes)); $i < $nrPaginas; $i++){
                        $j = $i + 1;
                        if($i == $page){
                            $paginacao .= $espaco.'|'.$espaco.$j; // pagina atual
                        }else{
                            $url = "$PHP_SELF?pg=$i$ancora";
                            $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url.'">'.$j.'</a>'; // link para outras paginas
                        }
                    }
                }

            }

            if($nrPaginas - $page != 1) {

               // proxima pagina
               $url = "$PHP_SELF?pg=$mais$ancora";
               $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url.'">Próxima</a>';

               // ultima pagina
               if($nrPaginas > 2){
                   $url_ult = "$PHP_SELF?pg=$ultima$ancora";
                   $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url_ult.'">Última</a>';
               }
           }

        }
        return $paginacao;
    }

       /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 27/02/2015 - 08:54
     *
     * @param array $array Recebe um array para se listado com paginacao
     * @param int $qtd Recebe a quantidade de elementos do array por pagina
     * @param int $page Recebe a pagina atual
     * @param string $ancora Quando necessario recebe a ancora da pagina atual
     * @return string Retorna uma string com paginacao
     */
    public static function criarPaginacaoTodos($array,$qtd,$page,$ancora=''){

        $paginacao = '';

        $nrPaginas = ceil(count($array)/$qtd);

        if($nrPaginas>1){
            $espaco = '&nbsp&nbsp&nbsp';

            $primeira = 0;
            $segunda = 1;

            $ultima = $nrPaginas - 1;
            $penultima = $ultima - 1;

            $auxUltima = $nrPaginas;
            $auxPenultima = $auxUltima - 1;

            $menos = $page - 1;
            $mais = $page + 1;
            $adjacentes = 2;

            if($page > 0) {

                // primeira pagina
                if($nrPaginas > 2){
                    $url_pri = "$PHP_SELF?pg=$primeira$ancora";
                    $paginacao .= '<a href="'.$url_pri.'">Primeira</a>'.$espaco.'|'.$espaco;
                }

                // pagina anterior
                $url = "$PHP_SELF?pg=$menos$ancora";
                $paginacao .= '<a href="'.$url.'">Anterior</a>';
            }

            // 5 paginas ou menos
            if($nrPaginas <= 5){
                for ($i=0; $i<$nrPaginas; $i++){
                    $j = $i + 1;
                    if($i == $page){
                        $paginacao .= $espaco.'|'.$espaco.$j; // pagina atual
                    }else{
                        $url = "$PHP_SELF?pg=$i$ancora";
                        $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url.'">'.$j.'</a>'; // link para outras paginas
                    }
                }
            }

            // mais de 5 paginas
            if ($nrPaginas > 5){

                // intervalo no fim
                if($page < 1 + (2 * $adjacentes)){

                    for($i=0; $i< 2 + (2 * $adjacentes); $i++){
                        $j = $i + 1;
                        if($i == $page){
                            $paginacao .= $espaco.'|'.$espaco.$j; // pagina atual
                        }else{
                            $url = "$PHP_SELF?pg=$i$ancora";
                            $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url.'">'.$j.'</a>'; // link para outras paginas
                        }
                    }

                    $paginacao .= $espaco.'|'.$espaco.'...'.$espaco;

                    $url_pen = "$PHP_SELF?pg=$penultima$ancora";
                    $paginacao .= '|'.$espaco.'<a href="'.$url_pen.'">'.$auxPenultima.'</a>'.$espaco.'|'.$espaco;

                    $url_ult = "$PHP_SELF?pg=$ultima$ancora";
                    $paginacao .= '<a href="'.$url_ult.'">'.$auxUltima.'</a>';


                }
                // intervalo no inicio e no fim
                else if($page > (2 * $adjacentes) && $page < $nrPaginas - 3){

                    $url_pri = "$PHP_SELF?pg=$primeira$ancora";
                    $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url_pri.'">1</a>'.$espaco.'|'.$espaco;

                    $url_seg = "$PHP_SELF?pg=$segunda$ancora";
                    $paginacao .= '<a href="'.$url_seg.'">2</a>'.$espaco.'|'.$espaco.'...';

                    for($i = $page-$adjacentes; $i <= $page + $adjacentes; $i++){
                        $j = $i + 1;
                        if($i == $page){
                            $paginacao .= $espaco.'|'.$espaco.$j; // pagina atual
                        }else{
                            $url = "$PHP_SELF?pg=$i$ancora";
                            $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url.'">'.$j.'</a>'; // link para outras paginas
                        }
                    }

                    $paginacao .= $espaco.'|'.$espaco.'...'.$espaco;

                    $url_pen = "$PHP_SELF?pg=$penultima$ancora";
                    $paginacao .= '|'.$espaco.'<a href="'.$url_pen.'">'.$auxPenultima.'</a>'.$espaco.'|'.$espaco;

                    $url_ult = "$PHP_SELF?pg=$ultima$ancora";
                    $paginacao .= '<a href="'.$url_ult.'">'.$auxUltima.'</a>';

                }
                // intervalo no inicio
                else{

                    $url_pri = "$PHP_SELF?pg=$primeira$ancora";
                    $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url_pri.'">1</a>'.$espaco.'|'.$espaco;

                    $url_seg = "$PHP_SELF?pg=$segunda$ancora";
                    $paginacao .= '<a href="'.$url_seg.'">2</a>'.$espaco.'|'.$espaco.'...';

                    for($i = $nrPaginas - (4 + (2 * adjacentes)); $i < $nrPaginas; $i++){
                        $j = $i + 1;
                        if($i == $page){
                            $paginacao .= $espaco.'|'.$espaco.$j; // pagina atual
                        }else{
                            $url = "$PHP_SELF?pg=$i$ancora";
                            $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url.'">'.$j.'</a>'; // link para outras paginas
                        }
                    }
                }

            }

            if($nrPaginas - $page != 1) {

               // proxima pagina
               $url = "$PHP_SELF?pg=$mais$ancora";
               $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url.'">Próxima</a>';

               // ultima pagina
               if($nrPaginas > 2){
                   $url_ult = "$PHP_SELF?pg=$ultima$ancora";
                   $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url_ult.'">Última</a>';
               }
           }

        }
        return $paginacao;
    }


    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 30/12/2014 - 14:41
     *
     * @param array $array Recebe um array para se listado com paginacao
     * @param int $qtd Recebe a quantidade de elementos do array por pagina
     * @param int $page Recebe a pagina atual
     * @param string $ancora Quando necessario recebe a ancora da pagina atual
     * @return string Retorna uma string com paginacao
     */
    public static function criarPaginacaoFalsa($array,$qtd,$page,$ancora=''){

        $paginacao = '';

        $nrPaginas = ceil(count($array)/$qtd);

        $onclick = "alert('Sinalize os candidatos encaminhados para visualizar os próximos candidatos!');";

        if($nrPaginas>1){
            $espaco = '&nbsp&nbsp&nbsp';

            $primeira = 0;
            $segunda = 1;

            $ultima = $nrPaginas - 1;
            $penultima = $ultima - 1;

            $auxUltima = $nrPaginas;
            $auxPenultima = $auxUltima - 1;

            $menos = $page - 1;
            $mais = $page + 1;
            $adjacentes = 2;

            if($page > 0) {

                // primeira pagina
                if($nrPaginas > 2){
                    $url_pri = "$PHP_SELF?enc=$primeira$ancora";
                    $paginacao .= '<a href="#parte-02" onclick="'.$onclick.'" >Primeira</a>'.$espaco.'|'.$espaco;
                }

                // pagina anterior
                $url = "$PHP_SELF?enc=$menos$ancora";
                $paginacao .= '<a href="#parte-02" onclick="'.$onclick.'" >Anterior</a>';
            }

            // 5 paginas ou menos
            if($nrPaginas <= 5){
                for ($i=0; $i<$nrPaginas; $i++){
                    $j = $i + 1;
                    if($i == $page){
                        $paginacao .= $espaco.'|'.$espaco.$j; // pagina atual
                    }else{
                        $url = "$PHP_SELF?enc=$i$ancora";
                        $paginacao .= $espaco.'|'.$espaco.'<a href="#parte-02" onclick="'.$onclick.'" >'.$j.'</a>'; // link para outras paginas
                    }
                }
            }

            // mais de 5 paginas
            if ($nrPaginas > 5){

                // intervalo no fim
                if($page < 1 + (2 * $adjacentes)){

                    for($i=0; $i< 2 + (2 * $adjacentes); $i++){
                        $j = $i + 1;
                        if($i == $page){
                            $paginacao .= $espaco.'|'.$espaco.$j; // pagina atual
                        }else{
                            $url = "$PHP_SELF?enc=$i$ancora";
                            $paginacao .= $espaco.'|'.$espaco.'<a href="#parte-02" onclick="'.$onclick.'" >'.$j.'</a>'; // link para outras paginas
                        }
                    }

                    $paginacao .= $espaco.'|'.$espaco.'...'.$espaco;

                    $url_pen = "$PHP_SELF?enc=$penultima$ancora";
                    $paginacao .= '|'.$espaco.'<a href="#parte-02" onclick="'.$onclick.'" >'.$auxPenultima.'</a>'.$espaco.'|'.$espaco;

                    $url_ult = "$PHP_SELF?enc=$ultima$ancora";
                    $paginacao .= '<a href="#parte-02" onclick="'.$onclick.'" >'.$auxUltima.'</a>';


                }
                // intervalo no inicio e no fim
                else if($page > (2 * $adjacentes) && $page < $nrPaginas - 3){

                    $url_pri = "$PHP_SELF?enc=$primeira$ancora";
                    $paginacao .= $espaco.'|'.$espaco.'<a href="#parte-02" onclick="'.$onclick.'" >1</a>'.$espaco.'|'.$espaco;

                    $url_seg = "$PHP_SELF?enc=$segunda$ancora";
                    $paginacao .= '<a href="#parte-02" onclick="'.$onclick.'" >2</a>'.$espaco.'|'.$espaco.'...';

                    for($i = $page-$adjacentes; $i <= $page + $adjacentes; $i++){
                        $j = $i + 1;
                        if($i == $page){
                            $paginacao .= $espaco.'|'.$espaco.$j; // pagina atual
                        }else{
                            $url = "$PHP_SELF?enc=$i$ancora";
                            $paginacao .= $espaco.'|'.$espaco.'<a href="#parte-02" onclick="'.$onclick.'" >'.$j.'</a>'; // link para outras paginas
                        }
                    }

                    $paginacao .= $espaco.'|'.$espaco.'...'.$espaco;

                    $url_pen = "$PHP_SELF?enc=$penultima$ancora";
                    $paginacao .= '|'.$espaco.'<a href="#parte-02" onclick="'.$onclick.'" >'.$auxPenultima.'</a>'.$espaco.'|'.$espaco;

                    $url_ult = "$PHP_SELF?enc=$ultima$ancora";
                    $paginacao .= '<a href="#parte-02" onclick="'.$onclick.'" >'.$auxUltima.'</a>';

                }
                // intervalo no inicio
                else{

                    $url_pri = "$PHP_SELF?enc=$primeira$ancora";
                    $paginacao .= $espaco.'|'.$espaco.'<a href="#parte-02" onclick="'.$onclick.'" >1</a>'.$espaco.'|'.$espaco;

                    $url_seg = "$PHP_SELF?enc=$segunda$ancora";
                    $paginacao .= '<a href="#parte-02" onclick="'.$onclick.'" >2</a>'.$espaco.'|'.$espaco.'...';

                    for($i = $nrPaginas - (4 + (2 * adjacentes)); $i < $nrPaginas; $i++){
                        $j = $i + 1;
                        if($i == $page){
                            $paginacao .= $espaco.'|'.$espaco.$j; // pagina atual
                        }else{
                            $url = "$PHP_SELF?enc=$i$ancora";
                            $paginacao .= $espaco.'|'.$espaco.'<a href="#parte-02" onclick="'.$onclick.'" >'.$j.'</a>'; // link para outras paginas
                        }
                    }
                }

            }

            if($nrPaginas - $page != 1) {

               // proxima pagina
               $url = "$PHP_SELF?enc=$mais$ancora";
               $paginacao .= $espaco.'|'.$espaco.'<a href="#parte-02" onclick="'.$onclick.'" >Próxima</a>';

               // ultima pagina
               if($nrPaginas > 2){
                   $url_ult = "$PHP_SELF?enc=$ultima$ancora";
                   $paginacao .= $espaco.'|'.$espaco.'<a href="#parte-02" onclick="'.$onclick.'" >Última</a>';
               }
           }

        }
        return $paginacao;
    }

       /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 30/12/2014 - 14:41
     *
     * @param array $array Recebe um array para se listado com paginacao
     * @param int $qtd Recebe a quantidade de elementos do array por pagina
     * @param int $page Recebe a pagina atual
     * @param string $ancora Quando necessario recebe a ancora da pagina atual
     * @return string Retorna uma string com paginacao
     */
    public static function criarPaginacaoFalsaEncaminhados($array,$qtd,$page,$ancora=''){

        $paginacao = '';

        $nrPaginas = ceil(count($array)/$qtd);

        $onclick = "alert('Sinalize os candidatos encaminhados para visualizar os próximos candidatos!');";

        if($nrPaginas>1){
            $espaco = '&nbsp&nbsp&nbsp';

            $primeira = 0;
            $segunda = 1;

            $ultima = $nrPaginas - 1;
            $penultima = $ultima - 1;

            $auxUltima = $nrPaginas;
            $auxPenultima = $auxUltima - 1;

            $menos = $page - 1;
            $mais = $page + 1;
            $adjacentes = 2;

            if($page > 0) {

                // primeira pagina
                if($nrPaginas > 2){
                    $url_pri = "$PHP_SELF?enc=$primeira$ancora";
                    $paginacao .= '<a href="#parte-03" onclick="'.$onclick.'" >Primeira</a>'.$espaco.'|'.$espaco;
                }

                // pagina anterior
                $url = "$PHP_SELF?enc=$menos$ancora";
                $paginacao .= '<a href="#parte-03" onclick="'.$onclick.'" >Anterior</a>';
            }

            // 5 paginas ou menos
            if($nrPaginas <= 5){
                for ($i=0; $i<$nrPaginas; $i++){
                    $j = $i + 1;
                    if($i == $page){
                        $paginacao .= $espaco.'|'.$espaco.$j; // pagina atual
                    }else{
                        $url = "$PHP_SELF?enc=$i$ancora";
                        $paginacao .= $espaco.'|'.$espaco.'<a href="#parte-03" onclick="'.$onclick.'" >'.$j.'</a>'; // link para outras paginas
                    }
                }
            }

            // mais de 5 paginas
            if ($nrPaginas > 5){

                // intervalo no fim
                if($page < 1 + (2 * $adjacentes)){

                    for($i=0; $i< 2 + (2 * $adjacentes); $i++){
                        $j = $i + 1;
                        if($i == $page){
                            $paginacao .= $espaco.'|'.$espaco.$j; // pagina atual
                        }else{
                            $url = "$PHP_SELF?enc=$i$ancora";
                            $paginacao .= $espaco.'|'.$espaco.'<a href="#parte-03" onclick="'.$onclick.'" >'.$j.'</a>'; // link para outras paginas
                        }
                    }

                    $paginacao .= $espaco.'|'.$espaco.'...'.$espaco;

                    $url_pen = "$PHP_SELF?enc=$penultima$ancora";
                    $paginacao .= '|'.$espaco.'<a href="#parte-03" onclick="'.$onclick.'" >'.$auxPenultima.'</a>'.$espaco.'|'.$espaco;

                    $url_ult = "$PHP_SELF?enc=$ultima$ancora";
                    $paginacao .= '<a href="#parte-03" onclick="'.$onclick.'" >'.$auxUltima.'</a>';


                }
                // intervalo no inicio e no fim
                else if($page > (2 * $adjacentes) && $page < $nrPaginas - 3){

                    $url_pri = "$PHP_SELF?enc=$primeira$ancora";
                    $paginacao .= $espaco.'|'.$espaco.'<a href="#parte-03" onclick="'.$onclick.'" >1</a>'.$espaco.'|'.$espaco;

                    $url_seg = "$PHP_SELF?enc=$segunda$ancora";
                    $paginacao .= '<a href="#parte-03" onclick="'.$onclick.'" >2</a>'.$espaco.'|'.$espaco.'...';

                    for($i = $page-$adjacentes; $i <= $page + $adjacentes; $i++){
                        $j = $i + 1;
                        if($i == $page){
                            $paginacao .= $espaco.'|'.$espaco.$j; // pagina atual
                        }else{
                            $url = "$PHP_SELF?enc=$i$ancora";
                            $paginacao .= $espaco.'|'.$espaco.'<a href="#parte-03" onclick="'.$onclick.'" >'.$j.'</a>'; // link para outras paginas
                        }
                    }

                    $paginacao .= $espaco.'|'.$espaco.'...'.$espaco;

                    $url_pen = "$PHP_SELF?enc=$penultima$ancora";
                    $paginacao .= '|'.$espaco.'<a href="#parte-03" onclick="'.$onclick.'" >'.$auxPenultima.'</a>'.$espaco.'|'.$espaco;

                    $url_ult = "$PHP_SELF?enc=$ultima$ancora";
                    $paginacao .= '<a href="#parte-03" onclick="'.$onclick.'" >'.$auxUltima.'</a>';

                }
                // intervalo no inicio
                else{

                    $url_pri = "$PHP_SELF?enc=$primeira$ancora";
                    $paginacao .= $espaco.'|'.$espaco.'<a href="#parte-03" onclick="'.$onclick.'" >1</a>'.$espaco.'|'.$espaco;

                    $url_seg = "$PHP_SELF?enc=$segunda$ancora";
                    $paginacao .= '<a href="#parte-03" onclick="'.$onclick.'" >2</a>'.$espaco.'|'.$espaco.'...';

                    for($i = $nrPaginas - (4 + (2 * adjacentes)); $i < $nrPaginas; $i++){
                        $j = $i + 1;
                        if($i == $page){
                            $paginacao .= $espaco.'|'.$espaco.$j; // pagina atual
                        }else{
                            $url = "$PHP_SELF?enc=$i$ancora";
                            $paginacao .= $espaco.'|'.$espaco.'<a href="#parte-03" onclick="'.$onclick.'" >'.$j.'</a>'; // link para outras paginas
                        }
                    }
                }

            }

            if($nrPaginas - $page != 1) {

               // proxima pagina
               $url = "$PHP_SELF?enc=$mais$ancora";
               $paginacao .= $espaco.'|'.$espaco.'<a href="#parte-03" onclick="'.$onclick.'" >Próxima</a>';

               // ultima pagina
               if($nrPaginas > 2){
                   $url_ult = "$PHP_SELF?enc=$ultima$ancora";
                   $paginacao .= $espaco.'|'.$espaco.'<a href="#parte-03" onclick="'.$onclick.'" >Última</a>';
               }
           }

        }
        return $paginacao;
    }

    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 30/12/2014 - 14:41
     *
     * @param array $array Recebe um array para se listado com paginacao
     * @param int $qtd Recebe a quantidade de elementos do array por pagina
     * @param int $page Recebe a pagina atual
     * @param string $ancora Quando necessario recebe a ancora da pagina atual
     * @return string Retorna uma string com paginacao
     */
    public static function criarPaginacaoEncaminhados($array,$qtd,$page,$ancora=''){

        $paginacao = '';

        $nrPaginas = ceil(count($array)/$qtd);

        if($nrPaginas>1){
            $espaco = '&nbsp&nbsp&nbsp';

            $primeira = 0;
            $segunda = 1;

            $ultima = $nrPaginas - 1;
            $penultima = $ultima - 1;

            $auxUltima = $nrPaginas;
            $auxPenultima = $auxUltima - 1;

            $menos = $page - 1;
            $mais = $page + 1;
            $adjacentes = 2;

            if($page > 0) {

                // primeira pagina
                if($nrPaginas > 2){
                    $url_pri = "$PHP_SELF?enc=$primeira$ancora";
                    $paginacao .= '<a href="'.$url_pri.'">Primeira</a>'.$espaco.'|'.$espaco;
                }

                // pagina anterior
                $url = "$PHP_SELF?enc=$menos$ancora";
                $paginacao .= '<a href="'.$url.'">Anterior</a>';
            }

            // 5 paginas ou menos
            if($nrPaginas <= 5){
                for ($i=0; $i<$nrPaginas; $i++){
                    $j = $i + 1;
                    if($i == $page){
                        $paginacao .= $espaco.'|'.$espaco.$j; // pagina atual
                    }else{
                        $url = "$PHP_SELF?enc=$i$ancora";
                        $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url.'">'.$j.'</a>'; // link para outras paginas
                    }
                }
            }

            // mais de 5 paginas
            if ($nrPaginas > 5){

                // intervalo no fim
                if($page < 1 + (2 * $adjacentes)){

                    for($i=0; $i< 2 + (2 * $adjacentes); $i++){
                        $j = $i + 1;
                        if($i == $page){
                            $paginacao .= $espaco.'|'.$espaco.$j; // pagina atual
                        }else{
                            $url = "$PHP_SELF?enc=$i$ancora";
                            $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url.'">'.$j.'</a>'; // link para outras paginas
                        }
                    }

                    $paginacao .= $espaco.'|'.$espaco.'...'.$espaco;

                    $url_pen = "$PHP_SELF?enc=$penultima$ancora";
                    $paginacao .= '|'.$espaco.'<a href="'.$url_pen.'">'.$auxPenultima.'</a>'.$espaco.'|'.$espaco;

                    $url_ult = "$PHP_SELF?enc=$ultima$ancora";
                    $paginacao .= '<a href="'.$url_ult.'">'.$auxUltima.'</a>';


                }
                // intervalo no inicio e no fim
                else if($page > (2 * $adjacentes) && $page < $nrPaginas - 3){

                    $url_pri = "$PHP_SELF?enc=$primeira$ancora";
                    $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url_pri.'">1</a>'.$espaco.'|'.$espaco;

                    $url_seg = "$PHP_SELF?enc=$segunda$ancora";
                    $paginacao .= '<a href="'.$url_seg.'">2</a>'.$espaco.'|'.$espaco.'...';

                    for($i = $page-$adjacentes; $i <= $page + $adjacentes; $i++){
                        $j = $i + 1;
                        if($i == $page){
                            $paginacao .= $espaco.'|'.$espaco.$j; // pagina atual
                        }else{
                            $url = "$PHP_SELF?enc=$i$ancora";
                            $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url.'">'.$j.'</a>'; // link para outras paginas
                        }
                    }

                    $paginacao .= $espaco.'|'.$espaco.'...'.$espaco;

                    $url_pen = "$PHP_SELF?enc=$penultima$ancora";
                    $paginacao .= '|'.$espaco.'<a href="'.$url_pen.'">'.$auxPenultima.'</a>'.$espaco.'|'.$espaco;

                    $url_ult = "$PHP_SELF?enc=$ultima$ancora";
                    $paginacao .= '<a href="'.$url_ult.'">'.$auxUltima.'</a>';

                }
                // intervalo no inicio
                else{

                    $url_pri = "$PHP_SELF?enc=$primeira$ancora";
                    $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url_pri.'">1</a>'.$espaco.'|'.$espaco;

                    $url_seg = "$PHP_SELF?enc=$segunda$ancora";
                    $paginacao .= '<a href="'.$url_seg.'">2</a>'.$espaco.'|'.$espaco.'...';

                    for($i = $nrPaginas - (4 + (2 * adjacentes)); $i < $nrPaginas; $i++){
                        $j = $i + 1;
                        if($i == $page){
                            $paginacao .= $espaco.'|'.$espaco.$j; // pagina atual
                        }else{
                            $url = "$PHP_SELF?enc=$i$ancora";
                            $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url.'">'.$j.'</a>'; // link para outras paginas
                        }
                    }
                }

            }

            if($nrPaginas - $page != 1) {

               // proxima pagina
               $url = "$PHP_SELF?enc=$mais$ancora";
               $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url.'">Próxima</a>';

               // ultima pagina
               if($nrPaginas > 2){
                   $url_ult = "$PHP_SELF?enc=$ultima$ancora";
                   $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url_ult.'">Última</a>';
               }
           }

        }
        return $paginacao;
    }

     /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 30/12/2014 - 14:57
     *
     * @param array $array Recebe um array para se listado com paginacao
     * @param int $qtd Recebe a quantidade de elementos do array por pagina
     * @param int $page Recebe a pagina atual
     * @param string $ancora Quando necessario recebe a ancora da pagina atual
     * @return string Retorna uma string com paginacao
     */
    public static function criarPaginacaoBaixasAutomaticas($array,$qtd,$page,$ancora=''){

        $paginacao = '';

        $nrPaginas = ceil(count($array)/$qtd);

        if($nrPaginas>1){
            $espaco = '&nbsp&nbsp&nbsp';

            $primeira = 0;
            $segunda = 1;

            $ultima = $nrPaginas - 1;
            $penultima = $ultima - 1;

            $auxUltima = $nrPaginas;
            $auxPenultima = $auxUltima - 1;

            $menos = $page - 1;
            $mais = $page + 1;
            $adjacentes = 2;

            if($page > 0) {

                // primeira pagina
                if($nrPaginas > 2){
                    $url_pri = "$PHP_SELF?ba=$primeira$ancora";
                    $paginacao .= '<a href="'.$url_pri.'">Primeira</a>'.$espaco.'|'.$espaco;
                }

                // pagina anterior
                $url = "$PHP_SELF?ba=$menos$ancora";
                $paginacao .= '<a href="'.$url.'">Anterior</a>';
            }

            // 5 paginas ou menos
            if($nrPaginas <= 5){
                for ($i=0; $i<$nrPaginas; $i++){
                    $j = $i + 1;
                    if($i == $page){
                        $paginacao .= $espaco.'|'.$espaco.$j; // pagina atual
                    }else{
                        $url = "$PHP_SELF?ba=$i$ancora";
                        $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url.'">'.$j.'</a>'; // link para outras paginas
                    }
                }
            }

            // mais de 5 paginas
            if ($nrPaginas > 5){

                // intervalo no fim
                if($page < 1 + (2 * $adjacentes)){

                    for($i=0; $i< 2 + (2 * $adjacentes); $i++){
                        $j = $i + 1;
                        if($i == $page){
                            $paginacao .= $espaco.'|'.$espaco.$j; // pagina atual
                        }else{
                            $url = "$PHP_SELF?ba=$i$ancora";
                            $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url.'">'.$j.'</a>'; // link para outras paginas
                        }
                    }

                    $paginacao .= $espaco.'|'.$espaco.'...'.$espaco;

                    $url_pen = "$PHP_SELF?ba=$penultima$ancora";
                    $paginacao .= '|'.$espaco.'<a href="'.$url_pen.'">'.$auxPenultima.'</a>'.$espaco.'|'.$espaco;

                    $url_ult = "$PHP_SELF?ba=$ultima$ancora";
                    $paginacao .= '<a href="'.$url_ult.'">'.$auxUltima.'</a>';


                }
                // intervalo no inicio e no fim
                else if($page > (2 * $adjacentes) && $page < $nrPaginas - 3){

                    $url_pri = "$PHP_SELF?ba=$primeira$ancora";
                    $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url_pri.'">1</a>'.$espaco.'|'.$espaco;

                    $url_seg = "$PHP_SELF?ba=$segunda$ancora";
                    $paginacao .= '<a href="'.$url_seg.'">2</a>'.$espaco.'|'.$espaco.'...';

                    for($i = $page-$adjacentes; $i <= $page + $adjacentes; $i++){
                        $j = $i + 1;
                        if($i == $page){
                            $paginacao .= $espaco.'|'.$espaco.$j; // pagina atual
                        }else{
                            $url = "$PHP_SELF?ba=$i$ancora";
                            $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url.'">'.$j.'</a>'; // link para outras paginas
                        }
                    }

                    $paginacao .= $espaco.'|'.$espaco.'...'.$espaco;

                    $url_pen = "$PHP_SELF?ba=$penultima$ancora";
                    $paginacao .= '|'.$espaco.'<a href="'.$url_pen.'">'.$auxPenultima.'</a>'.$espaco.'|'.$espaco;

                    $url_ult = "$PHP_SELF?ba=$ultima$ancora";
                    $paginacao .= '<a href="'.$url_ult.'">'.$auxUltima.'</a>';

                }
                // intervalo no inicio
                else{

                    $url_pri = "$PHP_SELF?ba=$primeira$ancora";
                    $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url_pri.'">1</a>'.$espaco.'|'.$espaco;

                    $url_seg = "$PHP_SELF?ba=$segunda$ancora";
                    $paginacao .= '<a href="'.$url_seg.'">2</a>'.$espaco.'|'.$espaco.'...';

                    for($i = $nrPaginas - (4 + (2 * adjacentes)); $i < $nrPaginas; $i++){
                        $j = $i + 1;
                        if($i == $page){
                            $paginacao .= $espaco.'|'.$espaco.$j; // pagina atual
                        }else{
                            $url = "$PHP_SELF?ba=$i$ancora";
                            $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url.'">'.$j.'</a>'; // link para outras paginas
                        }
                    }
                }

            }

            if($nrPaginas - $page != 1) {

               // proxima pagina
               $url = "$PHP_SELF?ba=$mais$ancora";
               $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url.'">Próxima</a>';

               // ultima pagina
               if($nrPaginas > 2){
                   $url_ult = "$PHP_SELF?ba=$ultima$ancora";
                   $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url_ult.'">Última</a>';
               }
           }

        }
        return $paginacao;
    }

     /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 30/12/2014 - 15:05
     *
     * @param array $array Recebe um array para se listado com paginacao
     * @param int $qtd Recebe a quantidade de elementos do array por pagina
     * @param int $page Recebe a pagina atual
     * @param string $ancora Quando necessario recebe a ancora da pagina atual
     * @return string Retorna uma string com paginacao
     */
    public static function criarPaginacaoPreSelecionados($array,$qtd,$page,$ancora=''){

        $paginacao = '';

        $nrPaginas = ceil(count($array)/$qtd);

        if($nrPaginas>1){
            $espaco = '&nbsp&nbsp&nbsp';

            $primeira = 0;
            $segunda = 1;

            $ultima = $nrPaginas - 1;
            $penultima = $ultima - 1;

            $auxUltima = $nrPaginas;
            $auxPenultima = $auxUltima - 1;

            $menos = $page - 1;
            $mais = $page + 1;
            $adjacentes = 2;

            if($page > 0) {

                // primeira pagina
                if($nrPaginas > 2){
                    $url_pri = "$PHP_SELF?ps=$primeira$ancora";
                    $paginacao .= '<a href="'.$url_pri.'">Primeira</a>'.$espaco.'|'.$espaco;
                }

                // pagina anterior
                $url = "$PHP_SELF?ps=$menos$ancora";
                $paginacao .= '<a href="'.$url.'">Anterior</a>';
            }

            // 5 paginas ou menos
            if($nrPaginas <= 5){
                for ($i=0; $i<$nrPaginas; $i++){
                    $j = $i + 1;
                    if($i == $page){
                        $paginacao .= $espaco.'|'.$espaco.$j; // pagina atual
                    }else{
                        $url = "$PHP_SELF?ps=$i$ancora";
                        $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url.'">'.$j.'</a>'; // link para outras paginas
                    }
                }
            }

            // mais de 5 paginas
            if ($nrPaginas > 5){

                // intervalo no fim
                if($page < 1 + (2 * $adjacentes)){

                    for($i=0; $i< 2 + (2 * $adjacentes); $i++){
                        $j = $i + 1;
                        if($i == $page){
                            $paginacao .= $espaco.'|'.$espaco.$j; // pagina atual
                        }else{
                            $url = "$PHP_SELF?ps=$i$ancora";
                            $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url.'">'.$j.'</a>'; // link para outras paginas
                        }
                    }

                    $paginacao .= $espaco.'|'.$espaco.'...'.$espaco;

                    $url_pen = "$PHP_SELF?ps=$penultima$ancora";
                    $paginacao .= '|'.$espaco.'<a href="'.$url_pen.'">'.$auxPenultima.'</a>'.$espaco.'|'.$espaco;

                    $url_ult = "$PHP_SELF?ps=$ultima$ancora";
                    $paginacao .= '<a href="'.$url_ult.'">'.$auxUltima.'</a>';


                }
                // intervalo no inicio e no fim
                else if($page > (2 * $adjacentes) && $page < $nrPaginas - 3){

                    $url_pri = "$PHP_SELF?ps=$primeira$ancora";
                    $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url_pri.'">1</a>'.$espaco.'|'.$espaco;

                    $url_seg = "$PHP_SELF?ps=$segunda$ancora";
                    $paginacao .= '<a href="'.$url_seg.'">2</a>'.$espaco.'|'.$espaco.'...';

                    for($i = $page-$adjacentes; $i <= $page + $adjacentes; $i++){
                        $j = $i + 1;
                        if($i == $page){
                            $paginacao .= $espaco.'|'.$espaco.$j; // pagina atual
                        }else{
                            $url = "$PHP_SELF?ps=$i$ancora";
                            $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url.'">'.$j.'</a>'; // link para outras paginas
                        }
                    }

                    $paginacao .= $espaco.'|'.$espaco.'...'.$espaco;

                    $url_pen = "$PHP_SELF?ps=$penultima$ancora";
                    $paginacao .= '|'.$espaco.'<a href="'.$url_pen.'">'.$auxPenultima.'</a>'.$espaco.'|'.$espaco;

                    $url_ult = "$PHP_SELF?ps=$ultima$ancora";
                    $paginacao .= '<a href="'.$url_ult.'">'.$auxUltima.'</a>';

                }
                // intervalo no inicio
                else{

                    $url_pri = "$PHP_SELF?ps=$primeira$ancora";
                    $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url_pri.'">1</a>'.$espaco.'|'.$espaco;

                    $url_seg = "$PHP_SELF?ps=$segunda$ancora";
                    $paginacao .= '<a href="'.$url_seg.'">2</a>'.$espaco.'|'.$espaco.'...';

                    for($i = $nrPaginas - (4 + (2 * adjacentes)); $i < $nrPaginas; $i++){
                        $j = $i + 1;
                        if($i == $page){
                            $paginacao .= $espaco.'|'.$espaco.$j; // pagina atual
                        }else{
                            $url = "$PHP_SELF?ps=$i$ancora";
                            $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url.'">'.$j.'</a>'; // link para outras paginas
                        }
                    }
                }

            }

            if($nrPaginas - $page != 1) {

               // proxima pagina
               $url = "$PHP_SELF?ps=$mais$ancora";
               $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url.'">Próxima</a>';

               // ultima pagina
               if($nrPaginas > 2){
                   $url_ult = "$PHP_SELF?ps=$ultima$ancora";
                   $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url_ult.'">Última</a>';
               }
           }

        }
        return $paginacao;
    }

    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 30/12/2014 - 15:38
     *
     * @param array $array Recebe um array para se listado com paginacao
     * @param int $qtd Recebe a quantidade de elementos do array por pagina
     * @param int $page Recebe a pagina atual
     * @param string $ancora Quando necessario recebe a ancora da pagina atual
     * @return string Retorna uma string com paginacao
     */
    public static function criarPaginacaoContratados($array,$qtd,$page,$ancora=''){

        $paginacao = '';

        $nrPaginas = ceil(count($array)/$qtd);

        if($nrPaginas>1){
            $espaco = '&nbsp&nbsp&nbsp';

            $primeira = 0;
            $segunda = 1;

            $ultima = $nrPaginas - 1;
            $penultima = $ultima - 1;

            $auxUltima = $nrPaginas;
            $auxPenultima = $auxUltima - 1;

            $menos = $page - 1;
            $mais = $page + 1;
            $adjacentes = 2;

            if($page > 0) {

                // primeira pagina
                if($nrPaginas > 2){
                    $url_pri = "$PHP_SELF?co=$primeira$ancora";
                    $paginacao .= '<a href="'.$url_pri.'">Primeira</a>'.$espaco.'|'.$espaco;
                }

                // pagina anterior
                $url = "$PHP_SELF?co=$menos$ancora";
                $paginacao .= '<a href="'.$url.'">Anterior</a>';
            }

            // 5 paginas ou menos
            if($nrPaginas <= 5){
                for ($i=0; $i<$nrPaginas; $i++){
                    $j = $i + 1;
                    if($i == $page){
                        $paginacao .= $espaco.'|'.$espaco.$j; // pagina atual
                    }else{
                        $url = "$PHP_SELF?co=$i$ancora";
                        $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url.'">'.$j.'</a>'; // link para outras paginas
                    }
                }
            }

            // mais de 5 paginas
            if ($nrPaginas > 5){

                // intervalo no fim
                if($page < 1 + (2 * $adjacentes)){

                    for($i=0; $i< 2 + (2 * $adjacentes); $i++){
                        $j = $i + 1;
                        if($i == $page){
                            $paginacao .= $espaco.'|'.$espaco.$j; // pagina atual
                        }else{
                            $url = "$PHP_SELF?co=$i$ancora";
                            $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url.'">'.$j.'</a>'; // link para outras paginas
                        }
                    }

                    $paginacao .= $espaco.'|'.$espaco.'...'.$espaco;

                    $url_pen = "$PHP_SELF?co=$penultima$ancora";
                    $paginacao .= '|'.$espaco.'<a href="'.$url_pen.'">'.$auxPenultima.'</a>'.$espaco.'|'.$espaco;

                    $url_ult = "$PHP_SELF?co=$ultima$ancora";
                    $paginacao .= '<a href="'.$url_ult.'">'.$auxUltima.'</a>';


                }
                // intervalo no inicio e no fim
                else if($page > (2 * $adjacentes) && $page < $nrPaginas - 3){

                    $url_pri = "$PHP_SELF?co=$primeira$ancora";
                    $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url_pri.'">1</a>'.$espaco.'|'.$espaco;

                    $url_seg = "$PHP_SELF?co=$segunda$ancora";
                    $paginacao .= '<a href="'.$url_seg.'">2</a>'.$espaco.'|'.$espaco.'...';

                    for($i = $page-$adjacentes; $i <= $page + $adjacentes; $i++){
                        $j = $i + 1;
                        if($i == $page){
                            $paginacao .= $espaco.'|'.$espaco.$j; // pagina atual
                        }else{
                            $url = "$PHP_SELF?co=$i$ancora";
                            $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url.'">'.$j.'</a>'; // link para outras paginas
                        }
                    }

                    $paginacao .= $espaco.'|'.$espaco.'...'.$espaco;

                    $url_pen = "$PHP_SELF?co=$penultima$ancora";
                    $paginacao .= '|'.$espaco.'<a href="'.$url_pen.'">'.$auxPenultima.'</a>'.$espaco.'|'.$espaco;

                    $url_ult = "$PHP_SELF?co=$ultima$ancora";
                    $paginacao .= '<a href="'.$url_ult.'">'.$auxUltima.'</a>';

                }
                // intervalo no inicio
                else{

                    $url_pri = "$PHP_SELF?co=$primeira$ancora";
                    $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url_pri.'">1</a>'.$espaco.'|'.$espaco;

                    $url_seg = "$PHP_SELF?co=$segunda$ancora";
                    $paginacao .= '<a href="'.$url_seg.'">2</a>'.$espaco.'|'.$espaco.'...';

                    for($i = $nrPaginas - (4 + (2 * adjacentes)); $i < $nrPaginas; $i++){
                        $j = $i + 1;
                        if($i == $page){
                            $paginacao .= $espaco.'|'.$espaco.$j; // pagina atual
                        }else{
                            $url = "$PHP_SELF?co=$i$ancora";
                            $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url.'">'.$j.'</a>'; // link para outras paginas
                        }
                    }
                }

            }

            if($nrPaginas - $page != 1) {

               // proxima pagina
               $url = "$PHP_SELF?co=$mais$ancora";
               $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url.'">Próxima</a>';

               // ultima pagina
               if($nrPaginas > 2){
                   $url_ult = "$PHP_SELF?co=$ultima$ancora";
                   $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url_ult.'">Última</a>';
               }
           }

        }
        return $paginacao;
    }

     /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 30/12/2014 - 15:43
     *
     * @param array $array Recebe um array para se listado com paginacao
     * @param int $qtd Recebe a quantidade de elementos do array por pagina
     * @param int $page Recebe a pagina atual
     * @param string $ancora Quando necessario recebe a ancora da pagina atual
     * @return string Retorna uma string com paginacao
     */
    public static function criarPaginacaoDispensados($array,$qtd,$page,$ancora=''){

        $paginacao = '';

        $nrPaginas = ceil(count($array)/$qtd);

        if($nrPaginas>1){
            $espaco = '&nbsp&nbsp&nbsp';

            $primeira = 0;
            $segunda = 1;

            $ultima = $nrPaginas - 1;
            $penultima = $ultima - 1;

            $auxUltima = $nrPaginas;
            $auxPenultima = $auxUltima - 1;

            $menos = $page - 1;
            $mais = $page + 1;
            $adjacentes = 2;

            if($page > 0) {

                // primeira pagina
                if($nrPaginas > 2){
                    $url_pri = "$PHP_SELF?di=$primeira$ancora";
                    $paginacao .= '<a href="'.$url_pri.'">Primeira</a>'.$espaco.'|'.$espaco;
                }

                // pagina anterior
                $url = "$PHP_SELF?di=$menos$ancora";
                $paginacao .= '<a href="'.$url.'">Anterior</a>';
            }

            // 5 paginas ou menos
            if($nrPaginas <= 5){
                for ($i=0; $i<$nrPaginas; $i++){
                    $j = $i + 1;
                    if($i == $page){
                        $paginacao .= $espaco.'|'.$espaco.$j; // pagina atual
                    }else{
                        $url = "$PHP_SELF?di=$i$ancora";
                        $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url.'">'.$j.'</a>'; // link para outras paginas
                    }
                }
            }

            // mais de 5 paginas
            if ($nrPaginas > 5){

                // intervalo no fim
                if($page < 1 + (2 * $adjacentes)){

                    for($i=0; $i< 2 + (2 * $adjacentes); $i++){
                        $j = $i + 1;
                        if($i == $page){
                            $paginacao .= $espaco.'|'.$espaco.$j; // pagina atual
                        }else{
                            $url = "$PHP_SELF?di=$i$ancora";
                            $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url.'">'.$j.'</a>'; // link para outras paginas
                        }
                    }

                    $paginacao .= $espaco.'|'.$espaco.'...'.$espaco;

                    $url_pen = "$PHP_SELF?di=$penultima$ancora";
                    $paginacao .= '|'.$espaco.'<a href="'.$url_pen.'">'.$auxPenultima.'</a>'.$espaco.'|'.$espaco;

                    $url_ult = "$PHP_SELF?di=$ultima$ancora";
                    $paginacao .= '<a href="'.$url_ult.'">'.$auxUltima.'</a>';


                }
                // intervalo no inicio e no fim
                else if($page > (2 * $adjacentes) && $page < $nrPaginas - 3){

                    $url_pri = "$PHP_SELF?di=$primeira$ancora";
                    $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url_pri.'">1</a>'.$espaco.'|'.$espaco;

                    $url_seg = "$PHP_SELF?di=$segunda$ancora";
                    $paginacao .= '<a href="'.$url_seg.'">2</a>'.$espaco.'|'.$espaco.'...';

                    for($i = $page-$adjacentes; $i <= $page + $adjacentes; $i++){
                        $j = $i + 1;
                        if($i == $page){
                            $paginacao .= $espaco.'|'.$espaco.$j; // pagina atual
                        }else{
                            $url = "$PHP_SELF?di=$i$ancora";
                            $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url.'">'.$j.'</a>'; // link para outras paginas
                        }
                    }

                    $paginacao .= $espaco.'|'.$espaco.'...'.$espaco;

                    $url_pen = "$PHP_SELF?di=$penultima$ancora";
                    $paginacao .= '|'.$espaco.'<a href="'.$url_pen.'">'.$auxPenultima.'</a>'.$espaco.'|'.$espaco;

                    $url_ult = "$PHP_SELF?di=$ultima$ancora";
                    $paginacao .= '<a href="'.$url_ult.'">'.$auxUltima.'</a>';

                }
                // intervalo no inicio
                else{

                    $url_pri = "$PHP_SELF?di=$primeira$ancora";
                    $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url_pri.'">1</a>'.$espaco.'|'.$espaco;

                    $url_seg = "$PHP_SELF?di=$segunda$ancora";
                    $paginacao .= '<a href="'.$url_seg.'">2</a>'.$espaco.'|'.$espaco.'...';

                    for($i = $nrPaginas - (4 + (2 * adjacentes)); $i < $nrPaginas; $i++){
                        $j = $i + 1;
                        if($i == $page){
                            $paginacao .= $espaco.'|'.$espaco.$j; // pagina atual
                        }else{
                            $url = "$PHP_SELF?di=$i$ancora";
                            $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url.'">'.$j.'</a>'; // link para outras paginas
                        }
                    }
                }

            }

            if($nrPaginas - $page != 1) {

               // proxima pagina
               $url = "$PHP_SELF?di=$mais$ancora";
               $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url.'">Próxima</a>';

               // ultima pagina
               if($nrPaginas > 2){
                   $url_ult = "$PHP_SELF?di=$ultima$ancora";
                   $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url_ult.'">Última</a>';
               }
           }

        }
        return $paginacao;
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 14/01/2014 - 12:02
     * @version Banco de Oportunidades 2.0
     *
     * @param string $ds_curso Recebe o curso superior
     * @param string $ds_semestre Recebe o semestre
     * @return string Retorna uma descriç?o de curso e semestre
     */
    public static function verificarCursoSemestre($ds_curso, $ds_semestre){
        if(!(empty($ds_curso) && empty($ds_semestre))){
            return " / ". $ds_curso . $ds_semestre;
        }else{
            return null;
        }
    }

    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 07/04/2014 - 14:16
     * @version Banco de Oportunidades 2.0
     *
     * @param string $string Recebe o valor a ser convertido
     * @return mb_strtoupper da $string
     */
    public static function converterStrtoupper($string){
        return mb_strtoupper($string);
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 03/10/2013 - 11:41
     * @version Banco de Oportunidades 2.0
     *
     * @param String $id_cidade Recebe o id do cidade como filtro para busca
     * @return int Retorna o id do estado que a cidade pertence
     */
    public static function buscarProfissaoPorId($id_profissao){
        if(is_numeric($id_profissao)){
            $pDAO = new ProfissaoDAO();
            $p = $pDAO->buscarProfissao($id_profissao);
            return $p;
        }else{
            return null;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 09/04/2014 - 15:44
     *
     * @param string $status Recebe o status do encaminhado
     * @return string Retorna a descricao do status
     */
    public static function verificarStatusEncaminhado($status){
        if($status == 'E'){
            return 'Encaminhado';
        }else if($status == 'D'){
            return 'Dispensado';
        }else if($status == 'C'){
            return 'Contratado';
        }else if($status == 'P'){
            return 'Pré-selecionado';
        }else if($status == 'B'){
            return 'Baixa automática';
        }
    }

    /**
     * @author Felipe Stroff <felipe.stroff@canoastec.rs.gov.br>
     * @since 25/07/2014 - 13:53
     * @version Banco de Oportunidades 2.0
     *
     * @param String $id_candidato Recebe o id do candidato como filtro para busca
     * @return int Retorna o id do candidato;
     */
    public static function buscarDadosCandidatoPorId($id_candidato){
        if(is_numeric($id_candidato)){

            $cDAO = new CandidatoDAO();
            $c = $cDAO->buscarPorId($id_candidato);

            if(is_object($c)){

                $cfDAO = new CandidatoFormacaoDAO();
                $c->formacoes = $cfDAO->buscarCandidatoFormacoes($c->id_candidato);

                $cqDAO = new CandidatoQualificacaoDAO();
                $c->qualificacoes = $cqDAO->buscarCandidatoQualificacoes($c->id_candidato);

                $ceDAO = new CandidatoExperienciaDAO();
                $c->experiencias = $ceDAO->buscarCandidatoExperiencias($c->id_candidato);

                $cp = new CandidatoProfissaoDAO();
                $c->profissoes = $cp->buscarCandidatoProfissoesSimples($c->id_candidato);

                $foto = '../fotos/' . $c->id_candidato . '.jpg';
                $foto = (file_exists($foto)) ? "$foto" : "../fotos/foto_null.jpg";

                $pdf = '<style>
                            .texto {
                                color: #000;
                                font-size: 11px;
                                font-family: verdana,helvetica, sans-serif, Helvetica;
                                text-align: justify;
                            }

                            .linha{
                                background-color:#CDCDC1;
                                color:#666;
                                font-size: 10px;
                            }

                            .linha_cabecalho{
                                background-color:#EEEEE0;
                            }

                            .linha_nome{
                                color:#000;
                                font-size: 30px;
                            }
                        </style>';
                /********************************************************************************************************
                * DADOS PESSOAIS
                * ***************************************************************************************************** */
                $pdf .= '<table width="700px" cellpadding="0" cellspacing="0" align="center">
                            <tr>
                                <td>
                                    <table border="0" width="700px" cellpadding="2" cellspacing="2" align="center" class="texto">
                                        <tr>
                                            <td align="" colspan="" class="linha_nome">'. $c->nm_candidato .'&nbsp;</td>
                                            <td align="right"><img src="'. $foto .'"></td>
                                        </tr>
                                    </table>

                                    <table border="0" width="700px" cellpadding="2" cellspacing="2" align="center" class="texto">
                                        <tr>
                                            <td align="center" colspan="4" class="linha"><b>Dados Pessoais</b></td>
                                        </tr>
                                        <tr>
                                           <td width="22%">Nome</td>
                                           <td width="28%">'. $c->nm_candidato .'&nbsp;</td>

                                           <td width="22%">E-mail</td>
                                           <td width="28%">'. $c->ds_email .'&nbsp;</td>
                                        </tr>
                                        <tr>
                                           <td>Telefone</td>
                                           <td>'. $c->nr_telefone .'&nbsp;</td>

                                           <td>Celular</td>
                                           <td>'. $c->nr_celular .'&nbsp;</td>
                                        </tr>
                                        <tr>
                                           <td>CPF</td>
                                           <td>'. $c->nr_cpf .'&nbsp;</td>

                                           <td>RG</td>
                                           <td>'. $c->nr_rg .'&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>CTPS / Nº Série / UF</td>
                                            <td>';
                                            $pdf .= ($c->nr_ctps == null) ? '*******' : $c->nr_ctps;
                                            $pdf .= ($c->nr_serie == null) ? '/ ****' : ' / '. $c->nr_serie;
                                            $pdf .= ($c->id_estadoctps == null) ? '/ **' : ' / '. Servicos::buscarEstadoPorId($c->id_estadoctps)->sg_estado;
                                            $pdf .= '</td>

                                            <td>Gênero</td>
                                            <td>'. Servicos::verificarGenero($c->ao_sexo) .'&nbsp;</td>
                                        </tr>
                                        <tr>
                                           <td>Logradouro</td>
                                           <td>'. $c->ds_logradouro .'&nbsp;</td>

                                           <td>Número / Comp.</td>
                                           <td>';
                                           $pdf .= ($c->nr_logradouro == null) ? '****' : $c->nr_logradouro;
                                           $pdf .= ($c->ds_complemento == null) ? ' / ****' : ' / '. $c->ds_complemento;
                                           $pdf .= '</td>
                                        </tr>
                                        <tr>
                                            <td>Bairro</td>
                                            <td>'. $c->ds_bairro .'&nbsp;</td>

                                            <td>Cidade / UF</td>
                                            <td>';
                                            $pdf .= ($c->id_cidade == null) ? '******' : Servicos::buscarCidadePorId($c->id_cidade)->nm_cidade;
                                            $pdf .= ($c->id_cidade == null) ? ' / ******' : ' / '. Servicos::buscarEstadoPorId(Servicos::buscarIdEstado($c->id_cidade))->sg_estado;
                                            $pdf .= '</td>
                                        </tr>
                                        <tr>
                                            <td>Estado Civil</td>
                                            <td>'. Servicos::verificarEstadoCivil($c->ds_estado_civil) .'&nbsp;</td>

                                            <td>Data de Nascimento</td>
                                            <td>'. Validacao::explodirDataMySql($c->dt_nascimento) .'&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>Nacionalidade</td>
                                            <td>'. $c->ds_nacionalidade .'&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" align="center">&nbsp;</td>
                                        </tr>';
                            if($c->ds_objetivo != ''){
                                $pdf .= '<tr>
                                            <td>Objetivos</td>
                                            <td colspan="4">'. nl2br($c->ds_objetivo) .'&nbsp;</td>
                                        </tr>';
                             }
                                $pdf .= '<tr>
                                            <td colspan="4">&nbsp;</b>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>';
                /********************************************************************************************************
                * PROFISSAO
                * ***************************************************************************************************** */
                if(count($c->profissoes) > 0){
                    $pdf .= '<table border="0" width="700px" cellpadding="0" cellspacing="0" align="center" class="texto">
                                <tr>
                                    <td>
                                        <table border="0" width="700px" cellpadding="2" cellspacing="2" align="center" class="texto">
                                            <tr>
                                                <td align="center" colspan="4" class="linha"><b>Profissão</b></td>
                                            </tr>';
                                    foreach($c->profissoes as $cp){
                                        $pdf .= '<tr>
                                                    <td width="100%">' .Servicos::buscarProfissaoPorId($cp->id_profissao). '&nbsp;</td>
                                                </tr>';
                                    }
                                    $pdf .= '<tr>
                                                <td colspan="4" align="center">&nbsp;</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>';
                }
                /********************************************************************************************************
                * FORMACOES
                * ***************************************************************************************************** */
                if(count($c->formacoes) > 0){
                    $pdf .= '<table border="0" width="700px" cellpadding="0" cellspacing="0" align="center" class="texto">
                                <tr>
                                    <td>
                                        <table border="0" width="700px" cellpadding="2" cellspacing="2" align="center" class="texto">
                                            <tr>
                                                <td align="center" colspan="4" class="linha"><b>Formação</b></td>
                                            </tr>
                                            <tr class="linha_cabecalho">
                                                <td>Escolaridade</td>
                                                <td>Data Término</td>
                                                <td>Escola</td>
                                                <td>Cidade Escola</td>
                                            </tr>';
                                    foreach($c->formacoes as $f){
                                        $pdf .= '<tr>
                                                    <td>'. Servicos::verificarFormacao($f->id_formacao) .'&nbsp;</td>
                                                    <td>'. Validacao::explodirDataMySqlNaoObg($f->dt_termino) .'&nbsp;</td>
                                                    <td>'. $f->nm_escola .'&nbsp;</td>
                                                    <td>'. $f->ds_cidadeescola .'&nbsp;</td>
                                                </tr>';
                                    }
                                    $pdf .= '<tr>
                                                <td colspan="4" align="center">&nbsp;</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>';
                }
                /********************************************************************************************************
                * QUALIFICACOES
                * ***************************************************************************************************** */
                if(count($c->qualificacoes) > 0){
                    $pdf .= '<table border="0" width="700px" cellpadding="0" cellspacing="0" align="center" class="texto">
                                <tr>
                                    <td>
                                        <table border="0" width="700px" cellpadding="2" cellspacing="2" align="center" class="texto">
                                            <tr>
                                                <td align="center" colspan="4" class="linha"><b>Qualificações</b></td>
                                            </tr>
                                            <tr class="linha_cabecalho">
                                                <td>Descrição</td>
                                                <td>Instituição</td>
                                                <td>Data Término</td>
                                                <td>Qnt. Horas</td>
                                            </tr>';

                                    foreach($c->qualificacoes as $q){
                                        $pdf .= '<tr>
                                                    <td>'. $q->ds_qualificacao .'&nbsp;</td>
                                                    <td>'. $q->nm_instituicao .'&nbsp;</td>
                                                    <td>'. Validacao::explodirDataMySqlNaoObg($q->dt_termino) .'&nbsp;</td>
                                                    <td>'. $q->qtd_horas .'&nbsp;</td>
                                                </tr>';
                                    }
                                    $pdf .= '<tr>
                                                <td colspan="4" align="center">&nbsp;</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>';
                }
                /********************************************************************************************************
                * EXPERIENCIAS
                * ***************************************************************************************************** */
                if(count($c->experiencias) > 0){
                    $pdf .= '<table border="0" width="700px" cellpadding="0" cellspacing="0" align="center" class="texto">
                                <tr>
                                    <td>
                                        <table border="0" width="700px" cellpadding="2" cellspacing="2" align="center" class="texto">
                                            <tr>
                                                <td align="center" colspan="4" class="linha"><b>Experiência Profissional</b></td>
                                            </tr>
                                            <tr class="linha_cabecalho">
                                                <td>Empresa</td>
                                                <td>Data Início</td>
                                                <td>Data Término</td>
                                                <td>Principais Atividades</td>
                                            </tr>';
                                    foreach($c->experiencias as $e){
                                        $pdf .= '<tr>
                                                    <td>'. $e->nm_empresa .'&nbsp;</td>
                                                    <td>'. Validacao::explodirDataMySqlNaoObg($e->dt_inicio) .'&nbsp;</td>
                                                    <td>'. Validacao::explodirDataMySqlNaoObg($e->dt_termino) .'&nbsp;</td>
                                                    <td>'. nl2br($e->ds_atividades) .'&nbsp;</td>
                                                </tr>';
                                    }
                                    $pdf .= '<tr>
                                                <td colspan="4" align="center">&nbsp;</b>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>';
                }
                return $pdf;

            }else{
                return null;
            }
        }else{
            return null;
        }
    }

    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 01/08/2014 - 13:40
     * @version Banco de Oportunidades 2.0
     *
     * @param String $id_vaga Recebe o id da vaga como filtro para busca
     * @return int Retorna o id da profissao que a vaga pertence
     */
    public static function buscarProfissaoPorIdVaga($id_vaga){
        if(is_numeric($id_vaga)){
            $pDAO = new ProfissaoDAO();
            $p = $pDAO->buscarProfissaoPorIdVaga($id_vaga);
            return $p;
        }else{
            return null;
        }
    }

    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 07/05/2015 - 14:05
     * @version Banco de Oportunidades 2.0
     *
     * @param String $id_vaga Recebe o id da vaga como filtro para busca
     * @return int Retorna a quantidade de vagas da profissão
    */
    public static function buscarTotalVagasPorIdProfissao($id_profissao){
        if(is_numeric($id_profissao)){
            $vDAO = new VagaDAO();
            $v = $vDAO->buscarTotalVagaPorIdProfissao($id_profissao);
            return $v;
        }else{
            return null;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @author Felipe Stroff <felipe.stroff@canoastec.rs.gov.br>
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 14/08/2014 - 11:46
     *
     * Função que verifica se existi o array de erros e se name do campo está contido no array.
     *
     * @param string $array Recebe o nome do array de erros
     * @param string $name Recebe o name do campo
     * @param string $mensagem Pode receber uma mensagem diferente do padrão
     * @return string Retorna a mensagem que o campo precisa ser preechido corretamente.
     */
    public static function verificarErro($array, $name, $mensagem=null){
        if (isset($_SESSION[$array]) && in_array($name, $_SESSION[$array])) {

            if(!is_null($mensagem)) return "<span class='style1'>$mensagem</span>";
            else return "<p><span class='style1'>* Preencha corretamente este campo</span></p>";

        }
    }

    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 23/05/2014 - 15:00
     *
     * @param date $data_nasc Recebe o nascimento no padrao aaaa-mm-dd
     * @return Retorna a idade calculada atravez da data de nascimento.
     */
    public static function calculaIdade($data_nasc){
//        //as datas devem ser no formato aaaa-mm-dd
//        $data_nasc = strtotime($data_nasc);
//        $data_atual = strtotime(date('Y-m-d'));
//        //cálculo da idade fazendo a diferença entre as duas datas
//        $idade = floor(abs($data_atual-$data_nasc)/60/60/24/365);
//        //retorna o resultado final da diferança
//        return($idade);

        //mais preciso
        $date = new DateTime($data_nasc); // data de nascimento
        $interval = $date->diff( new DateTime(date('Y-m-d')) ); // data definida
        return $interval->format('%Y');
    }

    /**
     * @author Felipe Stroff <felipe.stroff@canoastec.rs.gov.br>
     * @author Ricardo Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 15/09/2014 - 10:39
     *
     * @return MotivoVO Retorna um array de MotivoVO
     */
    public static function buscarMotivos(){
        $mDAO = new MotivoDAO();
        $motivos = $mDAO->buscarMotivos();
        return $motivos;
    }

    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 16/09/2014 - 11:04
     *
     * @return DeficienciaVO Retorna um DeficienciaVO
     */
    public static function buscarDeficienciaPorId($id_deficiencia){
        if(is_numeric($id_deficiencia)){
            $dDAO = new DeficienciaDao();
            $deficiencia = $dDAO->buscarDeficienciaPorId($id_deficiencia);
            return $deficiencia;
        }else{
            return null;
        }
    }

    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 16/09/2014 - 13:48
     *
     * @return MotivoVO Retorna um MotivoVO
     */
    public static function buscarMotivoPorId($id_motivo){
        if(is_numeric($id_motivo)){
            $mDAO = new MotivoDao();
            $motivo = $mDAO->buscarMotivoPorId($id_motivo);
            return $motivo;
        }else{
            return null;
        }
    }

    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 18/09/2014 - 12:57
     *
     * @param String $id_candidato Recebe o id do candidato como filtro para busca
     * @param String $id_empresa Recebe o id empresa como filtro para busca
     * @return HistoricoCandidatoVO Retorna um HistoricoCandidatoVO
     */
    public static function verificarHistoricoCandidato($id_candidato, $id_empresa){
        if(is_numeric($id_candidato) && is_numeric($id_empresa)){
            $hcDAO = new HistoricoCandidatoDAO();
            $historico = $hcDAO->verificarHistoricoCandidatoEmpresa($id_candidato, $id_empresa);
            return $historico;
        }else{
            return null;
        }
    }

    /**
     * @author Ricardo K.Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 19/09/2014 - 11:39
     *
     * @return EmpresaVO Retorna um EmpresaVO
     */
    public static function buscarEmpresaPorId($id_empresa){
        if(is_numeric($id_empresa)){
            $eDAO = new EmpresaDAO();
            $empresa = $eDAO->buscarEmpresa($id_empresa);
            return $empresa;
        }else{
            return null;
        }
    }


     /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 12/02/2015 - 16:30
     *
     * @return VagaCandidatoVO Retorna um VagaCandidatoVO
     */
    public static function salvarLogInterno($vc){

            $vDAO = new VagaCandidatoDAO();
            $vagacandidato = $vDAO->salvarLogInterno($vc);
            return $vagacandidato;

    }




    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 18/09/2014 - 13:34
     *
     * @param String $id_candidato Recebe o id do candidato como filtro para busca
     * @param String $id_empresa Recebe o id empresa como filtro para busca
     * @return HistoricoCandidatoVO Retorna um HistoricoCandidatoVO
     */
    public static function montarHistoricoCandidato($id_candidato, $id_empresa){

        if(is_numeric($id_candidato) && is_numeric($id_empresa)){

            $hcDAO = new HistoricoCandidatoDAO();
            $historico = $hcDAO->montarHistoricoCandidatoEmpresa($id_candidato, $id_empresa);

            $cDAO = new CandidatoDAO();
            $c = $cDAO->buscarPorId($id_candidato);

            if(is_array($historico)){

                $pdf = '<style>
                            .texto {
                                color: #000;
                                font-size: 11px;
                                font-family: verdana,helvetica, sans-serif, Helvetica;
                                text-align: justify;
                            }

                            .linha{
                                background-color:#CDCDC1;
                                color:#666;
                                font-size: 10px;
                            }

                            .linha_cabecalho{
                                background-color:#EEEEE0;
                            }

                            .linha_nome{
                                color:#000;
                                font-size: 30px;
                            }
                        </style>';

                if(count($historico) > 0){
                    $pdf .= '<br>
                            <br>
                            <table border="0" width="700px" cellpadding="0" cellspacing="0" align="center" class="texto">
                                <tr>
                                    <td>
                                        <table border="0" width="700px" cellpadding="2" cellspacing="2" align="center" class="texto">
                                            <tr>
                                                <td align="center" colspan="4" class="linha"><b>Histórico do(a) candidato(a) '. $c->nm_candidato .'</b></td>
                                            </tr>
                                            <tr class="linha_cabecalho">
                                                <td width="30%" align="center">Vaga</td>
                                                <td width="16%" align="center">Status</td>
                                                <td width="32%" align="center">Motivo</td>
                                                <td width="22%" align="center">Data</td>
                                            </tr>';

                                    foreach($historico as $hc){

                                        $pdf .= '<tr>
                                                    <td style="text-align: left;">'. Servicos::buscarProfissaoPorId($hc['id_profissao']).'&nbsp;</td>
                                                    <td>'. Servicos::verificarStatusEncaminhado($hc['ao_status']) .'&nbsp;</td>
                                                    <td>';
                                                        $pdf .= ($hc['id_motivo'] == null) ? $hc['ds_motivodispensa'] : Servicos::buscarMotivoPorId($hc['id_motivo'])->ds_motivo .'&nbsp;
                                                    </td>';
                                                    $pdf .='<td>'. Validacao::explodirDataMySql($hc['dt_cadastro'], true, true) .'&nbsp;</td>
                                                </tr>';

                                    }
                                    $pdf .= '<tr>
                                                <td colspan="4" align="center">&nbsp;</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>';
                }
                return $pdf;
            }else{
                return null;
            }
        }else{
            return null;
        }
    }

    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 25/09/2014 - 14:29
     *
     * @param String $id_candidato Recebe o id do candidato como filtro para busca
     * @return HistoricoCandidatoVO Retorna um HistoricoCandidatoVO

    public static function buscarHistoricoCandidatoCompleto($id_candidato){

        if(is_numeric($id_candidato)){
            $hcDAO = new HistoricoCandidatoDAO();
            $historico = $hcDAO->buscarHistoricoCandidatoCompleto($id_candidato);
            return $historico;
        }else{
            return null;
        }
    }*/

        /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 26/09/2014 - 15:43
     *
     * @param String $id_candidato Recebe o id do candidato como filtro para busca
     * @return VagaCandidatoVO Retorna um vagaCandidatoVO
     */
    public static function buscarUltimaAtualizacaoCandidato($id_candidato){

        if(is_numeric($id_candidato)){
            $vcDAO = new VagaCandidatoDAO();
            $historico = $vcDAO->buscarUltimaAtualizacaoCandidato($id_candidato);
            return $historico;
        }else{
            return null;
        }
    }

    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 26/09/2014 - 14:29
     *
     * @param String $id_candidato Recebe o id do candidato como filtro para busca
     * @return CandidatoQualificacaoVO Retorna um CandidatoQualificacaoVO
     */
    public static function buscarCandidatoQualificacao($id_candidato){

        if(is_numeric($id_candidato)){
            $cqDAO = new CandidatoQualificacaoDAO();
            $qualificacao = $cqDAO->buscarCandidatoQualificacoes($id_candidato);
            return $qualificacao;
        }else{
            return null;
        }
    }

    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 08/10/2014 - 10:52
     *
     * @param String $id_candidato Recebe o id do candidato como filtro para busca
     * @return CandidatoQualificacaoVO Retorna um CandidatoQualificacaoVO
     */
    public static function buscarQualificacoesNulas($id_candidato){

        if(is_numeric($id_candidato)){
            $cqDAO = new CandidatoQualificacaoDAO();
            $qualificacao = $cqDAO->buscarQualificacoesNulas($id_candidato);
            return $qualificacao;
        }else{
            return null;
        }
    }

    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 26/09/2014 - 14:29
     *
     * @param String $id_candidato Recebe o id do candidato como filtro para busca
     * @return CandidatoExperienciaVO Retorna um CandidatoExperienciaVO
     */
    public static function buscarCandidatoExperiencia($id_candidato){

        if(is_numeric($id_candidato)){
            $ceDAO = new CandidatoExperienciaDAO();
            $experiencia = $ceDAO->buscarCandidatoExperiencias($id_candidato);
            return $experiencia;
        }else{
            return null;
        }
    }

    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @since 08/10/2014 - 14:39
     *
     * @param String $id_candidato Recebe o id do candidato como filtro para busca
     * @return CandidatoExperienciaVO Retorna um CandidatoExperienciaVO
     */
    public static function buscarCandidatoExperienciaNula($id_candidato){

        if(is_numeric($id_candidato)){
            $ceDAO = new CandidatoExperienciaDAO();
            $experiencia = $ceDAO->buscarCandidatoExperienciasNulas($id_candidato);
            return $experiencia;
        }else{
            return null;
        }
    }

}
?>
