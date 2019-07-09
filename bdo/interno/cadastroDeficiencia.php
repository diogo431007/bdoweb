<?php  if(in_array(S_CADASTRO_DEFICIENCIA , $_SESSION[SESSION_ACESSO])){?>
<form id="cadastroDeficiencia" name="cadastroDeficiencia" method="post" action="javascript:func()">
   <div id="def_load"></div>
    <div id="def_error"></div>
     <div id="def_ok"></div>
    <fieldset>
     <legend class="legend">Cadastro de Deficiências</legend>
	   <table class="tabela">  
	     <tr>
	       <td><span class="style1">*</span></td>
	       <td width="69">Deficiência:</td>
		   <td width="546"><input name="deficiencia" class="campo" type="text" id="deficiencia" size="40" maxlength="60" /></td>
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