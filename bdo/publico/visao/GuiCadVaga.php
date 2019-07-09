<?php
include_once '../util/ControleSessao.class.php';
//include_once '../util/ControleLoginEmpresa.class.php';
ControleSessao::abrirSessao();

//verifico se ha candidato na sessao e se foi liberado pela moderacao
/*if((!ControleLoginEmpresa::verificarAcesso())||(ControleSessao::buscarObjeto('privateEmp')->ao_liberacao == 'N')){
    //se nao tiver candidato na sessao
    ControleLoginEmpresa::deslogar();
}*/

include_once './header.php';
include_once '../util/Servicos.class.php';

if(in_array(S_VISUALIZAR_EMP, $_SESSION[SESSION_ACESSO])) $disabled = 'disabled';
?>
<div class="sessao_nova_vaga">
    <?php
    if(!ControleSessao::buscarVariavel('cadVaga')){
    ?>
    <a class="logout" onclick="cadastrarVaga();">
        <img id="fechar_img" src="../../../Utilidades/Imagens/bancodeoportunidades/add.png" width="15%" />
        <span id="fechar">Nova Vaga</span>
    </a>
    <?php
    }else{
    ?>
        <a class="logout" onclick="cancelarVaga();">
            <img id="fechar_img" src="../../../Utilidades/Imagens/bancodeoportunidades/icon_back.png" width="15%" />
            <span id="fechar">Voltar</span>
        </a>
    <?php
    }
    ?>
