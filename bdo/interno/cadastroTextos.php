<?php  if(in_array(S_CADASTRO_TEXTOS , $_SESSION[SESSION_ACESSO])){?>
<form id="cadastroTexto" name="cadastroTexto" method="post" action="javascript:func()">
    <div id="def_load"></div>
    <div id="def_error"></div>
    <div id="def_ok"></div>
    <fieldset>
     <legend class="legend">Cadastro de Textos</legend>
	   <table width="100%" class="tabela">
            <tr>
                <td><span class="style1">*</span></td>
                <td width="20%">Título:</td>
                <td width="80%"><input name="ds_titulo" class="campo" type="text" id="ds_titulo" style="width: 830px;" /></td>
	    </tr>
            <tr>
                <td><span class="style1">*</span></td>
                <td>Texto:</td>
                <td><textarea name="ds_texto" id="ds_texto" class="campo" style="width: 830px; font-family: sans-serif;" rows="7"></textarea></td>
            </tr>
            <tr>
                <td colspan="3"><span class="style1">* Campos com * são obrigatórios!</span></td>
            </tr>
	  </table>
    </fieldset>
 <table class="tabela">
   <tr>
     <td>
         <input name="cadastrar" class="botao" type="submit" id="cadastrar" value="Enviar" />
       <input name="limpar" class="botao" type="reset" id="limpar" value="Limpar" />
     </td>
   </tr>
 </table>
</form>
<?php
$sql = "SELECT id_texto, ds_titulo, ds_texto FROM texto WHERE ao_ativo = 'S' ORDER BY id_texto DESC";
		$query = mysql_query($sql);

?>
<div class="tab_adiciona">
    <table width="100%" style="margin-top: 3px;">
        <tr class="table_formacao_cab">
            <td>Todas os textos iniciais cadastrados</td>
        </tr>
        <?php while($row = mysql_fetch_object($query)) { ?>
        <tr id="tr<?php echo $row->id_texto; ?>" class="tabelaTextosLista">
            <td>
                <form id="editaTexto<?php echo $row->id_texto; ?>" name="editaTexto<?php echo $row->id_texto; ?>" method="post" action="javascript:func()">
                    <div id="esconder<?php echo $row->id_texto; ?>">
                        <?php //Mensagem de erro ?>
                        <div class="per_load" id="per_load<?php echo $row->id_texto; ?>"></div>
                        <div class="per_error" id="per_error<?php echo $row->id_texto; ?>"></div>
                        <table width="100%" class="tabela" style="background: #FFF; margin-left: 14px;">
                         <tr>
                             <td><span class="style1">*</span></td>
                             <td width="20%">Título:</td>
                             <td width="80%">
                                 <input type="hidden" id="id_texto" name="id_texto" value="<?php echo $row->id_texto; ?>" />
                                 <input type="text" id="ds_titulo<?php echo $row->id_texto; ?>" name="ds_titulo<?php echo $row->id_texto; ?>" class="campo"  style="width: 830px;" value="<?php echo $row->ds_titulo; ?>" />
                             </td>
                         </tr>
                         <tr>
                             <td><span class="style1">*</span></td>
                             <td>Texto:</td>
                             <td><textarea name="ds_texto<?php echo $row->id_texto; ?>" id="ds_texto<?php echo $row->id_texto; ?>" class="campo" style="width: 830px; font-family: sans-serif;" rows="7"><?php echo $row->ds_texto; ?></textarea></td>
                         </tr>
                         <tr>
                             <td colspan="2" width="20%">&nbsp;</td>
                             <td width="80%">
                                 <input type="submit" id="btAtualizar" name="btAtualizar" value="Atualizar" class="botao" style="height: 20px;" onclick="alterarTexto(<?php echo $row->id_texto; ?>);"/>
                                 <input type="button" id="btCancelar" name="btCancelar" value="Cancelar" class="botao" style="height: 20px;" onclick="cancelarEditaTexto(<?php echo $row->id_texto; ?>)"/>
                             </td>
                         </tr>
                       </table>
                    </div>
                <div id="texto<?php echo $row->id_texto; ?>">
                        <?php //Mensagem de atualização do texto ?>
                        <div class="per_load" id="per_load<?php echo $row->id_texto; ?>"></div>
                        <div class="per_ok" id="per_ok<?php echo $row->id_texto; ?>"></div>
                    <b><div id="ds_tituloTexto<?php echo $row->id_texto; ?>" style="font-size: 13px; padding: 5px; margin: 1px 3px -5px 0px; " ><?php echo $row->ds_titulo; ?></div></b>
                    <hr id="hr<?php echo $row->id_texto; ?>" style="border: solid 1px #E4E2CD; width: 99%; margin-top: 7px;">
                    <div id="p<?php echo $row->id_texto; ?>"><p style="margin-bottom: 5px;" id="ds_textoTexto<?php echo $row->id_texto; ?>" class="tabelaTextos"><?php echo $row->ds_texto ?></p></div>
                    <div style="padding: 0px 0px 3px 3px; float:left;"><input class="botao" style="height: 20px;" type="button" id="btEditar<?php echo $row->id_texto; ?>" name="btEditar" value="Editar" onclick="editarTexto(<?php echo $row->id_texto; ?>);"/></div>
                    <div style="padding: 0px 0px 3px 3px; float:left;"><input class="botao" style="height: 20px;" type="submit" id="btExcluir<?php echo $row->id_texto; ?>" name="btExcluir" value="Excluir" onclick="if(confirm('Você tem certeza que deseja excluir este texto?')){excluirTexto(<?php echo $row->id_texto; ?>)};"/></div>
                </div>
                </form>
                <script>
                //--------SCRIPT DO EDITOR DE TEXTO-----------------
                    $('#esconder<?php echo $row->id_texto; ?>').hide(); //esconde a textarea ao carregar a página
                //---------------------------------------------------
                </script>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

<?php
}else{
    session_destroy();
    header('Location:index.php');
}
?>
