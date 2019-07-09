<?php  if(in_array(S_CADASTRO_SECRETARIA , $_SESSION[SESSION_ACESSO])){?>
<form id="cadastroSecretaria" name="cadastroSecretaria" method="post" action="javascript:func()">
   <div id="sec_load"></div>
    <div id="sec_error"></div>
     <div id="sec_ok"></div>
    <fieldset>
     <legend class="legend">Cadastro de Secretarias</legend>
	   <table class="tabela">  
	     <tr>
	       <td><span class="style1">*</span></td>
	       <td width="69">Secretaria:</td>
		   <td width="546"><input name="secretaria" class="campo" type="text" id="secretaria" size="40" maxlength="60" /></td>
	     </tr>
	    
		 <tr>
		   <td>&nbsp;</td>
		   <td>&nbsp;</td>
		   <td><span class="style1">* Campos com * são obrigatórios!</span></td>
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
}else{
    session_destroy();
    header('Location:index.php');
}
?>