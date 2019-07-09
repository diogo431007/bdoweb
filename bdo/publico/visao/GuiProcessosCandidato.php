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
?>
<div id="conteudo">
    <div class="subtitulo">Banco de Oportunidades</div>
    <div id="principal">
    <fieldset style="height: 60%; margin: 10px;">
        <legend class="legend">Processos Seletivos - <?php echo ControleSessao::buscarObjeto('privateCand')->nm_candidato ?></legend>
        <div class="tab_adiciona">
            <?php
            $status = Servicos::buscarUltimaAtualizacaoCandidato(ControleSessao::buscarObjeto('privateCand')->id_candidato);
            if(ControleLoginCandidato::verificarAcesso() && count($status)>0){
                //define a quantidade de resultados da lista
                $qtd = 10;
                //busca a page atual
                $page = (isset($_GET['pg'])) ? $_GET['pg'] : 0;
                //recebo um novo array com apenas os elemento necessarios para essa page atual
                $historicos = Servicos::listar($status, $qtd, $page);
                
                
            ?>
                <table id="tabela_formacoes" name='tabela_formacoes' width="100%">
                    <tr class="table_formacao_cab" id="tabelaFormacao">                        
                        <td align='center' width="37.5%">Profissão</td>                        
                        <td align='center' width="37.5%">Empresa</td>
                        <td align='center' width="10%">Status</td>
                        <td align='center' width="15%">Data/Hora</td>
                    </tr>
                    <?php
                    foreach($historicos as $h){
                        if(!Validacao::validarNulo($h)){
                    ?>
                            <tr class="table_formacao_row">
                                <td><?php echo Servicos::buscarProfissaoPorId($h['id_profissao'])->nm_profissao; ?></td>
                                <td>
                                    <?php
                                    if(($h['ao_status'] == 'E') || ($h['ao_status'] == 'D') || ($h['ao_status'] == 'B') ){
                                        echo "Empresa confidencial";
                                    }else{
                                        echo Servicos::buscarEmpresaPorId($h['id_empresa'])->nm_razaosocial;                                        
                                    }
                                    ?>
                                </td>
                                
                                <td align="center"><?php echo Servicos::verificarStatusEncaminhado($h['ao_status']); ?></td>
                                <td align="center"><?php echo Validacao::explodirDataMySql($h['dt_status'], true, true); ?></td>
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
                                echo Servicos::criarPaginacao($status, $qtd, $page);
                            ?>
                            </span>
                        </td>
                    </tr>
                </table>
            <?php 
            }else{ 
            ?>
                <div class="headertabela">   
                    <div class="msg" style="font-size: 15px;">
                        No momento você não possui processos seletivos.
                    </div>
                </div>
            <?php 
            }
            ?>
        </div>
        <div style="font-size: 12px; padding: 5px;"><b style="color: red;">*</b>Caso seu currículo for encaminhado para empresa e a mesma
        não atualizar seu status durante 30 dias, o candidato receberá baixa automática pelo sistema para aquela vaga.</div>
    </fieldset>
    </div>
</div>
<?php 
include_once 'footer.php';
?>    