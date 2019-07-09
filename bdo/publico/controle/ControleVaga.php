<?php
include_once '../util/ControleSessao.class.php';
//abro sessao
ControleSessao::abrirSessao();


include_once '../modelo/EmpresaVO.class.php';
include_once '../modelo/EmpresaDetalheVO.class.php';
include_once '../modelo/AdmissaoVO.class.php';
include_once '../modelo/VagaVO.class.php';
include_once '../modelo/AdicionalVO.class.php';
include_once '../modelo/BeneficioVO.class.php';
include_once '../modelo/VagaCandidatoVO.class.php';
include_once '../modelo/VagaAdicionalVO.class.php';
include_once '../modelo/VagaBeneficioVO.class.php';
include_once '../modelo/ProfissaoVO.class.php';
include_once '../modelo/CandidatoVO.class.php';
include_once '../modelo/HistoricoCandidatoVO.class.php';
include_once '../modelo/HistoricoVagaVO.class.php';

include_once '../persistencia/CandidatoDAO.class.php';
include_once '../persistencia/EmpresaDAO.class.php';
include_once '../persistencia/EmpresaDetalheDAO.class.php';
include_once '../persistencia/AdmissaoDAO.class.php';
include_once '../persistencia/VagaDAO.class.php';
include_once '../persistencia/AdicionalDAO.class.php';
include_once '../persistencia/BeneficioDAO.class.php';
include_once '../persistencia/VagaCandidatoDAO.class.php';
include_once '../persistencia/VagaAdicionalDAO.class.php';
include_once '../persistencia/VagaBeneficioDAO.class.php';
include_once '../persistencia/ProfissaoDAO.class.php';
include_once '../persistencia/HistoricoVagaDAO.class.php';

include_once '../util/Validacao.class.php';
include_once '../util/ControleLoginEmpresa.class.php';
include_once '../util/ControleLoginCandidato.class.php';
include_once '../util/Email.class.php';
include_once '../util/Servicos.class.php';
include_once '../util/Imprimir.class.php';

