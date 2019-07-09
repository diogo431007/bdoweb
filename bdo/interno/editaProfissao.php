<?php 
require_once 'header.php';

if(in_array(S_ALTERACAO_PROFISSAO , $_SESSION[SESSION_ACESSO])){
?>
<div id="conteudo">
 <!--<img id="cabecalho-logo" alt="Brasão da Prefeitura" src="imagens/Orange wave.png">-->
    <div class="subtitulo">Banco de Oportunidades</div>
    <div id="principal">
      <ul>
        <li><a href="#parte-01"><span>Alteração de Profissões</span></a></li>
        <li><a href="busca.php#parte-07"><span>Nova Pesquisa</span></a></li>
      </ul>

        <div id="parte-01">
	  <?php 			 
             $id = $_GET['edita'];	
             if($id != "") {
		$sql = "SELECT 
                                * 
                        FROM 
                                profissao p 
                        WHERE 
                                p.id_profissao = $id";
		$query = mysql_query($sql);			 
		while($row = mysql_fetch_object($query)) {
			?><form id="editaProfissao" name="editaProfissao" method="post" action="javascript:func()">
                                <div id="user_load"></div>
                                <div id="user_ok"></div>
                                <div id="user_error"></div>
                                    <input name="id_profissao" id="id_profissao"  type="hidden"  value="<?php echo $row->id_profissao ?>"/>
                                        
                                <fieldset>
                                <legend class="legend">Dados Da Profissão</legend>
                                <table class="tabela" style="width: 100%;" border="0">
                                    <tr>
                                        <td width="1%"><span class="style1">*</span></td>
                                        <td width="9%">Profissão:</td>
                                        <td width="25%"><input name="profissao" id="profissao" class="campo" type="text"  value="<?php echo $row->nm_profissao ?>"size="48" maxlength="75" /></td>
                                        <td width="5%">&nbsp;</td>
                                        <td width="60%" rowspan="2" style="vertical-align: top;">
                                            Esta profissão já existe? Encaminhe o candidato ou empresa à uma profissão ativa.
                                            <br/>
                                            <input name="flag" onchange="mostrarSelectProfissao();" id="flag_s" class="campo" type="radio" value="S" />Sim
                                            <input name="flag" onchange="ocultarSelectProfissao();" id="flag_n" class="campo" type="radio" value="N" checked />Não
                                            <br/>
                                            <span id="span_prof" style="display: none;">
                                                Profissão:
                                                <select name="prof_encaminha" id="prof_encaminha" class="campo select">
                                                    <?php
                                                    $sqlCidade = "SELECT * FROM profissao WHERE ao_ativo = 'S' ORDER BY nm_profissao ASC";
                                                    $queryProf = mysql_query($sqlCidade);
                                                    if($queryProf){
                                                        $profissoes = '';
                                                        while ($rowProf = mysql_fetch_object($queryProf)) {
                                                            $profissoes .= "<option value='$rowProf->id_profissao'>" . $rowProf->nm_profissao . "</option>";
                                                        }
                                                        echo $profissoes;
                                                    }

                                                    ?>
                                                </select>
                                            </span>
                                        </td>
                                    </tr>
                                     
                                    <tr id="tr_descricao">
                                        <td><span class="style1">*</span></td>
                                        <td>Descrição:</td>
                                        <td>
                                            <textarea style="resize: none;" name="ds_profissao" id="ds_profissao" class="campo" rows="5" cols="40"><?php echo $row->ds_profissao ?></textarea>
                                        </td>
                                    </tr>
                                     
                                    <tr id="tr_status">
                                        <td><span class="style1">*</span></td>
                                        <td>Status:</td>
                                        <td colspan="2">
                                            <input name="ao_ativo" id="ao_ativo_s" class="campo" type="radio" value="S" checked />Ativo
                                            <input name="ao_ativo" id="ao_ativo_n" class="campo" type="radio" value="N" <?php if($row->ao_ativo == 'N') echo 'checked'; ?> />Inativo
                                            <input name="ao_ativo" id="ao_ativo_v" class="campo" type="radio" value="V" <?php if($row->ao_ativo == 'V') echo 'checked'; ?> />Em Validação
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
					        <input name="cadastrar" class="botao" type="submit" id="cadastrar" value="Alterar" />
					           </td>
					         </tr>
					       </table>
					      </form>
			<?php	}
			}
			
	    ?>
        </div>
        <div id="parte-02">
        </div>
        <div id="parte-07">
        </div>
      </div>
</div>
<?php 
//require_once 'footer.php';  

}else{
    session_destroy();
    header('Location:index.php');
}
?>
