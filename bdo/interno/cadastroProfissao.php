<?php  
if(in_array(S_CADASTRO_PROFISSAO , $_SESSION[SESSION_ACESSO])){
?>
<form id="cadastroProfissao" name="cadastroProfissao" method="post" action="javascript:func()">
   <div id="prof_load"></div>
    <div id="prof_error"></div>
     <div id="prof_ok"></div>
    <fieldset>
     <legend class="legend">Cadastro de Profissão</legend>
	   <table class="tabela">  
	     <tr>
	       <td><span class="style1">*</span></td>
	       <td width="69">Profissão:</td>
		   <td width="546"><input name="profissao" class="campo" type="text" id="profissao" size="40" maxlength="60" /></td>
	     </tr>
             
             <tr>
	       <td><span class="style1">*</span></td>
	       <td width="69">Descrição:</td>
                    <td width="546">
                        <textarea style="" name="ds_profissao" id="ds_profissao" class="campo" rows="5" cols="50"></textarea>
                    </td>
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