<?php  if(in_array(S_CADASTRO_IMAGENS, $_SESSION[SESSION_ACESSO])){?>
<style>
    .erro {
        padding: 5px;	
	color: #900;
	font-weight: bold;
	background-color: #FFCCCC;
        border-color: #990000;
        border-style: solid;
        border-width: 1px;
    }
    
    .ok {
        padding: 5px;	
	color: #006600;
	font-weight: bold;
        background-color: #99ff99;
        border-color: #006600;
        border-style: solid;
        border-width: 1px;
    }
</style>
<script>        
    setTimeout(function () { $("#ok").hide('tohide'); }, 3000);    
</script>

<?php

    

if($_POST['ok']){
    echo "<script>$('#erro').hide();</script>";
    echo "<div id='ok' class='ok' >Imagem carregada com sucesso.</div>";
    //echo "<script>setTimeout(function () { location.reload(1); }, 3500);</script>";    
}

if($_POST['erro']){
    $erro = $_POST['erro'];
    $mostra = str_replace('|', '<br />', $erro);
    echo "<div id='erro' class='erro' >".$mostra."</div>";
}

?>
<form id="uploadImagem" name="uploadImagem" method="post" enctype="multipart/form-data" action="enviaImagem.php">
    <div id="img_load"></div>
    <div id="img_error"></div>
    <div id="img_ok"></div>
    <fieldset>
        <legend class="legend">Cadastro de Imagens</legend>
        <table width="100%" style="color: #666; font-size: 12px;">
            <tr>
                <td width="50%">
                    Selecione o lado:
                    <select id="lado" name="lado" class="campo" style="margin-left: 5px;">                        
                        <option value="Selecione">Selecione</option>
                        <option id="SE" value="SE">Superior Esquerdo</option>
                        <option id="SD" value="SD">Superior Direito</option>
                        <option id="IE" value="IE">Inferior Esquerdo</option>
                        <option id="ID" value="ID">Inferior Direito</option>
                        <option id="IF" value="IF">Imagem de Fundo</option>
                    </select>
                </td>
                <td width="50%">
                    Imagem:<input class="campo" id="imagem" type="file" name="imagem" style="width: 403px; margin-left: 5px;" />
                </td>     
            <tr>
                <td colspan="2" width="100%" align="left">
                    <hr>
                    <input type="submit" class="botao" name="enviar" value="Enviar" 
                           onclick="
                                    if($('#lado').val() === 'Selecione'){
                                        alert('Selecione um lado!');
                                        return false;
                                    };
                                    if($('#imagem').val() === ''){
                                        alert('Selecione uma imagem!');
                                        return false;
                                    };
                           " />
                </td>
            </tr>
        </table>
    </fieldset>
</form>
<?php
    // Selecionando a imagem do sistema
    $sql_SE = mysql_query("SELECT imagem FROM imagemsistema WHERE lado = 'SE'");
    $sql_SD = mysql_query("SELECT imagem FROM imagemsistema WHERE lado = 'SD'");
    $sql_IE = mysql_query("SELECT imagem FROM imagemsistema WHERE lado = 'IE'");
    $sql_ID = mysql_query("SELECT imagem FROM imagemsistema WHERE lado = 'ID'");
    $sql_IF = mysql_query("SELECT imagem FROM imagemsistema WHERE lado = 'IF'");

    $usuario_SE = mysql_fetch_object($sql_SE);
    $usuario_SD = mysql_fetch_object($sql_SD);
    $usuario_IE = mysql_fetch_object($sql_IE);
    $usuario_ID = mysql_fetch_object($sql_ID);
    $usuario_IF = mysql_fetch_object($sql_IF);
?>

<div style="float: left; width: 50%">
    <fieldset style="height: 135px; text-align: center;">
                <legend class="legend">Superior Esquerdo</legend>
                <img id="cabecalho-logo" alt="Brasão da Prefeitura" src="../../Utilidades/Imagens/bancodeoportunidades/<?php echo $usuario_SE->imagem; ?>" width="210px" height="110px;" title="Largura: 210 | Altura: 110" />
                <br /><div class="legend" style="text-align: right;">Dimensões: 210 x 110</div>
    </fieldset>
</div>
<div style="float: left; width: 50%;">
            <fieldset style="height: 135px; text-align: center;">
                <legend class="legend">Superior Direito</legend>
                <img id="cabecalho-logo" alt="Banco de Oportunidades" src="../../Utilidades/Imagens/bancodeoportunidades/<?php echo $usuario_SD->imagem; ?>" width="266px" height="77px;" title="Largura: 266 | Altura: 77" />
                <br /><div class="legend" style="text-align: right; margin-top: 33px;">Dimensões: 266 x 77</div>
            </fieldset>
</div>
<div style="float: left; width: 50%;">
            <fieldset style="height: 135px; text-align: center;">
                <legend class="legend">Inferior Esquerdo</legend>
                <img style="margin-top: 30px;" src="../../Utilidades/Imagens/bancodeoportunidades/<?php echo $usuario_IE->imagem; ?>" width="168px" height="40px" title="Largura: 168 | Altura: 40">
                <br /><div class="legend" style="text-align: right; margin-top: 40px;">Dimensões: 168 x 40</div>
            </fieldset>
</div>
<div style="float: left; width: 50%;">
            <fieldset style="height: 135px; text-align: center;">
                <legend class="legend">Inferior Direito</legend>
                <img style="margin-top: 30px;" src="../../Utilidades/Imagens/bancodeoportunidades/<?php echo $usuario_ID->imagem; ?>" width="133px" height="40px" title="Largura: 133 | Altura: 40">
                <br /><div class="legend" style="text-align: right; margin-top: 40px;">Dimensões: 133 x 40</div>
            </fieldset>
</div>

<div style="float: left; margin-top: 20px;">
    <fieldset>
        <legend class="legend" style="text-align: center;">Imagem de fundo do sistema</legend>
        <img src="../../Utilidades/Imagens/bancodeoportunidades/<?php echo $usuario_IF->imagem; ?>" width="100%" title="Largura: 1800 | Altura: 700" />
        <br /><div class="legend" style="text-align: right; margin-top: 10px;">Somente imagens ".png" | Dimensões: 1800 x 700</div>
    </fieldset>
</div>
<?php
}else{
    session_destroy();
    
    header('Location:index.php');    
}
?>