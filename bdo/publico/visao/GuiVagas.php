<?php
include_once '../util/ControleSessao.class.php';
ControleSessao::abrirSessao();

include_once '../util/ControleLoginEmpresa.class.php';
include_once '../util/Validacao.class.php';
include_once '../util/Servicos.class.php';

include_once '../modelo/VagaVO.class.php';

//verifico se ha candidato na sessao
if(!ControleLoginEmpresa::verificarAcesso()){
    //se nao tiver candidato na sessao
    ControleLoginEmpresa::deslogar();
}

include_once './header.php';

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
   <br /><br />
   <div class="msg_login_empresa">
       <?php
            if(ControleLoginEmpresa::verificarAcesso() && ControleSessao::buscarObjeto('privateEmp')->empresa_vagas){            
                echo "Clique no lápis ou na profissão para visualizar os candidatos encaminhados para as vagas.";
            }else{
                echo "Sua empresa não tem nenhuma vaga cadastrada no sistema, cadastre uma nova.";
            }
       ?>
   </div>
   <div id="tudo">
        <fieldset>
            <legend class="legend">Filtros</legend>
            <form name="filtroVaga" id="filtroVaga" method="post" action="../controle/ControleVaga.php?op=buscar">
                <div>
                    <table class="tabela_relatorio">
                        <tr>
                            <td>
                                <label class="filtro_label">Profissão:</label>
                            </td>
                            <td>                                    
                                <select name="filtro_profissao" id="filtro_profissao" class="campo largura">
                                    <option value="">Todos</option>
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
                                if(isset($_SESSION['errosV']) && in_array('filtro_profissao',$_SESSION['errosV'])){ 
                                ?>
                                    <span class="style1">* Dado inválido!</span>
                                <?php
                                }
                                ?>                                 
                            </td>

                            <td>
                                <label class="filtro_label">Status:</label>
                            </td>
                            <td>
                                <input type="radio" name="filtro_status" id="filtro_status_t" value="" checked />
                                <label class="filtro_label">Todos</label>
                                
                                <input type="radio" name="filtro_status" id="filtro_status_a" value="S" <?php if(isset($_SESSION['post']) && $_SESSION['post']['filtro_status']=='S'){echo 'checked';} ?> />
                                <label class="filtro_label">Ativo</label>

                                <input type="radio" name="filtro_status" id="filtro_status_i" value="N" <?php if(isset($_SESSION['post']) && $_SESSION['post']['filtro_status']=='N'){echo 'checked';} ?> />
                                <label class="filtro_label">Inativo</label>

                                <?php 
                                if(isset($_SESSION['errosV']) && in_array('filtro_status',$_SESSION['errosV'])){ 
                                ?>
                                    <span class="style1">* Dado inválido!</span>
                                <?php
                                }
                                ?>
                            </td>
                            <td>
                                <input type="submit" value="Buscar" class="botao"/>
                            </td>                            
                        </tr>                    
                    </table>
                </div>
            </form>
        </fieldset>     
        <br>
        <fieldset>
            <legend class="legend">Vagas</legend> 
            <div class="tab_adiciona">
                <?php                    
                if(ControleLoginEmpresa::verificarAcesso() && ControleSessao::buscarObjeto('privateEmp')->empresa_vagas){
                    
                    //define a quantidade de resultados da lista
                    $qtd = 15;
                    //busca a page atual
                    $page = (isset($_GET['pg'])) ? $_GET['pg'] : 0;
                    //recebo um novo array com apenas os elemento necessarios para essa page atual
                    $vagas = Servicos::listar(ControleSessao::buscarObjeto('privateEmp')->empresa_vagas, $qtd, $page);
                    
                    if(count($vagas) > 0){
                    ?>
                    <div>
                        <div id="div_carregando"></div>
                        <table class="tabela_vagas" width="100%" border="1">
                            <tr class="tabela_vagas_cab">
                                <td width="5%" style="text-align: center;">Código</td>
                                <td width="20%" style="text-align: center;">Profissão</td>
                                <td width="9%" style="text-align: center;">Salário</td>
                                <td width="42%" colspan="2" style="text-align: center;">Adicional / Benefício</td>                                
                                <td width="8%" style="text-align: center;">Nº Vagas</td>
                                <td width="11%" style="text-align: center;">Status</td>
                                <td width="5%" style="text-align: center;">Editar</td>
                            </tr>                            
                            
                            <?php
                            foreach($vagas as $v){                                    
                                if(!Validacao::validarNulo($v)){
   
                                //Se tiver a vaga inativa risca ela
                                if($v->ao_ativo == 'N'){
                                    $riscainicio = "<s>";
                                    $riscafim = "</s>";
                                }else{
                                    $riscainicio = "";
                                    $riscafim = "";
                                }   
                                    
                            ?>                               
                                <tr id="linha_vaga_<?php echo $v->id_vaga; ?>" class="tabela_vagas_row" <?php if(ControleSessao::buscarObjeto('objVaga')->id_vaga == $v->id_vaga);?>>
                                    <td width="5%" align='center'><?php echo $v->id_vaga; ?></td>
                                    <td width="20%" align='center'><a href="#" onclick="chamarEdicaoVaga(<?php echo $v->id_vaga; ?>)" title="Clique aqui para ver os candidatos encaminhados a vaga de <?php echo Servicos::buscarProfissaoPorId($v->id_profissao)->nm_profissao; ?>"><?php echo $riscainicio; ?><b><?php echo Servicos::buscarProfissaoPorId($v->id_profissao)->nm_profissao; ?></b><?php echo $riscafim; ?></a></td>
                                    <td width="9%" align='center'>R$ <?php echo Validacao::converterMoedaPhp($v->nr_salario); ?></td>
                                    <td width="42%" colspan="2" align='center'>
                                        <?php
                                            $vagaadicional = Servicos::buscarVagaAdicionalPorId($v->id_vaga);
                                            $vagabeneficio = Servicos::buscarVagaBeneficioPorId($v->id_vaga);
                                        
                                            foreach ($vagaadicional as $va){
                                                $adicional = Servicos::buscarAdicionalPorId($va->id_adicional);
                                                echo "<b>".$adicional->nm_adicional.";</b> ";
                                            }
                                        
                                        echo $v->ds_adicional;
                                        
                                        echo $v->ds_beneficio;                                                                                                                        
                                        
                                        if(!empty($vagaadicional) && !empty($vagabeneficio)){
                                            echo "<hr style='border: 1px solid #E4E2CD;'>";
                                        }
                                        if((empty($vagaadicional)) && (empty($vagabeneficio)) && ($v->ds_adicional == "") && ($v->ds_beneficio == "")){
                                            echo "\"Adicionais e benefícios não informados\"";
                                        }
                                            
                                        
                                            foreach ($vagabeneficio as $vb){
                                                $beneficio = Servicos::buscarBeneficioPorId($vb->id_beneficio);
                                                echo "<b>".$beneficio->nm_beneficio.";</b> ";
                                            }
                                        
                                        
                                        
                                        ?>
                                    </td>
                                    <td width="8%" align='center'><?php echo Validacao::validarQtdVaga($v->qt_vaga); ?></td>
                                    <td width="11%" align='center'><?php echo Servicos::verificarStatus($v->ao_ativo, $v->prof_ao_ativo); ?></td>
                                    <td width="" align='center'>
                                        <form style="margin: 0;padding: 0;" name="editarVaga" id="editarVaga" method="post" action="">    
                                            <input type="button" class="btn_editar" value="" onclick="chamarEdicaoVaga(<?php echo $v->id_vaga; ?>)" title="Clique aqui para ver os candidatos encaminhados a vaga de <?php echo Servicos::buscarProfissaoPorId($v->id_profissao)->nm_profissao; ?>" />
                                            <!--<input type="hidden" name="id_vaga" id="id_vaga" value="<?php echo $v->id_vaga; ?>">-->
                                        </form>
                                    </td>                                
                                </tr>                            
                            <?php
                                }
                            }
                            
                            if(count(ControleSessao::buscarObjeto('privateEmp')->empresa_vagas) > 15){                                
                            ?>
                                <tr style="background-color: #FFF;">
                                <td colspan="8" style="text-align: center;">
                                    <span id="paginacaovagas">
                                    <?php
                                    //crio a paginacao propriamente dita
                                    echo Servicos::criarPaginacao(ControleSessao::buscarObjeto('privateEmp')->empresa_vagas, $qtd, $page);
                                    ?>
                                    </span>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </table>
                        <span class="filtro_label"><br />*Em moderação aparece no status quando a empresa cadastra uma nova vaga com uma profissão inexistente no sistema.</span>
                    </div>                            
                    <?php
                    }else{
                    ?>                
                    <div align="center">
                        <p>Não há resultados para sua busca!</p>
                    </div>
                    <?php
                    }
                //<?php                        
                }else{
                ?>                            
                <fieldset>
                    <div class="headertabela">   
                        <div class="tabelapesq"> 
                            <?php echo "Não há vagas cadastradas para esta empresa."; ?>
                        </div>
                    </div>
                </fieldset>   
                <?php
                }
                ?>            
            </div>            
        </fieldset>     
    </div>
</div>
<?php
include_once './footer.php';
ControleSessao::destruirVariavel('errosV');
ControleSessao::destruirVariavel('errosI');
ControleSessao::destruirVariavel('post');
ControleSessao::destruirVariavel('vagas');
?>