</div>
<div id="conteudo">
    <div class="subtitulo">Banco de Oportunidades</div>
    <div id="tudo">
        <div id="tudo"></div>
        <div id="parte-00">
            <?php if(isset($_SESSION['msg'])){ ?>
            <div id="ds_msg_vaga" class="msg_vaga_ja_cadastrada">
                <?php echo ControleSessao::buscarVariavel('msg'); ?>
            </div>
            <?php } ?>
            <form name="formCadVaga" id="formCadVaga" method="post" action="../controle/ControleVaga.php?op=cadastrar">
                <fieldset>
                    <legend class="legend" style="color: black;">CADASTRO DE VAGA</legend>
                    <table class="tabela_cand" style="width: 100%;">
                        <tr>                            
                            <td width="15%"><span class="style1">*</span>Profissão:</td>
                            <td colspan="3" width="85%">
                                <select style="width: 164px;" onchange="mostrarProfissao(); desmarcar();" name="id_profissao" id="id_profissao" <?php echo (isset($_SESSION['errosV']) && in_array('id_profissao',$_SESSION['errosV'])) ? 'class="campo_erro select"' : 'class="campo select"'; ?>>
                                    <option value="" selected>Selecione</option>
                                    <?php
                                    $profissoes = array();
                                    $profissoes = Servicos::buscarProfissoes();
                                    foreach ($profissoes as $pro) {
                                    ?>
                                    <option value="<?php echo $pro->id_profissao; ?>" <?php if(isset($_SESSION['errosV']) && $_SESSION['post']['id_profissao'] == $pro->id_profissao) echo 'selected'; ?>><?php echo $pro->nm_profissao; ?></option>
                                    <?php
                                    }
                                    ?>
                                    <option <?php if(isset($_SESSION['errosV']) && $_SESSION['post']['id_profissao'] == 'OUTRO') echo 'selected'; ?> value="OUTRO">OUTRO</option>
                                </select>
                                <span id="ds_outro" <?php
                                            if($_SESSION['post']['id_profissao'] != 'OUTRO'){
                                                $aux = 'style="display: none;"';
                                            }
                                            echo $aux;?>>
                                &nbsp;&nbsp;Qual?&nbsp;&nbsp;
                                <input name="ds_outro" value="<?php if(isset($_SESSION['errosV'])){ 
                                                                                echo $_SESSION['post']['ds_outro'];
                                                                            }else if(isset(ControleSessao::buscarObjeto('objVaga')->profissao)){
                                                                                if($cp->profissao->ao_ativo == 'V') echo $cp->profissao;
                                                                            } ?>"
                                        <?php echo (isset($_SESSION['errosV']) && in_array('ds_outro',$_SESSION['errosV'])) ? 'class="campo_erro"' : 'class="campo"'; ?> 
                                type="text" />
                                </span>                                
                                <?php 
                                if(isset($_SESSION['errosV']) && (in_array('id_profissao',$_SESSION['errosV'])||in_array('ds_outro',$_SESSION['errosV']))){ 
                                ?>
                                    <span class="style1" style="font-size: 12px;">* Preencha corretamente este campo</span>
                                <?php
                                }
                                
                                //Verifico se foi dado o post de retorno da validação para continuar mostrando a profissão selecionada no select.
                                if($_SESSION['post']['id_profissao']){
                                    $ds_profissao_display = "block";
                                }else{
                                    $ds_profissao_display = "none";
                                }
                                
                                ?>
                                    <span id="ds_profissao" style="display: <?php echo $ds_profissao_display; ?>; float: right; font-size: 20px; color: #000;">                                        
                                    <?php
                                        //Verifico se foi dado o post de retorno da validação para continuar mostrando a profissão selecionada no select.
                                        if($_SESSION['post']['id_profissao']){
                                            echo Servicos::buscarProfissaoPorId($_SESSION['post']['id_profissao']);                                        
                                        }
                                    ?>
                                    </span>                                    
                            </td>
                        </tr> 
                        <tr>
                            <td><span class="style1">*</span>Quantidade de Vagas:</td>
                            <td>
                                <input placeholder="0" onkeypress="return valida_numero(event);" name="qt_vaga" id="qt_vaga" value="<?php if(isset($_SESSION['errosV'])){ echo $_SESSION['post']['qt_vaga'];} ?>" type="text"  size="20" maxlength="10" <?php echo (isset($_SESSION['errosV']) && in_array('qt_vaga',$_SESSION['errosV'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                <?php 
                                if(isset($_SESSION['errosV']) && in_array('qt_vaga',$_SESSION['errosV'])){ 
                                ?>
                                    <span class="style1" style="font-size: 12px;"><br />* Preencha corretamente este campo</span>
                                <?php
                                }
                                ?>
                            </td>
                            <td rowspan="3" width="30%;">                                
                                <fieldset style="border: 1px solid #E4E2CD;">
                                    <legend>Gênero do Candidato</legend>
                                        <input type="radio" name="ao_sexo" id="ao_sexo_i" value="I" checked />
                                        <label class="filtro_label">Indiferente</label>

                                        <input type="radio" name="ao_sexo" id="ao_sexo_m" value="M" <?php if(isset($_SESSION['post']) && $_SESSION['post']['ao_sexo']=='M'){echo 'checked';} ?> />
                                        <label class="filtro_label">Homem</label>

                                        <input type="radio" name="ao_sexo" id="ao_sexo_f" value="F" <?php if(isset($_SESSION['post']) && $_SESSION['post']['ao_sexo']=='F'){echo 'checked';} ?> />
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
                                    <input type="radio" name="ao_deficiente" id="ao_deficienteN" value="N" checked /> Não
                                    <input type="radio" name="ao_deficiente" id="ao_deficienteS" value="S" <?php if(isset($_SESSION['post']) && $_SESSION['post']['ao_deficiente']=='S'){echo 'checked';} ?> /> Sim
                                    <input type="radio" name="ao_deficiente" id="ao_deficienteI" value="I" <?php if(isset($_SESSION['post']) && $_SESSION['post']['ao_deficiente']=='I'){echo 'checked';} ?> /> Ambos
                                </fieldset>
                            </td>
                            <td rowspan="3" width="30%;">
                                <fieldset style="border: 1px solid #E4E2CD;">
                                    <legend>Divulgar</legend>                                    
                                    <?php
                                        //Caso caia na validação mais de uma vez, o valor não irá se alterar.
                                        if($_SESSION['post']['ao_exibenome']=='S'){
                                            $value_exibenome = "S";
                                        }else{
                                            $value_exibenome = "N";
                                        }
                                        //Caso caia na validação mais de uma vez, o valor não irá se alterar.
                                        if($_SESSION['post']['ao_exibetelefone']=='S'){
                                            $value_exibetelefone = "S";
                                        }else{
                                            $value_exibetelefone = "N";
                                        }
                                        //Caso caia na validação mais de uma vez, o valor não irá se alterar.
                                        if($_SESSION['post']['ao_exibeemail']=='S'){
                                            $value_exibeemail = "S";
                                        }else{
                                            $value_exibeemail = "N";
                                        }                                        
                                    ?>
                                    <input type="checkbox" id="ao_exibenome" name="ao_exibenome" value="<?php echo $value_exibenome; ?>" onclick="marcaDivulgar();" <?php if(isset($_SESSION['post']) && $_SESSION['post']['ao_exibenome']=='S'){ echo "checked"; } ?> /><label id="lnm_empresa" style="<?php if(isset($_SESSION['post']) && $_SESSION['post']['ao_exibenome']=='S'){echo 'color: #00CD00;'; } ?>">Nome da Empresa</label>
                                    <label class="ajudaCadVaga" title="Essas opções serão exibidas somente nos emails que vão para os candidatos.">(?)</label>
                                    <br /><br />
                                    Responsável com...
                                    <hr style="border: 1px solid #E4E2CD;">
                                    <span><input type="checkbox" id="ao_exibetelefone" name="ao_exibetelefone" value="<?php echo $value_exibetelefone; ?>" onclick="marcaDivulgar();" <?php if(isset($_SESSION['post']) && $_SESSION['post']['ao_exibetelefone']=='S'){ echo "checked"; } ?> /><label id="lnm_empresatelefone" style="<?php if(isset($_SESSION['post']) && $_SESSION['post']['ao_exibetelefone']=='S'){echo 'color: #00CD00;'; } ?>">Telefone</label></span>
                                    <span><input type="checkbox" id="ao_exibeemail" name="ao_exibeemail" value="<?php echo $value_exibeemail; ?>" style="margin-left: 50px;" onclick="marcaDivulgar();" <?php if(isset($_SESSION['post']) && $_SESSION['post']['ao_exibeemail']=='S'){ echo "checked"; } ?> /><label id="lnm_empresaemail" style="<?php if(isset($_SESSION['post']) && $_SESSION['post']['ao_exibeemail']=='S'){echo 'color: #00CD00;'; } ?>">Email</label></span>
                                </fieldset>
                            </td>
                        </tr>                        
                        <tr>
                            <td><span class="style1">*</span>Salário: <label style="float: right;">R$</label></td>
                            <td>
                                <input name="nr_salario" placeholder="0,00" id="nr_salario" value="<?php if(isset($_SESSION['errosV'])){ echo $_SESSION['post']['nr_salario'];} ?>" type="text"  size="20" maxlength="10" onKeydown="FormataMoeda(this,10,event)" onkeypress="return maskKeyPress(event)" <?php echo (isset($_SESSION['errosV']) && in_array('nr_salario',$_SESSION['errosV'])) ? 'class="campo_erro"' : 'class="campo"'; ?> />
                                <?php 
                                if(isset($_SESSION['errosV']) && in_array('nr_salario',$_SESSION['errosV'])){ 
                                ?>
                                    <span class="style1" style="font-size: 12px;"><br />* Preencha corretamente este campo</span>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="height: 50px;">
                                <span class="style1">* Campos são obrigatórios</span>
                            </td>                            
                        </tr>
                        <tr>
                            <td colspan="4">                                
                                <fieldset style="border: 1px solid #E4E2CD;">
                                    <legend style="color: black;">FILTROS</legend>
                                    <label>Candidatos com experiências?</label>
                                    <?php                                    
                                    //Caso caiu em alguma regra na validação do cadastro da vaga, o que a pessoa marcou não se perde.
                                    if(isset($_SESSION['post']) && $_SESSION['post']['ao_experiencia']=='S'){
                                        $ao_experiencia_s = "checked";
                                    }else if(isset($_SESSION['post']) && $_SESSION['post']['ao_experiencia']=='N'){
                                        $ao_experiencia_n = "checked";
                                    }else{
                                        $ao_experiencia_i = "checked";
                                    }                                    
                                    ?>
                                    <input <?php echo $disabled; ?> type="radio" name="ao_experiencia" id="ao_experiencia" value="S" <?php echo $ao_experiencia_s; ?> /> Sim
                                    <input <?php echo $disabled; ?> type="radio" name="ao_experiencia" id="ao_experiencia" value="N" <?php echo $ao_experiencia_n; ?> /> Não
                                    <input <?php echo $disabled; ?> type="radio" name="ao_experiencia" id="ao_experiencia" value="I" <?php echo $ao_experiencia_i; ?> /> Ambos
                                    
                                    <hr style="border: solid 1px #E4E2CD;">
                                    
                                    <br />
                                    <div style="float: left;">
                                    <label>Estado Civil:</label>
                                    <?php
                                        //Caso ele caia em alguma validação, o que ele marcou não se perde.
                                        $estado_civil = $_SESSION['post']['ds_estado_civil'];
                                    ?>
                                    <select name="ds_estado_civil" style="margin-left: 52px; width: 165px;" id="ds_estado_civil" <?php echo (isset($_SESSION['errosV']) && in_array('ds_estado_civil',$_SESSION['errosV'])) ? 'class="campo_erro"' : 'class="campo"'; ?>>                                        
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
                                    <label style="margin-left: 70px;">Idade:</label>
                                    <?php
                                        //Caso ele caia em alguma validação, o que ele marcou não se perde.
                                        $idade = $_SESSION['post']['ds_idade'];
                                    ?>
                                    <select name="ds_idade" onclick="escondeCNH();" style="margin-left: 15px; width: 208px;" id="ds_idade" <?php echo (isset($_SESSION['errosV']) && in_array('ds_idade',$_SESSION['errosV'])) ? 'class="campo_erro"' : 'class="campo"'; ?>>
                                        <option value="" <?php if($idade == ''){echo 'selected';} ?>>Todos</option>
                                        <option value="16" <?php if($idade == '16'){echo 'selected';} ?>>Até 16 anos (menor aprendiz)</option>
                                        <option value="18" <?php if($idade == '18'){echo 'selected';} ?>>Até 18 anos</option>
                                        <option value="25" <?php if($idade == '25'){echo 'selected';} ?>>Até 25 anos</option>
                                        <option value="30" <?php if($idade == '30'){echo 'selected';} ?>>Até 30 anos</option>
                                        <option value="40" <?php if($idade == '40'){echo 'selected';} ?>>Até 40 anos</option>
                                        <option value="50" <?php if($idade == '50'){echo 'selected';} ?>>Até 50 anos</option>
                                    </select>
                                    </div>
                                    <div style="float: left;">
                                    <?php
                                        //Caso tenha selecionado as idades até 16 ou 18, não irá aparecer a cnh após o post de validação.
                                        if(($idade == '') || ($idade == '25') || ($idade == '30') || ($idade == '40') || ($idade == '50')){
                                            $idadedisplay = 'block';
                                        }else{
                                            $idadedisplay = 'none';
                                        }
                                        
                                        //Caso ele caia em alguma validação, o que ele marcou não se perde.
                                        $ds_cnh = $_SESSION['post']['ds_cnh'];
                                    ?>
                                    <label id="lb_cnh" style="margin-left: 18px; margin-top: 10px; float: left; display: <?php echo $idadedisplay; ?>;">CNH:</label>                                    
                                    <select id="ds_cnh" name="ds_cnh" id="ds_cnh" class="campo" style="float: left; margin-left: 5px; display: <?php echo $idadedisplay; ?>;" >
                                        <option value="" <?php if($ds_cnh == ''){echo 'selected';} ?>>Indiferente</option>
                                        <option value="ACC" <?php if($ds_cnh == 'ACC'){echo 'selected';} ?>>ACC</option>
                                        <option value="A" <?php if($ds_cnh == 'A'){echo 'selected';} ?>>A</option>
                                        <option value="B" <?php if($ds_cnh == 'B'){echo 'selected';} ?>>B</option>
                                        <option value="C" <?php if($ds_cnh == 'C'){echo 'selected';} ?>>C</option>
                                        <option value="D" <?php if($ds_cnh == 'D'){echo 'selected';} ?>>D</option>
                                        <option value="E" <?php if($ds_cnh == 'E'){echo 'selected';} ?>>E</option>
                                        <option value="AB" <?php if($ds_cnh == 'AB'){echo 'selected';} ?>>AB</option>
                                        <option value="AC" <?php if($ds_cnh == 'AC'){echo 'selected';} ?>>AC</option>
                                        <option value="AD" <?php if($ds_cnh == 'AD'){echo 'selected';} ?>>AD</option>
                                        <option value="AE" <?php if($ds_cnh == 'AE'){echo 'selected';} ?>>AE</option>
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
                                        //Atribuo a uma variável o array de retorno do post da validação para verificar quais foram marcados
                                        $formacao = $_SESSION['post']['ao_formacao'];
                                                                            
                                        $formacoes = Servicos::buscarFormacoes();
                                        foreach ($formacoes as $f) {                                            
                                    ?>
                                        <span style="float: left; padding: 5px; width: 210px;">
                                            <input type="checkbox" id="ao_formacao_<?php echo $f->id_formacao; ?>" name="ao_formacao[]" value="<?php echo $f->id_formacao; ?>" onclick="marcaFormacao(<?php echo $f->id_formacao; ?>);" <?php if(in_array($f->id_formacao, $formacao)){ echo "checked";} ?> />
                                            <label id="lformacao_<?php echo $f->id_formacao; ?>" style="<?php if(in_array($f->id_formacao, $formacao)){ echo "color: #EE7228;";} ?>"><?php echo $f->nm_formacao; ?></label>
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
                            <!--
                            <td><span class="style1"></span></td>
                            <td>Adicional:</td>
                            <td>
                                <textarea name="ds_adicional" id="ds_adicional" cols="75" rows="7" <?php echo (isset($_SESSION['errosV']) && in_array('ds_adicional',$_SESSION['errosV'])) ? 'class="campo_erro"' : 'class="campo"'; ?>><?php if(isset($_SESSION['errosV'])){ echo $_SESSION['post']['ds_adicional'];} ?></textarea>
                                <?php 
                                if(isset($_SESSION['errosV']) && in_array('ds_adicional',$_SESSION['errosV'])){ 
                                ?>
                                    <span class="style1">* Preencha corretamente este campo</span>
                                <?php
                                }
                                ?>
                            </td> -->
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
                                        $adicional = $_SESSION['post']['ao_adicional'];
                                    
                                        $adicionais = Servicos::buscarAdicional();
                                        foreach ($adicionais as $a) {                                            
                                    ?>
                                        <span style="float: left; padding: 5px; width: 210px;">
                                            <input type="checkbox" id="ao_adicional_<?php echo $a->id_adicional; ?>" name="ao_adicional[]" value="<?php echo $a->id_adicional; ?>" onclick="marcaAdicional(<?php echo $a->id_adicional; ?>);" <?php if(in_array($a->id_adicional, $adicional)){ echo "checked";} ?> />
                                            <label id="ladicional_<?php echo $a->id_adicional; ?>" style="<?php if(in_array($a->id_adicional, $adicional)){ echo "color: #EE7228;";} ?>"><?php echo $a->nm_adicional; ?></label>
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
                            <!--
                            <td><span class="style1"></span></td>
                            <td>Adicional:</td>
                            <td>
                                <textarea name="ds_adicional" id="ds_adicional" cols="75" rows="7" <?php echo (isset($_SESSION['errosV']) && in_array('ds_adicional',$_SESSION['errosV'])) ? 'class="campo_erro"' : 'class="campo"'; ?>><?php if(isset($_SESSION['errosV'])){ echo $_SESSION['post']['ds_adicional'];} ?></textarea>
                                <?php 
                                if(isset($_SESSION['errosV']) && in_array('ds_adicional',$_SESSION['errosV'])){ 
                                ?>
                                    <span class="style1">* Preencha corretamente este campo</span>
                                <?php
                                }
                                ?>
                            </td> -->
                        </tr>
                        <tr>
                            <td colspan="4">
                                <br />
                                <fieldset style="border: 1px solid #E4E2CD;">
                                    <legend style="color: black;">BENEFÍCIOS</legend>
                                    <?php
                                        $beneficio = $_SESSION['post']['ao_beneficio'];
                                    
                                        $beneficios = Servicos::buscarBeneficio();
                                        foreach ($beneficios as $b) {                                            
                                    ?>
                                        <span style="float: left; padding: 5px; width: 210px;">
                                            <input type="checkbox" id="ao_beneficio_<?php echo $b->id_beneficio; ?>" name="ao_beneficio[]" value="<?php echo $b->id_beneficio; ?>" onclick="marcaBeneficio(<?php echo $b->id_beneficio; ?>);" <?php if(in_array($b->id_beneficio, $beneficio)){ echo "checked";} ?> />
                                            <label id="lbeneficio_<?php echo $b->id_beneficio; ?>" style="<?php if(in_array($b->id_beneficio, $beneficio)){ echo "color: #EE7228;";} ?>"><?php echo $b->nm_beneficio; ?></label>
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
                            <!--
                            <td><span class="style1"></span></td>
                            <td>Benefício:</td>
                            <td>
                                <textarea name="ds_beneficio" id="ds_beneficio" cols="75" rows="7" <?php echo (isset($_SESSION['errosV']) && in_array('ds_beneficio',$_SESSION['errosV'])) ? 'class="campo_erro"' : 'class="campo"'; ?>><?php if(isset($_SESSION['errosV'])){ echo $_SESSION['post']['ds_beneficio'];} ?></textarea>
                                <?php 
                                if(isset($_SESSION['errosV']) && in_array('ds_beneficio',$_SESSION['errosV'])){ 
                                ?>
                                    <span class="style1">* Preencha corretamente este campo</span>
                                <?php
                                }
                                ?>
                            </td>
                            -->
                        </tr>
                        <tr>                            
                            <td colspan="4">
                                <div style="width:50%; float: left;">
                                    <label style="color: black;">ATRIBUIÇÃO:</label>
                                    <textarea style="width:99%; font-family: Arial,sans-serif;	" name="ds_atribuicao" id="ds_atribuicao" placeholder="Digite aqui a descrição da vaga..." rows="10" <?php echo (isset($_SESSION['errosV']) && in_array('ds_atribuicao',$_SESSION['errosV'])) ? 'class="campo_erro"' : 'class="campo"'; ?>><?php if(isset($_SESSION['errosV'])){ echo $_SESSION['post']['ds_atribuicao'];} ?></textarea>
                                    <?php 
                                    if(isset($_SESSION['errosV']) && in_array('ds_atribuicao',$_SESSION['errosV'])){ 
                                    ?>
                                        <span class="style1">* Preencha corretamente este campo</span>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div style="width:50%; float: left;">
                                    <label style="margin-left: 4px; color: black;">OBSERVAÇÃO:</label>
                                    <textarea style="width: 99%; font-family: Arial,sans-serif;	 float: right;" name="ds_observacao" id="ds_observacao" placeholder="Digite aqui alguma observação referente a vaga caso tenha..." rows="10" <?php echo (isset($_SESSION['errosV']) && in_array('ds_observacao',$_SESSION['errosV'])) ? 'class="campo_erro"' : 'class="campo"'; ?>><?php if(isset($_SESSION['errosV'])){ echo $_SESSION['post']['ds_observacao'];} ?></textarea>
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
                                <input <?php echo $disabled; ?> class="botao" type="submit" value="CADASTRAR VAGA" />
                            </td>
                        </tr>
                    </table>
                </fieldset>                        
            </form>
        </div>
    </div>
</div>
<?php
include_once './footer.php';
ControleSessao::destruirVariavel('errosV');
ControleSessao::destruirVariavel('post');
ControleSessao::destruirVariavel('msg');
?>