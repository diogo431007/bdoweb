<?php
include_once '../util/ControleSessao.class.php';
//abro sessao
ControleSessao::abrirSessao();

include_once '../modelo/CandidatoVO.class.php';
include_once '../modelo/CandidatoFormacaoVO.class.php';
include_once '../modelo/CandidatoQualificacaoVO.class.php';
include_once '../modelo/CandidatoExperienciaVO.class.php';
include_once '../modelo/UploadVO.class.php';
include_once '../modelo/CandidatoProfissaoVO.class.php';

include_once '../persistencia/CandidatoDAO.class.php';
include_once '../persistencia/CandidatoFormacaoDAO.class.php';
include_once '../persistencia/CandidatoQualificacaoDAO.class.php';
include_once '../persistencia/CandidatoExperienciaDAO.class.php';
include_once '../persistencia/CandidatoQualificacaoDAO.class.php';
include_once '../persistencia/CandidatoProfissaoDAO.class.php';

include_once '../util/Validacao.class.php';
include_once '../util/ControleLoginCandidato.class.php';
include_once '../util/Email.class.php';
include_once '../util/Servicos.class.php';
include_once '../util/Imprimir.class.php';

if(isset($_GET['op'])){

    //switch do op para executar as operações
    switch($_GET['op']){
        case 'cadastrar':

            //testo se existi o post
            if(isset($_POST)){

                //var_dump($_POST);die;

                //array de erros de validacao
                $errosP = array();

                //valido cada informação
                if(!Validacao::validarNome($_POST['nm_candidato'])) $errosP[] = 'nm_candidato';
                if(!Validacao::validarMascaraCpf($_POST['nr_cpf']) && !Validacao::validarCpf($_POST['nr_cpf'])) $errosP[] = 'nr_cpf';
                if(!Validacao::validarRg($_POST['nr_rg'])) $errosP[] = 'nr_rg';
                if(!Validacao::validarNrCtps($_POST['nr_ctps'])) $errosP[] = 'nr_ctps';
                if(!Validacao::validarNrSerie($_POST['nr_serie'])) $errosP[] = 'nr_serie';
                if(!Validacao::validarEmail($_POST['ds_email'])) $errosP[] = 'ds_email';
                if(!Validacao::validarTelefoneNaoObg($_POST['nr_telefone'])) $errosP[] = 'nr_telefone';
                if(!Validacao::validarTelefoneNaoObg($_POST['nr_celular'])) $errosP[] = 'nr_celular';
                if(!Validacao::validarData($_POST['dt_nascimento'])) $errosP[] = 'dt_nascimento';
                if(!Validacao::validarSexo($_POST['ao_sexo'])) $errosP[] = 'ao_sexo';
                if(!Validacao::validarNacionalidade($_POST['ds_nacionalidade'])) $errosP[] = 'ds_nacionalidade';
                if(!Validacao::validarIdEstado($_POST['id_estado'])) $errosP[] = 'id_estado'; //NEW
                if(!Validacao::validarIdCidadeCandidato($_POST['id_cidade'])) $errosP[] = 'id_cidade';
                if(($_POST['id_bairro'] == null)) {
                    if(!Validacao::validarBairro($_POST['ds_bairro'])) $errosP[] = 'ds_bairro';
                } else {
                    if(!Validacao::validarIdBairroCandidato($_POST['id_bairro'])) $errosP[] = 'id_bairro';
                }
                if(!Validacao::validarDsLogradouro($_POST['ds_logradouro'])) $errosP[] = 'ds_logradouro';
                if(!Validacao::validarNrLogradouro($_POST['nr_logradouro'])) $errosP[] = 'nr_logradouro';
                if(!Validacao::validarIdDeficiencia($_POST['id_deficiencia'])) $errosP[] = 'id_deficiencia';
                if(!Validacao::validarMensagem($_POST['ds_objetivo'])) $errosP[] = 'ds_objetivo';
                if(!Validacao::validarGenerico('/^[(N)|(S)]{1}$/', $_POST['ao_bolsafamilia'])) $errosP[] = 'ao_bolsafamilia';
                if(!Validacao::validarGenerico('/^[0-9]{0,11}$/', $_POST['nr_nis'])) $errosP[] = 'nr_nis';

                if(!Validacao::validarLogin($_POST['ds_loginportal'])) $errosP[] = 'ds_loginportal';



                //se nao houver erros
                if(count($errosP)==0){

                    //instancio objeto dao
                    $cDAO = new CandidatoDAO();

                    //testo se o cpf e login ja estao cadastrados
                    $fLogin = $cDAO->verificarLogin($_POST['ds_loginportal']);


                    $fCpf = $cDAO->verificarCpf($_POST['nr_cpf']);

                    if(!$fLogin){

                        $errosP[] = 'login_cadastrado';

                    }if(!$fCpf){

                        $errosP[] = 'cpf_cadastrado';

                    }if(Servicos::calculaIdade(Validacao::explodirData($_POST['dt_nascimento'])) < 14){

                        $errosP[] = 'menor_idade';

                    }

                    if(count($errosP)!=0){

                        //Registrar sessão o array $erros e o array $_POST
                        ControleSessao::inserirVariavel('errosP', $errosP);
                        ControleSessao::inserirVariavel('post', $_POST);
                        //Redireciona
                        header('location:../visao/GuiCadCandidato.php#parte-01');

                    }else{

                        //Instanciando objeto CandidatoVO
                        $cp = new CandidatoVO();

                        $pw = Validacao::gerarSenha();
                        //seto os dados
                        //$cp->id_cbo = $_POST['id_cbo'];
                        $cp->id_deficiencia = Validacao::testatDeficiencia($_POST['id_deficiencia']);
                        $cp->id_userInclusao = 'null';
                        $cp->id_userAlteracao = 'null';
                        $cp->dt_alteracao = 'null';
                        $cp->dt_cadastro = 'NOW()';
                        $cp->dt_validade = 'CURDATE() + INTERVAL 61 DAY';
                        $cp->nm_candidato = Servicos::converterStrtoupper($_POST['nm_candidato']);
                        $cp->ds_email = Servicos::converterStrtoupper($_POST['ds_email']);
                        $cp->nr_telefone = $_POST['nr_telefone'];
                        $cp->nr_celular = $_POST['nr_celular'];
                        $cp->ds_estado_civil = (!empty($_POST['ds_estado_civil'])) ? "'".$_POST['ds_estado_civil']."'" : 'null';
                        $cp->dt_nascimento = Validacao::explodirData($_POST['dt_nascimento']);
                        $cp->ao_sexo = $_POST['ao_sexo'];
                        $cp->ds_nacionalidade = Servicos::converterStrtoupper($_POST['ds_nacionalidade']);
                        $cp->nr_cep = $_POST['nr_cep'];
                        $cp->ds_logradouro = Servicos::converterStrtoupper($_POST['ds_logradouro']);
                        $cp->nr_logradouro = $_POST['nr_logradouro'];
                        $cp->ds_complemento = Servicos::converterStrtoupper($_POST['ds_complemento']);
						$cp->ds_bairro = (!empty($_POST['ds_bairro'])) ? Servicos::converterStrtoupper($_POST['ds_bairro']) : '';
                        $cp->id_bairro = (!empty($_POST['id_bairro'])) ? $_POST['id_bairro'] : 'null';
                        $cp->id_estado = $_POST['id_estado'];
                        $cp->id_cidade = (!empty($_POST['id_cidade'])) ? $_POST['id_cidade'] : 'null';
                        $cp->ds_objetivo = Servicos::converterStrtoupper($_POST['ds_objetivo']);
                        $cp->nr_cpf = $_POST['nr_cpf'];
                        $cp->nr_rg = $_POST['nr_rg'];
                        $cp->nr_ctps = $_POST['nr_ctps'];
                        $cp->nr_pis = $_POST['nr_pis'];
                        $cp->nr_serie = $_POST['nr_serie'];
                        $cp->id_estadoctps = (!empty($_POST['id_estadoctps'])) ? $_POST['id_estadoctps'] : 'null';
                        $cp->ao_interno = 'S';
                        $cp->ds_loginportal = Servicos::converterStrtoupper($_POST['ds_loginportal']);
                        $cp->pw_senhaportal = Validacao::criptografar($pw);
                        $cp->ds_cnh = (!empty($_POST['ds_cnh'])) ? "'".$_POST['ds_cnh']."'" : 'null';
                        $cp->ao_bolsafamilia = $_POST['ao_bolsafamilia'];
                        $cp->nr_nis = (!empty($_POST['nr_nis'])) ? $_POST['nr_nis'] : 'null';
                        $cp->ao_ativo = 'null';

                        //metodo que cadastra na base e retorna o idCandidato gerado
                        $idCandidato = $cDAO->cadastrarCandidato($cp);
                        //seta no CandidatoVO o id gerado no cadastro
                        $cp->id_candidato = $idCandidato;


                        //mensagem do email
                        $msg = "<p>
                                Bem-vindo ao Banco de Oportunidades.
                                Você acaba de se cadastrar com sucesso.
                                </p>
                                Suas credenciais de acesso estão abaixo.<br><br>
                                Login: <b>$cp->ds_loginportal</b><br>
                                Senha: <b>$pw</b><br><br>
                                Por questões de segurança, orientamos que o Sr(a) troque sua senha,
                                antes de fazer o 1º acesso.";
                        //envia o email
                        Email::enviarEmail($cp->ds_email, 'Validação de Cadastro', $msg, $cp->nm_candidato);


                        //registra mensagem
                        //ControleSessao::inserirVariavel('msg','Prezado candidato(a). Verifique seu email.');
                        //redireciono
                        //header('location:../../');

                        $cq = new CandidatoQualificacaoVO();
                        $cq->id_qualificacao = null;
                        $cq->id_candidato = $idCandidato;
                        $cq->id_userAlteracao = 'null';
                        $cq->id_userInclusao = 'null';
                        $cq->ds_qualificacao = 'SEM QUALIFICAÇÃO';
                        $cq->dt_termino = 'null';
                        $cq->qtd_horas = 'null';
                        $cq->nm_instituicao = 'SEM INSTITUIÇÃO';
                        $cq->dt_inclusao = 'now()';
                        $cq->dt_alteracao = 'null';
                        $cq->ao_pronatec = 'null';
                        $cq->ao_qualificacao = '';
                        //instancio objeto dao
                        $cqDAO = new CandidatoQualificacaoDAO();
                        $cqDAO->cadastrarCandidatoQualificacao($cq);

                        $ce = new CandidatoExperienciaVO();
                        $ce->id_experiencia = null;
                        $ce->id_userAlteracao = 'null';
                        $ce->id_userInclusao = 'null';
                        $ce->id_candidato = $idCandidato;
                        $ce->dt_inicio = 'null';
                        $ce->dt_termino = 'null';
                        $ce->nm_empresa = 'SEM EXPERIÊNCIA';
                        $ce->ds_atividades = '';
                        $ce->dt_inclusao = 'now()';
                        $ce->dt_alteracao = 'null';
                        $ce->ao_experiencia = '';
                        //instancio objeto dao
                        $ceDAO = new CandidatoExperienciaDAO();
                        $ceDAO->cadastrarCandidatoExperiencia($ce);

                        ControleLoginCandidato::acessarSessao($cp);
                        //Redireciona
                        header('location:../visao/GuiManutencaoCandidato.php#parte-07');

                    }
                }else{
                    //se houver algum erro
                    //Registrar sessão o array $erros e o array $_POST
                    ControleSessao::inserirVariavel('errosP', $errosP);
                    ControleSessao::inserirVariavel('post', $_POST);
                    //var_dump($_POST['id_cidade']);die;
                    //Redireciona
                    header('location:../visao/GuiCadCandidato.php#parte-01');
                }
            }
        break;

        /***************************************************************************************************************
         *  MANUTENCAO
         **************************************************************************************************************/
        case 'manutencao':
            if(isset($_GET['form'])){
                //switch do form para testar de qual formaulario vem o post
                switch($_GET['form']){

                    /*******************************formulario dos dados pessoais****************************************/
                    case 1:
                        //array de erros de validacao
                        $errosP = array();

                        //testo se existi o post
                        if(isset($_POST)){

                            //valido cada informação
                            if(!Validacao::validarNome($_POST['nm_candidato'])) $errosP[] = 'nm_candidato';
                            if(!Validacao::validarMascaraCpf($_POST['nr_cpf']) && !Validacao::validarCpf($_POST['nr_cpf'])) $errosP[] = 'nr_cpf';
                            if(!Validacao::validarRg($_POST['nr_rg'])) $errosP[] = 'nr_rg';
                            if(!Validacao::validarNrCtps($_POST['nr_ctps'])) $errosP[] = 'nr_ctps';
                            //if(!Validacao::validarGenerico($_POST['nr_pis'])) $errosP[] = 'nr_pis';
                            if(!Validacao::validarNrSerie($_POST['nr_serie'])) $errosP[] = 'nr_serie';
                            if(!Validacao::validarEmail($_POST['ds_email'])) $errosP[] = 'ds_email';
                            if(!Validacao::validarTelefoneNaoObg($_POST['nr_telefone'])) $errosP[] = 'nr_telefone';
                            if(!Validacao::validarTelefoneNaoObg($_POST['nr_celular'])) $errosP[] = 'nr_celular';
                            if(!Validacao::validarData($_POST['dt_nascimento'])) $errosP[] = 'dt_nascimento';
                            if(!Validacao::validarSexo($_POST['ao_sexo'])) $errosP[] = 'ao_sexo';
                            if(!Validacao::validarNacionalidade($_POST['ds_nacionalidade'])) $errosP[] = 'ds_nacionalidade';
							if(!Validacao::validarIdCidadeCandidato($_POST['id_cidade'])) $errosP[] = 'id_cidade';
                            if(($_POST['id_bairro'] == null)) {
                                if(!Validacao::validarBairro($_POST['ds_bairro'])) $errosP[] = 'ds_bairro';
                            } else {
                                if(!Validacao::validarIdBairroCandidato($_POST['id_bairro'])) $errosP[] = 'id_bairro';
                            }
                            if(!Validacao::validarDsLogradouro($_POST['ds_logradouro'])) $errosP[] = 'ds_logradouro';
                            if(!Validacao::validarNrLogradouro($_POST['nr_logradouro'])) $errosP[] = 'nr_logradouro';
                            if(!Validacao::validarDsComplemento($_POST['ds_complemento'])) $errosP[] = 'ds_complemento';
                            if(!Validacao::validarIdDeficiencia($_POST['id_deficiencia'])) $errosP[] = 'id_deficiencia';
                            if(!Validacao::validarMensagem($_POST['ds_objetivo'])) $errosP[] = 'ds_objetivo';
                            if(!Validacao::validarGenerico('/^[(N)|(S)]{1}$/', $_POST['ao_bolsafamilia'])) $errosP[] = 'ao_bolsafamilia';
                            if(!Validacao::validarGenerico('/^[0-9]{0,11}$/', $_POST['nr_nis'])) $errosP[] = 'nr_nis';
//                            if(!Validacao::validarStatus($_POST['ao_ativo'])) $errosP[] = 'ao_ativo';
                            if(Servicos::calculaIdade(Validacao::explodirData($_POST['dt_nascimento'])) < 14){
                                $errosP[] = 'menor_idade';
                            }
                            //se nao houver erros
                            if(count($errosP)==0){

                                //Instanciando objeto CandidatoVO
                                $cp = new CandidatoVO();

                                //recebo o CandidatoVO logado da sessao
                                $cp = ControleSessao::buscarObjeto('privateCand');

                                //seto os dados
                                $cp->id_deficiencia = Validacao::testatDeficiencia($_POST['id_deficiencia']);
                                $cp->dt_alteracao = 'NOW()';
                                $cp->nm_candidato = Servicos::converterStrtoupper($_POST['nm_candidato']);
                                $cp->ds_email = Servicos::converterStrtoupper($_POST['ds_email']);
                                $cp->nr_telefone = $_POST['nr_telefone'];
                                $cp->nr_celular = $_POST['nr_celular'];
                                $cp->ds_estado_civil = (!empty($_POST['ds_estado_civil'])) ? "'".$_POST['ds_estado_civil']."'" : 'null';
                                $cp->dt_nascimento = Validacao::explodirData($_POST['dt_nascimento']);
                                $cp->ao_sexo = $_POST['ao_sexo'];
                                $cp->ds_nacionalidade = Servicos::converterStrtoupper($_POST['ds_nacionalidade']);
                                $cp->nr_cep = $_POST['nr_cep'];
                                $cp->ds_logradouro = Servicos::converterStrtoupper($_POST['ds_logradouro']);
                                $cp->nr_logradouro = $_POST['nr_logradouro'];
                                $cp->ds_complemento = Servicos::converterStrtoupper($_POST['ds_complemento']);
								$cp->ds_bairro = (!empty($_POST['ds_bairro'])) ? Servicos::converterStrtoupper($_POST['ds_bairro']) : '';
                                $cp->id_bairro = (!empty($_POST['id_bairro'])) ? $_POST['id_bairro'] : 'null';
                                $cp->id_estado = (!empty($_POST['id_estadoctps'])) ? $_POST['id_estadoctps'] : 'null';
                                $cp->id_cidade = (!empty($_POST['id_cidade'])) ? $_POST['id_cidade'] : 'null';
                                $cp->ds_objetivo = Servicos::converterStrtoupper($_POST['ds_objetivo']);
                                $cp->nr_rg = $_POST['nr_rg'];
                                $cp->nr_ctps = $_POST['nr_ctps'];
                                $cp->nr_pis = $_POST['nr_pis'];
                                $cp->nr_serie = $_POST['nr_serie'];
                                $cp->id_estadoctps = (!empty($_POST['id_estadoctps'])) ? $_POST['id_estadoctps'] : 'null';
                                $cp->ao_interno = 'N';
                                $cp->ds_cnh = (!empty($_POST['ds_cnh'])) ? "'".$_POST['ds_cnh']."'" : 'null';
                                $cp->ao_bolsafamilia = $_POST['ao_bolsafamilia'];
                                $cp->nr_nis = (!empty($_POST['nr_nis'])) ? $_POST['nr_nis'] : 'null';
                                $cp->ao_ativo = $_POST['ao_ativo'];


                                //instancio objeto dao
                                $cDAO = new CandidatoDAO();
                                //metodo que atualiza na base
                                $cDAO->alterarCandidato($cp);

                                if($cp->ao_ativo == 'N'){

                                    $msg = "<p>Você optou por desativar o seu currículo para empresas.</p>";
                                    //envia o email ao candidato que desativou o currículo
                                    Email::enviarEmail($cp->ds_email, 'Inativação de Currículo', $msg, $cp->nm_candidato);

                                    ControleLoginCandidato::acessarSessao($cp);
                                    //Redireciona
                                    header('location:../visao/GuiManutencaoCandidato.php#parte-07');

                                }else{
                                    ControleLoginCandidato::acessarSessao($cp);
                                    //Redireciona
                                    header('location:../visao/GuiManutencaoCandidato.php#parte-07');
                                }
                            }else{

                                //se houver algum erro
                                //Registrar sessão o array $erros e o array $_POST
                                ControleSessao::inserirVariavel('errosP', $errosP);
                                ControleSessao::inserirVariavel('post', $_POST);

                                //Redireciona
                                header('location:../visao/GuiManutencaoCandidato.php#parte-01');
                            }
                        }//is isset post
                    break;

                    /*******************************cadastrar formacao de candidato****************************************/
                    case 2:
                        if(isset($_POST)){
                            //array de erros
                            $errosF = array();

                            //valido cada informação
                            if(!Validacao::validarFormacao($_POST['id_formacao'])) $errosF[] = 'id_formacao';
                            if(!Validacao::validarDtTermino($_POST['dt_termino'])) $errosF[] = 'dt_termino';
                            if(!Validacao::validarNmEscola($_POST['nm_escola'])) $errosF[] = 'nm_escola';
                            if(!Validacao::validarNmEscola($_POST['ds_cidadeEscola'])) $errosF[] = 'ds_cidadeEscola';
                            if(!Validacao::validarCursoCand($_POST['curso_cand'])) $errosF[] = 'curso_cand';
                            if(!Validacao::validarSemestreCand($_POST['semestre_cand'])) $errosF[] = 'semestre_cand';


                            $id = $_POST['id_formacao'];
                            if (($id == 6 || $id == 7 || $id == 8) && empty($_POST['curso_cand'])){
                               $errosF[] = 'curso_cand';
                            }

                            if(count($errosF)==0){

                                //testo o acesso por seguranca
                                if(!ControleLoginCandidato::verificarAcesso()){
                                    ControleLoginCandidato::deslogar();
                                }

                                $c = ControleSessao::buscarObjeto('privateCand');


                                $cf = new CandidatoFormacaoVO();
                                $cf->id_candidato_formacao = null;
                                $cf->id_candidato = $c->id_candidato;
                                $cf->id_formacao = $_POST['id_formacao'];
                                $cf->id_userAlteracao = 'null';
                                $cf->id_userInclusao = 'null';
                                $cf->dt_termino = Validacao::explodirDataNaoObg($_POST['dt_termino']);
                                $cf->nm_escola = Servicos::converterStrtoupper($_POST['nm_escola']);
                                $cf->ds_cidadeescola = Servicos::converterStrtoupper($_POST['ds_cidadeEscola']);
                                $cf->dt_inclusao = 'now()';
                                $cf->dt_alteracao = 'null';
                                $cf->ds_curso = Servicos::converterStrtoupper($_POST['curso_cand']);
                                $cf->ds_semestre = Servicos::converterStrtoupper($_POST['semestre_cand']);

                                //instancio objeto dao
                                $cfDAO = new CandidatoFormacaoDAO();
                                $cfDAO->cadastrarCandidatoFormacao($cf);

                                //atualiza a dt_alteracao do candidato
                                $cDAO = new CandidatoDAO();
                                $cDAO->atualizarDtAlteracao($c->id_candidato);


                                $cDAO = new CandidatoDAO();



                                //Implementação para usuários antigos para não ocultar abas e somente atualizar o que falta preencher
                                if(($c->ao_abaformacao == 'A') && ($c->ao_abaqualificacao == 'A') && ($c->ao_abaexperiencia == 'A')){
                                        $c->ao_ativo = 'A';
                                        $c->ao_abaformacao = 'S';
                                        $c->ao_abaqualificacao = 'A';
                                        $c->ao_abaexperiencia = 'A';
                                }else if(($c->ao_abaformacao == 'A') && ($c->ao_abaqualificacao == 'S') && ($c->ao_abaexperiencia == 'A')){
                                        $c->ao_ativo = 'A';
                                        $c->ao_abaformacao = 'S';
                                        $c->ao_abaqualificacao = 'S';
                                        $c->ao_abaexperiencia = 'A';
                                }else if(($c->ao_abaformacao == 'A') && ($c->ao_abaqualificacao == 'A') && ($c->ao_abaexperiencia == 'S')){
                                        $c->ao_ativo = 'A';
                                        $c->ao_abaformacao = 'S';
                                        $c->ao_abaqualificacao = 'A';
                                        $c->ao_abaexperiencia = 'S';
                                }else if(($c->ao_abaformacao == 'A') && ($c->ao_abaqualificacao == 'S') && ($c->ao_abaexperiencia == 'S')){
                                        $c->ao_ativo = 'S';
                                        $c->ao_abaformacao = 'S';
                                        $c->ao_abaqualificacao = 'S';
                                        $c->ao_abaexperiencia = 'S';
                                }else if(($c->ao_abaformacao == 'S') && ($c->ao_abaqualificacao == 'A') && ($c->ao_abaexperiencia == 'A')){
                                        $c->ao_ativo = 'A';
                                        $c->ao_abaformacao = 'S';
                                        $c->ao_abaqualificacao = 'A';
                                        $c->ao_abaexperiencia = 'A';
                                }else if(($c->ao_abaformacao == 'S') && ($c->ao_abaqualificacao == 'S') && ($c->ao_abaexperiencia == 'A')){
                                        $c->ao_ativo = 'A';
                                        $c->ao_abaformacao = 'S';
                                        $c->ao_abaqualificacao = 'S';
                                        $c->ao_abaexperiencia = 'A';
                                }else if(($c->ao_abaformacao == 'S') && ($c->ao_abaqualificacao == 'A') && ($c->ao_abaexperiencia == 'S')){
                                        $c->ao_ativo = 'A';
                                        $c->ao_abaformacao = 'S';
                                        $c->ao_abaqualificacao = 'A';
                                        $c->ao_abaexperiencia = 'S';
                                }
                                //Se não existir usuário antigo cai no else
                                else{
                                    if(($c->ao_abaformacao == 'S') && ($c->ao_abaqualificacao == 'S') && ($c->ao_abaexperiencia == 'N')){
                                        $c->ao_ativo = 'null';
                                        $c->ao_abaformacao = 'S';
                                        $c->ao_abaqualificacao = 'S';
                                        $c->ao_abaexperiencia = 'N';
                                    }else if(($c->ao_abaformacao == 'S') && ($c->ao_abaqualificacao == 'S') && ($c->ao_abaexperiencia == 'S')){
                                        //verifica se currículo está ativo ou inativo
                                        if($c->ao_ativo == 'S'){
                                            $c->ao_ativo = 'S';
                                        }else if($c->ao_ativo == 'N'){
                                            $c->ao_ativo = 'N';
                                        }else{
                                            //se o currículo não foi cadastrado por completo ainda recebe = ''
                                            $c->ao_ativo = 'null';
                                        }
                                        $c->ao_abaformacao = 'S';
                                        $c->ao_abaqualificacao = 'S';
                                        $c->ao_abaexperiencia = 'S';
                                    }else{
                                        //fluxo normal se o candidato seguir passo a passo
                                        $c->ao_ativo = 'null';
                                        $c->ao_abaformacao = 'S';
                                        $c->ao_abaqualificacao = 'S';
                                        $c->ao_abaexperiencia = 'N';
                                    }
                                }

                                $cDAO->alterarAbas($c);

                                ControleLoginCandidato::acessarSessao($c);
                                //Redireciona
                                header('location:../visao/GuiManutencaoCandidato.php#parte-03');

                            }else{
                                //se houver algum erro
                                //Registrar sessão o array $erros e o array $_POST
                                ControleSessao::inserirVariavel('errosF', $errosF);
                                ControleSessao::inserirVariavel('post', $_POST);
                                //Redireciona
                                header('location:../visao/GuiManutencaoCandidato.php#parte-02');
                            }

                        }//if isset post
                    break;

                    /*******************************deletar uma formacao****************************************/
                    case 3:
                        if(isset($_POST)){
                            //array de erros de validacao
                            $errosDF = array();

                            //valido cada informação
                            if(empty($_POST['ids'])){
                                $errosDF[] = 'Precisa selecionar uma formação!';

                            }else{
                                foreach ($_POST['ids'] as $id) {
                                    if(!Validacao::validarIdCandidatoFormacao($id) && !in_array('Formação Inválida!', $errosDF)) $errosDF[] = 'Formação Inválida!';
                                }
                            }
                            if(count($errosDF)==0){

                                //testo o acesso por seguranca
                                if(!ControleLoginCandidato::verificarAcesso()){
                                    ControleLoginCandidato::deslogar();
                                }
                                $c = ControleSessao::buscarObjeto('privateCand');

                                foreach ($_POST['ids'] as $id) {

                                    $cfDAO = new CandidatoFormacaoDAO();

                                    if($cfDAO->verificar($id,$c->id_candidato)){

                                        $cfDAO->deletarCandidatoFormacao($id);

                                    }else if(!in_array('Formação Inválida!', $errosDF)){

                                        $errosDF[] = 'Formação Inválida!';
                                    }

                                }

                                //atualiza a dt_alteracao do candidato
                                $cDAO = new CandidatoDAO();
                                $cDAO->atualizarDtAlteracao($c->id_candidato);

                                if(count($errosDF)==0){
                                    ControleLoginCandidato::acessarSessao($c);
                                    //Redireciona
                                    header('location:../visao/GuiManutencaoCandidato.php#parte-03');
                                }else{
                                    //Registrar sessão o array $erros
                                    ControleSessao::inserirVariavel('errosDF', $errosDF);
                                    //Redireciona
                                    header('location:../visao/GuiManutencaoCandidato.php#parte-02');
                                }

                            }else{
                                //se houver algum erro
                                //Registrar sessão o array $erros
                                ControleSessao::inserirVariavel('errosDF', $errosDF);
                                //Redireciona
                                header('location:../visao/GuiManutencaoCandidato.php#parte-02');
                            }

                        }//id isset post
                    break;

                    /*******************************formulario dos dados das qualificacoes****************************************/
                    case 4:
                        if(isset($_POST)){
                            //array de erros de validacao
                            $errosQ = array();

                            //valido cada informação
                            if($_POST['ao_qualificacao'] == 'N'){

                                if(!Validacao::validarStatus($_POST['ao_qualificacao'])) $errosQ[] = 'ao_qualificacao';

                            }else{

                                if(!Validacao::validarDsQualificacao($_POST['ds_qualificacao'])) $errosQ[] = 'ds_qualificacao';
                                if(!Validacao::validarNmInstituicao($_POST['nm_instituicao'])) $errosQ[] = 'nm_instituicao';
                                if(!Validacao::validarDtTermino($_POST['dt_termino'])) $errosQ[] = 'dt_termino';
                                if(!Validacao::validarQtdHoras($_POST['qtd_horas'])) $errosQ[] = 'qtd_horas';
                                if(!Validacao::validarStatus($_POST['ao_qualificacao'])) $errosQ[] = 'ao_qualificacao';
                                if(!Validacao::validarStatus($_POST['ao_pronatec'])) $errosQ[] = 'ao_pronatec';
                            }

                            if(count($errosQ)==0){

                                //testo o acesso por seguranca
                                if(!ControleLoginCandidato::verificarAcesso()){
                                    ControleLoginCandidato::deslogar();
                                }

                                //busco o candidato na sessao
                                $c = ControleSessao::buscarObjeto('privateCand');

                                //instancio um objeto CandidatoQualificacaoVO
                                $cq = new CandidatoQualificacaoVO();

                                if($_POST['ao_qualificacao'] == 'N'){
                                    //Deleta todos com N
                                    $cqDAO = new CandidatoQualificacaoDAO();
                                    $cqDAO->deletarQualificacoesNulas($c->id_candidato);

                                    //Insere os candidatos
                                    $cq->id_qualificacao = null;
                                    $cq->id_candidato = $c->id_candidato;
                                    $cq->id_userAlteracao = 'null';
                                    $cq->id_userInclusao = 'null';
                                    $cq->ds_qualificacao = 'SEM QUALIFICAÇÃO';
                                    $cq->dt_termino = 'null';
                                    $cq->qtd_horas = 'null';
                                    $cq->nm_instituicao = 'SEM INSTITUIÇÃO';
                                    $cq->dt_inclusao = 'now()';
                                    $cq->dt_alteracao = 'null';
                                    $cq->ao_pronatec = null;
                                    $cq->ao_qualificacao = $_POST['ao_qualificacao'];

                                }else{

                                    $cqDAO = new CandidatoQualificacaoDAO();

                                    $cqDAO->deletarQualificacoesNulas($c->id_candidato);

                                    $cq->id_qualificacao = null;
                                    $cq->id_candidato = $c->id_candidato;
                                    $cq->id_userAlteracao = 'null';
                                    $cq->id_userInclusao = 'null';
                                    $cq->ds_qualificacao = Servicos::converterStrtoupper($_POST['ds_qualificacao']);
                                    $cq->dt_termino = Validacao::explodirDataNaoObg($_POST['dt_termino']);
                                    $cq->qtd_horas = Validacao::testarQtdHoras($_POST['qtd_horas']);
                                    $cq->nm_instituicao = Servicos::converterStrtoupper($_POST['nm_instituicao']);
                                    $cq->dt_inclusao = 'now()';
                                    $cq->dt_alteracao = 'null';
                                    $cq->ao_pronatec = $_POST['ao_pronatec'];
                                    $cq->ao_qualificacao = $_POST['ao_qualificacao'];

                                }

                                //instancio objeto dao
                                $cqDAO = new CandidatoQualificacaoDAO();
                                $cqDAO->cadastrarCandidatoQualificacao($cq);

                                //atualiza a dt_alteracao do candidato
                                $cDAO = new CandidatoDAO();
                                $cDAO->atualizarDtAlteracao($c->id_candidato);

                                $cDAO = new CandidatoDAO();

                                //Implementação para usuários antigos para não ocultar abas e somente atualizar o que falta preencher
                                if(($c->ao_abaformacao == 'A') && ($c->ao_abaqualificacao == 'A') && ($c->ao_abaexperiencia == 'A')){
                                        $c->ao_ativo = 'A';
                                        $c->ao_abaformacao = 'A';
                                        $c->ao_abaqualificacao = 'S';
                                        $c->ao_abaexperiencia = 'A';
                                }else if(($c->ao_abaformacao == 'S') && ($c->ao_abaqualificacao == 'A') && ($c->ao_abaexperiencia == 'A')){
                                        $c->ao_ativo = 'A';
                                        $c->ao_abaformacao = 'S';
                                        $c->ao_abaqualificacao = 'S';
                                        $c->ao_abaexperiencia = 'A';
                                }else if(($c->ao_abaformacao == 'A') && ($c->ao_abaqualificacao == 'A') && ($c->ao_abaexperiencia == 'S')){
                                        $c->ao_ativo = 'A';
                                        $c->ao_abaformacao = 'A';
                                        $c->ao_abaqualificacao = 'S';
                                        $c->ao_abaexperiencia = 'S';
                                }else if(($c->ao_abaformacao == 'S') && ($c->ao_abaqualificacao == 'A') && ($c->ao_abaexperiencia == 'S')){
                                        $c->ao_ativo = 'S';
                                        $c->ao_abaformacao = 'S';
                                        $c->ao_abaqualificacao = 'S';
                                        $c->ao_abaexperiencia = 'S';
                                }else if(($c->ao_abaformacao == 'A') && ($c->ao_abaqualificacao == 'S') && ($c->ao_abaexperiencia == 'A')){
                                        $c->ao_ativo = 'A';
                                        $c->ao_abaformacao = 'A';
                                        $c->ao_abaqualificacao = 'S';
                                        $c->ao_abaexperiencia = 'A';
                                }else if(($c->ao_abaformacao == 'S') && ($c->ao_abaqualificacao == 'S') && ($c->ao_abaexperiencia == 'A')){
                                        $c->ao_ativo = 'A';
                                        $c->ao_abaformacao = 'S';
                                        $c->ao_abaqualificacao = 'S';
                                        $c->ao_abaexperiencia = 'A';
                                }else if(($c->ao_abaformacao == 'A') && ($c->ao_abaqualificacao == 'S') && ($c->ao_abaexperiencia == 'S')){
                                        $c->ao_ativo = 'A';
                                        $c->ao_abaformacao = 'A';
                                        $c->ao_abaqualificacao = 'S';
                                        $c->ao_abaexperiencia = 'S';
                                }
                                //Se não existir usuário antigo cai no else
                                else{
                                    //Novos candidatos
                                    if(($c->ao_abaformacao == 'S') && ($c->ao_abaqualificacao == 'S') && ($c->ao_abaexperiencia == 'S')){
                                        //verifica se currículo está ativo ou inativo
                                        if($c->ao_ativo == 'S'){
                                            $c->ao_ativo = 'S';
                                        }else if($c->ao_ativo == 'N'){
                                            $c->ao_ativo = 'N';
                                        }else{
                                            //se o currículo não foi cadastrado por completo ainda recebe = ''
                                            $c->ao_ativo = 'null';
                                        }
                                        $c->ao_abaformacao = 'S';
                                        $c->ao_abaqualificacao = 'S';
                                        $c->ao_abaexperiencia = 'S';
                                    }else{
                                        //fluxo normal se o candidato seguir passo a passo
                                        $c->ao_ativo = 'null';
                                        $c->ao_abaformacao = 'S';
                                        $c->ao_abaqualificacao = 'S';
                                        $c->ao_abaexperiencia = 'S';
                                    }
                                }
                                $cDAO->alterarAbas($c);

                                if($_POST['ao_qualificacao'] != 'N'){
                                    $msg = "Qualificação cadastrada com sucesso.";
                                }

                                ControleLoginCandidato::acessarSessao($c);
                                //Redireciona
                                header('location:../visao/GuiManutencaoCandidato.php#parte-04');

                            }else{

                                //se houver algum erro
                                $msg = "Ocorreu um erro ao fazer o cadastro. Tente novamente.";
                                //Registrar sessão o array $erros e o array $_POST
                                ControleSessao::inserirVariavel('errosQ', $errosQ);
                                ControleSessao::inserirVariavel('post', $_POST);
                                //Redireciona
                                header('location:../visao/GuiManutencaoCandidato.php#parte-03');

                            }

                            ControleSessao::inserirVariavel('msgQualificacao', $msg);

                        }
                    break;

                    /*******************************deletar qualificacoes****************************************/
                    case 5:
                        if(isset($_POST)){

                            //array de erros de validacao
                            $errosDQ = array();

                            //valido cada informação
                            if(empty($_POST['idsQua'])) $errosDQ[] = 'Precisa selecionar uma qualificação!';
                            foreach ($_POST['idsQua'] as $id) {
                                if(!Validacao::validarIdCandidatoFormacao($id) && !in_array('Qualificação Inválida!', $errosDQ)) $errosDQ[] = 'Qualificação Inválida!';
                            }

                            if(count($errosDQ)==0){

                                //testo o acesso por seguranca
                                if(!ControleLoginCandidato::verificarAcesso()){
                                    ControleLoginCandidato::deslogar();
                                }
                                $c = ControleSessao::buscarObjeto('privateCand');

                                foreach ($_POST['idsQua'] as $id) {

                                    $cqDAO = new CandidatoQualificacaoDAO();

                                    if($cqDAO->verificar($id,$c->id_candidato)){

                                        $cqDAO->deletarCandidatoQualificacao($id);

                                    }else if(!in_array('Qualificação Inválida!', $errosDQ)){
                                        $errosDQ[] = 'Qualificação Inválida!';
                                    }

                                }
                                $cqDAO = new CandidatoQualificacaoDAO();
                                $qualificacao = $cqDAO->buscarCandidatoQualificacoes($c->id_candidato);

                                if(count($qualificacao)==0){
                                    $cq = new CandidatoQualificacaoVO();
                                    $cq->id_qualificacao = null;
                                    $cq->id_candidato = $c->id_candidato;
                                    $cq->id_userAlteracao = 'null';
                                    $cq->id_userInclusao = 'null';
                                    $cq->ds_qualificacao = 'SEM QUALIFICAÇÃO';
                                    $cq->dt_termino = 'null';
                                    $cq->qtd_horas = 'null';
                                    $cq->nm_instituicao = 'SEM INSTITUIÇÃO';
                                    $cq->dt_inclusao = 'now()';
                                    $cq->dt_alteracao = 'null';
                                    $cq->ao_pronatec = 'null';
                                    $cq->ao_qualificacao = 'N';

                                    //instancio objeto dao
                                    $cqDAO = new CandidatoQualificacaoDAO();
                                    $cqDAO->cadastrarCandidatoQualificacao($cq);
                                }

                                //atualiza a dt_alteracao do candidato
                                $cDAO = new CandidatoDAO();
                                $cDAO->atualizarDtAlteracao($c->id_candidato);

                                if(count($errosDQ)!=0){
                                    //Registrar sessão o array $erros
                                    ControleSessao::inserirVariavel('errosDQ', $errosDQ);
                                    //Redireciona
                                    header('location:../visao/GuiManutencaoCandidato.php#parte-03');
                                }

                                ControleLoginCandidato::acessarSessao($c);
                                //Redireciona
                                header('location:../visao/GuiManutencaoCandidato.php#parte-03');

                            }else{
                                //se houver algum erro
                                //Registrar sessão o array $erros
                                ControleSessao::inserirVariavel('errosDQ', $errosDQ);
                                //Redireciona
                                header('location:../visao/GuiManutencaoCandidato.php#parte-03');
                            }
                        }//id isset post
                    break;

                    /*******************************cadastro de experiencias****************************************/
                    case 6:
                        if(isset($_POST)){
                            //array de erros de validacao
                            $errosE = array();

                            //valido cada informação

                            if($_POST['ao_experiencia'] == 'N'){

                                if(!Validacao::validarStatus($_POST['ao_experiencia'])) $errosQ[] = 'ao_experiencia';

                            }else{

                                if(!Validacao::validarNmEmpresa($_POST['nm_empresa'])) $errosE[] = 'nm_empresa';
                                if(!Validacao::validarDtTermino($_POST['dt_inicio'])) $errosE[] = 'dt_inicio';
                                if(!Validacao::validarDtTermino($_POST['dt_termino'])) $errosE[] = 'dt_termino';
                                if(!Validacao::validarMensagem($_POST['ds_atividades'])) $errosE[] = 'ds_atividades';
                                if(!Validacao::validarStatus($_POST['ao_experiencia'])) $errosQ[] = 'ao_experiencia';
                            }

                            if(count($errosE)==0){

                                //testo o acesso por seguranca
                                if(!ControleLoginCandidato::verificarAcesso()){
                                    ControleLoginCandidato::deslogar();
                                }

                                //busco o candidato na sessao
                                $c = ControleSessao::buscarObjeto('privateCand');

                                //instancio um objeto CandidatoExperienciaVO
                                $ce = new CandidatoExperienciaVO();

                                if($_POST['ao_experiencia'] == 'N'){

                                    //Deleta os candidatos igual a 'N'
                                    $ceDAO = new CandidatoExperienciaDAO();
                                    $ceDAO->deletarExperienciasNulas($c->id_candidato);

                                    //deleta todas do candidatos S e N
//                                    foreach (ControleSessao::buscarObjeto('privateCand')->experiencias as $e) {
//                                        $ceDAO = new CandidatoExperienciaDAO();
//                                        if(is_numeric($ceDAO->verificar($e->id_experiencia, $c->id_candidato))){
//                                            $ceDAO->deletarCandidatoFormacao($e->id_experiencia);
//                                        }
//                                    }

                                    //Insere os candidatos
                                    $ce->id_experiencia = null;
                                    $ce->id_userAlteracao = 'null';
                                    $ce->id_userInclusao = 'null';
                                    $ce->id_candidato = $c->id_candidato;
                                    $ce->dt_inicio = 'null';
                                    $ce->dt_termino = 'null';
                                    $ce->nm_empresa = 'SEM EXPERIÊNCIA';
                                    $ce->ds_atividades = '';
                                    $ce->dt_inclusao = 'now()';
                                    $ce->dt_alteracao = 'null';
                                    $ce->ao_experiencia = 'N';

                                }else{

                                    $ceDAO = new CandidatoExperienciaDAO();

                                    //deleta os qualificacao N
                                    $ceDAO->deletarExperienciasNulas($c->id_candidato);

                                    $ce->id_experiencia = null;
                                    $ce->id_userAlteracao = 'null';
                                    $ce->id_userInclusao = 'null';
                                    $ce->id_candidato = $c->id_candidato;
                                    $ce->dt_inicio = Validacao::explodirDataNaoObg($_POST['dt_inicio']);
                                    $ce->dt_termino = Validacao::explodirDataNaoObg($_POST['dt_termino']);
                                    $ce->nm_empresa = Servicos::converterStrtoupper($_POST['nm_empresa']);
                                    $ce->ds_atividades = Servicos::converterStrtoupper($_POST['ds_atividades']);
                                    $ce->dt_inclusao = 'now()';
                                    $ce->dt_alteracao = 'null';
                                    $ce->ao_experiencia = $_POST['ao_experiencia'];
                                }

                                //instancio objeto dao
                                $ceDAO = new CandidatoExperienciaDAO();
                                $ceDAO->cadastrarCandidatoExperiencia($ce);

                                $cDAO = new CandidatoDAO();


                                //Implementação para usuários antigos para não ocultar abas e somente atualizar o que falta preencher
                                if(($c->ao_abaformacao == 'A') && ($c->ao_abaqualificacao == 'A') && ($c->ao_abaexperiencia == 'A')){
                                        $c->ao_ativo = 'A';
                                        $c->ao_abaformacao = 'A';
                                        $c->ao_abaqualificacao = 'A';
                                        $c->ao_abaexperiencia = 'S';
                                }else if(($c->ao_abaformacao == 'S') && ($c->ao_abaqualificacao == 'A') && ($c->ao_abaexperiencia == 'A')){
                                        $c->ao_ativo = 'A';
                                        $c->ao_abaformacao = 'S';
                                        $c->ao_abaqualificacao = 'A';
                                        $c->ao_abaexperiencia = 'S';
                                }else if(($c->ao_abaformacao == 'A') && ($c->ao_abaqualificacao == 'S') && ($c->ao_abaexperiencia == 'A')){
                                        $c->ao_ativo = 'A';
                                        $c->ao_abaformacao = 'A';
                                        $c->ao_abaqualificacao = 'S';
                                        $c->ao_abaexperiencia = 'S';
                                }else if(($c->ao_abaformacao == 'S') && ($c->ao_abaqualificacao == 'S') && ($c->ao_abaexperiencia == 'A')){
                                        $c->ao_ativo = 'S';
                                        $c->ao_abaformacao = 'S';
                                        $c->ao_abaqualificacao = 'S';
                                        $c->ao_abaexperiencia = 'S';
                                }else if(($c->ao_abaformacao == 'A') && ($c->ao_abaqualificacao == 'A') && ($c->ao_abaexperiencia == 'S')){
                                        $c->ao_ativo = 'A';
                                        $c->ao_abaformacao = 'A';
                                        $c->ao_abaqualificacao = 'A';
                                        $c->ao_abaexperiencia = 'S';
                                }else if(($c->ao_abaformacao == 'S') && ($c->ao_abaqualificacao == 'A') && ($c->ao_abaexperiencia == 'S')){
                                        $c->ao_ativo = 'A';
                                        $c->ao_abaformacao = 'S';
                                        $c->ao_abaqualificacao = 'A';
                                        $c->ao_abaexperiencia = 'S';
                                }else if(($c->ao_abaformacao == 'A') && ($c->ao_abaqualificacao == 'S') && ($c->ao_abaexperiencia == 'S')){
                                        $c->ao_ativo = 'A';
                                        $c->ao_abaformacao = 'A';
                                        $c->ao_abaqualificacao = 'S';
                                        $c->ao_abaexperiencia = 'S';
                                }
                                //Se não existir usuário antigo cai no else
                                else{
                                    if($c->ao_ativo == 'N'){
                                        $c->ao_ativo = 'N';
                                        $c->ao_abaformacao = 'S';
                                        $c->ao_abaqualificacao = 'S';
                                        $c->ao_abaexperiencia = 'S';
                                    }else{
                                        $c->ao_ativo = 'S';
                                        $c->ao_abaformacao = 'S';
                                        $c->ao_abaqualificacao = 'S';
                                        $c->ao_abaexperiencia = 'S';
                                    }
                                }
                                $cDAO->alterarAbas($c);


                                //atualiza a dt_alteracao do candidato
                                $cDAO = new CandidatoDAO();
                                $cDAO->atualizarDtAlteracao($c->id_candidato);

                                if($_POST['ao_experiencia'] != 'N'){
                                    $msg = "Experiência cadastrada com sucesso.";
                                }

                                //logo o candidato para buscar a experiencia cadastrada
                                ControleLoginCandidato::acessarSessao($c);
                                //Redireciona

                                if($_POST['ao_experiencia'] == 'N'){
                                    header('location:../visao/GuiManutencaoCandidato.php#parte-05');
                                }else{
                                    header('location:../visao/GuiManutencaoCandidato.php#parte-04');
                                }

                            }else{
                                //se houver algum erro
                                $msg = "Ocorreu um erro ao fazer o cadastro. Tente novamente.";
                                //Registrar sessão o array $erros e o array $_POST
                                ControleSessao::inserirVariavel('errosE', $errosE);
                                ControleSessao::inserirVariavel('post', $_POST);
                                //Redireciona
                                header('location:../visao/GuiManutencaoCandidato.php#parte-04');
                            }
                            ControleSessao::inserirVariavel('msgExperiencia', $msg);
                        }
                    break;

                    /*******************************deletar experiencias****************************************/
                    case 7:
                        if(isset($_POST)){
                            //array de erros de validacao
                            $errosDE = array();

                            //valido cada informação
                            if(empty($_POST['idsExp'])) $errosDE[] = 'Precisa selecionar uma experiência!';
                            foreach ($_POST['idsExp'] as $id) {
                                if(!Validacao::validarIdCandidatoFormacao($id) && !in_array('Experiência Inválida!', $errosDE)) $errosDE[] = 'Experiência Inválida!';
                            }

                            if(count($errosDE)==0){

                                //testo o acesso por seguranca
                                if(!ControleLoginCandidato::verificarAcesso()){
                                    ControleLoginCandidato::deslogar();
                                }
                                $c = ControleSessao::buscarObjeto('privateCand');

                                foreach ($_POST['idsExp'] as $id) {

                                    $ceDAO = new CandidatoExperienciaDAO();

                                    if($ceDAO->verificar($id,$c->id_candidato)){

                                        $ceDAO->deletarCandidatoFormacao($id);

                                    }else if(!in_array('Experiência Inválida!', $errosDE)){
                                        $errosDE[] = 'Experiência Inválida!';
                                    }
                                }

                                $ceDAO = new CandidatoExperienciaDAO();
                                $experiencia = $ceDAO->buscarCandidatoExperiencias($c->id_candidato);

                                if(count($experiencia)==0){

                                    $ce = new CandidatoExperienciaVO();
                                    $ce->id_experiencia = null;
                                    $ce->id_userAlteracao = 'null';
                                    $ce->id_userInclusao = 'null';
                                    $ce->id_candidato = $c->id_candidato;
                                    $ce->dt_inicio = 'null';
                                    $ce->dt_termino = 'null';
                                    $ce->nm_empresa = 'SEM EXPERIÊNCIA';
                                    $ce->ds_atividades = '';
                                    $ce->dt_inclusao = 'now()';
                                    $ce->dt_alteracao = 'null';
                                    $ce->ao_experiencia = 'N';
                                    //instancio objeto dao
                                    $ceDAO = new CandidatoExperienciaDAO();
                                    $ceDAO->cadastrarCandidatoExperiencia($ce);
                                }

                                //atualiza a dt_alteracao do candidato
                                $cDAO = new CandidatoDAO();
                                $cDAO->atualizarDtAlteracao($c->id_candidato);

                                if(count($errosDE)!=0){
                                    //Registrar sessão o array $erros
                                    ControleSessao::inserirVariavel('errosDE', $errosDE);
                                    //Redireciona
                                    header('location:../visao/GuiManutencaoCandidato.php#parte-04');
                                }

                                ControleLoginCandidato::acessarSessao($c);
                                //Redireciona
                                header('location:../visao/GuiManutencaoCandidato.php#parte-04');

                            }else{
                                //se houver algum erro
                                //Registrar sessão o array $erros
                                ControleSessao::inserirVariavel('errosDE', $errosDE);
                                //Redireciona
                                header('location:../visao/GuiManutencaoCandidato.php#parte-04');
                            }
                        }
                    break;

                    /*******************************cadastro de profissoes****************************************/
                    case 8:
                        if(isset($_POST)){


                            //tiro a vírgula que vem da caixa de texto e coloco num array
                            $profissoes = explode(",", $_POST['profissoes']);

                            if(!empty($_POST['profissoes_jacadastradas'])){
                                //Junto o array com as profissões já cadastradas pelo candidato caso tenha.
                                $todas_profissoes = array_merge($profissoes, $_POST['profissoes_jacadastradas']);
                            }else{
                                $todas_profissoes = $profissoes;
                            }

                            //array de erros de validacao
                            $errosPR = array();

                            if(isset($_POST['ao_outro']) && $_POST['ao_outro'] == 'S'){
                                if(!Validacao::validarNmEmpresa($_POST['ds_outro'])) $errosPR[] = 'ds_outro';
                            }else if(!empty($todas_profissoes)){
                                foreach ($todas_profissoes as $id) {
                                    if(!Validacao::validarIdCbo($id) && !in_array('id_profissao', $errosPR)) $errosPR[] = 'id_profissao';
                                }
                            }else {
                                $errosPR[] = 'id_profissao';
                            }

                            if(count($errosPR)==0){

                                //testo o acesso por seguranca
                                if(!ControleLoginCandidato::verificarAcesso()){
                                    ControleLoginCandidato::deslogar();
                                }

                                //busco o candidato na sessao
                                $c = ControleSessao::buscarObjeto('privateCand');

                                if(isset($_POST['ao_outro'])){

                                    if(Servicos::converterStrtoupper($_POST['ds_outro']) !=
                                            Servicos::converterStrtoupper(ControleSessao::buscarObjeto('privateCand')->profissoes[0]->profissao->nm_profissao)){
                                        $p = new ProfissaoVO();
                                        $p->nm_profissao = Servicos::converterStrtoupper($_POST['ds_outro']);
                                        $p->ao_ativo = 'V';

                                        $pDAO = new ProfissaoDAO();
                                        $idGeradoProf = $pDAO->cadastrarProfissao($p);

                                        $todas_profissoes[] = $idGeradoProf;

                                        //$cpDAO = new CandidatoProfissaoDAO();
                                        //$cpDAO->deletar($c->id_candidato);

                                        $msg = "<p>Uma nova profissão foi cadastrada pelo(a) candidato(a) $c->nm_candidato no Banco de Oportunidade e aguarda por validação.</p>
                                                <p><b>Profissão:</b> $p->nm_profissao</p>";
                                        //envia o email
                                        Email::enviarEmail('seuemail@prefeitura.com', 'Validação de Profissão', $msg, 'Moderador(a) do Sistema');
                                    }

                                }else{
                                    $cpDAO = new CandidatoProfissaoDAO();
                                    $cpDAO->deletar($c->id_candidato);
                                }

                                foreach ($todas_profissoes as $id) {

                                    //instancio um objeto VO
                                    $cp = new CandidatoProfissaoVO();
                                    $cp->id_candidatoprofissao = null;
                                    $cp->id_candidato = $c->id_candidato;
                                    $cp->id_profissao = $id;

                                    //instancio objeto DAO
                                    $cpDAO = new CandidatoProfissaoDAO();
                                    $cpDAO->cadastrarCandidatoProfissao($cp);

                                }
                                //atualiza a dt_alteracao do candidato
                                $cDAO = new CandidatoDAO();
                                $cDAO->atualizarDtAlteracao($c->id_candidato);

                                $cDAO = new CandidatoDAO();

                                //Implementação para usuários antigos para não ocultar abas e somente atualizar o que falta preencher
                                if(($c->ao_abaformacao == 'A') && ($c->ao_abaqualificacao == 'A') && ($c->ao_abaexperiencia == 'A')){
                                        $c->ao_ativo = 'A';
                                        $c->ao_abaformacao = 'A';
                                        $c->ao_abaqualificacao = 'A';
                                        $c->ao_abaexperiencia = 'A';
                                }else if(($c->ao_abaformacao == 'S') && ($c->ao_abaqualificacao == 'A') && ($c->ao_abaexperiencia == 'A')){
                                        $c->ao_ativo = 'A';
                                        $c->ao_abaformacao = 'S';
                                        $c->ao_abaqualificacao = 'A';
                                        $c->ao_abaexperiencia = 'A';
                                }else if(($c->ao_abaformacao == 'A') && ($c->ao_abaqualificacao == 'S') && ($c->ao_abaexperiencia == 'A')){
                                        $c->ao_ativo = 'A';
                                        $c->ao_abaformacao = 'A';
                                        $c->ao_abaqualificacao = 'S';
                                        $c->ao_abaexperiencia = 'A';
                                }else if(($c->ao_abaformacao == 'S') && ($c->ao_abaqualificacao == 'S') && ($c->ao_abaexperiencia == 'A')){
                                        $c->ao_ativo = 'A';
                                        $c->ao_abaformacao = 'S';
                                        $c->ao_abaqualificacao = 'S';
                                        $c->ao_abaexperiencia = 'A';
                                }else if(($c->ao_abaformacao == 'A') && ($c->ao_abaqualificacao == 'A') && ($c->ao_abaexperiencia == 'S')){
                                        $c->ao_ativo = 'A';
                                        $c->ao_abaformacao = 'A';
                                        $c->ao_abaqualificacao = 'A';
                                        $c->ao_abaexperiencia = 'S';
                                }else if(($c->ao_abaformacao == 'S') && ($c->ao_abaqualificacao == 'A') && ($c->ao_abaexperiencia == 'S')){
                                        $c->ao_ativo = 'A';
                                        $c->ao_abaformacao = 'S';
                                        $c->ao_abaqualificacao = 'A';
                                        $c->ao_abaexperiencia = 'S';
                                }else if(($c->ao_abaformacao == 'A') && ($c->ao_abaqualificacao == 'S') && ($c->ao_abaexperiencia == 'S')){
                                        $c->ao_ativo = 'A';
                                        $c->ao_abaformacao = 'A';
                                        $c->ao_abaqualificacao = 'S';
                                        $c->ao_abaexperiencia = 'S';
                                }
                                //Se não existir usuário antigo cai no else
                                else{
                                    //Novos candidatos
                                    if(($c->ao_abaformacao == 'S') && ($c->ao_abaqualificacao == 'S') && ($c->ao_abaexperiencia == 'N')){
                                        $c->ao_ativo = 'null';
                                        $c->ao_abaformacao = 'S';
                                        $c->ao_abaqualificacao = 'S';
                                        $c->ao_abaexperiencia = 'N';
                                    }else if(($c->ao_abaformacao == 'S') && ($c->ao_abaqualificacao == 'S') && ($c->ao_abaexperiencia == 'S')){
                                        //verifica se currículo está ativo ou inativo
                                        if($c->ao_ativo == 'S'){
                                            $c->ao_ativo = 'S';
                                        }else if($c->ao_ativo == 'N'){
                                            $c->ao_ativo = 'N';
                                        }else{
                                            //se o currículo não foi cadastrado por completo ainda recebe = ''
                                            $c->ao_ativo = 'null';
                                        }
                                        $c->ao_abaformacao = 'S';
                                        $c->ao_abaqualificacao = 'S';
                                        $c->ao_abaexperiencia = 'S';
                                    }else{
                                        //fluxo normal se o candidato seguir passo a passo
                                        $c->ao_ativo = 'null';
                                        $c->ao_abaformacao = 'S';
                                        $c->ao_abaqualificacao = 'N';
                                        $c->ao_abaexperiencia = 'N';
                                    }
                                }
                                $cDAO->alterarAbas($c);

                                //logo o candidato para buscar a experiencia cadastrada
                                ControleLoginCandidato::acessarSessao($c);

                                //Redireciona

                                //Caso a aba formação estiver vazia, passa para próxima aba, se não fica na de profissões.
                                if($c->ao_abaformacao == 'N'){
                                    header('location:../visao/GuiManutencaoCandidato.php#parte-02');
                                }else{
                                    header('location:../visao/GuiManutencaoCandidato.php#parte-07');
                                }


                            }else{
                                //se houver algum erro
                                //Registrar sessão o array $erros e o array $_POST
                                ControleSessao::inserirVariavel('errosPR', $errosPR);
                                ControleSessao::inserirVariavel('post', $_POST);
                                //Redireciona
                                header('location:../visao/GuiManutencaoCandidato.php#parte-07');
                            }
                        }
                        break;
                        /*******************************deletar candidato profissão****************************************/
                    case 9:
                        if(isset($_POST)){
                            //Instanciando objeto CandidatoVO
                            $c = new CandidatoVO();

                            //recebo o CandidatoVO logado da sessao
                            $c = ControleSessao::buscarObjeto('privateCand');

                             //deleto os existentes
                            $cpDAO = new CandidatoProfissaoDAO();
                            $cpDAO->deletarCandidatoProfissaoPorId($_POST['id_candidato'], $_POST['id_profissao']);

                            $cp = new CandidatoProfissaoDAO();
                            $c->profissoes = $cp->buscarCandidatoProfissoes($_POST['id_candidato']);


                            ControleSessao::inserirObjeto('privateCand',$c);
                            header('location:../visao/GuiManutencaoCandidato.php#parte-07');
                        }
                        break;

                }//fecha switch form
            }//fecha if isset do form
        break;


        /***************************************************************************************************************
         *  DESLOGAR
         **************************************************************************************************************/
        case 'deslogar':
            //derrubo o candidato/tudo da sessao
            ControleLoginCandidato::deslogar();
        break;

        /***************************************************************************************************************
         *  LOGAR
         **************************************************************************************************************/
        case 'logar':
            if(isset($_POST['login']) && isset($_POST['senha'])){

                $contErros=0;

                //valido os dados
                if(!Validacao::validarLogin($_POST['login'])) $contErros++;
                if(!Validacao::validarSenha($_POST['senha'])) $contErros++;

                if($contErros==0){
                    //instancio um CandidatoVO
                    $c = new CandidatoVO();
                    //seto o login e senha
                    $c->ds_loginportal = $_POST['login'];
                    $c->pw_senhaportal = Validacao::criptografar($_POST['senha']);

                    //logo o candidato no sistema
                    ControleLoginCandidato::logar($c);
                }else{
                    //registra a mensagem de erro
                    ControleSessao::inserirVariavel('msg', 'Login e/ou Senha incorretos');
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
                if(!Validacao::validarLogin($_POST['login'])) $erros[] = 'login';
                if(!Validacao::validarSenha($_POST['senha'])) $erros[] = 'senha';
                if(!Validacao::validarSenha($_POST['nova_senha'])) $erros[] = 'nova_senha';
                if(!Validacao::validarSenha($_POST['confirma_senha'])) $erros[] = 'confirma_senha';
                if($_POST['confirma_senha'] != $_POST['nova_senha']) $erros[] = 'senha_diferente';

                if(count($erros)==0){

                    //instancio um CandidatoVO
                    $c = new CandidatoVO();
                    //seto login e a senha atual
                    $c->ds_loginportal = $_POST['login'];
                    $c->pw_senhaportal = Validacao::criptografar($_POST['senha']);

                    //verifico se existi este candidato no banco
                    $cDAO = new CandidatoDAO();
                    $candidato = $cDAO->verificarCandidato($c);

                    if($candidato && !is_null($candidato)){

                        //seto a nova senha
                        $candidato->pw_senhaportal = Validacao::criptografar($_POST['nova_senha']);
                        //seto o ao_interno como N
                        $candidato->ao_interno = 'N';
                        //altera a senha e ao_interno na base
                        $cDAO = new CandidatoDAO();
                        $cDAO->alterarSenha($candidato);
                        //logo o candidato no sistema
                        ControleLoginCandidato::logar($candidato);

                    }else{
                        //registro a mensagem de erro
                        ControleSessao::inserirVariavel('msg', 'Login e/ou Senha incorretos');
                        //redireciono
                        header('location:../visao/GuiAlterarSenhaCandidato.php');
                    }

                }else{
                    //registro o array de erros
                    ControleSessao::inserirVariavel('erros', $erros);
                    //redireciono
                    header('location:../visao/GuiAlterarSenhaCandidato.php');
                }
            }
        break;

        /***************************************************************************************************************
         *  LEMBRAR SENHA
         **************************************************************************************************************/
        case 'lembrarSenha':
            if(isset($_POST['nr_cpf']) && isset($_POST['ds_email'])){

                //valido os dados
                $errosL = array();
                if(!Validacao::validarCpf($_POST['nr_cpf']) && !Validacao::validarMascaraCpf($_POST['nr_cpf'])) $errosL[] = 'nr_cpf';
                if(!Validacao::validarEmail($_POST['ds_email'])) $errosL[] = 'ds_email';

                if(count($errosL)==0){

                    //instancio um CandidatoVO
                    $c = new CandidatoVO();
                    //seto o cpf e o email
                    $c->nr_cpf = $_POST['nr_cpf'];
                    $c->ds_email = $_POST['ds_email'];

                    //instancio um CandidatoDAO
                    $cDAO = new CandidatoDAO();
                    //verifico se tem na base um candidato com esse cpf e email
                    $candidato = $cDAO->verificarNrCpfCandidato($c);

                    if($candidato && !is_null($candidato)){

                        //gero uma nova senha randonica
                        $pw = Validacao::gerarSenha();

                        //seto o ao_interno para obrigar o candidato alterar sua senha quando acessar o sistema
                        $candidato->ao_interno = 'S';
                        //seto a senha randonica criptografada
                        $candidato->pw_senhaportal = Validacao::criptografar($pw);

                        //instancio um CandidatoDAO
                        $cDAO = new CandidatoDAO();
                        //altero na base
                        $cDAO->alterarSenha($candidato);

                        //mensagem do email
                        $msg = "<p>
                                Você solicitou o serviço Lembre Minha Senha,
                                ao acessar sua conta será solicitado a alteração da mesma para sua segurança.
                                </p>
                                Seu login: <b>$candidato->ds_loginportal</b><br>
                                Sua nova senha: <b>$pw</b>";

                        //envia o email
                        Email::enviarEmail($candidato->ds_email, 'Lembre Minha Senha', $msg, $candidato->nm_candidato);



                        //Verifico o sexo do candidato para melhro entendimento da mensagem
                        if($candidato->ao_sexo == "M"){
                            $prezado = "Prezado";
                        }else{
                            $prezado = "Prezada";
                        }


                        $mensagemLembrarSenha = $prezado." $candidato->nm_candidato foi enviado um email para $candidato->ds_email com seu login e uma nova senha, "
                                . "verifique seu email e acesse o banco de oportunidades novamente.";

                        //registra mensagem
                        ControleSessao::inserirVariavel('msg', $prezado." $candidato->nm_candidato verifique seu email $candidato->ds_email");

                        //Mostra a mensagem de email enviado e redireciona.
                        echo "<script type='text/javascript'> alert('".$mensagemLembrarSenha."'); "
                            . "location.href='../visao/GuiLembrarSenhaCandidato.php';</script>";

                        //redireciono
                        //header('location:../visao/GuiLembrarSenhaCandidato.php');

                    }else{
                        //registro a mensagem de erro
                        ControleSessao::inserirVariavel('msg', 'CPF e/ou E-mail incorretos');
                        //redireciono
                        header('location:../visao/GuiLembrarSenhaCandidato.php');
                    }

                }else{
                    //registro o array de erros e o post
                    ControleSessao::inserirVariavel('errosL', $errosL);
                    ControleSessao::inserirVariavel('post', $_POST);
                    //redireciono
                    header('location:../visao/GuiLembrarSenhaCandidato.php');
                }

            }
        break;

        /***************************************************************************************************************
         *  BUSCAR
         **************************************************************************************************************/
        case 'buscar':
            if(isset($_POST)){

                //array de erros
                $errosC = array();

                //valido todos os dados
                if(!Validacao::validarFiltroIdCidade($_POST['filtro_codigo'])) $errosC[] = 'filtro_codigo';
                if(!Validacao::validarNacionalidade($_POST['filtro_nome'])) $errosC[] = 'filtro_nome';
                if(!Validacao::validarFiltroDeficiencia($_POST['filtro_deficiencia'])) $errosC[] = 'filtro_deficiencia';
                if(!Validacao::validarFiltroIdEstado($_POST['id_estado'])) $errosC[] = 'id_estado';
                if(!Validacao::validarFiltroIdFormacao($_POST['filtro_escolaridade'])) $errosC[] = 'filtro_escolaridade';
                if(!Validacao::validarFiltroIdCidade($_POST['id_cidade'])) $errosC[] = 'id_cidade';
                if(!Validacao::validarFiltroEstadoCivil($_POST['filtro_ec'])) $errosC[] = 'filtro_ec';
                if(!Validacao::validarFiltroFaixaEtaria($_POST['filtro_fe'])) $errosC[] = 'filtro_fe';
                if(!Validacao::validarFiltroGenero($_POST['filtro_genero'])) $errosC[] = 'filtro_genero';
                if(!Validacao::validarStatus($_POST['filtro_bolsafamilia']) && !empty($_POST['filtro_bolsafamilia'])) $errosC[] = 'filtro_bolsafamilia';
                if(!Validacao::validarFiltroIdCidade($_POST['filtro_profissao'])) $errosC[] = 'filtro_profissao';


                if(Validacao::validarVazio($_POST['filtro_codigo']) &&
                        Validacao::validarVazio($_POST['filtro_nome']) &&
                        Validacao::validarDeficienciaVazio($_POST['filtro_deficiencia']) &&
                        Validacao::validarVazio($_POST['id_estado']) &&
                        Validacao::validarVazio($_POST['filtro_escolaridade']) &&
                        Validacao::validarVazio($_POST['id_cidade']) &&
                        Validacao::validarVazio($_POST['filtro_ec']) &&
                        Validacao::validarVazio($_POST['filtro_fe']) &&
                        Validacao::validarVazio($_POST['filtro_genero']) &&
                        Validacao::validarVazio($_POST['filtro_bolsafamilia']) &&
                        Validacao::validarVazio($_POST['filtro_profissao'])) $errosC[] = 'filtro_vazio';

                //se nao tiver erros
                if(count($errosC) == 0){

                    //monta query
                    $query = '';

                    if($_POST['filtro_codigo']){
                        $query .= " and c.id_candidato = ".$_POST['filtro_codigo'];
                    }
                    if($_POST['filtro_nome']){
                        $query .= " and c.nm_candidato like '%".$_POST['filtro_nome']."%'";
                    }
                    if($_POST['id_cidade']){
                        $query .= " and c.id_cidade = ".$_POST['id_cidade'];
                    }
                    if($_POST['id_estado']){
                        $query .= " and cid.id_estado = ".$_POST['id_estado'];
                    }
                    if($_POST['filtro_fe']){
                        $idade = "(YEAR(now()) - YEAR(c.dt_nascimento) - if( DATE_FORMAT(now(), '%m%d') > DATE_FORMAT(c.dt_nascimento, '%m%d') ,0 , -1))";
                        if($_POST['filtro_fe'] == 1){
                            $query .= " and $idade between 15 and 19";
                        }else if($_POST['filtro_fe'] == 2){
                            $query .= " and $idade between 20 and 24";
                        }else if($_POST['filtro_fe'] == 3){
                            $query .= " and $idade between 25 and 29";
                        }else if($_POST['filtro_fe'] == 4){
                            $query .= " and $idade between 30 and 34";
                        }else if($_POST['filtro_fe'] == 5){
                            $query .= " and $idade between 35 and 39";
                        }else if($_POST['filtro_fe'] == 6){
                            $query .= " and $idade >= 40";
                        }
                    }
                    if($_POST['filtro_genero']){
                        $query .= " and ao_sexo = '".$_POST['filtro_genero']."'";
                    }
                    if(!empty($_POST['filtro_bolsafamilia'])){
                        $query .= " and ao_bolsafamilia = '".$_POST['filtro_bolsafamilia']."'";
                    }
                    if($_POST['filtro_deficiencia']){
                        if($_POST['filtro_deficiencia'] === 'I'){
                            //nao concatena nada na query
                        }else if($_POST['filtro_deficiencia'] === 'N'){
                            $query .= " and id_deficiencia is null";
                        }else if($_POST['filtro_deficiencia'] === 'T'){
                            $query .= " and id_deficiencia is not null";
                        }else{
                            $query .= " and id_deficiencia = ".$_POST['filtro_deficiencia'];
                        }
                    }
                    if(!empty($_POST['filtro_escolaridade'])){
                        $query .= " and cf.id_formacao = ".$_POST['filtro_escolaridade'];
                    }
                    if(!empty($_POST['filtro_profissao'])){
                        $query .= " and cp.id_profissao = ".$_POST['filtro_profissao'];
                    }
                    if(!empty($_POST['filtro_ec'])){
                        $query .= " and ds_estado_civil = '".$_POST['filtro_ec']."'";
                    }

                    //instancia um dao
                    $cDAO = new CandidatoDAO();
                    //busca os candidatos no bd
                    $candidatos = $cDAO->buscarPorFiltro($query);
                    //insiro na sessao o array de candidatos
                    ControleSessao::inserirObjeto('candidatos', $candidatos);
                    //insiro na sessao os filtros
                    ControleSessao::inserirVariavel('post', $_POST);
                    //redireciono
                    header('location:../visao/GuiCurriculos.php');

                }else{
                    //registro o array de erros e o post
                    ControleSessao::inserirVariavel('errosC', $errosC);
                    ControleSessao::inserirVariavel('post', $_POST);
                    //redireciono
                    header('location:../visao/GuiCurriculos.php');
                }
            }
        break;

        /***************************************************************************************************************
         *  BUSCAR CONTRATADO
         **************************************************************************************************************/
        case 'buscarContratado':
            if(isset($_POST)){

                //array de erros
                $errosContratado = array();

                //valido todos os dados
                if(!Validacao::validarFiltroIdCidade($_POST['filtro_codigo'])) $errosContratado[] = 'filtro_codigo';
                if(!Validacao::validarFiltroIdCidade($_POST['id_empresa'])) $errosContratado[] = 'id_empresa';
                if(!Validacao::validarNacionalidade($_POST['filtro_nome'])) $errosContratado[] = 'filtro_nome';


                if(Validacao::validarVazio($_POST['filtro_codigo']) &&
                        Validacao::validarVazio($_POST['filtro_nome'])) $errosContratado[] = 'filtro_vazio';

                //se nao tiver erros
                if(count($errosContratado) == 0){

                    //monta query
                    $query = '';

                    if($_POST['filtro_codigo']){
                        $query .= " and c.id_candidato = ".$_POST['filtro_codigo'];
                    }
                    if($_POST['filtro_nome']){
                        $filtro_nome = str_replace(" ","%", $_POST['filtro_nome']);
                        $query .= " and c.nm_candidato like '%".$filtro_nome."%'";
                    }

                    //instancia um dao
                    $cDAO = new CandidatoDAO();
                    //busca os candidatos no bd
                    $candidatosContratados = $cDAO->buscarContratado($query, $_POST['id_empresa']);

                    //insiro na sessao o array de candidatos
                    ControleSessao::inserirObjeto('candidatosContratados', $candidatosContratados);
                    //insiro na sessao os filtros
                    ControleSessao::inserirVariavel('post', $_POST);

                    //redireciono
                    header('location:../visao/GuiContratar.php');

                }else{
                    //registro o array de erros e o post
                    ControleSessao::inserirVariavel('errosContratado', $errosContratado);
                    ControleSessao::inserirVariavel('post', $_POST);
                    //redireciono
                    header('location:../visao/GuiContratar.php');
                }
            }
        break;

        /***************************************************************************************************************
         *  IMPRIMIR CURRICULO
         **************************************************************************************************************/
        case 'imprimir':
            if(isset($_POST['imprimir'])){

                //array de errros
                $errosI = 0;

                //valido cada id
                foreach ($_POST['imprimir'] as $id) {
                    if(!Validacao::validarIdCandidatoFormacao($id)) $errosI++;
                }

                //se nao houver erros
                if($errosI == 0){

                    //var_dump($_POST);//die;

                    //crio um array
                    $candidatos = array();

                    foreach ($_POST['imprimir'] as $id) {

                        //instancio um dao
                        $cDAO = new CandidatoDAO();
                        //recebo um candidato
                        $c = $cDAO->buscarPorId($id);

                        if(!is_bool($c) && !is_null($c)){
                            //instancio um dao
                            $cfDAO = new CandidatoFormacaoDAO();
                            //seto as formacoes do candidato
                            $c->formacoes = $cfDAO->buscarCandidatoFormacoes($c->id_candidato);

                            //instancio um dao
                            $cpDAO = new CandidatoProfissaoDAO();
                            //seto as profissoes do candidato
                            $c->profissoes = $cpDAO->buscarCandidatoProfissoesSimples($c->id_candidato);

                            //instancio um dao
                            $cqDAO = new CandidatoQualificacaoDAO();
                            //seto as qualificacoes do candidato
                            $c->qualificacoes = $cqDAO->buscarCandidatoQualificacoes($c->id_candidato);

                            //instancio um dao
                            $ceDAO = new CandidatoExperienciaDAO();
                            //seto as experiencias do candidato
                            $c->experiencias = $ceDAO->buscarCandidatoExperiencias($c->id_candidato);

                            //adiciono o candidato no array
                            $candidatos[] = $c;

                        }else{
                            //registra array de erros
                            ControleSessao::inserirVariavel('errosI', 'Ocorreu um erro. Tente novamente!');
                            //redireciona
                            header('location:../visao/GuiCurriculos.php');
                        }
                    }

                    Imprimir::imprimirCurriculo($candidatos);

                }else{
                    //registra array de erros
                    ControleSessao::inserirVariavel('errosI', 'Ocorreu um erro. Tente novamente!');
                    //redireciona
                    header('location:../visao/GuiCurriculos.php');
                }

            }
            else if(ControleLoginCandidato::verificarAcesso()){

                //crio um array
                $candidatos = array();
                //array recebe o candidato da sessao
                $candidatos[] = ControleSessao::buscarObjeto('privateCand');
                //gera o curriculo .pdf
                Imprimir::imprimirCurriculoCompletoCandidato($candidatos);

            }
            else{
                ControleSessao::inserirVariavel('errosI', 'Selecione pelo menos um registro para imprimir!');
                header('location:../visao/GuiCurriculos.php');
            }
        break;


        /***************************************************************************************************************
         *  UPLOAD DE FOTO
         **************************************************************************************************************/
        case 'upload':

            $erros = array();

            //testa se recebeu a imagem
            if(!empty($_FILES['foto']['name'])){

                //instancia o objeto que faz upload
                $up = new UploadVO($_FILES['foto']);
                //informa a pasta
                $up->diretorio = '../fotos';
                /* Tipos de arquivos aceitos.. para aceitar outros arquivos, pesquise sobre mime-types em: http://www.webmaster-toolkit.com/mime-types.shtml */
                $aceitos = array('image/jpeg');
                //informa as extensoes aceitas
                $up->formatos = $aceitos;




                //Verificando se houve algum erro
                if($up->erro!=0){
                    $erros[] = $up->obterErro();
                }
                if(!$up->verificarTamanho()){
                    $erros[]='Tamanho inválido';
                }
                if(!$up->verificarTipo()){
                    $erros[]='Formato de arquivo não permitido';
                }
                if(count($erros)==0){
                    //nova largura para redimensionar
                    $largura = 70;
                    //novo nome da imagem
                    $novonome = ControleSessao::buscarObjeto('privateCand')->id_candidato;
                    //redimensiona e faz upload
                    $up->upload($largura, $novonome);

                    $erros[] = 'Foto enviada com sucesso!';
                    ControleSessao::inserirVariavel('erros', $erros);
                    header('location:../visao/GuiManutencaoCandidato.php#parte-06');

                }else{
                    ControleSessao::inserirVariavel('erros', $erros);
                    header('location:../visao/GuiManutencaoCandidato.php#parte-05');
                }
            }else{
                $erros[] = 'Selecione uma imagem';
                ControleSessao::inserirVariavel('erros', $erros);
                header('location:../visao/GuiManutencaoCandidato.php#parte-05');
            }
        break;

        /***************************************************************************************************************
         *  CARREGAR CANDIDATO PARA ADMISSAO
         **************************************************************************************************************/
        case 'carregarAdmissao':
            if(isset($_POST['nr_cpf'])){

                //valido os dados
                $erros = array();
                if(!Validacao::validarCpf($_POST['nr_cpf']) && !Validacao::validarMascaraCpf($_POST['nr_cpf'])) $erros[] = 'nr_cpf';

                if(count($erros)==0){

                    $cpf = $_POST['nr_cpf'];

                    //instancio um CandidatoDAO
                    $cDAO = new CandidatoDAO();
                    //busco na base candidato com esse cpf
                    $candidato = $cDAO->buscarPorNrCpf($cpf);

                    if($candidato && !is_null($candidato)){

                        //registra mensagem
                        ControleSessao::inserirObjeto('admitido', $candidato);
                        //redireciono
                        header('location:../visao/GuiAdmissao.php');

                    }else{
                        //registro a mensagem de erro
                        $erros[] = 'msg';
                        ControleSessao::inserirVariavel('erros', $erros);
                        //redireciono
                        header('location:../visao/GuiAdmissao.php');
                    }

                }else{
                    //registro o array de erros e o post
                    ControleSessao::inserirVariavel('erros', $erros);
                    ControleSessao::inserirVariavel('post', $_POST);
                    //redireciono
                    header('location:../visao/GuiAdmissao.php');
                }
            }
            break;

        case 'curriculo':

            break;

        default:
            ControleLoginCandidato::deslogar();
        break;

    }//fecha switch do op
}//fecha if do isset get
?>
