<?php
include_once '../util/ControleSessao.class.php';
include_once '../util/ControleLoginEmpresa.class.php';
include_once '../modelo/CandidatoVO.class.php';
include_once '../modelo/VagaCandidatoVO.class.php';
include_once '../util/Imprimir.class.php';


ControleSessao::abrirSessao();

//verifico se ha candidato na sessao
if(!ControleLoginEmpresa::verificarAcesso()){
    //se nao tiver candidato na sessao
    ControleLoginEmpresa::deslogar();
}

//var_dump($_SESSION['id_usuario']);die;

include_once './header.php';
include_once '../util/Servicos.class.php';

if(in_array(S_VISUALIZAR_EMP, $_SESSION[SESSION_ACESSO])) 
           
//Para bloquear a edição do acesso interno como empresa, deixando apenas para visualizar, só descomentar a linha abaixo.
//$disabled = 'disabled';

?>
<div class="sessao_nova_vaga">
    <?php if(!ControleSessao::buscarVariavel('cancelar')){ ?>
    <a class="logout" onclick="cancelarVaga();">
        <img id="fechar_img" src="../../../Utilidades/Imagens/bancodeoportunidades/icon_back.png" width="15%" />
        <span id="fechar">Voltar</span>
    </a>
    <?php } ?>
</div>
<?php
    //Processo para contar a quantidade de candidato para cada status e jogar nas abas.

    $totalEncaminhados = 0;
    $totalBaixasAutomaticas = 0;
    $totalPreSelecionados = 0;
    $totalContratados = 0;
    $totalDispensandos = 0;

    $candidatos = ControleSessao::buscarObjeto('objVaga')->encaminhados;            
    foreach($candidatos as $todos){                                        
            if($todos->ao_status == "E"){
                $totalEncaminhados++;
            }elseif($todos->ao_status == "B"){
                $totalBaixasAutomaticas++;
            }elseif($todos->ao_status == "P") {
                $totalPreSelecionados++;
            }elseif($todos->ao_status == "C"){
                $totalContratados++;
            }else{
                $totalDispensandos++;
            }
    }
    
    /* Quando for feita a pesquisa por código verifica a sessão
    e coloca nas variáveis para não alterar os valores delas. */
    if($_SESSION['post']){                        
        $totalEncaminhados = $_SESSION['post']['encaminhados'];
        $totalBaixasAutomaticas = $_SESSION['post']['baixasAutomaticas'];
        $totalPreSelecionados = $_SESSION['post']['preSelecionados'];
        $totalContratados = $_SESSION['post']['contratados'];
        $totalDispensandos = $_SESSION['post']['dispensados'];        
    }
    
    $total = $totalEncaminhados + $totalBaixasAutomaticas + $totalPreSelecionados + $totalContratados + $totalDispensandos;                                    

    if($total == "0"){
        $candi = "Não há candidatos";
        $total = "";
        $mostraQtdVaga = $candi;
    }else if($total == "1"){
        $candi = "candidato";
        $mostraQtdVaga = $total." ".$candi;
    }else{
        $candi = "candidatos";
        $mostraQtdVaga = $total." ".$candi;
    }

