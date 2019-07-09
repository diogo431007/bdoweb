<?php
require_once 'header.php';
require_once 'funcoes.php';

if(in_array(S_PESQUISA_CANDIDATO , $_SESSION[SESSION_ACESSO])){
?>

<div id="conteudo">
 <!--<img id="cabecalho-logo" alt="Brasão da Prefeitura" src="imagens/Orange wave.png">-->
    <div class="subtitulo">Banco de Oportunidades</div>
    <div class="voltar_email_processos" style="float:right; margin-top: -10px;">
        <a href="busca.php#parte-00" id="voltar_email_processos" onclick="destruirSessaoBuscaCandidato();" title="Voltar a busca de candidatos">
        <img src="../../Utilidades/Imagens/bancodeoportunidades/buscar_novocandidato.png" style="width: 30px; height: 30px;" title="Fazer uma nova busca" />
        </a>
    </div>
    <div class="voltar_email_processos" style="float:right; margin-top: -10px;">
        <a href="busca.php#parte-00" id="voltar_email_processos" title="Voltar a busca de candidatos">
            <img src="../../Utilidades/Imagens/bancodeoportunidades/voltar_candidato.png" style="width: 30px; height: 30px;" />
        </a>
    </div>    
    <div id="principal">        
      <ul>
        <li><a href="#parte-00"><span>Alteração de Candidato</span></a></li>
        <li><a href="#parte-01"><span>Processos do Candidato</span></a></li>
        <li><a href="#parte-02"><span>Enviar Email ao Candidato</span></a></li>              
      </ul>        
        <div id="parte-00">
	  <?php 			 
             $id = $_GET['edita'];
             if($id != "") {
		  $sql = "SELECT * FROM candidato WHERE id_candidato = $id"; 
              
		$query = mysql_query($sql);			 
		$row = mysql_fetch_object($query);
                
                //Para colocar no fieldset da aba processod do candidato.
                $nome_candidato = $row->nm_candidato;
			?>
<form  name="editaCandidato" id="editaCandidato" method="post" action="enviaEditaCandidato.php">
<input name="idEditaCandidato" type="hidden" value="<?php echo$id?>" />
   <fieldset>
      <legend class="legend">Dados Pessoais</legend>
	    <table class="tabela">
                <tr>
		    <td><span class="style1">*</span></td>
			<td width="69">Nome <?php //echo $_SESSION['id_usuario']; ?> :</td>
			<td width="546"><input name="nome_cand" id="nome_cand" value="<?php echo $row->nm_candidato; ?>" class="campo"  type="text"  size="71" maxlength="60" /></td>  
                </tr>
                
		<tr>
		    <td><span class="style1">*</span></td>
			<td>CPF:</td>
                        <td><input readonly name="cpf_cand" id="cpf_cand" value="<?php echo $row->nr_cpf; ?>" onkeypress='return valida_numero(event)' onKeydown='Formata(this,20,event,2)' class="campo" type="text"  size="20" maxlength="15" /></td>  
               </tr>
               
                <tr>
                    <td><span class="style1"></span></td>
                    <td>RG:</td>
                    <td><input readonly name="rg_cand" id="cpf_cand" value="<?php echo $row->nr_rg;?>" onkeypress='return valida_numero(event)' class="campo" type="text"  size="20" maxlength="10" /></td> 
                </tr>
               
                <tr>
                    <td><span class="style1"></span></td>
                    <td>CTPS Nº:</td>
                    <td>
                        <input name="ctps_cand" id="ctps_cand" value="<?php echo $row->nr_ctps; ?>" onkeypress="return valida_numero(event);" class="campo" type="text"  size="20" maxlength="10" />
                            &nbsp;&nbsp;
                    <span class="style1"></span>&nbsp;Série Nº:
                    <input name="nr_serie" id="nr_serie" value="<?php echo $row->nr_serie; ?>" class="campo" type="text"  size="7" maxlength="5" />
                    &nbsp;
                    <span class="style1"></span>&nbsp;UF:
                    <select name="estado_ctps" id="estado_ctps" class="campo">
                        <option value="">----</option>
                        <?php
                        $sqlUf = "SELECT * FROM estado ORDER BY nm_estado";
                        $query = mysql_query($sqlUf);
                        while ($rowUf = mysql_fetch_object($query)) {
                        ?>
                        <option value="<?php echo $rowUf->id_estado;?>" <?php if ($row->id_estadoctps == $rowUf->id_estado) echo "selected" ?>>
                            <?php
                            echo $rowUf->sg_estado;
                            ?>
                        </option>
                        <?php
                        }
                        ?>
                    </select>
                       </td>
		  </tr>
                  <tr>
                  <td><span class="style1"></span></td>
                    <td>PIS/PASEP:</td>
                    <td>
                        <input name="pis_cand" id="pis_cand" value="<?php echo $row->nr_pis; ?>" onkeypress="return valida_numero(event);" class="campo" type="text"  size="20" maxlength="50" />
                    </td>
                  </tr>
                  <tr>
                <td><span class="style1"></span></td>
                <td>CNH:</td>
                    <td>
                        <select name="cnh_cand" id="cnh_cand" class="campo"  >
                            <option value="">Selecione</option>
                            <option value="ACC" <?php if ($_POST['cnh_cand'] == 'ACC') echo "selected" ?>>ACC</option>
                            <option value="A" <?php if ($_POST['cnh_cand'] == 'A') echo "selected" ?>>A</option>
                            <option value="B" <?php if ($_POST['cnh_cand'] == 'B') echo "selected" ?>>B</option>
                            <option value="C" <?php if ($_POST['cnh_cand'] == 'C') echo "selected" ?>>C</option>
                            <option value="D" <?php if ($_POST['cnh_cand'] == 'D') echo "selected" ?>>D</option>
                            <option value="E" <?php if ($_POST['cnh_cand'] == 'E') echo "selected" ?>>E</option>
                            <option value="AB" <?php if ($_POST['cnh_cand'] == 'AB') echo "selected" ?>>AB</option>
                            <option value="AC" <?php if ($_POST['cnh_cand'] == 'AC') echo "selected" ?>>AC</option>
                            <option value="AD" <?php if ($_POST['cnh_cand'] == 'AD') echo "selected" ?>>AD</option>
                            <option value="AE" <?php if ($_POST['cnh_cand'] == 'AE') echo "selected" ?>>AE</option>
                        </select>
                    </td>
                 </tr>
		  <tr>
                      <td><span class="style1">*</span></td>
	              <td>Email:</td>
		      <td><input name="email_cand"  id="email_cand" value="<?php echo $row->ds_email; ?>" class="campo" type="text"  size="71" maxlength="60" />
                  </tr>
                  
                    <tr>
                        <td><span class="style1"></span></td>
                        <td>Telefone:</td>
                        <td><input name="tel_cand" id="tel_cand" value="<?php echo $row->nr_telefone ?>" class="campo" onkeypress="return valida_numero(event);" type="text" maxlength="14" /> <!-- onBlur="ValidaTelefone(cadastro.tel);" /--></td>
                    </tr>
                  
                    <tr>
                        <td><span class="style1"></span></td>
                        <td>Celular:</td>
                        <td><input name="cel_cand" id="cel_cand" value="<?php echo $row->nr_celular ?>" class="campo" onkeypress="return valida_numero(event);" type="text" maxlength="14" /> <!-- onBlur="ValidaTelefone(cadastro.tel);" /--></td>
                    </tr>
                    
		    <tr>
                        <td><span class="style1"></span></td>
                        <td>Estado Civil:</td>
                        <td>
                          <select name="estciv_cand" id="estciv_cand" class="campo"  >
			    <option value="S" <?php if($row->ds_estado_civil == 'S') echo "selected";?>>Solteiro</option>
		            <option value="C" <?php if($row->ds_estado_civil == 'C') echo "selected";?>>Casado</option>
		            <option value="V" <?php if($row->ds_estado_civil == 'V') echo "selected";?>>Viúvo</option>
		          </select>
                        </td>
		   </tr>
                   
		  <tr>
		        <td><span class="style1">*</span></td>
                        <td>Nascimento:</td>
                        <td><input type="text" name="dtanasc_cand" id="dtanasc_cand" value="<?php echo mysql_to_data($row->dt_nascimento);?>" onkeypress="return valida_numero(event);" onkeydown="formata_data(this,event);" class="campo data" size="10" maxlength="10"/></td>	
		  </tr>
                  
                <tr>
                    <td><span class="style1">*</span></td>
		    <td>Sexo:</td>
		    <td><input name="sexo_cand" id="sexo_cand" type="radio" value="M" checked="checked" <?php if($row->ao_sexo == 'M') echo "checked";?> />Masculino
		        <input name="sexo_cand" id="sexo_cand" type="radio" value="F" <?php if($row->ao_sexo == 'F') echo "checked";?> />Feminino
                    </td>
		</tr>
                  
                <tr>
                    <td>&nbsp;</td>
		    <td>Nacionalidade:</td>
		    <td><input name="nacio_cand" id="nacio_cand" value="<?php echo $row->ds_nacionalidade;?>"class="campo" type="text"/></td>
                </tr>
                              
                <tr>
                    <td>
                        <span class="style1"></span>
                    </td>
                    <td>
                        <label>Cep:</label>
                    </td>
                    <td>
                        <input type="text" name="nr_cepcand" value="<?php echo $row->nr_cep;?>" id="nr_cepcand" class="campo" maxlength='9' onBlur="ValidaCep(this.value)" onkeypress="return BloqueiaLetras(this.value);" />
                    </td>
                </tr>

                <tr>
                    <td><span class="style1"></span></td>
                    <td>Estado:</td>
                    <td>
                        <select name="estado_cand" id="estado_cand" class="campo select">
                            <option value="">Selecione</option>
                            <?php
//                            $c->id_cidade;
                            if (is_numeric($row->id_cidade)){
                                $sqlUfAux = "SELECT DISTINCT(id_estado) FROM cidade WHERE id_estado IN (SELECT id_estado FROM cidade WHERE id_cidade = $row->id_cidade)";
                                $queryAux = mysql_query($sqlUfAux);
                                $auxIdUf = mysql_result($queryAux,0);
                            }
                            //}
                            $sqlUf = "SELECT * FROM estado ORDER BY nm_estado";
                            $query = mysql_query($sqlUf);
                            while ($rowUf = mysql_fetch_object($query)) {
                            ?>
                            <option value="<?php echo $rowUf->id_estado;?>" <?php if ($_POST['estado_cand'] == $rowUf->id_estado || $auxIdUf == $rowUf->id_estado) echo "selected" ?>>
                                <?php
                                echo $rowUf->nm_estado;
                                ?>
                            </option>
                            <?php
                            
                            } 
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><span class="style1"></span></td>
                    <td>Cidade:</td>
                    <td>
                        <select name="cidade_cand" id="cidade_cand" class="campo select">
                        <?php
                        
                        $sqlCidade = "SELECT * FROM cidade WHERE id_estado IN (SELECT id_estado FROM cidade WHERE id_cidade = ".$row->id_cidade.")";
                        $queryCidade = mysql_query($sqlCidade);
                        if($queryCidade){
                            $cidades = '';
                            while ($rowCidade = mysql_fetch_object($queryCidade)) {
                                if($rowCidade->id_cidade == $row->id_cidade){
                                    $cidades.= "<option selected value='$rowCidade->id_cidade'>".$rowCidade->nm_cidade."</option>";
                                }
                                $cidades.= "<option value='$rowCidade->id_cidade'>".$rowCidade->nm_cidade."</option>";
                            }
                            echo $cidades;
                        }
                        
                        ?>
                        </select>
                    </td>
                </tr>
                 
                <tr>
		    <td><span class="style1"></span></td>	      
		    <td>Logradouro:</td>
		    <td><input name="logra_cand" id="logra_cand" class="campo" value="<?php echo $row->ds_logradouro;?>" type="text"  size="70" maxlength="70" /></td>
		</tr>
		<tr>
		    <td><span class="style1"></span></td>
		    <td>Nº:</td>
		    <td><input name="num_cand" id="num_cand" value="<?php echo $row->nr_logradouro;?>" onkeypress="return valida_numero(event);" class="campo" type="text"  size="10" maxlength="10" /></td>
		</tr>
		<tr>
		    <td>&nbsp;</td>
		    <td>Complemento:</td>
			<td><input name="comp_cand" id="comp_cand" class="campo" value="<?php echo $row->ds_complemento;?>" type="text"  size="70" maxlength="70" /></td>
                </tr>
		<tr>
		    <td><span class="style1"></span></td>
		    <td>Bairro:</td>
		    <td><input name="bairro_cand" id="bairro_cand" class="campo" value="<?php echo $row->ds_bairro;?>" type="text"  maxlength="20" /></td>
		</tr>
                <tr>
                  <td><span class="style1"></span></td>
                  <td>Deficiência:</td>
                  <td>
                    <select name="def_cand" id="def_cand" class="campo select">
                        <option value="">Nenhuma</option>
                       <?php 
                          $sql = "SELECT * FROM deficiencia ORDER BY nm_deficiencia ASC ";
                          $query = mysql_query($sql);

                          while($row_prof = mysql_fetch_object($query)) {
                                ?><option value="<?php echo $row_prof->id_deficiencia?>" <?php if($row->id_deficiencia == $row_prof->id_deficiencia) echo "selected";?>><?php echo $row_prof->nm_deficiencia?></option>';
                          <?php 
                           }
                           ?>
                        </select>
                      </td>
                </tr> 

                <tr>
                    <td><span class="style1"></span></td>
                    <td>Objetivo:</td>
                    <td><textarea name="obj_cand" id="obj_cand" cols="50" rows="3" class="campo"><?php echo $row->ds_objetivo;?></textarea></td>
               </tr>
               <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><span class="style1">* Campos com * são obrigatórios!</span></td>
               </tr>
               <tr>
                   <td colspan="3" class="legend">
                       <br /><br />
                       DADOS DE ACESSO<br />
                       <hr style="width: 100%;">                       
                   </td>
               </tr>
               <tr>
                   <td class="padding_dados_acesso" colspan="2">
                       Login:
                   </td>
                   <td class="padding_dados_acesso" >
                       <?php echo $row->ds_loginportal; ?>
                   </td>
               </tr>
               <tr>
                   <td class="padding_dados_acesso" colspan="2">
                       Senha:
                   </td>
                   <td class="padding_dados_acesso">
                       Sugere-se trocar a senha no primeiro acesso.
                   </td>
               </tr>
               <tr>
                   <td class="padding_dados_acesso" colspan="2">
                       Cadastro:
                   </td>
                   <td class="padding_dados_acesso">
                        <?php echo mysql_to_data($row->dt_cadastro); ?>
                   </td>
               </tr>
               <tr>
                   <td class="padding_dados_acesso" colspan="2">Último acesso:</td>
                   <td class="padding_dados_acesso">
                       <?php
                        $sqlUltimoAcesso = "SELECT MAX(id_log), MAX(dt_log) AS data, DATEDIFF(now(), MAX(dt_log)) AS dias_acesso FROM log WHERE id_acesso = '$row->id_candidato'";
                                                
                        $queryUltimoAcesso = mysql_query($sqlUltimoAcesso);			 
                        $rowUltimoAcesso = mysql_fetch_object($queryUltimoAcesso);
                        
                        if($rowUltimoAcesso->data == null){
                            echo "Sem registro de acesso ao sistema";
                        }else{
                            if($rowUltimoAcesso->dias_acesso == "0"){
                                echo mysql_to_data($rowUltimoAcesso->data).", acessou hoje o sistema.";
                            }else if($rowUltimoAcesso->dias_acesso == "1"){
                                echo mysql_to_data($rowUltimoAcesso->data).", acessou ontem o sistema.";
                            }else{
                                echo mysql_to_data($rowUltimoAcesso->data).", ".$rowUltimoAcesso->dias_acesso." dias sem acessar o sistema.";
                            }
                        }
                       ?>
                   </td>
               </tr>
               <tr>
                   <td class="padding_dados_acesso" colspan="2">
                       Status:
                   </td>
                   <td class="padding_dados_acesso">
                       <?php 
                          if(($row->ao_ativo == 'A') || ($row->ao_ativo == 'N')){
                              echo "Inativo";
                          }else{
                              echo "Ativo";
                          }
                       
                       ?>
                   </td>
               </tr>
               <tr>
                   <td colspan="3">              
                       <br />                       
                   </td>
               </tr>
              </table>
	 </fieldset>

	   <fieldset>
	   <legend class="legend">Profissões</legend>
                <table class="tab_form" width="100%">
                    <tr>
                        <td><span class="style1">*</span></td>
                        <td>Profissões:</td>
                        <td>
                            <input type="checkbox" name="" id="tdProf" value="" onclick="marcarTodosProfissao();" /> MARCAR TODOS
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>
                            <?php
                            $sql_profissao = "select 
                                                cp.*
                                           from 
                                                candidatoprofissao cp
                                           where 
                                                id_candidato = $row->id_candidato";
                            
                            $query = mysql_query($sql_profissao);

                            $candProfissoes = array();
                            while($row = mysql_fetch_object($query)) {
                                $candProfissoes[] = $row;
                            }
                            
                            $sql = "select p.id_profissao, p.nm_profissao from profissao p where ao_ativo = 'S' order by p.nm_profissao ASC";
                            //die($sql);
                            $query = mysql_query($sql);

                            $auxProfissoes = array();
                            while($row = mysql_fetch_object($query)) {
                                $auxProfissoes[] = $row;
                            }


                            foreach($auxProfissoes as $p) {
                            ?>
                            <div class="checkProfissaoCand">
                                <input type="checkbox" class="mProf" id="" name="profissoes[]" value="<?php echo $p->id_profissao; ?>" 
                                    <?php 
                                    if (isset($_POST['profissoes']) && in_array($p->id_profissao, $_POST['profissoes'])) { echo 'checked'; }
                                    else if(count($candProfissoes)>0){
                                        foreach ($candProfissoes as $cp) {
                                            if($p->id_profissao == $cp->id_profissao) echo 'checked';
                                        }
                                    } ?> /> 
                                    <?php echo $p->nm_profissao; ?>
                            </div>
                            <?php
                            }
                            ?>
                        </td>
                    </tr>

                    <?php /* -- OUTRO --
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>
                            <div class="checkProfissaoOutroCand">
                                <input type="checkbox" class="oProf" name="ao_outro" value="S" 
                                        <?php
        //                                if (isset($_SESSION['post']['ao_outro'])) {
        //                                    echo 'checked';
        //                                }else if(count(ControleSessao::buscarObjeto('privateCand')->profissoes)>0){
        //                                    foreach (ControleSessao::buscarObjeto('privateCand')->profissoes as $cp) {
        //                                        if($cp->profissao->ao_ativo == 'V') echo 'checked';
        //                                    }
        //                                 }
                                         ?> onclick="desmarcar();" />OUTRO

                                <input <?php
        //                                    if(ControleSessao::buscarObjeto('privateCand')->profissoes>0){
        //                                        foreach (ControleSessao::buscarObjeto('privateCand')->profissoes as $cp) {
        //                                            if($cp->profissao->ao_ativo == 'V'){
        //                                                $aux = '';
        //                                            }else{
                                                        $aux = 'style="display: none;"';
        //                                            }
        //                                        }
        //                                    }else if(!(isset($_SESSION['errosPR']) && in_array('ds_outro',$_SESSION['errosPR']))){ 
        //                                        $aux = 'style="display: none;"';
        //                                    }
                                            echo $aux;
                                            ?>
                                    name="ds_outro"  id="ds_outro" value="<?php 
        //                                                                    if(isset($_SESSION['errosPR'])){ 
        //                                                                        echo $_SESSION['post']['ds_outro'];
        //                                                                    }else if(count(ControleSessao::buscarObjeto('privateCand')->profissoes)>0){
        //                                                                        foreach (ControleSessao::buscarObjeto('privateCand')->profissoes as $cp){
        //                                                                            if($cp->profissao->ao_ativo == 'V') echo $cp->profissao;
        //                                                                        }
        //                                                                    } 
                                                                            ?>"
                                type="text" />

                            </div>
                        </td>
                    </tr>
                    */ ?>
                </table>   
        </fieldset>
<!----------------------------------------------------------------------------------------------------------------------->
           <fieldset>
               <legend class="legend">Formação</legend>
               <fieldset>
               
               <?php
                   
                    //inicio da consulta pra mostrar os resultados da formação num while do candidato.
                            $sqlform2 = "SELECT
                                        cf.id_candidato_formacao,
                                        cf.dt_termino,
                                        cf.ds_cidadeescola,
                                        cf.nm_escola,
                                        f.nm_formacao, 
                                        f.id_formacao,
                                        cf.ds_curso,
                                        cf.ds_semestre
                                FROM 
                                        candidatoformacao cf, 
                                        formacao f 
                                WHERE 
                                        f.id_formacao = cf.id_formacao AND
                                        cf.id_candidato = ".$id." 
                                order by cf.id_candidato_formacao ASC";
	                                
                    $queryform2 = mysql_query($sqlform2);	    
                    $rowCont = mysql_num_rows($queryform2);
                    echo "<div>";
                    if($rowCont>0){ 
                        
                            echo "<table width='100%'>";
                                echo "<tr class='table_formacao_cab'>";
                                    echo"<td align='center'>Escolaridade</td>";
                                    echo"<td align='center' width='10%'>Data Termino</td>";
                                    echo"<td align='center'>Escola</td>";
                                    echo"<td align='center'>Cidade</td>";
                                    echo"<td align='center' width='5%'>Deleta</td>";
                                echo "</tr>";
                        while($rowform = mysql_fetch_object($queryform2)) {
                            if($rowform->id_formacao == 1){
                                echo "<tr class='table_formacao_row'>";
                                    echo "<td align='center'>". $rowform->nm_formacao . verificarCursoSemestre($rowform->ds_curso, $rowform->ds_semestre) . "</td>";
                                    echo "<td align='center'>".converterDataMysql($rowform->dt_termino). "</td>";
                                    echo "<td align='center'>".$rowform->nm_escola. "</td>";
                                    echo "<td align='center'>".$rowform->ds_cidadeescola. "</td>";
                                    echo '<td align="center" width="5%" id="deletar"><a href="deletaFormacaoCandidato.php?deletar='.$rowform->id_candidato_formacao.'&candidato='.$id.'"><img src="../../Utilidades/Imagens/bancodeoportunidades/deleta.png"></a></td>';
                                echo '</tr>';   
//                                echo '<div class="linhatabela">';
//                                echo '<div class="linha nome">'. $rowform->nm_formacao . verificarCursoSemestre($rowform->ds_curso, $rowform->ds_semestre) .'</div>';
//                                echo '<div class="linha telefone"></div>';
//                                echo '<div class="linha profissao"></div>';
//                                echo '<div class="linha telefone"></div>';
//                                echo '<div class="linha edita" id="deletar"><a href="deletaFormacaoCandidato.php?deletar='.$rowform->id_candidato_formacao.'&candidato='.$id.'"><img src="imagens/deleta.png"></a></div>';
//                                echo '</div>';                                             
                            }else{
                                echo "<tr class='table_formacao_row'>";
                                    echo "<td align='center'>". $rowform->nm_formacao . verificarCursoSemestre($rowform->ds_curso, $rowform->ds_semestre) . "</td>";
                                    echo "<td align='center' width='10%'>".converterDataMysql($rowform->dt_termino). "</td>";
                                    echo "<td align='center'>".$rowform->nm_escola. "</td>";
                                    echo "<td align='center'>".$rowform->ds_cidadeescola. "</td>";
                                    echo '<td align="center" width="5%" id="deletar"><a href="deletaFormacaoCandidato.php?deletar='.$rowform->id_candidato_formacao.'&candidato='.$id.'"><img src="../../Utilidades/Imagens/bancodeoportunidades/deleta.png"></a></td>';
                                echo '</tr>';   
//                                echo '<div class="linhatabela">';
//                                echo '<div class="linha nome">'.$rowform->nm_formacao . verificarCursoSemestre($rowform->ds_curso, $rowform->ds_semestre) . '</div>';
//                                echo '<div class="linha telefone" align="center">'.converterDataMysql($rowform->dt_termino). '</div>';
//                                echo '<div class="linha profissao">'.$rowform->nm_escola. '</div>';
//                                echo '<div class="linha telefone">'.$rowform->ds_cidadeescola. '</div>';                            
//                                echo '<div class="linha edita" id="deletar"><a href="deletaFormacaoCandidato.php?deletar='.$rowform->id_candidato_formacao.'&candidato='.$id.'"><img src="imagens/deleta.png"></a></div>';
//                                echo '</div>';
                            }                        
                        }
                    }else{
                        echo '<div class="headertabela">
                                 <div class="tabelapesq nome">Candidato sem formação cadastrada</div>
                              </div>';
                        
                    }
                    echo "</table>";
                    echo "</div>";
                    echo "</fieldset>";
              ?>
	    <div id="origem_formacao">  
	      <table class="tabela">
	        <tr>
		      <td><span class="style1">*</span></td>
			  <td width="69">Escolaridade:</td>
                          <td width="546">
                             <select name="form_cand[]" id="form_cand" class="campo">
                             <option value="" >Selecione...</option>
                            <?php
                            $sqlf = "SELECT 
                                            * 
                                    FROM 
                                            formacao f 
                                    ORDER BY f.id_formacao ASC";
                            $queryf = mysql_query($sqlf);
                            while($row_esco = mysql_fetch_object($queryf)) {
                            ?>
                            <option value="<?php echo $row_esco->id_formacao?>"><?php echo $row_esco->nm_formacao?></option>
                            <?php }?>
			    </select></td>
		    </tr>
                        <tr id="auxCurso" <?php echo "style='display: none;'";?>>
                        <td><span class="style1">*</span></td>
                        <td>Curso:</td>
                        <td><input value="<?php echo $_POST['curso_cand'][$i];?>" type="text" name="curso_cand[]"  id="curso_cand" class="campo" size="35" maxlength="30"/></td>	
                    </tr>
                    <tr id="auxSemestre" <?php echo "style='display: none;'";?>>
                        <td><span class="style1">*</span></td>
                        <td>Semestre:</td>
                        <td><input value="<?php echo $_POST['semestre_cand'][$i];?>" type="text" name="semestre_cand[]" onkeypress="return valida_numero(event);" id="semestre_cand" class="campo" size="20" maxlength="2"/></td>	
                    </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td>Data Termino:</td>
                      <td><input  value="<?php echo $rowform->dt_termino?>"  type="text" name="dtatermform_cand[]"  id="dtatermform_cand" onkeypress="return valida_numero(event);" onkeydown="formata_data(this,event);" class="campo" size="10" maxlength="10"/></td>	
		    </tr>
		    <tr>
		     <td>&nbsp;</td>
			  <td>Escola:</td>
			  <td><input name="escolaform_cand[]"  value="<?php echo $rowform->nm_escola?>" id="escolaform_cand" class="campo" type="text"  size="70" maxlength="60" /></td>  
		    </tr>
		    <tr>
		      <td>&nbsp;</td>
			  <td>Cidade Escola:</td>
			  <td><input name="cidesc_cand[]" id="cidesc_cand" value="<?php echo $rowform->ds_cidadeescola?>" class="campo" type="text"  size="70" maxlength="60" /></td>  
		    </tr>
		    <tr>
		     <td>&nbsp;</td>
		     <td>&nbsp;</td>
		     <td><span class="style1">* Campos com * são obrigatórios!</span></td>
		   </tr>
		   <tr>
		     <td>&nbsp;</td>
		     <td>&nbsp;</td>
		     <td><img  src="../../Utilidades/Imagens/bancodeoportunidades/add.png" width="25px" height="25px" style="cursor: pointer;" onclick="duplicarFormacao();">  
                 <img  src="../../Utilidades/Imagens/bancodeoportunidades/cross.png" width="25px" height="25px" style="cursor: pointer;" onclick="removerFormacao(this);"></td>
		   </tr>
	       </table> 
	     </div>
	     <div id="destino_formacao"></div>
             
	 </fieldset>
         <fieldset>
             <legend class="legend">Qualificações e Atividades Profissionais</legend>
             <fieldset>
	   
              <?php  $sqlquali = "SELECT 
                                        * 
                                  FROM 
                                        candidatoqualificacao cq 
                                  WHERE 
                                        cq.id_candidato = ".$id." 
                                  ORDER BY cq.id_candidato ASC";
	            $queryquali = mysql_query($sqlquali);
                 $rowCont = mysql_num_rows($queryquali);
                echo '<div>';
                 if($rowCont>0){
                ?>
                
                    <table width='100%'>
                        <tr class='table_formacao_cab'>
                            <td align='center'>Descricao</td>
                            <td align='center'>Instituição</td>
                            <td align='center' width='10%'>Data Termino</td>
                            <td align='center' width='8%'>Qtn. Horas</td>
                            <td align='center' width='5%'>Deleta</td>
                        </tr>
                <!--<div class="headertabela">
                <div class="tabelapesq nome">Descricao</div>
                <div class="tabelapesq profissao">Instituição</div>
                <div class="tabelapesq telefone">Data Termino</div>
                <div class="tabelapesq telefone">Qtn. Horas</div>
                <div class="tabelapesq edita">Deleta</div>
              </div>-->
              <?php
	           while($rowquali = mysql_fetch_object($queryquali)) {	
                        echo "<tr class='table_formacao_row'>";
                            echo "<td align='center'>". $rowquali->ds_qualificacao. '</td>';
                            echo "<td align='center'>". $rowquali->nm_instituicao. '</td>';
                            echo "<td align='center' width='10%'>". converterDataMysql($rowquali->dt_termino). '</td>';
                            echo "<td align='center' width='8%'>". $rowquali->qtd_horas. '</td>';
                            echo '<td align="center" width="5%" id="deletar"><a href="deletaQualificacaoCandidato.php?deletar='.$rowquali->id_qualificacao.'&candidato='.$id.'"><img src="../../Utilidades/Imagens/bancodeoportunidades/deleta.png"></a></td>';
                         echo '</tr>';    
                    }
                    }else{
                        ?>
                <div class="headertabela">
                <div class="tabelapesq nome">Candidato sem qualificações cadastradas</div>
              </div>
                        <?php
                    }
                        echo "</table>";
                    echo "</div>";
                    echo "</fieldset>";
                    
              ?> 
	    <div id="origem_qualificacao">  
	      <table class="tabela">
	        <tr>
		      <td>&nbsp;</td>
			  <td width="69">Descrição:</td>
			  <td width="546"><input name="descquali_cand[]" id="descquali_cand" class="campo" type="text"  size="70" maxlength="60" /></td>  
		    </tr>
		    <tr>
		      <td>&nbsp;</td>
			  <td>Instituição:</td>
			  <td><input name="instquali_cand[]" id="instquali_cand" class="campo" type="text"  size="70" maxlength="60" /></td>  
		    </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td>Data Termino:</td>
			  <td><input type="text" name="dtatermquali_cand[]" onkeypress="return valida_numero(event);" onkeydown="formata_data(this,event);" id="dtatermquali_cand" class="campo data" size="10" maxlength="10"/></td>	
		    </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td>Qnt. Horas:</td>
			  <td><input type="text" name="qnthsquali_cand[]" onkeypress="return valida_numero(event);" id="qnthsquali_cand"  class="campo" size="10" maxlength="10"/>Hrs.</td>	
		    </tr>
		    <tr>
		     <td>&nbsp;</td>
		     <td>&nbsp;</td>
		     <td><span class="style1">* Campos com * são obrigatórios!</span></td>
		   </tr>
		   <tr>
		     <td>&nbsp;</td>
		     <td>&nbsp;</td>
		     <td><img  src="../../Utilidades/Imagens/bancodeoportunidades/add.png" width="25px" height="25px" style="cursor: pointer;" onclick="duplicarQualificacao();">  
                 <img  src="../../Utilidades/Imagens/bancodeoportunidades/cross.png" width="25px" height="25px" style="cursor: pointer;" onclick="removerQualificacao(this);"></td>
		   </tr>
	       </table> 
	     
	     <div id="destino_qualificacao"></div>
             </fieldset>
	 <fieldset>
	   <legend class="legend">Experiência Profissional</legend>
           <fieldset>
              
              <?php
	            $sqlexp = "SELECT 
                                    * 
                               FROM 
                                    candidatoexperiencia ce
                               WHERE 
                                    ce.id_candidato = ".$id." 
                               ORDER BY ce.id_candidato ASC";
	            $queryexp = mysql_query($sqlexp);
                    $rowCont = mysql_num_rows($queryexp);
                    echo "<div>";
                    if($rowCont>0){ 
                      
                            echo "<table width='100%'>";
                                echo "<tr class='table_formacao_cab'>";
                                    echo"<td align='center'>Empresa</td>";
                                    echo"<td align='center'>Principais Atividades</td>";
                                    echo"<td align='center' width='10%'>Data inicio</td>";
                                    echo"<td align='center' width='10%'>Data Termino</td>";
                                    echo"<td align='center' width='5%'>Deleta</td>";
//                    echo '<div class="headertabela">
//                        <div class="tabelapesq nome">Empresa</div>
//                        <div class="tabelapesq profissao">Principais Atividades</div>
//                        <div class="tabelapesq telefone">Data inicio</div>
//                        <div class="tabelapesq telefone" >Data Termino</div>
//                        <div class="tabelapesq edita">Deleta</div>
//                        </div>';
                    while($rowexp = mysql_fetch_object($queryexp)) {	
                          echo "<tr class='table_formacao_row'>";
                          echo "<td align='center'>". $rowexp->nm_empresa. '</td>';
                          echo "<td align='center'>". $rowexp->ds_atividades. '</td>';
                          echo "<td align='center' width='10%'>". converterDataMysql($rowexp->dt_inicio). '</td>';
                          echo "<td align='center' width='10%'>". converterDataMysql($rowexp->dt_termino). '</td>';
                          echo '<td align="center" width="5%" id="deletar"><a href="deletaExperienciaCandidato.php?deletar='.$rowexp->id_experiencia.'&candidato='.$id.'"><img src="../../Utilidades/Imagens/bancodeoportunidades/deleta.png"></a></td>';
//                        echo '<div class="linhatabela">';
//                        echo '<div class="linha nome">'.$rowexp->nm_empresa. '</div>';
//                        echo '<div class="linha profissao">'.$rowexp->ds_atividades. '</div>';
//                        echo '<div class="linha telefone" align="center">'.converterDataMysql($rowexp->dt_inicio). '</div>';
//                        echo '<div class="linha telefone" align="center">'.converterDataMysql($rowexp->dt_termino). '</div>';
//                        echo '<div class="linha edita" id="deletar"><a href="deletaExperienciaCandidato.php?deletar='.$rowexp->id_experiencia.'&candidato='.$id.'"><img src="imagens/deleta.png"></a></div>';
//                        echo '</div>';
                        
                    }
				}else{
					echo '	<div class="headertabela">
					        <div class="tabelapesq nome">Candidato sem experiencia profissional</div>
                                                </div>';
				}
                                echo "</table>";
                    echo "</div>";
                    echo "</fieldset>";
              ?>
	    <div id="origem_experiencia">  
	      <table class="tabela">
	        <tr>
		      <td>&nbsp;</td>
		      <td width="69">Data Início:</td>
			  <td width="546"><input type="text" onkeypress="return valida_numero(event);" onkeydown="formata_data(this,event);" name="dtainiexp_cand[]" id="dtainiexp_cand" class="campo" size="10" maxlength="10"/></td>	
		    </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td>Data Termino:</td>
			  <td><input type="text" name="dtaterexp_cand[]" onkeypress="return valida_numero(event);" onkeydown="formata_data(this,event);" id="dtaterexp_cand" class="campo" size="10" maxlength="10"/></td>	
		    </tr>
		    <tr>
		      <td>&nbsp;</td>
			  <td>Empresa:</td>
			  <td><input name="empresaexp_cand[]" id="empresaexp_cand" class="campo" type="text" id="empresa" size="70" maxlength="60" /></td>  
		    </tr>
		    <tr>
		     <td>&nbsp;</td>
		     <td>Principais Atividades:</td>
		     <td><textarea name="prinativexp_cand[]" id="prinativexp_cand" cols="50" rows="3" class="campo"></textarea></td>
		   </tr>
		    <tr>
		    <tr>
		     <td>&nbsp;</td>
		     <td>&nbsp;</td>
		     <td><span class="style1">* Campos com * são obrigatórios!</span></td>
		   </tr>
		   <tr>
		     <td>&nbsp;</td>
		     <td>&nbsp;</td>
		     <td><img  src="../../Utilidades/Imagens/bancodeoportunidades/add.png" width="25px" height="25px" style="cursor: pointer;" onclick="duplicarExperiencia();">  
                         <img  src="../../Utilidades/Imagens/bancodeoportunidades/cross.png" width="25px" height="25px" style="cursor: pointer;" onclick="removerExperiencia(this);"></td>
		   </tr>
	       </table> 
	     </div>
	     <div id="destino_experiencia">  
         </div>
	 </fieldset>
            <?php if(in_array(S_ALTERACAO_CANDIDATO , $_SESSION[SESSION_ACESSO])){?>
            <table>
                <tr>
                    <td colspan="2">
                        <input name="cadastrar" class="botao" type="submit" id="cadastrar" value="Enviar" />
                        <input name="limpar"  class="botao" type="reset" id="limpar" value="Limpar" />
                    </td>
                </tr>
            </table> 
            <?php }?>
      </form>
<?php	
			}
                        else{
                            echo "<script>alert('Candidato não encontrado!');window.location = 'busca.php#parte-00';</script>";
                        }
	    ?>
            
            
            <!-- INÍCIO DA ABA PROCESSOS -->
            </div>
            <div id="parte-01">
                <?php
                
                $idCandProcessos = $_GET['edita'];
                if($id != ""){
		$sqlCandidato = "SELECT * FROM candidato WHERE id_candidato = $idCandProcessos"; 
                
                $sqlProcessos = "SELECT
                            vc.id_candidato, vc.ao_status, vc.dt_status, v.id_vaga, p.id_profissao, p.nm_profissao, 
                            e.id_empresa, e.nm_razaosocial, e.nm_fantasia
                        FROM vagacandidato vc 
                            JOIN vaga v ON (vc.id_vaga = v.id_vaga)
                            JOIN empresa e ON (v.id_empresa = e.id_empresa)
                            JOIN profissao p ON (v.id_profissao = p.id_profissao)
                        WHERE
                            vc.id_candidato = '$idCandProcessos'
                        ORDER BY vc.dt_status DESC";
                        
                $queryProcessos = mysql_query($sqlProcessos);
                                
                if(mysql_num_rows($queryProcessos) > 0){
                    
                    $auxProcesso = array();
                    while ($rowProcesso = mysql_fetch_object($queryProcessos)) {
                        $auxProcesso[] = $rowProcesso;
                    }                    
                ?>
                <fieldset style="height: 60%; margin: 0px; border: solid 1px #EE7228;">
                    <legend class="legend"><label style="font-size: x-small;">PROCESSOS SELETIVOS -</label> <label style="color: #4682B4;"><?php echo $nome_candidato; ?></label></legend>
                    <table class="table_processos" width="100%" border="1">
                        <tr class="table_processos_cab">
                            <td width="30%" style="text-align: center;">Profissão</td>
                            <td width="30%" style="text-align: center;">Empresa</td>
                            <td width="15%" style="text-align: center;">Status</td>
                            <td width="15%" style="text-align: center;">Data / Hora</td>
                        </tr>
                        <?php
                        //define a quantidade de resultados da lista
                        $qtd = 10;
                        //busca a page atual
                        $page = (isset($_GET['pg'])) ? $_GET['pg'] : 0;
                        //recebo um novo array com apenas os elemento necessarios para essa page atual
                        $processos = listar($auxProcesso, $qtd, $page);

                        foreach($processos as $p){
                            //testa se o elemento do array n?o é nulo
                            if(!is_null($p)){
                            
                        ?>
                        <tr class="table_processos_row">
                            <td width="30%"><label class='processos_candidato'><?php echo $p->nm_profissao; ?></label></td>
                            <td width="30%">
                                <?php
                                    if(($p->ao_status == 'E') || ($p->ao_status == 'B') || ($p->ao_status == 'D')){
                                        if(empty($p->nm_fantasia)){
                                            echo "<label class='processos_candidato'>".$p->nm_razaosocial."</label><br />";
                                        }else{
                                            echo "<label class='processos_candidato'>".$p->nm_fantasia."</label><br />";
                                        }
                                        echo "Empresa confidencial para o candidato nesta vaga";
                                    }else{
                                        echo "<label class='processos_candidato'>".$p->nm_fantasia."</label>";
                                    }                                    
                                ?>
                            </td>
                            <td width="15%" style="text-align: center;">
                                <?php
                                    if($p->ao_status == 'E'){
                                        echo "Encaminhado";
                                    }else if($p->ao_status == 'B'){
                                        echo "Baixa Automática";
                                    }else if ($p->ao_status == 'P'){
                                        echo "Pré-Selecionado";
                                    }else if($p->ao_status == 'C'){
                                        echo "Contratado";
                                    }else{
                                        echo "Dispensado";
                                    }
                                ?>
                            </td>
                            <td width="15%" style="text-align: center;"><?php echo date('d/m/Y H:i:s', strtotime($p->dt_status)); ?></td>
                        </tr>
                        <?php
                            }
                        }
                        
                        if(mysql_num_rows($queryProcessos) > 10){
                        ?>
                        <tr>
                            <td colspan="4" style="text-align: center;">
                                <span id="paginacaoProcessoCandidato">
                                    <?php
                                    //crio a paginacao propriamente dita
                                    $ancora = "&edita=$idCandProcessos#parte-01";
                                    echo criarPaginacao($auxProcesso, $qtd, $page, $ancora);
                                    ?>
                                </span>
                            </td>
                        </tr>
                        <?php } ?>
                    </table>                    
                </fieldset>
                <?php
                }else{ ?>
                    <fieldset style="height: 60%; margin: 0px; border: solid 1px #EE7228;">
                        <legend class="legend">Processos Seletivos - <?php echo $nome_candidato; ?></legend>
                        <table class="table_processos" width="100%" border="1">
                            <tr class="table_processos_cab">
                                 <td width="100%" style="text-align: center;">&nbsp;</td>
                            </tr>
                            <tr class="legend">
                                <td style="text-align: center; height: 392px; font-size: 18px;" colspan="4">CANDIDATO SEM HISTÓRICO DE PROCESSOS</td>
                            </tr>
                        </table>                   
                    </fieldset>
                <?php
                    }                
                }//else{
                    //Não precisa deste alert pois ele já informa um alert na outra aba e redireciona.
                    //echo "<script>alert('Candidato não encontrado!');window.location = 'busca.php#parte-00';</script>";
                //}                
                ?>
            </div>
            <!-- FIM DA ABA PROCESSOS -->
            <!-- INÍCIO DA ABA ENVIAR EMAIL AO CANDIDATO -->
            <div id="parte-02">
                <fieldset style="height: 60%; margin: 0px; border: solid 1px #EE7228;">
                    <legend class="legend_envio_email_individual">ENVIO DE EMAIL INDIVIDUAL</legend>
                    <?php
                        $sqlEmail = "SELECT id_candidato, nm_candidato, ds_email FROM candidato where id_candidato = '".$_GET['edita']."'";
                        
                        $queryEmail = mysql_query($sqlEmail);
                        
                        $emailCandidato = mysql_fetch_object($queryEmail);                        
                    
                    //Quando da o submit de enviou de email, ele insere na sessão avisando que o email foi enviado
                    //Se estiver vazio mostra o enviou normal, caso contrário mostra a mensagem de que o email foi enviado
                    if(empty($_SESSION['enviouEmail'])){
                    ?>                    
                    <form name="formEnviaEmail" id="formEnviaEmail" method="post" enctype="multipart/form-data" action="controleCandidato.php?op=enviarEmail&edita=<?php echo $_GET['edita']; ?>">
                        <table class="tabela_enviar_email" style="display: block;">
                            <tr>
                                <td style="width: 15%;">Nome:</td>
                                <td style="width: 85%; font-weight: bold;"><?php echo $emailCandidato->nm_candidato; ?></td>
                            </tr>
                            <tr>
                                <td>Email:</td>
                                <td style="text-transform: lowercase;"><?php echo $emailCandidato->ds_email; ?></td>
                            </tr>
                            <tr>
                                <td>Assunto:</td>
                                <td style="padding: 0px;"><input name="ds_assunto" id="ds_assunto" onkeypress="document.getElementById('ds_assunto').style.background = '#FFF'" value="Banco de Oportunidades - Comunicado" style="border: none; width: 100%; height: 33px; padding: 10px;"></td>
                            </tr>
                            <tr>
                                <td>Anexo:</td>
                                <td style="padding: 0px;"><input type="file" size="50" name="arquivo" id="arquivo" class="upload_enviar_email" /></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="height: 270px; padding: 0px;">
                                    <textarea name="ds_emailindividual" id="ds_emailindividual" class="email_individual" onkeypress="document.getElementById('ds_emailindividual').style.background = '#FFF'" placeholder="Digite aqui o email que deseja enviar a <?php echo $emailCandidato->nm_candidato; ?>"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="border: none; text-align: right; padding: 10px 0px; ;">                                                                        
                                    <input type="reset" name="enviar_email" id="enviar_email" class="botao_email" value="LIMPAR" />
                                    <input type="button" name="enviar_email" id="enviar_email" class="botao_email" value="ENVIAR" onclick="envia_email('<?php echo $emailCandidato->nm_candidato; ?>');" />                                    
                                </td>
                            </tr>
                        </table>                        
                    </form>
                    <?php }else{ 
                        //Pegar o primeiro nome;
                        $nome_completo = $emailCandidato->nm_candidato;
                        $primeiro_nome = explode(" ", $nome_completo);
                    ?>

                        <div id="tabelaPosEmail" style="display: block;">
                            <div id="pos_envio_email" class="pos_envio_email" style="display: block;">
                                <label style="font-size: 20px;">EMAIL ENVIADO COM SUCESSO!</label><br /><br /><br /><br /><br /><br />
                                <input type="button" name="enviar_email" id="enviar_email" class="botao_pos_email" value="ENVIAR OUTRO EMAIL PARA <?php echo $primeiro_nome[0]; ?>" onclick="location.reload();" />
                            </div>
                        </div>
                    <?php
                        //Limpo a sessão caso o usuário de F5, para voltar ao envio de email
                        unset($_SESSION['enviouEmail']);
                        } 
                    ?>                    
                    <div id="tabelaPosEmail" style="display: none;">                        
                        <?php
                            //Pegar o primeiro nome;
                            $nome_completo = $emailCandidato->nm_candidato;
                            $primeiro_nome = explode(" ", $nome_completo);
                        ?>
                        <div id="imagem_envio_email" style="width: 100%; display: none; text-align: center; margin-top: 140px;">
                            <img src="../../Utilidades/Imagens/bancodeoportunidades/enviando_email.gif" />
                            <br /><br />                            
                            <label style="color: black; font-weight: bold; font-size: 13px;">ENVIANDO EMAIL PARA <?php echo $primeiro_nome[0]; ?>...</label>
                        </div>
                        <div id="pos_envio_email" class="pos_envio_email" style="display: none;">
                            <label style="font-size: 20px;">EMAIL ENVIADO COM SUCESSO!</label><br /><br /><br /><br /><br /><br />
                            <input type="button" name="enviar_email" id="enviar_email" class="botao_pos_email" value="ENVIAR OUTRO EMAIL PARA <?php echo $primeiro_nome[0]; ?>" onclick="location.reload();" />
                        </div>                                
                    </div>    
                </fieldset>
            </div>
            <!-- FIM DA ABA ENVIAR EMAIL AO CANDIDATO -->
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
