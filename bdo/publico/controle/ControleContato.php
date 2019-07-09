<?php
include_once '../util/ControleSessao.class.php';
ControleSessao::abrirSessao();

include_once '../modelo/ContatoVO.class.php';
include_once '../persistencia/ContatoDAO.class.php';

include_once '../util/Validacao.class.php';
include_once '../util/Email.class.php';
include_once '../util/Servicos.class.php';

if(isset($_GET['op'])){
    switch ($_GET['op']) {
        case 'enviar':
            if(isset($_POST)){

                $erros = array();

                if(!Validacao::validarNome($_POST['nm_contato'])) $erros[] = 'nm_contato';
                if(!Validacao::validarEmail($_POST['ds_email'])) $erros[] = 'ds_email';
                if(!Validacao::validarTelefoneNaoObg($_POST['nr_telefone'])) $erros[] = 'nr_telefone';
                if(!Validacao::validarAssunto($_POST['ds_assunto'])) $erros[] = 'ds_assunto';
                if($_POST['ds_assunto'] == 'Esqueci Minha Senha'){
                    if(!Validacao::validarMascaraCpf($_POST['nr_cpf']) && !Validacao::validarCpf($_POST['nr_cpf'])) $erros[] = 'nr_cpf';
                }
                if(!Validacao::validarMensagemContato($_POST['ds_mensagem']) || empty($_POST['ds_mensagem'])) $erros[] = 'ds_mensagem';

                if(count($erros)==0){

                    $c = new ContatoVO();
                    $c->id_contato = 'null';
                    $c->nm_contato = Servicos::converterStrtoupper($_POST['nm_contato']);
                    $c->ds_email = Servicos::converterStrtoupper($_POST['ds_email']);
                    $c->nr_telefone = $_POST['nr_telefone'];
                    $c->ds_assunto = Servicos::converterStrtoupper($_POST['ds_assunto']);
                    $c->nr_cpf = $_POST['nr_cpf'];
                    $c->ds_mensagem = Servicos::converterStrtoupper($_POST['ds_mensagem']);
                    $c->dt_cadastro = 'now()';

                    $cDAO = new ContatoDao();
                    $idGerado = $cDAO->cadastrarContato($c);

                    if(is_numeric($idGerado)){
                        $c->id_contato = $idGerado;

                        $msg = 'Mensagem enviada comsucesso!';

                        //email do moderador
                        $destino = 'seuemail@prefeitura.com';
                        $nomeDestino = 'Moderador do Sistema';
                        //assunto do email
                        $assunto = "Fale Conosco - $c->ds_assunto";
                        //mensagem do email
                        $corpo = $c;
                        Email::enviarEmail($destino, $assunto, $corpo, $nomeDestino);

                    }else{
                        $msg = 'Ocorreu um erro. Tente novamente!';
                        ControleSessao::inserirVariavel('post', $_POST);
                    }
                    ControleSessao::inserirVariavel('msg', $msg);
                    //redireciona
                    header('location:../visao/GuiContato.php');

                }else{
                    //registra o array de erros e o post
                    ControleSessao::inserirVariavel('erros', $erros);
                    ControleSessao::inserirVariavel('post', $_POST);
                    //redireciona
                    header('location:../visao/GuiContato.php');
                }

            }
            break;

        default:
            ControleSessao::destruirSessao();
            header('location:../../index.php');
            break;
    }
}
?>