?>
<div id="conteudo">
    <div class="subtitulo">Banco de Oportunidades</div>
    <div id="tudo"></div>
    <div id="principal">
        <?php $v = ControleSessao::buscarObjeto('objVaga'); ?>
        <ul>
            <li><a href="#parte-01"><span>Dados da Vaga</span></a></li>
            <li><a href="#parte-02" onclick="atualizaListaTodos(<?php echo ControleSessao::buscarObjeto('objVaga')->id_vaga; ?>);" ><span>Todos Candidatos</span></a></li>
            <li><a href="#parte-03" onclick="atualizaListaEncaminhados(<?php echo ControleSessao::buscarObjeto('objVaga')->id_vaga; ?>);"><span>Encaminhados</span></a></li>
            <li><a href="#parte-04" onclick="atualizaListaBaixasAutomaticas(<?php echo ControleSessao::buscarObjeto('objVaga')->id_vaga; ?>);"><span>Baixas Automáticas</span></a></li>
            <li><a href="#parte-05" onclick="atualizaListaPreSelecionados(<?php echo ControleSessao::buscarObjeto('objVaga')->id_vaga; ?>);"><span>Pré-Selecionados</span></a></li>
            <li><a href="#parte-06" onclick="atualizaListaContratados(<?php echo ControleSessao::buscarObjeto('objVaga')->id_vaga; ?>);"><span>Contratados</span></a></li>
            <li><a href="#parte-07" onclick="atualizaListaDispensados(<?php echo ControleSessao::buscarObjeto('objVaga')->id_vaga; ?>);"><span>Dispensados</span></a></li>
        </ul>
        
    <div id="parte-01">
            <div class="style1">
            <?php if(isset($_SESSION['msg']))echo ControleSessao::buscarVariavel('msg');?>
            <?php
                //Caso a vaga estiver inativa, bloquea todos os campos dessa vaga.
                if(ControleSessao::buscarObjeto('objVaga')->ao_ativo == 'N'){ 
                    $disabled = "disabled";                
                }else{
                    $disabled = "";
                }
            ?>
            </div>
            <form name="formCadVaga" id="formCadVaga" method="post" action="../controle/ControleVaga.php?op=manutencao">
                <?php //Passando os campos pra busca para poder retonar na sessão. ?>
                <input type="hidden" name="encaminhados" id="encaminhados" value="<?php echo $totalEncaminhados; ?>" />
                <input type="hidden" name="baixasAutomaticas" id="baixasAutomaticas" value="<?php echo $totalBaixasAutomaticas; ?>" />
                <input type="hidden" name="preSelecionados" id="preSelecionados" value="<?php echo $totalPreSelecionados; ?>" />
                <input type="hidden" name="contratados" id="contatados" value="<?php echo $totalContratados;?>" />
                <input type="hidden" name="dispensados" id="dispensados" value="<?php echo $totalDispensandos; ?>" />
                <fieldset>
                    <legend class="legend" style="color: black;">EDIÇÃO DA VAGA</legend>
                    <table class="tabela_cand" style="width: 100%;">
                        <tr>                            
                            <td width="15%"><span class="style1">*</span>Profissão:</td>
                            <td colspan="3" width="85%">
                                <select style="width: 164px;" onchange="desmarcar();" disabled="disabled" name="id_profissao" id="id_profissao" <?php echo (isset($_SESSION['errosV']) && in_array('id_profissao',$_SESSION['errosV'])) ? 'class="campo_erro select"' : 'class="campo select"'; ?>>
                                    <option <?php echo $disabled; ?> value="" selected>Selecione</option>
                                    <?php
                                    $profissoes = array();
                                    $profissoes = Servicos::buscarProfissoes();
                                    foreach ($profissoes as $pro) {
                                    ?>
                                        <option <?php echo $disabled; ?> value="<?php echo $pro->id_profissao; ?>" <?php if((isset($_SESSION['errosV']) && $_SESSION['post']['id_profissao'] == $pro->id_profissao)||(isset($_SESSION['objVaga']) && ControleSessao::buscarObjeto('objVaga')->id_profissao == $pro->id_profissao)){ echo 'selected';} ?>><?php echo $pro->nm_profissao; ?></option>
                                    <?php
                                    }
                                    ?>
                                    <option <?php echo $disabled; ?> <?php if(isset($_SESSION['errosV']) && $_SESSION['post']['id_profissao'] == 'OUTRO'){ echo 'selected';} 
                                                    else if(ControleSessao::buscarObjeto('objVaga')->profissao->ao_ativo == 'V' && !is_numeric($_SESSION['post']['id_profissao'])){ echo 'selected'; }
                                                     ?> value="OUTRO">OUTRO</option>
                                </select>                                
                                <span <?php echo $disabled; ?> id="ds_outro" <?php
                                            if(isset($_SESSION['errosV']) && $_SESSION['post']['id_profissao'] != 'OUTRO'){
                                                $aux = 'style="display: none;"';
                                            }else if(ControleSessao::buscarObjeto('objVaga')->profissao->ao_ativo != 'V'){ 
                                                $aux = 'style="display: none;"';
                                            }
                                            echo $aux;?>>
                                &nbsp;&nbsp;Qual?&nbsp;&nbsp;
                                <input name="ds_outro" disabled="disabled" value="<?php if(isset($_SESSION['errosV']) && $_SESSION['post']['id_profissao'] != 'OUTRO'){
                                                                                echo $_SESSION['post']['ds_outro'];
                                                                            }else if(ControleSessao::buscarObjeto('objVaga')->profissao->ao_ativo == 'V') {
                                                                                echo ControleSessao::buscarObjeto('objVaga')->profissao->nm_profissao;
                                                                            }
                                                                            ?>"
                                        <?php echo (isset($_SESSION['errosV']) && in_array('ds_outro',$_SESSION['errosV'])) ? 'class="campo_erro"' : 'class="campo"'; ?> 
                                type="text" />
                                </span>
                                <?php if(isset($_SESSION['errosV']) && (in_array('id_profissao',$_SESSION['errosV'])||in_array('ds_outro',$_SESSION['errosV']))){ ?>
                                    <span class="style1">* Preencha corretamente este campo</span>
                                <?php } ?>
                                    <span id="ds_profissao" style="display: block; float: right; font-size: 20px; color: <?php if(ControleSessao::buscarObjeto('objVaga')->ao_ativo == 'N'){ echo "red;"; }else{ echo "#000;"; } ?>"><?php if(!empty($disabled)){ echo "<s>";} ?><?php echo Servicos::buscarProfissaoPorId($v->id_profissao)->nm_profissao; ?><?php if(!empty($disabled)){ echo "<s>";} ?></span>
                            </td>
                        </tr> 
                        <tr>
                            <td><span class="style1">*</span>Quantidade de Vagas:</td>
                            <td>
                                <input <?php echo $disabled; ?> value="<?php if(isset($_SESSION['errosV'])){ echo $_SESSION['post']['qt_vaga'];}else if(isset($_SESSION['objVaga'])){echo ControleSessao::buscarObjeto('objVaga')->qt_vaga;}?>" type="text" name="qt_vaga" id="qt_vaga" size="20" maxlength="10" onkeypress="return valida_numero(event);" <?php echo (isset($_SESSION['errosV']) && in_array('qt_vaga',$_SESSION['errosV'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                <?php 
                                if(isset($_SESSION['errosV']) && in_array('qt_vaga',$_SESSION['errosV'])){ 
                                ?>
                                    <span class="style1">* Preencha corretamente este campo</span>
                                <?php
                                }
                                ?>
                            </td>
                            <td rowspan="3" width="30%;">                                
                                <fieldset style="border: 1px solid #E4E2CD;">
                                    <legend>Gênero do Candidato</legend>
                                        <input <?php echo $disabled; ?> type="radio" name="ao_sexo" id="ao_sexo_i" value="I" <?php if(isset($_SESSION['post']) && $_SESSION['post']['ao_sexo']=='I'){echo 'checked';}else if(isset($_SESSION['objVaga']) && ControleSessao::buscarObjeto('objVaga')->ao_sexo == 'I'){ echo 'checked'; } ?> />
                                        <label class="filtro_label">Indiferente</label>

                                        <input <?php echo $disabled; ?> type="radio" name="ao_sexo" id="ao_sexo_m" value="M" <?php if(isset($_SESSION['post']) && $_SESSION['post']['ao_sexo']=='M'){echo 'checked';}else if(isset($_SESSION['objVaga']) && ControleSessao::buscarObjeto('objVaga')->ao_sexo == 'M'){ echo 'checked'; } ?> />
                                        <label class="filtro_label">Homem</label>

                                        <input <?php echo $disabled; ?> type="radio" name="ao_sexo" id="ao_sexo_f" value="F" <?php if(isset($_SESSION['post']) && $_SESSION['post']['ao_sexo']=='F'){echo 'checked';}else if(isset($_SESSION['objVaga']) && ControleSessao::buscarObjeto('objVaga')->ao_sexo == 'F'){ echo 'checked'; } ?> />
                                        <label class="filtro_label">Mulher</label>
                                        <?php 
                                        if(isset($_SESSION['errosV']) && in_array('ao_sexo',$_SESSION['errosV'])){ 
                                        ?>
                                            <span class="style1">* Preencha corretamente este campo</span>
                                        <?php
                                        }
                                        ?>                                   

                                </fieldset>
                                <br />
                                <fieldset style="border: 1px solid #E4E2CD;">
                                    <legend>Destina-se a pessoa com deficiência?</legend>
                                        <input <?php echo $disabled; ?> type="radio" name="ao_deficiente" id="ao_deficiente" value="N" <?php if(isset($_SESSION['post']) && $_SESSION['post']['ao_deficiente'] == 'N'){echo 'checked';}else if(isset($_SESSION['objVaga']) && ControleSessao::buscarObjeto('objVaga')->ao_deficiente == 'N'){echo 'checked'; } ?> /> Não                                   
                                        <input <?php echo $disabled; ?> type="radio" name="ao_deficiente" id="ao_deficiente" value="S" <?php if(isset($_SESSION['post']) && $_SESSION['post']['ao_deficiente'] == 'S'){echo 'checked';}else if(isset($_SESSION['objVaga']) && ControleSessao::buscarObjeto('objVaga')->ao_deficiente == 'S'){echo 'checked'; } ?> /> Sim
                                        <input <?php echo $disabled; ?> type="radio" name="ao_deficiente" id="ao_deficiente" value="I" <?php if(isset($_SESSION['post']) && $_SESSION['post']['ao_deficiente'] == 'I'){echo 'checked';}else if(isset($_SESSION['objVaga']) && ControleSessao::buscarObjeto('objVaga')->ao_deficiente == 'I'){echo 'checked'; } ?> /> Ambos
                                </fieldset>
                            </td>
                            <td rowspan="3" width="30%;">
                                <fieldset style="border: 1px solid #E4E2CD;">
                                    <legend>Divulgar</legend>
                                    <input <?php echo $disabled; ?> type="checkbox" id="ao_exibenome" name="ao_exibenome" value="N" onclick="marcaDivulgar();" <?php if(isset($_SESSION['post']) && $_SESSION['post']['ao_exibenome']=='S'){echo 'checked'; }else if(isset($_SESSION['objVaga']) && ControleSessao::buscarObjeto('objVaga')->ao_exibenome == 'S'){ echo 'checked'; } ?> /><label id="lnm_empresa" style="<?php if(isset($_SESSION['post']) && $_SESSION['post']['ao_exibenome']=='S'){echo 'color: #00CD00;'; }else if(isset($_SESSION['objVaga']) && ControleSessao::buscarObjeto('objVaga')->ao_exibenome == 'S'){ echo 'color: #00CD00;'; } ?>" >Nome da Empresa</label>
                                    <label class="ajudaCadVaga" title="Essas opções serão exibidas somente nos emails que vão para os candidatos.">(?)</label>
                                    <br /><br />
                                    Responsável com...
                                    <hr style="border: 1px solid #E4E2CD;">
                                    <span><input <?php echo $disabled; ?> type="checkbox" id="ao_exibetelefone" name="ao_exibetelefone" value="N" onclick="marcaDivulgar();" <?php if(isset($_SESSION['post']) && $_SESSION['post']['ao_exibetelefone']=='S'){echo 'checked';}else if(isset($_SESSION['objVaga']) && ControleSessao::buscarObjeto('objVaga')->ao_exibetelefone == 'S'){ echo 'checked'; } ?> /><label id="lnm_empresatelefone" style="<?php if(isset($_SESSION['post']) && $_SESSION['post']['ao_exibetelefone']=='S'){echo 'color: #00CD00;'; }else if(isset($_SESSION['objVaga']) && ControleSessao::buscarObjeto('objVaga')->ao_exibetelefone == 'S'){ echo 'color: #00CD00;'; } ?>">Telefone</label></span>
                                    <span><input <?php echo $disabled; ?> type="checkbox" id="ao_exibeemail" name="ao_exibeemail" value="N" style="margin-left: 50px;" onclick="marcaDivulgar();" <?php if(isset($_SESSION['post']) && $_SESSION['post']['ao_exibeemail']=='S'){echo 'checked';}else if(isset($_SESSION['objVaga']) && ControleSessao::buscarObjeto('objVaga')->ao_exibeemail == 'S'){ echo 'checked'; } ?> /><label id="lnm_empresaemail" style="<?php if(isset($_SESSION['post']) && $_SESSION['post']['ao_exibeemail']=='S'){echo 'color: #00CD00;'; }else if(isset($_SESSION['objVaga']) && ControleSessao::buscarObjeto('objVaga')->ao_exibeemail == 'S'){ echo 'color: #00CD00;'; } ?>">Email</label></span>
                                </fieldset>
                            </td>
                        </tr>                        
                        <tr>
                            <td><span class="style1">*</span>Salário: <label style="float: right;">R$</label></td>
                            <td>
                                <input <?php echo $disabled; ?> value="<?php if(isset($_SESSION['errosV'])){ echo $_SESSION['post']['nr_salario'];}else if(isset($_SESSION['objVaga'])){echo Validacao::converterMoedaPhp(ControleSessao::buscarObjeto('objVaga')->nr_salario);}?>" type="text" name="nr_salario" id="nr_salario" size="20" maxlength="10" onKeydown="FormataMoeda(this,9,event)" onkeypress="return maskKeyPress(event)" <?php echo (isset($_SESSION['errosV']) && in_array('nr_salario',$_SESSION['errosV'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                <?php 
                                if(isset($_SESSION['errosV']) && in_array('nr_salario',$_SESSION['errosV'])){ 
                                ?>
                                    <span class="style1">* Preencha corretamente este campo</span>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="height: 50px;">
                                <span class="style1">* Campos são obrigatórios</span>
                                <?php if(ControleSessao::buscarObjeto('objVaga')->ao_ativo == 'S'){ ?>
                                <span>
                                    <input type="hidden" id="ao_ativo" name="ao_ativo" value="S" />
                                    <input type="button" value="INATIVAR VAGA" class="botao" style="margin-left: 14px;" onclick="inativarVaga();" />
                                </span>
                                <?php } ?>
                            </td>                            
                        </tr>
                        <tr>
                            <td colspan="4">                                
                                <fieldset style="border: 1px solid #E4E2CD;">
                                    <legend style="color: black;">FILTROS</legend>
                                    <label>Candidatos com experiências?</label>
                                    <?php
                                        //Se a sessão do post estiver vazia então pega a sessão da vaga, 
                                        //o if serve para os selects trazerem o valor atual marcado na experiência da vaga                                    
                                        if($_SESSION['post']['ao_experiencia'] == null){                                            
                                            $experiencia = ControleSessao::buscarObjeto('objVaga')->ao_experiencia;
                                        }else{                                            
                                            $experiencia = $_SESSION['post']['ao_experiencia'];
                                        }
                                    ?>
                                    <input <?php echo $disabled; ?> type="radio" name="ao_experiencia" id="ao_experiencia" value="S" <?php if($experiencia == 'S'){echo 'checked';} ?> /> Sim
                                    <input <?php echo $disabled; ?> type="radio" name="ao_experiencia" id="ao_experiencia" value="N" <?php if($experiencia == 'N'){echo 'checked';} ?> /> Não
                                    <input <?php echo $disabled; ?> type="radio" name="ao_experiencia" id="ao_experiencia" value="I" <?php if($experiencia == 'I'){echo 'checked';} ?> /> Ambos
                                    <hr style="border: solid 1px #E4E2CD;">
                                    <br />
                                    <div style="float: left;">
                                    <?php
                                        //Se a sessão do post estiver vazia então pega a sessão da vaga, 
                                        //o if serve para os selects trazerem o valor atual marcado no estado civil da vaga
                                        if($_SESSION['post']['ds_estado_civil'] == null){
                                            $estado_civil = ControleSessao::buscarObjeto('objVaga')->ds_estado_civil;                                            
                                        }else{                                            
                                            $estado_civil = $_SESSION['post']['ds_estado_civil'];
                                        }
                                    ?>
                                    <label>Estado Civil:</label>                                    
                                    <select name="ds_estado_civil" style="margin-left: 52px; width: 165px;" id="ds_estado_civil" <?php echo (isset($_SESSION['errosV']) && in_array('ds_estado_civil',$_SESSION['errosV'])) ? 'class="campo_erro"' : 'class="campo"'; ?>>
                                        <!--<option value="" selected>Todos</option> <<< SOMENTE NO CADASTRO ISSO-->
                                        <option value="" <?php if($estado_civil == ''){echo 'selected';} ?>>Todos</option>
                                        <option value="S" <?php if($estado_civil == 'S'){echo 'selected';} ?>>Solteiro</option>
                                        <option value="C" <?php if($estado_civil == 'C'){echo 'selected';} ?>>Casado</option>
                                        <option value="V" <?php if($estado_civil == 'V'){echo 'selected';} ?>>Viúvo</option>
                                        <option value="D" <?php if($estado_civil == 'D'){echo 'selected';} ?>>Divorciado</option>
                                        <option value="P" <?php if($estado_civil == 'P'){echo 'selected';} ?>>Separado</option>
                                        <option value="O" <?php if($estado_civil == 'O'){echo 'selected';} ?>>Outros</option>
                                    </select>
                                    </div>
                                    <div style="float: left;">
                                    <?php
                                        //Se a sessão do post estiver vazia então pega a sessão da vaga, 
                                        //o if serve para os selects trazerem o valor atual marcado na idade da vaga
                                        if($_SESSION['post']['ds_idade'] == null){
                                            $idade = ControleSessao::buscarObjeto('objVaga')->ds_idade;
                                        }else{                                            
                                            $idade = $_SESSION['post']['ds_idade'];
                                        }
                                    ?>
                                    <label style="margin-left: 70px;">Idade:</label>
                                    <select name="ds_idade" onclick="escondeCNH();" style="margin-left: 15px; width: 208px;" id="ds_idade" <?php echo (isset($_SESSION['errosV']) && in_array('ds_idade',$_SESSION['errosV'])) ? 'class="campo_erro"' : 'class="campo"'; ?>>
                                        <option value="" <?php if($idade == ''){echo 'selected';} ?>>Todos</option>
                                        <option value="16" <?php if($idade == '16'){echo 'selected';} ?> >Até 16 anos (menor aprendiz)</option>
                                        <option value="18" <?php if($idade == '18'){echo 'selected';} ?> >Até 18 anos</option>
                                        <option value="25" <?php if($idade == '25'){echo 'selected';} ?> >Até 25 anos</option>
                                        <option value="30" <?php if($idade == '30'){echo 'selected';} ?> >Até 30 anos</option>
                                        <option value="40" <?php if($idade == '40'){echo 'selected';} ?> >Até 40 anos</option>
                                        <option value="50" <?php if($idade == '50'){echo 'selected';} ?> >Até 50 anos</option>
                                    </select>
                                    </div>
                                    <div style="float: left;">
                                    <?php
                                        //Se a sessão do post estiver vazia então pega a sessão da vaga, 
                                        //o if serve para os selects trazerem o valor atual marcado na idade da vaga
                                        if($_SESSION['post']['ds_cnh'] == null){
                                            $cnh = ControleSessao::buscarObjeto('objVaga')->ds_cnh;
                                        }else{                                            
                                            $cnh = $_SESSION['post']['ds_cnh'];
                                        }
                                        
                                        if(($idade == '') || ($idade == '25') || ($idade == '30') || ($idade == '40') || ($idade == '50')){
                                            $idadedisplay = 'block';
                                        }else{
                                            $idadedisplay = 'none';
                                        }
                                    ?>    
                                        
                                    <label id="lb_cnh" style="margin-left: 18px; margin-top: 10px; float: left; display: <?php echo $idadedisplay; ?>;">CNH:</label>
                                    <select id="ds_cnh" name="ds_cnh" id="ds_cnh" class="campo" style="float: left; margin-left: 5px; display: <?php echo $idadedisplay; ?>;" >
                                        <option value="" <?php if($cnh == ''){echo 'selected';} ?>>Indiferente</option>
                                        <option value="ACC" <?php if($cnh == 'ACC'){echo 'selected';} ?>>ACC</option>
                                        <option value="A" <?php if($cnh == 'A'){echo 'selected';} ?>>A</option>
                                        <option value="B" <?php if($cnh == 'B'){echo 'selected';} ?>>B</option>
                                        <option value="C" <?php if($cnh == 'C'){echo 'selected';} ?>>C</option>
                                        <option value="D" <?php if($cnh == 'D'){echo 'selected';} ?>>D</option>
                                        <option value="E" <?php if($cnh == 'E'){echo 'selected';} ?>>E</option>
                                        <option value="AB" <?php if($cnh == 'AB'){echo 'selected';} ?>>AB</option>
                                        <option value="AC" <?php if($cnh == 'AC'){echo 'selected';} ?>>AC</option>
                                        <option value="AD" <?php if($cnh == 'AD'){echo 'selected';} ?>>AD</option>
                                        <option value="AE" <?php if($cnh == 'AE'){echo 'selected';} ?>>AE</option>
                                    </select>
                                    
                                    </div>
                                    <br /><br />
                                </fieldset>
                            </td>
                        </tr>                        
                        <tr>
                            <td colspan="4">
                                <fieldset style="border: 1px solid #E4E2CD;">
                                    <legend style="color: black;">FORMAÇÃO</legend>
                                    <?php
                                        //busco todos as formações do banco
                                        $formacao = Servicos::buscarFormacoes();
                                        
                                        //adiciono a uma variável o id da vaga
                                        $formacaovaga = ControleSessao::buscarObjeto('objVaga')->id_vaga;
                                        
                                        foreach ($formacao as $f) {
                                            //busco as formações daquela vaga e jogo numa variável para comparar depois no input se ela está vazia ou não, se sim marca ckecked.
                                            $temformacaovaga = Servicos::buscarVagaFormacaoPorIdVaga($formacaovaga, $f->id_formacao);
                                    ?>
                                        <span style="float: left; padding: 5px; width: 210px;">
                                            <input <?php echo $disabled; ?> type="checkbox" id="ao_formacao_<?php echo $f->id_formacao; ?>" name="ao_formacao[]" value="<?php echo $f->id_formacao; ?>" onclick="marcaFormacao(<?php echo $f->id_formacao; ?>);" <?php if(!empty($temformacaovaga)){ echo 'checked';} ?> />
                                            <label id="lformacao_<?php echo $f->id_formacao; ?>" style="color: <?php if(!empty($temformacaovaga)){ echo '#EE7228;';} ?>" ><?php echo $f->nm_formacao; ?></label>
                                        </span>
                                    <?php
                                        }                                
                                        
                                        if(isset($_SESSION['errosV']) && in_array('id_formacao',$_SESSION['errosE'])){ 
                                    ?>
                                        <span class="style1">* Preencha corretamente este campo</span>
                                    <?php
                                        }
                                    ?>
                                </fieldset>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <br />
                                <hr style="border: solid 1px #EE7228;">
                                <br />
                            </td>
                        </tr>
                        <tr>                           
                            <td colspan="4">                                
                                <fieldset style="border: 1px solid #E4E2CD;">
                                    <legend style="color: black;">ADICIONAIS</legend>
                                    <?php
                                        //busco todos os adicionais do banco
                                        $adicionais = Servicos::buscarAdicional();
                                        
                                        //adiciono a uma variável o id da vaga
                                        $adicionaisvaga = ControleSessao::buscarObjeto('objVaga')->id_vaga;
                                        
                                        foreach ($adicionais as $a) {
                                            //busco os adicionais daquela vaga e jogo numa variável para comparar depois no input se ele está vazia ou não, se sim marca ckecked.
                                            $temadicionalvaga = Servicos::buscarVagaAdicionalPorIdVaga($adicionaisvaga, $a->id_adicional);
                                    ?>
                                        <span style="float: left; padding: 5px; width: 210px;">
                                            <input <?php echo $disabled; ?> type="checkbox" id="ao_adicional_<?php echo $a->id_adicional; ?>" name="ao_adicional[]" value="<?php echo $a->id_adicional; ?>" onclick="marcaAdicional(<?php echo $a->id_adicional; ?>);" <?php if(!empty($temadicionalvaga)){ echo 'checked';} ?> />
                                            <label id="ladicional_<?php echo $a->id_adicional; ?>" style="color: <?php if(!empty($temadicionalvaga)){ echo '#EE7228;';} ?>" ><?php echo $a->nm_adicional; ?></label>
                                        </span>
                                    <?php
                                        }                                
                                        
                                        if(isset($_SESSION['errosV']) && in_array('id_adicional',$_SESSION['errosE'])){ 
                                    ?>
                                        <span class="style1">* Preencha corretamente este campo</span>
                                    <?php
                                        }
                                    ?>
                                </fieldset>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <br />
                                <fieldset style="border: 1px solid #E4E2CD;">
                                    <legend style="color: black;">BENEFÍCIOS</legend>
                                    <?php
                                        //busco todos os benefícios do banco
                                        $beneficios = Servicos::buscarBeneficio();
                                        
                                        //adiciono a uma variável o id da vaga
                                        $beneficiosvaga = ControleSessao::buscarObjeto('objVaga')->id_vaga;
                                        
                                        foreach ($beneficios as $b) {
                                            //busco os benefícios daquela vaga e jogo numa variável para comparar depois no input se ele está vazia ou não, se sim marca ckecked.
                                            $tembeneficiovaga = Servicos::buscarVagaBeneficioPorIdVaga($adicionaisvaga, $b->id_beneficio);
                                    ?>
                                        <span style="float: left; padding: 5px; width: 210px;">
                                            <input <?php echo $disabled; ?> type="checkbox" id="ao_beneficio_<?php echo $b->id_beneficio; ?>" name="ao_beneficio[]" value="<?php echo $b->id_beneficio; ?>" onclick="marcaBeneficio(<?php echo $b->id_beneficio; ?>);" <?php if(!empty($tembeneficiovaga)){ echo 'checked';} ?> />
                                            <label id="lbeneficio_<?php echo $b->id_beneficio; ?>" style="color: <?php if(!empty($tembeneficiovaga)){ echo '#EE7228;';} ?>"><?php echo $b->nm_beneficio; ?></label>
                                        </span>
                                    <?php
                                        }                                
                                        
                                        if(isset($_SESSION['errosV']) && in_array('id_beneficio',$_SESSION['errosE'])){ 
                                    ?>
                                        <span class="style1">* Preencha corretamente este campo</span>
                                    <?php
                                        }
                                    ?>
                                </fieldset>
                                <br />
                            </td>
                        </tr>
                        <tr>                            
                            <td colspan="4">
                                <div style="width:50%; float: left;">
                                    <label style="color: black;">ATRIBUIÇÃO:</label>
                                    <textarea <?php echo $disabled; ?> style="width:99%; font-family: Arial,sans-serif;	" name="ds_atribuicao" id="ds_atribuicao" placeholder="Digite aqui a descrição da vaga..." rows="10" <?php echo (isset($_SESSION['errosV']) && in_array('ds_atribuicao',$_SESSION['errosV'])) ? 'class="campo_erro"' : 'class="campo"'; ?>><?php if(isset($_SESSION['errosV'])){ echo $_SESSION['post']['ds_atribuicao'];} elseif(isset($_SESSION['objVaga'])){ echo ControleSessao::buscarObjeto('objVaga')->ds_atribuicao;} ?></textarea>                                    
                                    <?php 
                                    if(isset($_SESSION['errosV']) && in_array('ds_atribuicao',$_SESSION['errosV'])){ 
                                    ?>
                                        <span class="style1">* Preencha corretamente este campo</span>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div style="width:50%; float: left;">
                                    <label style="margin-left: 4px; color: black;">OBSERVAÇÃO</label>
                                    
                                    <?php
                                        //atribuo nas variáveis os adicionais e benefícios antigos quando eram pra digitação livre para poder mostrar no campo observação e não se perder essas informações.
                                        $adicionaisantigos = ControleSessao::buscarObjeto('objVaga')->ds_adicional;
                                        $beneficiosantigos = ControleSessao::buscarObjeto('objVaga')->ds_beneficio;
                                        
                                        //Monto a estrutura
                                        $adicionaisantigosobs = "Adicionais:\n\n".$adicionaisantigos."\n----------------------------------------------------------\n\n";
                                        $beneficiosantigosobs = "Benefícios:\n\n".$beneficiosantigos."\n----------------------------------------------------------\n\n";
                                    
                                    ?>
                                    <textarea <?php echo $disabled; ?> style="width: 99%; font-family: Arial,sans-serif; float: right;" name="ds_observacao" id="ds_observacao" placeholder="Digite aqui alguma observação referente a vaga caso tenha..." rows="10" <?php echo (isset($_SESSION['errosV']) && in_array('ds_observacao',$_SESSION['errosV'])) ? 'class="campo_erro"' : 'class="campo"'; ?>><?php if(!empty($adicionaisantigos)){ echo $adicionaisantigosobs;} if(!empty($beneficiosantigos)){ echo $beneficiosantigosobs;} ?><?php if(isset($_SESSION['errosV'])){ echo $_SESSION['post']['ds_observacao'];} elseif(isset($_SESSION['objVaga'])){ echo ControleSessao::buscarObjeto('objVaga')->ds_observacao;} ?></textarea>
                                        
                                      
                                    <?php 
                                    
                                    if(isset($_SESSION['errosV']) && in_array('ds_observacao',$_SESSION['errosV'])){ 
                                    ?>
                                        <span class="style1">* Preencha corretamente este campo</span>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <br />
                                <hr style="border: 1px solid #E4E2CD;">
                            </td>
                        </tr>
                        <tr>                            
                            <td colspan="4" style="text-align: center;">
                                <input <?php echo $disabled; ?> class="botao" type="submit" value="<?php if(ControleSessao::buscarObjeto('objVaga')->ao_ativo == 'N'){ echo 'VAGA INATIVADA'; }else{ echo 'ATUALIZAR VAGA';} ?>" />
                            </td>
                        </tr>
                    </table>
                </fieldset>                        
            </form>
        </div>        
        <!-- #######################################TODOS CANDIDATOS####################################### -->
        <div id="parte-02">
            <div id="loading" align="center" style="display: none;">
                <div id="aguarde" style="background-color:#ffffff;position:absolute;color:#000033;top:50%;left:30%;border:2px solid #cccccc; width:300;font-size:12px;z-index:0;">
                    <br><img src="../../../Utilidades/Imagens/bancodeoportunidades/loading.gif" border="0" align="middle"> Aguarde! Carregando Dados...<br><br>
                </div>
            </div>
            <fieldset>
                <legend class="legend">Filtro</legend>                
                <form name="filtro" id="filtroVaga" method="post" action="../controle/ControleVaga.php?op=pesquisarTodos">
                    <div>                        
                        <table class="tabela_relatorio" border="0" style="margin-bottom: -20px;">
                            <tr>                                
                                <td colspan="3" style="width: 300px;" class="filtro_todos">                                    
                                    <input type="hidden" name="filtro_status" id="filtro_status" value="" />
                                    <?php //Passando os campos pra busca para poder retonar na sessão. ?>
                                    <input type="hidden" name="encaminhados" id="encaminhadosT" value="<?php echo $totalEncaminhados; ?>" />
                                    <input type="hidden" name="baixasAutomaticas" id="baixasAutomaticasT" value="<?php echo $totalBaixasAutomaticas; ?>" />
                                    <input type="hidden" name="preSelecionados" id="preSelecionadosT" value="<?php echo $totalPreSelecionados; ?>" />
                                    <input type="hidden" name="contratados" id="contratadosT" value="<?php echo $totalContratados;?>" />
                                    <input type="hidden" name="dispensados" id="dispensadosT" value="<?php echo $totalDispensandos; ?>" />
                                    <div style="float: left;">
                                        <label class="filtro_label">Código:</label>                                        
                                        <input value="<?php if(isset($_SESSION['post'])){echo $_SESSION['post']['filtro_codigo_todos'];} ?>" type="text" name="filtro_codigo" id="filtro_codigo_todos" class="campo largura" style="width: 70px;" onkeypress="document.getElementById('filtro_nome_todos').value = ''; return valida_numero(event);" />
                                    
                                        <label class="filtro_label">Nome:</label>                                        
                                        <input value="<?php if(isset($_SESSION['post'])){echo $_SESSION['post']['filtro_nome_todos'];} ?>" type="text" name="filtro_nome" id="filtro_nome_todos" class="campo largura" style="width: 150px;" onkeypress="document.getElementById('filtro_codigo_todos').value = ''; return bloqueia_numeros(event);" />
                                    
                                        <input type="submit" name="buscar" value="Buscar" class="botao"/>
                                        
                                        <?php 
                                            if(isset($_SESSION['errosTodos']) && in_array('filtro_codigo',$_SESSION['errosTodos'])){ 
                                        ?>
                                        <span class="style1"><b>* Valor digitado inválido! Somente números.</b></span>
                                        <?php
                                            }
                                        ?>
                                        
                                        <?php 
                                            if(isset($_SESSION['errosTodos']) && in_array('filtro_nome',$_SESSION['errosTodos'])){ 
                                        ?>
                                        <span class="style1"><b>* Valor digitado inválido! Somente letras.</b></span>
                                        <?php
                                            }
                                        ?>
                                    </div> 
                                </td>
                                <td colspan="2" align="right">
                                    <?php
                                        echo "<b>".Servicos::buscarProfissaoPorId($v->id_profissao)->nm_profissao."</b></br>(".$mostraQtdVaga.")";                                    
                                    ?>
                                </td>                            
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <hr style="border: 1px solid #EE7228;">
                                </td>
                            </tr>                            
                            <tr class="filtro_label">
                                <td align="center" style="width: 20%;"><b>Encaminhados:</b> <span id="totalEncaminhados"><?php echo $totalEncaminhados; ?></span></td>
                                <td align="center" style="width: 20%;"><b>Baixas Automáticas:</b> <span id="totalBaixasAutomaticas"><?php echo $totalBaixasAutomaticas; ?></span></td>
                                <td align="center" style="width: 20%;"><b>Pré-Selecionados:</b> <span id="totalPreSelecionados"><?php echo $totalPreSelecionados; ?></span></td>
                                <td align="center" style="width: 20%;"><b>Contratados:</b> <span id="totalContratados"><?php echo $totalContratados;?></span></td>
                                <td align="center" style="width: 20%;"><b>Dispensados:</b> <span id="totalDispensados"><?php echo $totalDispensandos; ?></span></td>
                            </tr>
                        </table>                        
                    </div>
                    <div>                                                
                    </div>
                </form>
            </fieldset>            
            <div class="tab_adiciona" <?php echo (!ControleSessao::buscarObjeto('objVaga')->todos) ? 'style="padding-bottom: 100px;"' : ''; ?>>
                <?php
                
                if(ControleSessao::buscarObjeto('objVaga')->todos){
                    
                    include_once '../modelo/VagaCandidatoVO.class.php';                    
                    if(count(ControleSessao::buscarObjeto('objVaga')->todos)>0){
                        //define a quantidade de resultados da lista
                        $qtd = 10;
                        //busca a page atual
                        $page = (isset($_GET['pg'])) ? $_GET['pg'] : 0;
                        //recebo um novo array com apenas os elemento necessarios para essa page atual
                        $todosCandidatos = Servicos::listar(ControleSessao::buscarObjeto('objVaga')->todos, $qtd, $page);
                        

                        ?>
                        <div>                            
                            <form id="formImprimir" name="formImprimir" method="post" action="../controle/ControleVaga.php?op=imprimir">
                                <div style="float: left; padding: 3px; cursor: pointer;"><img onclick="atualizaListaTodos(<?php echo ControleSessao::buscarObjeto('objVaga')->id_vaga; ?>);" onMouseOver="this.src='../../../Utilidades/Imagens/bancodeoportunidades/refresh-a.png';" onMouseOut="this.src='../../../Utilidades/Imagens/bancodeoportunidades/refresh.png'" id="imagemrefreshTodos" src="../../../Utilidades/Imagens/bancodeoportunidades/refresh.png" style="width: 25px;" title="Atualizar a lista de candidatos"></div>
                                <div class="botao_lista" >
                                    <input type="hidden" name="id_vaga" value="<?php 
                                        $v = ControleSessao::buscarObjeto('objVaga');
                                        echo $v->id_vaga; ?>">
                                    <input <?php echo $disabled; ?> type="submit" name="lista" value="Imprimir Lista" class="botao"/>                                    
                                </div>
                            </form>
                            <!--<form id="formImprimir" name="formImprimir" method="post" action="../controle/ControleVaga.php?op=imprimirCurriculos">-->
                                <!--<div class="botoes_imprimir" align="right">
                                    <input type="submit" value="Imprimir Currículo" class="botao"/>
                                    <label class="filtro_label">Marcar Todos</label>
                                    <input type="checkbox" name="imprimirTodos" id="todos" value="" onclick="marcardesmarcar();">
                                </div>-->
                            <!--</form>-->
                            
                            <?php if(isset($_SESSION['msgImp'])){ ?>
                                <span class="msg" style="margin-left: 565px;"><?php echo ControleSessao::buscarVariavel('msgImp'); ?></span>
                            <?php } ?>
                                <div id="tabela_todos_div"></div>
                            <table width="100%" id="tabela_todos" border="0" class="tabela_encaminhados">
                                <tr class="table_formacao_cab">
                                    <td align='center' width="5%">Código</td>
                                    <td align='center' width="28%">Nome</td>
                                    <td align='center' width="10%">Telefone</td>
                                    <td align='center' width="25%">Email</td>
                                    <td align='center' width="12%">Status</td>
                                    <td align='center' width="5%">Histórico</td>
                                    <td align='center' width="5%">Visualizar</td>
                                    <td align='center' width="5%">Imprimir</td>
                                </tr>
                                <?php
                                $cont=0;
                                $contastatusE = 0;
                                                                
                                foreach($todosCandidatos as $vc){                                    
                                    if($vc->ao_status == 'E'){
                                        $contastatusE++;
                                    }
                                    
                                    if(!Validacao::validarNulo($vc)){ 
                                    $cont++;                                    
                                ?>
                                    <form name="formSinalizar" id="formSinalizar_<?php echo $vc->id_candidato; ?>" method="post" action="../controle/ControleVaga.php?op=sinalizar" />
                                    <tr class="tabela_linha_todos" id="linha_pre_t_<?php echo $vc->id_vagacandidato; ?>">
                                            <td align="center"><?php echo $vc->id_candidato; ?></td>
                                            <td>                                                
                                                <label style="color: black; font-weight: bold;"><?php echo $vc->nm_candidato; ?></label><br />                                                
                                                <?php
                                                    //Mostra a deficiência caso o candidato tenha.
                                                    if(!is_null($vc->id_deficiencia)){
                                                        if($vc->ao_sexo == "M"){
                                                            $sexoTodos = "Candidato";
                                                        }else{
                                                            $sexoTodos = "Candidata";
                                                        }
                                                        $deficienciaTodos = "(".$sexoTodos." com deficiência <b>".Servicos::buscarDeficienciaPorId($vc->id_deficiencia)."</b>)";
                                                    }else{
                                                        $deficienciaTodos = "";
                                                    }
                                                ?>
                                                <i><?php echo $deficienciaTodos; ?></i>
                                            </td>                
                                            <td style="text-align: center;">                                                
                                                <?php
                                                    $telefone = $vc->nr_telefone;
                                                    if(!empty($telefone)){ 
                                                        echo $telefone;
                                                    }else{
                                                        echo $vc->nr_celular;
                                                    }
                                                ?>
                                            </td>
                                            <td><?php echo $vc->ds_email; ?></td>
                                            <td align="left">                                                
                                                <?php if($vc->ao_status == 'E'){ ?>
                                                
                                                
                                                <div id="pre_t_<?php echo $vc->id_vagacandidato; ?>">
                                                    <input <?php echo $disabled; ?> id="candidato_E_todos_<?php echo $vc->id_candidato; ?>" name="<?php echo $vc->id_candidato; ?>" type="radio" value="E" onclick="alterarStatus('E','<?php echo $vc->id_vagacandidato; ?>', 'E'); ocultarSelectMotivos('<?php echo $vc->id_candidato; ?>');" checked disabled />Encaminhado<br>
                                                    <input <?php echo $disabled; ?> id="candidato_P" name="<?php echo $vc->id_candidato; ?>" type="radio" value="P" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'P')||($vc->ao_status == 'P')) echo 'checked'; ?> onclick="if(confirm('Enviar email para o candidato <?php echo $vc->nm_candidato; ?> como pré-selecionado?')){                                                                                                                                                                                                                                                                                                                                                    
                                                                                                                                                                                                                                                                                                                                                    alterarStatus('E','<?php echo $vc->id_vagacandidato; ?>', 'P', '<?php echo $vc->id_vaga; ?>', '<?php echo $_SESSION['id_usuario']; ?>');                                                                                                                                                                                                                                                                                                                                                    
                                                                                                                                                                                                                                                                                                                                                    ocultarSelectMotivos('<?php echo $vc->id_candidato; ?>');
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
                                                                                                                                                                                                                                                                                                                                                }else{
                                                                                                                                                                                                                                                                                                                                                    document.getElementById('candidato_E_todos_<?php echo $vc->id_candidato; ?>').checked = true;
                                                                                                                                                                                                                                                                                                                                                }" />Pré-selecionado<br>
                                                    <input <?php echo $disabled; ?> id="candidato_C" name="<?php echo $vc->id_candidato; ?>" type="radio" value="C" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'C')||($vc->ao_status == 'C')) echo 'checked'; ?> onclick="if(confirm('Contratar candidato?')){
                                                                                                                                                                                                                                                                                        alterarStatus('E','<?php echo $vc->id_vagacandidato; ?>', 'C', '<?php echo $vc->id_vaga; ?>', '<?php echo $_SESSION['id_usuario']; ?>'); 
                                                                                                                                                                                                                                                                                        ocultarSelectMotivos('<?php echo $vc->id_candidato; ?>');
                                                                                                                                                                                                                                                                                        
                                                                                                                                                                                                                                                                                    }else{                                                                                                                                                                                                                                                                                        
                                                                                                                                                                                                                                                                                        document.getElementById('candidato_E_todos_<?php echo $vc->id_candidato; ?>').checked = true;
                                                                                                                                                                                                                                                                                    }" />Contratado<br>
                                                    <input <?php echo $disabled; ?> id="candidato_D" name="<?php echo $vc->id_candidato; ?>" type="radio" value="D" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'D')||($vc->ao_status == 'D')) echo 'checked'; ?> onclick="mostrarSelectMotivos('<?php echo $vc->id_candidato; ?>', 'E');" />Dispensado
                                                </div>
                                                <div id="div_p_<?php echo $vc->id_vagacandidato; ?>" style="display: none;">
                                                        <input id="candidato_P_todos_<?php echo $vc->id_candidato; ?>" name="pre<?php echo $vc->id_candidato; ?>" type="radio" value="P" checked disabled />Pré-selecionado<br>
                                                        <input <?php echo $disabled; ?> id="candidato_C" name="pre<?php echo $vc->id_candidato; ?>" type="radio" value="C" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'C')||($vc->ao_status == 'C')) echo 'checked'; ?> onclick="if(confirm('Contratar candidato?')){                                                                                                                                                                                                                                                                                            
                                                                                                                                                                                                                                                                                            alterarStatus('P','<?php echo $vc->id_vagacandidato; ?>', 'C', '<?php echo $vc->id_vaga; ?>', '<?php echo $_SESSION['id_usuario']; ?>');                                                                                                                                                                                                                                                                                            
                                                                                                                                                                                                                                                                                            ocultarSelectMotivos('<?php echo $vc->id_candidato; ?>');                                                                                                                                                                                                                                                                                             
                                                                                                                                                                                                                                                                                        }else{                                                                                                                                                                                                                                                                                             
                                                                                                                                                                                                                                                                                             document.getElementById('candidato_P_todos_<?php echo $vc->id_candidato; ?>').checked = true;
                                                                                                                                                                                                                                                                                        }" />Contratado<br>
                                                        <input id="candidato_D" name="pre<?php echo $vc->id_candidato; ?>" type="radio" value="D" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'D')||($vc->ao_status == 'D')) echo 'checked'; ?> onclick="mostrarSelectMotivos('<?php echo $vc->id_candidato; ?>', 'P');"/>Dispensado
                                                </div>
                                                <?php
                                                }else{
                                                    if($vc->ao_status == 'C'){
                                                        echo 'Contratação já sinalizada';                                                        
                                                    }else if($vc->ao_status == 'D'){ 
                                                        echo 'Dispensa já sinalizada';                                                        
                                                    }else if($vc->ao_status == 'B'){
                                                        echo 'Baixa automática';
                                                    }else if($vc->ao_status == 'P'){ ?>
                                                        <div id="div_p2_<?php echo $vc->id_vagacandidato; ?>">
                                                            <input id="candidato_P_todos_<?php echo $vc->id_candidato; ?>" name="<?php echo $vc->id_candidato; ?>" type="radio" value="P" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'P')||($vc->ao_status == 'P')) echo 'checked'; ?> disabled />Pré-selecionado<br>
                                                            <input <?php echo $disabled; ?> id="candidato_C" name="<?php echo $vc->id_candidato; ?>" type="radio" value="C" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'C')||($vc->ao_status == 'C')) echo 'checked'; ?> onclick="if(confirm('Contratar candidato?')){                                                                                                                                                                                                                                                                                            
                                                                                                                                                                                                                                                                                            alterarStatus('P','<?php echo $vc->id_vagacandidato; ?>', 'C', '<?php echo $vc->id_vaga; ?>', '<?php echo $_SESSION['id_usuario']; ?>');                                                                                                                                                                                                                                                                                            
                                                                                                                                                                                                                                                                                            ocultarSelectMotivos('<?php echo $vc->id_candidato; ?>');                                                                                                                                                                                                                                                                                             
                                                                                                                                                                                                                                                                                        }else{                                                                                                                                                                                                                                                                                             
                                                                                                                                                                                                                                                                                             document.getElementById('candidato_P_todos_<?php echo $vc->id_candidato; ?>').checked = true;
                                                                                                                                                                                                                                                                                        }" />Contratado<br>
                                                            <input id="candidato_D" name="<?php echo $vc->id_candidato; ?>" type="radio" value="D" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'D')||($vc->ao_status == 'D')) echo 'checked'; ?> onclick="mostrarSelectMotivos('<?php echo $vc->id_candidato; ?>', 'P');"/>Dispensado
                                                        </div>
                                                <?php 
                                                    }
                                                }
                                                ?>
                                                  
                                            </td>                                            
                                            <?php 
                                            $historico = Servicos::verificarHistoricoCandidato($vc->id_candidato, ControleSessao::buscarObjeto('privateEmp')->id_empresa);
                                            if($historico>0){ 
                                            ?>
                                                <td align='center'>
                                                    <img src='../../../Utilidades/Imagens/bancodeoportunidades/historico.png' width="28" onclick="abrirHistoricoCandidatoTodos('dadosHistoricoSelecionadoTodos_<?php echo $vc->id_vagacandidato; ?>');" value="" title="Visualizar histórico de <?php echo $vc->nm_candidato; ?>" style="cursor: pointer;" />
                                                </td>
                                            <?php 
                                            }else{ 
                                            ?>
                                                <td align='center'>
                                                    <img src='../../../Utilidades/Imagens/bancodeoportunidades/historico_disabled.png' title='Candidato sem histórico' width="28" />
                                                </td>
                                            <?php 
                                            } 
                                            ?>
                                            <td align='center'>
                                                <input type="button" class="btn_visualizar" onclick="abrirDadosCandidatoTodos('dadosCandidatoSelecionadoTodos_<?php echo $vc->id_candidato; ?>');" value="" title="Visualizar currículo de <?php echo $vc->nm_candidato; ?>" />
                                            </td>
                                            <!--<td align="center">
                                                <input type="checkbox" class="marcar" id="pag_perfil" name="imprimir[]" value="<?php //echo $vc->id_candidato; ?>" />
                                            </td>-->
                                            <td align="center">
                                                <input <?php echo $disabled; ?> type="submit" name="imprimir" value="" class="btn_imprimir" title="Imprimir currículo de <?php echo $vc->nm_candidato; ?>" />
                                                <input type="hidden" name="id_candidato" id="id_candidato" value="<?php echo $vc->id_candidato; ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" id="candidato_<?php echo $vc->id_candidato; ?>" style="display: none;">
                                                <div>
                                                   <span class="style1" style="float: left; margin-top: 5px; margin-right: 3px;">*</span>
                                                   <span style="color: white;">
                                                        Motivo:
                                                       <select onchange="mostrarCampoMotivoDispensa(<?php echo $vc->id_candidato; ?>);" name="id_motivo" id="id_motivo_<?php echo $vc->id_candidato; ?>" <?php echo (isset($_SESSION['errosTodos']) && in_array('id_motivo',$_SESSION['errosTodos'])) ? 'class="campo_erro select"' : 'class="campo select"'; ?>>
                                                        <option value="Selecione">Selecione</option>
                                                            <?php
                                                            $motivos = Servicos::buscarMotivos();
                                                            foreach($motivos as $m){
                                                            ?>
                                                                <option value="<?php echo $m->id_motivo; ?>" <?php if(isset($_SESSION['errosTodos']) && (isset($_SESSION['post']['id_motivo']) && $_SESSION['post']['id_motivo'] == $m->id_motivo)) { echo 'selected';} ?> ><?php echo $m->ds_motivo; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                            <option value="Outros">Outros</option>
                                                        </select>
                                                        <?php echo Servicos::verificarErro('errosTodos', 'id_motivo', '* Selecione um dado.'); ?>
                                                   </span>
                                                   
                                                   <span id="mostrarMotivo_<?php echo $vc->id_candidato; ?>" style="display: none; margin-left: 40px; color: white;">
                                                       Descrição Motivo:
                                                       <input style="width: 305px;" value="<?php if(isset($_SESSION['errosTodos'])){ echo $_SESSION['post']['ds_motivo']; } ?>" type="text" name="ds_motivo" id="ds_motivo_<?php echo $vc->id_candidato; ?>" maxlength="500" <?php echo (isset($_SESSION['errosTodos']) && in_array('ds_motivo',$_SESSION['errosTodos'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                                       <?php echo Servicos::verificarErro('errosTodos', 'ds_motivo'); ?>
                                                   </span>                                                   
                                                   
                                                   <span id="inputEnviar_<?php echo $vc->id_candidato; ?>" style="display: none;">
                                                       <?php //Se o dispensar vier direto do E, recebe E para decrementar nos encaminhados e mostra o enviarMotivo_E_, se vier do P, recebe P e decrementa do P e mostra o enviarMotivo_P_. ?>
                                                       <input style="margin-top: 3px;" <?php echo $disabled; ?> id="enviarMotivo_E_<?php echo $vc->id_candidato; ?>" name="enviarMotivo" type="button" value="Enviar" class="botao" onclick="if(confirm('Tem certeza que deseja dispensar o candidato <?php echo $vc->nm_candidato; ?>?')){verificarSelect('E','<?php echo $vc->id_candidato; ?>', '<?php echo $vc->id_vagacandidato; ?>', 'D', '<?php echo $vc->id_vaga; ?>', '<?php echo $_SESSION['id_usuario']; ?>');}else{ document.getElementById('candidato_E_todos_<?php echo $vc->id_candidato; ?>').checked = true; ocultarSelectMotivos('<?php echo $vc->id_candidato; ?>'); return false; }" />
                                                       <input style="margin-top: 3px;" <?php echo $disabled; ?> id="enviarMotivo_P_<?php echo $vc->id_candidato; ?>" name="enviarMotivo" type="button" value="Enviar" class="botao" onclick="if(confirm('Tem certeza que deseja dispensar o candidato <?php echo $vc->nm_candidato; ?>?')){verificarSelect('P','<?php echo $vc->id_candidato; ?>', '<?php echo $vc->id_vagacandidato; ?>', 'D', '<?php echo $vc->id_vaga; ?>', '<?php echo $_SESSION['id_usuario']; ?>');}else{ document.getElementById('candidato_P_todos_<?php echo $vc->id_candidato; ?>').checked = true; ocultarSelectMotivos('<?php echo $vc->id_candidato; ?>'); return false; }" />
                                                       <input type="hidden" name="id_vagacandidato" id="id_vagacandidato" value="<?php echo $vc->id_vagacandidato; ?>">
                                                   </span>                                                   
                                                </div>                                                
                                            </td>
                                        </tr>                                        
                                    </form>
                                <?php
                                    }
                                }
                                ?>
                                <tr>                                    
                                    <td colspan="8">
                                        <table width="100%">
                                            <tr>
                                                <td class="cont_pagina" width="5%">
                                                    <?php 
                                                        $total = count(ControleSessao::buscarObjeto('objVaga')->todos);

                                                        echo ($page * $qtd + $cont).'/'.$total;                                                        
                                                        
                                                    ?>                                                    
                                                </td>
                                                <td id="paginacao" align="center" width="95%">
                                                    <input type="hidden" id="conta_encaminhados_todos_enc" value="<?php echo $contastatusE; ?>" />
                                                    <input type="hidden" id="get_encaminhados_todos_enc" value="<?php echo $page; ?>" />
                                                    <?php
                                                        if($contastatusE == '0'){
                                                            $mostraPaginacaoFalsa = "none;";
                                                            $mostraPaginacaoCerta = "block;";
                                                        }else{
                                                            $mostraPaginacaoFalsa = "block;";
                                                            $mostraPaginacaoCerta = "none;";
                                                        }
                                                    ?>
                                                    <div id="paginacaoFalsaTodos" style="display: <?php echo $mostraPaginacaoFalsa; ?>">
                                                        <?php
                                                            //crio a paginacao propriamente dita
                                                            echo Servicos::criarPaginacaoFalsa(ControleSessao::buscarObjeto('objVaga')->todos, $qtd, $page,'#parte-02');
                                                        ?>
                                                    </div>
                                                    <div id="paginacaoCertaTodos" style="display: <?php echo $mostraPaginacaoCerta; ?>">
                                                        <?php
                                                            //crio a paginacao propriamente dita
                                                            echo Servicos::criarPaginacaoTodos(ControleSessao::buscarObjeto('objVaga')->todos, $qtd, $page,'#parte-02');
                                                        ?>
                                                    </div>                                                    
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                                
                            <?php if(ControleSessao::buscarObjeto('objVaga')->ao_ativo == 'S'){ ?>
                            <div align="right">
                                <br/>
                                <span class="msg">
                                    <?php if(isset($_SESSION['msgEn']))echo ControleSessao::buscarVariavel('msgEn'); ?>
                                </span>
                                <!--<input class="botao" name="registrar" type="submit" value="Registrar" />-->                                    
                            </div>      
                            <?php } ?>                           
                        </div>
                    <?php } ?>                        
                <?php                    
                }else{
                ?>
                <br />
                <div style="width: 100%; float: left; padding: 3px; cursor: pointer;"><img onclick="atualizaListaTodos(<?php echo ControleSessao::buscarObjeto('objVaga')->id_vaga; ?>);" onMouseOver="this.src='../../../Utilidades/Imagens/bancodeoportunidades/refresh-a.png';" onMouseOut="this.src='../../../Utilidades/Imagens/bancodeoportunidades/refresh.png'" id="imagemrefreshTodos" src="../../../Utilidades/Imagens/bancodeoportunidades/refresh.png" style="width: 25px;" title="Atualizar a lista de candidatos"></div>
                <div id="tabela_todos_div_pesq"></div>
                <table id="tabela_todos_pesq" width="100%" class='tabela_encaminhados'>
                    <tr class='table_formacao_cab'>
                        <td>&nbsp;</td>
                    </tr>
                    <tr class='table_formacao_row'>
                        <td style='height: 300px;'>
                            <center>
                                <b style="font-size: 20px;">
                                    <?php                                
                                        if(ControleSessao::buscarObjeto('objVaga')->pesqTodos){
                                            echo "Não há resultados para sua busca por candidatos!";
                                        }else{
                                            echo "Não há candidatos para esta vaga";
                                        }
                                    ?>
                                </b>
                            </center>
                        </td>
                    </tr>
                </table>                
                <?php
                }
                ?>
            </div>
            
            <?php // echo Servicos::montarHistoricoCandidato(617, 96); ?>
            
            <?php 
            //$x=0;            
            
            foreach($todosCandidatos as $vc){
                
                //if(!Validacao::validarNulo($vc)){
                //$x++; 
            ?>
                <!--Aba de visualizar curriculos-->
                <div colspan="4" class="white_content_candidato_todos selecionados" id="dadosCandidatoSelecionadoTodos_<?php echo $vc->id_candidato; ?>">
                    <div id="dadosCandidatoTodos">
                        <?php echo Servicos::buscarDadosCandidatoPorId($vc->id_candidato); ?>
                    </div>                    
                    <div class="log_bottom">
                        <form id="formImprimir" name="formImprimir" method="post" action="../controle/ControleVaga.php?op=imprimir">
                            <input type="hidden" name="id_candidato" value="<?php echo $vc->id_candidato; ?>">
                            <input <?php echo $disabled; ?> type="submit" name="curriculo" value="Imprimir Currículo" class="botao" />
                        </form>
                        <p>
                        Para fechar, 
                        <a class="link_incluir" href="javascript:void(0)" onclick="fecharDadosCandidatoTodos('dadosCandidatoSelecionadoTodos_<?php echo $vc->id_candidato; ?>');">clique aqui</a>
                        .</p>                        
                    </div>
                </div>
                <!--<div colspan="4" id="black_overlay_todos" class="black_overlay_todos"></div>-->
                
                <!--Aba de visualizar histórico-->
                <div colspan="4" class="white_content_candidato_todos selecionados" id="dadosHistoricoSelecionadoTodos_<?php echo $vc->id_vagacandidato; ?>">
                    <div id="dadosHistoricoCandidatoTodos">
                        <?php 
                        echo Servicos::montarHistoricoCandidato($vc->id_candidato, ControleSessao::buscarObjeto('privateEmp')->id_empresa); ?>
                    </div>                   
                    <div class="log_bottom">
                        <!--<form id="formImprimir" name="formImprimir" method="post" action="../controle/ControleVaga.php?op=imprimir">
                            <input type="hidden" name="id_candidato" value="<?php //echo $vc->id_candidato; ?>">
                            <input type="submit" name="curriculo" value="Imprimir Currículo" class="botao" />
                        </form>-->
                        <p>
                        Para fechar, 
                        <a class="link_incluir" href="javascript:void(0)" onclick="fecharHistoricoCandidatoTodos('dadosHistoricoSelecionadoTodos_<?php echo $vc->id_vagacandidato; ?>');">clique aqui</a>
                        .</p>                        
                    </div>
                </div>
                <div colspan="4" id="black_overlay_todos" class="black_overlay_todos"></div>
            <?php //}
            }
            ?>
        </div>
        <!-- #######################################ENCAMINHADOS####################################### -->
        <div id="parte-03">
            <div id="loading" align="center" style="display: none;">
                <div id="aguarde" style="background-color:#ffffff;position:absolute;color:#000033;top:50%;left:30%;border:2px solid #cccccc; width:300;font-size:12px;z-index:0;">
                    <br><img src="../../../Utilidades/Imagens/bancodeoportunidades/loading.gif" border="0" align="middle"> Aguarde! Carregando Dados...<br><br>
                </div>
            </div>
            <fieldset>
                <legend class="legend">Filtro</legend>
                <form name="filtro" id="filtroVaga" method="post" action="../controle/ControleVaga.php?op=pesquisarEncaminhados">
                    <div>
                        <table class="tabela_relatorio" border="0" style="margin-bottom: -20px;">
                            <tr>                                
                                <td colspan="3">
                                    <input type="hidden" name="filtro_status" id="filtro_status" value="E" />                                 
                                    <?php //Passando os campos pra busca para poder retonar na sessão. ?>
                                    <input type="hidden" name="encaminhados" id="encaminhadosE" value="<?php echo $totalEncaminhados; ?>" />
                                    <input type="hidden" name="baixasAutomaticas" id="baixasAutomaticasE" value="<?php echo $totalBaixasAutomaticas; ?>" />
                                    <input type="hidden" name="preSelecionados" id="preSelecionadosE" value="<?php echo $totalPreSelecionados; ?>" />
                                    <input type="hidden" name="contratados" id="contratadosE" value="<?php echo $totalContratados;?>" />
                                    <input type="hidden" name="dispensados" id="dispensadosE" value="<?php echo $totalDispensandos; ?>" />
                                    <div style="float: left;">
                                        <label class="filtro_label">Código:</label>                                        
                                        <input value="<?php if(isset($_SESSION['post'])){echo $_SESSION['post']['filtro_codigo_encaminhados'];} ?>" type="text" name="filtro_codigo" id="filtro_codigo_encaminhados" class="campo largura" style="width: 70px;" onkeypress="document.getElementById('filtro_nome_encaminhados').value = ''; return valida_numero(event);" />
                                    
                                        <label class="filtro_label">Nome:</label>                                        
                                        <input value="<?php if(isset($_SESSION['post'])){echo $_SESSION['post']['filtro_nome_encaminhados'];} ?>" type="text" name="filtro_nome" id="filtro_nome_encaminhados" class="campo largura" style="width: 150px;" onkeypress="document.getElementById('filtro_codigo_encaminhados').value = ''; return bloqueia_numeros(event);" />
                                    
                                        <input type="submit" name="buscar" value="Buscar" class="botao"/>
                                        
                                        <?php 
                                            if(isset($_SESSION['errosV']) && in_array('filtro_codigo',$_SESSION['errosV'])){ 
                                        ?>
                                        <span class="style1"><b>* Valor digitado inválido! Somente números.</b></span>
                                        <?php
                                            }
                                        ?>
                                        
                                        <?php 
                                            if(isset($_SESSION['errosV']) && in_array('filtro_nome',$_SESSION['errosV'])){ 
                                        ?>
                                        <span class="style1"><b>* Valor digitado inválido! Somente letras.</b></span>
                                        <?php
                                            }
                                        ?>
                                    </div>                                    
                                </td>
                                <td colspan="2" align="right">
                                    <?php
                                        //Processo de contar a quantidade de candidatos feito na aba de todas as vagas
                                        echo "<b>".Servicos::buscarProfissaoPorId($v->id_profissao)->nm_profissao."</b></br>(".$mostraQtdVaga.")";
                                    ?>
                                </td> 
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <hr style="border: 1px solid #EE7228;">
                                </td>
                            </tr>                            
                            <tr class="filtro_label">
                                <td align="center" style="width: 20%;"><b>Encaminhados:</b> <span id="totalEncaminhadosE"><?php echo $totalEncaminhados; ?></span></td>
                                <td align="center" style="width: 20%; color: #D3D3D3;"><b>Baixas Automáticas:</b> <span id="totalBaixasAutomaticasE"><?php echo $totalBaixasAutomaticas; ?></span></td>
                                <td align="center" style="width: 20%; color: #D3D3D3;"><b>Pré-Selecionados:</b> <span id="totalPreSelecionadosE"><?php echo $totalPreSelecionados; ?></span></td>
                                <td align="center" style="width: 20%; color: #D3D3D3;"><b>Contratados:</b> <span id="totalContratadosE"><?php echo $totalContratados;?></span></td>
                                <td align="center" style="width: 20%; color: #D3D3D3;"><b>Dispensados:</b> <span id="totalDispensadosE"><?php echo $totalDispensandos; ?></span></td>
                            </tr>
                        </table>                        
                    </div>
                    <div>                                                
                    </div>
                </form>
            </fieldset>
            
            <div class="tab_adiciona" <?php echo (!ControleSessao::buscarObjeto('objVaga')->resultadoEncaminhados) ? 'style="padding-bottom: 100px;"' : ''; ?>>
                <?php
                
                if((ControleSessao::buscarObjeto('objVaga')->resultadoEncaminhados) && ($totalEncaminhados > 0)){
                    //var_dump(ControleSessao::buscarObjeto('objVaga'));
                    include_once '../modelo/VagaCandidatoVO.class.php';                    
                    if(count(ControleSessao::buscarObjeto('objVaga')->resultadoEncaminhados)>0){
                        
                        //define a quantidade de resultados da lista
                        $qtdEnc = 10;
                        //busca a page atual
                        $pageEnc = (isset($_GET['enc'])) ? $_GET['enc'] : 0;
                        //recebo um novo array com apenas os elemento necessarios para essa page atual
                        $encaminhados = Servicos::listar(ControleSessao::buscarObjeto('objVaga')->resultadoEncaminhados, $qtdEnc, $pageEnc);                        
                        ?>
                        <div>                            
                            <form id="formImprimir" name="formImprimir" method="post" action="../controle/ControleVaga.php?op=imprimir">
                                <div style="float: left; padding: 3px; cursor: pointer;"><img onclick="atualizaListaEncaminhados(<?php echo ControleSessao::buscarObjeto('objVaga')->id_vaga; ?>);" onMouseOver="this.src='../../../Utilidades/Imagens/bancodeoportunidades/refresh-a.png';" onMouseOut="this.src='../../../Utilidades/Imagens/bancodeoportunidades/refresh.png'" id="imagemrefreshTodos" src="../../../Utilidades/Imagens/bancodeoportunidades/refresh.png" style="width: 25px;" title="Atualizar a lista de candidatos encaminhados"></div>
                                <div class="botao_lista" >
                                    <input type="hidden" name="id_vaga" value="<?php 
                                        $v = ControleSessao::buscarObjeto('objVaga');
                                        echo $v->id_vaga; ?>">
                                    <input <?php echo $disabled; ?> type="submit" name="lista" value="Imprimir Lista" class="botao"/>                                   
                                </div>
                            </form>
                            <!--<form id="formImprimir" name="formImprimir" method="post" action="../controle/ControleVaga.php?op=imprimirCurriculos">-->
                                <!--<div class="botoes_imprimir" align="right">
                                    <input type="submit" value="Imprimir Currículo" class="botao"/>
                                    <label class="filtro_label">Marcar Todos</label>
                                    <input type="checkbox" name="imprimirTodos" id="todos" value="" onclick="marcardesmarcar();">
                                </div>-->
                            <!--</form>-->
                            
                            <?php if(isset($_SESSION['msgImp'])){ ?>
                                <span class="msg" style="margin-left: 565px;"><?php echo ControleSessao::buscarVariavel('msgImp'); ?></span>
                            <?php } ?>
                                <div id="tabela_encaminhados_div"></div>
                            <table width="100%" border="0" id="tabela_encaminhados" class="tabela_encaminhados">
                                <tr class="table_formacao_cab">
                                    <td align='center' width="5%">Código</td>
                                    <td align='center' width="28%">Nome</td>
                                    <td align='center' width="10%">Telefone</td>
                                    <td align='center' width="25%">Email</td>
                                    <td align='center' width="12%">Status</td>
                                    <td align='center' width="5%">Histórico</td>
                                    <td align='center' width="5%">Visualizar</td>
                                    <td align='center' width="5%">Imprimir</td>
                                </tr>
                                <?php
                                $cont=0;
                                $contastatusE_enc = 0;
                                //var_dump(ControleSessao::buscarObjeto('objVaga')->encaminhados[0]);
                                foreach($encaminhados as $vc){
                                    if($vc->ao_status == 'E'){
                                        $contastatusE_enc++;
                                    }
                                    if(!Validacao::validarNulo($vc)){ 
                                    $cont++;                                    
                                ?>
                                    <form name="formSinalizarEnc" id="formSinalizarEnc_<?php echo $vc->id_candidato; ?>" method="post" action="../controle/ControleVaga.php?op=sinalizarEnc" />
                                        <tr class="tabela_linha_todos" id="linha_pre_e_<?php echo $vc->id_vagacandidato; ?>">
                                            <td align="center"><?php echo $vc->id_candidato; ?></td>
                                            <td>                                                
                                                <label style="color: black; font-weight: bold;"><?php echo $vc->nm_candidato; ?></label><br />                                                
                                                <?php
                                                    //Mostra a deficiência caso o candidato tenha.
                                                    if(!is_null($vc->id_deficiencia)){
                                                        if($vc->ao_sexo == "M"){
                                                            $sexoTodos = "Candidato";
                                                        }else{
                                                            $sexoTodos = "Candidata";
                                                        }
                                                        $deficienciaTodos = "(".$sexoTodos." com deficiência <b>".Servicos::buscarDeficienciaPorId($vc->id_deficiencia)."</b>)";
                                                    }else{
                                                        $deficienciaTodos = "";
                                                    }
                                                ?>
                                                <i><?php echo $deficienciaTodos; ?></i>
                                            </td>
                                            <td style="text-align: center;">                                                
                                                <?php
                                                    $telefone = $vc->nr_telefone;
                                                    if(!empty($telefone)){ 
                                                        echo $telefone;
                                                    }else{
                                                        echo $vc->nr_celular;
                                                    }
                                                ?>
                                            </td>
                                            <td><?php echo $vc->ds_email; ?></td>
                                            <td align="left">                                                
                                                 <?php if($vc->ao_status == 'E'){ ?>                                                    
                                                <div id="pre_e_<?php echo $vc->id_vagacandidato; ?>">
                                                    <input <?php echo $disabled; ?> id="candidato_E_encaminhados_<?php echo $vc->id_candidato; ?>" name="<?php echo $vc->id_candidato; ?>" type="radio" value="E" onclick="alterarStatus('E','<?php echo $vc->id_vagacandidato; ?>', 'E'); ocultarSelectMotivos('<?php echo $vc->id_candidato; ?>');" checked disabled />Encaminhado<br>
                                                    <input <?php echo $disabled; ?> id="candidato_P" name="<?php echo $vc->id_candidato; ?>" type="radio" value="P" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'P')||($vc->ao_status == 'P')) echo 'checked'; ?> onclick="if(confirm('Enviar email para o candidato <?php echo $vc->nm_candidato; ?> como pré-selecionado?')){                                                                                                                                                                                                                                                                                                                                                    
                                                                                                                                                                                                                                                                                                                                                    alterarStatus('E','<?php echo $vc->id_vagacandidato; ?>', 'P', '<?php echo $vc->id_vaga; ?>', '<?php echo $_SESSION['id_usuario']; ?>');                                                                                                                                                                                                                                                                                                                                                    
                                                                                                                                                                                                                                                                                                                                                    ocultarSelectMotivos('<?php echo $vc->id_candidato; ?>');
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
                                                                                                                                                                                                                                                                                                                                                }else{                                                                                                                                                                                                                                                                                                                                                    
                                                                                                                                                                                                                                                                                                                                                    document.getElementById('candidato_E_encaminhados_<?php echo $vc->id_candidato; ?>').checked = true;
                                                                                                                                                                                                                                                                                                                                                }" />Pré-selecionado<br>
                                                    <input <?php echo $disabled; ?> id="candidato_C" name="<?php echo $vc->id_candidato; ?>" type="radio" value="C" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'C')||($vc->ao_status == 'C')) echo 'checked'; ?> onclick="if(confirm('Contratar candidato?')){
                                                                                                                                                                                                                                                                                        alterarStatus('E','<?php echo $vc->id_vagacandidato; ?>', 'C', '<?php echo $vc->id_vaga; ?>', '<?php echo $_SESSION['id_usuario']; ?>'); 
                                                                                                                                                                                                                                                                                        ocultarSelectMotivosEnc('<?php echo $vc->id_candidato; ?>');
                                                                                                                                                                                                                                                                                        
                                                                                                                                                                                                                                                                                    }else{                                                                                                                                                                                                                                                                                        
                                                                                                                                                                                                                                                                                        document.getElementById('candidato_E_encaminhados_<?php echo $vc->id_candidato; ?>').checked = true;
                                                                                                                                                                                                                                                                                    }" />Contratado<br>
                                                    <input <?php echo $disabled; ?> id="candidato_D" name="<?php echo $vc->id_candidato; ?>" type="radio" value="D" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'D')||($vc->ao_status == 'D')) echo 'checked'; ?> onclick="mostrarSelectMotivosEnc('<?php echo $vc->id_candidato; ?>', 'E');" />Dispensado
                                                </div>
                                                <div id="div_p_e_<?php echo $vc->id_vagacandidato; ?>" style="display: none;">
                                                        <input id="candidato_P_encaminhados_<?php echo $vc->id_candidato; ?>" name="pre<?php echo $vc->id_candidato; ?>" type="radio" value="P" checked disabled />Pré-selecionado<br>
                                                        <input <?php echo $disabled; ?> id="candidato_C" name="pre<?php echo $vc->id_candidato; ?>" type="radio" value="C" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'C')||($vc->ao_status == 'C')) echo 'checked'; ?> onclick="if(confirm('Contratar candidato?')){                                                                                                                                                                                                                                                                                            
                                                                                                                                                                                                                                                                                            alterarStatus('P','<?php echo $vc->id_vagacandidato; ?>', 'C', '<?php echo $vc->id_vaga; ?>', '<?php echo $_SESSION['id_usuario']; ?>');                                                                                                                                                                                                                                                                                            
                                                                                                                                                                                                                                                                                            ocultarSelectMotivosEnc('<?php echo $vc->id_candidato; ?>');                                                                                                                                                                                                                                                                                             
                                                                                                                                                                                                                                                                                        }else{                                                                                                                                                                                                                                                                                             
                                                                                                                                                                                                                                                                                             document.getElementById('candidato_P_encaminhados_<?php echo $vc->id_candidato; ?>').checked = true;
                                                                                                                                                                                                                                                                                        }" />Contratado<br>
                                                        <input <?php echo $disabled; ?> id="candidato_D" name="pre<?php echo $vc->id_candidato; ?>" type="radio" value="D" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'D')||($vc->ao_status == 'D')) echo 'checked'; ?> onclick="mostrarSelectMotivosEnc('<?php echo $vc->id_candidato; ?>', 'P');"/>Dispensado
                                                </div>
                                                <?php
                                                }else{
                                                    if($vc->ao_status == 'C'){
                                                        echo 'Contratação já sinalizada';                                                        
                                                    }else if($vc->ao_status == 'D'){ 
                                                        echo 'Dispensa já sinalizada';                                                        
                                                    }else if($vc->ao_status == 'B'){
                                                        echo 'Baixa automática';
                                                    }else if($vc->ao_status == 'P'){ ?>
                                                        <div id="div_p2_e_<?php echo $vc->id_vagacandidato; ?>">
                                                            <input id="candidato_P_encaminhados_<?php echo $vc->id_candidato; ?>" name="<?php echo $vc->id_candidato; ?>" type="radio" value="P" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'P')||($vc->ao_status == 'P')) echo 'checked'; ?> disabled />Pré-selecionado<br>
                                                            <input <?php echo $disabled; ?> id="candidato_C" name="<?php echo $vc->id_candidato; ?>" type="radio" value="C" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'C')||($vc->ao_status == 'C')) echo 'checked'; ?> onclick="if(confirm('Contratar candidato?')){                                                                                                                                                                                                                                                                                            
                                                                                                                                                                                                                                                                                            alterarStatus('P','<?php echo $vc->id_vagacandidato; ?>', 'C', '<?php echo $vc->id_vaga; ?>', '<?php echo $_SESSION['id_usuario']; ?>');                                                                                                                                                                                                                                                                                            
                                                                                                                                                                                                                                                                                            ocultarSelectMotivosEnc('<?php echo $vc->id_candidato; ?>');                                                                                                                                                                                                                                                                                             
                                                                                                                                                                                                                                                                                        }else{                                                                                                                                                                                                                                                                                             
                                                                                                                                                                                                                                                                                             document.getElementById('candidato_P_encaminhados_<?php echo $vc->id_candidato; ?>').checked = true;
                                                                                                                                                                                                                                                                                        }" />Contratado<br>
                                                            <input <?php echo $disabled; ?> id="candidato_D" name="<?php echo $vc->id_candidato; ?>" type="radio" value="D" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'D')||($vc->ao_status == 'D')) echo 'checked'; ?> onclick="mostrarSelectMotivosEnc('<?php echo $vc->id_candidato; ?>', 'P');"/>Dispensado
                                                        </div>
                                                <?php 
                                                    }
                                                }
                                                ?>
                                            </td>                                            
                                            <?php 
                                            $historico = Servicos::verificarHistoricoCandidato($vc->id_candidato, ControleSessao::buscarObjeto('privateEmp')->id_empresa);
                                            if($historico>0){ 
                                            ?>
                                                <td align='center'>
                                                    <img src='../../../Utilidades/Imagens/bancodeoportunidades/historico.png' width="28" onclick="abrirHistoricoCandidato('dadosHistoricoSelecionado_<?php echo $vc->id_vagacandidato; ?>');" value="" title="Visualizar histórico de <?php echo $vc->nm_candidato; ?>" style="cursor: pointer;" />
                                                </td>
                                            <?php 
                                            }else{ 
                                            ?>
                                                <td align='center'>
                                                    <img src='../../../Utilidades/Imagens/bancodeoportunidades/historico_disabled.png' title='Candidato sem histórico' width="28" />
                                                </td>
                                            <?php 
                                            } 
                                            ?>
                                            <td align='center'>
                                                <input type="button" class="btn_visualizar" onclick="abrirDadosCandidato('dadosCandidatoSelecionado_<?php echo $vc->id_candidato; ?>');" value="" title="Visualizar currículo de <?php echo $vc->nm_candidato; ?>" />
                                            </td>
                                            <!--<td align="center">
                                                <input type="checkbox" class="marcar" id="pag_perfil" name="imprimir[]" value="<?php //echo $vc->id_candidato; ?>" />
                                            </td>-->
                                            <td align="center">
                                                <input <?php echo $disabled; ?> type="submit" name="imprimir" value="" class="btn_imprimir" title="Imprimir currículo de <?php echo $vc->nm_candidato; ?>" />
                                                <input type="hidden" name="id_candidato" id="id_candidato" value="<?php echo $vc->id_candidato; ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" id="candidatoEnc_<?php echo $vc->id_candidato; ?>" style="display: none;">
                                                <div>
                                                   <span class="style1" style="float: left; margin-top: 5px; margin-right: 3px;">*</span>
                                                   <span style="color: white;">
                                                        Motivo:                                                
                                                       <select onchange="mostrarCampoMotivoDispensaEnc(<?php echo $vc->id_candidato; ?>);" name="id_motivo" id="id_motivoEnc_<?php echo $vc->id_candidato; ?>" <?php echo (isset($_SESSION['errosV']) && in_array('id_motivo',$_SESSION['errosV'])) ? 'class="campo_erro select"' : 'class="campo select"'; ?>>
                                                        <option value="Selecione">Selecione</option>
                                                            <?php
                                                            $motivos = Servicos::buscarMotivos();
                                                            foreach($motivos as $m){
                                                            ?>
                                                                <option value="<?php echo $m->id_motivo; ?>" <?php if(isset($_SESSION['errosV']) && (isset($_SESSION['post']['id_motivo']) && $_SESSION['post']['id_motivo'] == $m->id_motivo)) { echo 'selected';} ?> ><?php echo $m->ds_motivo; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                            <option value="Outros">Outros</option>
                                                        </select>
                                                        <?php echo Servicos::verificarErro('errosV', 'id_motivo', '* Selecione um dado.'); ?>
                                                   </span>
                                                   
                                                   <span id="mostrarMotivoEnc_<?php echo $vc->id_candidato; ?>" style="display: none; margin-left: 40px; color: white;">
                                                       Descrição Motivo:
                                                       <input style="width: 305px;" value="<?php if(isset($_SESSION['errosV'])){ echo $_SESSION['post']['ds_motivo']; } ?>" type="text" name="ds_motivo" id="ds_motivoEnc_<?php echo $vc->id_candidato; ?>" size="50" maxlength="500" <?php echo (isset($_SESSION['errosV']) && in_array('ds_motivo',$_SESSION['errosV'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                                       <?php echo Servicos::verificarErro('errosV', 'ds_motivo'); ?>
                                                   </span>
                                                   
                                                   
                                                   <span id="inputEnviarEnc_<?php echo $vc->id_candidato; ?>" style="display: none;">
                                                       <?php //Se o dispensar vier direto do E, recebe E para decrementar nos encaminhados e mostra o enviarMotivo_E_, se vier do P, recebe P e decrementa do P e mostra o enviarMotivo_P_. ?>
                                                       <input style="margin-top: 3px;" <?php echo $disabled; ?> id="enviarMotivo_Enc_<?php echo $vc->id_candidato; ?>" name="enviarMotivo" type="button" value="Enviar" class="botao" onclick="if(confirm('Tem certeza que deseja dispensar o candidato <?php echo $vc->nm_candidato; ?>?')){verificarSelectEnc('E','<?php echo $vc->id_candidato; ?>', '<?php echo $vc->id_vagacandidato; ?>', 'D', '<?php echo $vc->id_vaga; ?>', '<?php echo $_SESSION['id_usuario']; ?>');}else{ document.getElementById('candidato_E_encaminhados_<?php echo $vc->id_candidato; ?>').checked = true; ocultarSelectMotivosEnc('<?php echo $vc->id_candidato; ?>'); return false; }" />
                                                       <input style="margin-top: 3px;" <?php echo $disabled; ?> id="enviarMotivo_Pre_<?php echo $vc->id_candidato; ?>" name="enviarMotivo" type="button" value="Enviar" class="botao" onclick="if(confirm('Tem certeza que deseja dispensar o candidato <?php echo $vc->nm_candidato; ?>?')){verificarSelectEnc('P','<?php echo $vc->id_candidato; ?>', '<?php echo $vc->id_vagacandidato; ?>', 'D', '<?php echo $vc->id_vaga; ?>', '<?php echo $_SESSION['id_usuario']; ?>');}else{ document.getElementById('candidato_P_encaminhados_<?php echo $vc->id_candidato; ?>').checked = true; ocultarSelectMotivosEnc('<?php echo $vc->id_candidato; ?>'); return false; }" />
                                                       <input type="hidden" name="id_vagacandidato" id="id_vagacandidato" value="<?php echo $vc->id_vagacandidato; ?>">
                                                       <?php //informa ao sinalizarEnc do action do form, que este vem da aba dos pré-selecionados. ?>
                                                       <input type="hidden" name="vem_do" id="vem_do" value="E">
                                                   </span>                                                   
                                                </div>                                                
                                            </td>
                                        </tr>
                                    </form>
                                <?php
                                    }
                                }
                                ?>
                                <tr>                                    
                                    <td colspan="8">
                                        <table width="100%">
                                            <tr>
                                                <td class="cont_pagina" width="5%">
                                                    <?php 
                                                        //$total = count(ControleSessao::buscarObjeto('objVaga')->encaminhados);
                                                    
                                                        //conta qual é o total de encaminhados
                                                        $todos_encaminhados = ControleSessao::buscarObjeto('objVaga')->resultadoEncaminhados;
                                                        foreach($todos_encaminhados as $tenc){                                    
                                                            if($tenc->ao_status == 'E'){
                                                                $total_enc++;
                                                            }
                                                        }

                                                        echo ($pageEnc * $qtdEnc + $cont).'/'.$total_enc;
                                                    ?>                                                    
                                                </td>
                                                <td id="paginacao" align="center" width="95%">
                                                    <input type="hidden" id="conta_encaminhados_todos" value="<?php echo $contastatusE_enc; ?>" />
                                                    <input type="hidden" id="get_encaminhados_todos" value="<?php echo $page; ?>" />
                                                    <?php
                                                        if($$contastatusE_enc == '0'){
                                                            $mostraPaginacaoFalsa_enc = "none;";
                                                            $mostraPaginacaoCerta_enc = "block;";
                                                        }else{
                                                            $mostraPaginacaoFalsa_enc = "block;";
                                                            $mostraPaginacaoCerta_enc = "none;";
                                                        }
                                                    ?>
                                                    <div id="paginacaoFalsaTodos" style="display: <?php echo $mostraPaginacaoFalsa_enc; ?>">
                                                        <?php
                                                            //crio a paginacao propriamente dita
                                                            echo Servicos::criarPaginacaoFalsaEncaminhados(ControleSessao::buscarObjeto('objVaga')->resultadoEncaminhados, $qtd, $page,'#parte-02');
                                                        ?>
                                                    </div>
                                                    <div id="paginacaoCertaTodos" style="display: <?php echo $mostraPaginacaoCerta_enc; ?>">
                                                        <?php
                                                            //crio a paginacao propriamente dita
                                                            echo Servicos::criarPaginacaoEncaminhados(ControleSessao::buscarObjeto('objVaga')->resultadoEncaminhados, $qtdEnc, $pageEnc,'#parte-03');
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <?php if(ControleSessao::buscarObjeto('objVaga')->ao_ativo == 'S'){ ?>
                            <div align="right">
                                <br/>
                                <span class="msg">
                                    <?php if(isset($_SESSION['msgEn']))echo ControleSessao::buscarVariavel('msgEn'); ?>
                                </span>
                                <!--<input class="botao" name="registrar" type="submit" value="Registrar" />-->                                    
                            </div>      
                            <?php } ?>                           
                        </div>
                    <?php } ?>                        
                <?php                    
                }else{
                ?>                
                <br />
                <div style="width: 100%; float: left; padding: 3px; cursor: pointer;"><img onclick="atualizaListaEncaminhados(<?php echo ControleSessao::buscarObjeto('objVaga')->id_vaga; ?>);" onMouseOver="this.src='../../../Utilidades/Imagens/bancodeoportunidades/refresh-a.png';" onMouseOut="this.src='../../../Utilidades/Imagens/bancodeoportunidades/refresh.png'" id="imagemrefreshTodos" src="../../../Utilidades/Imagens/bancodeoportunidades/refresh.png" style="width: 25px;" title="Atualizar a lista de candidatos encaminhados"></div>
                <div id="tabela_encaminhados_div_pesq"></div>
                <table id="tabela_encaminhados_pesq" width="100%" class='tabela_encaminhados'>
                    <tr class='table_formacao_cab'>
                        <td>&nbsp;</td>
                    </tr>
                    <tr class='table_formacao_row'>
                        <td style='height: 300px;'>
                            <center>
                                <b style="font-size: 20px;">
                                    <?php                                
                                        if(ControleSessao::buscarObjeto('objVaga')->pesqEncaminhados){
                                            echo "Não há resultados para sua busca por candidatos encaminhados!";
                                        }else{
                                            echo "Não há candidatos encaminhados para esta vaga";
                                        }
                                    ?>
                                </b>
                            </center>
                        </td>
                    </tr>
                </table>    
                <?php
                }
                ?>
            </div>
            
            <?php // echo Servicos::montarHistoricoCandidato(617, 96); ?>
            
            <?php 
            //$x=0;
            foreach($encaminhados as $vc){
                if(!Validacao::validarNulo($vc)){
                //$x++; 
            ?>
                <!--Aba de visualizar curriculos-->
                <div colspan="4" class="white_content_candidato selecionados" id="dadosCandidatoSelecionado_<?php echo $vc->id_candidato; ?>">
                    <div id="dadosCandidato">
                        <?php echo Servicos::buscarDadosCandidatoPorId($vc->id_candidato); ?>
                    </div>                    
                    <div class="log_bottom">
                        <form id="formImprimir" name="formImprimir" method="post" action="../controle/ControleVaga.php?op=imprimir">
                            <input type="hidden" name="id_candidato" value="<?php echo $vc->id_candidato; ?>">
                            <input <?php echo $disabled; ?> type="submit" name="curriculo" value="Imprimir Currículo" class="botao" />
                        </form>
                        <p>
                        Para fechar, 
                        <a class="link_incluir" href="javascript:void(0)" onclick="fecharDadosCandidato('dadosCandidatoSelecionado_<?php echo $vc->id_candidato; ?>');">clique aqui</a>
                        .</p>                        
                    </div>
                </div>
                <!--<div colspan="4" id="black_overlay" class="black_overlay"></div>-->
                
                <!--Aba de visualizar histórico-->
                <div colspan="4" class="white_content_candidato selecionados" id="dadosHistoricoSelecionado_<?php echo $vc->id_vagacandidato; ?>">
                    <div id="dadosHistoricoCandidato">
                        <?php 
                        echo Servicos::montarHistoricoCandidato($vc->id_candidato, ControleSessao::buscarObjeto('privateEmp')->id_empresa); ?>
                    </div>                   
                    <div class="log_bottom">
                        <!--<form id="formImprimir" name="formImprimir" method="post" action="../controle/ControleVaga.php?op=imprimir">
                            <input type="hidden" name="id_candidato" value="<?php //echo $vc->id_candidato; ?>">
                            <input type="submit" name="curriculo" value="Imprimir Currículo" class="botao" />
                        </form>-->
                        <p>
                        Para fechar, 
                        <a class="link_incluir" href="javascript:void(0)" onclick="fecharHistoricoCandidato('dadosHistoricoSelecionado_<?php echo $vc->id_vagacandidato; ?>');">clique aqui</a>
                        .</p>                        
                    </div>
                </div>
                <div colspan="4" id="black_overlay" class="black_overlay"></div>
            <?php }
            }
            ?>
        </div>
        <!-- #######################################BAIXAS AUTOMÁTICAS####################################### -->
        <div id="parte-04">
            <div id="loading" align="center" style="display: none;">
                <div id="aguarde" style="background-color:#ffffff;position:absolute;color:#000033;top:50%;left:30%;border:2px solid #cccccc; width:300;font-size:12px;z-index:0;">
                    <br><img src="../../../Utilidades/Imagens/bancodeoportunidades/loading.gif" border="0" align="middle"> Aguarde! Carregando Dados...<br><br>
                </div>
            </div>
            <fieldset>
                <legend class="legend">Filtro</legend>
                <form name="filtro" id="filtroVaga" method="post" action="../controle/ControleVaga.php?op=pesquisarBaixasAutomaticas">
                    <div>
                        <table class="tabela_relatorio" border="0" style="margin-bottom: -20px;">
                            <tr>                                
                                <td colspan="3">                                                                        
                                    <input type="hidden" name="filtro_status" id="filtro_status" value="B" />
                                    <?php //Passando os campos pra busca para poder retonar na sessão. ?>
                                    <input type="hidden" name="encaminhados" id="encaminhadosB" value="<?php echo $totalEncaminhados; ?>" />
                                    <input type="hidden" name="baixasAutomaticas" id="baixasAutomaticasB" value="<?php echo $totalBaixasAutomaticas; ?>" />
                                    <input type="hidden" name="preSelecionados" id="preSelecionadosB" value="<?php echo $totalPreSelecionados; ?>" />
                                    <input type="hidden" name="contratados" id="contratadosB" value="<?php echo $totalContratados;?>" />
                                    <input type="hidden" name="dispensados" id="dispensadosB" value="<?php echo $totalDispensandos; ?>" />                                    
                                
                                    <div style="float: left;">
                                        <label class="filtro_label">Código:</label>                                        
                                        <input value="<?php if(isset($_SESSION['post'])){echo $_SESSION['post']['filtro_codigo_baixas_automaticas'];} ?>" type="text" name="filtro_codigo" id="filtro_codigo_baixas_automaticas" class="campo largura" style="width: 70px;" onkeypress="document.getElementById('filtro_nome_baixas_automaticas').value = ''; return valida_numero(event);" />
                                    
                                        <label class="filtro_label">Nome:</label>                                        
                                        <input value="<?php if(isset($_SESSION['post'])){echo $_SESSION['post']['filtro_nome_baixas_automaticas'];} ?>" type="text" name="filtro_nome" id="filtro_nome_baixas_automaticas" class="campo largura" style="width: 150px;" onkeypress="document.getElementById('filtro_codigo_baixas_automaticas').value = ''; return bloqueia_numeros(event);" />
                                    
                                        <input type="submit" name="buscar" value="Buscar" class="botao"/>
                                        
                                        <?php 
                                            if(isset($_SESSION['errosV']) && in_array('filtro_codigo',$_SESSION['errosV'])){ 
                                        ?>
                                        <span class="style1"><b>* Valor digitado inválido! Somente números.</b></span>
                                        <?php
                                            }
                                        ?>
                                        
                                        <?php 
                                            if(isset($_SESSION['errosV']) && in_array('filtro_nome',$_SESSION['errosV'])){ 
                                        ?>
                                        <span class="style1"><b>* Valor digitado inválido! Somente letras.</b></span>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                </td>
                                <td colspan="2" align="right">
                                    <?php
                                        //Processo de contar a quantidade de candidatos feito na aba de todas as vagas
                                        echo "<b>".Servicos::buscarProfissaoPorId($v->id_profissao)->nm_profissao."</b></br>(".$mostraQtdVaga.")";
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <hr style="border: 1px solid #EE7228;">
                                </td>
                            </tr>                            
                            <tr class="filtro_label">
                                <td align="center" style="width: 20%; color: #D3D3D3;"><b>Encaminhados:</b> <span id="totalEncaminhadosB"><?php echo $totalEncaminhados; ?></span></td>
                                <td align="center" style="width: 20%;"><b>Baixas Automáticas:</b> <span id="totalBaixasAutomaticasB"><?php echo $totalBaixasAutomaticas; ?></span></td>
                                <td align="center" style="width: 20%; color: #D3D3D3;"><b>Pré-Selecionados:</b> <span id="totalPreSelecionadosB"><?php echo $totalPreSelecionados; ?></span></td>
                                <td align="center" style="width: 20%; color: #D3D3D3;"><b>Contratados:</b> <span id="totalContratadosB"><?php echo $totalContratados;?></span></td>
                                <td align="center" style="width: 20%; color: #D3D3D3;"><b>Dispensados:</b> <span id="totalDispensadosB"><?php echo $totalDispensandos; ?></span></td>
                            </tr>
                        </table>                        
                    </div>
                    <div>                                                
                    </div>
                </form>
            </fieldset>
            
            <div class="tab_adiciona" <?php echo (!ControleSessao::buscarObjeto('objVaga')->baixasAutomaticas) ? 'style="padding-bottom: 100px;"' : ''; ?>>
                <?php
                
                if((ControleSessao::buscarObjeto('objVaga')->baixasAutomaticas) && ($totalBaixasAutomaticas > 0) ){
                    //var_dump(ControleSessao::buscarObjeto('objVaga'));
                    include_once '../modelo/VagaCandidatoVO.class.php';                    
                    if(count(ControleSessao::buscarObjeto('objVaga')->baixasAutomaticas)>0){
                        
                        //define a quantidade de resultados da lista
                        $qtdBA = 10;
                        //busca a page atual
                        $pageBA = (isset($_GET['ba'])) ? $_GET['ba'] : 0;
                        //recebo um novo array com apenas os elemento necessarios para essa page atual
                        $baixasAutomaticas = Servicos::listar(ControleSessao::buscarObjeto('objVaga')->baixasAutomaticas, $qtdBA, $pageBA);                        
                        ?>
                        <div>                            
                            <form id="formImprimir" name="formImprimir" method="post" action="../controle/ControleVaga.php?op=imprimir">
                                <div style="float: left; padding: 3px; cursor: pointer;"><img onclick="atualizaListaBaixasAutomaticas(<?php echo ControleSessao::buscarObjeto('objVaga')->id_vaga; ?>);" onMouseOver="this.src='../../../Utilidades/Imagens/bancodeoportunidades/refresh-a.png';" onMouseOut="this.src='../../../Utilidades/Imagens/bancodeoportunidades/refresh.png'" id="imagemrefreshTodos" src="../../../Utilidades/Imagens/bancodeoportunidades/refresh.png" style="width: 25px;" title="Atualizar a lista de baixas automáticas"></div>
                                <div class="botao_lista" >
                                    <input type="hidden" name="id_vaga" value="<?php 
                                        $v = ControleSessao::buscarObjeto('objVaga');
                                        echo $v->id_vaga; ?>">
                                    <input <?php echo $disabled; ?> type="submit" name="lista" value="Imprimir Lista" class="botao"/>                                   
                                </div>
                            </form>
                            <!--<form id="formImprimir" name="formImprimir" method="post" action="../controle/ControleVaga.php?op=imprimirCurriculos">-->
                                <!--<div class="botoes_imprimir" align="right">
                                    <input type="submit" value="Imprimir Currículo" class="botao"/>
                                    <label class="filtro_label">Marcar Todos</label>
                                    <input type="checkbox" name="imprimirTodos" id="todos" value="" onclick="marcardesmarcar();">
                                </div>-->
                            <!--</form>-->
                            
                            <?php if(isset($_SESSION['msgImp'])){ ?>
                                <span class="msg" style="margin-left: 565px;"><?php echo ControleSessao::buscarVariavel('msgImp'); ?></span>
                            <?php } ?>
                            <div class="filtro_label" style="padding: 5px 0px 0px 50px;">
                                *Baixas automáticas dos candidatos ocorrem quando eles ficam mais de 30 dias com o status de encaminhado para esta vaga.
                            </div>
                            <div id="tabela_baixas_automaticas_div"></div>
                            <table width="100%" border="0" id="tabela_baixas_automaticas" class="tabela_encaminhados">
                                <tr class="table_formacao_cab">
                                    <td align='center' width="5%">Código</td>
                                    <td align='center' width="28%">Nome</td>
                                    <td align='center' width="10%">Telefone</td>
                                    <td align='center' width="25%">Email</td>
                                    <td align='center' width="12%">Status</td>
                                    <td align='center' width="5%">Histórico</td>
                                    <td align='center' width="5%">Visualizar</td>
                                    <td align='center' width="5%">Imprimir</td>
                                </tr>
                                <?php
                                $cont=0;
                                
                                //var_dump(ControleSessao::buscarObjeto('objVaga')->encaminhados[0]);
                                foreach($baixasAutomaticas as $vc){
                                    
                                    if($vc->ao_status == 'B'){
                                    if(!Validacao::validarNulo($vc)){ 
                                    $cont++;                                    
                                ?>
                                    <form name="formSinalizar" id="formSinalizar_<?php echo $vc->id_candidato; ?>" method="post" action="../controle/ControleVaga.php?op=sinalizar" />
                                        <tr class="tabela_linha_todos" style="height: 50px;">
                                            <td align="center"><?php echo $vc->id_candidato; ?></td>
                                            <td>                                                
                                                <label style="color: black; font-weight: bold;"><?php echo $vc->nm_candidato; ?></label><br />                                                
                                                <?php
                                                    //Mostra a deficiência caso o candidato tenha.
                                                    if(!is_null($vc->id_deficiencia)){
                                                        if($vc->ao_sexo == "M"){
                                                            $sexoTodos = "Candidato";
                                                        }else{
                                                            $sexoTodos = "Candidata";
                                                        }
                                                        $deficienciaTodos = "(".$sexoTodos." com deficiência <b>".Servicos::buscarDeficienciaPorId($vc->id_deficiencia)."</b>)";
                                                    }else{
                                                        $deficienciaTodos = "";
                                                    }
                                                ?>
                                                <i><?php echo $deficienciaTodos; ?></i>
                                            </td> 
                                            <td style="text-align: center;">                                                
                                                <?php                                                                                
                                                    $telefone = $vc->nr_telefone;
                                                    if(!empty($telefone)){ 
                                                        echo $telefone;
                                                    }else{
                                                        echo $vc->nr_celular;
                                                    }
                                                ?>
                                            </td>
                                            <td><?php echo $vc->ds_email; ?></td>
                                            <td align="left">
                                                <?php if($vc->ao_status == 'E'){ ?>                                                    
                                                    <input <?php echo $disabled; ?> id="candidato_E" name="<?php echo $vc->id_candidato; ?>" type="radio" value="E" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'E')||($vc->ao_status == 'E')) echo 'checked'; ?> onclick="alterarStatus('<?php echo $vc->id_vagacandidato; ?>', 'E'); ocultarSelectMotivos('<?php echo $vc->id_candidato; ?>');" />Encaminhado<br>
                                                    <input <?php echo $disabled; ?> id="candidato_P" name="<?php echo $vc->id_candidato; ?>" type="radio" value="P" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'P')||($vc->ao_status == 'P')) echo 'checked'; ?> onclick="if(confirm('Enviar email para o candidato <?php echo $vc->candidato->nm_candidato; ?> como pré-selecionado?')){ 
                                                                                                                                                                                                                                                                                                                                                    alterarStatus('<?php echo $vc->id_vagacandidato; ?>', 'P', '<?php echo $vc->id_vaga; ?>', '<?php echo $_SESSION['id_usuario']; ?>');                                                                                                                                                                                                                                                                                                                                                    
                                                                                                                                                                                                                                                                                                                                                    ocultarSelectMotivos('<?php echo $vc->id_candidato; ?>');
                                                                                                                                                                                                                                                                                                                                                    $('input[name=buscar]').click();
                                                                                                                                                                                                                                                                                                                                                }else{                                                                                                                                                                                                                                                                                                                                                    
                                                                                                                                                                                                                                                                                                                                                    location.reload();                                                                                                                                                                                                                                                                                                                                                    
                                                                                                                                                                                                                                                                                                                                                }" />Pré-selecionado<br>
                                                    <input <?php echo $disabled; ?> id="candidato_C" name="<?php echo $vc->id_candidato; ?>" type="radio" value="C" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'C')||($vc->ao_status == 'C')) echo 'checked'; ?> onclick="if(confirm('Contratar candidato?')){
                                                                                                                                                                                                                                                                                        alterarStatus('<?php echo $vc->id_vagacandidato; ?>', 'C', '<?php echo $vc->id_vaga; ?>', '<?php echo $_SESSION['id_usuario']; ?>'); 
                                                                                                                                                                                                                                                                                        ocultarSelectMotivos('<?php echo $vc->id_candidato; ?>');                                                                                                                                                                                                                                                                                        
                                                                                                                                                                                                                                                                                        $('input[name=buscar]').click();                                                                                                                                                                                                                                                                                        
                                                                                                                                                                                                                                                                                    }else{                                                                                                                                                                                                                                                                                        
                                                                                                                                                                                                                                                                                        location.reload();
                                                                                                                                                                                                                                                                                    }" />Contratado<br>
                                                    <input id="candidato_D" name="<?php echo $vc->id_candidato; ?>" type="radio" value="D" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'D')||($vc->ao_status == 'D')) echo 'checked'; ?> onclick="mostrarSelectMotivos('<?php echo $vc->id_candidato; ?>');" />Dispensado
                                                <?php
                                                }else{
                                                    if($vc->ao_status == 'C'){
                                                        echo 'Contratação já sinalizada';                                                        
                                                    }else if($vc->ao_status == 'D'){ 
                                                        echo 'Dispensa já sinalizada'; 
                                                    }else if($vc->ao_status == 'B'){
                                                        echo 'Baixa automática';
                                                    }else if($vc->ao_status == 'P'){ ?>                                                            
                                                        <input id="candidato_P" name="<?php echo $vc->id_candidato; ?>" type="radio" value="P" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'P')||($vc->ao_status == 'P')) echo 'checked'; ?> disabled />Pré-selecionado<br>
                                                        <input <?php echo $disabled; ?> id="candidato_C" name="<?php echo $vc->id_candidato; ?>" type="radio" value="C" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'C')||($vc->ao_status == 'C')) echo 'checked'; ?> onclick="if(confirm('Contratar candidato?')){                                                                                                                                                                                                                                                                                            
                                                                                                                                                                                                                                                                                            alterarStatus('<?php echo $vc->id_vagacandidato; ?>', 'C', '<?php echo $vc->id_vaga; ?>', '<?php echo $_SESSION['id_usuario']; ?>');                                                                                                                                                                                                                                                                                            
                                                                                                                                                                                                                                                                                            ocultarSelectMotivos('<?php echo $vc->id_candidato; ?>'); 
                                                                                                                                                                                                                                                                                            $('input[name=buscar]').click(); 
                                                                                                                                                                                                                                                                                        }else{                                                                                                                                                                                                                                                                                             
                                                                                                                                                                                                                                                                                             location.reload();
                                                                                                                                                                                                                                                                                        }" />Contratado<br>
                                                        <input id="candidato_D" name="<?php echo $vc->id_candidato; ?>" type="radio" value="D" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'D')||($vc->ao_status == 'D')) echo 'checked'; ?> onclick="mostrarSelectMotivos('<?php echo $vc->id_candidato; ?>');"/>Dispensado
                                                <?php 
                                                    }
                                                }
                                                ?>
                                            </td>                                            
                                            <?php 
                                            $historico = Servicos::verificarHistoricoCandidato($vc->id_candidato, ControleSessao::buscarObjeto('privateEmp')->id_empresa);
                                            if($historico>0){ 
                                            ?>
                                                <td align='center'>
                                                    <img src='../../../Utilidades/Imagens/bancodeoportunidades/historico.png' width="28" onclick="abrirHistoricoCandidatoBaixa('dadosHistoricoSelecionadoBaixa_<?php echo $vc->id_vagacandidato; ?>');" value="" title="Visualizar histórico de <?php echo $vc->nm_candidato; ?>" style="cursor: pointer;" />
                                                </td>
                                            <?php 
                                            }else{ 
                                            ?>
                                                <td align='center'>
                                                    <img src='../../../Utilidades/Imagens/bancodeoportunidades/historico_disabled.png' title='Candidato sem histórico' width="28" />
                                                </td>
                                            <?php 
                                            } 
                                            ?>
                                            <td align='center'>
                                                <input type="button" class="btn_visualizar" onclick="abrirDadosCandidatoBaixa('dadosCandidatoSelecionadoBaixa_<?php echo $vc->id_candidato; ?>');" value="" title="Visualizar currículo de <?php echo $vc->nm_candidato; ?>" />
                                            </td>
                                            <!--<td align="center">
                                                <input type="checkbox" class="marcar" id="pag_perfil" name="imprimir[]" value="<?php //echo $vc->id_candidato; ?>" />
                                            </td>-->
                                            <td align="center">
                                                <input <?php echo $disabled; ?> type="submit" name="imprimir" value="" class="btn_imprimir" title="Imprimir currículo de <?php echo $vc->nm_candidato; ?>" />
                                                <input type="hidden" name="id_candidato" id="id_candidato" value="<?php echo $vc->id_candidato; ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" id="candidato_<?php echo $vc->id_candidato; ?>" style="display: none;">                                                
                                                <div>
                                                   <span class="style1">*</span>
                                                   <span>
                                                        Motivo:                                                
                                                       <select onchange="mostrarCampoMotivoDispensa(<?php echo $vc->id_candidato; ?>);" name="id_motivo" id="id_motivo_e_<?php echo $vc->id_candidato; ?>" <?php echo (isset($_SESSION['errosV']) && in_array('id_motivo',$_SESSION['errosV'])) ? 'class="campo_erro select"' : 'class="campo select"'; ?>>
                                                        <option value="Selecione">Selecione</option>
                                                            <?php
                                                            $motivos = Servicos::buscarMotivos();
                                                            foreach($motivos as $m){
                                                            ?>
                                                                <option value="<?php echo $m->id_motivo; ?>" <?php if(isset($_SESSION['errosV']) && (isset($_SESSION['post']['id_motivo']) && $_SESSION['post']['id_motivo'] == $m->id_motivo)) { echo 'selected';} ?> ><?php echo $m->ds_motivo; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                            <option value="Outros">Outros</option>
                                                        </select>
                                                        <?php echo Servicos::verificarErro('errosV', 'id_motivo', '* Selecione um dado.'); ?>
                                                   </span>
                                                   
                                                   <span id="mostrarMotivo_<?php echo $vc->id_candidato; ?>" style="display: none;">
                                                       Descrição Motivo:
                                                       <input value="<?php if(isset($_SESSION['errosV'])){ echo $_SESSION['post']['ds_motivo']; } ?>" type="text" name="ds_motivo" id="ds_motivo_e_<?php echo $vc->id_candidato; ?>" size="50" maxlength="500" <?php echo (isset($_SESSION['errosV']) && in_array('ds_motivo',$_SESSION['errosV'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                                       <?php echo Servicos::verificarErro('errosV', 'ds_motivo'); ?>
                                                   </span>
                                                   
                                                   
                                                   <span id="inputEnviar_<?php echo $vc->id_candidato; ?>" style="display: none;">
                                                       <input <?php echo $disabled; ?> name="enviarMotivo" type="button" value="Enviar" class="botao" onclick="if(confirm('Tem certeza que deseja dispensar o candidato <?php echo $vc->nm_candidato; ?>?')){verificarSelect(<?php echo $vc->id_candidato; ?>);}else{ return false; }" />                                                        
                                                       <input type="hidden" name="id_vagacandidato" id="id_vagacandidato" value="<?php echo $vc->id_vagacandidato; ?>">
                                                   </span>                                                   
                                                </div>                                                
                                            </td>
                                        </tr>
                                    </form>
                                <?php
                                    }
                                  }
                                }
                                ?>
                                <tr>                                    
                                    <td colspan="8">
                                        <table width="100%">
                                            <tr>
                                                <td class="cont_pagina" width="5%">
                                                    <?php 
                                                        //$total = count(ControleSessao::buscarObjeto('objVaga')->encaminhados);
                                                    
                                                        //conta qual é o total de baixas automáticas
                                                        $todos_encaminhados = ControleSessao::buscarObjeto('objVaga')->baixasAutomaticas;
                                                        foreach($todos_encaminhados as $tenc){                                    
                                                            if($tenc->ao_status == 'B'){
                                                                $total_baixas++;
                                                            }
                                                        }

                                                        echo ($pageBA * $qtdBA + $cont).'/'.$total_baixas;
                                                    ?>                                                    
                                                </td>
                                                <td id="paginacao" align="center" width="95%">
                                                    <?php
                                                        //crio a paginacao propriamente dita
                                                        echo Servicos::criarPaginacaoBaixasAutomaticas(ControleSessao::buscarObjeto('objVaga')->baixasAutomaticas, $qtdBA, $pageBA,'#parte-04');
                                                    ?>                                                    
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <?php if(ControleSessao::buscarObjeto('objVaga')->ao_ativo == 'S'){ ?>
                            <div align="right">
                                <br/>
                                <span class="msg">
                                    <?php if(isset($_SESSION['msgEn']))echo ControleSessao::buscarVariavel('msgEn'); ?>
                                </span>
                                <!--<input class="botao" name="registrar" type="submit" value="Registrar" />-->                                    
                            </div>      
                            <?php } ?>                           
                        </div>
                    <?php } ?>                        
                <?php                    
                }else{
                ?>
                <br />
                <div style="width: 100%; float: left; padding: 3px; cursor: pointer; margin: -5px"><img onclick="atualizaListaBaixasAutomaticas(<?php echo ControleSessao::buscarObjeto('objVaga')->id_vaga; ?>);" onMouseOver="this.src='../../../Utilidades/Imagens/bancodeoportunidades/refresh-a.png';" onMouseOut="this.src='../../../Utilidades/Imagens/bancodeoportunidades/refresh.png'" id="imagemrefreshTodos" src="../../../Utilidades/Imagens/bancodeoportunidades/refresh.png" style="width: 25px;" title="Atualizar a lista de baixas automáticas"></div>
                <div class="filtro_label" style="padding: 5px 0px 0px 5px; float: left; margin: -25px 0px 15px 50px;" >                    
                    *Baixas automáticas dos candidatos ocorrem quando eles ficam mais de 30 dias com o status de encaminhado para esta vaga.
                </div>
                <div id="tabela_baixas_automaticas_div_pesq"></div>
                <table id="tabela_baixas_automaticas_pesq" width="100%" class='tabela_encaminhados'>
                    <tr class='table_formacao_cab'>
                        <td>&nbsp;</td>
                    </tr>
                    <tr class='table_formacao_row'>
                        <td style='height: 300px;'>
                            <center>
                                <b style="font-size: 20px;">
                                    <?php                                
                                        if(ControleSessao::buscarObjeto('objVaga')->pesqBaixasAutomaticas){
                                            echo "Não há resultados para sua busca por baixas automáticas!";
                                        }else{
                                            echo "Não há baixas automáticas para esta vaga";
                                        }
                                    ?>
                                </b>
                            </center>
                        </td>
                    </tr>
                </table>  
                <?php
                }
                ?>
            </div>
            
            <?php // echo Servicos::montarHistoricoCandidato(617, 96); ?>
            
            <?php 
            //$x=0;
            foreach($baixasAutomaticas as $vc){
                if(!Validacao::validarNulo($vc)){
                //$x++; 
            ?>
                <!--Aba de visualizar curriculos-->
                <div colspan="4" class="white_content_candidato_baixa selecionados" id="dadosCandidatoSelecionadoBaixa_<?php echo $vc->id_candidato; ?>">
                    <div id="dadosCandidatoBaixa">
                        <?php echo Servicos::buscarDadosCandidatoPorId($vc->id_candidato); ?>
                    </div>                    
                    <div class="log_bottom">
                        <form id="formImprimir" name="formImprimir" method="post" action="../controle/ControleVaga.php?op=imprimir">
                            <input type="hidden" name="id_candidato" value="<?php echo $vc->id_candidato; ?>">
                            <input <?php echo $disabled; ?> type="submit" name="curriculo" value="Imprimir Currículo" class="botao" />
                        </form>
                        <p>
                        Para fechar, 
                        <a class="link_incluir" href="javascript:void(0)" onclick="fecharDadosCandidatoBaixa('dadosCandidatoSelecionadoBaixa_<?php echo $vc->id_candidato; ?>');">clique aqui</a>
                        .</p>                        
                    </div>
                </div>
                <!--<div colspan="4" id="black_overlay_baixa" class="black_overlay_baixa"></div>-->
                
                <!--Aba de visualizar histórico-->
                <div colspan="4" class="white_content_candidato_baixa selecionados" id="dadosHistoricoSelecionadoBaixa_<?php echo $vc->id_vagacandidato; ?>">
                    <div id="dadosHistoricoCandidatoBaixa">
                        <?php 
                        echo Servicos::montarHistoricoCandidato($vc->id_candidato, ControleSessao::buscarObjeto('privateEmp')->id_empresa); ?>
                    </div>                   
                    <div class="log_bottom">
                        <!--<form id="formImprimir" name="formImprimir" method="post" action="../controle/ControleVaga.php?op=imprimir">
                            <input type="hidden" name="id_candidato" value="<?php //echo $vc->id_candidato; ?>">
                            <input type="submit" name="curriculo" value="Imprimir Currículo" class="botao" />
                        </form>-->
                        <p>
                        Para fechar, 
                        <a class="link_incluir" href="javascript:void(0)" onclick="fecharHistoricoCandidatoBaixa('dadosHistoricoSelecionadoBaixa_<?php echo $vc->id_vagacandidato; ?>');">clique aqui</a>
                        .</p>                        
                    </div>
                </div>
                <div colspan="4" id="black_overlay_baixa" class="black_overlay_baixa"></div>
            <?php }
            }
            ?>
        </div>
        <!-- #######################################PRÉ-SELECIONADOS####################################### -->
        <div id="parte-05">
            <div id="loading" align="center" style="display: none;">
                <div id="aguarde" style="background-color:#ffffff;position:absolute;color:#000033;top:50%;left:30%;border:2px solid #cccccc; width:300;font-size:12px;z-index:0;">
                    <br><img src="../../../Utilidades/Imagens/bancodeoportunidades/loading.gif" border="0" align="middle"> Aguarde! Carregando Dados...<br><br>
                </div>
            </div>
            <fieldset>
                <legend class="legend">Filtro</legend>
                <form name="filtro" id="filtroVaga" method="post" action="../controle/ControleVaga.php?op=pesquisarPreSelecionados">
                    <div>
                        <table class="tabela_relatorio" border="0" style="margin-bottom: -20px;">
                            <tr>                                
                                <td colspan="3">
                                    <input type="hidden" name="filtro_status" id="filtro_status" value="P" />
                                    <?php //Passando os campos pra busca para poder retonar na sessão. ?>
                                    <input type="hidden" name="encaminhados" id="encaminhadosP" value="<?php echo $totalEncaminhados; ?>" />
                                    <input type="hidden" name="baixasAutomaticas" id="baixasAutomaticasP" value="<?php echo $totalBaixasAutomaticas; ?>" />
                                    <input type="hidden" name="preSelecionados" id="preSelecionadosP" value="<?php echo $totalPreSelecionados; ?>" />
                                    <input type="hidden" name="contratados" id="contratadosP" value="<?php echo $totalContratados;?>" />
                                    <input type="hidden" name="dispensados" id="dispensadosP" value="<?php echo $totalDispensandos; ?>" />                                    
                                
                                    <div style="float: left;">
                                        <label class="filtro_label">Código:</label>                                        
                                        <input value="<?php if(isset($_SESSION['post'])){echo $_SESSION['post']['filtro_codigo_preSelecionados'];} ?>" type="text" name="filtro_codigo" id="filtro_codigo_pre_selecionados" class="campo largura" style="width: 70px;" onkeypress="document.getElementById('filtro_nome_pre_selecionados').value = ''; return valida_numero(event);" />
                                    
                                        <label class="filtro_label">Nome:</label>                                        
                                        <input value="<?php if(isset($_SESSION['post'])){echo $_SESSION['post']['filtro_nome_preSelecionados'];} ?>" type="text" name="filtro_nome" id="filtro_nome_pre_selecionados" class="campo largura" style="width: 150px;" onkeypress="document.getElementById('filtro_codigo_pre_selecionados').value = ''; return bloqueia_numeros(event);" />
                                    
                                        <input type="submit" name="buscar" value="Buscar" class="botao"/>
                                        
                                        <?php 
                                            if(isset($_SESSION['errosV']) && in_array('filtro_codigo',$_SESSION['errosV'])){ 
                                        ?>
                                        <span class="style1"><b>* Valor digitado inválido! Somente números.</b></span>
                                        <?php
                                            }
                                        ?>
                                        
                                        <?php 
                                            if(isset($_SESSION['errosV']) && in_array('filtro_nome',$_SESSION['errosV'])){ 
                                        ?>
                                        <span class="style1"><b>* Valor digitado inválido! Somente letras.</b></span>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                </td>
                                <td colspan="2" align="right">
                                    <?php
                                        //Processo de contar a quantidade de candidatos feito na aba de todas as vagas
                                        echo "<b>".Servicos::buscarProfissaoPorId($v->id_profissao)->nm_profissao."</b></br>(".$mostraQtdVaga.")";
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <hr style="border: 1px solid #EE7228;">
                                </td>
                            </tr>                            
                            <tr class="filtro_label">
                                <td align="center" style="width: 20%; color: #D3D3D3;"><b>Encaminhados:</b> <span id="totalEncaminhadosP"><?php echo $totalEncaminhados; ?></span></td>
                                <td align="center" style="width: 20%; color: #D3D3D3;"><b>Baixas Automáticas:</b> <span id="totalBaixasAutomaticasP"><?php echo $totalBaixasAutomaticas; ?></span></td>
                                <td align="center" style="width: 20%; "><b>Pré-Selecionados:</b> <span id="totalPreSelecionadosP"><?php echo $totalPreSelecionados; ?></span></td>
                                <td align="center" style="width: 20%; color: #D3D3D3;"><b>Contratados:</b> <span id="totalContratadosP"><?php echo $totalContratados;?></span></td>
                                <td align="center" style="width: 20%; color: #D3D3D3;"><b>Dispensados:</b> <span id="totalDispensadosP"><?php echo $totalDispensandos; ?></span></td>
                            </tr>
                        </table>                        
                    </div>
                    <div>                                                
                    </div>
                </form>
            </fieldset>
            
            <div class="tab_adiciona" <?php echo (!ControleSessao::buscarObjeto('objVaga')->preSelecionados) ? 'style="padding-bottom: 100px;"' : ''; ?>>
                <?php
                
                if((ControleSessao::buscarObjeto('objVaga')->preSelecionados) && ($totalPreSelecionados > 0) ){
                    //var_dump(ControleSessao::buscarObjeto('objVaga'));
                    include_once '../modelo/VagaCandidatoVO.class.php';                    
                    if(count(ControleSessao::buscarObjeto('objVaga')->preSelecionados)>0){
                        
                        //define a quantidade de resultados da lista
                        $qtdPS = 10;
                        //busca a page atual
                        $pagePS = (isset($_GET['ps'])) ? $_GET['ps'] : 0;
                        //recebo um novo array com apenas os elemento necessarios para essa page atual
                        $preSelecionados = Servicos::listar(ControleSessao::buscarObjeto('objVaga')->preSelecionados, $qtdPS, $pagePS);
                                                                                                    
                        ?>
                        <div>                            
                            <form id="formImprimir" name="formImprimir" method="post" action="../controle/ControleVaga.php?op=imprimir">
                                <div style="float: left; padding: 3px; cursor: pointer;"><img onclick="atualizaListaPreSelecionados(<?php echo ControleSessao::buscarObjeto('objVaga')->id_vaga; ?>);" onMouseOver="this.src='../../../Utilidades/Imagens/bancodeoportunidades/refresh-a.png';" onMouseOut="this.src='../../../Utilidades/Imagens/bancodeoportunidades/refresh.png'" id="imagemrefreshTodos" src="../../../Utilidades/Imagens/bancodeoportunidades/refresh.png" style="width: 25px;" title="Atualizar a lista de candidatos pré-selecionados"></div>
                                <div class="botao_lista" >
                                    <input type="hidden" name="id_vaga" value="<?php 
                                        $v = ControleSessao::buscarObjeto('objVaga');
                                        echo $v->id_vaga; ?>">
                                    <input <?php echo $disabled; ?> type="submit" name="lista" value="Imprimir Lista" class="botao"/>                                   
                                </div>
                            </form>
                            <!--<form id="formImprimir" name="formImprimir" method="post" action="../controle/ControleVaga.php?op=imprimirCurriculos">-->
                                <!--<div class="botoes_imprimir" align="right">
                                    <input type="submit" value="Imprimir Currículo" class="botao"/>
                                    <label class="filtro_label">Marcar Todos</label>
                                    <input type="checkbox" name="imprimirTodos" id="todos" value="" onclick="marcardesmarcar();">
                                </div>-->
                            <!--</form>-->
                            
                            <?php if(isset($_SESSION['msgImp'])){ ?>
                                <span class="msg" style="margin-left: 565px;"><?php echo ControleSessao::buscarVariavel('msgImp'); ?></span>
                            <?php } ?>
                            <div id="tabela_pre_selecionados_div"></div>
                            <table width="100%" border="0" id="tabela_pre_selecionados" class="tabela_encaminhados">
                                <tr class="table_formacao_cab">
                                    <td align='center' width="5%">Código</td>
                                    <td align='center' width="28%">Nome</td>
                                    <td align='center' width="10%">Telefone</td>
                                    <td align='center' width="25%">Email</td>
                                    <td align='center' width="12%">Status</td>
                                    <td align='center' width="5%">Histórico</td>
                                    <td align='center' width="5%">Visualizar</td>
                                    <td align='center' width="5%">Imprimir</td>
                                </tr>
                                <?php
                                $cont=0;
                                
                                //var_dump(ControleSessao::buscarObjeto('objVaga')->encaminhados[0]);
                                foreach($preSelecionados as $vc){                                    
                                    if(!Validacao::validarNulo($vc)){ 
                                    $cont++;                                    
                                ?>
                                    <form name="formSinalizarPre" id="formSinalizarPre_<?php echo $vc->id_candidato; ?>" method="post" action="../controle/ControleVaga.php?op=sinalizarEnc" />
                                    <tr class="tabela_linha_todos" id="linha_pre_p_<?php echo $vc->id_vagacandidato; ?>">
                                            <td align="center"><?php echo $vc->id_candidato; ?></td>
                                            <td>                                                
                                                <label style="color: black; font-weight: bold;"><?php echo $vc->nm_candidato; ?></label><br />                                                
                                                <?php
                                                    //Mostra a deficiência caso o candidato tenha.
                                                    if(!is_null($vc->id_deficiencia)){
                                                        if($vc->ao_sexo == "M"){
                                                            $sexoTodos = "Candidato";
                                                        }else{
                                                            $sexoTodos = "Candidata";
                                                        }
                                                        $deficienciaTodos = "(".$sexoTodos." com deficiência <b>".Servicos::buscarDeficienciaPorId($vc->id_deficiencia)."</b>)";
                                                    }else{
                                                        $deficienciaTodos = "";
                                                    }
                                                ?>
                                                <i><?php echo $deficienciaTodos; ?></i>
                                            </td>              
                                            <td style="text-align: center;">                                                
                                                <?php
                                                    $telefone = $vc->nr_telefone;
                                                    if(!empty($telefone)){ 
                                                        echo $telefone;
                                                    }else{
                                                        echo $vc->nr_celular;
                                                    }
                                                ?>
                                            </td>
                                            <td><?php echo $vc->ds_email; ?></td>
                                            <td align="left">
                                                <div id="pre_t_<?php echo $vc->id_vagacandidato; ?>">
                                                <?php if($vc->ao_status == 'E'){ ?>                                                    
                                                    <input <?php echo $disabled; ?> id="candidato_E_pre_<?php echo $vc->id_candidato; ?>" name="<?php echo $vc->id_candidato; ?>" type="radio" value="E" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'E')||($vc->ao_status == 'E')) echo 'checked'; ?> onclick="alterarStatus('<?php echo $vc->id_vagacandidato; ?>', 'E'); ocultarSelectMotivosPre('<?php echo $vc->id_candidato; ?>');" />Encaminhado<br>
                                                    <input <?php echo $disabled; ?> id="candidato_P" name="<?php echo $vc->id_candidato; ?>" type="radio" value="P" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'P')||($vc->ao_status == 'P')) echo 'checked'; ?> onclick="if(confirm('Enviar email para o candidato <?php echo $vc->nm_candidato; ?> como pré-selecionado?')){ 
                                                                                                                                                                                                                                                                                                                                                    alterarStatus('<?php echo $vc->id_vagacandidato; ?>', 'P', '<?php echo $vc->id_vaga; ?>', '<?php echo $_SESSION['id_usuario']; ?>');                                                                                                                                                                                                                                                                                                                                                    
                                                                                                                                                                                                                                                                                                                                                    ocultarSelectMotivosPre('<?php echo $vc->id_candidato; ?>');
                                                                                                                                                                                                                                                                                                                                                    
                                                                                                                                                                                                                                                                                                                                                }else{                                                                                                                                                                                                                                                                                                                                                    
                                                                                                                                                                                                                                                                                                                                                    document.getElementById('candidato_E_pre_<?php echo $vc->id_candidato; ?>').checked = true;
                                                                                                                                                                                                                                                                                                                                                }" />Pré-selecionado<br>
                                                    <input <?php echo $disabled; ?> id="candidato_C" name="<?php echo $vc->id_candidato; ?>" type="radio" value="C" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'C')||($vc->ao_status == 'C')) echo 'checked'; ?> onclick="if(confirm('Contratar candidato?')){
                                                                                                                                                                                                                                                                                        alterarStatus('<?php echo $vc->id_vagacandidato; ?>', 'C', '<?php echo $vc->id_vaga; ?>', '<?php echo $_SESSION['id_usuario']; ?>'); 
                                                                                                                                                                                                                                                                                        ocultarSelectMotivosPre('<?php echo $vc->id_candidato; ?>');                                                                                                                                                                                                                                                                                        
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
                                                                                                                                                                                                                                                                                    }else{                                                                                                                                                                                                                                                                                        
                                                                                                                                                                                                                                                                                        document.getElementById('candidato_E_pre_<?php echo $vc->id_candidato; ?>').checked = true;
                                                                                                                                                                                                                                                                                    }" />Contratado<br>
                                                    <input <?php echo $disabled; ?> id="candidato_D" name="<?php echo $vc->id_candidato; ?>" type="radio" value="D" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'D')||($vc->ao_status == 'D')) echo 'checked'; ?> onclick="mostrarSelectMotivosPre('<?php echo $vc->id_candidato; ?>');" />Dispensado
                                                <?php
                                                }else{
                                                    if($vc->ao_status == 'C'){
                                                        echo 'Contratação já sinalizada';                                                        
                                                    }else if($vc->ao_status == 'D'){ 
                                                        echo 'Dispensa já sinalizada'; 
                                                    }else if($vc->ao_status == 'B'){
                                                        echo 'Baixa automática';
                                                    }else if($vc->ao_status == 'P'){ ?>
                                                        <div id="div_p2_p_<?php echo $vc->id_vagacandidato; ?>">
                                                            <input id="candidato_P_pre_<?php echo $vc->id_candidato; ?>" name="<?php echo $vc->id_candidato; ?>" type="radio" value="P" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'P')||($vc->ao_status == 'P')) echo 'checked'; ?> disabled />Pré-selecionado<br>
                                                            <input <?php echo $disabled; ?> id="candidato_C" name="<?php echo $vc->id_candidato; ?>" type="radio" value="C" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'C')||($vc->ao_status == 'C')) echo 'checked'; ?> onclick="if(confirm('Contratar candidato?')){                                                                                                                                                                                                                                                                                            
                                                                                                                                                                                                                                                                                            alterarStatus('P','<?php echo $vc->id_vagacandidato; ?>', 'C', '<?php echo $vc->id_vaga; ?>', '<?php echo $_SESSION['id_usuario']; ?>');
                                                                                                                                                                                                                                                                                            ocultarSelectMotivosPre('<?php echo $vc->id_candidato; ?>'); 
                                                                                                                                                                                                                                                                                             
                                                                                                                                                                                                                                                                                        }else{                                                                                                                                                                                                                                                                                             
                                                                                                                                                                                                                                                                                             document.getElementById('candidato_P_pre_<?php echo $vc->id_candidato; ?>').checked = true;
                                                                                                                                                                                                                                                                                        }" />Contratado<br>
                                                            <input <?php echo $disabled; ?> id="candidato_D" name="<?php echo $vc->id_candidato; ?>" type="radio" value="D" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'D')||($vc->ao_status == 'D')) echo 'checked'; ?> onclick="mostrarSelectMotivosPre('<?php echo $vc->id_candidato; ?>');"/>Dispensado
                                                        </div>
                                                <?php 
                                                    }
                                                }
                                                ?>
                                                </div>
                                            </td>                                            
                                            <?php 
                                            $historico = Servicos::verificarHistoricoCandidato($vc->id_candidato, ControleSessao::buscarObjeto('privateEmp')->id_empresa);
                                            if($historico>0){ 
                                            ?>
                                                <td align='center'>
                                                    <img src='../../../Utilidades/Imagens/bancodeoportunidades/historico.png' width="28" onclick="abrirHistoricoCandidatoPre('dadosHistoricoSelecionadoPre_<?php echo $vc->id_vagacandidato; ?>');" value="" title="Visualizar histórico de <?php echo $vc->nm_candidato; ?>" style="cursor: pointer;" />
                                                </td>
                                            <?php 
                                            }else{ 
                                            ?>
                                                <td align='center'>
                                                    <img src='../../../Utilidades/Imagens/bancodeoportunidades/historico_disabled.png' title='Candidato sem histórico' width="28" />
                                                </td>
                                            <?php 
                                            } 
                                            ?>
                                            <td align='center'>
                                                <input type="button" class="btn_visualizar" onclick="abrirDadosCandidatoPre('dadosCandidatoSelecionadoPre_<?php echo $vc->id_candidato; ?>');" value="" title="Visualizar currículo de <?php echo $vc->nm_candidato; ?>" />
                                            </td>
                                            <!--<td align="center">
                                                <input type="checkbox" class="marcar" id="pag_perfil" name="imprimir[]" value="<?php //echo $vc->id_candidato; ?>" />
                                            </td>-->
                                            <td align="center">
                                                <input <?php echo $disabled; ?> type="submit" name="imprimir" value="" class="btn_imprimir" title="Imprimir currículo de <?php echo $vc->nm_candidato; ?>" />
                                                <input type="hidden" name="id_candidato" id="id_candidato" value="<?php echo $vc->id_candidato; ?>">                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8">                                                
                                                
                                                <div id="candidatoPre_<?php echo $vc->id_candidato; ?>" style="display: none;">
                                                   <span class="style1">*</span>
                                                   <span>
                                                        Motivo:                                                
                                                       <select onchange="mostrarCampoMotivoDispensaPre(<?php echo $vc->id_candidato; ?>);" name="id_motivo" id="id_motivoPre_<?php echo $vc->id_candidato; ?>" <?php echo (isset($_SESSION['errosV']) && in_array('id_motivo',$_SESSION['errosV'])) ? 'class="campo_erro select"' : 'class="campo select"'; ?>>
                                                        <option value="Selecione">Selecione</option>
                                                            <?php
                                                            $motivos = Servicos::buscarMotivos();
                                                            foreach($motivos as $m){
                                                            ?>
                                                                <option value="<?php echo $m->id_motivo; ?>" <?php if(isset($_SESSION['errosV']) && (isset($_SESSION['post']['id_motivo']) && $_SESSION['post']['id_motivo'] == $m->id_motivo)) { echo 'selected';} ?> ><?php echo $m->ds_motivo; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                            <option value="Outros">Outros</option>
                                                        </select>
                                                        <?php echo Servicos::verificarErro('errosV', 'id_motivo', '* Selecione um dado.'); ?>
                                                   </span>
                                                   
                                                   <span id="mostrarMotivoPre_<?php echo $vc->id_candidato; ?>" style="display: none;">
                                                       Descrição Motivo:
                                                       <input value="<?php if(isset($_SESSION['errosV'])){ echo $_SESSION['post']['ds_motivo']; } ?>" type="text" name="ds_motivo" id="ds_motivoPre_<?php echo $vc->id_candidato; ?>" size="50" maxlength="500" <?php echo (isset($_SESSION['errosV']) && in_array('ds_motivo',$_SESSION['errosV'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                                       <?php echo Servicos::verificarErro('errosV', 'ds_motivo'); ?>
                                                   </span>
                                                   
                                                   
                                                   <span id="inputEnviarPre_<?php echo $vc->id_candidato; ?>" style="display: none;">
                                                       <input <?php echo $disabled; ?> name="enviarMotivo" type="button" value="Enviar" class="botao" onclick="if(confirm('Tem certeza que deseja dispensar o candidato <?php echo $vc->nm_candidato; ?>?')){verificarSelectPre('P','<?php echo $vc->id_candidato; ?>', '<?php echo $vc->id_vagacandidato; ?>', 'D', '<?php echo $vc->id_vaga; ?>', '<?php echo $_SESSION['id_usuario']; ?>');}else{ document.getElementById('candidato_P_pre_<?php echo $vc->id_candidato; ?>').checked = true; ocultarSelectMotivosPre('<?php echo $vc->id_candidato; ?>'); return false; }" />                                                        
                                                       <input type="hidden" name="id_vagacandidato" id="id_vagacandidato" value="<?php echo $vc->id_vagacandidato; ?>">
                                                       <?php //informa ao sinalizarEnc do action do form, que este vem da aba dos pré-selecionados. ?>
                                                       <input type="hidden" name="vem_do" id="vem_do" value="P">
                                                   </span>                                                   
                                                </div>                                                
                                            </td>
                                        </tr>
                                    </form>
                                <?php
                                    }
                                }
                                ?>
                                <tr>                                    
                                    <td colspan="8">
                                        <table width="100%">
                                            <tr>
                                                <td class="cont_pagina" width="5%">
                                                    <?php 
                                                        //$total = count(ControleSessao::buscarObjeto('objVaga')->encaminhados);
                                                    
                                                        //conta qual é o total de pré-selecionados
                                                        $todos_encaminhados = ControleSessao::buscarObjeto('objVaga')->preSelecionados;
                                                        foreach($todos_encaminhados as $tenc){                                    
                                                            if($tenc->ao_status == 'P'){
                                                                $total_pre++;
                                                            }
                                                        }

                                                        echo ($pagePS * $qtdPS + $cont).'/'.$total_pre;
                                                    ?>                                                    
                                                </td>
                                                <td id="paginacao" align="center" width="95%">
                                                    <?php
                                                        //crio a paginacao propriamente dita
                                                        echo Servicos::criarPaginacaoPreSelecionados(ControleSessao::buscarObjeto('objVaga')->preSelecionados, $qtdPS, $pagePS,'#parte-05');
                                                    ?>                                                    
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <?php if(ControleSessao::buscarObjeto('objVaga')->ao_ativo == 'S'){ ?>
                            <div align="right">
                                <br/>
                                <span class="msg">
                                    <?php if(isset($_SESSION['msgEn']))echo ControleSessao::buscarVariavel('msgEn'); ?>
                                </span>
                                <!--<input class="botao" name="registrar" type="submit" value="Registrar" />-->                                    
                            </div>      
                            <?php } ?>                           
                        </div>
                    <?php } ?>                        
                <?php                    
                }else{
                ?>                
                <br />
                <div style="width: 100%; float: left; padding: 3px; cursor: pointer;"><img onclick="atualizaListaPreSelecionados(<?php echo ControleSessao::buscarObjeto('objVaga')->id_vaga; ?>);" onMouseOver="this.src='../../../Utilidades/Imagens/bancodeoportunidades/refresh-a.png';" onMouseOut="this.src='../../../Utilidades/Imagens/bancodeoportunidades/refresh.png'" id="imagemrefreshTodos" src="../../../Utilidades/Imagens/bancodeoportunidades/refresh.png" style="width: 25px;" title="Atualizar a lista de candidatos pré-selecionados"></div>
                <div id="tabela_pre_selecionados_div_pesq"></div>
                <table id="tabela_pre_selecionados_pesq" width="100%" class='tabela_encaminhados'>
                    <tr class='table_formacao_cab'>
                        <td>&nbsp;</td>
                    </tr>
                    <tr class='table_formacao_row'>
                        <td style='height: 300px;'>
                            <center>
                                <b style="font-size: 20px;">
                                    <?php                                
                                        if(ControleSessao::buscarObjeto('objVaga')->pesqPreSelecionados){
                                            echo "Não há resultados para sua busca por candidatos pré-selecionados!";
                                        }else{
                                            echo "Não há candidatos pré-selecionados para esta vaga";
                                        }
                                    ?>
                                </b>
                            </center>
                        </td>
                    </tr>
                </table>  
                <?php
                }
                ?>
            </div>
            
            <?php // echo Servicos::montarHistoricoCandidato(617, 96); ?>
            
            <?php 
            //$x=0;
            foreach($preSelecionados as $vc){
                if(!Validacao::validarNulo($vc)){
                //$x++; 
            ?>
                <!--Aba de visualizar curriculos-->
                <div colspan="4" class="white_content_candidato_pre selecionados" id="dadosCandidatoSelecionadoPre_<?php echo $vc->id_candidato; ?>">
                    <div id="dadosCandidatoPre">
                        <?php echo Servicos::buscarDadosCandidatoPorId($vc->id_candidato); ?>
                    </div>                    
                    <div class="log_bottom">
                        <form id="formImprimir" name="formImprimir" method="post" action="../controle/ControleVaga.php?op=imprimir">
                            <input type="hidden" name="id_candidato" value="<?php echo $vc->id_candidato; ?>">
                            <input <?php echo $disabled; ?> type="submit" name="curriculo" value="Imprimir Currículo" class="botao" />
                        </form>
                        <p>
                        Para fechar, 
                        <a class="link_incluir" href="javascript:void(0)" onclick="fecharDadosCandidatoPre('dadosCandidatoSelecionadoPre_<?php echo $vc->id_candidato; ?>');">clique aqui</a>
                        .</p>                        
                    </div>
                </div>
                <!--<div colspan="4" id="black_overlay_pre" class="black_overlay_pre"></div>-->
                
                <!--Aba de visualizar histórico-->
                <div colspan="4" class="white_content_candidato_pre selecionados" id="dadosHistoricoSelecionadoPre_<?php echo $vc->id_vagacandidato; ?>">
                    <div id="dadosHistoricoCandidatoPre">
                        <?php 
                        echo Servicos::montarHistoricoCandidato($vc->id_candidato, ControleSessao::buscarObjeto('privateEmp')->id_empresa); ?>
                    </div>                   
                    <div class="log_bottom">
                        <!--<form id="formImprimir" name="formImprimir" method="post" action="../controle/ControleVaga.php?op=imprimir">
                            <input type="hidden" name="id_candidato" value="<?php //echo $vc->id_candidato; ?>">
                            <input type="submit" name="curriculo" value="Imprimir Currículo" class="botao" />
                        </form>-->
                        <p>
                        Para fechar, 
                        <a class="link_incluir" href="javascript:void(0)" onclick="fecharHistoricoCandidatoPre('dadosHistoricoSelecionadoPre_<?php echo $vc->id_vagacandidato; ?>');">clique aqui</a>
                        .</p>                        
                    </div>
                </div>
                <div colspan="4" id="black_overlay_pre" class="black_overlay_pre"></div>
            <?php }
            }
            ?>
        </div>
        <!-- #######################################CONTRATADOS####################################### -->
        <div id="parte-06">
            <div id="loading" align="center" style="display: none;">
                <div id="aguarde" style="background-color:#ffffff;position:absolute;color:#000033;top:50%;left:30%;border:2px solid #cccccc; width:300;font-size:12px;z-index:0;">
                    <br><img src="../../../Utilidades/Imagens/bancodeoportunidades/loading.gif" border="0" align="middle"> Aguarde! Carregando Dados...<br><br>
                </div>
            </div>
            <fieldset>
                <legend class="legend">Filtro</legend>
                <form name="filtro" id="filtroVaga" method="post" action="../controle/ControleVaga.php?op=pesquisarContratados">
                    <div>
                        <table class="tabela_relatorio" border="0" style="margin-bottom: -20px;">
                            <tr>                                
                                <td colspan="3">                                    
                                    <input type="hidden" name="filtro_status" id="filtro_status" value="C" />
                                    <?php //Passando os campos pra busca para poder retonar na sessão. ?>
                                    <input type="hidden" name="encaminhados" id="encaminhadosC" value="<?php echo $totalEncaminhados; ?>" />
                                    <input type="hidden" name="baixasAutomaticas" id="baixasAutomaticasC" value="<?php echo $totalBaixasAutomaticas; ?>" />
                                    <input type="hidden" name="preSelecionados" id="preSelecionadosC" value="<?php echo $totalPreSelecionados; ?>" />
                                    <input type="hidden" name="contratados" id="contratadosC" value="<?php echo $totalContratados;?>" />
                                    <input type="hidden" name="dispensados" id="dispensadosC" value="<?php echo $totalDispensandos; ?>" />                                    
                                
                                    <div style="float: left;">
                                        <label class="filtro_label">Código:</label>                                        
                                        <input value="<?php if(isset($_SESSION['post'])){echo $_SESSION['post']['filtro_codigo_contratados'];} ?>" type="text" name="filtro_codigo" id="filtro_codigo_contratados" class="campo largura" style="width: 70px;" onkeypress="document.getElementById('filtro_nome_contratados').value = ''; return valida_numero(event);" />
                                    
                                        <label class="filtro_label">Nome:</label>                                        
                                        <input value="<?php if(isset($_SESSION['post'])){echo $_SESSION['post']['filtro_nome_contratados'];} ?>" type="text" name="filtro_nome" id="filtro_nome_contratados" class="campo largura" style="width: 150px;" onkeypress="document.getElementById('filtro_codigo_contratados').value = ''; return bloqueia_numeros(event);" />
                                    
                                        <input type="submit" name="buscar" value="Buscar" class="botao"/>
                                        
                                        <?php 
                                            if(isset($_SESSION['errosV']) && in_array('filtro_codigo',$_SESSION['errosV'])){ 
                                        ?>
                                        <span class="style1"><b>* Valor digitado inválido! Somente números.</b></span>
                                        <?php
                                            }
                                        ?>
                                        
                                        <?php 
                                            if(isset($_SESSION['errosV']) && in_array('filtro_nome',$_SESSION['errosV'])){ 
                                        ?>
                                        <span class="style1"><b>* Valor digitado inválido! Somente letras.</b></span>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                </td>
                                <td colspan="2" align="right">
                                    <?php
                                        //Processo de contar a quantidade de candidatos feito na aba de todas as vagas
                                        echo "<b>".Servicos::buscarProfissaoPorId($v->id_profissao)->nm_profissao."</b></br>(".$mostraQtdVaga.")";
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <hr style="border: 1px solid #EE7228;">
                                </td>
                            </tr>                            
                            <tr class="filtro_label">
                                <td align="center" style="width: 20%; color: #D3D3D3;"><b>Encaminhados:</b> <span id="totalEncaminhadosC"><?php echo $totalEncaminhados; ?></span></td>
                                <td align="center" style="width: 20%; color: #D3D3D3;"><b>Baixas Automáticas:</b> <span id="totalBaixasAutomaticasC"><?php echo $totalBaixasAutomaticas; ?></span></td>
                                <td align="center" style="width: 20%; color: #D3D3D3;"><b>Pré-Selecionados:</b> <span id="totalPreSelecionadosC"><?php echo $totalPreSelecionados; ?></span></td>
                                <td align="center" style="width: 20%;"><b>Contratados:</b> <span id="totalContratadosC"><?php echo $totalContratados;?></span></td>
                                <td align="center" style="width: 20%; color: #D3D3D3;"><b>Dispensados:</b> <span id="totalDispensadosC"><?php echo $totalDispensandos; ?></span></td>
                            </tr>
                        </table>                        
                    </div>
                    <div>                                                
                    </div>
                </form>
            </fieldset>
            
            <div class="tab_adiciona" <?php echo (!ControleSessao::buscarObjeto('objVaga')->contratados) ? 'style="padding-bottom: 100px;"' : ''; ?>>
                <?php
                
                
                if((ControleSessao::buscarObjeto('objVaga')->contratados) && ($totalContratados > 0)  ){
                    //var_dump(ControleSessao::buscarObjeto('objVaga'));
                    include_once '../modelo/VagaCandidatoVO.class.php';                    
                    if(count(ControleSessao::buscarObjeto('objVaga')->contratados)>0){
                        
                        //define a quantidade de resultados da lista
                        $qtdCO = 10;
                        //busca a page atual
                        $pageCO = (isset($_GET['co'])) ? $_GET['co'] : 0;
                        
                        //recebo um novo array com apenas os elemento necessarios para essa page atual
                        $contratados = Servicos::listar(ControleSessao::buscarObjeto('objVaga')->contratados, $qtdCO, $pageCO);
                        
                        ?>
                        <div>                            
                            <form id="formImprimir" name="formImprimir" method="post" action="../controle/ControleVaga.php?op=imprimir">
                                <div style="float: left; padding: 3px; cursor: pointer;"><img onclick="atualizaListaContratados(<?php echo ControleSessao::buscarObjeto('objVaga')->id_vaga; ?>);" onMouseOver="this.src='../../../Utilidades/Imagens/bancodeoportunidades/refresh-a.png';" onMouseOut="this.src='../../../Utilidades/Imagens/bancodeoportunidades/refresh.png'" id="imagemrefreshTodos" src="../../../Utilidades/Imagens/bancodeoportunidades/refresh.png" style="width: 25px;" title="Atualizar a lista de candidatos contratados"></div>
                                <div class="botao_lista" >                                    
                                    <input type="hidden" name="id_vaga" value="<?php 
                                        $v = ControleSessao::buscarObjeto('objVaga');
                                        echo $v->id_vaga; ?>">
                                    <input <?php echo $disabled; ?> type="submit" name="lista" value="Imprimir Lista" class="botao"/>                                   
                                </div>
                            </form>
                            <!--<form id="formImprimir" name="formImprimir" method="post" action="../controle/ControleVaga.php?op=imprimirCurriculos">-->
                                <!--<div class="botoes_imprimir" align="right">
                                    <input type="submit" value="Imprimir Currículo" class="botao"/>
                                    <label class="filtro_label">Marcar Todos</label>
                                    <input type="checkbox" name="imprimirTodos" id="todos" value="" onclick="marcardesmarcar();">
                                </div>-->
                            <!--</form>-->
                            
                            <?php if(isset($_SESSION['msgImp'])){ ?>
                                <span class="msg" style="margin-left: 565px;"><?php echo ControleSessao::buscarVariavel('msgImp'); ?></span>
                            <?php } ?>
                            <div id="tabela_contratados_div_pesq"></div>
                            <table id="tabela_contratados_pesq" width="100%" border="0" class="tabela_encaminhados">
                                <tr class="table_formacao_cab">
                                    <td align='center' width="5%">Código</td>
                                    <td align='center' width="28%">Nome</td>
                                    <td align='center' width="10%">Telefone</td>
                                    <td align='center' width="25%">Email</td>
                                    <td align='center' width="12%">Status</td>
                                    <td align='center' width="5%">Histórico</td>
                                    <td align='center' width="5%">Visualizar</td>
                                    <td align='center' width="5%">Imprimir</td>
                                </tr>
                                <?php
                                $cont=0;
                                
                                //var_dump(ControleSessao::buscarObjeto('objVaga')->encaminhados[0]);
                                foreach($contratados as $vc){
                                    
                                    if($vc->ao_status == 'C'){
                                    if(!Validacao::validarNulo($vc)){ 
                                    $cont++;                                    
                                ?>
                                    <form name="formSinalizar" id="formSinalizar_<?php echo $vc->id_candidato; ?>" method="post" action="../controle/ControleVaga.php?op=sinalizar" />
                                        <tr class="tabela_linha_todos" style="height: 50px;">
                                            <td align="center"><?php echo $vc->id_candidato; ?></td>
                                            <td>                                                
                                                <label style="color: black; font-weight: bold;"><?php echo $vc->nm_candidato; ?></label><br />                                                
                                                <?php
                                                    //Mostra a deficiência caso o candidato tenha.
                                                    if(!is_null($vc->id_deficiencia)){
                                                        if($vc->ao_sexo == "M"){
                                                            $sexoTodos = "Candidato";
                                                        }else{
                                                            $sexoTodos = "Candidata";
                                                        }
                                                        $deficienciaTodos = "(".$sexoTodos." com deficiência <b>".Servicos::buscarDeficienciaPorId($vc->id_deficiencia)."</b>)";
                                                    }else{
                                                        $deficienciaTodos = "";
                                                    }
                                                ?>
                                                <i><?php echo $deficienciaTodos; ?></i>
                                            </td>               
                                            <td style="text-align: center;">                                                
                                                <?php
                                                    $telefone = $vc->nr_telefone;
                                                    if(!empty($telefone)){ 
                                                        echo $telefone;
                                                    }else{
                                                        echo $vc->nr_celular;
                                                    }
                                                ?>
                                            </td>
                                            <td><?php echo $vc->ds_email; ?></td>
                                            <td align="left">
                                                <?php if($vc->ao_status == 'E'){ ?>                                                    
                                                    <input <?php echo $disabled; ?> id="candidato_E" name="<?php echo $vc->id_candidato; ?>" type="radio" value="E" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'E')||($vc->ao_status == 'E')) echo 'checked'; ?> onclick="alterarStatus('<?php echo $vc->id_vagacandidato; ?>', 'E'); ocultarSelectMotivos('<?php echo $vc->id_candidato; ?>');" />Encaminhado<br>
                                                    <input <?php echo $disabled; ?> id="candidato_P" name="<?php echo $vc->id_candidato; ?>" type="radio" value="P" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'P')||($vc->ao_status == 'P')) echo 'checked'; ?> onclick="if(confirm('Enviar email para o candidato <?php echo $vc->nm_candidato; ?> como pré-selecionado?')){ 
                                                                                                                                                                                                                                                                                                                                                    alterarStatus('<?php echo $vc->id_vagacandidato; ?>', 'P', '<?php echo $vc->id_vaga; ?>', '<?php echo $_SESSION['id_usuario']; ?>');                                                                                                                                                                                                                                                                                                                                                    
                                                                                                                                                                                                                                                                                                                                                    ocultarSelectMotivos('<?php echo $vc->id_candidato; ?>');
                                                                                                                                                                                                                                                                                                                                                    $('input[name=buscar]').click();
                                                                                                                                                                                                                                                                                                                                                }else{                                                                                                                                                                                                                                                                                                                                                    
                                                                                                                                                                                                                                                                                                                                                    location.reload();                                                                                                                                                                                                                                                                                                                                                    
                                                                                                                                                                                                                                                                                                                                                }" />Pré-selecionado<br>
                                                    <input <?php echo $disabled; ?> id="candidato_C" name="<?php echo $vc->id_candidato; ?>" type="radio" value="C" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'C')||($vc->ao_status == 'C')) echo 'checked'; ?> onclick="if(confirm('Contratar candidato?')){
                                                                                                                                                                                                                                                                                        alterarStatus('<?php echo $vc->id_vagacandidato; ?>', 'C', '<?php echo $vc->id_vaga; ?>', '<?php echo $_SESSION['id_usuario']; ?>'); 
                                                                                                                                                                                                                                                                                        ocultarSelectMotivos('<?php echo $vc->id_candidato; ?>');                                                                                                                                                                                                                                                                                        
                                                                                                                                                                                                                                                                                        $('input[name=buscar]').click();                                                                                                                                                                                                                                                                                        
                                                                                                                                                                                                                                                                                    }else{                                                                                                                                                                                                                                                                                        
                                                                                                                                                                                                                                                                                        location.reload();
                                                                                                                                                                                                                                                                                    }" />Contratado<br>
                                                    <input id="candidato_D" name="<?php echo $vc->id_candidato; ?>" type="radio" value="D" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'D')||($vc->ao_status == 'D')) echo 'checked'; ?> onclick="mostrarSelectMotivos('<?php echo $vc->id_candidato; ?>');" />Dispensado
                                                <?php
                                                }else{
                                                    if($vc->ao_status == 'C'){
                                                        echo 'Contratação já sinalizada';                                                        
                                                    }else if($vc->ao_status == 'D'){ 
                                                        echo 'Dispensa já sinalizada'; 
                                                    }else if($vc->ao_status == 'B'){
                                                        echo 'Baixa automática';
                                                    }else if($vc->ao_status == 'P'){ ?>                                                            
                                                        <input id="candidato_P" name="<?php echo $vc->id_candidato; ?>" type="radio" value="P" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'P')||($vc->ao_status == 'P')) echo 'checked'; ?> disabled />Pré-selecionado<br>
                                                        <input <?php echo $disabled; ?> id="candidato_C" name="<?php echo $vc->id_candidato; ?>" type="radio" value="C" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'C')||($vc->ao_status == 'C')) echo 'checked'; ?> onclick="if(confirm('Contratar candidato?')){                                                                                                                                                                                                                                                                                            
                                                                                                                                                                                                                                                                                            alterarStatus('<?php echo $vc->id_vagacandidato; ?>', 'C', '<?php echo $vc->id_vaga; ?>', '<?php echo $_SESSION['id_usuario']; ?>');                                                                                                                                                                                                                                                                                            
                                                                                                                                                                                                                                                                                            ocultarSelectMotivos('<?php echo $vc->id_candidato; ?>'); 
                                                                                                                                                                                                                                                                                            $('input[name=buscar]').click(); 
                                                                                                                                                                                                                                                                                        }else{                                                                                                                                                                                                                                                                                             
                                                                                                                                                                                                                                                                                             location.reload();
                                                                                                                                                                                                                                                                                        }" />Contratado<br>
                                                        <input id="candidato_D" name="<?php echo $vc->id_candidato; ?>" type="radio" value="D" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'D')||($vc->ao_status == 'D')) echo 'checked'; ?> onclick="mostrarSelectMotivos('<?php echo $vc->id_candidato; ?>');"/>Dispensado
                                                <?php 
                                                    }
                                                }
                                                ?>
                                            </td>                                            
                                            <?php 
                                            $historico = Servicos::verificarHistoricoCandidato($vc->id_candidato, ControleSessao::buscarObjeto('privateEmp')->id_empresa);
                                            if($historico>0){ 
                                            ?>
                                                <td align='center'>
                                                    <img src='../../../Utilidades/Imagens/bancodeoportunidades/historico.png' width="28" onclick="abrirHistoricoCandidatoCon('dadosHistoricoSelecionadoCon_<?php echo $vc->id_vagacandidato; ?>');" value="" title="Visualizar histórico de <?php echo $vc->nm_candidato; ?>" style="cursor: pointer;" />
                                                </td>
                                            <?php 
                                            }else{ 
                                            ?>
                                                <td align='center'>
                                                    <img src='../../../Utilidades/Imagens/bancodeoportunidades/historico_disabled.png' title='Candidato sem histórico' width="28" />
                                                </td>
                                            <?php 
                                            } 
                                            ?>
                                            <td align='center'>
                                                <input type="button" class="btn_visualizar" onclick="abrirDadosCandidatoCon('dadosCandidatoSelecionadoCon_<?php echo $vc->id_candidato; ?>');" value="" title="Visualizar currículo de <?php echo $vc->nm_candidato; ?>" />
                                            </td>
                                            <!--<td align="center">
                                                <input type="checkbox" class="marcar" id="pag_perfil" name="imprimir[]" value="<?php //echo $vc->id_candidato; ?>" />
                                            </td>-->
                                            <td align="center">
                                                <input <?php echo $disabled; ?> type="submit" name="imprimir" value="" class="btn_imprimir" title="Imprimir currículo de <?php echo $vc->nm_candidato; ?>" />
                                                <input type="hidden" name="id_candidato" id="id_candidato" value="<?php echo $vc->id_candidato; ?>">
                                            </td>
                                        </tr>                                        
                                        <tr>
                                            <td colspan="8" id="candidato_<?php echo $vc->id_candidato; ?>" style="display: none;">                                                
                                                <div>
                                                   <span class="style1">*</span>
                                                   <span>
                                                        Motivo:                                                
                                                       <select onchange="mostrarCampoMotivoDispensa(<?php echo $vc->id_candidato; ?>);" name="id_motivo" id="id_motivo_<?php echo $vc->id_candidato; ?>" <?php echo (isset($_SESSION['errosV']) && in_array('id_motivo',$_SESSION['errosV'])) ? 'class="campo_erro select"' : 'class="campo select"'; ?>>
                                                        <option value="Selecione">Selecione</option>
                                                            <?php
                                                            $motivos = Servicos::buscarMotivos();
                                                            foreach($motivos as $m){
                                                            ?>
                                                                <option value="<?php echo $m->id_motivo; ?>" <?php if(isset($_SESSION['errosV']) && (isset($_SESSION['post']['id_motivo']) && $_SESSION['post']['id_motivo'] == $m->id_motivo)) { echo 'selected';} ?> ><?php echo $m->ds_motivo; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                            <option value="Outros">Outros</option>
                                                        </select>
                                                        <?php echo Servicos::verificarErro('errosV', 'id_motivo', '* Selecione um dado.'); ?>
                                                   </span>
                                                   
                                                   <span id="mostrarMotivo_<?php echo $vc->id_candidato; ?>" style="display: none;">
                                                       Descrição Motivo:
                                                       <input value="<?php if(isset($_SESSION['errosV'])){ echo $_SESSION['post']['ds_motivo']; } ?>" type="text" name="ds_motivo" id="ds_motivo_<?php echo $vc->id_candidato; ?>" size="50" maxlength="500" <?php echo (isset($_SESSION['errosV']) && in_array('ds_motivo',$_SESSION['errosV'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                                       <?php echo Servicos::verificarErro('errosV', 'ds_motivo'); ?>
                                                   </span>
                                                   
                                                   
                                                   <span id="inputEnviar_<?php echo $vc->id_candidato; ?>" style="display: none;">
                                                       <input <?php echo $disabled; ?> name="enviarMotivo" type="button" value="Enviar" class="botao" onclick="if(confirm('Tem certeza que deseja dispensar o candidato <?php echo $vc->nm_candidato; ?>?')){verificarSelect(<?php echo $vc->id_candidato; ?>);}else{ return false; }" />                                                        
                                                       <input type="hidden" name="id_vagacandidato" id="id_vagacandidato" value="<?php echo $vc->id_vagacandidato; ?>">
                                                   </span>                                                   
                                                </div>                                                
                                            </td>
                                        </tr>
                                    </form>
                                <?php
                                    }
                                  }
                                }
                                ?>
                                <tr>                                    
                                    <td colspan="8">
                                        <table width="100%">
                                            <tr>
                                                <td class="cont_pagina" width="5%">
                                                    <?php 
                                                        //$total = count(ControleSessao::buscarObjeto('objVaga')->encaminhados);
                                                    
                                                        //conta qual é o total de contratados
                                                        $todos_encaminhados = ControleSessao::buscarObjeto('objVaga')->contratados;
                                                        foreach($todos_encaminhados as $tenc){                                    
                                                            if($tenc->ao_status == 'C'){
                                                                $total_con++;
                                                            }
                                                        }

                                                        echo ($pageCO * $qtdCO + $cont).'/'.$total_con;
                                                    ?>                                                    
                                                </td>
                                                <td id="paginacao" align="center" width="95%">
                                                    <?php
                                                        //crio a paginacao propriamente dita
                                                        echo Servicos::criarPaginacaoContratados(ControleSessao::buscarObjeto('objVaga')->contratados, $qtdCO, $pageCO,'#parte-06');
                                                    ?>                                                    
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <?php if(ControleSessao::buscarObjeto('objVaga')->ao_ativo == 'S'){ ?>
                            <div align="right">
                                <br/>
                                <span class="msg">
                                    <?php if(isset($_SESSION['msgEn']))echo ControleSessao::buscarVariavel('msgEn'); ?>
                                </span>
                                <!--<input class="botao" name="registrar" type="submit" value="Registrar" />-->                                    
                            </div>      
                            <?php } ?>                           
                        </div>
                    <?php } ?>                        
                <?php                    
                }else{
                ?>                
                <br />
                <div style="width: 100%; float: left; padding: 3px; cursor: pointer;"><img onclick="atualizaListaContratados(<?php echo ControleSessao::buscarObjeto('objVaga')->id_vaga; ?>);" onMouseOver="this.src='../../../Utilidades/Imagens/bancodeoportunidades/refresh-a.png';" onMouseOut="this.src='../../../Utilidades/Imagens/bancodeoportunidades/refresh.png'" id="imagemrefreshTodos" src="../../../Utilidades/Imagens/bancodeoportunidades/refresh.png" style="width: 25px;" title="Atualizar a lista de candidatos contratados"></div>
                <div id="tabela_contratados_div_pesq"></div>
                <table id="tabela_contratados_pesq" width="100%" class='tabela_encaminhados'>
                    <tr class='table_formacao_cab'>
                        <td>&nbsp;</td>
                    </tr>
                    <tr class='table_formacao_row'>
                        <td style='height: 300px;'>
                            <center>
                                <b style="font-size: 20px;">
                                    <?php                                
                                        if(ControleSessao::buscarObjeto('objVaga')->pesqContratados){
                                            echo "Não há resultados para sua busca por candidatos contratados!";
                                        }else{
                                            echo "Não há candidatos contratados para esta vaga";
                                        }
                                    ?>
                                </b>
                            </center>
                        </td>
                    </tr>
                </table> 
                <?php
                }
                ?>
            </div>
            
            <?php // echo Servicos::montarHistoricoCandidato(617, 96); ?>
            
            <?php 
            //$x=0;
            foreach($contratados as $vc){
                if(!Validacao::validarNulo($vc)){
                //$x++; 
            ?>
                <!--Aba de visualizar curriculos-->
                <div colspan="4" class="white_content_candidato_con selecionados" id="dadosCandidatoSelecionadoCon_<?php echo $vc->id_candidato; ?>">
                    <div id="dadosCandidatoCon">
                        <?php echo Servicos::buscarDadosCandidatoPorId($vc->id_candidato); ?>
                    </div>                    
                    <div class="log_bottom">
                        <form id="formImprimir" name="formImprimir" method="post" action="../controle/ControleVaga.php?op=imprimir">
                            <input type="hidden" name="id_candidato" value="<?php echo $vc->id_candidato; ?>">
                            <input <?php echo $disabled; ?> type="submit" name="curriculo" value="Imprimir Currículo" class="botao" />
                        </form>
                        <p>
                        Para fechar, 
                        <a class="link_incluir" href="javascript:void(0)" onclick="fecharDadosCandidatoCon('dadosCandidatoSelecionadoCon_<?php echo $vc->id_candidato; ?>');">clique aqui</a>
                        .</p>                        
                    </div>
                </div>
                <!--<div colspan="4" id="black_overlay_con" class="black_overlay_con"></div>-->
                
                <!--Aba de visualizar histórico-->
                <div colspan="4" class="white_content_candidato selecionados" id="dadosHistoricoSelecionadoCon_<?php echo $vc->id_vagacandidato; ?>">
                    <div id="dadosHistoricoCandidatoCon">
                        <?php 
                        echo Servicos::montarHistoricoCandidato($vc->id_candidato, ControleSessao::buscarObjeto('privateEmp')->id_empresa); ?>
                    </div>                   
                    <div class="log_bottom">
                        <!--<form id="formImprimir" name="formImprimir" method="post" action="../controle/ControleVaga.php?op=imprimir">
                            <input type="hidden" name="id_candidato" value="<?php //echo $vc->id_candidato; ?>">
                            <input type="submit" name="curriculo" value="Imprimir Currículo" class="botao" />
                        </form>-->
                        <p>
                        Para fechar, 
                        <a class="link_incluir" href="javascript:void(0)" onclick="fecharHistoricoCandidatoCon('dadosHistoricoSelecionadoCon_<?php echo $vc->id_vagacandidato; ?>');">clique aqui</a>
                        .</p>                        
                    </div>
                </div>
                <div colspan="4" id="black_overlay_con" class="black_overlay_con"></div>
            <?php }
            }
            ?>
        </div>
        <!-- #######################################DISPENSADOS####################################### -->
        <div id="parte-07">
            <div id="loading" align="center" style="display: none;">
                <div id="aguarde" style="background-color:#ffffff;position:absolute;color:#000033;top:50%;left:30%;border:2px solid #cccccc; width:300;font-size:12px;z-index:0;">
                    <br><img src="../../../Utilidades/Imagens/bancodeoportunidades/loading.gif" border="0" align="middle"> Aguarde! Carregando Dados...<br><br>
                </div>
            </div>
            <fieldset>
                <legend class="legend">Filtro</legend>
                <form name="filtro" id="filtroVaga" method="post" action="../controle/ControleVaga.php?op=pesquisarDispensados">
                    <div>
                        <table class="tabela_relatorio" border="0" style="margin-bottom: -20px;">
                            <tr>                                
                                <td colspan="3">
                                    <input type="hidden" name="filtro_status" id="filtro_status" value="D" />
                                    <?php //Passando os campos pra busca para poder retonar na sessão. ?>
                                    <input type="hidden" name="encaminhados" id="encaminhadosD" value="<?php echo $totalEncaminhados; ?>" />
                                    <input type="hidden" name="baixasAutomaticas" id="baixasAutomaticasD" value="<?php echo $totalBaixasAutomaticas; ?>" />
                                    <input type="hidden" name="preSelecionados" id="preSelecionadosD" value="<?php echo $totalPreSelecionados; ?>" />
                                    <input type="hidden" name="contratados" id="contratadosD" value="<?php echo $totalContratados;?>" />
                                    <input type="hidden" name="dispensados" id="dispensadosD" value="<?php echo $totalDispensandos; ?>" />                                    
                                
                                    <div style="float: left;">
                                        <label class="filtro_label">Código:</label>                                        
                                        <input value="<?php if(isset($_SESSION['post'])){echo $_SESSION['post']['filtro_codigo_dispensados'];} ?>" type="text" name="filtro_codigo" id="filtro_codigo_dispensados" class="campo largura" style="width: 70px;" onkeypress="document.getElementById('filtro_nome_dispensados').value = ''; return valida_numero(event);" />
                                    
                                        <label class="filtro_label">Nome:</label>                                        
                                        <input value="<?php if(isset($_SESSION['post'])){echo $_SESSION['post']['filtro_nome_dispensados'];} ?>" type="text" name="filtro_nome" id="filtro_nome_dispensados" class="campo largura" style="width: 150px;" onkeypress="document.getElementById('filtro_codigo_dispensados').value = ''; return bloqueia_numeros(event);" />
                                    
                                        <input type="submit" name="buscar" value="Buscar" class="botao"/>
                                        
                                        <?php 
                                            if(isset($_SESSION['errosV']) && in_array('filtro_codigo',$_SESSION['errosV'])){ 
                                        ?>
                                        <span class="style1"><b>* Valor digitado inválido! Somente números.</b></span>
                                        <?php
                                            }
                                        ?>
                                        
                                        <?php 
                                            if(isset($_SESSION['errosV']) && in_array('filtro_nome',$_SESSION['errosV'])){ 
                                        ?>
                                        <span class="style1"><b>* Valor digitado inválido! Somente letras.</b></span>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                </td>
                                <td colspan="2" align="right">
                                    <?php
                                        //Processo de contar a quantidade de candidatos feito na aba de todas as vagas
                                        echo "<b>".Servicos::buscarProfissaoPorId($v->id_profissao)->nm_profissao."</b></br>(".$mostraQtdVaga.")";
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <hr style="border: 1px solid #EE7228;">
                                </td>
                            </tr>                            
                            <tr class="filtro_label">
                                <td align="center" style="width: 20%; color: #D3D3D3;"><b>Encaminhados:</b> <span id="totalEncaminhadosD"><?php echo $totalEncaminhados; ?></span></td>
                                <td align="center" style="width: 20%; color: #D3D3D3;"><b>Baixas Automáticas:</b> <span id="totalBaixasAutomaticasD"><?php echo $totalBaixasAutomaticas; ?></span></td>
                                <td align="center" style="width: 20%; color: #D3D3D3;"><b>Pré-Selecionados:</b> <span id="totalPreSelecionadosD"><?php echo $totalPreSelecionados; ?></span></td>
                                <td align="center" style="width: 20%; color: #D3D3D3;"><b>Contratados:</b> <span id="totalContratadosD"><?php echo $totalContratados;?></span></td>
                                <td align="center" style="width: 20%;"><b>Dispensados:</b> <span id="totalDispensadosD"><?php echo $totalDispensandos; ?></span></td>
                            </tr>
                        </table>                        
                    </div>
                    <div>                                                
                    </div>
                </form>
            </fieldset>
            
            <div class="tab_adiciona" <?php echo (!ControleSessao::buscarObjeto('objVaga')->dispensados) ? 'style="padding-bottom: 100px;"' : ''; ?>>
                <?php
                
                if((ControleSessao::buscarObjeto('objVaga')->dispensados) && ($totalDispensandos > 0)  ){
                    //var_dump(ControleSessao::buscarObjeto('objVaga'));
                    include_once '../modelo/VagaCandidatoVO.class.php';                    
                    if(count(ControleSessao::buscarObjeto('objVaga')->dispensados)>0){
                        
                        //define a quantidade de resultados da lista
                        $qtdDI = 10;
                        //busca a page atual
                        $pageDI = (isset($_GET['di'])) ? $_GET['di'] : 0;
                        //recebo um novo array com apenas os elemento necessarios para essa page atual
                        $dispensados = Servicos::listar(ControleSessao::buscarObjeto('objVaga')->dispensados, $qtdDI, $pageDI);
                                                                                                    
                        ?>
                        <div>                            
                            <form id="formImprimir" name="formImprimir" method="post" action="../controle/ControleVaga.php?op=imprimir">
                                <div style="float: left; padding: 3px; cursor: pointer;"><img onclick="atualizaListaDispensados(<?php echo ControleSessao::buscarObjeto('objVaga')->id_vaga; ?>);" onMouseOver="this.src='../../../Utilidades/Imagens/bancodeoportunidades/refresh-a.png';" onMouseOut="this.src='../../../Utilidades/Imagens/bancodeoportunidades/refresh.png'" id="imagemrefreshTodos" src="../../../Utilidades/Imagens/bancodeoportunidades/refresh.png" style="width: 25px;" title="Atualizar a lista de candidatos dispensados"></div>
                                <div class="botao_lista" >                                    
                                    <input type="hidden" name="id_vaga" value="<?php 
                                        $v = ControleSessao::buscarObjeto('objVaga');
                                        echo $v->id_vaga; ?>">
                                    <input <?php echo $disabled; ?> type="submit" name="lista" value="Imprimir Lista" class="botao"/>                                   
                                </div>
                            </form>
                            <!--<form id="formImprimir" name="formImprimir" method="post" action="../controle/ControleVaga.php?op=imprimirCurriculos">-->
                                <!--<div class="botoes_imprimir" align="right">
                                    <input type="submit" value="Imprimir Currículo" class="botao"/>
                                    <label class="filtro_label">Marcar Todos</label>
                                    <input type="checkbox" name="imprimirTodos" id="todos" value="" onclick="marcardesmarcar();">
                                </div>-->
                            <!--</form>-->
                            
                            <?php if(isset($_SESSION['msgImp'])){ ?>
                                <span class="msg" style="margin-left: 565px;"><?php echo ControleSessao::buscarVariavel('msgImp'); ?></span>
                            <?php } ?>
                            <div id="tabela_dispensados_div"></div>
                            <table width="100%" border="0" id="tabela_dispensados" class="tabela_encaminhados">
                                <tr class="table_formacao_cab">
                                    <td align='center' width="5%">Código</td>
                                    <td align='center' width="28%">Nome</td>
                                    <td align='center' width="10%">Telefone</td>
                                    <td align='center' width="25%">Email</td>
                                    <td align='center' width="12%">Status</td>
                                    <td align='center' width="5%">Histórico</td>
                                    <td align='center' width="5%">Visualizar</td>
                                    <td align='center' width="5%">Imprimir</td>
                                </tr>
                                <?php
                                $cont=0;
                                
                                //var_dump(ControleSessao::buscarObjeto('objVaga')->encaminhados[0]);
                                foreach($dispensados as $vc){
                                    
                                    if($vc->ao_status == 'D'){
                                    if(!Validacao::validarNulo($vc)){ 
                                    $cont++;                                    
                                ?>
                                    <form name="formSinalizar" id="formSinalizar_<?php echo $vc->id_candidato; ?>" method="post" action="../controle/ControleVaga.php?op=sinalizar" />
                                        <tr class="tabela_linha_todos" style="height: 50px;">
                                            <td align="center"><?php echo $vc->id_candidato; ?></td>
                                            <td>                                                
                                                <label style="color: black; font-weight: bold;"><?php echo $vc->nm_candidato; ?></label><br />                                                
                                                <?php
                                                    //Mostra a deficiência caso o candidato tenha.
                                                    if(!is_null($vc->id_deficiencia)){
                                                        if($vc->ao_sexo == "M"){
                                                            $sexoTodos = "Candidato";
                                                        }else{
                                                            $sexoTodos = "Candidata";
                                                        }
                                                        $deficienciaTodos = "(".$sexoTodos." com deficiência <b>".Servicos::buscarDeficienciaPorId($vc->id_deficiencia)."</b>)";
                                                    }else{
                                                        $deficienciaTodos = "";
                                                    }
                                                ?>
                                                <i><?php echo $deficienciaTodos; ?></i>
                                            </td>
                                            <td style="text-align: center;">                                                
                                                <?php
                                                    $telefone = $vc->nr_telefone;
                                                    if(!empty($telefone)){ 
                                                        echo $telefone;
                                                    }else{
                                                        echo $vc->nr_celular;
                                                    }
                                                ?>
                                            </td>
                                            <td><?php echo $vc->ds_email; ?></td>
                                            <td align="left">
                                                <?php if($vc->ao_status == 'E'){ ?>                                                    
                                                    <input <?php echo $disabled; ?> id="candidato_E" name="<?php echo $vc->id_candidato; ?>" type="radio" value="E" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'E')||($vc->ao_status == 'E')) echo 'checked'; ?> onclick="alterarStatus('<?php echo $vc->id_vagacandidato; ?>', 'E'); ocultarSelectMotivos('<?php echo $vc->id_candidato; ?>');" />Encaminhado<br>
                                                    <input <?php echo $disabled; ?> id="candidato_P" name="<?php echo $vc->id_candidato; ?>" type="radio" value="P" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'P')||($vc->ao_status == 'P')) echo 'checked'; ?> onclick="if(confirm('Enviar email para o candidato <?php echo $vc->nm_candidato; ?> como pré-selecionado?')){ 
                                                                                                                                                                                                                                                                                                                                                    alterarStatus('<?php echo $vc->id_vagacandidato; ?>', 'P', '<?php echo $vc->id_vaga; ?>', '<?php echo $_SESSION['id_usuario']; ?>');                                                                                                                                                                                                                                                                                                                                                    
                                                                                                                                                                                                                                                                                                                                                    ocultarSelectMotivos('<?php echo $vc->id_candidato; ?>');
                                                                                                                                                                                                                                                                                                                                                    $('input[name=buscar]').click();
                                                                                                                                                                                                                                                                                                                                                }else{                                                                                                                                                                                                                                                                                                                                                    
                                                                                                                                                                                                                                                                                                                                                    location.reload();                                                                                                                                                                                                                                                                                                                                                    
                                                                                                                                                                                                                                                                                                                                                }" />Pré-selecionado<br>
                                                    <input <?php echo $disabled; ?> id="candidato_C" name="<?php echo $vc->id_candidato; ?>" type="radio" value="C" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'C')||($vc->ao_status == 'C')) echo 'checked'; ?> onclick="if(confirm('Contratar candidato?')){
                                                                                                                                                                                                                                                                                        alterarStatus('<?php echo $vc->id_vagacandidato; ?>', 'C', '<?php echo $vc->id_vaga; ?>', '<?php echo $_SESSION['id_usuario']; ?>'); 
                                                                                                                                                                                                                                                                                        ocultarSelectMotivos('<?php echo $vc->id_candidato; ?>');                                                                                                                                                                                                                                                                                        
                                                                                                                                                                                                                                                                                        $('input[name=buscar]').click();                                                                                                                                                                                                                                                                                        
                                                                                                                                                                                                                                                                                    }else{                                                                                                                                                                                                                                                                                        
                                                                                                                                                                                                                                                                                        location.reload();
                                                                                                                                                                                                                                                                                    }" />Contratado<br>
                                                    <input id="candidato_D" name="<?php echo $vc->id_candidato; ?>" type="radio" value="D" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'D')||($vc->ao_status == 'D')) echo 'checked'; ?> onclick="mostrarSelectMotivos('<?php echo $vc->id_candidato; ?>');" />Dispensado
                                                <?php
                                                }else{
                                                    if($vc->ao_status == 'C'){
                                                        echo 'Contratação já sinalizada';                                                        
                                                    }else if($vc->ao_status == 'D'){ 
                                                        echo 'Dispensa já sinalizada'; 
                                                    }else if($vc->ao_status == 'B'){
                                                        echo 'Baixa automática';
                                                    }else if($vc->ao_status == 'P'){ ?>                                                            
                                                        <input id="candidato_P" name="<?php echo $vc->id_candidato; ?>" type="radio" value="P" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'P')||($vc->ao_status == 'P')) echo 'checked'; ?> disabled />Pré-selecionado<br>
                                                        <input <?php echo $disabled; ?> id="candidato_C" name="<?php echo $vc->id_candidato; ?>" type="radio" value="C" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'C')||($vc->ao_status == 'C')) echo 'checked'; ?> onclick="if(confirm('Contratar candidato?')){                                                                                                                                                                                                                                                                                            
                                                                                                                                                                                                                                                                                            alterarStatus('<?php echo $vc->id_vagacandidato; ?>', 'C', '<?php echo $vc->id_vaga; ?>', '<?php echo $_SESSION['id_usuario']; ?>');                                                                                                                                                                                                                                                                                            
                                                                                                                                                                                                                                                                                            ocultarSelectMotivos('<?php echo $vc->id_candidato; ?>'); 
                                                                                                                                                                                                                                                                                            $('input[name=buscar]').click(); 
                                                                                                                                                                                                                                                                                        }else{                                                                                                                                                                                                                                                                                             
                                                                                                                                                                                                                                                                                             location.reload();
                                                                                                                                                                                                                                                                                        }" />Contratado<br>
                                                        <input id="candidato_D" name="<?php echo $vc->id_candidato; ?>" type="radio" value="D" <?php if((isset($_SESSION['post']) && $_SESSION['post'][$vc->id_candidato] == 'D')||($vc->ao_status == 'D')) echo 'checked'; ?> onclick="mostrarSelectMotivos('<?php echo $vc->id_candidato; ?>');"/>Dispensado
                                                <?php 
                                                    }
                                                }
                                                ?>
                                            </td>                                            
                                            <?php 
                                            $historico = Servicos::verificarHistoricoCandidato($vc->id_candidato, ControleSessao::buscarObjeto('privateEmp')->id_empresa);
                                            if($historico>0){ 
                                            ?>
                                                <td align='center'>
                                                    <img src='../../../Utilidades/Imagens/bancodeoportunidades/historico.png' width="28" onclick="abrirHistoricoCandidatoDis('dadosHistoricoSelecionadoDis_<?php echo $vc->id_vagacandidato; ?>');" value="" title="Visualizar histórico de <?php echo $vc->candidato->nm_candidato; ?>" style="cursor: pointer;" />
                                                </td>
                                            <?php 
                                            }else{ 
                                            ?>
                                                <td align='center'>
                                                    <img src='../../../Utilidades/Imagens/bancodeoportunidades/historico_disabled.png' title='Candidato sem histórico' width="28" />
                                                </td>
                                            <?php 
                                            } 
                                            ?>
                                            <td align='center'>
                                                <input type="button" class="btn_visualizar" onclick="abrirDadosCandidatoDis('dadosCandidatoSelecionadoDis_<?php echo $vc->id_candidato; ?>');" value="" title="Visualizar currículo de <?php echo $vc->nm_candidato; ?>" />
                                            </td>
                                            <!--<td align="center">
                                                <input type="checkbox" class="marcar" id="pag_perfil" name="imprimir[]" value="<?php //echo $vc->id_candidato; ?>" />
                                            </td>-->
                                            <td align="center">
                                                <input <?php echo $disabled; ?> type="submit" name="imprimir" value="" class="btn_imprimir" title="Imprimir currículo de <?php echo $vc->nm_candidato; ?>" />
                                                <input type="hidden" name="id_candidato" id="id_candidato" value="<?php echo $vc->id_candidato; ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" id="candidato_<?php echo $vc->id_candidato; ?>" style="display: none;">                                                
                                                <div>
                                                   <span class="style1">*</span>
                                                   <span>
                                                        Motivo:                                                
                                                       <select onchange="mostrarCampoMotivoDispensa(<?php echo $vc->id_candidato; ?>);" name="id_motivo" id="id_motivo_<?php echo $vc->id_candidato; ?>" <?php echo (isset($_SESSION['errosV']) && in_array('id_motivo',$_SESSION['errosV'])) ? 'class="campo_erro select"' : 'class="campo select"'; ?>>
                                                        <option value="Selecione">Selecione</option>
                                                            <?php
                                                            $motivos = Servicos::buscarMotivos();
                                                            foreach($motivos as $m){
                                                            ?>
                                                                <option value="<?php echo $m->id_motivo; ?>" <?php if(isset($_SESSION['errosV']) && (isset($_SESSION['post']['id_motivo']) && $_SESSION['post']['id_motivo'] == $m->id_motivo)) { echo 'selected';} ?> ><?php echo $m->ds_motivo; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                            <option value="Outros">Outros</option>
                                                        </select>
                                                        <?php echo Servicos::verificarErro('errosV', 'id_motivo', '* Selecione um dado.'); ?>
                                                   </span>
                                                   
                                                   <span id="mostrarMotivo_<?php echo $vc->id_candidato; ?>" style="display: none;">
                                                       Descrição Motivo:
                                                       <input value="<?php if(isset($_SESSION['errosV'])){ echo $_SESSION['post']['ds_motivo']; } ?>" type="text" name="ds_motivo" id="ds_motivo_<?php echo $vc->id_candidato; ?>" size="50" maxlength="500" <?php echo (isset($_SESSION['errosV']) && in_array('ds_motivo',$_SESSION['errosV'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                                       <?php echo Servicos::verificarErro('errosV', 'ds_motivo'); ?>
                                                   </span>
                                                   
                                                   
                                                   <span id="inputEnviar_<?php echo $vc->id_candidato; ?>" style="display: none;">
                                                       <input <?php echo $disabled; ?> name="enviarMotivo" type="button" value="Enviar" class="botao" onclick="if(confirm('Tem certeza que deseja dispensar o candidato <?php echo $vc->nm_candidato; ?>?')){verificarSelect(<?php echo $vc->id_candidato; ?>);}else{ return false; }" />                                                        
                                                       <input type="hidden" name="id_vagacandidato" id="id_vagacandidato" value="<?php echo $vc->id_vagacandidato; ?>">
                                                   </span>                                                   
                                                </div>                                                
                                            </td>
                                        </tr>
                                    </form>
                                <?php
                                    }
                                  }
                                }
                                ?>
                                <tr>                                    
                                    <td colspan="8">
                                        <table width="100%">
                                            <tr>
                                                <td class="cont_pagina" width="5%">
                                                    <?php 
                                                        //$total = count(ControleSessao::buscarObjeto('objVaga')->encaminhados);
                                                    
                                                        //conta qual é o total de dispensados
                                                        $todos_encaminhados = ControleSessao::buscarObjeto('objVaga')->dispensados;
                                                        foreach($todos_encaminhados as $tenc){                                    
                                                            if($tenc->ao_status == 'D'){
                                                                $total_dis++;
                                                            }
                                                        }

                                                        echo ($pageDI * $qtdDI + $cont).'/'.$total_dis;
                                                    ?>                                                    
                                                </td>
                                                <td id="paginacao" align="center" width="95%">
                                                    <?php
                                                        //crio a paginacao propriamente dita
                                                        echo Servicos::criarPaginacaoDispensados(ControleSessao::buscarObjeto('objVaga')->dispensados, $qtdDI, $pageDI,'#parte-07');
                                                    ?>                                                    
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <?php if(ControleSessao::buscarObjeto('objVaga')->ao_ativo == 'S'){ ?>
                            <div align="right">
                                <br/>
                                <span class="msg">
                                    <?php if(isset($_SESSION['msgEn']))echo ControleSessao::buscarVariavel('msgEn'); ?>
                                </span>
                                <!--<input class="botao" name="registrar" type="submit" value="Registrar" />-->                                    
                            </div>      
                            <?php } ?>                           
                        </div>
                    <?php } ?>                        
                <?php                    
                }else{
                ?>                
                <br />
                <div style="width: 100%; float: left; padding: 3px; cursor: pointer;"><img onclick="atualizaListaDispensados(<?php echo ControleSessao::buscarObjeto('objVaga')->id_vaga; ?>);" onMouseOver="this.src='../../../Utilidades/Imagens/bancodeoportunidades/refresh-a.png';" onMouseOut="this.src='../../../Utilidades/Imagens/bancodeoportunidades/refresh.png'" id="imagemrefreshTodos" src="../../../Utilidades/Imagens/bancodeoportunidades/refresh.png" style="width: 25px;" title="Atualizar a lista de candidatos dispensados"></div>
                <div id="tabela_dispensados_div_pesq"></div>
                <table id="tabela_dispensados_pesq" width="100%" class='tabela_encaminhados'>
                    <tr class='table_formacao_cab'>
                        <td>&nbsp;</td>
                    </tr>
                    <tr class='table_formacao_row'>
                        <td style='height: 300px;'>
                            <center>
                                <b style="font-size: 20px;">
                                    <?php                                
                                        if(ControleSessao::buscarObjeto('objVaga')->pesqDispensados){
                                            echo "Não há resultados para sua busca por candidatos dispensados!";
                                        }else{
                                            echo "Não há candidatos dispensados para esta vaga";
                                        }
                                    ?>
                                </b>
                            </center>
                        </td>
                    </tr>
                </table>   
                <?php
                }
                ?>
            </div>
            
            <?php // echo Servicos::montarHistoricoCandidato(617, 96); ?>
            
            <?php 
            //$x=0;
            foreach($dispensados as $vc){
                if(!Validacao::validarNulo($vc)){
                //$x++; 
            ?>
                <!--Aba de visualizar curriculos-->
                <div colspan="4" class="white_content_candidato_dis selecionados" id="dadosCandidatoSelecionadoDis_<?php echo $vc->id_candidato; ?>">
                    <div id="dadosCandidatoDis">
                        <?php echo Servicos::buscarDadosCandidatoPorId($vc->id_candidato); ?>
                    </div>                    
                    <div class="log_bottom">
                        <form id="formImprimir" name="formImprimir" method="post" action="../controle/ControleVaga.php?op=imprimir">
                            <input type="hidden" name="id_candidato" value="<?php echo $vc->id_candidato; ?>">
                            <input <?php echo $disabled; ?> type="submit" name="curriculo" value="Imprimir Currículo" class="botao" />
                        </form>
                        <p>
                        Para fechar, 
                        <a class="link_incluir" href="javascript:void(0)" onclick="fecharDadosCandidatoDis('dadosCandidatoSelecionadoDis_<?php echo $vc->id_candidato; ?>');">clique aqui</a>
                        .</p>                        
                    </div>
                </div>
                <!--<div colspan="4" id="black_overlay_dis" class="black_overlay_dis"></div>-->
                
                <!--Aba de visualizar histórico-->
                <div colspan="4" class="white_content_candidato_dis selecionados" id="dadosHistoricoSelecionadoDis_<?php echo $vc->id_vagacandidato; ?>">
                    <div id="dadosHistoricoCandidatoDis">
                        <?php 
                        echo Servicos::montarHistoricoCandidato($vc->id_candidato, ControleSessao::buscarObjeto('privateEmp')->id_empresa); ?>
                    </div>                   
                    <div class="log_bottom">
                        <!--<form id="formImprimir" name="formImprimir" method="post" action="../controle/ControleVaga.php?op=imprimir">
                            <input type="hidden" name="id_candidato" value="<?php //echo $vc->id_candidato; ?>">
                            <input type="submit" name="curriculo" value="Imprimir Currículo" class="botao" />
                        </form>-->
                        <p>
                        Para fechar, 
                        <a class="link_incluir" href="javascript:void(0)" onclick="fecharHistoricoCandidatoDis('dadosHistoricoSelecionadoDis_<?php echo $vc->id_vagacandidato; ?>');">clique aqui</a>
                        .</p>                        
                    </div>
                </div>
                <div colspan="4" id="black_overlay_dis" class="black_overlay_dis"></div>
            <?php }
            }
            ?>        
        </div>        
    </div>    
</div>
<?php
include_once './footer.php';
ControleSessao::destruirVariavel('errosV');
ControleSessao::destruirVariavel('post');
ControleSessao::destruirVariavel('msg');
ControleSessao::destruirVariavel('msgEn');
ControleSessao::destruirVariavel('msgImp');
?>
