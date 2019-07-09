<?php  if(in_array(S_CADASTRO_FAQ , $_SESSION[SESSION_ACESSO])){?>
<form id="cadastroFaq" name="cadastroFaq" method="post" action="javascript:func()">
   <div id="def_load"></div>
    <div id="def_error"></div>
     <div id="def_ok"></div>
    <fieldset>
     <legend class="legend">Cadastro de Perguntas</legend>
	   <table width="100%" class="tabela">  
            <tr>
                <td><span class="style1">*</span></td>
                <td width="20%">Pergunta:</td>
                <td width="80%"><input name="ds_pergunta" class="campo" type="text" id="ds_pergunta" style="width: 830px;" /></td>
	    </tr>
            <tr>
                <td><span class="style1">*</span></td>
                <td>Resposta:</td>
                <td><textarea name="ds_resposta" id="ds_resposta" class="campo" style="width: 830px; font-family: sans-serif;" rows="7"></textarea></td>
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
$sql = "SELECT id_pergunta, ds_pergunta, ds_resposta FROM pergunta WHERE ao_ativo = 'S' ORDER BY id_pergunta DESC";
		$query = mysql_query($sql);
   
?>
<div class="tab_adiciona">
    <table width="100%" style="margin-top: 3px;">
        <tr class="table_formacao_cab">
            <td>Todas as perguntas frequentes cadastradas</td>
        </tr>
        <?php while($row = mysql_fetch_object($query)) { ?>
        <tr id="tr<?php echo $row->id_pergunta; ?>" class="tabelaPerguntasLista">        
            <td>
                <form id="editaFaq<?php echo $row->id_pergunta; ?>" name="editaFaq<?php echo $row->id_pergunta; ?>" method="post" action="javascript:func()">
                    <div id="esconder<?php echo $row->id_pergunta; ?>">
                        <?php //Mensagem de erro ?>
                        <div class="per_load" id="per_load<?php echo $row->id_pergunta; ?>"></div>                        
                        <div class="per_error" id="per_error<?php echo $row->id_pergunta; ?>"></div>                        
                        <table width="100%" class="tabela" style="background: #FFF; margin-left: 14px;">  
                         <tr>
                             <td><span class="style1">*</span></td>
                             <td width="20%">Pergunta:</td>
                             <td width="80%">
                                 <input type="hidden" id="id_pergunta" name="id_pergunta" value="<?php echo $row->id_pergunta; ?>" />
                                 <input type="text" id="ds_pergunta<?php echo $row->id_pergunta; ?>" name="ds_pergunta<?php echo $row->id_pergunta; ?>" class="campo"  style="width: 830px;" value="<?php echo $row->ds_pergunta; ?>" />
                             </td>
                         </tr>
                         <tr>
                             <td><span class="style1">*</span></td>
                             <td>Resposta:</td>
                             <td><textarea name="ds_resposta<?php echo $row->id_pergunta; ?>" id="ds_resposta<?php echo $row->id_pergunta; ?>" class="campo" style="width: 830px; font-family: sans-serif;" rows="7"><?php echo $row->ds_resposta; ?></textarea></td>
                         </tr>
                         <tr>
                             <td colspan="2" width="20%">&nbsp;</td>
                             <td width="80%">
                                 <input type="submit" id="btAtualizar" name="btAtualizar" value="Atualizar" class="botao" style="height: 20px;" onclick="alterarPergunta(<?php echo $row->id_pergunta; ?>);"/>
                                 <input type="button" id="btCancelar" name="btCancelar" value="Cancelar" class="botao" style="height: 20px;" onclick="cancelarEditaPergunta(<?php echo $row->id_pergunta; ?>)"/>
                             </td>
                         </tr>
                       </table>
                    </div>                
                <div id="pergunta<?php echo $row->id_pergunta; ?>">
                        <?php //Mensagem de atualização da pergunta ?>
                        <div class="per_load" id="per_load<?php echo $row->id_pergunta; ?>"></div>                        
                        <div class="per_ok" id="per_ok<?php echo $row->id_pergunta; ?>"></div>
                    <b><div id="ds_perguntaTexto<?php echo $row->id_pergunta; ?>" style="font-size: 13px; padding: 5px; margin: 1px 3px -5px 0px; " ><?php echo $row->ds_pergunta; ?></div></b>
                    <hr id="hr<?php echo $row->id_pergunta; ?>" style="border: solid 1px #E4E2CD; width: 99%; margin-top: 7px;">
                    <div id="p<?php echo $row->id_pergunta; ?>"><p style="margin-bottom: 5px;" id="ds_respostaTexto<?php echo $row->id_pergunta; ?>" class="tabelaPerguntas"><?php echo $row->ds_resposta ?></p></div>                    
                    <div style="padding: 0px 0px 3px 3px; float:left;"><input class="botao" style="height: 20px;" type="button" id="btEditar<?php echo $row->id_pergunta; ?>" name="btEditar" value="Editar" onclick="editarPergunta(<?php echo $row->id_pergunta; ?>);"/></div>
                    <div style="padding: 0px 0px 3px 3px; float:left;"><input class="botao" style="height: 20px;" type="submit" id="btExcluir<?php echo $row->id_pergunta; ?>" name="btExcluir" value="Excluir" onclick="if(confirm('Você tem certeza que deseja excluir esta pergunta?')){excluirPergunta(<?php echo $row->id_pergunta; ?>)};"/></div>
                </div>
                </form>
                <script>
                //--------SCRIPT DO EDITOR DE TEXTO-----------------
                    $('#esconder<?php echo $row->id_pergunta; ?>').hide(); //esconde a textarea ao carregar a página                    
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