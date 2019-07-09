<?php
include_once 'header.php';

//Conexão com o Banco de Dados
include("../../interno/conecta.php");
include_once '../util/ControleSessao.class.php';
include_once '../util/Servicos.class.php';
ControleSessao::abrirSessao();
?>


<?php
    $sql = "SELECT id_pergunta, ds_pergunta, ds_resposta "
            . "FROM pergunta "
            . "WHERE ao_ativo = 'S' "
            . "ORDER BY id_pergunta ASC";

    $query = mysql_query($sql);
?>

<div id="conteudo">
    <div class="subtitulo">Perguntas frequentes</div>
    <?php while($row = mysql_fetch_object($query)) { ?>
    <p class="PerguntaFaq">
        <b><?php echo $row->ds_pergunta; ?></b>
    </p>
    <p class="RespostaFaq" style="text-indent: 30px; text-align: justify">
        <?php echo $row->ds_resposta; ?>
    </p>
    <?php } ?>
    <p align="center"><a href="../../index.php" title="Ir para a página principal" class="link_manual"><- Página principal</a>
</div>

<?php
include_once 'footer.php';
?>
