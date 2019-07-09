<?php
include_once '../util/ControleSessao.class.php';
include_once '../util/ControleLoginCandidato.class.php';
ControleSessao::abrirSessao();

//verifico se ha candidato na sessao
if(!ControleLoginCandidato::verificarAcesso()){
    //se nao tiver candidato na sessao
    ControleLoginCandidato::deslogar();
}
include_once 'header.php';
include_once '../util/Servicos.class.php';
include_once '../util/Validacao.class.php';

include_once '../modelo/CandidatoVO.class.php';
include_once '../modelo/CandidatoFormacaoVO.class.php';
include_once '../modelo/CandidatoQualificacaoVO.class.php';
include_once '../modelo/CandidatoExperienciaVO.class.php';
include_once '../modelo/CandidatoProfissaoVO.class.php';


include_once '../modelo/CidadeVO.class.php';
include_once '../modelo/EstadoVO.class.php';

?>

<div id="conteudo">
    <!--<img id="cabecalho-logo" alt="Bras�o da Prefeitura" src="../imagens/Orange wave.png">-->
    <div class="subtitulo">Banco de Oportunidades</div>

        <?php

            $verificaSessao = ControleSessao::buscarObjeto('privateCand');

            $parte2 = "<li><a href='#parte-02'><span>Dados Escolares</span></a></li>";
            $parte3 = "<li><a href='#parte-03'><span>Dados de Qualifica��es</span></a></li>";
            $parte4 = "<li><a href='#parte-04'><span>Experi�ncias Anteriores</span></a></li>";
            $parte5 = "<li><a href='#parte-05'><span>Adicionar Foto</span></a></li>";
            $parte6 = "<li><a href='#parte-06'><span>Imprimir Curr�culo</span></a></li>";
            $mensagem = "<br /><br /><span style='font-size:12px;'>Complete todos os passos para que as empresas possam visualizar seu curr�culo.</span>";

            $dadosEscolares = "";
            $dadosQualificacoes = "";
            $experienciaAnteriores = "";
            $adicionarFoto = "";
            $imprimirCurriculo = "";

            $mensagemPassos = $mensagem;

            $passo2ativo = "<img src='../../../Utilidades/Imagens/bancodeoportunidades/passo2_ativo.png' width='8%' title='Dados Escolares'>";
            $passo2inativo = "<img src='../../../Utilidades/Imagens/bancodeoportunidades/passo2_inativo.png' width='8%' title='Dados escolares n�o preenchidos'>";
            $passo3ativo = "<img src='../../../Utilidades/Imagens/bancodeoportunidades/passo3_ativo.png' width='8%' title='Dados de Qualifica��es'>";
            $passo3inativo = "<img src='../../../Utilidades/Imagens/bancodeoportunidades/passo3_inativo.png' width='8%' title='Dados de qualifica��es n�o preenchidas'>";
            $passo4ativo = "<img src='../../../Utilidades/Imagens/bancodeoportunidades/passo4_ativo.png' width='8%' title='Experi�ncias Anteriores'>";
            $passo4inativo = "<img src='../../../Utilidades/Imagens/bancodeoportunidades/passo4_inativo.png' width='8%' title='Experi�ncias anteriores n�o preenchidas'>";
            $tracoAtivo = "<img src='../../../Utilidades/Imagens/bancodeoportunidades/trajeto_ativo.png' width='8%' style='margin-bottom: 36px;'>";
            $tracoInativo = "<img src='../../../Utilidades/Imagens/bancodeoportunidades/trajeto_inativo.png' width='8%' style='margin-bottom: 36px;'>";
            $tracoInativoVermelho = "<img src='../../../Utilidades/Imagens/bancodeoportunidades/trajeto_degrade.png' width='8%' style='margin-bottom: 36px;'>";
            $curriculo_ativo = "<img src='../../../Utilidades/Imagens/bancodeoportunidades/curriculo_ativo.png' width='8%' title='Curr�culo Ativo'>";
            $curriculo_inativo = "<img src='../../../Utilidades/Imagens/bancodeoportunidades/curriculo_inativo.png' width='8%' title='Curr�culo Inativo'>";
            $curriculo_inativo_vermelho = "<img src='../../../Utilidades/Imagens/bancodeoportunidades/curriculo_inativo_vermelho.png' width='8%' title='Curr�culo Inativo'>";

            $passo1 = "<img src='../../../Utilidades/Imagens/bancodeoportunidades/passo1_ativo.png' width='8%' class='exibir_seta' title='Profiss�o'>";
            $passo2 = $passo2inativo;
            $passo3 = $passo3inativo;
            $passo4 = $passo4inativo;
            $ativo_inativo = $curriculo_inativo;
            $traco1e2 = $tracoInativo;
            $traco2e3 = $tracoInativo;
            $traco3e4 = $tracoInativo;
            $traco4e5 = $tracoInativo;

            //Obs.: Usu�rios antigos antes desta implementa��o recebem = 'A' no banco

            //Profiss�o salva mostra o a forma��o
            if(($verificaSessao->ao_abaformacao == 'S') || ($verificaSessao->ao_abaformacao == 'A')){
                $dadosEscolares = $parte2;
                if($verificaSessao->ao_abaformacao == 'S'){
                    $passo2 = $passo2ativo;
                    $traco1e2 = $tracoAtivo;
                }
            }

            //Forma��o salva mostra a Qualifica��o
            if(($verificaSessao->ao_abaqualificacao == 'S') || ($verificaSessao->ao_abaqualificacao == 'A')){
                $dadosQualificacoes = $parte3;
                if($verificaSessao->ao_abaqualificacao == 'S'){
                    $passo3 = $passo3ativo;
                    $traco2e3 = $tracoAtivo;
                }
            }

            //Qualifica��o salva mostra a experi�ncia
            if(($verificaSessao->ao_abaexperiencia == 'S') || ($verificaSessao->ao_abaexperiencia == 'A')){
                $experienciaAnteriores = $parte4;
                if($verificaSessao->ao_abaexperiencia == 'S'){
                    $passo4 = $passo4ativo;
                    $traco3e4 = $tracoAtivo;
                }
            }

            //Finaliza o cadastro e ativa o Curr�culo
            if(($verificaSessao->ao_abaexperiencia == 'S') && ($verificaSessao->ao_ativo == 'S')){
                $adicionarFoto = $parte5;
                $imprimirCurriculo = $parte6;
                $ativo_inativo = $curriculo_ativo;
                $traco4e5 = $tracoAtivo;
                $mensagemPassos = "<br /><br /><span style='font-size:12px;'>Parab�ns, agora seu curr�culo est� completo e as empresas poder�o visualiz�-lo. <b>Boa Sorte!</b></span>";
            }

            if((($verificaSessao->ao_abaexperiencia == 'S') && ($verificaSessao->ao_ativo == 'N'))
                ||
                    (($verificaSessao->ao_abaexperiencia == 'A') && ($verificaSessao->ao_ativo == 'A'))
                ||
                    (($verificaSessao->ao_abaexperiencia == 'S') && ($verificaSessao->ao_ativo == 'A'))
                ||
                    (($verificaSessao->ao_abaexperiencia == 'A') && ($verificaSessao->ao_ativo == 'N'))
                ){
                $adicionarFoto = $parte5;
                $imprimirCurriculo = $parte6;
                $ativo_inativo = $curriculo_inativo_vermelho;
                $traco4e5 = $tracoInativoVermelho;
                if(($verificaSessao->ao_abaexperiencia == 'S') && ($verificaSessao->ao_ativo == 'N')){
                    $mensagemPassos = "<br /><br /><span style='font-size:12px;'>Seu curr�culo est� <b>inativo</b>, as empresas n�o poder�o visualiz�-lo. Ative-o na aba <b>dados pessoais</b>!</span>";
                }
            }
        ?>
        <br />
        <div align="center">
            <h2 class="subtitulo_index" style="margin-bottom: -58px; margin-right: 825px;">Passo:</h2>
            <?php
                echo $passo1;
                    echo $traco1e2;
                echo $passo2;
                    echo $traco2e3;
                echo $passo3;
                    echo $traco3e4;
                echo $passo4;
                    echo $traco4e5;
                echo $ativo_inativo;
            ?>
        </div>

        <?php

            $corCinza = "#828282;";

            $colorDadosEscolares = "";
            $colorQualificacoes = "";
            $colorExperiencias = "";
            $colorAtivo = "";

            //Troca as cores das letras entre laranja == "ativo" e cinza ou vermelho == "inativo"
            if(($verificaSessao->ao_abaformacao == 'N') || ($verificaSessao->ao_abaformacao == 'A')){
                $colorDadosEscolares = $corCinza;
            }
            if(($verificaSessao->ao_abaqualificacao == 'N') || ($verificaSessao->ao_abaqualificacao == 'A')){
                $colorQualificacoes = $corCinza;
            }
            if(($verificaSessao->ao_abaexperiencia == 'N') || ($verificaSessao->ao_abaexperiencia == 'A')){
                $colorExperiencias = $corCinza;
            }
            if($verificaSessao->ao_ativo == 'S'){
                $palavraAtivoInativo = "Ativo";
                $px = "98;";
            }else if(($verificaSessao->ao_ativo == 'N') || ($verificaSessao->ao_ativo == 'A')){
                $palavraAtivoInativo = "Inativo";
                $px = "94;";
                $colorAtivo = "#FF0000;";
            }else{
                $palavraAtivoInativo = "Inativo";
                $px = "94;";
                $colorAtivo = $corCinza;
            }
        ?>
        <span class="subtitulo_index" style="font-size: 13px; margin-left: 149px;">Profiss�o</span>
        <span class="subtitulo_index" style="font-size: 13px; margin-left: 78px; color: <?php echo $colorDadosEscolares; ?>">Dados Escolares</span>
        <span class="subtitulo_index" style="font-size: 13px; margin-left: 67px; color: <?php echo $colorQualificacoes; ?>">Qualifica��es</span>
        <span class="subtitulo_index" style="font-size: 13px; margin-left: 76px; color: <?php echo $colorExperiencias; ?>">Experi�ncias</span>
        <span class="subtitulo_index" style="font-size: 13px; margin-left: <?php echo $px; ?> color: <?php echo $colorAtivo; ?>"><?php echo $palavraAtivoInativo; ?></span>

        <!-- Mostra a mensagem dos passos -->
        <div style="text-align: center;"><?php echo $mensagemPassos; ?></div>
        <br /><br />

        <div id="principal">
            <ul>
                <li><a href="#parte-01"><span>Dados Pessoais</span></a></li>

                <li><a href="#parte-07"><span>Cargos Pretendidos</span></a></li>

                <?php

                    echo $dadosEscolares;

                    echo $dadosQualificacoes;

                    echo $experienciaAnteriores;

                    echo $adicionarFoto;

                    echo $imprimirCurriculo;
                ?>

            </ul>

            <!-- DADOS PESSOAIS -->
            <div id="parte-01">
                <fieldset>
                    <form name="formDadosPessoais" id="formDadosPessoais" method="post" action="../controle/ControleCandidato.php?op=manutencao&form=1">
                        <legend class="legend">Dados Pessoais</legend>
                        <table class="tabela">
                            <tr>
                                <td width="8"><span class="style1">*</span></td>
                                <td>Nome:</td>
                                <td width="546">
                                    <input name="nm_candidato" id="nome_cand" value="<?php if(isset($_SESSION['errosP'])){ echo $_SESSION['post']['nm_candidato'];} elseif(isset($_SESSION['privateCand'])){ echo ControleSessao::buscarObjeto('privateCand')->nm_candidato;} ?>" <?php echo (isset($_SESSION['errosP']) && in_array('nm_candidato',$_SESSION['errosP'])) ? 'class="campo_erro"' : 'class="campo"'; ?> type="text"  size="71" maxlength="60" />
                                    <?php echo Servicos::verificarErro('errosP', 'nm_candidato'); ?>
                                </td>
                            </tr>

                            <tr>
                                <td><span class="style1">*</span></td>
                                <td>CPF:</td>
                                <td>
                                    <input readonly="" name="nr_cpf" id="nr_cpf" value="<?php if(isset($_SESSION['errosP'])){ echo $_SESSION['post']['nr_cpf'];} elseif(isset($_SESSION['privateCand'])){ echo ControleSessao::buscarObjeto('privateCand')->nr_cpf;} ?>" onblur="validarCPF(this.value);" onkeypress='return valCPF(event,this);' <?php echo (isset($_SESSION['errosP']) && in_array('nr_cpf',$_SESSION['errosP'])) ? 'class="campo_erro"' : 'class="campo"'; ?> type="text"  size="20" maxlength="11" />
                                    <?php echo Servicos::verificarErro('errosP', 'nr_cpf'); ?>
                                </td>
                            </tr>

                            <tr>
                                <td><span class="style1"></span></td>
                                <td>RG:</td>
                                <td>
                                    <input name="nr_rg" id="nr_rg" value="<?php if(isset($_SESSION['errosP'])){ echo $_SESSION['post']['nr_rg'];} elseif(isset($_SESSION['privateCand'])){ echo ControleSessao::buscarObjeto('privateCand')->nr_rg;} ?>" <?php echo (isset($_SESSION['errosP']) && in_array('nr_rg',$_SESSION['errosP'])) ? 'class="campo_erro"' : 'class="campo"'; ?> type="text"  size="20" maxlength="10" />
                                    <?php echo Servicos::verificarErro('errosP', 'nr_rg'); ?>
                                </td>
                            </tr>

                            <tr>
                                <td><span class="style1"></span></td>
                                <td>CTPS N�:</td>
                                <td>
                                    <input name="nr_ctps" id="nr_ctps" value="<?php if(isset($_SESSION['errosP'])){ echo $_SESSION['post']['nr_ctps'];} elseif(isset($_SESSION['privateCand'])){ echo ControleSessao::buscarObjeto('privateCand')->nr_ctps;} ?>" onkeypress="return valida_numero(event);" <?php echo (isset($_SESSION['errosP']) && in_array('nr_ctps',$_SESSION['errosP'])) ? 'class="campo_erro"' : 'class="campo"'; ?> type="text"  size="20" maxlength="10" />
                                    &nbsp;&nbsp;
                                    <span class="style1"></span>&nbsp;S�rie N�:
                                    <input name="nr_serie" id="nr_serie" value="<?php if(isset($_SESSION['errosP'])){ echo $_SESSION['post']['nr_serie'];} elseif(isset($_SESSION['privateCand'])){ echo ControleSessao::buscarObjeto('privateCand')->nr_serie;} ?>" <?php echo (isset($_SESSION['errosP']) && in_array('nr_serie',$_SESSION['errosP'])) ? 'class="campo_erro"' : 'class="campo"'; ?> type="text"  size="7" maxlength="5" />
                                    &nbsp;
                                    <span class="style1"></span>&nbsp;UF:
                                    <select name="id_estadoctps" id="id_estadoctps" <?php echo (isset($_SESSION['errosP']) && in_array('id_estadoctps',$_SESSION['errosP'])) ? 'class="campo_erro"' : 'class="campo"'; ?>>
                                        <option value="" selected>----</option>
                                        <?php
                                        $estadosSg = array();
                                        $estadosSg = Servicos::buscarEstadosPorSg();
                                        foreach ($estadosSg as $e) {
                                        ?>
                                            <option value="<?php echo $e->id_estado; ?>" <?php if((isset($_SESSION['errosP']) && $_SESSION['post']['id_estadoctps'] == $e->id_estado)||(isset($_SESSION['privateCand']) && ControleSessao::buscarObjeto('privateCand')->id_estadoctps == $e->id_estado)){ echo 'selected';} ?>><?php echo $e->sg_estado; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td><span class="style1"></span></td>
                                <td>PIS/PASEP:</td>
                                <td>
                                    <input name="nr_pis" id="nr_pis" value="<?php if(isset($_SESSION['errosP'])){ echo $_SESSION['post']['nr_pis'];} elseif(isset($_SESSION['privateCand'])){ echo ControleSessao::buscarObjeto('privateCand')->nr_pis;} ?>" onkeypress="return valida_numero(event);" <?php echo (isset($_SESSION['errosP']) && in_array('nr_pis',$_SESSION['errosP'])) ? 'class="campo_erro"' : 'class="campo"'; ?> type="text"  size="20" maxlength="50" />
                                </td>
                            </tr>

                            <tr>
                                <td><span class="style1"></span></td>
                                <td>CNH:</td>
                                <td>
                                    <select name="ds_cnh" id="ds_cnh" class="campo"  >
                                        <option value="">Selecione</option>
                                        <option value="ACC" <?php if (($_SESSION['post']['ds_cnh'] == 'ACC')||(isset($_SESSION['privateCand']) && ControleSessao::buscarObjeto('privateCand')->ds_cnh == 'ACC')) echo "selected" ?>>ACC</option>
                                        <option value="A" <?php if (($_SESSION['post']['ds_cnh'] == 'A')||(isset($_SESSION['privateCand']) && ControleSessao::buscarObjeto('privateCand')->ds_cnh == 'A')) echo "selected" ?>>A</option>
                                        <option value="B" <?php if (($_SESSION['post']['ds_cnh'] == 'B')||(isset($_SESSION['privateCand']) && ControleSessao::buscarObjeto('privateCand')->ds_cnh == 'B')) echo "selected" ?>>B</option>
                                        <option value="C" <?php if (($_SESSION['post']['ds_cnh'] == 'C')||(isset($_SESSION['privateCand']) && ControleSessao::buscarObjeto('privateCand')->ds_cnh == 'C')) echo "selected" ?>>C</option>
                                        <option value="D" <?php if (($_SESSION['post']['ds_cnh'] == 'D')||(isset($_SESSION['privateCand']) && ControleSessao::buscarObjeto('privateCand')->ds_cnh == 'D')) echo "selected" ?>>D</option>
                                        <option value="E" <?php if (($_SESSION['post']['ds_cnh'] == 'E')||(isset($_SESSION['privateCand']) && ControleSessao::buscarObjeto('privateCand')->ds_cnh == 'E')) echo "selected" ?>>E</option>
                                        <option value="AB" <?php if (($_SESSION['post']['ds_cnh'] == 'AB')||(isset($_SESSION['privateCand']) && ControleSessao::buscarObjeto('privateCand')->ds_cnh == 'AB')) echo "selected" ?>>AB</option>
                                        <option value="AC" <?php if (($_SESSION['post']['ds_cnh'] == 'AC')||(isset($_SESSION['privateCand']) && ControleSessao::buscarObjeto('privateCand')->ds_cnh == 'AC')) echo "selected" ?>>AC</option>
                                        <option value="AD" <?php if (($_SESSION['post']['ds_cnh'] == 'AD')||(isset($_SESSION['privateCand']) && ControleSessao::buscarObjeto('privateCand')->ds_cnh == 'AD')) echo "selected" ?>>AD</option>
                                        <option value="AE" <?php if (($_SESSION['post']['ds_cnh'] == 'AE')||(isset($_SESSION['privateCand']) && ControleSessao::buscarObjeto('privateCand')->ds_cnh == 'AE')) echo "selected" ?>>AE</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                 <td><span class="style1">*</span></td>
                                <td>Email:</td>
                                <td>
                                    <input name="ds_email"  id="ds_email" value="<?php if(isset($_SESSION['errosP'])){ echo $_SESSION['post']['ds_email'];} elseif(isset($_SESSION['privateCand'])){ echo ControleSessao::buscarObjeto('privateCand')->ds_email;} ?>" <?php echo (isset($_SESSION['errosP']) && in_array('ds_email',$_SESSION['errosP'])) ? 'class="campo_erro"' : 'class="campo"'; ?> type="text"  size="71" maxlength="60" />
                                    <?php echo Servicos::verificarErro('errosP', 'ds_email'); ?>
                                </td>
                            </tr>

                            <tr>
                                <td><span class="style1"></span></td>
                                <td>Telefone:</td>
                                <td>
                                    <input name="nr_telefone" id="nr_telefone" value="<?php if(isset($_SESSION['errosP'])){ echo $_SESSION['post']['nr_telefone'];} elseif(isset($_SESSION['privateCand'])){ echo ControleSessao::buscarObjeto('privateCand')->nr_telefone;} ?>" <?php echo (isset($_SESSION['errosP']) && in_array('nr_telefone',$_SESSION['errosP'])) ? 'class="campo_erro"' : 'class="campo"'; ?> onkeypress="return valida_numero(event);" type="text" maxlength="14" />
                                    <?php echo Servicos::verificarErro('errosP', 'nr_telefone'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="style1"></span></td>
                                <td>Celular:</td>
                                <td>
                                    <input name="nr_celular" id="nr_celular" value="<?php if(isset($_SESSION['errosP'])){ echo $_SESSION['post']['nr_celular'];} elseif(isset($_SESSION['privateCand'])){ echo ControleSessao::buscarObjeto('privateCand')->nr_celular;} ?>" <?php echo (isset($_SESSION['errosP']) && in_array('nr_celular',$_SESSION['errosP'])) ? 'class="campo_erro"' : 'class="campo"'; ?> onkeypress="return valida_numero(event);" type="text" maxlength="14" />
                                    <?php echo Servicos::verificarErro('errosP', 'nr_celular'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="style1"></span></td>
                                <td>Estado Civil:</td>
                                <td>
                                    <select name="ds_estado_civil" id="ds_estado_civil" <?php echo (isset($_SESSION['errosP']) && in_array('ds_estado_civil',$_SESSION['errosP'])) ? 'class="campo_erro"' : 'class="campo"'; ?>  >
                                        <option value="" selected>Selecione</option>
                                        <option value="S" <?php if((isset($_SESSION['errosP']) && $_SESSION['post']['ds_estado_civil'] == 'S')||(isset($_SESSION['privateCand']) && ControleSessao::buscarObjeto('privateCand')->ds_estado_civil == 'S')) echo 'selected'; ?>>Solteiro</option>
                                        <option value="C" <?php if((isset($_SESSION['errosP']) && $_SESSION['post']['ds_estado_civil'] == 'C')||(isset($_SESSION['privateCand']) && ControleSessao::buscarObjeto('privateCand')->ds_estado_civil == 'C')) echo 'selected'; ?>>Casado</option>
                                        <option value="V" <?php if((isset($_SESSION['errosP']) && $_SESSION['post']['ds_estado_civil'] == 'V')||(isset($_SESSION['privateCand']) && ControleSessao::buscarObjeto('privateCand')->ds_estado_civil == 'V')) echo 'selected'; ?>>Vi�vo</option>
                                        <option value="D" <?php if((isset($_SESSION['errosP']) && $_SESSION['post']['ds_estado_civil'] == 'D')||(isset($_SESSION['privateCand']) && ControleSessao::buscarObjeto('privateCand')->ds_estado_civil == 'D')) echo 'selected'; ?>>Divorciado</option>
                                        <option value="P" <?php if((isset($_SESSION['errosP']) && $_SESSION['post']['ds_estado_civil'] == 'P')||(isset($_SESSION['privateCand']) && ControleSessao::buscarObjeto('privateCand')->ds_estado_civil == 'P')) echo 'selected'; ?>>Separado</option>
                                        <option value="O" <?php if((isset($_SESSION['errosP']) && $_SESSION['post']['ds_estado_civil'] == 'O')||(isset($_SESSION['privateCand']) && ControleSessao::buscarObjeto('privateCand')->ds_estado_civil == 'O')) echo 'selected'; ?>>Outros</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="style1">*</span></td>
                                <td>Nascimento:</td>
                                <td>
                                    <input placeholder="DD/MM/AAAA" type="text" name="dt_nascimento" id="dt_nascimento" value="<?php if(isset($_SESSION['errosP'])){ echo $_SESSION['post']['dt_nascimento'];} elseif(isset($_SESSION['privateCand'])){ echo Validacao::explodirDataMySql(ControleSessao::buscarObjeto('privateCand')->dt_nascimento);} ?>" onkeypress="return valida_numero(event);" onkeydown="formata_data(this, event);" <?php echo (isset($_SESSION['errosP']) && in_array('dt_nascimento',$_SESSION['errosP'])) ? 'class="campo_erro data"' : 'class="campo data"'; ?> size="11" maxlength="10"/>
                                    <?php if(isset($_SESSION['errosP']) && in_array('dt_nascimento',$_SESSION['errosP'])){ ?>
                                        <span class="style1">* Preencha corretamente este campo</span>
                                    <?php }else if(isset($_SESSION['errosP']) && in_array('menor_idade',$_SESSION['errosP'])){ ?>
                                        <span class="style1">* Voc� deve ter no m�nimo 16 anos.</span>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="style1"></span></td>
                                <td>G�nero:</td>
                                <td>
                                    <input name="ao_sexo" id="ao_sexo" type="radio" value="M" checked />Masculino
                                    <input name="ao_sexo" id="ao_sexo" type="radio" value="F" <?php if((isset($_SESSION['errosP']) && $_SESSION['post']['ao_sexo'] == 'F')||(isset($_SESSION['privateCand']) && ControleSessao::buscarObjeto('privateCand')->ao_sexo == 'F')) echo 'checked'; ?> />Feminino
                                    <?php echo Servicos::verificarErro('errosP', 'ao_sexo'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="style1"></span></td>
                                <td>Cep:</td>
                                <td>
                                    <input value="<?php if(isset($_SESSION['errosP'])){ echo $_SESSION['post']['nr_cep'];} elseif(isset($_SESSION['privateCand'])){ echo ControleSessao::buscarObjeto('privateCand')->nr_cep;} ?>" type="text" name="nr_cep" id="nr_cep" maxlength='9' onBlur="ValidaCep(this.value)" onkeypress="return BloqueiaLetras(this.value);" <?php echo (isset($_SESSION['errosP']) && in_array('nr_cep',$_SESSION['errosP'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                    <?php echo Servicos::verificarErro('errosP', 'nr_cep'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="style1"></span></td>
                                <td>Logradouro:</td>
                                <td>
                                    <input name="ds_logradouro" id="ds_logradouro" value="<?php if(isset($_SESSION['errosP'])){ echo $_SESSION['post']['ds_logradouro'];} elseif(isset($_SESSION['privateCand'])){ echo ControleSessao::buscarObjeto('privateCand')->ds_logradouro;} ?>" <?php echo (isset($_SESSION['errosP']) && in_array('ds_logradouro',$_SESSION['errosP'])) ? 'class="campo_erro"' : 'class="campo"'; ?> type="text"  size="70" maxlength="70" />
                                    <?php echo Servicos::verificarErro('errosP', 'ds_logradouro'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="style1"></span></td>
                                <td>N�:</td>
                                <td>
                                    <input name="nr_logradouro" id="nr_logradouro" value="<?php if(isset($_SESSION['errosP'])){ echo $_SESSION['post']['nr_logradouro'];} elseif(isset($_SESSION['privateCand'])){ echo ControleSessao::buscarObjeto('privateCand')->nr_logradouro;} ?>" onkeypress="return valida_numero(event);" <?php echo (isset($_SESSION['errosP']) && in_array('nr_logradouro',$_SESSION['errosP'])) ? 'class="campo_erro"' : 'class="campo"'; ?> type="text"  size="10" maxlength="8" />
                                    <?php echo Servicos::verificarErro('errosP', 'nr_logradouro'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>Complemento:</td>
                                <td>
                                    <input name="ds_complemento" id="ds_complemento" value="<?php if(isset($_SESSION['errosP'])){ echo $_SESSION['post']['ds_complemento'];} elseif(isset($_SESSION['privateCand'])){ echo ControleSessao::buscarObjeto('privateCand')->ds_complemento;} ?>" <?php echo (isset($_SESSION['errosP']) && in_array('ds_complemento',$_SESSION['errosP'])) ? 'class="campo_erro"' : 'class="campo"'; ?> type="text"  size="70" maxlength="70" />
                                    <?php echo Servicos::verificarErro('errosP', 'ds_complemento'); ?>
                                </td>
                            </tr>

                            <tr>
                                <td><span class="style1"></span></td>
                                <td>Estado:</td>
                                <td>
                                    <select name="id_estado" id="id_estado" <?php echo (isset($_SESSION['errosP']) && in_array('id_estado',$_SESSION['errosP'])) ? 'class="campo_erro select"' : 'class="campo select"'; ?>>
                                        <option value="" selected>Selecione</option>
                                        <?php
                                        $estadosNm = array();
                                        $estadosNm = Servicos::buscarEstadosPorNm();

                                        foreach ($estadosNm as $e) {
                                        ?>
                                        <option value="<?php echo $e->id_estado; ?>"<?php if((isset($_SESSION['errosP']) && $_SESSION['post']['id_estado'] == $e->id_estado)){
                                                echo 'selected';
                                            }else{
                                                if(is_numeric((ControleSessao::buscarObjeto('privateCand')->id_cidade))){
                                                    if(Servicos::buscarIdEstado(ControleSessao::buscarObjeto('privateCand')->id_cidade) == $e->id_estado){
                                                        echo 'selected';
                                                    }
                                                }
                                            }
                                            ?>><?php echo $e->nm_estado; ?></option>
                                        <?php
                                        }
                                        ?>
                                        <?php echo Servicos::verificarErro('errosP', 'id_estado'); ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td><span class="style1"></span></td>
                                <td>Cidade:</td>
                                <td>
                                    <select name="id_cidade" id="id_cidade" <?php echo (isset($_SESSION['errosP']) && in_array('id_cidade',$_SESSION['errosP'])) ? 'class="campo_erro select"' : 'class="campo select"'; ?>>
                                        <option value="" selected>Selecione</option>
                                        <?php
                                        if(isset($_SESSION['errosP']) && isset($_SESSION['post']) && !empty($_SESSION['post']['id_estado'])){


                                            $cidades = array();
                                            $cidades = Servicos::buscarCidadesPorIdEstado($_SESSION['post']['id_estado']);
                                            foreach ($cidades as $c) {
                                        ?>
                                        <option value="<?php echo $c->id_cidade;?>" <?php if(isset($_SESSION['errosP']) && $_SESSION['post']['id_cidade'] == $c->id_cidade) echo ''; ?>><?php echo $c->nm_cidade; ?></option>
                                        <?php
                                            }

                                        }else if(ControleLoginCandidato::verificarAcesso()){

                                            if(is_numeric((ControleSessao::buscarObjeto('privateCand')->id_cidade))){
                                                $cidades = Servicos::buscarCidadesPorIdCidade(ControleSessao::buscarObjeto('privateCand')->id_cidade);
                                            }else if(is_numeric((ControleSessao::buscarObjeto('privateCand')->id_estado))){
                                                $cidades = Servicos::buscarCidadesPorIdEstado(ControleSessao::buscarObjeto('privateCand')->id_estado);
                                            }else{
                                                $cidades = array();
                                            }

                                            foreach ($cidades as $c) {
                                        ?>
                                        <option  value="<?php echo $c->id_cidade;?>" <?php if(ControleSessao::buscarObjeto('privateCand')->id_cidade == $c->id_cidade){echo 'selected';} ?>><?php echo $c->nm_cidade; ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                        <?php echo Servicos::verificarErro('errosP', 'id_cidade'); ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td><span class="style1"></span></td>
                                <td>Bairro:</td>
                                <td>
                                    <select <?php if(ControleSessao::buscarObjeto('privateCand')->id_bairro == null) { echo 'style="display:none"'; } else {echo 'style="display:block"';}?> name="id_bairro" id="id_bairro" <?php echo (isset($_SESSION['errosP']) && in_array('id_bairro',$_SESSION['errosP'])) ? 'class="campo_erro select"' : 'class="campo select"'; ?>>

                                        <option value="" selected>Selecione</option>
                                        <?php
                                        if(isset($_SESSION['errosP']) && isset($_SESSION['post']) && !empty($_SESSION['post']['id_cidade'])){


                                            $bairros = array();
                                            $bairros = Servicos::buscarBairrosPorIdCidade($_SESSION['post']['id_cidade']);
                                            foreach ($bairros as $b) {
                                        ?>
                                        <option value="<?php echo $b->id_bairro;?>" <?php if(isset($_SESSION['errosP']) && $_SESSION['post']['id_bairro'] == $b->id_bairro) echo 'selected'; ?>><?php echo $b->nm_bairro; ?></option>
                                        <?php
                                            }

                                        }else if(ControleLoginCandidato::verificarAcesso()){

                                           /* if(is_numeric((ControleSessao::buscarObjeto('privateCand')->id_bairro))){
                                                $bairros = Servicos::buscarBairrosPorIdBairro(ControleSessao::buscarObjeto('privateCand')->id_bairro);
                                            }else */
                                            if(is_numeric((ControleSessao::buscarObjeto('privateCand')->id_cidade))){
                                                $bairros = Servicos::buscarBairrosPorIdCidade(ControleSessao::buscarObjeto('privateCand')->id_cidade);
                                            }else{
                                                $bairros = array();
                                            }

                                            foreach ($bairros as $b) {
                                        ?>
                                        <option value="<? echo $b->id_bairro; ?>" <?php if(ControleSessao::buscarObjeto('privateCand')->id_bairro == $b->id_bairro){echo 'selected';} ?>><?php echo $b->nm_bairro; ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                        <?php echo Servicos::verificarErro('errosP', 'id_bairro'); ?>
                                    </select>

                                    <input <?php if(ControleSessao::buscarObjeto('privateCand')->ds_bairro == null){ echo 'style="display:none"'; } ?> name="ds_bairro" id="ds_bairro" value="<?php if(isset($_SESSION['errosP'])){ echo $_SESSION['post']['ds_bairro'];} elseif(isset($_SESSION['privateCand'])){ echo ControleSessao::buscarObjeto('privateCand')->ds_bairro;} ?>" <?php echo (isset($_SESSION['errosP']) && in_array('ds_bairro',$_SESSION['errosP'])) ? 'class="campo_erro"' : 'class="campo"'; ?> type="text"  maxlength="20" />
                                    <?php echo Servicos::verificarErro('errosP', 'ds_bairro'); ?>

                            </tr>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="style1"></span></td>
                                <td>Nacionalidade:</td>
                                <td>
                                    <input name="ds_nacionalidade"  id="ds_nacionalidade" value="<?php if(isset($_SESSION['errosP'])){ echo $_SESSION['post']['ds_nacionalidade'];} elseif(isset($_SESSION['privateCand'])){ echo ControleSessao::buscarObjeto('privateCand')->ds_nacionalidade;} ?>" <?php echo (isset($_SESSION['errosP']) && in_array('ds_nacionalidade',$_SESSION['errosP'])) ? 'class="campo_erro"' : 'class="campo"'; ?> type="text"/>
                                    <?php echo Servicos::verificarErro('errosP', 'ds_nacionalidade'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="style1"></span></td>
                                <td>Defici�ncia:</td>
                                <td>
                                    <select name="id_deficiencia" id="id_deficiencia" <?php echo (isset($_SESSION['errosP']) && in_array('id_deficiencia',$_SESSION['errosP'])) ? 'class="campo_erro select"' : 'class="campo select"'; ?>>
                                        <option value="" selected>Nenhuma</option>
                                        <?php
                                        $deficiencias = array();
                                        $deficiencias = Servicos::buscarDeficiencias();
                                        foreach ($deficiencias as $d) {
                                        ?>
                                        <option value="<?php echo $d->id_deficiencia; ?>" <?php if((isset($_SESSION['errosP']) && $_SESSION['post']['id_deficiencia'] == $d->id_deficiencia)||(isset($_SESSION['privateCand']) && ControleSessao::buscarObjeto('privateCand')->id_deficiencia == $d->id_deficiencia)) echo 'selected'; ?>><?php echo $d->nm_deficiencia; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <?php echo Servicos::verificarErro('errosP', 'id_deficiencia'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="style1"></span></td>
                                <td>Objetivo:</td>
                                <td>
                                    <textarea name="ds_objetivo" id="ds_objetivo" cols="50" rows="3" <?php echo (isset($_SESSION['errosP']) && in_array('ds_objetivo',$_SESSION['errosP'])) ? 'class="campo_erro"' : 'class="campo"'; ?>><?php if(isset($_SESSION['errosP'])){ echo $_SESSION['post']['ds_objetivo'];} elseif(isset($_SESSION['privateCand'])){ echo ControleSessao::buscarObjeto('privateCand')->ds_objetivo;} ?></textarea>
                                    <?php echo Servicos::verificarErro('errosP', 'ds_objetivo'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="style1">*</span></td>
                                <td>Possui Bolsa Fam�lia:</td>
                                <td>
                                    <input name="ao_bolsafamilia" id="ao_bolsafamilia_s" type="radio" onclick="mostrarCampoNIS();" value="S" <?php if((isset($_SESSION['errosP']) && $_SESSION['post']['ao_bolsafamilia'] == 'S')||(isset($_SESSION['privateCand']) && ControleSessao::buscarObjeto('privateCand')->ao_bolsafamilia == 'S')) echo 'checked'; ?> />Sim
                                    <input name="ao_bolsafamilia" id="ao_bolsafamilia_n" type="radio" onclick="mostrarCampoNIS();" value="N" checked />N�o
                                    <?php echo Servicos::verificarErro('errosP', 'ao_bolsafamilia'); ?>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span id="numeroNis" <?php if(ControleSessao::buscarObjeto('privateCand')->ao_bolsafamilia == 'N'){ echo 'style="display: none"'; } ?>>
                                        NIS:
                                        <input name="nr_nis" id="nr_nis" value="<?php if(isset($_SESSION['errosP'])){ echo $_SESSION['post']['nr_nis'];} else if(isset($_SESSION['privateCand'])){ echo ControleSessao::buscarObjeto('privateCand')->nr_nis;} ?>" onkeypress="return valida_numero(event);" <?php echo (isset($_SESSION['errosP']) && in_array('nr_nis',$_SESSION['errosP'])) ? 'class="campo_erro"' : 'class="campo"'; ?> type="text"  size="20" maxlength="11" />
                                        <?php echo Servicos::verificarErro('errosP', 'nr_nis'); ?>
                                    </span>
                                </td>
                            </tr>
                            <?php
                                if(
                                        ((ControleSessao::buscarObjeto('privateCand')->ao_abaexperiencia == 'S') && (ControleSessao::buscarObjeto('privateCand')->ao_ativo == 'N'))
                                        ||
                                        ((ControleSessao::buscarObjeto('privateCand')->ao_abaexperiencia == 'S') && (ControleSessao::buscarObjeto('privateCand')->ao_ativo == 'S'))
                                        )


                                    {
                            ?>
                            <tr>
                                <td><span class="style1"></span></td>
                                <td>Ativar curr�culo?</td>
                                <td><input name="ao_ativo" id="ao_ativo" type="radio" value="S" <?php if((isset($_SESSION['errosP']) && $_SESSION['post']['ao_ativo'] == 'S')||(isset($_SESSION['privateCand']) && ControleSessao::buscarObjeto('privateCand')->ao_ativo == 'S')) echo 'checked'; ?> />Sim
                                    <input name="ao_ativo" id="ao_ativo" type="radio" value="N" <?php if((isset($_SESSION['errosP']) && $_SESSION['post']['ao_ativo'] == 'N')||(isset($_SESSION['privateCand']) && ControleSessao::buscarObjeto('privateCand')->ao_ativo == 'N')) echo 'checked'; ?> />N�o
                                    <span style="font-size: 11px; margin-left: 5px;">
                                        (Ao inativar o seu curr�culo as empresas n�o poder�o visualiz�-lo para novas vagas)
                                    </span>
                                </td>
                            </tr>
                            <?php
                                }
                            ?>
                            <tr>
                                <td colspan="3" class="style1">
                                    <br /><input name="next" class="botao" type="submit" id="next_0" value="Salvar e Avan�ar" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="style1"><br />* Campos com * s�o obrigat�rios!</td>
                            </tr>
                        </table>
                    </form>

                </fieldset>



            </div>
            <!-- FIM DADOS PESSOAIS -->

            <!-- PROFISSAO -->
            <div id="parte-07">
                <fieldset>
                    <legend class="legend" style="color: #000; font-size: x-small;">LISTA DE PROFISS�ES</legend>
                    <div class="div_aviso_profissoes">
                        ESCOLHA ABAIXO OS CARGOS NOS QUAIS VOC� SE PROP�E A TRABALHAR E CONCORRER PELAS VAGAS OFERTADAS NO <label style="color: #FFFF00;">BANCO DE OPORTUNIDADES</label>
                    </div>
                    <br />
                    <br />
                    <br />
                    <br />
                    <br />
                    <form name="formDadosEsc" id="formDadosEsc" method="post" action="../controle/ControleCandidato.php?op=manutencao&form=8" onsubmit="verifica_vazio_profissoes();">
                    <div style="color: #000; font-size: 16px; font-weight: bold; float: left; padding: 5px; margin-top: 3px;">
                        BUSCAR PROFISS�ES:
                    </div>
                    <div style="float: left;">
                        <input type="text" id="profissoes" name="profissoes" />
                    </div>
                    <div style="float: left;">
                        <input type="submit" class="bt_cadastrar_profissao" value="Cadastrar" />
                    </div>
                        <script type="text/javascript">
                            //uso noConflict porque tem v�rios bibliotecas e estava dando conflito com as das abas.
                            //a que utiliza essa � a jquery-1.5.1

                            $JQuery(document).ready(function() {
                            $JQuery("#profissoes").tokenInput([
                                <?php
                                    $listaProfissoes = Servicos::buscarProfissoesPorIdCandidatoNaoCadastrada(ControleSessao::buscarObjeto('privateCand')->id_candidato);
                                    foreach($listaProfissoes as $lprof){
                                    ?>
                                        {id: <?php echo $lprof->id_profissao; ?>, name: "<?php echo $lprof->nm_profissao; ?>"},
                                    <?php
                                        }
                                    ?>
                            ]);
                        });
                        </script>
                    <br /><br />
                    <?php
                        if(count(ControleSessao::buscarObjeto('privateCand')->profissoes)){
                    ?>
                            <div style="margin-top: 80px; font-size: 14px; color: #000; float: left; width: 100%;">
                                <label>Profiss�es cadastradas por voc� para encaminhamentos:</label>
                                <br />
                                <hr style="border: solid 1px #EE7228;">
                            </div>
                            <div>
                                <?php
                                    $profissoes_candidato = ControleSessao::buscarObjeto('privateCand')->profissoes;

                                    foreach($profissoes_candidato as $profCand){
                                        //Verifico se a profiss�o est� em valida��o, se sim coloca amarelo se n�o verde
                                        if($profCand->profissao->ao_ativo == "V"){
                                            $class_profissao_lista = "profissao_lista_validacao";
                                            $title_profissao_lista = "Em processo de modera��o pelo administrador do sistema a profiss�o de ".$profCand->profissao->nm_profissao." que voc� cadastrou";
                                        }else{
                                            $class_profissao_lista = "profissao_lista";
                                            $title_profissao_lista = $profCand->profissao->ds_profissao;
                                        }
                                ?>
                                        <div id="profissao_lista<?php echo $profCand->profissao->id_profissao; ?>" class="<?php echo $class_profissao_lista; ?>" title="<?php echo $title_profissao_lista; ?>">
                                            <input type="hidden" name="id_candidato" id="id_candidato" value="<?php echo ControleSessao::buscarObjeto('privateCand')->id_candidato; ?>" />
                                            <input type="hidden" name="id_profissao" id="id_profissao" value="<?php echo $profCand->profissao->id_profissao; ?>" />
                                            <label onclick="esconder_profissao_lista('<?php echo ControleSessao::buscarObjeto('privateCand')->id_candidato; ?>','<?php echo $profCand->profissao->id_profissao; ?>', '<?php echo $profCand->profissao->nm_profissao; ?>');" style="float:right; cursor: pointer; font-weight: bold;" title="Exluir <?php echo $profCand->profissao->nm_profissao; ?> da sua lista de cargos pretendidos?">X</label>
                                            <?php
                                                //Conta se a profiss�o tem vagas cadastradas no banco de oportunidades
                                                if(Servicos::buscarTotalVagasPorIdProfissao($profCand->profissao->id_profissao)->totalvagas > 0){
                                                    //verifica se tem 1 vaga, coloca no singular caso contr�rio plural.
                                                    if(Servicos::buscarTotalVagasPorIdProfissao($profCand->profissao->id_profissao)->totalvagas == 1){
                                                        $vaga_singular_plural = "vaga dispon�vel";
                                                    }else{
                                                        $vaga_singular_plural = "vagas dispon�veis";
                                                    }
                                            ?>
                                                    <div class="div_conta_vagas_profissao" title="<?php echo Servicos::buscarTotalVagasPorIdProfissao($profCand->profissao->id_profissao)->totalvagas." ".$vaga_singular_plural; ?> para <?php echo $profCand->profissao->nm_profissao; ?>">
                                                        <?php echo Servicos::buscarTotalVagasPorIdProfissao($profCand->profissao->id_profissao)->totalvagas; ?>
                                                    </div>
                                            <?php
                                                }else if((Servicos::buscarTotalVagasPorIdProfissao($profCand->profissao->id_profissao)->totalvagas == 0) && ($profCand->profissao->ao_ativo == "V")){
                                            ?>
                                                    <div style="background: #EEEE00;"></div>
                                            <?php
                                                }else{
                                            ?>
                                                    <div class="div_conta_vagas_profissao" title="Nenhuma vaga dispon�vel para <?php echo $profCand->profissao->nm_profissao; ?>">0</div>
                                            <?php
                                                }
                                            ?>
                                            <br /><br />
                                            <?php
                                                echo $profCand->profissao->nm_profissao;
                                            ?>
                                            <input type="hidden" name="profissoes_jacadastradas[]" value="<?php echo $profCand->profissao->id_profissao; ?>" />
                                        </div>
                                <?php
                                    }
                                ?>
                            </div>
                            <div style="font-size: 14px; color: #000; float: left; width: 100%;">
                                <hr style="border: solid 1px #EE7228;">
                            </div>
                    <?php
                        }else{
                    ?>

                            <div class="div_nenhuma_profissao">
                                <br /><br /><br /><br /><br /><br /><br /><br />
                                <label style="text-transform: uppercase; font-size: 14px;">Voc� n�o tem candidaturas, cadastre as profiss�es acima para poder ser encaminhado a novas vagas.</label>
                            </div>
                    <?php
                        }
                    ?>
                    </form>
                    <div class="conta_lista_profissoes">
                        <?php
                            //Conto as profiss�es e mostro no fim da p�gina.
                            if(count(ControleSessao::buscarObjeto('privateCand')->profissoes) == 0){
                                echo "Nenhuma profiss�o cadastrada";
                            }else if(count(ControleSessao::buscarObjeto('privateCand')->profissoes) == 1){
                                echo "<b>".count(ControleSessao::buscarObjeto('privateCand')->profissoes)."</b> profiss�o cadastrada.";
                            }else{
                                echo "<b>".count(ControleSessao::buscarObjeto('privateCand')->profissoes)."</b> profiss�es cadastradas.";
                            }
                        ?>
                    </div>
                    <form name="formNovaProfissao" id="formNovaProfissao" method="post" action="../controle/ControleCandidato.php?op=manutencao&form=8">
                    <div style="width: 100%;">
                        <label class="label_nova_profissao" id="label_nova_profissao" style="display: <?php echo (isset($_SESSION['errosPR']) && in_array('ds_outro',$_SESSION['errosPR'])) ? 'none;' : 'block;'; ?>">Caso a profiss�o que deseja se candidar n�o esteja em nossa lista, <b class="clique_nova_profissao" onclick="profissao_outra();">clique aqui</b>.</label>
                        <div id="profissao_outra" class="profissao_outra" style="display: <?php echo (isset($_SESSION['errosPR']) && in_array('ds_outro',$_SESSION['errosPR'])) ? 'block' : 'none'; ?>">
                            Digite a profiss�o: <input type="text" name="ds_outro" id="ds_outro" style="background: <?php echo (isset($_SESSION['errosPR']) && in_array('ds_outro',$_SESSION['errosPR'])) ? '#FFF68F;' : '#FFF;'; ?>" />
                            <input type="submit" class="bt_cadastrar_profissao" value="CADASTRAR" />
                            <input type="hidden" name="ao_outro" value="S" />
                            <?php
                                if(isset($_SESSION['errosPR']) && in_array('ds_outro',$_SESSION['errosPR'])){
                            ?>
                                <br />
                                <span class="style1" style="float: right; margin-right: 115px;">* Preencha corretamente este campo de profiss�o</span>

                            <?php
                                }
                            ?>
                        </div>
                    </div>
                    </form>
                </fieldset>
            </div>
            <!-- FIM DADOS ESCOLARES

            <!-- DADOS ESCOLARES -->
            <div id="parte-02">
                <fieldset>

                    <legend class="legend">Forma��o</legend>

                    <div class="tab_form">
                        <form name="formDadosEsc" id="formDadosEsc" method="post" action="../controle/ControleCandidato.php?op=manutencao&form=2">
                            <table>
                                <tr>
                                    <td><span class="style1">*</span></td>
                                    <td>Escolaridade:</td>
                                    <td>
                                        <select name="id_formacao" id="id_formacao" <?php echo (isset($_SESSION['errosF']) && in_array('id_formacao',$_SESSION['errosF'])) ? 'class="campo_erro"' : 'class="campo"'; ?>>
                                            <option value="">Selecione...</option>
                                            <?php
                                            $formacoes = array();
                                            $formacoes = Servicos::buscarFormacoes();
                                            foreach ($formacoes as $f) {
                                            ?>
                                            <option value="<?php echo $f->id_formacao; ?>" <?php if(isset($_SESSION['errosF']) && $_SESSION['post']['id_formacao'] == $f->id_formacao){ echo 'selected';} ?>><?php echo $f->nm_formacao; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <?php
                                        if(isset($_SESSION['errosF']) && in_array('id_formacao',$_SESSION['errosF'])){
                                        ?>
                                            <span class="style1">* Preencha corretamente este campo</span>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr id="auxCurso" <?php if($_SESSION['post']['id_formacao'] != 6 && $_SESSION['post']['id_formacao'] != 7 && $_SESSION['post']['id_formacao'] != 8) echo "style='display: none;'"; ?>>
                                    <td><span class="style1">*</span></td>
                                    <td>Curso:</td>
                                    <td><input value="<?php echo $_POST['curso_cand'];?>" type="text" name="curso_cand"  id="curso_cand" class="campo" size="35" maxlength="30" <?php echo (isset($_SESSION['errosF']) && in_array('curso_cand',$_SESSION['errosF'])) ? 'class="campo_erro"' : 'class="campo"'; ?> /></td>
                                        <?php
                                        if(isset($_SESSION['errosF']) && in_array('curso_cand',$_SESSION['errosF'])){
                                        ?>
                                            <span class="style1">* Preencha corretamente este campo</span>
                                        <?php
                                        }
                                        ?>
                                </tr>
                                <tr id="auxSemestre" <?php if($_SESSION['post']['id_formacao'] != 6 && $_SESSION['post']['id_formacao'] != 7) echo "style='display: none;'"; ?>>
                                    <td><span class="style1"></span></td>
                                    <td>Semestre:</td>
                                    <td><input value="<?php echo $_POST['semestre_cand'];?>" type="text" name="semestre_cand" id="semestre_cand" class="campo" onkeypress="return valida_numero(event);" size="20" maxlength="2" <?php echo (isset($_SESSION['errosF']) && in_array('semestre_cand',$_SESSION['errosF'])) ? 'class="campo_erro"' : 'class="campo"'; ?> /></td>
                                        <?php
                                            if(isset($_SESSION['errosF']) && in_array('semestre_cand',$_SESSION['errosF'])){
                                        ?>
                                            <span class="style1">* Preencha corretamente este campo</span>
                                        <?php
                                        }
                                        ?>
                                </tr>

                                <tr>
                                    <td>&nbsp;</td>
                                    <td>Data Termino:</td>
                                    <td>
                                        <input placeholder="DD/MM/AAAA" value="<?php if(isset($_SESSION['errosF'])){ echo $_SESSION['post']['dt_termino'];} ?>" type="text" name="dt_termino"  id="dt_termino" onkeypress="return valida_numero(event);" onkeydown="formata_data(this, event);" size="11" maxlength="10" <?php echo (isset($_SESSION['errosF']) && in_array('dt_termino',$_SESSION['errosF'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                        <?php
                                        if(isset($_SESSION['errosF']) && in_array('dt_termino',$_SESSION['errosF'])){
                                        ?>
                                            <span class="style1">* Preencha corretamente este campo</span>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>Escola:</td>
                                    <td>
                                        <input value="<?php if(isset($_SESSION['errosF'])){ echo $_SESSION['post']['nm_escola'];} ?>" name="nm_escola" id="nm_escola" type="text"  size="50" maxlength="60" <?php echo (isset($_SESSION['errosF']) && in_array('nm_escola',$_SESSION['errosF'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                        <?php
                                        if(isset($_SESSION['errosF']) && in_array('nm_escola',$_SESSION['errosF'])){
                                        ?>
                                            <span class="style1">* Preencha corretamente este campo</span>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>Cidade Escola:</td>
                                    <td>
                                        <input value="<?php if(isset($_SESSION['errosF'])){ echo $_SESSION['post']['ds_cidadeEscola'];} ?>" name="ds_cidadeEscola" id="ds_cidadeEscola" type="text"  size="50" maxlength="60" <?php echo (isset($_SESSION['errosF']) && in_array('ds_cidadeEscola',$_SESSION['errosF'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                        <?php
                                        if(isset($_SESSION['errosF']) && in_array('ds_cidadeEscola',$_SESSION['errosF'])){
                                        ?>
                                            <span class="style1">* Preencha corretamente este campo</span>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td><span class="style1">* Campos com * s�o obrigat�rios!</span></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>
                                        <input type="submit" value="Salvar" class="botao" />
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    <div class="tab_adiciona">
                        <?php
                        if(ControleLoginCandidato::verificarAcesso() && ControleSessao::buscarObjeto('privateCand')->formacoes){
                            //define a quantidade de resultados da lista
                            $qtd = 10;
                            //busca a page atual
                            $page = (isset($_GET['pg'])) ? $_GET['pg'] : 0;
                            //recebo um novo array com apenas os elemento necessarios para essa page atual
                            $formacoes = Servicos::listar(ControleSessao::buscarObjeto('privateCand')->formacoes, $qtd, $page);
                        ?>
                        <div id="erros" class="style1">
                            <?php
                            if($_SESSION['errosDF']){
                                $errosDF = ControleSessao::buscarVariavel('errosDF');
                                foreach ($errosDF as $e) {
                                    echo $e.'<br>';
                                }
                            }
                            ?>
                        </div>
                        <div>
                            <form name="deletarFormacao" id="deletarFormacao" method="post" action="../controle/ControleCandidato.php?op=manutencao&form=3">
                                <table id="tabela_formacoes" name='tabela_formacoes' width="100%">
                                    <tr class="table_formacao_cab" id="tabelaFormacao">
                                        <td align='center' width="50%">Escolaridade</td>
                                        <td align='center' width="20%">Escola</td>
                                        <td align='center' width="20%">Cidade Escola</td>
                                        <td align='center' width="9%">Data T�rmino</td>
                                        <td width="5%">Apagar</td>
                                    </tr>
                                    <?php
                                        foreach($formacoes as $cf){
                                            if(!Validacao::validarNulo($cf)){
                                    ?>
                                    <tr class="table_formacao_row">
                                        <td><?php echo Servicos::verificarFormacao($cf->id_formacao) . Servicos::verificarCursoSemestre($cf->ds_curso, ($cf->ds_semestre == null) ? '' : ' / '.$cf->ds_semestre."� Sem."); ?></td>
                                        <td><?php echo $cf->nm_escola; ?></td>
                                        <td><?php echo $cf->ds_cidadeescola; ?></td>
                                        <td align='center'><?php echo Validacao::explodirDataMySqlNaoObg($cf->dt_termino); ?></td>
                                        <td align='center'><input type="checkbox" class="marcar" name="ids[]" id="idsFor" value="<?php echo $cf->id_candidato_formacao; ?>"></td>
                                    </tr>
                                    <?php
                                            }
                                        }
                                    ?>
                                    <tr>
                                        <td colspan="5" align="center">
                                            <span id="paginacao">
                                            <?php
                                            //crio a paginacao propriamente dita
                                            echo Servicos::criarPaginacao(ControleSessao::buscarObjeto('privateCand')->formacoes, $qtd, $page, '#parte-02');
                                            ?>
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                                <div align='right' class="deletar">
                                    <input type="button" value="Deletar" class="botao" onclick="confirmarDeleteFormacao()" />
                                    <label class="filtro_label">Marcar Todos</label>
                                    <input type="checkbox" name="cfTodos" id="todos" value="" onclick="marcardesmarcar();">
                                </div>
                            </form>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                </fieldset>
            </div>
            <!-- FIM DADOS ESCOLARES -->

            <!-- DADOS QUALIFICA��O -->
            <div id="parte-03">
                <fieldset>
                    <legend class="legend">Qualifica��es</legend>
                    <div class="tab_form">
                        <form name="formDadosQual" id="formDadosQual" method="post" action="../controle/ControleCandidato.php?op=manutencao&form=4">
                            <table>
                                <?php
                                if(count(ControleSessao::buscarObjeto('privateCand')->qualificacoes)>0){
                                    $perguntaQualificacoes = "Possui outras qualifica��es?";
                                    $aux=1;
                                }else{
                                    $perguntaQualificacoes = "Possui qualifica��o?";
                                    $aux=0;
                                }
                                ?>
                                <tr>
                                    <td><span class="style1">*</span></td>
                                    <td><?php echo $perguntaQualificacoes; ?>

                                        <?php if($aux == '0'){ ?>
                                        <input name="ao_qualificacao" id="ao_qualificacao_n" type="radio" <?php if(count(ControleSessao::buscarObjeto('privateCand')->qualificacoes) > 0){ ?>
                                                                                                                    onclick="mostrarCamposQualificacoes();
                                                                                                                        if(confirm('Voc� tem certeza que deseja apagar todas as suas qualifica��es j� cadastradas.')){
                                                                                                                            alert('Qualifica��es deletadas com sucesso.');
                                                                                                                            $('input[name=registrar]').click();
                                                                                                                        }else{
                                                                                                                            location.reload();
                                                                                                                        }"
                                                                                                          <?php }else{ ?>
                                                                                                                    onclick="$('input[name=registrar]').click();"
                                                                                                          <?php } ?> value="N"
                                                                                                          <?php
                                                                                                          $auxQualificacao = Servicos::buscarQualificacoesNulas(ControleSessao::buscarObjeto('privateCand')->id_candidato);
                                                                                                          if(count($auxQualificacao) > 0){ echo 'checked'; } ?>/>N�o
                                        <?php } ?>
                                    <input name="ao_qualificacao" id="ao_qualificacao_s" type="radio" onclick="mostrarCamposQualificacoes();" value="S" <?php if((isset($_SESSION['errosQ']) && $_SESSION['post']['ao_qualificacao'] == 'S')){ echo 'checked';} ?> />Sim</td>
                                </tr>
                            </table>
                            <table class="tabela" id="tabela_qualificacoes" <?php if(isset($_SESSION['errosQ'])){ echo'style="display: block;"'; }else{ echo 'style="display: none;"'; } ?>>
                                <tr>
                                    <td><span class="style1">*</span></td>
                                    <td width="100px">Descri��o:</td>
                                    <td>
                                        <input value="<?php if(isset($_SESSION['errosQ'])){ echo $_SESSION['post']['ds_qualificacao'];} ?>" name="ds_qualificacao" id="ds_qualificacao" type="text"  size="50" maxlength="60" <?php echo (isset($_SESSION['errosQ']) && in_array('ds_qualificacao',$_SESSION['errosQ'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                        <?php if(isset($_SESSION['errosQ']) && in_array('ds_qualificacao',$_SESSION['errosQ'])){ ?>
                                            <span class="style1">* Preencha corretamente este campo</span>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="style1">*</span></td>
                                    <td width="100px">Institui��o:</td>
                                    <td>
                                        <input value="<?php if(isset($_SESSION['errosQ'])){ echo $_SESSION['post']['nm_instituicao'];} ?>" name="nm_instituicao" id="nm_instituicao" type="text"  size="50" maxlength="60" <?php echo (isset($_SESSION['errosQ']) && in_array('nm_instituicao',$_SESSION['errosQ'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                        <?php if(isset($_SESSION['errosQ']) && in_array('nm_instituicao',$_SESSION['errosQ'])){ ?>
                                            <span class="style1">* Preencha corretamente este campo</span>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td width="100px">Data Termino:</td>
                                    <td>
                                        <input placeholder="DD/MM/AAAA" value="<?php if(isset($_SESSION['errosQ'])){ echo $_SESSION['post']['dt_termino'];} ?>" type="text" name="dt_termino" id="dt_termino" onkeypress="return valida_numero(event);" onkeydown="formata_data(this, event);" size="11" maxlength="10" <?php echo (isset($_SESSION['errosQ']) && in_array('dt_termino',$_SESSION['errosQ'])) ? 'class="campo_erro data"' : 'class="campo data"'; ?> />
                                        <?php if(isset($_SESSION['errosQ']) && in_array('dt_termino',$_SESSION['errosQ'])){ ?>
                                            <span class="style1">* Preencha corretamente este campo</span>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td width="100px">Qnt. Horas:</td>
                                    <td>
                                        <input value="<?php if(isset($_SESSION['errosQ'])){ echo $_SESSION['post']['qtd_horas'];} ?>" type="text" name="qtd_horas" id="qtd_horas" onkeypress="return valida_numero(event);" size="10" maxlength="10" <?php echo (isset($_SESSION['errosQ']) && in_array('qtd_horas',$_SESSION['errosQ'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />Hrs.
                                        <?php if(isset($_SESSION['errosQ']) && in_array('qtd_horas',$_SESSION['errosQ'])){ ?>
                                            <span class="style1">* Preencha corretamente este campo</span>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="style1">*</span></td>
                                    <td width="100px">Curso realizado pelo PRONATEC?</td>
                                    <td><input name="ao_pronatec" id="ao_pronatec_n" type="radio" value="N" <?php if((isset($_SESSION['errosE']) && $_SESSION['post']['ao_pronatec'] == 'N')||(isset($_SESSION['privateCand']) && ControleSessao::buscarObjeto('privateCand')->ao_pronatec == 'N')) echo 'checked'; ?> />N�o
                                    <input name="ao_pronatec" id="ao_pronatec_s" type="radio" value="S" <?php if((isset($_SESSION['errosE']) && $_SESSION['post']['ao_pronatec'] == 'S')||(isset($_SESSION['privateCand']) && ControleSessao::buscarObjeto('privateCand')->ao_pronatec == 'S')) echo 'checked'; ?> />Sim</td>
                                    <?php echo Servicos::verificarErro('errosQ', 'ao_pronatec', '* Marque ao menos uma op��o.'); ?>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                    <td>
                                        <input type="submit" name="registrar" value="Salvar" class="botao" />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3"><span class="style1"><br />* Campos s�o obrigat�rios!</span></td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    <div class="tab_adiciona">
                        <?php
                        if(ControleLoginCandidato::verificarAcesso() && ControleSessao::buscarObjeto('privateCand')->qualificacoes){
                            //define a quantidade de resultados da lista
                            $qtd = 10;
                            //busca a page atual
                            $page = (isset($_GET['pg'])) ? $_GET['pg'] : 0;
                            //recebo um novo array com apenas os elemento necessarios para essa page atual
                            $qualificacoes = Servicos::listar(ControleSessao::buscarObjeto('privateCand')->qualificacoes, $qtd, $page);

                        ?>
                        <div id="erros" class="style1">
                            <?php
                            if($_SESSION['errosDQ']){
                                $errosDQ = ControleSessao::buscarVariavel('errosDQ');
                                foreach ($errosDQ as $e) {
                                    echo $e.'<br>';
                                }
                            }
                            ?>
                        </div>
                        <div>
                            <form name="deletarQualificacao" id="deletarQualificacao" method="post" action="../controle/ControleCandidato.php?op=manutencao&form=5">
                                <table id="tabela_formacoes" name='tabela_formacoes' width="100%">
                                    <tr class="table_formacao_cab" id="tabelaFormacao">
                                        <td align='center'>Descri��o</td>
                                        <td align='center'>Institui��o</td>
                                        <td align='center' width='100px'>Data T�rmino</td>
                                        <td align='center' width='100px'>Qnt. Horas</td>
                                        <td width="45">Apagar</td>
                                    </tr>
                                    <?php
                                        foreach($qualificacoes as $cq){
                                            if(!Validacao::validarNulo($cq)){
                                    ?>
                                    <tr class="table_formacao_row">
                                        <td><?php echo $cq->ds_qualificacao; ?></td>
                                        <td><?php echo $cq->nm_instituicao; ?></td>
                                        <td align='center'><?php echo Validacao::explodirDataMySqlNaoObg($cq->dt_termino); ?></td>
                                        <td align='center'><?php echo $cq->qtd_horas; ?></td>
                                        <td align='center'>
                                            <input type="checkbox" class="mQua" name="idsQua[]" value="<?php echo $cq->id_qualificacao; ?>">
                                        </td>
                                    </tr>
                                    <?php
                                            }
                                        }
                                    ?>
                                    <tr>
                                        <td colspan="5" align="center">
                                            <span id="paginacao">
                                            <?php
                                            //crio a paginacao propriamente dita
                                            echo Servicos::criarPaginacao(ControleSessao::buscarObjeto('privateCand')->qualificacoes, $qtd, $page, '#parte-03');
                                            ?>
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                                <div align='right' class="deletar">
                                    <input type="button" value="Deletar" class="botao" onclick="confirmarDeleteQualificacao()" />
                                    <label class="filtro_label">Marcar Todos</label>
                                    <input type="checkbox" name="cqTodos" id="tdQua" value="" onclick="marcardesmarcar();">
                                </div>
                            </form>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                    <?php if(isset($_SESSION['msgQualificacao'])){ ?>
                        <span class="msg"><?php echo ControleSessao::buscarVariavel('msgQualificacao'); ?></span>
                    <?php } ?>
                </fieldset>
            </div>
            <!-- FIM DADOS QUALIFICA��O -->

            <!-- EXPERI�NCIAS ANTERIORES -->
            <div id="parte-04">
                <fieldset>
                    <legend class="legend">Experi�ncia Profissional</legend>
                    <div class="tab_form">
                        <form name="formExpAnt" id="formExpAnt" method="post" action="../controle/ControleCandidato.php?op=manutencao&form=6">
                            <table>
                                <tr>
                                    <td><span class="style1">*</span></td>
                                    <?php
                                        if(count(ControleSessao::buscarObjeto('privateCand')->experiencias)>0){
                                            $perguntaExperiencias = "Possui outras experi�ncias?";
                                            $auxExp = "1";
                                        }else{
                                            $perguntaExperiencias = "Possui experi�ncia?";
                                            $auxExp = "0";
                                        }
                                    ?>
                                    <td>
                                        <?php echo $perguntaExperiencias; ?>

                                        <?php if($auxExp == "0"){ ?>
                                        <input name="ao_experiencia" id="ao_experiencia_n" type="radio" <?php if(count(ControleSessao::buscarObjeto('privateCand')->experiencias) > 0){ ?>
                                                                                                                    onclick="mostrarCamposExperiencias();
                                                                                                                        if(confirm('Voc� tem certeza que deseja apagar todas as suas experi�ncias anteriores j� cadastradas.')){
                                                                                                                            alert('Experi�ncias deletadas com sucesso.');
                                                                                                                            $('input[name=cadastrar]').click();
                                                                                                                        }else{
                                                                                                                            location.reload();
                                                                                                                        }"
                                                                                                          <?php }else{ ?>
                                                                                                                    onclick="$('input[name=cadastrar]').click();"
                                                                                                          <?php } ?> value="N"
                                                                                                          <?php
                                                                                                          $auxExperiencia = Servicos::buscarCandidatoExperienciaNula(ControleSessao::buscarObjeto('privateCand')->id_candidato);
                                                                                                          if(count($auxExperiencia) > 0){ echo 'checked'; }
                                                                                                          ?>/>N�o
                                        <?php } ?>
                                        <input name="ao_experiencia" id="ao_experiencia_s" type="radio" onclick="mostrarCamposExperiencias();" value="S" <?php if((isset($_SESSION['errosE']) && $_SESSION['post']['ao_experiencia'] == 'S')) echo 'checked'; ?> />Sim
                                    </td>
                                </tr>
                            </table>

                            <table id="tabela_experiencias" <?php if(isset($_SESSION['errosE'])){ echo'style="display: block;"'; }else{ echo 'style="display: none;"'; } ?>>
                                <tr>
                                    <td><span class="style1">*</span></td>
                                    <td>Empresa:</td>
                                    <td>
                                        <input value="<?php if(isset($_SESSION['errosE'])){ echo $_SESSION['post']['nm_empresa'];} ?>" name="nm_empresa" id="nm_empresa" type="text" size="70" maxlength="60" <?php echo (isset($_SESSION['errosE']) && in_array('nm_empresa',$_SESSION['errosE'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                        <?php
                                        if(isset($_SESSION['errosE']) && in_array('nm_empresa',$_SESSION['errosE'])){
                                        ?>
                                            <span class="style1">* Preencha corretamente este campo</span>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td width="69">Data In�cio:</td>
                                    <td width="546">
                                        <input placeholder="DD/MM/AAAA" value="<?php if(isset($_SESSION['errosE'])){ echo $_SESSION['post']['dt_inicio'];} ?>" name="dt_inicio" id="dt_inicio" type="text" onkeypress="return valida_numero(event);" onkeydown="formata_data(this, event);" size="11" maxlength="10" <?php echo (isset($_SESSION['errosE']) && in_array('dt_inicio',$_SESSION['errosE'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                        <?php
                                        if(isset($_SESSION['errosE']) && in_array('dt_inicio',$_SESSION['errosE'])){
                                        ?>
                                            <span class="style1">* Preencha corretamente este campo</span>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>Data Termino:</td>
                                    <td>
                                        <input placeholder="DD/MM/AAAA" value="<?php if(isset($_SESSION['errosE'])){ echo $_SESSION['post']['dt_termino'];} ?>" name="dt_termino" id="dt_termino" type="text" onkeypress="return valida_numero(event);" onkeydown="formata_data(this, event);" size="11" maxlength="10" <?php echo (isset($_SESSION['errosE']) && in_array('dt_termino',$_SESSION['errosE'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                        <?php
                                        if(isset($_SESSION['errosE']) && in_array('dt_termino',$_SESSION['errosE'])){
                                        ?>
                                            <span class="style1">* Preencha corretamente este campo</span>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>Principais Atividades:</td>
                                    <td>
                                        <textarea name="ds_atividades" id="ds_atividade" cols="50" rows="3" <?php echo (isset($_SESSION['errosE']) && in_array('ds_atividades',$_SESSION['errosE'])) ? 'class="campo_erro"' : 'class="campo"'; ?>><?php if(isset($_SESSION['errosE'])){ echo $_SESSION['post']['ds_atividades'];} ?></textarea>
                                        <?php
                                        if(isset($_SESSION['errosE']) && in_array('ds_atividades',$_SESSION['errosE'])){
                                        ?>
                                            <span class="style1">* Preencha corretamente este campo</span>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>
                                        <input type="submit" name="cadastrar" value="Salvar" class="botao" />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3"><span class="style1"><br />* Campos s�o obrigat�rios!</span></td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    <div class="tab_adiciona">
                        <?php
                        if(ControleLoginCandidato::verificarAcesso() && ControleSessao::buscarObjeto('privateCand')->experiencias){
                            //define a quantidade de resultados da lista
                            $qtd = 10;
                            //busca a page atual
                            $page = (isset($_GET['pg'])) ? $_GET['pg'] : 0;
                            //recebo um novo array com apenas os elemento necessarios para essa page atual
                            $experiencias = Servicos::listar(ControleSessao::buscarObjeto('privateCand')->experiencias, $qtd, $page);
                        ?>
                        <div id="erros" class="style1">
                            <?php
                            if($_SESSION['errosDE']){
                                $errosDE = ControleSessao::buscarVariavel('errosDE');
                                foreach ($errosDE as $e) {
                                    echo $e.'<br>';
                                }
                            }
                            ?>
                        </div>
                        <div>
                            <form name="deletarExperiencia" id="deletarExperiencia" method="post" action="../controle/ControleCandidato.php?op=manutencao&form=7">
                                <table id="tabela_formacoes" name='tabela_formacoes' width="100%">
                                    <tr class="table_formacao_cab" id="tabelaFormacao">
                                        <td align='center' width="20%">Empresa</td>
                                        <td align='center' width="5%">Data In�cio</td>
                                        <td align='center' width="10%">Data T�rmino</td>
                                        <td align='center' width="63">Principais Atividades</td>
                                        <td width="2%">Apagar</td>
                                    </tr>
                                    <?php
                                        foreach($experiencias as $ce){
                                            if(!Validacao::validarNulo($ce)){
                                    ?>
                                    <tr class="table_formacao_row">
                                        <td><?php echo $ce->nm_empresa; ?></td>
                                        <td align='center'><?php echo Validacao::explodirDataMySqlNaoObg($ce->dt_inicio); ?></td>
                                        <td align='center'><?php echo Validacao::explodirDataMySqlNaoObg($ce->dt_termino);?></td>
                                        <td><?php echo nl2br($ce->ds_atividades)?></td>
                                        <td align='center'>
                                            <input type="checkbox" class="mExp" name="idsExp[]" value="<?php echo $ce->id_experiencia; ?>">
                                        </td>
                                    </tr>
                                    <?php
                                            }
                                        }
                                    ?>
                                    <tr>
                                        <td colspan="5" align="center">
                                            <span id="paginacao">
                                            <?php
                                            //crio a paginacao propriamente dita
                                            echo Servicos::criarPaginacao(ControleSessao::buscarObjeto('privateCand')->experiencias, $qtd, $page, '#parte-04');
                                            ?>
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                                <div align='right' class="deletar">
                                    <input type="button" value="Deletar" class="botao" onclick="confirmarDeleteExperiencia()" />
                                    <label class="filtro_label">Marcar Todos</label>
                                    <input type="checkbox" name="ceTodos" id="tdExp" value="" onclick="marcardesmarcar()">
                                </div>
                            </form>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                    <?php if(isset($_SESSION['msgExperiencia'])){ ?>
                        <span class="msg"><?php echo ControleSessao::buscarVariavel('msgExperiencia'); ?></span>
                    <?php } ?>
                </fieldset>
            </div>
            <!-- FIM EXPERI�NCIAS ANTERIORES -->

            <!-- ADICIONAR FOTO -->
            <div id="parte-05">
                <fieldset style="height: 40%;">
                    <legend class="legend">Adicionar Foto</legend>
                    <form name="formUpload" method="post" action="../controle/ControleCandidato.php?op=upload" enctype="multipart/form-data">
                        <table class="tabela_cand campo">
                            <tr>
                                <td width='55%' style="vertical-align: text-top;">
                                    <p>
                                        Voc� pode complementar seu curr�culo adicionando uma foto profissional!
                                    </p>
                                    <p>
                                        Selecione uma imagem (.jpg): <input type="file" name="foto" />
                                    </p>
                                    <p>
                                        <input type="submit" value="Enviar Foto" class="botao" />
                                        <?php
                                        if(isset($_SESSION['erros'])){
                                            $erros = ControleSessao::buscarVariavel('erros');
                                            foreach ($erros as $e) {
                                            ?>
                                                <span class="style1">
                                                    &nbsp;
                                                    <?php echo ' * '.$e; ?>
                                                </span>
                                            <?php
                                            }
                                        }
                                        ?>
                                    </p>
                                </td>
                                <td colspan="2">
                                    <img src='<?php $foto = '../fotos/' . ControleSessao::buscarObjeto('privateCand')->id_candidato . '.jpg';
                                                    echo (file_exists($foto)) ? "$foto" : '../fotos/foto_null.jpg';
                                                ?>' />
                                </td>
                            </tr>
                        </table>
                    </form>
                </fieldset>
            </div>
            <!-- FIM FOTO -->

            <!-- IMPRIMIR CURRICULO -->
            <div id="parte-06">
                <fieldset style="height: 40%;">
                    <legend class="legend">Imprimir</legend>
                    <form name="formImprimir" method="post" action="../controle/ControleCandidato.php?op=imprimir">
                        <table class="tabela_cand campo">
                            <tr height='50px'>
                                <td>
                                    Voc� deseja imprimir seu curr�culo?
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <input type="submit" value="Sim, imprimir agora" class="botao" />
                                </td>
                            </tr>
                        </table>
                    </form>
                </fieldset>
            </div>
            <!-- FIM IMPRIMIR CURRICULO -->

        </div>
</div>


<?php
include_once 'footer.php';
ControleSessao::destruirVariavel('post');
ControleSessao::destruirVariavel('errosP');
ControleSessao::destruirVariavel('errosA');
ControleSessao::destruirVariavel('errosF');
ControleSessao::destruirVariavel('errosDF');
ControleSessao::destruirVariavel('errosQ');
ControleSessao::destruirVariavel('msgQualificacao');
ControleSessao::destruirVariavel('errosDQ');
ControleSessao::destruirVariavel('errosE');
ControleSessao::destruirVariavel('msgExperiencia');
ControleSessao::destruirVariavel('errosDE');
ControleSessao::destruirVariavel('erros');
ControleSessao::destruirVariavel('errosPR');
?>
