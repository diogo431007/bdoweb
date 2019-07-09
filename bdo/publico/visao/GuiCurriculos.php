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
    <!--<img id="cabecalho-logo" alt="Brasão da Prefeitura" src="../imagens/Orange wave.png">-->
    <div class="subtitulo">Banco de Oportunidades</div>
    <div id="tudo">
<!--    <div id="principal">
        <ul>
            <li>
                <a href="#parte-00"><span>Busca de Currículos</span></a>
            </li>
        </ul>-->
        <div id="parte-00">
            <div class="relatorio_filtro">
                <form name="relatorioFiltro" id="relatorioFiltro" method="post" action="../controle/ControleCandidato.php?op=buscar">
                    <fieldset>
                        <legend class="legend">Filtros</legend>

                        <table class="tabela_relatorio">

                            <tr>
                                <td width="7%">
                                    <label class="filtro_label">Código:</label>
                                </td>
                                <td width="35%">
                                    <input value="<?php if(isset($_SESSION['post'])){echo $_SESSION['post']['filtro_codigo'];} ?>" type="text" name="filtro_codigo" id="filtro_codigo" class="campo largura" />
                                    <?php 
                                    if(isset($_SESSION['errosC']) && in_array('filtro_codigo',$_SESSION['errosC'])){ 
                                    ?>
                                        <span class="style1">* Dado inválido!</span>
                                    <?php
                                    }
                                    ?>
                                </td>
                                
                                <td width="15%">
                                    <label class="filtro_label">Nome:</label>
                                </td>
                                <td width="43%">
                                    <input value="<?php if(isset($_SESSION['post'])){echo $_SESSION['post']['filtro_nome'];} ?>" type="text" name="filtro_nome" id="filtro_nome" class="campo largura" />
                                    <?php 
                                    if(isset($_SESSION['errosC']) && in_array('filtro_nome',$_SESSION['errosC'])){ 
                                    ?>
                                        <span class="style1">* Dado inválido!</span>
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label class="filtro_label">Deficiência:</label>
                                </td>
                                <td>
                                    <select name="filtro_deficiencia" id="filtro_deficiencia" class="campo largura">
                                        <option value="I">Indiferente</option>
                                        <option value="N" <?php if(isset($_SESSION['post']) && $_SESSION['post']['filtro_deficiencia'] == 'N') echo 'selected'; ?>>Nenhuma</option>
                                        <option value="T" <?php if(isset($_SESSION['post']) && $_SESSION['post']['filtro_deficiencia'] == 'T') echo 'selected'; ?>>Todas</option>
                                        <?php
                                        $deficiencias = array();
                                        $deficiencias = Servicos::buscarDeficiencias();
                                        foreach ($deficiencias as $d) {
                                        ?>
                                            <option value="<?php echo $d->id_deficiencia; ?>" <?php if(isset($_SESSION['post']) && $_SESSION['post']['filtro_deficiencia'] == $d->id_deficiencia) echo 'selected'; ?>><?php echo $d->nm_deficiencia; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <?php 
                                    if(isset($_SESSION['errosC']) && in_array('filtro_deficiencia',$_SESSION['errosC'])){ 
                                    ?>
                                        <span class="style1">* Dado inválido!</span>
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td>
                                    <label class="filtro_label">Estado:</label>
                                </td>
                                <td>
                                    <select name="id_estado" id="id_estado" class="campo largura">
                                        <option value="" selected>Selecione</option>
                                        <?php
                                        $estadosNm = Servicos::buscarEstadosPorNm();
                                        foreach ($estadosNm as $e) {
                                        ?>
                                            <option value="<?php echo $e->id_estado; ?>" <?php if(isset($_SESSION['post']) && $_SESSION['post']['id_estado'] == $e->id_estado) echo 'selected'; ?>><?php echo $e->nm_estado; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <?php 
                                    if(isset($_SESSION['errosC']) && in_array('id_estado',$_SESSION['errosC'])){ 
                                    ?>
                                        <span class="style1">* Dado inválido!</span>
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label class="filtro_label">Escolaridade:</label>
                                </td>
                                <td>
                                    <select name="filtro_escolaridade" id="filtro_escolaridade" class="campo largura">
                                        <option value="">Todos</option>
                                        <?php
                                        $formacoes = array();
                                        $formacoes = Servicos::buscarFormacoes();
                                        foreach ($formacoes as $f) {
                                        ?>
                                            <option value="<?php echo $f->id_formacao; ?>" <?php if(isset($_SESSION['post']) && $_SESSION['post']['filtro_escolaridade'] == $f->id_formacao){ echo 'selected';} ?>><?php echo $f->nm_formacao; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <?php 
                                    if(isset($_SESSION['errosC']) && in_array('filtro_escolaridade',$_SESSION['errosC'])){ 
                                    ?>
                                        <span class="style1">* Dado inválido!</span>
                                    <?php
                                    }
                                    ?>
                                </td>
                                
                                <td>
                                    <label class="filtro_label">Cidade:</label>
                                </td>
                                <td>
                                    <select name="id_cidade" id="id_cidade" class="campo largura">
                                        <option value="">Selecione</option>
                                        <?php
                                        if(isset($_SESSION['post']) && !empty($_SESSION['post']['id_estado'])){
                                            $cidades = array();
                                            $cidades = Servicos::buscarCidadesPorIdEstado($_SESSION['post']['id_estado']);
                                            foreach ($cidades as $c) {
                                        ?>
                                        <option value="<?php echo $c->id_cidade;?>" <?php if(isset($_SESSION['post']) && $_SESSION['post']['id_cidade'] == $c->id_cidade) echo 'selected'; ?>><?php echo $c->nm_cidade; ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <?php 
                                    if(isset($_SESSION['errosC']) && in_array('id_cidade',$_SESSION['errosC'])){ 
                                    ?>
                                        <span class="style1">* Dado inválido!</span>
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label class="filtro_label">Estado Civil:</label>
                                </td>
                                <td>
                                    <select name="filtro_ec" id="filtro_estado_civil" class="campo largura">
                                        <option value="">Todos</option>
                                        <option value="S" <?php if(isset($_SESSION['post']) && $_SESSION['post']['filtro_ec']=='S'){echo 'selected';} ?>>Solteiro</option>
                                        <option value="C" <?php if(isset($_SESSION['post']) && $_SESSION['post']['filtro_ec']=='C'){echo 'selected';} ?>>Casado</option>
                                        <option value="V" <?php if(isset($_SESSION['post']) && $_SESSION['post']['filtro_ec']=='V'){echo 'selected';} ?>>Viúvo</option>
                                        <option value="D" <?php if(isset($_SESSION['post']) && $_SESSION['post']['filtro_ec']=='D'){echo 'selected';} ?>>Divorciado</option>
                                        <option value="P" <?php if(isset($_SESSION['post']) && $_SESSION['post']['filtro_ec']=='P'){echo 'selected';} ?>>Separado</option>
                                        <option value="O" <?php if(isset($_SESSION['post']) && $_SESSION['post']['filtro_ec']=='O'){echo 'selected';} ?>>Outros</option>
                                    </select>
                                    <?php 
                                    if(isset($_SESSION['errosC']) && in_array('filtro_ec',$_SESSION['errosC'])){ 
                                    ?>
                                        <span class="style1">* Dado inválido!</span>
                                    <?php
                                    }
                                    ?>
                                </td>
                                
                                <td>
                                    <label class="filtro_label">Faixa Etária:</label>
                                </td>
                                <td>
                                    <select name="filtro_fe" id="filtro_faixa_etaria" class="campo largura">
                                        <option value="" selected>Todos</option>
                                        <option value="1" <?php if(isset($_SESSION['post']) && $_SESSION['post']['filtro_fe']==1){echo 'selected';} ?>>15 - 19</option>
                                        <option value="2" <?php if(isset($_SESSION['post']) && $_SESSION['post']['filtro_fe']==2){echo 'selected';} ?>>20 - 24</option>
                                        <option value="3" <?php if(isset($_SESSION['post']) && $_SESSION['post']['filtro_fe']==3){echo 'selected';} ?>>25 - 29</option>
                                        <option value="4" <?php if(isset($_SESSION['post']) && $_SESSION['post']['filtro_fe']==4){echo 'selected';} ?>>30 - 34</option>
                                        <option value="5" <?php if(isset($_SESSION['post']) && $_SESSION['post']['filtro_fe']==5){echo 'selected';} ?>>35 - 39</option>
                                        <option value="6" <?php if(isset($_SESSION['post']) && $_SESSION['post']['filtro_fe']==6){echo 'selected';} ?>>40 - ...</option>
                                    </select>
                                    <?php 
                                    if(isset($_SESSION['errosC']) && in_array('filtro_fe',$_SESSION['errosC'])){ 
                                    ?>
                                        <span class="style1">* Dado inválido!</span>
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                            
                            <!--<tr>
                                <td><label class="filtro_label">Profissão:</label></td>
                                <td colspan="3">
                                    <div>
                                        <form>
                                            <div>
                                                <input value="<?php //if(isset($_SESSION['post'])){echo $_SESSION['post']['filtro_profissao'];} ?>" type="text" name="filtro_profissao" id="filtro_profissao" class="campo largura" />
                                                <?php 
                                                //if(isset($_SESSION['errosC']) && in_array('filtro_profissao',$_SESSION['errosC'])){ 
                                                ?>
                                                    <span class="style1">* Dado inválido!</span>
                                                <?php
                                                //}
                                                ?>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>-->
                            
                            <tr>
                                <td>
                                    <label class="filtro_label">Profissão:</label>
                                </td>
                                <td>                                    
                                    <select name="filtro_profissao" id="filtro_profissao" class="campo largura">
                                        <option value="">Selecione</option>
                                        <?php
                                        $profissoes = array();
                                        $profissoes = Servicos::buscarProfissoes();
                                        foreach ($profissoes as $pro) {
                                        ?>
                                            <option value="<?php echo $pro->id_profissao; ?>" <?php if(isset($_SESSION['post']) && $_SESSION['post']['filtro_profissao'] == $pro->id_profissao){ echo 'selected';} ?>><?php echo $pro->nm_profissao; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <?php 
                                    if(isset($_SESSION['errosC']) && in_array('filtro_profissao',$_SESSION['errosC'])){ 
                                    ?>
                                        <span class="style1">* Dado inválido!</span>
                                    <?php
                                    }
                                    ?>                                 
                                </td>
                                
                                <td>
                                    <label class="filtro_label">Gênero:</label>
                                </td>
                                <td>
                                    <input type="radio" name="filtro_genero" id="filtro_genero_i" value="" checked />
                                    <label class="filtro_label">Indiferente</label>

                                    <input type="radio" name="filtro_genero" id="filtro_genero_m" value="M" <?php if(isset($_SESSION['post']) && $_SESSION['post']['filtro_genero']=='M'){echo 'checked';} ?> />
                                    <label class="filtro_label">Homem</label>

                                    <input type="radio" name="filtro_genero" id="filtro_genero_f" value="F" <?php if(isset($_SESSION['post']) && $_SESSION['post']['filtro_genero']=='F'){echo 'checked';} ?> />
                                    <label class="filtro_label">Mulher</label>
                                    <?php 
                                    if(isset($_SESSION['errosC']) && in_array('filtro_genero',$_SESSION['errosC'])){ 
                                    ?>
                                        <span class="style1">* Dado inválido!</span>
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                            
                            <tr>
                                <td colspan="2">&nbsp;</td>
                                <td>
                                    <label class="filtro_label">Possui Bolsa Família:</label>
                                </td>
                                <td>
                                    <input type="radio" name="filtro_bolsafamilia" id="filtro_bolsafamilia_i" value="" checked />
                                    <label class="filtro_label">Indiferente</label>

                                    <input type="radio" name="filtro_bolsafamilia" id="filtro_bolsafamilia_s" value="S" <?php if(isset($_SESSION['post']) && $_SESSION['post']['filtro_bolsafamilia']=='S'){echo 'checked';} ?> />
                                    <label class="filtro_label">Sim</label>

                                    <input type="radio" name="filtro_bolsafamilia" id="filtro_bolsafamilia_n" value="N" <?php if(isset($_SESSION['post']) && $_SESSION['post']['filtro_bolsafamilia']=='N'){echo 'checked';} ?> />
                                    <label class="filtro_label">Não</label>
                                    <?php 
                                    if(isset($_SESSION['errosC']) && in_array('filtro_bolsafamilia',$_SESSION['errosC'])){ 
                                    ?>
                                        <span class="style1">* Dado inválido!</span>
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                            
                        </table>
                    </fieldset>
                    <table>
                        <tr>
                            <td>
                                <input <?php //echo $disabled; ?> type="submit" value="Buscar" class="botao"/>                                
                                <?php 
                                if(isset($_SESSION['errosC']) && in_array('filtro_vazio',$_SESSION['errosC'])){ 
                                ?>
                                    <span class="style1">* Preecha no mínimo um filtro!</span>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            
            <?php
            if(isset($_SESSION['errosI'])){
                $e = ControleSessao::buscarVariavel('errosI');
                echo '<div class="style1">'.$e.'</div>';
            }
            
            if(isset($_SESSION['candidatos'])){
                include_once '../modelo/CandidatoVO.class.php';
                $candidatos = ControleSessao::buscarObjeto('candidatos'); 
                
            ?>
                <div class="relatorio_resultado">
                <?php
                if(count($candidatos)>0){
                ?>
                    <form name="print_relatorio" id="print_relatorio" method="post" action="../controle/ControleCandidato.php?op=imprimir">

                        <div align='right' class="imprimir">
                            <input type="submit" value="Gerar PDF" class="botao" />

                            <label class="filtro_label">Marcar Todos</label>
                            <input type="checkbox" name="imprimirTodos" id="todos" value="" onclick="marcardesmarcar();">
                        </div>

                        <table width="100%">
                            <tr>
                                <td class="tabela_resultado nome">Código</td>
                                <td class="tabela_resultado nome">Nome</td>
                                <td class="tabela_resultado telefone">Idade</td>
                                <td class="tabela_resultado telefone">Estado Civil</td>
                                <td class="tabela_resultado email">Cidade / UF</td>
                                <td class="tabela_resultado edita">Imprimir</td>
                            </tr>
                            
                            <?php                            
                            foreach ($candidatos as $c) {
                                //var_dump($c);die;
                            ?>
                            <tr>
                                <td class="linha_relatorio"><?php echo $c->id_candidato; ?></td>
                                <td class="linha_relatorio"><?php echo $c->nm_candidato; ?></td>
                                <td class="linha_relatorio" align="center"><?php echo $c->dt_nascimento; ?></td>
                                <td class="linha_relatorio" align="center"><?php echo $c->ds_estado_civil; ?></td>
                                <td class="linha_relatorio"><?php echo ($c->id_cidade == null) ? '*****' : Servicos::buscarCidadePorId($c->id_cidade)->nm_cidade . ' / ' .  Servicos::buscarEstadoPorId(Servicos::buscarIdEstado($c->id_cidade))->sg_estado; ?></td>
                                
                                <td class="linha_relatorio" align="center">
                                    <input type="checkbox" class="marcar" id="pag_perfil" name="imprimir[]" value="<?php echo $c->id_candidato; ?>" />
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </table>
                        <div align='right' class="imprimir">
                            <input type="submit" value="Gerar PDF" class="botao" />

                            <label class="filtro_label">Marcar Todos</label>
                            <input type="checkbox" name="imprimirTodos" id="todos2" value="" onclick="marcardesmarcar2();">
                        </div>
                    </form>                
                <?php
                }else{
                ?>
                    <div align="center">
                        <p>Não há resultados para sua busca!</p>
                    </div>
                <?php
                }
                ?>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<?php
include_once './footer.php';
ControleSessao::destruirVariavel('errosC');
ControleSessao::destruirVariavel('errosI');
ControleSessao::destruirVariavel('post');
ControleSessao::destruirVariavel('candidatos');
?>