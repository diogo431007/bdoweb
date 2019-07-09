<?php 
    if(in_array(S_CADASTRO_USUARIO , $_SESSION[SESSION_ACESSO])){
?>
<form id="cadastroUsuario" name="cadastroUsuario" method="post" action="javascript:func()">
<div id="user_load"></div>
<div id="user_ok"></div>
<div id="user_error"></div>
   <fieldset>
     <legend class="legend">Dados De Usuário</legend>
	   <table class="tabela">  
	     <tr>
	       <td><span class="style1">*</span></td>
	       <td width="69">Nome:</td>
		   <td width="546"><input name="nome_user" id="nome_user" class="campo" type="text"  size="40" maxlength="60" /></td>
	     </tr>
	       <tr>
	         <td><span class="style1">*</span></td>
		     <td>Email:</td>
			 <td><input name="email_user" id="email_user" class="campo" type="text"  size="40" maxlength="60" /></td>
		   </tr>
                   <tr>
	             <td><span class="style1">*</span></td>
		     <td>Login:</td>
			 <td><input name="login_user" id="login_user" class="campo" type="text"  size="30" maxlength="20" /></td>
		   </tr>
		   <tr>
		     <td><span class="style1">*</span></td>
		     <td>Senha:</td>
		     <td><input class="campo" name="senha_user" id="senha_user" type="password"  maxlength="12" size="12" /></td>
		   </tr> 
		   <tr>
		     <td><span class="style1">*</span></td>
		     <td>Perfil:</td>
		     <td>
		       <select id="perfil_user" name="perfil_user" class="campo">
		         <option>Selecione...</option>
		         <?php 
		              $sql = "SELECT * FROM perfil p ORDER BY p.ds_perfil ASC";
		              $query = mysql_query($sql);
		         
		              while($row = mysql_fetch_object($query)) {
		         	    echo '<option value="'.$row->id_perfil.'">'.$row->ds_perfil.'</option>';
		              }
			     ?>
			   </select>
			 </td>
		   </tr> 
                   <tr>
		     <td><span class="style1">*</span></td>
		     <td>Secretaria:</td>
		     <td>
		       <select id="secretaria_user" name="secretaria_user" class="campo">
		         <option>Selecione...</option>
		         <?php 
		              $sql = "SELECT * FROM secretaria s ORDER BY s.nm_secretaria ASC";
		              $query = mysql_query($sql);
		         
		              while($row = mysql_fetch_object($query)) {
		         	    echo '<option value="'.$row->id_secretaria.'">'.$row->nm_secretaria.'</option>';
		              }
			     ?>
			   </select>
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