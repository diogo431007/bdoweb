<?php 
require_once 'header.php';

if(in_array(S_ALTERACAO_DEFICIENCIA , $_SESSION[SESSION_ACESSO])){
?>
<div id="conteudo">
 <!--<img id="cabecalho-logo" alt="Brasão da Prefeitura" src="imagens/Orange wave.png">-->
     <div class="subtitulo">Banco de Oportunidades</div>
    <div id="principal">
      <ul>
        <li><a href="#parte-04"><span>Alteração de Deficiências</span></a></li>
        <li><a href="busca.php#parte-04"><span>Nova Pesquisa</span></a></li>
      </ul>
        <div id="parte-04">
	  <?php 			 
             $id = $_GET['edita'];	
             if($id != "") {
		$sql = "SELECT * FROM deficiencia d WHERE d.id_deficiencia = $id";
		$query = mysql_query($sql);			 
		while($row = mysql_fetch_object($query)) {		 
			?><form id="editaDeficiencia" name="editaDeficiencia" method="post" action="javascript:func()">
                                <div id="user_load"></div>
                                <div id="user_ok"></div>
                                <div id="user_error"></div>
                                    <input name="id_deficiencia" id="id_deficiencia"  type="hidden"  value="<?php echo $row->id_deficiencia ?>"/>
                                        
                                <fieldset>
                                        <legend class="legend">Dados Da Deficiência</legend>
				 <table class="tabela">
                                    <tr>
                                         <td><span class="style1">*</span></td>
                                         <td width="69">Deficiência:</td>
                                          <td width="546"><input name="deficiencia" id="deficiencia" class="campo" type="text"  value="<?php echo $row->nm_deficiencia ?>"size="40" maxlength="60" /></td>
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
					        <input name="cadastrar" class="botao" type="submit" id="cadastrar" value="Alterar" />
					           </td>
					         </tr>
					       </table>
					      </form>
			<?php	}
			}
			
	    ?>
        </div>
      </div>
</div>
<?php 
require_once 'footer.php';  

}else{
    session_destroy();
    header('Location:index.php');
}
?>
