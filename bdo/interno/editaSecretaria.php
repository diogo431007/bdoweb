<?php 
require_once 'header.php';

if(in_array(S_PESQUISA_SECRETARIA , $_SESSION[SESSION_ACESSO])){
?>
<div id="conteudo">
<!-- <img id="cabecalho-logo" alt="Brasão da Prefeitura" src="imagens/Orange wave.png">-->
    <div class="subtitulo">Banco de Oportunidades</div>
    <div id="principal">
      <ul>
        <li><a href="#parte-05"><span>Alteração de Secretaria</span></a></li>
        <li><a href="busca.php#parte-05"><span>Nova Pesquisa</span></a></li>
      </ul>

        <div id="parte-05">
	  <?php 			 
             $id = $_GET['edita'];
             
             if($id != "") {
		$sql = "SELECT * FROM secretaria WHERE id_secretaria = $id";
                $query = mysql_query($sql);			 
		while($row = mysql_fetch_object($query)) {		 
			?><form id="editaSecretaria" name="editaSecretaria" method="post" action="javascript:func()">
                                <div id="sec_load"></div>
                                <div id="sec_ok"></div>
                                <div id="sec_error"></div>
                                    <input name="id_secretaria" id="id_secretaria"  type="hidden"  value="<?php echo $row->id_secretaria ?>"/>
                                        
                                <fieldset>
                                        <legend class="legend">Dados Da Secretaria</legend>
				 <table class="tabela">
                                    <tr>
                                         <td><span class="style1">*</span></td>
                                         <td width="69">Secretaria:</td>
                                          <td width="546"><input name="secretaria" id="secretaria" class="campo" type="text"  value="<?php echo $row->nm_secretaria ?>"size="40" maxlength="60" /></td>
                                     </tr>
					  
                                          <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td><span class="style1">* Campos com * são obrigatórios!</span></td>
					  </tr>
				</table>
				</fieldset>
                                    <?PHP if(in_array(S_ALTERACAO_SECRETARIA , $_SESSION[SESSION_ACESSO])){?>
				<table class="tabela">
					   <tr>
					<td>
					        <input name="cadastrar" class="botao" type="submit" id="cadastrar" value="Alterar" />
					           </td>
					         </tr>
					       </table>
                                   <?php }?> 
					      </form>
			<?php	}
			}
			
	    ?>
        </div>
        <div id="parte-02">
        </div>
        <div id="parte-03">
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
