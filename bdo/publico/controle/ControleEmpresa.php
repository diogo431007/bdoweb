<?php

include_once '../util/ControleSessao.class.php';
ControleSessao::abrirSessao();

include_once '../modelo/EmpresaVO.class.php';
include_once '../modelo/EmpresaDetalheVO.class.php';
include_once '../modelo/AdmissaoVO.class.php';
include_once '../modelo/VagaVO.class.php';
include_once '../modelo/LogUsuarioEmpresaVO.class.php';

include_once '../persistencia/EmpresaDAO.class.php';
include_once '../persistencia/AdmissaoDAO.class.php';
include_once '../persistencia/VagaDAO.class.php';
include_once '../persistencia/LogUsuarioEmpresaDAO.class.php';

include_once '../util/Validacao.class.php';
include_once '../util/ControleLoginEmpresa.class.php';
include_once '../util/Email.class.php';
include_once '../util/Servicos.class.php';

if(isset($_GET['op'])){
    switch ($_GET['op']) {

        /***************************************************************************************************************
         *  CADASTRAR
         **************************************************************************************************************/
        case 'cadastrar':
            if(isset($_POST)){

                //array de erros
                $errosE = array();

                //valido os dados da empresa
                if(!Validacao::validarNmEmpresa($_POST['nm_razaosocial'])) $errosE[] = 'nm_razaosocial';
                if(!Validacao::validarNmFantasia($_POST['nm_fantasia'])) $errosE[] = 'nm_fantasia';
                if(!Validacao::validarCnpj($_POST['nr_cnpj'])) $errosE[] = 'nr_cnpj';
                if(!Validacao::validarIdRamoAtividade($_POST['id_ramoatividade'])) $errosE[] = 'id_ramoatividade';
                if(!Validacao::validarIdEmpresaTipo($_POST['id_empresatipo'])) $errosE[] = 'id_empresatipo';
                if(!Validacao::validarIdQuantidadeFuncionario($_POST['id_quantidadefuncionario'])) $errosE[] = 'id_quantidadefuncionario';
                if(!Validacao::validarNome($_POST['nm_contato'])) $errosE[] = 'nm_contato';
                if(!Validacao::validarTelefone($_POST['nr_telefoneempresa'])) $errosE[] = 'nr_telefoneempresa';
                if(!Validacao::validarCep($_POST['nr_cep'])) $errosE[] = 'nr_cep';
                if(!Validacao::validarDsLogradouro($_POST['ds_logradouro'])) $errosE[] = 'ds_logradouro';
                if(!Validacao::validarNrLogradouro($_POST['nr_logradouro'])) $errosE[] = 'nr_logradouro';
                if(!Validacao::validarBairro($_POST['ds_bairro'])) $errosE[] = 'ds_bairro';
                if(!Validacao::validarDsComplemento($_POST['ds_complemento'])) $errosE[] = 'ds_complemento';
                if(!Validacao::validarIdEstado($_POST['id_estado'])) $errosE[] = 'id_estado';
                if(!Validacao::validarIdCidadeEmpresa($_POST['id_cidade'])) $errosE[] = 'id_cidade';
                if(!Validacao::validarEmail($_POST['ds_email'])) $errosE[] = 'ds_email';
                if(!Validacao::validarSite($_POST['ds_site']) && !empty($_POST['ds_site'])) $errosE[] = 'ds_site';
                if(!Validacao::validarNrIncricaoEstadual($_POST['nr_inscricaoestadual'], $_POST['id_estado'])) $errosE[] = 'nr_inscricaoestadual';
                if(!Validacao::validarNrIncricaoMunicipal($_POST['nr_inscricaomunicipal'])) $errosE[] = 'nr_inscricaomunicipal';
                if(!Validacao::validarDtTermino($_POST['dt_fundacao'])) $errosE[] = 'dt_fundacao';
                if(!Validacao::validarSenha($_POST['pw_senha'])) $errosE[] = 'pw_senha';

                //valido os dados do proprietario
                if(!Validacao::validarNome($_POST['nm_proprietario'])) $errosE[] = 'nm_proprietario';
                if(!Validacao::validarNome($_POST['ds_cargo'])) $errosE[] = 'ds_cargo';
                if(!Validacao::validarVazio($_SESSION['nr_cpf'])){
                    if(!Validacao::validarMascaraCpf($_POST['nr_cpf']) && !Validacao::validarCpf($_POST['nr_cpf'])) $errosE[] = 'nr_cpf';
                }
                if(!Validacao::validarDataNaoObg($_POST['dt_nascimento'])) $errosE[] = 'dt_nascimento';
                if(!Validacao::validarTelefoneNaoObg($_POST['nr_celular'])) $errosE[] = 'nr_celular';
                if(!Validacao::validarEmail($_POST['ds_emailproprietario'])) $errosE[] = 'ds_emailproprietario';
                if(!Validacao::validarStatus($_POST['ao_recrutador'])) $errosE[] = 'ao_recrutador';

                //if(!Validacao::validarIdMicroRegiao($_POST['id_microregiao'])) $errosE[] = 'id_microregiao';
                //if(!Validacao::validarIdPoligono($_POST['id_poligono'])) $errosE[] = 'id_poligono';

                //if(!Validacao::validarIdCidadeCandidato($_POST['id_microregiao'])) $errosE[] = 'id_microregiao';
                //if(!Validacao::validarIdCidadeCandidato($_POST['id_poligono'])) $errosE[] = 'id_poligono';

                //testo se houve erro
                if(count($errosE)==0){

                    //instancio um dao
                    $eDAO = new EmpresaDAO();

                    if(!$eDAO->verificarLogin($_POST['ds_email'], $_POST['nr_cnpj'])){

                        $errosE[] = 'empresa_cadastrada';
                        //registra o array de erros e o post
                        ControleSessao::inserirVariavel('errosE', $errosE);
                        ControleSessao::inserirVariavel('post', $_POST);
                        //redireciona
                        header('location:../visao/GuiCadEmpresa.php');

                    }else{

                        //instancio um EmpresaVO
                        $e = new EmpresaVO();
                        //seto os dados da empresa
                        //$e->id_empresa = null;
                        $e->nm_razaosocial = Servicos::converterStrtoupper($_POST['nm_razaosocial']);
                        $e->nm_fantasia = Servicos::converterStrtoupper($_POST['nm_fantasia']);
                        $e->nr_cnpj = $_POST['nr_cnpj'];
                        $e->nm_contato = Servicos::converterStrtoupper($_POST['nm_contato']);
                        $e->nr_telefoneempresa = $_POST['nr_telefoneempresa'];
                        $e->nr_cep = $_POST['nr_cep'];
                        $e->ds_logradouro = Servicos::converterStrtoupper($_POST['ds_logradouro']);
                        $e->nr_logradouro = $_POST['nr_logradouro'];
                        $e->ds_bairro = Servicos::converterStrtoupper($_POST['ds_bairro']);
                        $e->ds_complemento = Servicos::converterStrtoupper($_POST['ds_complemento']);
                        $e->id_cidade = (!empty($_POST['id_cidade'])) ? $_POST['id_cidade'] : 'null';
                        $e->ds_email = Servicos::converterStrtoupper($_POST['ds_email']);
                        $e->ds_site = Servicos::converterStrtoupper($_POST['ds_site']);
                        $e->nr_inscricaoestadual = $_POST['nr_inscricaoestadual'];
                        $e->nr_inscricaomunicipal = $_POST['nr_inscricaomunicipal'];
                        $e->dt_fundacao = Validacao::explodirDataNaoObg($_POST['dt_fundacao']);
                        $e->ao_liberacao = 'N';
                        $e->pw_senhaportal = Validacao::criptografar($_POST['pw_senha']);
                        $e->ao_interno = 'N';
                        $e->id_ramoatividade = $_POST['id_ramoatividade'];
                        $e->id_empresatipo = $_POST['id_empresatipo'];
                        $e->id_quantidadefuncionario = $_POST['id_quantidadefuncionario'];
                        //seto os dados do rsponsável da empresa
                        $e->nm_proprietario = Servicos::converterStrtoupper($_POST['nm_proprietario']);
                        $e->ds_cargo = Servicos::converterStrtoupper($_POST['ds_cargo']);
                        $e->nr_cpf = $_POST['nr_cpf'];
                        $e->dt_nascimento = Validacao::explodirDataNaoObg($_POST['dt_nascimento']);
                        $e->nr_celular = $_POST['nr_celular'];
                        $e->ds_emailproprietario = Servicos::converterStrtoupper($_POST['ds_emailproprietario']);
                        $e->ao_status = 'S';
                        $e->ao_recrutador = $_POST['ao_recrutador'];
                        $e->id_microregiao = (!empty($_POST['id_microregiao'])) ? $_POST['id_microregiao'] : 'null';
                        $e->id_poligono = (!empty($_POST['id_poligono'])) ? $_POST['id_poligono'] : 'null';

                        //insiro no banco e resgato o id_empresa gerado
                        $idGerado = $eDAO->cadastrarEmpresa($e);

                        //testo se eh um numero mesmo
                        if(!is_numeric($idGerado)){
                            //caso nao, registro uma mensagem
                            ControleSessao::inserirVariavel('msg', 'Ocorreu um erro. Tente novamente!');
                            ControleSessao::inserirVariavel('errosE', $errosE);
                            ControleSessao::inserirVariavel('post', $_POST);
                            //redireciona
                            header('location:../visao/GuiCadEmpresa.php');
                        }

                        //seto o id gerado
                        $e->id_empresa = $idGerado;
                        //insiro a empresa na sessao
                        ControleLoginEmpresa::acessarSessao($e);

                        //email do moderador
                        $destino = 'seuemail@prefeitura.com';
                        $nomeDestino = 'Moderador';
                        //assunto do email
                        $assunto = 'Há uma nova empresa para moderação!';
                        //mensagem do email
                        $corpo = "<p>
                                    A empresa $e->nm_fantasia cadastrou-se no Banco de Oportunidades
                                    e necessita de moderação.<br>
                                    Por favor faça-o quanto antes.
                                </p>";
                        Email::enviarEmail($destino, $assunto, $corpo, $nomeDestino);

                        //redireciona para manutencao
                        header('location:../visao/GuiManutencaoEmpresa.php#parte-01');

                    }
                }else{
                    //registra o array de erros e o post
                    ControleSessao::inserirVariavel('errosE', $errosE);
                    ControleSessao::inserirVariavel('post', $_POST);
                    //redireciona
                    header('location:../visao/GuiCadEmpresa.php');
                }
            }
        break;

        /***************************************************************************************************************
         *  MANUTENCAO
         **************************************************************************************************************/
        case 'manutencao':
            if(isset($_GET['form'])){
                switch ($_GET['form']) {

                    /********************** update dos dados da empresa **********************/
                    case 1:
                        if(isset($_POST)){

                            //array de erros
                            $errosE = array();
                            //valido todos os dados da empresa
                            if(!Validacao::validarNmEmpresa($_POST['nm_razaosocial'])) $errosE[] = 'nm_razaosocial';
                            if(!Validacao::validarNmFantasia($_POST['nm_fantasia'])) $errosE[] = 'nm_fantasia';
                            if(!Validacao::validarCnpj($_POST['nr_cnpj'])) $errosE[] = 'nr_cnpj';
                            if(!Validacao::validarIdRamoAtividade($_POST['id_ramoatividade'])) $errosE[] = 'id_ramoatividade';
                            if(!Validacao::validarIdEmpresaTipo($_POST['id_empresatipo'])) $errosE[] = 'id_empresatipo';
                            if(!Validacao::validarIdQuantidadeFuncionario($_POST['id_quantidadefuncionario'])) $errosE[] = 'id_quantidadefuncionario';
                            if(!Validacao::validarNome($_POST['nm_contato'])) $errosE[] = 'nm_contato';
                            if(!Validacao::validarTelefone($_POST['nr_telefoneempresa'])) $errosE[] = 'nr_telefoneempresa';
                            if(!Validacao::validarCep($_POST['nr_cep'])) $errosE[] = 'nr_cep';
                            if(!Validacao::validarDsLogradouro($_POST['ds_logradouro'])) $errosE[] = 'ds_logradouro';
                            if(!Validacao::validarNrLogradouro($_POST['nr_logradouro'])) $errosE[] = 'nr_logradouro';
                            if(!Validacao::validarBairro($_POST['ds_bairro'])) $errosE[] = 'ds_bairro';
                            if(!Validacao::validarDsComplemento($_POST['ds_complemento'])) $errosE[] = 'ds_complemento';
                            if(!Validacao::validarIdEstado($_POST['id_estado'])) $errosE[] = 'id_estado';
                            if(!Validacao::validarIdCidadeEmpresa($_POST['id_cidade'])) $errosE[] = 'id_cidade';
                            if(!Validacao::validarEmail($_POST['ds_email'])) $errosE[] = 'ds_email';
                            if(!Validacao::validarSite($_POST['ds_site']) && !empty($_POST['ds_site'])) $errosE[] = 'ds_site';
                            if(!Validacao::validarNrIncricaoEstadual($_POST['nr_inscricaoestadual'], $_POST['id_estado'])) $errosE[] = 'nr_inscricaoestadual';
                            if(!Validacao::validarNrIncricaoMunicipal($_POST['nr_inscricaomunicipal'])) $errosE[] = 'nr_inscricaomunicipal';
                            if(!Validacao::validarDtTermino($_POST['dt_fundacao'])) $errosE[] = 'dt_fundacao';
                            //valida todos os dados do responsável pela empresa
                            if(!Validacao::validarNome($_POST['nm_proprietario'])) $errosE[] = 'nm_proprietario';
                            if(!Validacao::validarNome($_POST['ds_cargo'])) $errosE[] = 'ds_cargo';
                            if(!Validacao::validarVazio($_SESSION['nr_cpf'])){
                                if(!Validacao::validarMascaraCpf($_POST['nr_cpf']) && !Validacao::validarCpf($_POST['nr_cpf'])) $errosE[] = 'nr_cpf';
                            }
                            if(!Validacao::validarDataNaoObg($_POST['dt_nascimento'])) $errosE[] = 'dt_nascimento';
                            if(!Validacao::validarTelefoneNaoObg($_POST['nr_celular'])) $errosE[] = 'nr_celular';
                            if(!Validacao::validarEmail($_POST['ds_emailproprietario'])) $errosE[] = 'ds_emailproprietario';
                            if(!Validacao::validarStatus($_POST['ao_recrutador'])) $errosE[] = 'ao_recrutador';

                            //se nao houver erro
                            if(count($errosE)==0){

                                //instancio um EmpresaVO
                                $e = new EmpresaVO();

                                //recebo o EmpresaVO da sessao
                                $e = ControleSessao::buscarObjeto('privateEmp');

                                //seto os novos dados da empresa
                                $e->nm_razaosocial = Servicos::converterStrtoupper($_POST['nm_razaosocial']);
                                $e->nm_fantasia = Servicos::converterStrtoupper($_POST['nm_fantasia']);
                                $e->nr_cnpj = $_POST['nr_cnpj'];
                                $e->nm_contato = Servicos::converterStrtoupper($_POST['nm_contato']);
                                $e->nr_telefoneempresa = $_POST['nr_telefoneempresa'];
                                $e->nr_cep = $_POST['nr_cep'];
                                $e->ds_logradouro = Servicos::converterStrtoupper($_POST['ds_logradouro']);
                                $e->nr_logradouro = $_POST['nr_logradouro'];
                                $e->ds_bairro = Servicos::converterStrtoupper($_POST['ds_bairro']);
                                $e->ds_complemento = Servicos::converterStrtoupper($_POST['ds_complemento']);
                                $e->id_cidade = $_POST['id_cidade'];
                                $e->ds_email = Servicos::converterStrtoupper($_POST['ds_email']);
                                $e->ds_site = Servicos::converterStrtoupper($_POST['ds_site']);
                                $e->nr_inscricaoestadual = $_POST['nr_inscricaoestadual'];
                                $e->nr_inscricaomunicipal = $_POST['nr_inscricaomunicipal'];
                                $e->dt_fundacao = Validacao::explodirDataNaoObg($_POST['dt_fundacao']);
                                $e->ao_liberacao = 'N';
                                $e->id_ramoatividade = $_POST['id_ramoatividade'];
                                $e->id_empresatipo = $_POST['id_empresatipo'];
                                $e->id_quantidadefuncionario = $_POST['id_quantidadefuncionario'];
                                //seto os novos dados do responsável da empresa
                                $e->nm_proprietario = Servicos::converterStrtoupper($_POST['nm_proprietario']);
                                $e->ds_cargo = Servicos::converterStrtoupper($_POST['ds_cargo']);
                                $e->nr_cpf = $_POST['nr_cpf'];
                                $e->dt_nascimento = Validacao::explodirDataNaoObg($_POST['dt_nascimento']);
                                $e->nr_celular = $_POST['nr_celular'];
                                $e->ds_emailproprietario = Servicos::converterStrtoupper($_POST['ds_emailproprietario']);
                                $e->ao_status = 'S';
                                $e->ao_recrutador = $_POST['ao_recrutador'];
                                $e->id_microregiao = (!empty($_POST['id_microregiao'])) ? $_POST['id_microregiao'] : 'null';
                                $e->id_poligono = (!empty($_POST['id_poligono'])) ? $_POST['id_poligono'] : 'null';

                                //instancio um dao
                                $eDAO = new EmpresaDAO();
                                //atualizo empresa no banco
                                $flag = $eDAO->alterarEmpresa($e);

                                if(!$flag){
                                    //se ocorreu um erro no update
                                    ControleSessao::inserirVariavel('msg', 'Ocorreu um erro. Tente novamente!');
                                    //redireciona
                                    header('location:../visao/GuiManutencaoEmpresa.php#parte-01');
                                }

                                //email do moderador
                                $destino = 'seuemail@prefeitura.com';
                                $nomeDestino = 'Moderador';
                                //assunto do email
                                $assunto = 'Há uma nova empresa para moderação!';
                                //mensagem do email
                                $corpo = "<p>
                                            A empresa $e->nm_fantasia cadastrou-se no Banco de Oportunidades
                                            e necessita de moderação.<br>
                                            Por favor faça-o quanto antes.
                                        </p>";
                                Email::enviarEmail($destino, $assunto, $corpo, $nomeDestino);

                                ControleLoginEmpresa::acessarSessao($e);
                                header('location:../visao/GuiManutencaoEmpresa.php#parte-01');

                            }else{
                                //registra o array de erros e o post
                                ControleSessao::inserirVariavel('errosE', $errosE);
                                ControleSessao::inserirVariavel('post', $_POST);
                                //redireciona
                                header('location:../visao/GuiManutencaoEmpresa.php#parte-01');
                            }
                        }
                    break;

                    /********************** cadastrar dados dos proprietarios **********************/
                    case 2:
                        if(isset($_POST)){

                            //array de erros
                            $errosP = array();

                            //valido os dados
                            if(!Validacao::validarNome($_POST['nm_proprietario'])) $errosP[] = 'nm_proprietario';
                            if(!Validacao::validarNome($_POST['ds_cargo'])) $errosP[] = 'ds_cargo';
                            if(!Validacao::validarVazio($_SESSION['nr_cpf'])){
                                if(!Validacao::validarMascaraCpf($_POST['nr_cpf']) && !Validacao::validarCpf($_POST['nr_cpf'])) $errosP[] = 'nr_cpf';
                            }
                            if(!Validacao::validarDataNaoObg($_POST['dt_nascimento'])) $errosP[] = 'dt_nascimento';
                            if(!Validacao::validarTelefoneNaoObg($_POST['nr_celular'])) $errosP[] = 'nr_celular';
                            if(!Validacao::validarEmail($_POST['ds_emailproprietario'])) $errosP[] = 'ds_emailproprietario';
                            if(!Validacao::validarStatus($_POST['ao_recrutador'])) $errosP[] = 'ao_recrutador';

                            //se nao houver erros
                            if(count($errosP)==0){

                                //testo acesso por segurança
                                if(!ControleLoginEmpresa::verificarAcesso()){
                                    ControleLoginEmpresa::deslogar();
                                }

                                //recebo a empresa da sessao
                                $e = ControleSessao::buscarObjeto('privateEmp');

                                //instancio um EmpresaDetalheVO
                                $ed = new EmpresaDetalheVO();
                                //seto os dados
                                $ed->nm_proprietario = Servicos::converterStrtoupper($_POST['nm_proprietario']);
                                $ed->ds_cargo = Servicos::converterStrtoupper($_POST['ds_cargo']);
                                $ed->nr_cpf = $_POST['nr_cpf'];
                                $ed->dt_nascimento = Validacao::explodirDataNaoObg($_POST['dt_nascimento']);
                                $ed->nr_celular = $_POST['nr_celular'];
                                $ed->ds_emailproprietario = Servicos::converterStrtoupper($_POST['ds_emailproprietario']);
                                $ed->ao_status = 'S';
                                $ed->id_empresa = $e->id_empresa;
                                $ed->ao_recrutador = $_POST['ao_recrutador'];

                                $edDAO = new EmpresaDetalheDAO();
                                $flag = $edDAO->cadastrarEmpresaDetalhe($ed);

                                if(!$flag){
                                    //se ocorreu um erro no insert
                                    ControleSessao::inserirVariavel('msg', 'Ocorreu um erro. Tente novamente!');
                                    //redireciona
                                    header('location:../visao/GuiManutencaoEmpresa.php#parte-02');
                                }

                                ControleLoginEmpresa::acessarSessao($e);
                                header('location:../visao/GuiManutencaoEmpresa.php#parte-02');

                            }else{
                                //registra o array de erros e o post
                                ControleSessao::inserirVariavel('errosP', $errosP);
                                ControleSessao::inserirVariavel('post', $_POST);
                                //redireciona
                                header('location:../visao/GuiManutencaoEmpresa.php#parte-02');
                            }
                        }
                    break;

                    /********************** carregar empresa detalhe para editar **********************/
                    case 3:
                        if(isset($_POST)){

                            //contador de erros
                            $erroEED = 0;
                            //valida o id
                            if(!Validacao::validarIdCandidatoFormacao($_POST['idEmpDet'])) $erroEED++;

                            if($erroEED == 0){

                                //instancio um dao
                                $edDAO = new EmpresaDetalheDAO();
                                //busco o EmpresaDetalheVO pelo id_empresadetalhe e id_empresa
                                $ed = $edDAO->trazerEmpresaDetalhe($_POST['idEmpDet'],ControleSessao::buscarObjeto('privateEmp')->id_empresa);

                                if(isset($ed) && !is_null($ed) && !is_bool($ed)){

                                    //insiro na sessao o EmpresaDetalheVO
                                    ControleSessao::inserirObjeto('empresa_detalhe', $ed);
                                    //redireciono
                                    header('location:../visao/GuiManutencaoEmpresa.php#parte-02');

                                }else{
                                    //se ocorreu um erro no select
                                    ControleSessao::inserirVariavel('erroDED', 'Ocorreu um erro. Tente novamente!');
                                    //redireciona
                                    header('location:../visao/GuiManutencaoEmpresa.php#parte-02');
                                }

                            }else{
                                //se ocorreu um erro no update
                                ControleSessao::inserirVariavel('erroEED', 'Ocorreu um erro. Tente novamente!');
                                //redireciona
                                header('location:../visao/GuiManutencaoEmpresa.php#parte-02');
                            }
                        }
                    break;

                    /********************** update de empresa detalhe *************************/
                    case 4:
                        if(isset($_POST)){

                            //array de erros
                            $errosP = array();
                            $erroEED = 0;

                            //valido os dados
                            if(!Validacao::validarNome($_POST['nm_proprietario'])) $errosP[] = 'nm_proprietario';
                            if(!Validacao::validarNome($_POST['ds_cargo'])) $errosP[] = 'ds_cargo';
                            if(!Validacao::validarVazio($_SESSION['nr_cpf'])){
                                if(!Validacao::validarMascaraCpf($_POST['nr_cpf']) && !Validacao::validarCpf($_POST['nr_cpf'])) $errosP[] = 'nr_cpf';
                            }
                            if(!Validacao::validarDataNaoObg($_POST['dt_nascimento'])) $errosP[] = 'dt_nascimento';
                            if(!Validacao::validarTelefoneNaoObg($_POST['nr_celular'])) $errosP[] = 'nr_celular';
                            if(!Validacao::validarEmail($_POST['ds_emailproprietario'])) $errosP[] = 'ds_emailproprietario';
                            if(!Validacao::validarStatus($_POST['ao_status'])) $errosP[] = 'ao_status';
                            if(!Validacao::validarStatus($_POST['ao_recrutador'])) $errosP[] = 'ao_recrutador';

                            //valido o id
                            if(!Validacao::validarIdCandidatoFormacao($_POST['detalhe'])) $erroEED++;

                            //se nao houver erros
                            if(count($errosP)==0 && $erroEED==0){

                                //testo acesso por segurança
                                if(!ControleLoginEmpresa::verificarAcesso()){
                                    ControleLoginEmpresa::deslogar();
                                }

                                //recebo a empresa da sessao
                                $e = ControleSessao::buscarObjeto('privateEmp');

                                $edDAO = new EmpresaDetalheDAO();

                                if($edDAO->verificar($_POST['detalhe'], $e->id_empresa)){

                                    //instancio um EmpresaDetalheVO
                                    $ed = new EmpresaDetalheVO();
                                    //seto os dados
                                    $ed->id_empresadetalhe = $_POST['detalhe'];
                                    $ed->nm_proprietario = Servicos::converterStrtoupper($_POST['nm_proprietario']);
                                    $ed->ds_cargo = Servicos::converterStrtoupper($_POST['ds_cargo']);
                                    $ed->nr_cpf = $_POST['nr_cpf'];
                                    $ed->dt_nascimento = Validacao::explodirDataNaoObg($_POST['dt_nascimento']);
                                    $ed->nr_celular = $_POST['nr_celular'];
                                    $ed->ds_emailproprietario = Servicos::converterStrtoupper($_POST['ds_emailproprietario']);
                                    $ed->ao_status = $_POST['ao_status'];
                                    $ed->id_empresa = $e->id_empresa;
                                    $ed->ao_recrutador = $_POST['ao_recrutador'];

                                    //atualizo na base e recebo true se bem sucedida
                                    $flag = $edDAO->alterarEmpresaDetalhe($ed);

                                    if(!$flag){
                                        //se ocorreu um erro no update
                                        ControleSessao::inserirVariavel('erroEED', 'Ocorreu um erro. Tente novamente!');
                                        //redireciona
                                        header('location:../visao/GuiManutencaoEmpresa.php#parte-02');
                                    }

                                    ControleLoginEmpresa::acessarSessao($e);
                                    header('location:../visao/GuiManutencaoEmpresa.php#parte-02');

                                }else{
                                    //se ocorreu um erro no select
                                    ControleSessao::inserirVariavel('erroEED', 'Ocorreu um erro. Tente novamente!');
                                    //redireciona
                                    header('location:../visao/GuiManutencaoEmpresa.php#parte-02');
                                }
                            }else{
                                //registra o erro
                                ControleSessao::inserirVariavel('erroEED', 'Ocorreu um erro. Tente novamente!');
                                //redireciona
                                header('location:../visao/GuiManutencaoEmpresa.php#parte-02');
                            }

                        }
                    break;
                }
            }
        break;

        /***************************************************************************************************************
         *  DESLOGAR
         **************************************************************************************************************/
        case 'deslogar':
            ControleLoginEmpresa::deslogar();
            break;

        /***************************************************************************************************************
         *  DESTRUIR O ACESSO EMPRESA DO INTERNO
         **************************************************************************************************************/
        case 'destruir':
            unset($_SESSION['privateEmp']);
            unset($_SESSION['objVaga']);
            unset($_SESSION['candidatos']);
            unset($_SESSION['ds_email']);
            unset($_SESSION['pw_senhaportal']);
            unset($_SESSION['candidatosContratados']);
            header('location:../../interno/busca.php#parte-06');
            break;

        /***************************************************************************************************************
         *  LOGAR
         **************************************************************************************************************/
        case 'logar':

            if(isset($_POST['login']) && isset($_POST['senha'])){

                $contErros = 0;

                //valido os dados
                if(!Validacao::validarEmail($_POST['login'])) $contErros++;
                if(!Validacao::validarSenha($_POST['senha'])) $contErros++;

                if($contErros==0){
                    //instancio um EmpresaVO
                    $e = new EmpresaVO();
                    //seto o login/email e senha
                    $e->ds_email = $_POST['login'];
                    $e->pw_senhaportal = Validacao::criptografar($_POST['senha']);
                    //logo a empresa no sistema
                    ControleLoginEmpresa::logar($e);
                }else{
                    //registra a mensagem de erro
                    ControleSessao::inserirVariavel('msgEmpresa', 'Login e/ou Senha incorretos');
                    //redireciona para o login
                    header('location:../../index.php');
                }
            }
        break;

        /***************************************************************************************************************
         *  VISUALIZAR EMPRESA PELO INTERNO
         **************************************************************************************************************/
        case 'visualizarEmp':
            //var_dump($_SESSION);die;
            if(isset($_SESSION['id_empresa'])){

                $contErros = array();

                //valido os dados
                if(!is_numeric($_SESSION['id_usuario'])) $contErros[] = 'id_usuario';
                if(!is_numeric($_SESSION['id_empresa'])) $contErros[] = 'id_empresa';

                if(count($contErros)==0){

                    $eDAO = new EmpresaDAO();
                    $e = $eDAO->buscarEmpresa($_SESSION['id_empresa']);

                    //cadastro o log de acesso do usuário do interno quando acessa como empresa.
                    $lue = new LogUsuarioEmpresaVO();
                    $lue->id_usuario = $_SESSION['id_usuario'];
                    $lue->id_empresa = $_SESSION['id_empresa'];

                    $lueDAO = new LogUsuarioEmpresaDAO();
                    $lueDAO->cadastrarLogUsuarioEmpresa($lue);


                    //logo a empresa no sistema
                    ControleLoginEmpresa::acessarSessao($e);
                    header('location:../visao/GuiVagas.php');
                }else{
                    //registra a mensagem de erro
                    ControleSessao::inserirVariavel('msgEmpresa', 'Login e/ou Senha incorretos');
                    //redireciona para o login
                    header('location:../../index.php');
                }
            }
        break;

        /***************************************************************************************************************
         *  ALTERAR SENHA
         **************************************************************************************************************/
        case 'alterarSenha':
            if(isset($_POST['login']) &&
                    isset($_POST['senha']) &&
                    isset($_POST['nova_senha']) &&
                    isset($_POST['confirma_senha'])){

                $erros = array();

                //valida os dados
                if(!Validacao::validarEmail($_POST['login'])) $erros[] = 'login';
                if(!Validacao::validarSenha($_POST['senha'])) $erros[] = 'senha';
                if(!Validacao::validarSenha($_POST['nova_senha'])) $erros[] = 'nova_senha';
                if(!Validacao::validarSenha($_POST['confirma_senha'])) $erros[] = 'confirma_senha';
                if($_POST['confirma_senha'] != $_POST['nova_senha']) $erros[] = 'senhas_diferentes';

                if(count($erros)==0){

                    //instancio um EmpresaVO
                    $e = new EmpresaVO();
                    //seto login e a senha atual
                    $e->ds_email = $_POST['login'];
                    $e->pw_senhaportal = Validacao::criptografar($_POST['senha']);

                    //verifico se existi este candidato no banco
                    $eDAO = new EmpresaDAO();
                    $empresa = $eDAO->verificarEmpresa($e);

                    if(isset($empresa) && !is_null($empresa) && $empresa!=false){

                        //seto a nova senha
                        $empresa->pw_senhaportal = Validacao::criptografar($_POST['nova_senha']);

                        //seto o ao_interno para N
                        $empresa->ao_interno = 'N';

                        //altera a senha na base
                        $eDAO->alterarSenha($empresa);

                        //logo o candidato no sistema
                        ControleLoginEmpresa::logar($empresa);

                    }else{
                        //registro a mensagem de erro
                        ControleSessao::inserirVariavel('msg', 'Login e/ou Senha incorretos');
                        //redireciono
                        header('location:../visao/GuiAlterarSenhaEmpresa.php');
                    }

                }else{
                    //registro o array de erros
                    ControleSessao::inserirVariavel('erros', $erros);
                    //redireciono
                    header('location:../visao/GuiAlterarSenhaEmpresa.php');
                }
            }
        break;

        /***************************************************************************************************************
         *  LEMBRAR SENHA
         **************************************************************************************************************/
        case 'lembrarSenha':
            if(isset($_POST['login']) && isset($_POST['nr_cnpj'])){

                //valido os dados
                $errosL = array();
                if(!Validacao::validarEmail($_POST['login'])) $errosL[] = 'login';
                if(!Validacao::validarCnpj($_POST['nr_cnpj'])) $errosL[] = 'nr_cnpj';

                if(count($errosL)==0){

                    //instancio um EmpresaVO
                    $e = new EmpresaVO();
                    //seto o cnpj e o login(email)
                    $e->ds_email = $_POST['login'];
                    $e->nr_cnpj = $_POST['nr_cnpj'];

                    //instancio um EmpresaDAO
                    $eDAO = new EmpresaDAO();
                    //verifico se tem na base uma empresa com esse cnpj e email
                    $empresa = $eDAO->verificarNrCnpj($e);

                    if(isset($empresa) && !is_null($empresa) && !is_bool($empresa)){

                        //gero uma nova senha randonica
                        $pw = Validacao::gerarSenha();

                        //seto a senha randonica criptografada
                        $empresa->pw_senhaportal = Validacao::criptografar($pw);

                        //seto o ao_interno para S para forçar a empresa alterar sua senha ao acessar o sistema
                        $empresa->ao_interno = 'S';

                        //altero a senha na base
                        $eDAO->alterarSenha($empresa);

                        //mensagem do email
                        $msg = "<p>
                                Você solicitou o serviço Lembre Minha Senha,
                                ao acessar sua conta será solicitado a alteração da mesma para sua segurança.
                                </p>
                                Sua nova senha: <b>$pw</b>";

                        //envia o email
                        Email::enviarEmail($empresa->ds_email, 'Lembre Minha Senha', $msg, $empresa->nm_contato);

                        //registra mensagem
                        ControleSessao::inserirVariavel('msg', 'Verifique seu e-mail.');
                        //redireciono
                        header('location:../visao/GuiLembrarSenhaEmpresa.php');

                    }else{
                        //registro a mensagem de erro
                        ControleSessao::inserirVariavel('msg', 'Login e/ou CNPJ incorretos');
                        //redireciono
                        header('location:../visao/GuiLembrarSenhaEmpresa.php');
                    }
                }else{
                    //registro o array de erros e o post
                    ControleSessao::inserirVariavel('errosL', $errosL);
                    ControleSessao::inserirVariavel('post', $_POST);
                    //redireciono
                    header('location:../visao/GuiLembrarSenhaEmpresa.php');
                }

            }
        break;

        /***************************************************************************************************************
         *  CADASTRAR ADMISSAO
         **************************************************************************************************************/
        case 'cadastrarAdmissao':
            die('Não é mais utilizado!');
            if(isset($_POST)){

                //array de erros
                $errosA = array();

                //valido os dados
                if(!Validacao::validarAdmitido($_POST['admitido'])) $errosA[] = 'admitido';
                if(!Validacao::validarMascaraCpf($_POST['nr_cpf']) && !Validacao::validarCpf($_POST['nr_cpf'])) $errosA[] = 'nr_cpf';
                if(!Validacao::validarNome($_POST['ds_cargo'])) $errosA[] = 'ds_cargo';
                if(!Validacao::validarData($_POST['dt_admissao'])) $errosA[] = 'dt_admissao';

                //se nao houver erros
                if(count($errosA)==0){

                    //testo acesso por segurança
                    if(!ControleLoginEmpresa::verificarAcesso()){
                        ControleLoginEmpresa::deslogar();
                    }

                    //recebo a empresa da sessao
                    $e = ControleSessao::buscarObjeto('privateEmp');

                    //instancio um AdmissaoVO
                    $a = new AdmissaoVO();
                    //seto os dados
                    $a->id_candidato = $_POST['admitido'];
                    $a->id_empresa = $e->id_empresa;
                    $a->ds_cargo = Servicos::converterStrtoupper($_POST['ds_cargo']);
                    $a->dt_admissao = Validacao::explodirDataNaoObg($_POST['dt_admissao']);

                    $aDAO = new AdmissaoDAO();
                    $flag = $aDAO->cadastrarAdmissao($a);

                    if(!$flag){
                        //registro a mensagem de erro
                        $errosA[] = 'msg';
                        ControleSessao::inserirVariavel('errosA', $errosA);
                        //redireciono
                        header('location:../visao/GuiAdmissao.php');
                    }else{
                        ControleLoginEmpresa::acessarSessao($e);
                        header('location:../visao/GuiAdmissao.php');
                    }

                }else{
                    //registra o array de erros e o post
                    ControleSessao::inserirVariavel('errosA', $errosA);
                    ControleSessao::inserirVariavel('post', $_POST);
                    //redireciona
                    header('location:../visao/GuiAdmissao.php');
                }
            }
        break;

        default:
            ControleLoginEmpresa::deslogar();
        break;
    }
}
?>
