<?php

include_once '../util/ControleSessao.class.php';
include_once '../util/ControleLoginEmpresa.class.php';
ControleSessao::abrirSessao();

//verifico se ha candidato na sessao
if((!ControleLoginEmpresa::verificarAcesso())||(ControleSessao::buscarObjeto('privateEmp')->ao_liberacao == 'N')){
    //se nao tiver candidato na sessao
    ControleLoginEmpresa::deslogar();
}

include_once './header.php';

include_once '../modelo/CandidatoVO.class.php';
include_once '../modelo/CandidatoSubAreaVO.class.php';


include_once '../util/Servicos.class.php';
include_once '../util/Validacao.class.php';

if(in_array(S_VISUALIZAR_EMP, $_SESSION[SESSION_ACESSO])) $disabled = 'disabled';
?>
<div id="conteudo">    
    <div class="subtitulo">Banco de Oportunidades</div>    
    <div id="tudo">
        <div id="parte-00">
            <div class="relatorio_filtro">
                <form name="contratarFiltro" id="contratarFiltro" method="post" action="../controle/ControleCandidato.php?op=buscarContratado">
                    <input type="hidden" name="id_empresa" value="<?php echo ControleSessao::buscarObjeto('privateEmp')->id_empresa; ?>">
                    <fieldset>
                        <legend class="legend">Filtros de Contratação Rápida</legend>

                        <table width="100%">
                            <tr>
                                <td width="5%">
                                    <label class="filtro_label">Código:</label>
                                </td>
                                <td width="20%">
                                    <input style="width: 120px;" value="<?php if(isset($_SESSION['post'])){echo $_SESSION['post']['filtro_codigo'];} ?>" type="text" name="filtro_codigo" id="filtro_codigo" class="campo largura" onkeypress="document.getElementById('filtro_nome').value = ''; return valida_numero(event);" />
                                    <?php 
                                    if(isset($_SESSION['errosContratado']) && in_array('filtro_codigo',$_SESSION['errosContratado'])){ 
                                    ?>
                                        <span class="style1">* Dado inválido!</span>
                                    <?php
                                    }
                                    ?>
                                </td>                                
                                <td width="5%">
                                    <label class="filtro_label">Nome:</label>
                                </td>
                                <td width="34%">
                                    <input style="width: 300px;" value="<?php if(isset($_SESSION['post'])){echo $_SESSION['post']['filtro_nome'];} ?>" type="text" name="filtro_nome" id="filtro_nome" class="campo largura" onkeypress="document.getElementById('filtro_codigo').value = ''; return bloqueia_numeros(event);" />
                                    <?php 
                                    if(isset($_SESSION['errosContratado']) && in_array('filtro_nome',$_SESSION['errosContratado'])){ 
                                    ?>
                                        <span class="style1">* Dado inválido!</span>
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td width="36%">
                                <input <?php //echo $disabled; ?> type="submit" value="Buscar" class="botao"/>                                
                                <?php 
                                if(isset($_SESSION['errosContratado']) && in_array('filtro_vazio',$_SESSION['errosContratado'])){ 
                                ?>
                                    <span class="style1">* Preecha no mínimo um filtro!</span>
                                <?php
                                }
                                ?>
                            </td>
                            </tr>
                        </table>
                    </fieldset>                    
                </form>
            </div>            
            <?php
            
            
            
            if(isset($_SESSION['errosI'])){
                $e = ControleSessao::buscarVariavel('errosI');
                echo '<div class="style1">'.$e.'</div>';
            }           
                        
            if(isset($_SESSION['candidatosContratados'])){
                
                $candidatosContratados = ControleSessao::buscarObjeto('candidatosContratados');
            ?>
                <div>
                <?php                
                
                //define a quantidade de resultados da lista
                $qtd = 10;
                //busca a page atual
                $page = (isset($_GET['pg'])) ? $_GET['pg'] : 0;
                //recebo um novo array com apenas os elemento necessarios para essa page atual
                $candidatos = Servicos::listar($candidatosContratados, $qtd, $page);
                
                if(count($candidatosContratados) > 0){                    
                ?>                    
                    <table id="tabelaFiltroContratados" style="display: block;" width="100%" class="tabela_contratar">
                    <tr class="table_formacao_cab">
                        <th width="6%">Código</th>
                        <th width="35%">Nome</th>
                        <th width="15%">Cidade / UF</th>
                        <th width="6%">Vaga</th>
                        <th width="31%">Profissão</th>
                        <th width="7%">Contratar</th>
                    </tr>

                    <?php                        
                        foreach ($candidatos as $c){                            
                            if(!Validacao::validarNulo($c)){ 
                                
                    ?>
                        <tr class="table_formacao_row tabela_linha_todos">
                            <td align="center"><?php echo $c->id_candidato; ?></td>
                            <td>
                                <?php
                                    if($c->ao_status == "E"){
                                        $statusCandidato = "Encaminhado";                                        
                                    }else if($c->ao_status == "B"){
                                        $statusCandidato = "Baixa Automática";
                                    }else if($c->ao_status == "P"){
                                        $statusCandidato = "Pré Selecionado";
                                    }else if($c->ao_status == "C"){
                                        $statusCandidato = "Contratado";                                        
                                    }else{
                                        $statusCandidato = "Dispensado";                                        
                                    }
                                ?>
                                <b style="color: #000;"><?php echo $c->nm_candidato; ?></b>
                                (<?php echo $statusCandidato; ?>)
                                <br />
                                <?php
                                    //Mostra a deficiência caso o candidato tenha.
                                    if(!is_null($c->id_deficiencia)){
                                        if($c->ao_sexo == "M"){
                                            $sexoTodos = "Candidato";
                                        }else{
                                            $sexoTodos = "Candidata";
                                        }
                                        $deficienciaTodos = "<br />(".$sexoTodos." com deficiência <b>".Servicos::buscarDeficienciaPorId($c->id_deficiencia)."</b>)";
                                    }else{
                                        $deficienciaTodos = "";
                                    }
                                ?>
                                <i><?php echo $deficienciaTodos; ?></i>
                            </td>                            
                            <td align="center"><?php echo ($c->id_cidade == null) ? '*****' : Servicos::buscarCidadePorId($c->id_cidade)->nm_cidade . ' / ' .  Servicos::buscarEstadoPorId(Servicos::buscarIdEstado($c->id_cidade))->sg_estado; ?></td>
                            <td align="center"><?php echo $c->id_vaga; ?></td>
                            <?php
                                if($c->ao_ativo == "S"){
                                    $corProfissao = "#000";
                                    $mensagemProfissao = "";
                                }else{
                                    $corProfissao = "red";
                                    $mensagemProfissao = "Vaga está inativada no sistema mas liberada para contratação.";
                                }
                            ?>
                            <td style="color: <?php echo $corProfissao; ?>;" title="<?php echo $mensagemProfissao; ?>">
                                <b><?php echo $c->nm_profissao; ?></b>
                            </td>
                            <td align="center">
                                <?php if ($c->ao_status == "C"){ ?>
                                    <img id="img_contratado_<?php echo $c->id_vagacandidato; ?>" src="../../../Utilidades/Imagens/bancodeoportunidades/contratado_b.png" style="width: 20px;" title="Candidato contratado!">
                                <?php }else{ ?>
                                    <img id="img_contratar_<?php echo $c->id_vagacandidato; ?>" onclick="if(confirm('Você deseja contratar <?php echo $c->nm_candidato; ?> para a vaga de <?php echo $c->nm_profissao; ?>?')){atualizaContratado('<?php echo $c->id_vagacandidato; ?>', '<?php echo $c->nm_candidato; ?>', '<?php echo $c->ds_email; ?>');}" onMouseOver="this.src='../../../Utilidades/Imagens/bancodeoportunidades/contratado_a.png';" onMouseOut="this.src='../../../Utilidades/Imagens/bancodeoportunidades/contratado.png'" src="../../../Utilidades/Imagens/bancodeoportunidades/contratado.png" style="width: 30px; cursor: pointer;" title="Contratar <?php echo $c->nm_candidato; ?> para a vaga de <?php echo $c->nm_profissao; ?>">
                                <?php } ?>                                    
                                <img id="img_contratado_<?php echo $c->id_vagacandidato; ?>" src="../../../Utilidades/Imagens/bancodeoportunidades/contratado_b.png" style="width: 20px; display: none;" title="Candidato contratado!">
                            </td>
                        </tr>
                    <?php
                            }
                        }                    
                        if(count($candidatosContratados) > 10){
                            
                    ?>
                        <tr style="background-color: #FFF;">
                        <td colspan="6" style="text-align: center;">
                            <span id="paginacaovagas">
                            <?php
                            //crio a paginacao propriamente dita
                                echo Servicos::criarPaginacao($candidatosContratados, $qtd, $page);
                            ?>
                            </span>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                    <tr>
                        <td class="legend" colspan="6">
                            *O candidato receberá um email pelo banco de oportunidades informando que foi contratado para a vaga selecionada quando a empresa sinalizar a contatação.
                        </td>
                    </tr>
                </table>
                <?php                        
                }else{
                ?>
                    <table width="100%" style="border-collapse: collapse; border: 1px solid #EE7228;">
                    <tr class="table_formacao_cab">
                        <td>&nbsp;</td>
                    </tr>
                    <tr class="table_formacao_row">
                        <td style="height: 300px;">
                            <center>
                                <b style="font-size: 18px;">Não há resultados para sua busca!</b>
                            </center>
                        </td>
                    </tr>
                    </table>
                <?php
                }
                ?>
                </div>
            <?php
            }else{
            ?>
            <table width="100%" style="border-collapse: collapse; border: 1px solid #EE7228;">
                <tr class="table_formacao_cab">
                    <td>&nbsp;</td>
                </tr>
                <tr class="table_formacao_row">
                    <td style="height: 300px;">
                        <center>
                            <b style="font-size: 18px;">Digite o código ou nome do candidato que queira contratar.</b>
                        </center>
                    </td>
                </tr>
            </table>
            <?php } ?>
        </div>
    </div>
</div>
<?php
include_once './footer.php';
ControleSessao::destruirVariavel('errosContratado');
ControleSessao::destruirVariavel('errosI');
ControleSessao::destruirVariavel('post');
ControleSessao::destruirVariavel('candidatos');
?>