if(isset($_GET['op'])){
    //switch do op para executar as operações
    switch($_GET['op']){
        case 'cadastrar':

            if(isset($_POST)){
                $errosV = array();

                if($_POST['id_profissao'] == 'OUTRO'){
                    if(!Validacao::validarNmEmpresa($_POST['ds_outro'])) $errosV[] = 'ds_outro';
                }else if(!is_numeric($_POST['id_profissao'])){
                    $errosV[] = 'id_profissao';
                }
                if(!Validacao::validarAtribuicao($_POST['ds_atribuicao'])) $errosV[] = 'ds_atribuicao';
                if(!Validacao::validarMoedaReal($_POST['nr_salario'])) $errosV[] = 'nr_salario';
                //if(!Validacao::validarAtribuicao($_POST['ds_adicional'])) $errosV[] = 'ds_adicional';
                //if(!Validacao::validarAtribuicao($_POST['ds_beneficio'])) $errosV[] = 'ds_beneficio';
                if(!Validacao::validarAtribuicao($_POST['ds_observacao'])) $errosV[] = 'ds_observacao';
                if(!Validacao::validarIdCbo($_POST['qt_vaga'])) $errosV[] = 'qt_vaga';
                if(!Validacao::validarGenerico('/^[IMF]$/', $_POST['ao_sexo'])) $errosV[] = 'ao_sexo';
                if(!Validacao::validarStatus($_POST['ao_exibenome']) && !empty($_POST['ao_exibenome'])) $errosV[] = 'ao_exibenome';
                if(!Validacao::validarStatus($_POST['ao_exibeemail']) && !empty($_POST['ao_exibeemail'])) $errosV[] = 'ao_exibeemail';
                if(!Validacao::validarStatus($_POST['ao_exibetelefone']) && !empty($_POST['ao_exibetelefone'])) $errosV[] = 'ao_exibetelefone';
                if(!Validacao::validarStatus($_POST['ao_deficiente'])) $errosV[] = 'ao_deficiente';
                if(!Validacao::validarEstadoCivilVaga($_POST['ds_estado_civil'])) $errosV[] = 'ds_estado_civil';
                if(!Validacao::validarIdades($_POST['ds_idade'])) $errosV[] = 'ds_idade';
                if(!Validacao::validarStatus($_POST['ao_experiencia']) && !empty($_POST['ao_experiencia'])) $errosV[] = 'ao_experiencia';
                if(!Validacao::validarCNH($_POST['ds_cnh'])) $errosV[] = 'ds_cnh';

                //valida ao_adicional
                if(isset($_POST['ao_adicional'])){
                    if(is_array($_POST['ao_adicional'])){
                    foreach ($_POST['ao_adicional'] as $idAdicional) {
                            if(!Validacao::validarAdicional('/^[0-9]{0,6}$/', $idAdicional) && !in_array('id_adicional', $errosV)) $errosV[] = 'id_adicional';
                        }
                    }else{
                        $errosV[] = 'id_adicional';
                    }
                }
                //valida ao_beneficio
                if(isset($_POST['ao_beneficio'])){
                    if(is_array($_POST['ao_beneficio'])){
                    foreach ($_POST['ao_beneficio'] as $idBeneficio) {
                            if(!Validacao::validarBeneficio('/^[0-9]{0,6}$/', $idBeneficio) && !in_array('id_beneficio', $errosV)) $errosV[] = 'id_beneficio';
                        }
                    }else{
                        $errosV[] = 'id_beneficio';
                    }
                }
                //valida ao_formacao
                if(isset($_POST['ao_formacao'])){
                    if(is_array($_POST['ao_formacao'])){
                    foreach ($_POST['ao_formacao'] as $idFormacao) {
                            if(!Validacao::validarAoFormacao('/^[0-9]{0,6}$/', $idFormacao) && !in_array('id_Formacao', $errosV)) $errosV[] = 'id_formacao';
                        }
                    }else{
                        $errosV[] = 'id_formacao';
                    }
                }
                 //se nao houver erros
                if(count($errosV)==0){

                    if(is_numeric($_POST['id_profissao'])){

                        $vDAO = new VagaDAO;
                        if(!$vDAO->verificarVaga($_POST['id_profissao'], ControleSessao::buscarObjeto('privateEmp')->id_empresa)){
                            ControleSessao::inserirVariavel('msg', 'Já existe uma vaga cadastrada para a profissão de '.Servicos::buscarProfissaoPorId($_POST['id_profissao']).', verifique sua lista de vagas!');
                            ControleSessao::inserirVariavel('post', $_POST);
                            ControleSessao::inserirVariavel('errosV', $errosV);
                            header('location:../visao/GuiCadVaga.php');
                            die();
                        }

                    }else if(!empty($_POST['ds_outro'])){

                        if(Servicos::converterStrtoupper($_POST['ds_outro']) !=
                                Servicos::converterStrtoupper(ControleSessao::buscarObjeto('objVaga')->profissao->nm_profissao)){
                            $p = new ProfissaoVO();
                            $p->nm_profissao = Servicos::converterStrtoupper($_POST['ds_outro']);
                            $p->ao_ativo = 'V';

                            $pDAO = new ProfissaoDAO();
                            $idGeradoProf = $pDAO->cadastrarProfissao($p);

                            $_POST['id_profissao'] = $idGeradoProf;

                            $msg = "<p>Uma nova profissão foi cadastrada no Banco de Oportunidade e aguarda por validação.</p>
                                    <p><b>Profissão:</b> $p->nm_profissao</p>";
                            //envia o email
                            Email::enviarEmail('seuemail@prefeitura.com', 'Validação de Profissão', $msg, 'Moderador(a) do Sistema');

                        }
                    }

                    $e = ControleSessao::buscarObjeto('privateEmp');

                    $v = new VagaVO();

                    $v->id_vaga = 'null';
                    $v->id_empresa = $e->id_empresa;
                    $v->id_profissao = (!empty($_POST['id_profissao'])) ? $_POST['id_profissao'] : 'null';
                    $v->ds_atribuicao = $_POST['ds_atribuicao'];
                    $v->nr_salario = Validacao::converterMoedaMysql($_POST['nr_salario']);
                    $v->ds_adicional = $_POST['ds_adicional'];
                    $v->ds_beneficio = $_POST['ds_beneficio'];
                    $v->ds_observacao = $_POST['ds_observacao'];
                    $v->qt_vaga = (!empty($_POST['qt_vaga'])) ? $_POST['qt_vaga'] : 'null';
                    $v->ao_exibenome = (!empty($_POST['ao_exibenome'])) ? 'S' : 'N';
                    $v->ao_exibeemail = (!empty($_POST['ao_exibeemail'])) ? 'S' : 'N';
                    $v->ao_exibetelefone = (!empty($_POST['ao_exibetelefone'])) ? 'S' : 'N';
                    $v->ao_ativo = 'S';
                    $v->ao_sexo = $_POST['ao_sexo'];
                    $v->ao_deficiente = $_POST['ao_deficiente'];
                    $v->ds_estado_civil = $_POST['ds_estado_civil'];
                    $v->ds_idade = $_POST['ds_idade'];
                    $v->ao_experiencia = $_POST['ao_experiencia'];
                    $v->ds_cnh = $_POST['ds_cnh'];

                    $vDAO = new VagaDAO;
                    $flag = $vDAO->cadastrarVaga($v);

                    //Grava na tabela vagaadicional
                    $a = new VagaAdicionalVO();
                    $adicionais = $_POST['ao_adicional'];

                    if(!is_null($adicionais)){
                        foreach ($adicionais as $p){
                            $aDAO = new VagaAdicionalDAO;
                            $a->id_vagaadicional = null;
                            $a->id_vaga = $flag;
                            $a->id_adicional = $p;

                            $aDAO->cadastrarVagaAdicional($a);
                        }
                    }

                    //Grava na tabela vagabeneficio
                    $b = new VagaBeneficioVO();
                    $beneficios = $_POST['ao_beneficio'];

                    if(!is_null($beneficios)){
                        foreach ($beneficios as $be){

                            $bDAO = new VagaBeneficioDAO;
                            $b->id_vagabeneficio = null;
                            $b->id_vaga = $flag;
                            $b->id_beneficio = $be;

                            $bDAO->cadastrarVagaBeneficio($b);
                        }
                    }

                    //Grava na tabela vagaformacao
                    $f = new VagaFormacaoVO();
                    $formacoes = $_POST['ao_formacao'];

                    if(!is_null($formacoes)){
                        foreach ($formacoes as $fo){
                            $fDAO = new VagaFormacaoDAO;
                            $f->id_vagaformacao = null;
                            $f->id_vaga = $flag;
                            $f->id_formacao = $fo;

                            $fDAO->cadastrarVagaFormacao($f);
                        }
                    }

                     //Grava na tabela historicovaga
                    $hv = new HistoricoVagaVO();

                    $historicoVaga = new HistoricoVagaDAO;
                    $hv->id_vaga = $flag;
                    $hv->qt_vaga = $_POST['qt_vaga'];
                    $hv->ao_ativo = "S";
                    $hv->ao_deficiente = $_POST['ao_deficiente'];
                    $historicoVaga->cadastrarHistoricoVaga($hv);

                    if(!is_numeric($flag)){
                        //caso nao, registro uma mensagem
                        ControleSessao::inserirVariavel('msg', 'Ocorreu um erro. Tente novamente!');
                        ControleSessao::inserirVariavel('errosV', $errosV);
                        ControleSessao::inserirVariavel('post', $_POST);
                        //redireciona
                        header('location:../visao/GuiCadVaga.php');
                    }
                    ControleSessao::destruirVariavel('cadVaga');
                    ControleLoginEmpresa::acessarSessao($e);

                    //Busco a profissão e jogo numa variável para mostrar na mensagem de sucesso.
                    $vagaprofissao = Servicos::buscarProfissaoPorId($_POST['id_profissao']);

                    //Mostra a mensagem de vaga cadastrada e redireciona.
                    echo "<script type='text/javascript'> alert('Vaga de ".$vagaprofissao->nm_profissao." cadastrada com sucesso!'); "
                            . "location.href='../visao/GuiVagas.php';</script>";
                    //header('location:../visao/GuiVagas.php');
                }else{
                    //die('CHEGOU AQUI');
                    //registra o array de erros e o post
                    ControleSessao::inserirVariavel('errosV', $errosV);
                    ControleSessao::inserirVariavel('post', $_POST);
                    //redireciona

                    header('location:../visao/GuiCadVaga.php');
                }
            }
            break;

        case 'manutencao':

            if(isset($_POST)){


                $errosV = array();

                if($_POST['id_profissao'] == 'OUTRO'){
                    if(!Validacao::validarNmEmpresa($_POST['ds_outro'])) $errosV[] = 'ds_outro';
                }

                if(!Validacao::validarAtribuicao($_POST['ds_atribuicao'])) $errosV[] = 'ds_atribuicao';
                if(!Validacao::validarMoedaReal($_POST['nr_salario'])) $errosV[] = 'nr_salario';
                //if(!Validacao::validarAtribuicao($_POST['ds_adicional'])) $errosV[] = 'ds_adicional';
                //if(!Validacao::validarAtribuicao($_POST['ds_beneficio'])) $errosV[] = 'ds_beneficio';
                if(!Validacao::validarAtribuicao($_POST['ds_observacao'])) $errosV[] = 'ds_observacao';
                if(!Validacao::validarIdCbo($_POST['qt_vaga'])) $errosV[] = 'qt_vaga';
                if(!Validacao::validarStatus($_POST['ao_ativo'])) $errosV[] = 'ao_ativo';
                if(!Validacao::validarSexo($_POST['ao_sexo'])) $errosV[] = 'ao_sexo';
                //if(!Validacao::validarGenerico('/^[IMF]$/', $_POST['ao_sexo'])) $errosV[] = 'ao_sexo';
                if(!Validacao::validarStatus($_POST['ao_exibenome']) && !empty($_POST['ao_exibenome'])) $errosV[] = 'ao_exibenome';
                if(!Validacao::validarStatus($_POST['ao_exibeemail']) && !empty($_POST['ao_exibeemail'])) $errosV[] = 'ao_exibeemail';
                if(!Validacao::validarStatus($_POST['ao_exibetelefone']) && !empty($_POST['ao_exibetelefone'])) $errosV[] = 'ao_exibetelefone';
                if(!Validacao::validarStatus($_POST['ao_deficiente'])) $errosV[] = 'ao_deficiente';
                if(!Validacao::validarEstadoCivilVaga($_POST['ds_estado_civil'])) $errosV[] = 'ds_estado_civil';
                if(!Validacao::validarIdades($_POST['ds_idade'])) $errosV[] = 'ds_idade';
                if(!Validacao::validarStatus($_POST['ao_experiencia']) && !empty($_POST['ao_experiencia'])) $errosV[] = 'ao_experiencia';
                if(!Validacao::validarCNH($_POST['ds_cnh'])) $errosV[] = 'ds_cnh';

                //valida ao_adicional
                if(isset($_POST['ao_adicional'])){
                    if(is_array($_POST['ao_adicional'])){
                    foreach ($_POST['ao_adicional'] as $idAdicional) {
                            if(!Validacao::validarAdicional('/^[0-9]{0,6}$/', $idAdicional) && !in_array('id_adicional', $errosV)) $errosV[] = 'id_adicional';
                        }
                    }else{
                        $errosV[] = 'id_adicional';
                    }
                }
                //valida ao_beneficio
                if(isset($_POST['ao_beneficio'])){
                    if(is_array($_POST['ao_beneficio'])){
                    foreach ($_POST['ao_beneficio'] as $idBeneficio) {
                            if(!Validacao::validarBeneficio('/^[0-9]{0,6}$/', $idBeneficio) && !in_array('id_beneficio', $errosV)) $errosV[] = 'id_beneficio';
                        }
                    }else{
                        $errosV[] = 'id_beneficio';
                    }
                }
                //valida ao_formacao
                if(isset($_POST['ao_formacao'])){
                    if(is_array($_POST['ao_formacao'])){
                    foreach ($_POST['ao_formacao'] as $idFormacao) {
                            if(!Validacao::validarAoFormacao('/^[0-9]{0,6}$/', $idFormacao) && !in_array('id_Formacao', $errosV)) $errosV[] = 'id_formacao';
                        }
                    }else{
                        $errosV[] = 'id_formacao';
                    }
                }

                //se nao houver erros
                if(count($errosV)==0){
                    if(is_numeric($_POST['id_profissao'])){

                        $vDAO = new VagaDAO();
                        if(!$vDAO->verificarVaga($_POST['id_profissao'], ControleSessao::buscarObjeto('privateEmp')->id_empresa, ControleSessao::buscarObjeto('objVaga')->id_vaga)){
                            ControleSessao::inserirVariavel('msg', 'Há uma vaga ativa para essa profissão.');
                            ControleSessao::inserirVariavel('post', $_POST);
                            ControleSessao::inserirVariavel('errosV', $errosV);
                            header('location:../visao/GuiManutencaoVaga.php');
                            //die();
                        }

                    }else if(!empty($_POST['ds_outro'])){

                        if(Servicos::converterStrtoupper($_POST['ds_outro']) !=
                                Servicos::converterStrtoupper(ControleSessao::buscarObjeto('objVaga')->profissao->nm_profissao)){
                            $p = new ProfissaoVO();
                            $p->nm_profissao = Servicos::converterStrtoupper($_POST['ds_outro']);
                            $p->ao_ativo = 'V';

                            $pDAO = new ProfissaoDAO();
                            $idGeradoProf = $pDAO->cadastrarProfissao($p);

                            $_POST['id_profissao'] = $idGeradoProf;

                            $msg = "<p>Uma nova profissão foi cadastrada no Banco de Oportunidade e aguarda por validação.</p>
                                    <p><b>Profissão:</b> $p->nm_profissao</p>";
                            //envia o email
                            Email::enviarEmail('seuemail@prefeitura.com', 'Validação de Profissão', $msg, 'Moderador(a) do Sistema');

                        }
                    }

                    $va = new VagaVO();
                    $e = ControleSessao::buscarObjeto('privateEmp');
                    $v = ControleSessao::buscarObjeto('objVaga');

                    $va->id_vaga = $v->id_vaga;
                    $va->id_empresa = $e->id_empresa;
                    //$va->id_profissao = (!empty($_POST['id_profissao'])) ? $_POST['id_profissao'] : 'null';
                    $va->id_profissao = $v->id_profissao;
                    $va->ds_atribuicao = $_POST['ds_atribuicao'];
                    $va->nr_salario = Validacao::converterMoedaMysql($_POST['nr_salario']);
                    $va->ds_adicional = $_POST['ds_adicional'];
                    $va->ds_beneficio = $_POST['ds_beneficio'];
                    $va->ds_observacao = $_POST['ds_observacao'];
                    $va->qt_vaga = (!empty($_POST['qt_vaga'])) ? $_POST['qt_vaga'] : 'null';
                    $va->ao_exibenome = (!empty($_POST['ao_exibenome'])) ? 'S' : 'N';
                    $va->ao_exibeemail = (!empty($_POST['ao_exibeemail'])) ? 'S' : 'N';
                    $va->ao_exibetelefone = (!empty($_POST['ao_exibetelefone'])) ? 'S' : 'N';
                    $va->ao_ativo = $_POST['ao_ativo'];
                    $va->ao_sexo = $_POST['ao_sexo'];
                    $va->ao_deficiente = $_POST['ao_deficiente'];
                    $va->ds_estado_civil = $_POST['ds_estado_civil'];
                    $va->ds_idade = $_POST['ds_idade'];
                    $va->ao_experiencia = $_POST['ao_experiencia'];
                    $va->ds_cnh = $_POST['ds_cnh'];

                    //Para mostrar na mensagem de confirmação da edição da vaga.
                    $nomeprofissao = Servicos::buscarProfissaoPorId($v->id_profissao);

                    $vDAO = new VagaDAO;
                    $vDAO->alterarVaga($va);

                    //Gravar na tabela vagaadicional
                    $a = new VagaAdicionalVO();

                    //deleto os existentes
                    $vgexDAO = new VagaAdicionalDAO;
                    $vgexDAO->deletarVagaAdicional($v->id_vaga);

                    //jogo numa variável os novos
                    $adicionais = $_POST['ao_adicional'];

                    //gravo na tabela novamente
                    if(!is_null($adicionais)){
                        foreach ($adicionais as $p){
                            $aDAO = new VagaAdicionalDAO;
                            $a->id_vagaadicional = null;
                            $a->id_vaga = $v->id_vaga;
                            $a->id_adicional = $p;

                            $aDAO->cadastrarVagaAdicional($a);
                        }
                    }

                    //Gravar na tabela vagabeneficio
                    $b = new VagaBeneficioVO();

                    //deleto os existentes
                    $vbexDAO = new VagaBeneficioDAO;
                    $vbexDAO->deletarVagaBeneficio($v->id_vaga);

                    //jogo numa variável os novos
                    $beneficios = $_POST['ao_beneficio'];

                    //gravo na tabela novamente
                    if(!is_null($beneficios)){
                        foreach ($beneficios as $be){
                            $bDAO = new VagaBeneficioDAO;
                            $b->id_vagabeneficio = null;
                            $b->id_vaga = $v->id_vaga;
                            $b->id_beneficio = $be;

                            $bDAO->cadastrarVagaBeneficio($b);
                        }
                    }

                    //Gravar na tabela vagaformacao
                    $f = new VagaFormacaoVO();

                    //deleto os existentes
                    $vfexDAO = new VagaFormacaoDAO;
                    $vfexDAO->deletarVagaFormacao($v->id_vaga);

                    //jogo numa variável os novos
                    $formacoes = $_POST['ao_formacao'];

                    //gravo na tabela novamente
                    if(!is_null($formacoes)){
                        foreach ($formacoes as $fo){
                            $fDAO = new VagaFormacaoDAO;
                            $f->id_vagaformacao = null;
                            $f->id_vaga = $v->id_vaga;
                            $f->id_formacao = $fo;

                            $fDAO->cadastrarVagaFormacao($f);
                        }
                    }

                     //Grava na tabela historicovaga
                    $hv = new HistoricoVagaVO();

                    $historicoVaga = new HistoricoVagaDAO;
                    $hv->id_vaga = $v->id_vaga;
                    $hv->qt_vaga = $_POST['qt_vaga'];
                    $hv->ao_ativo = $_POST['ao_ativo'];
                    $hv->ao_deficiente = $_POST['ao_deficiente'];
                    $historicoVaga->cadastrarHistoricoVaga($hv);

                    $totalEncaminhados = $_POST['encaminhados'];
                    $totalBaixasAutomaticas =  $_POST['baixasAutomaticas'];
                    $totalPreSelecionados = $_POST['preSelecionados'];
                    $totalContratados = $_POST['contratados'];
                    $totalDispensandos = $_POST['dispensados'];


                    $_POST['encaminhados'] = $totalEncaminhados;
                    $_POST['baixasAutomaticas'] = $baixasAutomaticas;
                    $_POST['preSelecionados'] = $totalPreSelecionados;
                    $_POST['contratados'] = $totalContratados;
                    $_POST['dispensados'] = $totalDispensandos;

                    if($_POST['encaminhados'] == null){
                        $_POST['encaminhados'] = 0;
                    }
                    if(($_POST['baixasAutomaticas'] == null)){
                        $_POST['baixasAutomaticas'] = 0;
                    }
                    if($_POST['preSelecionados'] == null){
                        $_POST['preSelecionados'] = 0;
                    }
                    if($_POST['contratados'] == null){
                        $_POST['contratados'] = 0;
                    }
                    if($_POST['dispensados'] == null){
                        $_POST['dispensados'] = 0;
                    }

                    ControleLoginEmpresa::acessarSessao($e);
                    ControleSessao::inserirVariavel('errosV', $errosV);
                    ControleSessao::inserirVariavel('post', $_POST);
                    ControleSessao::inserirObjeto('objVaga',$va);

                    //Mostra a mensagem de vaga atualizada e redireciona.
                    if($_POST['ao_ativo'] == 'S'){
                        echo "<script type='text/javascript'>alert('Vaga de ".$nomeprofissao." editada com sucesso!'); "
                            . "location.href='../visao/GuiManutencaoVaga.php#parte-01';</script>";
                    }else{
                        echo "<script type='text/javascript'>alert('Vaga de ".$nomeprofissao." inativada!'); "
                            . "location.href='../visao/GuiVagas.php';</script>";
                    }

                    //header('location:../visao/GuiManutencaoVaga.php#parte-01');
                }else{
                    //die('AQUI--->');
                    //registra o array de erros e o post
                    ControleSessao::inserirVariavel('errosV', $errosV);
                    ControleSessao::inserirVariavel('post', $_POST);
                    //redireciona
                    header('location:../visao/GuiManutencaoVaga.php');
                }
            }
            break;



        case 'verificarProfissao':

            if(isset($_POST)){
                if(is_numeric($_POST['id_profissao'])){

                        $vDAO = new VagaDAO();
                        if(!$vDAO->verificarVaga($_POST['id_profissao'], ControleSessao::buscarObjeto('privateEmp')->id_empresa, ControleSessao::buscarObjeto('objVaga')->id_vaga)){
                            ControleSessao::inserirVariavel('msg', 'Há uma vaga ativa para essa profissão.');
                            ControleSessao::inserirVariavel('post', $_POST);
                            ControleSessao::inserirVariavel('errosV', $errosV);
                            header('location:../visao/GuiCadVaga.php');
                            //die();
                        }

                 }
            }else{
                $msg = 'Ocorreu um erro, tente novamente.';
                ControleSessao::inserirVariavel('msgVaga', $msg);
                header('location:../visao/GuiCadVaga.php');
            }
        break;

        case 'pegar':
            if(isset($_POST)){

                //array de erros
                $errosV = 0;

                //validacao
                if(!is_numeric($_POST['id_vaga'])) $errosV[] = 'id_vaga';

                if($errosV == 0){

                    $vDAO = new VagaDAO();
                    $v = $vDAO->buscarVaga($_POST['id_vaga']);

                    if(isset($v) && !is_null($v)){

                        $pDAO = new ProfissaoDAO();
                        $v->profissao = $pDAO->buscarProfissao($v->id_profissao);

                        $vcDAO = new VagaCandidatoDAO();
                        $v->encaminhados = $vcDAO->buscarTodosCandidatos($v->id_vaga);
                        //insiro no array para as outras abas para quando for efetuada a pesquisa por código, ele fará individualmente.
                        $tDAO = new VagaCandidatoDAO();
                        $v->todos = $tDAO->buscarCandidatosTodos($v->id_vaga);
                        $eDAO = new VagaCandidatoDAO();
                        $v->resultadoEncaminhados = $eDAO->buscarCandidatosEncaminhados($v->id_vaga);
                        $bDAO = new VagaCandidatoDAO();
                        $v->baixasAutomaticas = $bDAO->buscarCandidatosBaixasAutomaticas($v->id_vaga);
                        $psDAO = new VagaCandidatoDAO();
                        $v->preSelecionados = $psDAO->buscarCandidatosPreSelecionados($v->id_vaga);
                        $conDAO = new VagaCandidatoDAO();
                        $v->contratados = $conDAO->buscarCandidatosContratados($v->id_vaga);
                        $dDAO = new VagaCandidatoDAO();
                        $v->dispensados = $dDAO->buscarCandidatosDispensados($v->id_vaga);

                        ControleSessao::inserirObjeto('objVaga', $v);
                        header('location:../visao/GuiManutencaoVaga.php#parte-02');

                    }
                }else{
                    $msg = 'Ocorreu um erro, tente novamente.';
                    ControleSessao::inserirVariavel('msgVaga', $msg);
                    header('location:../visao/GuiManutencaoVaga.php');
                }
            }else{
                $msg = 'Ocorreu um erro, tente novamente.';
                ControleSessao::inserirVariavel('msgVaga', $msg);
                header('location:../visao/GuiManutencaoVaga.php');
            }
            break;

         case 'contrataCandidato':

            if(isset($_POST)){

                if(!Validacao::validarIdCandidato($_POST['id_vagacandidato'])) $errosContratado[] = 'id_contratado';

                if($errosV == 0){

                    $vcDAO = new VagaCandidatoDAO();
                    $contratado = $vcDAO->contratarDireto($_POST['id_vagacandidato']);

                    $v = ControleSessao::buscarObjeto('objVaga');

                    $en = null;

                    date_default_timezone_set('America/Sao_Paulo');

                    foreach($v->encaminhados as $aux){
                        if($aux->id_vagacandidato == $_POST['id_vagacandidato']) $en = $aux;
                    }

                    $emailCand = $en->ds_email;
                    $nomeCand = $en->nm_candidato;


                    //Exibe Empresa
                    if($v->ao_exibenome == 'S'){
                        $exibeEmpresa = "Empresa: <b>" .Servicos::buscarEmpresaPorId($v->id_empresa)->nm_razaosocial."</b>";
                    }else{
                        $exibeEmpresa = "Empresa: <b>Confidencial</b>";
                    }

                    //exibeResponsavel
                    if($v->ao_exibetelefone == 'S' || $v->ao_exibeemail == 'S'){
                        $exibeResponsavel = "<br />Contato: " .Servicos::buscarEmpresaPorId($v->id_empresa)->nm_proprietario;
                    }else{
                        $exibeResponsavel = "";
                    }

                    //Divulgar telefone
                    if($v->ao_exibetelefone == 'S'){
                        $exibeTelefone = "<br />Telefone: " .Servicos::buscarEmpresaPorId($v->id_empresa)->nr_celular;
                    }else{
                        $exibeTelefone = "";
                    }

                    //Divulgar email
                    if($v->ao_exibeemail == 'S'){
                        $exibeEmail = "<br />Email: " .Servicos::buscarEmpresaPorId($v->id_empresa)->ds_emailproprietario;
                    }else{
                        $exibeEmail = "";
                    }

                    //Contatos da Empresa

                    if(empty($exibeResponsavel) && (empty($exibeTelefone)) && (empty($exibeEmail))){
                        $contato = "Aguarde contato da empresa.";
                    }else{
                        $contato = "<p>Para maiores informações entre em contato com: <br/>"
                                            .
                                            $exibeEmpresa
                                            .
                                            $exibeResponsavel
                                            .
                                            $exibeTelefone
                                            .
                                            $exibeEmail
                                            .
                                    "</p>";
                    }


                    //Email para candidato
                    $assunto = 'Banco de Oportunidade - Contratação';
                    $corpo = '<p>
                                Você foi contratado(a) pela empresa '.Servicos::buscarEmpresaPorId($v->id_empresa)->nm_razaosocial.' para a vaga de '.Servicos::buscarProfissaoPorIdVaga($v->id_vaga).'.</p>
                            <p>'. $contato .'</p>';

                    Email::enviarEmail($emailCand, $assunto, $corpo, $nomeCand);

                    //instancia um dao
                    $cDAO = new CandidatoDAO();
                    //busca os candidatos no bd
                    $candidatosContratados = $cDAO->buscarContratado($query, ControleSessao::buscarObjeto('privateEmp')->id_empresa);

                    ControleSessao::inserirObjeto('candidatosContratados', $candidatosContratados);

                    //historico
                    $hc = new HistoricoCandidatoVO();
                    $hc->id_historico = null;
                    $hc->id_vagacandidato = $_POST['id_vagacandidato'];
                    $hc->id_usuario = ControleSessao::buscarObjeto('privateEmp')->id_empresa;
                    $hc->id_motivo = 'null';
                    $hc->ds_motivodispensa = '';
                    $hc->ao_status = "C";
                    $hc->dt_cadastro = 'NOW()';

                    $hcDAO = new HistoricoCandidatoDAO();
                    $hcDAO->cadastrarHistoricoCandidato($hc);

                    header('location:../visao/GuiContratar.php');

                }else{
                    $msg = 'Ocorreu um erro, tente novamente.';
                    ControleSessao::inserirVariavel('msgContratar', $msg);
                    header('location:../visao/GuiContratar.php');
            }

            }else{
                $msg = 'Ocorreu um erro, tente novamente.';
                ControleSessao::inserirVariavel('msgContratar', $msg);
                header('location:../visao/GuiContratar.php');
            }
            break;

        case 'registrar':

            if(isset($_POST)){

                //array de erros
                $errosV = array();

                //validacao
                if(!Validacao::validarStatusEncaminhado($_POST['ao_status'])) $errosV++;

                if(count($errosV)==0){

                    $v = ControleSessao::buscarObjeto('objVaga');

                    //Exibe Empresa
                    if($v->ao_exibenome == 'S'){
                        $exibeEmpresa = "Empresa: <b>" .Servicos::buscarEmpresaPorId($v->id_empresa)->nm_razaosocial."</b>";
                    }else{
                        //Exibe empresa se for contratado
                        if($_POST['ao_status'] == "C"){
                            $exibeEmpresa = "Empresa: <b>" .Servicos::buscarEmpresaPorId($v->id_empresa)->nm_razaosocial."</b>";
                        }else{
                            $exibeEmpresa = "Empresa: <b>Confidencial</b>";
                        }
                    }

                    //exibeResponsavel
                    if($v->ao_exibetelefone == 'S' || $v->ao_exibeemail == 'S'){
                        $exibeResponsavel = "<br />Contato: " .Servicos::buscarEmpresaPorId($v->id_empresa)->nm_proprietario;
                    }else{
                        $exibeResponsavel = "";
                    }

                    //Divulgar telefone
                    if($v->ao_exibetelefone == 'S'){
                        $exibeTelefone = "<br />Telefone: " .Servicos::buscarEmpresaPorId($v->id_empresa)->nr_celular;
                    }else{
                        $exibeTelefone = "";
                    }

                    //Divulgar email
                    if($v->ao_exibeemail == 'S'){
                        $exibeEmail = "<br />Email: " .Servicos::buscarEmpresaPorId($v->id_empresa)->ds_emailproprietario;
                    }else{
                        $exibeEmail = "";
                    }

                    //Contatos da Empresa

                    if(empty($exibeResponsavel) && (empty($exibeTelefone)) && (empty($exibeEmail))){
                        $contato = "Aguarde contato da empresa.";
                    }else{
                        $contato = "<p>Para maiores informações entre em contato com: <br/>"
                                            .
                                            $exibeEmpresa
                                            .
                                            $exibeResponsavel
                                            .
                                            $exibeTelefone
                                            .
                                            $exibeEmail
                                            .
                                    "</p>";
                    }

                    $en = null;

                    date_default_timezone_set('America/Sao_Paulo');

                    foreach($v->encaminhados as $aux){
                        if($aux->id_vagacandidato == $_POST['id_vagacandidato']){
                            $en = $aux;
                        }
                    }
                    foreach($v->todos as $aux1){
                        if($aux1->id_vagacandidato == $_POST['id_vagacandidato']){
                            $en1 = $aux1;
                        }
                    }
                    foreach($v->resultadoEncaminhados as $aux2){
                        if($aux2->id_vagacandidato == $_POST['id_vagacandidato']){
                            $en2 = $aux2;
                        }
                    }
                    foreach($v->preSelecionados as $aux3){
                        if($aux3->id_vagacandidato == $_POST['id_vagacandidato']){
                            $en3 = $aux3;
                        }
                    }


                    $emailCand = $en->ds_email;
                    $nomeCand = $en->nm_candidato;

                    if($en==null){ echo false;die; }

                    if($en->ao_status == 'E'){
                        $en->ao_status = $_POST['ao_status'];
                        $en1->ao_status = $_POST['ao_status'];
                        $en2->ao_status = $_POST['ao_status'];
                        $en3->ao_status = $_POST['ao_status'];
                        $en->dt_status = date('Y-m-d H:i:s');
                        $en->id_interno = $_POST['id_interno'];


                        $vcDAO = new VagaCandidatoDAO();
                        $vcDAO->alterarStatus($en);

                        if(!empty($en->id_interno)){
                            Servicos::salvarLogInterno($en);
                        }

                        if($en->ao_status == 'C'){

                            $v->qt_vaga--;
                            ControleSessao::inserirObjeto('objVaga', $v);

                            $vDAO = new VagaDAO();
                            $vDAO->alterarVaga($v);


                            //Email para candidato
                            $assunto = 'Banco de Oportunidade - Contratação';
                            $corpo = '<p>
                                        Você foi contratado(a) pela empresa '.Servicos::buscarEmpresaPorId($v->id_empresa)->nm_razaosocial.' para a vaga de '.Servicos::buscarProfissaoPorIdVaga($v->id_vaga).'.</p>
                                    <p>'. $contato .'</p>';

                            Email::enviarEmail($emailCand, $assunto, $corpo, $nomeCand);

                        }else if($en->ao_status == 'P'){
                            //Se somente exibeempresa for sim
                            if(($v->ao_exibenome == 'S') && ($v->ao_exibeemail == 'N') && ($v->ao_exibetelefone == 'N')){
                                $contato = "Aguarde contato da empresa " .Servicos::buscarEmpresaPorId($v->id_empresa)->nm_razaosocial."." ;
                            }
                            //Email para candidato
                            $assunto = 'Banco de Oportunidade - Pré-seleção';
                            $corpo = '<p>Você foi pré-selecionado(a) para a vaga de '.Servicos::buscarProfissaoPorIdVaga($v->id_vaga).'.</p>
                                      <p>'. $contato .'</p>';

                            Email::enviarEmail($emailCand, $assunto, $corpo, $nomeCand);
                        }
                    }else if($en->ao_status == 'P'){
                        $en->ao_status = $_POST['ao_status'];
                        $en1->ao_status = $_POST['ao_status'];
                        $en2->ao_status = $_POST['ao_status'];
                        $en3->ao_status = $_POST['ao_status'];
                        $en->dt_status = date('Y-m-d H:i:s');
                        $en->id_interno = $_POST['id_interno'];

                        $vcDAO = new VagaCandidatoDAO();
                        $vcDAO->alterarStatus($en);

                        if(!empty($en->id_interno)){
                            Servicos::salvarLogInterno($en);
                        }

                        if($en->ao_status == 'C'){

                            $v->qt_vaga--;
                            ControleSessao::inserirObjeto('objVaga', $v);

                            $vDAO = new VagaDAO();
                            $vDAO->alterarVaga($v);

                            //Email para candidato
                            $assunto = 'Banco de Oportunidade - Contratação';
                            $corpo = '<p>
                                        Você foi contratado(a) pela '.Servicos::buscarEmpresaPorId($v->id_empresa)->nm_razaosocial.' para a vaga de '.Servicos::buscarProfissaoPorIdVaga($v->id_vaga).'.</p>
                                    <p>'. $contato .'</p>';


                            Email::enviarEmail($emailCand, $assunto, $corpo, $nomeCand);

                        }else if($en->ao_status == 'P'){
                            //Se somente exibeempresa for sim
                            if(($v->ao_exibenome == 'S') && ($v->ao_exibeemail == 'N') && ($v->ao_exibetelefone == 'N')){
                                $contato = "Aguarde contato da empresa " .Servicos::buscarEmpresaPorId($v->id_empresa)->nm_razaosocial."." ;
                            }
                            //Email para candidato
                            $assunto = 'Banco de Oportunidade - Pré-seleção';
                            $corpo = '<p>Você foi pré-selecionado(a) para a vaga de '.Servicos::buscarProfissaoPorIdVaga($v->id_vaga).'.</p>
                                      <p>'. $contato .'</p>';

                            Email::enviarEmail($emailCand, $assunto, $corpo, $nomeCand);
                        }
                    }


                    ControleSessao::inserirObjeto('objVaga', $v);

                    //historico
                    $hc = new HistoricoCandidatoVO();
                    $hc->id_historico = null;
                    $hc->id_vagacandidato = $_POST['id_vagacandidato'];
                    $hc->id_usuario = ControleSessao::buscarObjeto('privateEmp')->id_empresa;
                    $hc->id_motivo = 'null';
                    $hc->ds_motivodispensa = '';
                    $hc->ao_status = $_POST['ao_status'];
                    $hc->dt_cadastro = 'NOW()';

                    $hcDAO = new HistoricoCandidatoDAO();
                    $hcDAO->cadastrarHistoricoCandidato($hc);

                    echo true;

                }else{
                    echo false;
                }
            }else{
                echo false;
            }
            break;

        case 'verificarVaga':


            if(isset($_POST)){

                $errosV = array();

                //validacao
                if(!Validacao::validarGenerico('/^[0-9]{1,8}$/', $_POST['id_vaga'])) $errosV++;

                if(count($errosV)==0){

                    $id_vaga = $_POST['id_vaga'];

                    $vDAO = new VagaDAO();
                    $auxVaga = $vDAO->buscarQtVaga($id_vaga);

                    echo $auxVaga->qt_vaga;die;

               }

            }else{
                echo false;die;
            }

            break;

        case 'atualizarSessaoQtdCandidatos':

            if($_SESSION['post']){
                $totalEncaminhados = $_SESSION['post']['encaminhados'];
                $totalBaixasAutomaticas = $_SESSION['post']['baixasAutomaticas'];
                $totalPreSelecionados = $_SESSION['post']['preSelecionados'];
                $totalContratados = $_SESSION['post']['contratados'];
                $totalDispensandos = $_SESSION['post']['dispensados'];


                if($_POST['vem_do'] == 'E'){
                    $totalEncaminhados--;
                }else if($_POST['vem_do'] == 'P'){
                    $totalPreSelecionados--;
                }

                if($_POST['ao_status'] == 'P'){
                    $totalPreSelecionados++;
                }else if($_POST['ao_status'] == 'C'){
                    $totalContratados++;
                }else if($_POST['ao_status'] == 'D'){
                    $totalDispensandos++;
                }

                $_POST['encaminhados'] = $totalEncaminhados;
                $_POST['baixasAutomaticas'] = $baixasAutomaticas;
                $_POST['preSelecionados'] = $totalPreSelecionados;
                $_POST['contratados'] = $totalContratados;
                $_POST['dispensados'] = $totalDispensandos;


                ControleSessao::inserirVariavel('post', $_POST);

                $v = ControleSessao::buscarObjeto('objVaga');

                ControleSessao::inserirObjeto('objVaga', $v);

            }

            break;

        case 'sinalizar':

            if (isset($_POST['imprimir'])) {

                if(!Validacao::validarIdCandidatoFormacao($_POST['id_candidato'])) $errosI[] = 'id_candidato';

                if(count($errosI)==0){

                    $cDAO = new CandidatoDAO();
                    $c = $cDAO->buscarPorId($_POST['id_candidato']);

                    if(!is_bool($c) && !is_null($c)){

                        $cfDAO = new CandidatoFormacaoDAO();
                        $c->formacoes = $cfDAO->buscarCandidatoFormacoes($c->id_candidato);

                        $cqDAO = new CandidatoQualificacaoDAO();
                        $c->qualificacoes = $cqDAO->buscarCandidatoQualificacoes($c->id_candidato);

                        $ceDAO = new CandidatoExperienciaDAO();
                        $c->experiencias = $ceDAO->buscarCandidatoExperiencias($c->id_candidato);

                        $cp = new CandidatoProfissaoDAO();
                        $c->profissoes = $cp->buscarCandidatoProfissoesSimples($c->id_candidato);

                        $candidatos[] = $c;

                    }else{
                        ControleSessao::inserirVariavel('errosI', 'Ocorreu um erro. Tente novamente!');
                        header('location:../visao/GuiManutencaoVaga.php#parte-02');
                    }

                    //gera o curriculo .pdf
                    Imprimir::imprimirCurriculoCompletoCandidato($candidatos);

                }else{
                    ControleSessao::inserirVariavel('errosI', 'Ocorreu um erro. Tente novamente!');
                    header('location:../visao/GuiManutencaoVaga.php#parte-02');
                }

            }else if(isset($_POST)){
                    //echo"aaaa"; die;

                    //array de erros
                    $errosV = array();;

                    //validacao
                    foreach ($_POST as $status) {
                        if(!Validacao::validarStatusEncaminhado($status)) $errosV++;
                    }
                    if(!Validacao::validarGenerico('/^[0-9]{1,6}$/', $_POST['id_vagacandidato'])) $errosV[] = 'id_vagacandidato';
                    if(!Validacao::validarGenerico('/^[Outros0-9]{1,6}$/', $_POST['id_motivo']) ) $errosV[] = 'id_motivo';
                    if($_POST['id_motivo'] == 'Outros'){
                        if(!Validacao::validarGenerico('/^[0-9a-zA-ZçÇáéíóúàâêîôûãõÁÉÍÓÚÀÂÊÎÔÛÃÕ!?\-\,\:\.\%\+\$\@ ]{1,1000}$/m', $_POST['ds_motivo']) ) $errosV[] = 'ds_motivo';
                    }

                    if(count($errosV)==0){

                        $v = ControleSessao::buscarObjeto('objVaga');

                        date_default_timezone_set('America/Sao_Paulo');
                        foreach($v->encaminhados as $aux){
                            if($aux->id_vagacandidato == $_POST['id_vagacandidato']) $en = $aux;
                        }

                        if($en->ao_status == 'E' || $en->ao_status == 'P'){

                            foreach ($_POST as $enc) {
                                if($enc == 'D'){
                                    $en->ao_status = $enc;
                                }
                            }

                            $en->dt_status = date('Y-m-d H:i:s');

                            $vcDAO = new VagaCandidatoDAO();
                            $vcDAO->alterarStatus($en);


                            $hc = new HistoricoCandidatoVO();
                            $hc->id_historico = null;
                            $hc->id_vagacandidato = $_POST['id_vagacandidato'];
                            $hc->id_usuario = ControleSessao::buscarObjeto('privateEmp')->id_empresa;
                            $hc->id_motivo = ($_POST['id_motivo'] != 'Outros') ? $_POST['id_motivo'] : 'null';
                            $hc->ds_motivodispensa = (!empty($_POST['ds_motivo'])) ? $_POST['ds_motivo'] : '';
                            $hc->ao_status = $en->ao_status;

                            $hc->dt_cadastro = 'NOW()';

                            $hcDAO = new HistoricoCandidatoDAO();
                            $hcDAO->cadastrarHistoricoCandidato($hc);

                        }

                        ControleSessao::destruirVariavel('objVaga');
                        ControleSessao::inserirObjeto('objVaga',$v);

                        $msg = 'Alteração concluída';

                    }else{
                        $msg = 'Ocorreu um erro, tente novamente.';
                        ControleSessao::inserirVariavel('post', $_POST);
                    }
                    ControleSessao::inserirVariavel('msgEn', $msg);
                    header('location:../visao/GuiManutencaoVaga.php#parte-02');
                }

            break;

        case 'sinalizarEnc':

            if (isset($_POST['imprimir'])) {

                if(!Validacao::validarIdCandidatoFormacao($_POST['id_candidato'])) $errosI[] = 'id_candidato';

                if(count($errosI)==0){

                    $cDAO = new CandidatoDAO();
                    $c = $cDAO->buscarPorId($_POST['id_candidato']);

                    if(!is_bool($c) && !is_null($c)){

                        $cfDAO = new CandidatoFormacaoDAO();
                        $c->formacoes = $cfDAO->buscarCandidatoFormacoes($c->id_candidato);

                        $cqDAO = new CandidatoQualificacaoDAO();
                        $c->qualificacoes = $cqDAO->buscarCandidatoQualificacoes($c->id_candidato);

                        $ceDAO = new CandidatoExperienciaDAO();
                        $c->experiencias = $ceDAO->buscarCandidatoExperiencias($c->id_candidato);

                        $cp = new CandidatoProfissaoDAO();
                        $c->profissoes = $cp->buscarCandidatoProfissoesSimples($c->id_candidato);

                        $candidatos[] = $c;

                    }else{
                        ControleSessao::inserirVariavel('errosI', 'Ocorreu um erro. Tente novamente!');
                        header('location:../visao/GuiManutencaoVaga.php#parte-03');
                    }

                    //gera o curriculo .pdf
                    Imprimir::imprimirCurriculoCompletoCandidato($candidatos);

                }else{
                    ControleSessao::inserirVariavel('errosI', 'Ocorreu um erro. Tente novamente!');
                    header('location:../visao/GuiManutencaoVaga.php#parte-03');
                }

            }else if(isset($_POST)){

                    //array de erros
                    $errosV = array();;

                    //validacao
                    foreach ($_POST as $status) {
                        if(!Validacao::validarStatusEncaminhado($status)) $errosV++;
                    }

                    if(!Validacao::validarGenerico('/^[0-9]{1,6}$/', $_POST['id_vagacandidato'])) $errosV[] = 'id_vagacandidato';
                    if(!Validacao::validarGenerico('/^[Outros0-9]{1,6}$/', $_POST['id_motivo']) ) $errosV[] = 'id_motivo';
                    if($_POST['id_motivo'] == 'Outros'){
                        if(!Validacao::validarGenerico('/^[0-9a-zA-ZçÇáéíóúàâêîôûãõÁÉÍÓÚÀÂÊÎÔÛÃÕ!?\-\,\:\.\%\+\$\@ ]{1,1000}$/m', $_POST['ds_motivo']) ) $errosV[] = 'ds_motivo';
                    }

                    if(count($errosV)==0){

                        $v = ControleSessao::buscarObjeto('objVaga');

                        //Define de qual aba vem para poder jogar num foreach.
                        if($_POST["vem_do"] == "E"){
                            $vem = $v->resultadoEncaminhados;
                        }else if($_POST["vem_do"] == "P"){
                            $vem = $v->preSelecionados;
                        }

                        date_default_timezone_set('America/Sao_Paulo');
                        foreach($vem as $aux){
                            if($aux->id_vagacandidato == $_POST['id_vagacandidato']) $en = $aux;
                        }

                        if($en->ao_status == 'E' || $en->ao_status == 'P'){

                            foreach ($_POST as $enc) {
                                if($enc == 'D'){
                                    $en->ao_status = $enc;
                                }
                            }

                            $en->dt_status = date('Y-m-d H:i:s');

                            $vcDAO = new VagaCandidatoDAO();
                            $vcDAO->alterarStatus($en);

                            $hc = new HistoricoCandidatoVO();
                            $hc->id_historico = null;
                            $hc->id_vagacandidato = $_POST['id_vagacandidato'];
                            $hc->id_usuario = ControleSessao::buscarObjeto('privateEmp')->id_empresa;
                            $hc->id_motivo = ($_POST['id_motivo'] != 'Outros') ? $_POST['id_motivoEnc'] : 'null';
                            $hc->ds_motivodispensa = (!empty($_POST['ds_motivoEnc'])) ? $_POST['ds_motivoEnc'] : '';
                            $hc->ao_status = $en->ao_status;

                            $hc->dt_cadastro = 'NOW()';

                            $hcDAO = new HistoricoCandidatoDAO();
                            $hcDAO->cadastrarHistoricoCandidato($hc);

                        }

                        ControleSessao::destruirVariavel('objVaga');
                        ControleSessao::inserirObjeto('objVaga',$v);

                        $msg = 'Alteração concluída';

                    }else{
                        $msg = 'Ocorreu um erro, tente novamente.';
                        ControleSessao::inserirVariavel('post', $_POST);
                    }

                    ControleSessao::inserirVariavel('msgEn', $msg);
                    if($_POST['vem_do'] == "E"){
                        header('location:../visao/GuiManutencaoVaga.php#parte-03');
                    }else if($_POST['vem_do'] == "P"){
                        header('location:../visao/GuiManutencaoVaga.php#parte-05');
                    }

                }

            break;


        /***************************************************************************************************************
         *  BUSCAR
         **************************************************************************************************************/
        case 'buscar':
            if(isset($_POST)){

                //array de erros
                $errosV = array();

                //valido todos os dados
                if(!Validacao::validarFiltroIdCidade($_POST['filtro_profissao'])) $errosV[] = 'filtro_profissao';
                if(!Validacao::validarFiltroStatus($_POST['filtro_status'])) $errosV[] = 'filtro_status';

                //se nao tiver erros
                if(count($errosV) == 0){

                    $e = ControleSessao::buscarObjeto('privateEmp');
                    //monta query
                    $query = '';

                    if(!empty($_POST['filtro_profissao'])){
                        $query .= " and p.id_profissao = ".$_POST['filtro_profissao'];
                    }
                    if($_POST['filtro_status']){
                        $query .= " and v.ao_ativo = '".$_POST['filtro_status']."'";
                    }

                    //instancia um dao
                    $vDAO = new VagaDAO();
                    //busca os candidatos no bd
                    $vagas = $vDAO->buscarVagasEmpresa($e->id_empresa, $query);
                    //insiro na sessao o array de candidatos
                    $e->empresa_vagas = $vagas;

                    ControleSessao::inserirObjeto('privateEmp', $e);

                    //insiro na sessao os filtros
                    ControleSessao::inserirVariavel('post', $_POST);

                    //redireciono
                    header('location:../visao/GuiVagas.php');

                }else{
                    //registro o array de erros e o post
                    ControleSessao::inserirVariavel('errosV', $errosV);

                    ControleSessao::inserirVariavel('post', $_POST);
                    //redireciono
                    header('location:../visao/GuiVagas.php');
                }
            }
        break;

        /***************************************************************************************************************
         *  PESQUISAR
         **************************************************************************************************************/
        case 'pesquisar':

            if(isset($_POST)){

                //Caso a pesquisa já foi feita em alguma aba e retornou um erro após for feita nova pesquisa esse erro sai.
                ControleSessao::destruirVariavel('errosTodos');
                ControleSessao::destruirVariavel('errosEncaminhados');
                ControleSessao::destruirVariavel('errosBaixasAutomaticas');
                ControleSessao::destruirVariavel('errosPreSelecionados');
                ControleSessao::destruirVariavel('errosContratados');
                ControleSessao::destruirVariavel('errosDispensados');

                //array de erros
                $errosV = array();

                //valido todos os dados
                if(!Validacao::validarFiltroIdCidade($_POST['filtro_codigo'])) $errosV[] = 'filtro_codigo';
                //if(!Validacao::validarNome($_POST['filtro_nome'])) $errosV[] = 'filtro_nome';
                if(!Validacao::validarFiltroStatusEncaminhado($_POST['filtro_status'])) $errosV[] = 'filtro_status';


                //se nao tiver erros
                if(count($errosV) == 0){

                    $e = ControleSessao::buscarObjeto('privateEmp');
                    $v = ControleSessao::buscarObjeto('objVaga');
                    //monta query

                    //pesquiso por código
                    if(!empty($_POST['filtro_codigo'])){
                        $query .= " and vc.id_candidato = ".$_POST['filtro_codigo'];
                    }

                    //pesquiso por nome
                    if(!empty($_POST['filtro_nome'])){
                        $query .= " and c.nm_candidato like '%".$_POST['filtro_nome']."%'";
                    }

                    if($_POST['filtro_status']){
                        $query .= " and vc.ao_status = '".$_POST['filtro_status']."'";
                    }
                    //instancia um dao
                    $vcDAO = new VagaCandidatoDAO();
                    //busca os candidatos no bd
                    $encaminhados = $vcDAO->buscarTodosCandidatos($v->id_vaga, $query);
                    //insiro na sessao o array de candidatos

                    $v->encaminhados = $encaminhados;

                    /* Insiro na sessão o true para a mensagem de pesquisa não sumir quando for feita uma pesquisa em outra aba.
                    ex.: Fez a pesquisa e não retornou nada: Não há resultados para sua busca por candidatos encaminhados,
                    quando a mesma pesquisa for feita em outra aba essa mensagem não irá sumir nesta aba. */
                    $v->pesqTodos = true;

                    ControleSessao::inserirObjeto('objVaga', $v);

                    /*Retorna somente ao campo de busca por código da aba todos,
                    assim ele não irá preencher os outros campos de busca das outras abas. */
                    $_POST['filtro_codigo_todos'] = $_POST['filtro_codigo'];
                    $_POST['filtro_nome_todos'] = $_POST['filtro_nome'];




                    //insiro na sessao os filtros
                    ControleSessao::inserirVariavel('post', $_POST);

                    //redireciono
                    header('location:../visao/GuiManutencaoVaga.php#parte-02');

                }else{
                    //registro o array de erros e o post
                    ControleSessao::inserirVariavel('errosV', $errosV);
                    ControleSessao::inserirVariavel('post', $_POST);
                    //redireciono
                    header('location:../visao/GuiManutencaoVaga.php#parte-02');
                }
            }
        break;

         /***************************************************************************************************************
         *  PESQUISAR TODOS
         **************************************************************************************************************/
        case 'pesquisarTodos':

            if(isset($_POST)){

                //Caso a pesquisa já foi feita em alguma aba e retornou um erro após for feita nova pesquisa esse erro sai.
                ControleSessao::destruirVariavel('errosTodos');
                ControleSessao::destruirVariavel('errosEncaminhados');
                ControleSessao::destruirVariavel('errosBaixasAutomaticas');
                ControleSessao::destruirVariavel('errosPreSelecionados');
                ControleSessao::destruirVariavel('errosContratados');
                ControleSessao::destruirVariavel('errosDispensados');

                //array de erros
                $errosTodos = array();

                //valido todos os dados
                if(!Validacao::validarFiltroIdCidade($_POST['filtro_codigo'])) $errosTodos[] = 'filtro_codigo';
                //if(!Validacao::validarNome($_POST['filtro_nome'])) $errosEncaminhados[] = 'filtro_nome';
                if(!Validacao::validarFiltroStatusEncaminhado($_POST['filtro_status'])) $errosTodos[] = 'filtro_status';

                //se nao tiver erros

                if(count($errosTodos) == 0){

                    $e = ControleSessao::buscarObjeto('privateEmp');
                    $v = ControleSessao::buscarObjeto('objVaga');
                    //monta query

                    //pesquiso por código
                    if(!empty($_POST['filtro_codigo'])){
                        $query .= " and vc.id_candidato = ".$_POST['filtro_codigo'];
                    }

                    //pesquiso por nome
                    if(!empty($_POST['filtro_nome'])){
                        $query .= " and c.nm_candidato like '%".$_POST['filtro_nome']."%'";
                    }

                    if($_POST['filtro_status']){
                        $query .= " and vc.ao_status = '".$_POST['filtro_status']."'";
                    }

                    //instancia um dao
                    $vcDAO = new VagaCandidatoDAO();
                    //busca os candidatos no bd
                    $todos = $vcDAO->buscarTodosCandidatos($v->id_vaga, $query);
                    //insiro na sessao o array de candidatos
                    $v->todos = $todos;
                    /* Insiro na sessão o true para a mensagem de pesquisa não sumir quando for feita uma pesquisa em outra aba.
                    ex.: Fez a pesquisa e não retornou nada: Não há resultados para sua busca por candidatos encaminhados,
                    quando a mesma pesquisa for feita em outra aba essa mensagem não irá sumir nesta aba. */
                    $v->pesqTodos = true;

                    ControleSessao::inserirObjeto('objVaga', $v);

                    /*Retorna somente ao campo de busca por código da aba encaminhados,
                    assim ele não irá preencher os outros campos de busca das outras abas. */
                    $_POST['filtro_codigo_todos'] = $_POST['filtro_codigo'];
                    $_POST['filtro_nome_todos'] = $_POST['filtro_nome'];

                    //insiro na sessao os filtros
                    ControleSessao::inserirVariavel('post', $_POST);

                    //redireciono
                    header('location:../visao/GuiManutencaoVaga.php#parte-02');

                }else{
                    //registro o array de erros e o post
                    ControleSessao::inserirVariavel('errosTodos', $errosTodos);
                    ControleSessao::inserirVariavel('post', $_POST);
                    //redireciono
                    header('location:../visao/GuiManutencaoVaga.php#parte-02');
                }
            }
        break;

        /***************************************************************************************************************
         *  PESQUISAR ENCAMINHADOS
         **************************************************************************************************************/
        case 'pesquisarEncaminhados':

            if(isset($_POST)){

                //Caso a pesquisa já foi feita em alguma aba e retornou um erro após for feita nova pesquisa esse erro sai.
                ControleSessao::destruirVariavel('errosV');
                ControleSessao::destruirVariavel('errosEncaminhados');
                ControleSessao::destruirVariavel('errosBaixasAutomaticas');
                ControleSessao::destruirVariavel('errosPreSelecionados');
                ControleSessao::destruirVariavel('errosContratados');
                ControleSessao::destruirVariavel('errosDispensados');

                //array de erros
                $errosEncaminhados = array();

                //valido todos os dados
                if(!Validacao::validarFiltroIdCidade($_POST['filtro_codigo'])) $errosEncaminhados[] = 'filtro_codigo';
                //if(!Validacao::validarNome($_POST['filtro_nome'])) $errosEncaminhados[] = 'filtro_nome';
                if(!Validacao::validarFiltroStatusEncaminhado($_POST['filtro_status'])) $errosEncaminhados[] = 'filtro_status';

                //se nao tiver erros

                if(count($errosEncaminhados) == 0){

                    $e = ControleSessao::buscarObjeto('privateEmp');
                    $v = ControleSessao::buscarObjeto('objVaga');
                    //monta query

                    //pesquiso por código
                    if(!empty($_POST['filtro_codigo'])){
                        $query .= " and vc.id_candidato = ".$_POST['filtro_codigo'];
                    }

                    //pesquiso por nome
                    if(!empty($_POST['filtro_nome'])){
                        $query .= " and c.nm_candidato like '%".$_POST['filtro_nome']."%'";
                    }

                    if($_POST['filtro_status']){
                        $query .= " and vc.ao_status = '".$_POST['filtro_status']."'";
                    }

                    //instancia um dao
                    $vcDAO = new VagaCandidatoDAO();
                    //busca os candidatos no bd
                    $encaminhados = $vcDAO->buscarTodosCandidatos($v->id_vaga, $query);
                    //insiro na sessao o array de candidatos
                    $v->resultadoEncaminhados = $encaminhados;
                    /* Insiro na sessão o true para a mensagem de pesquisa não sumir quando for feita uma pesquisa em outra aba.
                    ex.: Fez a pesquisa e não retornou nada: Não há resultados para sua busca por candidatos encaminhados,
                    quando a mesma pesquisa for feita em outra aba essa mensagem não irá sumir nesta aba. */
                    $v->pesqEncaminhados = true;


                    ControleSessao::inserirObjeto('objVaga', $v);

                    /*Retorna somente ao campo de busca por código da aba encaminhados,
                    assim ele não irá preencher os outros campos de busca das outras abas. */
                    $_POST['filtro_codigo_encaminhados'] = $_POST['filtro_codigo'];
                    $_POST['filtro_nome_encaminhados'] = $_POST['filtro_nome'];



                    //insiro na sessao os filtros
                    ControleSessao::inserirVariavel('post', $_POST);

                    //redireciono
                    header('location:../visao/GuiManutencaoVaga.php#parte-03');


                }else{
                    //registro o array de erros e o post
                    ControleSessao::inserirVariavel('errosEncaminhados', $errosEncaminhados);
                    ControleSessao::inserirVariavel('post', $_POST);
                    //redireciono
                    header('location:../visao/GuiManutencaoVaga.php#parte-03');
                }
            }
        break;

        /***************************************************************************************************************
         *  PESQUISAR BAIXAS AUTOMÁTICAS
         **************************************************************************************************************/
        case 'pesquisarBaixasAutomaticas':

            if(isset($_POST)){

                //Caso a pesquisa já foi feita em alguma aba e retornou um erro após for feita nova pesquisa esse erro sai.
                ControleSessao::destruirVariavel('errosV');
                ControleSessao::destruirVariavel('errosEncaminhados');
                ControleSessao::destruirVariavel('errosBaixasAutomaticas');
                ControleSessao::destruirVariavel('errosPreSelecionados');
                ControleSessao::destruirVariavel('errosContratados');
                ControleSessao::destruirVariavel('errosDispensados');

                //array de erros
                $errosBaixasAutomaticas = array();

                //valido todos os dados
                if(!Validacao::validarFiltroIdCidade($_POST['filtro_codigo'])) $errosBaixasAutomaticas[] = 'filtro_codigo';
                //if(!Validacao::validarNome($_POST['filtro_nome'])) $errosBaixasAutomaticas[] = 'filtro_nome';
                if(!Validacao::validarFiltroStatusEncaminhado($_POST['filtro_status'])) $errosBaixasAutomaticas[] = 'filtro_status';

                //se nao tiver erros

                if(count($errosBaixasAutomaticas) == 0){

                    $e = ControleSessao::buscarObjeto('privateEmp');
                    $v = ControleSessao::buscarObjeto('objVaga');
                    //monta query

                    //pesquiso por codigo
                    if(!empty($_POST['filtro_codigo'])){
                        $query .= " and vc.id_candidato = ".$_POST['filtro_codigo'];
                    }

                    //pesquiso por nome
                    if(!empty($_POST['filtro_nome'])){
                        $query .= " and c.nm_candidato like '%".$_POST['filtro_nome']."%'";
                    }

                    if($_POST['filtro_status']){
                        $query .= " and vc.ao_status = '".$_POST['filtro_status']."'";
                    }

                    //instancia um dao
                    $vcDAO = new VagaCandidatoDAO();
                    //busca os candidatos no bd
                    $baixaAutomatica = $vcDAO->buscarTodosCandidatos($v->id_vaga, $query);
                    //insiro na sessao o array de candidatos

                    $v->baixasAutomaticas = $baixaAutomatica;
                    /* Insiro na sessão o true para a mensagem de pesquisa não sumir quando for feita uma pesquisa em outra aba.
                    ex.: Fez a pesquisa e não retornou nada: Não há resultados para sua busca por candidatos com Baixas Automáticas,
                    quando a mesma pesquisa for feita em outra aba essa mensagem não irá sumir nesta aba. */
                    $v->pesqBaixasAutomaticas = true;

                    ControleSessao::inserirObjeto('objVaga', $v);

                    /*Retorna somente ao campo de busca por código da aba baixas automáticas,
                    assim ele não irá preencher os outros campos de busca das outras abas. */
                    $_POST['filtro_codigo_baixas_automaticas'] = $_POST['filtro_codigo'];
                    $_POST['filtro_nome_baixas_automaticas'] = $_POST['filtro_nome'];

                    //insiro na sessao os filtros
                    ControleSessao::inserirVariavel('post', $_POST);

                    //redireciono
                    header('location:../visao/GuiManutencaoVaga.php#parte-04');


                }else{
                    //registro o array de erros e o post
                    ControleSessao::inserirVariavel('errosBaixasAutomaticas', $errosBaixasAutomaticas);
                    ControleSessao::inserirVariavel('post', $_POST);
                    //redireciono
                    header('location:../visao/GuiManutencaoVaga.php#parte-04');
                }
            }
        break;

        /***************************************************************************************************************
         *  PESQUISAR PRÉ-SELECIONADOS
         **************************************************************************************************************/
        case 'pesquisarPreSelecionados':

            if(isset($_POST)){

                //Caso a pesquisa já foi feita em alguma aba e retornou um erro após for feita nova pesquisa esse erro sai.
                ControleSessao::destruirVariavel('errosV');
                ControleSessao::destruirVariavel('errosEncaminhados');
                ControleSessao::destruirVariavel('errosBaixasAutomaticas');
                ControleSessao::destruirVariavel('errosPreSelecionados');
                ControleSessao::destruirVariavel('errosContratados');
                ControleSessao::destruirVariavel('errosDispensados');

                //array de erros
                $errosPreSelecionados = array();

                //valido todos os dados
                if(!Validacao::validarFiltroIdCidade($_POST['filtro_codigo'])) $errosPreSelecionados[] = 'filtro_codigo';
                //if(!Validacao::validarNome($_POST['filtro_nome'])) $errosPreSelecionados[] = 'filtro_nome';
                if(!Validacao::validarFiltroStatusEncaminhado($_POST['filtro_status'])) $errosPreSelecionados[] = 'filtro_status';

                //se nao tiver erros

                if(count($errosPreSelecionados) == 0){

                    $e = ControleSessao::buscarObjeto('privateEmp');
                    $v = ControleSessao::buscarObjeto('objVaga');
                    //monta query

                    //pesquiso por código
                    if(!empty($_POST['filtro_codigo'])){
                        $query .= " and vc.id_candidato = ".$_POST['filtro_codigo'];
                    }

                    //pesquiso por nome
                    if(!empty($_POST['filtro_nome'])){
                        $query .= " and c.nm_candidato like '%".$_POST['filtro_nome']."%'";
                    }

                    if($_POST['filtro_status']){
                        $query .= " and vc.ao_status = '".$_POST['filtro_status']."'";
                    }

                    //instancia um dao
                    $vcDAO = new VagaCandidatoDAO();
                    //busca os candidatos no bd
                    $preSelecionado = $vcDAO->buscarTodosCandidatos($v->id_vaga, $query);
                    //insiro na sessao o array de candidatos

                    $v->preSelecionados = $preSelecionado;
                    /* Insiro na sessão o true para a mensagem de pesquisa não sumir quando for feita uma pesquisa em outra aba.
                    ex.: Fez a pesquisa e não retornou nada: Não há resultados para sua busca por candidatos pré-selecionados,
                    quando a mesma pesquisa for feita em outra aba essa mensagem não irá sumir nesta aba. */
                    $v->pesqPreSelecionados = true;

                    ControleSessao::inserirObjeto('objVaga', $v);

                    /*Retorna somente ao campo de busca por código da aba pré-selecionados,
                    assim ele não irá preencher os outros campos de busca das outras abas. */
                    $_POST['filtro_codigo_preSelecionados'] = $_POST['filtro_codigo'];
                    $_POST['filtro_nome_preSelecionados'] = $_POST['filtro_nome'];

                    //insiro na sessao os filtros
                    ControleSessao::inserirVariavel('post', $_POST);

                    //redireciono
                    header('location:../visao/GuiManutencaoVaga.php#parte-05');


                }else{
                    //registro o array de erros e o post
                    ControleSessao::inserirVariavel('errosPreSelecionados', $errosPreSelecionados);
                    ControleSessao::inserirVariavel('post', $_POST);
                    //redireciono
                    header('location:../visao/GuiManutencaoVaga.php#parte-05');
                }
            }
        break;

        /***************************************************************************************************************
         *  PESQUISAR CONTRATADOS
         **************************************************************************************************************/
        case 'pesquisarContratados':

            if(isset($_POST)){

                //Caso a pesquisa já foi feita em alguma aba e retornou um erro após for feita nova pesquisa esse erro sai.
                ControleSessao::destruirVariavel('errosV');
                ControleSessao::destruirVariavel('errosEncaminhados');
                ControleSessao::destruirVariavel('errosBaixasAutomaticas');
                ControleSessao::destruirVariavel('errosPreSelecionados');
                ControleSessao::destruirVariavel('errosContratados');
                ControleSessao::destruirVariavel('errosDispensados');

                //array de erros
                $errosContratados = array();

                //valido todos os dados
                if(!Validacao::validarFiltroIdCidade($_POST['filtro_codigo'])) $errosContratados[] = 'filtro_codigo';
                //if(!Validacao::validarNome($_POST['filtro_nome'])) $errosContratados[] = 'filtro_nome';
                if(!Validacao::validarFiltroStatusEncaminhado($_POST['filtro_status'])) $errosContratados[] = 'filtro_status';

                //se nao tiver erros

                if(count($errosContratados) == 0){

                    $e = ControleSessao::buscarObjeto('privateEmp');
                    $v = ControleSessao::buscarObjeto('objVaga');
                    //monta query

                    //pesquiso por código
                    if(!empty($_POST['filtro_codigo'])){
                        $query .= " and vc.id_candidato = ".$_POST['filtro_codigo'];
                    }

                    //pesquiso por nome
                    if(!empty($_POST['filtro_nome'])){
                        $query .= " and c.nm_candidato like '%".$_POST['filtro_nome']."%'";
                    }

                    if($_POST['filtro_status']){
                        $query .= " and vc.ao_status = '".$_POST['filtro_status']."'";
                    }

                    //instancia um dao
                    $vcDAO = new VagaCandidatoDAO();
                    //busca os candidatos no bd
                    $contratado = $vcDAO->buscarTodosCandidatos($v->id_vaga, $query);
                    //insiro na sessao o array de candidatos

                    $v->contratados = $contratado;
                    /* Insiro na sessão o true para a mensagem de pesquisa não sumir quando for feita uma pesquisa em outra aba.
                    ex.: Fez a pesquisa e não retornou nada: Não há resultados para sua busca por candidatos contratados,
                    quando a mesma pesquisa for feita em outra aba essa mensagem não irá sumir nesta aba. */
                    $v->pesqContratados = true;

                    ControleSessao::inserirObjeto('objVaga', $v);

                    /*Retorna somente ao campo de busca por código da aba contratados,
                    assim ele não irá preencher os outros campos de busca das outras abas. */
                    $_POST['filtro_codigo_contratados'] = $_POST['filtro_codigo'];
                    $_POST['filtro_nome_contratados'] = $_POST['filtro_nome'];

                    //insiro na sessao os filtros
                    ControleSessao::inserirVariavel('post', $_POST);

                    //redireciono
                    header('location:../visao/GuiManutencaoVaga.php#parte-06');


                }else{
                    //registro o array de erros e o post
                    ControleSessao::inserirVariavel('errosContratados', $errosContratados);
                    ControleSessao::inserirVariavel('post', $_POST);
                    //redireciono
                    header('location:../visao/GuiManutencaoVaga.php#parte-06');
                }
            }
        break;

                /***************************************************************************************************************
         *  PESQUISAR DISPENSADOS
         **************************************************************************************************************/
        case 'pesquisarDispensados':

            if(isset($_POST)){

                //Caso a pesquisa já foi feita em alguma aba e retornou um erro após for feita nova pesquisa esse erro sai.
                ControleSessao::destruirVariavel('errosV');
                ControleSessao::destruirVariavel('errosEncaminhados');
                ControleSessao::destruirVariavel('errosBaixasAutomaticas');
                ControleSessao::destruirVariavel('errosPreSelecionados');
                ControleSessao::destruirVariavel('errosContratados');
                ControleSessao::destruirVariavel('errosDispensados');

                //array de erros
                $errosDispensados = array();

                //valido todos os dados
                if(!Validacao::validarFiltroIdCidade($_POST['filtro_codigo'])) $errosDispensados[] = 'filtro_codigo';
                //if(!Validacao::validarNome($_POST['filtro_nome'])) $errosDispensados[] = 'filtro_nome';
                if(!Validacao::validarFiltroStatusEncaminhado($_POST['filtro_status'])) $errosDispensados[] = 'filtro_status';

                //se nao tiver erros

                if(count($errosDispensados) == 0){

                    $e = ControleSessao::buscarObjeto('privateEmp');
                    $v = ControleSessao::buscarObjeto('objVaga');
                    //monta query

                    //pesquiso por código
                    if(!empty($_POST['filtro_codigo'])){
                        $query .= " and vc.id_candidato = ".$_POST['filtro_codigo'];
                    }

                    //pesquiso por nome
                    if(!empty($_POST['filtro_nome'])){
                        $query .= " and c.nm_candidato like '%".$_POST['filtro_nome']."%'";
                    }

                    if($_POST['filtro_status']){
                        $query .= " and vc.ao_status = '".$_POST['filtro_status']."'";
                    }

                    //instancia um dao
                    $vcDAO = new VagaCandidatoDAO();
                    //busca os candidatos no bd
                    $dispensado = $vcDAO->buscarTodosCandidatos($v->id_vaga, $query);
                    //insiro na sessao o array de candidatos

                    $v->dispensados = $dispensado;
                    /* Insiro na sessão o true para a mensagem de pesquisa não sumir quando for feita uma pesquisa em outra aba.
                    ex.: Fez a pesquisa e não retornou nada: Não há resultados para sua busca por candidatos dispensados,
                    quando a mesma pesquisa for feita em outra aba essa mensagem não irá sumir nesta aba. */
                    $v->pesqDispensados = true;

                    ControleSessao::inserirObjeto('objVaga', $v);

                    /*Retorna somente ao campo de busca por código da aba dispensados,
                    assim ele não irá preencher os outros campos de busca das outras abas. */
                    $_POST['filtro_codigo_dispensados'] = $_POST['filtro_codigo'];
                    $_POST['filtro_nome_dispensados'] = $_POST['filtro_nome'];

                    //insiro na sessao os filtros
                    ControleSessao::inserirVariavel('post', $_POST);

                    //redireciono
                    header('location:../visao/GuiManutencaoVaga.php#parte-07');


                }else{
                    //registro o array de erros e o post
                    ControleSessao::inserirVariavel('errosDispensados', $errosDispensados);
                    ControleSessao::inserirVariavel('post', $_POST);
                    //redireciono
                    header('location:../visao/GuiManutencaoVaga.php#parte-07');
                }
            }
        break;

        /*************************************************************************************************************
        *  IMPRIMIR CURRICULO
        **************************************************************************************************************/
        case 'imprimir':

            if (isset($_POST) && isset($_POST['curriculo'])) {

                if(!Validacao::validarIdCandidatoFormacao($_POST['id_candidato'])) $errosI[] = 'id_candidato';

                if(count($errosI)==0){

                    $cDAO = new CandidatoDAO();
                    $c = $cDAO->buscarPorId($_POST['id_candidato']);

                    if(!is_bool($c) && !is_null($c)){

                        $cfDAO = new CandidatoFormacaoDAO();
                        $c->formacoes = $cfDAO->buscarCandidatoFormacoes($c->id_candidato);

                        $cqDAO = new CandidatoQualificacaoDAO();
                        $c->qualificacoes = $cqDAO->buscarCandidatoQualificacoes($c->id_candidato);

                        $ceDAO = new CandidatoExperienciaDAO();
                        $c->experiencias = $ceDAO->buscarCandidatoExperiencias($c->id_candidato);

                        $cp = new CandidatoProfissaoDAO();
                        $c->profissoes = $cp->buscarCandidatoProfissoesSimples($c->id_candidato);

                        $candidatos[] = $c;

                    }else{
                        ControleSessao::inserirVariavel('errosI', 'Ocorreu um erro. Tente novamente!');
                        header('location:../visao/GuiManutencaoVaga.php#parte-02');
                    }

                    //gera o curriculo .pdf
                    Imprimir::imprimirCurriculoCompletoCandidato($candidatos);

                }else{
                    ControleSessao::inserirVariavel('errosI', 'Ocorreu um erro. Tente novamente!');
                    header('location:../visao/GuiManutencaoVaga.php#parte-02');
                }

            } else if (isset($_POST['lista'])){
                //die('AQUI<--------------IMPRISSÂO DE LISTA');
                if(!Validacao::validarIdCandidatoFormacao($_POST['id_vaga'])) $errosI[] = 'id_vaga';
                //var_dump($_POST['id_vaga']);
                if(count($errosI)==0){

                    $vcDAO = new VagaCandidatoDAO();
                    $vagaCandidato = $vcDAO->montarListaEncaminhados($_POST['id_vaga']);
                    //var_dump($vagaCandidato);

                    //Chamada da função impressão da LISTA;
                    Imprimir::imprimirLista($vagaCandidato);

                }else{
                    ControleSessao::inserirVariavel('errosI', 'Ocorreu um erro. Tente novamente!');
                    header('location:../visao/GuiManutencaoVaga.php#parte-02');
                }

            }
            break;

        default:
            ControleLoginEmpresa::deslogar();
            break;
    }
}

?>
