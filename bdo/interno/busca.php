<?php
require_once 'header.php';
require_once 'funcoes.php';
require_once '../publico/util/Servicos.class.php';
require_once '../publico/util/ControleSessao.class.php';
if(in_array(S_PESQUISA , $_SESSION[SESSION_ACESSO])){

    $retorno_zero = "<span style='color:#EE7228; text-align:center; font-weight: bold; '>
                        Sua busca não retornou nenhum registro.
                     </span>";

?>
  <div id="conteudo">
    <!--<img id="cabecalho-logo" alt="Brasão da Prefeitura" src="imagens/Orange wave.png">-->
      <div class="subtitulo">Banco de Oportunidades</div>
      <div id="principal">
        <ul>
          <?php  if(in_array(S_PESQUISA_CANDIDATO , $_SESSION[SESSION_ACESSO])){?>
            <li><a href="#parte-00"><span>Busca Candidato</span></a></li>
          <?php } ?>

          <?php  if(in_array(S_PESQUISA_USUARIO , $_SESSION[SESSION_ACESSO])){?>
          <li><a href="#parte-02"><span>Busca Usuários</span></a></li>
          <?php } ?>

          <?php  if(in_array(S_PESQUISA_PERFIL , $_SESSION[SESSION_ACESSO])){?>
          <li><a href="#parte-03"><span>Busca Perfil</span></a></li>
          <?php } ?>

          <?php  if(in_array(S_PESQUISA_DEFICIENCIA , $_SESSION[SESSION_ACESSO])){?>
          <li><a href="#parte-04"><span>Busca Deficiência</span></a></li>
          <?php } ?>

          <?php  if(in_array(S_PESQUISA_SECRETARIA , $_SESSION[SESSION_ACESSO])){?>
          <li><a href="#parte-05"><span>Busca Secretaria</span></a></li>
          <?php } ?>

          <?php if(in_array(S_PESQUISA_EMPRESA, $_SESSION[SESSION_ACESSO])) {?>
          <li><a href="#parte-06"><span>Busca Empresa</span></a></li>
          <?php } ?>

          <?php if(in_array(S_PESQUISA_PROFISSAO , $_SESSION[SESSION_ACESSO])){?>
          <li><a href="#parte-07"><span>Busca Profissão</span></a></li>
          <?php } ?>

        </ul>

          <?php  if(in_array(S_PESQUISA_CANDIDATO , $_SESSION[SESSION_ACESSO])){?>
          <div id="parte-00">
              <form name="formBuscaCandidato" id="formBuscaCandidato" method="post" action="controleCandidato.php?op=buscar">
                  <div style="color: black;">
                      <br /><br />
                      <center><b>DIGITE O NOME DO CANDIDATO:</b></center>
                      <center>
                          <input type="text" name="busca_candidato" class="campo_texto_busca_candidato" value="<?php if(isset($_SESSION['post_busca_candidato'])){echo $_SESSION['post_busca_candidato']; } ?>" style="padding: 5px;" />
                          <input type="submit" name="botao_busca_candidato" class="botao_busca_candidato" value="BUSCAR" />
                      </center>
                      <br /><br />
                  </div>
              </form>
              <?php
                //Pega a data atual sem hora, com horas: date('Y-m-d H:i');
                date_default_timezone_set('America/Sao_Paulo');
                $dataatual = date('Y-m-d');

                //Número de currículos cadastrados no banco hoje.
                $totalCandidatosHoje = "SELECT count(*) as totalCandidatosHoje FROM candidato WHERE dt_cadastro > '$dataatual'";
                $resCurriculosCadHoje = mysql_fetch_object(mysql_query($totalCandidatosHoje));

                if($resCurriculosCadHoje->totalCandidatosHoje == 0){
                    $totalHoje = "NENHUM CANDIDATO";
                }else if($resCurriculosCadHoje->totalCandidatosHoje == 1){
                    $totalHoje = "1 CANDIDATO";
                }else{
                    $totalHoje = $resCurriculosCadHoje->totalCandidatosHoje." CANDIDATOS";
                }

              ?>
              <div style="float: left; font-size: x-small; color: black;">
                  <?php
                    if(isset($_SESSION['candidatos'])){
                        if(count($_SESSION['candidatos']) == '0'){
                            $busca = "SUA BUSCA RETORNOU <b style='font-size: 12px;'>NENHUM</b> CANDIDATO";
                        }else if(count($_SESSION['candidatos']) == '1'){
                            $busca = "SUA BUSCA RETORNOU <b style='font-size: 12px;'>1</b> CANDIDATO";
                        }else{
                            $busca = "SUA BUSCA RETORNOU <b style='font-size: 12px;'>".count($_SESSION['candidatos'])."</b> CANDIDATOS";
                        }
                    }
                    echo $busca;
                  ?>
              </div>
              <div style="float: right; font-size: x-small; color: black;">
                  CADASTRADOS HOJE: <?php echo $totalHoje; ?>
              </div>
              <br />
              <div style="border-top: solid 2px #4682B4;"></div>
              <br />
              <?php if(isset($_SESSION['candidatos']) && !empty($_SESSION['candidatos'])){ ?>
              <table class="tabelaBuscaCanditos" width="100%" style="display: block;">
                <tr>
                    <th width="45%">NOME</th>
                    <th width="30%">EMAIL / TELEFONE</th>
                    <th width="15%">STATUS</th>
                    <th width="5%">PROCESSOS</th>
                    <th width="5%">IMPRIMIR</th>
                </tr>
                <?php

                    //define a quantidade de resultados da lista
                    $qtd = 10;
                    //busca a page atual
                    $page = (isset($_GET['pg'])) ? $_GET['pg'] : 0;
                    //recebo um novo array com apenas os elemento necessarios para essa page atual
                    $lista = listar($_SESSION['candidatos'], $qtd, $page);


                    foreach($lista as $candidatos){
                        if(!is_null($candidatos)){
                ?>
                <tr class="busca_candidato_linha">
                    <td>
                        <div style="float:left; width: 20%; position: relative;">
                            <?php
                                $foto = "../publico/fotos/$candidatos->id_candidato.jpg";
                                $titlefoto = "";

                                if(!file_exists($foto)){
                                    if($candidatos->ao_sexo == "M"){
                                        $foto = "../../Utilidades/Imagens/bancodeoportunidades/candidato.png";
                                        $titlefoto = "Candidato sem foto";
                                    }else{
                                        $foto = "../../Utilidades/Imagens/bancodeoportunidades/candidata.png";
                                        $titlefoto = "Candidata sem foto";
                                    }
                                }
                            ?>
                            <img src="<?php echo $foto; ?>" title="<?php echo $titlefoto; ?>" style="width: 80px; height: 80px;" />
                        </div>
                        <div style="float:left; width: 75%; margin: 10px 0px 0px 10px;">
                        <label style="font-weight: bold;"><?php echo $candidatos->nm_candidato; ?></label>, <?php echo $candidatos->idade; ?> anos.
                        </div>
                        <div style="float:left; margin-left: 10px; margin-top: 10px; margin-bottom: -25px;">
                            <?php
                            //Caso tenha alguma deficiência mostra.
                            if(!empty($candidatos->id_deficiencia)){
                                $sqlDeficiencia = "SELECT * FROM deficiencia WHERE id_deficiencia = '".$candidatos->id_deficiencia."'";
                                $queryDeficiencia = mysql_query($sqlDeficiencia);

                                $deficiencia = mysql_fetch_object($queryDeficiencia);
                                if($candidatos->ao_sexo == "M"){
                                    $sexoDeficiencia = "Candidato";
                                }else{
                                    $sexoDeficiencia = "Candidata";
                                }
                                echo $sexoDeficiencia." com deficiência <b>".$deficiencia->nm_deficiencia."</b>.";
                            }
                        ?>
                        </div>
                        <div style="float:left; width: 75%; margin: 12px 0px 0px 10px;">
                            <div style="float: left; margin-top: 30px;">
                                <small>CÓDIGO: </small><b><?php echo $candidatos->id_candidato; ?></b>
                                - <a href="" class="enviar_email_candidato" style="color: #4682B4;" onclick="resetar_senha_candidato('<?php echo $candidatos->id_candidato; ?>','<?php echo $candidatos->nm_candidato; ?>', '<?php echo $candidatos->ds_email ?>', '<?php echo $candidatos->ds_loginportal; ?>');">RESETAR SENHA</a>
                            </div>
                            <div style="float: right;">
                                <div style="margin-bottom: 10px; float: right; position: relative;">
                                    <a href="editaCandidato.php?edita=<?php echo $candidatos->id_candidato; ?>" title="Edição dos dados de <?php echo $candidatos->nm_candidato; ?>">
                                        <img src="../../Utilidades/Imagens/bancodeoportunidades/edita_candidato.png" style="width: 40px; height: 40px;" />
                                    </a>
                                </div>
                                <div style="margin-top: 10px; padding: 3px; float: right; position: relative;">
                                    <label style="font-size: x-small; font-weight: bold; margin-bottom: 20px;">EDITAR:</label>
                                </div>
                            </div>
                        </div>
                        <div class="div_cadastro"><small>CADASTRO:</small> <?php echo date('d/m/Y', strtotime($candidatos->dt_cadastro)); ?></div>
                        <div class="div_login"><small>LOGIN:</small> <?php echo $candidatos->ds_loginportal; ?></div>
                    </td>
                    <td style="text-align: center;">
                        <label style="text-transform: lowercase;"><?php echo $candidatos->ds_email; ?></label>
                        <div style="border-top: solid 1px #EE7228; margin: 9px 0px 9px 0px;"></div>
                        <label>
                            <?php
                                if(empty($candidatos->nr_telefone) && empty($candidatos->nr_celular)){
                                    echo "Candidato sem telefone";
                                }else if(!empty($candidatos->nr_telefone) && empty($candidatos->nr_celular)){
                                    echo $candidatos->nr_telefone;
                                }else if(empty($candidatos->nr_telefone) && !empty($candidatos->nr_celular)){
                                    echo $candidatos->nr_celular;
                                }else{
                                    echo $candidatos->nr_telefone." | ".$candidatos->nr_celular;
                                }
                            ?>
                        </label>
                        <div style="text-align: center;">
                            <br /><br />
                            <?php
                                //Pegar o primeiro nome;
                                $nome_completo = $candidatos->nm_candidato;
                                $primeiro_nome = explode(" ", $nome_completo);
                            ?>
                            <a href="editaCandidato.php?edita=<?php echo $candidatos->id_candidato; ?>#parte-02" class="enviar_email_candidato" title="Irá enviar ume email para <?php echo $candidatos->nm_candidato; ?> com a descrição que desejar">ENVIAR EMAIL PARA <?php echo $primeiro_nome[0]; ?></a>
                        </div>
                    </td>
                    <td style="text-align: center;">
                        <?php if($candidatos->ao_ativo == 'S'){
                            $cordiv = "#008B00";
                        ?>
                            <div class="div_ativo">ATIVO</div>
                        <?php }else{
                            $cordiv = "#8B0000";
                        ?>
                            <div class="div_inativo">INATIVO</div>
                        <?php } ?>
                        <div style="color: <?php echo $cordiv; ?>; font-weight: bold;">
                            <?php
                                $sqlUltimoAcesso = "SELECT MAX(id_log), MAX(dt_log) AS data, DATEDIFF(now(), MAX(dt_log)) AS dias_acesso FROM log WHERE id_acesso = '$candidatos->id_candidato'";

                                $queryUltimoAcesso = mysql_query($sqlUltimoAcesso);
                                $rowUltimoAcesso = mysql_fetch_object($queryUltimoAcesso);

                                if($rowUltimoAcesso->data == null){
                                    echo "<br /><br />Sem registro de acesso ao sistema.<br /><br />";
                                }else{
                                    if($rowUltimoAcesso->dias_acesso == "0"){
                                        echo "<br /><br /><small>ACESSO:</small> ".date('d/m/Y', strtotime($rowUltimoAcesso->data)).", acessou hoje o sistema.";
                                    }else if($rowUltimoAcesso->dias_acesso == "1"){
                                        echo "<br /><br /><small>ACESSO:</small> ".date('d/m/Y', strtotime($rowUltimoAcesso->data)).", acessou ontem o sistema.";
                                    }else{
                                        echo "<br /><br /><small>ACESSO:</small> ".date('d/m/Y', strtotime($rowUltimoAcesso->data)).",<br /> ".$rowUltimoAcesso->dias_acesso." dias sem acessar o sistema.";
                                    }
                                }
                            ?>
                        </div>
                    </td>
                    <td style="text-align: center;">
                        <br />
                        <div>
                            <a href="editaCandidato.php?edita=<?php echo $candidatos->id_candidato; ?>#parte-01" title="Processos de <?php echo $candidatos->nm_candidato; ?>" >
                                <img src="../../Utilidades/Imagens/bancodeoportunidades/processos_candidato.png" style="width: 32px; height: 32px;" />
                            </a>
                        </div>
                        <div style="color: #000; font-weight: bold; margin-top: 10px;">
                        <?php
                            //Conto quantos processos o candidato tem.
                            $sqlProcessos = "select * from vagacandidato where id_candidato = '$candidatos->id_candidato'";

                            $queryProcessos = mysql_query($sqlProcessos);
                            $totalProcessos = mysql_num_rows($queryProcessos);

                            if($totalProcessos == '0'){
                                echo "Sem processos";
                            }else if($totalProcessos == '1'){
                                echo "1<br /> processo";
                            }else{
                                echo $totalProcessos."<br /> processos";
                            }
                        ?>
                        </div>
                    </td>
                    <td style="text-align: center;">
                        <div>
                            <form name="print_relatorio_<?php echo $candidatos->id_candidato; ?>" id="print_relatorio_<?php echo $candidatos->id_candidato; ?>" method="post" action="printCurriculo.php">
                                <input type="hidden" name="ids[]" id="ids" value="<?php echo $candidatos->id_candidato; ?>" />
                            </form>
                            <img src="../../Utilidades/Imagens/bancodeoportunidades/imprimir_candidato.png" style="width: 32px; height: 32px; margin-top: 23px; cursor: pointer;" onclick="imprimir_curriculo_individual('<?php echo $candidatos->id_candidato; ?>','<?php echo $candidatos->nm_candidato; ?>');" title="Fazer download do currículo de <?php echo $candidatos->nm_candidato; ?>" />
                        </div>
                        <div style="color: #000; font-weight: bold; font-size: x-small; margin-top: 10px;">
                            <?php
                                $cadastro = date('d/m/Y', strtotime($candidatos->dt_cadastro));
                                $atualizacao = date('d/m/Y', strtotime($candidatos->dt_alteracao));

                                if($cadastro == $atualizacao){
                                    echo "Nunca atualizado<br /><br />";
                                }else{
                                    echo "Atualizado<br />em: ".date('d/m/Y', strtotime($candidatos->dt_alteracao));
                                }
                            ?>
                        </div>
                    </td>
                </tr>
                <?php
                        }
                    }


                    if(count($_SESSION['candidatos']) > 10){
                ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">
                            <span id="paginacaoProcessoCandidato" style="text-transform: uppercase; font-size: 11px;">
                                <?php
                                //crio a paginacao propriamente dita
                                echo criarPaginacao($_SESSION['candidatos'], $qtd, $page);
                                ?>
                            </span>
                        </td>
                    </tr>
                <?php
                    }
                ?>
              </table>
              <?php }else{ ?>
              <table class="tabelaBuscaCanditos" width="100%">
                  <tr>
                      <th>CANDIDATOS</th>
                  </tr>
                  <tr>
                      <td style="text-align: center; height: 300px;">
                          <?php
                            //Número total de currículos cadastrados no banco.
                                $totalCandidatos = "SELECT count(*) as totalCandidatos FROM candidato";
                                $resCurriculosCad = mysql_fetch_object(mysql_query($totalCandidatos));

                                $totalCurriculos = $resCurriculosCad->totalCandidatos;
                          ?>
                          <div class="div_total_candidatos">TOTAL DE CANDIDATOS: <b style="font-size: 15px;"><?php echo $totalCurriculos; ?></b> CADASTRADOS</div>
                          <?php
                            //Número de currículos cadastrados no banco que estão ativos.
                                $totalCandidatosAtivos = "SELECT count(*) as totalCandidatosAtivos FROM candidato WHERE ao_ativo = 'S'";
                                $resCurriculosCadAtivos = mysql_fetch_object(mysql_query($totalCandidatosAtivos));

                                $totalCurriculosAtivos = $resCurriculosCadAtivos->totalCandidatosAtivos;
                          ?>
                          <div class="div_ativos_candidatos">ATIVOS: <b style="font-size: 14px;"><?php echo $totalCurriculosAtivos; ?></b></div>
                          <?php
                            //Número de currículos cadastrados no banco que estão ativos.
                                $totalCandidatosInativos = "SELECT count(*) as totalCandidatosInativos FROM candidato WHERE ao_ativo <> 'S'";
                                $resCurriculosCadInativos = mysql_fetch_object(mysql_query($totalCandidatosInativos));

                                //soma dois porque existe dois registros perdidos no banco
                                $totalCurriculosInativos = $resCurriculosCadInativos->totalCandidatosInativos;
                          ?>
                          <div class="div_inativos_candidatos">INATIVOS: <b style="font-size: 14px;"><?php echo $totalCurriculosInativos; ?></b></div>
                      </td>
                  </tr>

              </table>
              <?php } ?>
          </div>
          <?php } ?>

          <?php  if(in_array(S_PESQUISA_USUARIO , $_SESSION[SESSION_ACESSO])){?>
          <div id="parte-02">
            <div class="pesquisa">
              <form id="form1" action="" method="post">
                <div class="busca">
                  Pesquisa: <input type="text" name="busca_usuario" size="70" maxlength="60" id="busca" class="campo" value="" />
                            <input type="submit" name="Enviar" value="OK" style="border: solid 1px black; background: #EE7228; color: white; font-size: 12px; padding: 5px;">
                </div>
              </form>
            </div>
            <?php
                    if ($_POST['Enviar'] == 'OK' && !empty($_POST['busca_usuario'])) {
                        $busca = $_POST['busca_usuario'];
                        $pg_atual = 0;
                    }elseif ($_POST['Enviar'] == 'OK' && empty($_POST['busca_usuario'])) {
                        $busca = '';
                        $pg_atual = 0;
                    }else{
                        $busca = $_REQUEST['buscaUser'];
                        $pg_atual = $_GET['pgUser'];
                        if(!isset($pg_atual)) { $pg_atual = 0; }
                    }

                    $sql_all = mysql_query("SELECT
                                                    *
                                            FROM
                                                    usuario u
                                            WHERE
                                                    u.nm_usuario LIKE '%$busca%'
                                            ORDER BY u.nm_usuario ASC"); //executa a query com o limite de linhas.

                    $limit = 30; //determina qtd de resultados por pagina

                    $all = mysql_num_rows($sql_all); //recebe o total de registros

                    $qtd_pg = ceil($all / $limit); //retorna o total de páginas

                    $num_offset = $pg_atual * $limit; //retorna qual será a primeira linha a ser mostrada


                    $sql = "SELECT
                                    *
                            FROM
                                    usuario u
                            WHERE
                                    u.nm_usuario LIKE '%$busca%'
                            ORDER BY u.nm_usuario ASC
                            LIMIT $limit
                            OFFSET $num_offset";
                    $query = mysql_query($sql); //executa a query com o limite de linhas.

                    $num_rows = mysql_num_rows($query);
                    if($num_rows > 0){
                        // Cabeçalho da pesquisa
                        echo '<div class="headertabela">';
                        //echo '<div class="tabelapesq id">ID</div>';
                        echo '<div class="tabelapesq nome_user">Nome Completo</div>';
                        echo '<div class="tabelapesq nome_user">E-mail</div>';
                        echo '<div class="tabelapesq perfil_user">Perfil</div>';
                        echo '<div class="tabelapesq controle">Status</div>';
                        echo '<div class="tabelapesq edita">Edita</div>';

                        echo '</div>';

                        while($row = mysql_fetch_object($query)) {
                            echo '<div class="linhatabela">';
                            echo '<div class="linha nome_user">'.$row->nm_usuario. '</div>';
                            echo '<div class="linha nome_user">'.$row->ds_email. '</div>';
                            //busca na tabela de perfil a descrição do perfil do usuário.
                            $perfil = $row->id_perfil;
                            $perfilsql = "SELECT ds_perfil FROM perfil WHERE id_perfil = $perfil";
                            $queryperfil = mysql_query($perfilsql);
                            $rowperfil = mysql_fetch_object($queryperfil);
                            echo '<div class="linha perfil_user"> '.$rowperfil->ds_perfil.'</div>'; //exibe o perfil do usuário.
                            // Testa se o usário está ou não ativo, tipando corretamente a linha da pesquisa.
                            if ($row->ao_controle == "S"){
                                    echo '<div class="linha controle">Ativo</div>';
                            }else {
                                    echo '<div class="linha controle">Inativo</div>';
                            };
                            echo '<div class="linha edita" ><a href="editaUsuario.php?edita='.$row->id_usuario.';#parte-02"><img  src="../../Utilidades/Imagens/bancodeoportunidades/edita.png"></a></div>';
                            // echo '<div class="linha deleta"><a href="deletaUsuario.php?deleta='.$row->id_usuario.'"><img id="deltar" alt="Deletar" src="imagens/deleta.png"></a></div>';
                            echo "</div>";
                        }
                    }else{
                        echo $retorno_zero;
                    }
                    ?>
                <div class="paginacao">
                    <span>
                    <?php



                    if($qtd_pg > 1){

                        $espaco = '&nbsp&nbsp&nbsp';
                        $primeira = 0;
                        $ultima = $qtd_pg - 1;
                        $ant = $pg_atual - 1;
                        $prox = $pg_atual + 1;

                        if($pg_atual > 0) {
                            if($qtd_pg > 3){
                                $url_pri = "$PHP_SELF?pgUser=$primeira&buscaUser=$busca&#parte-02";
                                echo '<a href="'.$url_pri.'">Primeira</a>'.$espaco.'|'.$espaco;
                            }
                            $url = "$PHP_SELF?pgUser=$ant&buscaUser=$busca&#parte-02";
                            echo '<a href="'.$url.'">Anterior</a>'; // Vai para a página anterior
                         }
                         for($i = 0; $i < $qtd_pg; $i++) { // Gera um loop com o link para as páginas
                             $j = $i + 1;

                             if($pg_atual == $i){
                                 echo $espaco.'|'.$espaco.'<font class="page">'.$j.'</font>';
                             }else{
                                $url = "$PHP_SELF?buscaUser=$busca&pgUser=$i#parte-02";
                                echo $espaco.'|'.$espaco.'<a href="'.$url.'">'.$j.'</a>';
                             }
                         }
                         if($qtd_pg - $pg_atual != 1) {
                            $url = "$PHP_SELF?buscaUser=$busca&pgUser=$prox&#parte-02";
                            echo $espaco.'|'.$espaco.'<a href="'.$url.'">Próxima</a>';
                            if($qtd_pg > 3){
                                $url_ult = "$PHP_SELF?pgUser=$ultima&buscaUser=$busca#parte-02";
                                echo $espaco.'|'.$espaco.'<a href="'.$url_ult.'">Última</a>';
                            }
                        }
                    }
                    ?>
                    </span>
                </div>
          </div>
          <?php } ?>

          <?php  if(in_array(S_PESQUISA_PERFIL , $_SESSION[SESSION_ACESSO])){?>
          <div id="parte-03">
            <div class="pesquisa">
              <form id="form1" action="" method="post">
                <div class="busca">
                  Pesquisa: <input type="text" name="buscaPerfil" size="70" maxlength="60" id="buscaPerfil" class="campo" value="" />
                            <input type="submit" name="Enviar" value="OK" style="border: solid 1px black; background: #EE7228; color: white; font-size: 12px; padding: 5px;">
                </div>
              </form>
            </div>
              <?php
                    if ($_POST['Enviar'] == 'OK' && !empty($_POST['buscaPerfil'])) {
                        $busca = $_POST['buscaPerfil'];
                        $pg_atual = 0;
                    }elseif ($_POST['Enviar'] == 'OK' && empty($_POST['buscaPerfil'])) {
                        $busca = '';
                        $pg_atual = 0;
                    }else{
                        $busca = $_REQUEST['buscaPerf'];
                        $pg_atual = $_GET['pgPerf'];
                        if(!isset($pg_atual)) { $pg_atual = 0; }
                    }

                    $sql_all = mysql_query("SELECT
                                                    *
                                            FROM
                                                    perfil p
                                            WHERE
                                                    p.ds_perfil LIKE '%$busca%'
                                            ORDER BY p.ao_controle asc, p.ds_perfil"); //executa a query com o limite de linhas.

                    $limit = 15; //determina qtd de resultados por pagina

                    $all = mysql_num_rows($sql_all); //recebe o total de registros

                    $qtd_pg = ceil($all / $limit); //retorna o total de páginas

                    $num_offset = $pg_atual * $limit; //retorna qual será a primeira linha a ser mostrada


                    $sql = "SELECT
                                    *
                            FROM
                                    perfil p
                            WHERE
                                    p.ds_perfil LIKE '%$busca%'
                            ORDER BY p.ao_controle asc, p.ds_perfil
                            LIMIT $limit
                            OFFSET $num_offset";
                    $query = mysql_query($sql); //executa a query com o limite de linhas.

                    $num_rows = mysql_num_rows($query);
                    if($num_rows > 0){
                        // Cabeçalho da pesquisa
                        echo '<div class="headertabela">';
                        //echo '<div class="tabelapesq id">ID</div>';
                        echo '<div class="tabelapesq descricao_perf">Descrição</div>';
                        echo '<div class="tabelapesq controle">Status</div>';
                        echo '<div class="tabelapesq edita">Edita</div>';
                        echo '</div>';

                        while($row = mysql_fetch_object($query)) {
                            echo '<div class="linhatabela">';
                            //echo '<div id="editar" class="linha id" >'.$row->id_perfil. '</div>';
                            echo '<div class="linha descricao_perf">'.$row->ds_perfil. '</div>';
                            // Testa se o usário está ou não ativo, tipando corretamente a linha da pesquisa.
                            if ($row->ao_controle == "S"){
                                    echo '<div class="linha controle">Ativo</div>';
                            }else {
                                    echo '<div class="linha controle">Inativo</div>';
                            };
                            echo '<div class="linha edita" ><a href="editaPerfil.php?edita='.$row->id_perfil.';#parte-03"><img  src="../../Utilidades/Imagens/bancodeoportunidades/edita.png"></a></div>';
                            // echo '<div class="linha deleta"><a href="deletaUsuario.php?deleta='.$row->id_usuario.'"><img id="deltar" alt="Deletar" src="imagens/deleta.png"></a></div>';
                            echo "</div>";
                        }
                    }else{
                        echo $retorno_zero;
                    }
                    ?>
                <div class="paginacao">
                    <span>
                    <?php

                    if($qtd_pg > 1){

                        $espaco = '&nbsp&nbsp&nbsp';
                        $primeira = 0;
                        $ultima = $qtd_pg - 1;
                        $ant = $pg_atual - 1;
                        $prox = $pg_atual + 1;

                        if($pg_atual > 0) {
                            if($qtd_pg > 3){
                                $url_pri = "$PHP_SELF?buscaPerf=$busca&pgPerf=$primeira&#parte-03";
                                echo '<a href="'.$url_pri.'">Primeira</a>'.$espaco.'|'.$espaco;
                            }
                            $url = "$PHP_SELF?buscaPerf=$busca&pgPerf=$ant&#parte-03";
                            echo '<a href="'.$url.'">Anterior</a>'; // Vai para a página anterior
                         }
                         for($i = 0; $i < $qtd_pg; $i++) { // Gera um loop com o link para as páginas
                             $j = $i + 1;

                             if($pg_atual == $i){
                                 echo $espaco.'|'.$espaco.'<font class="page">'.$j.'</font>';
                             }else{
                                $url = "$PHP_SELF?buscaPerf=$busca&pgPerf=$i#parte-03";
                                echo $espaco.'|'.$espaco.'<a href="'.$url.'">'.$j.'</a>';
                             }
                         }
                         if($qtd_pg - $pg_atual != 1) {
                            $url = "$PHP_SELF?buscaPerf=$busca&pgPerf=$prox&#parte-03";
                            echo $espaco.'|'.$espaco.'<a href="'.$url.'">Próxima</a>';
                            if($qtd_pg > 3){
                                $url_ult = "$PHP_SELF?pgPerf=$ultima&buscaPerf=$busca#parte-03";
                                echo $espaco.'|'.$espaco.'<a href="'.$url_ult.'">Última</a>';
                            }
                        }
                    }
                    ?>
                    </span>
                </div>
          </div>
          <?php } ?>

          <?php  if(in_array(S_PESQUISA_DEFICIENCIA , $_SESSION[SESSION_ACESSO])){?>
          <div id="parte-04">
            <div class="pesquisa">
              <form id="form1" action="" method="post">
                <div class="busca">
                  Pesquisa: <input type="text" name="buscaDeficiencia" size="70" maxlength="60" id="buscaDeficiencia" class="campo" value="" />
                            <input type="submit" name="Enviar" value="OK" style="border: solid 1px black; background: #EE7228; color: white; font-size: 12px; padding: 5px;">
                </div>
              </form>
            </div>
            <?php
                    if ($_POST['Enviar'] == 'OK' && !empty($_POST['buscaDeficiencia'])) {
                        $busca = $_POST['buscaDeficiencia'];
                        $pg_atual = 0;
                    }elseif ($_POST['Enviar'] == 'OK' && empty($_POST['buscaDeficiencia'])) {
                        $busca = '';
                        $pg_atual = 0;
                    }else{
                        $busca = $_REQUEST['buscaDef'];
                        $pg_atual = $_GET['pgDef'];
                        if(!isset($pg_atual)) { $pg_atual = 0; }
                    }

                    $sql_all = mysql_query("SELECT
                                                    *
                                            FROM
                                                    deficiencia d
                                            WHERE
                                                    d.nm_deficiencia LIKE '%$busca%'
                                            ORDER BY d.nm_deficiencia ASC"); //executa a query com o limite de linhas.

                    $limit = 20; //determina qtd de resultados por pagina

                    $all = mysql_num_rows($sql_all); //recebe o total de registros

                    $qtd_pg = ceil($all / $limit); //retorna o total de páginas

                    $num_offset = $pg_atual * $limit; //retorna qual será a primeira linha a ser mostrada


                    $sql = "SELECT
                                    *
                            FROM
                                    deficiencia d
                            WHERE
                                    d.nm_deficiencia LIKE '%$busca%'
                            ORDER BY d.nm_deficiencia ASC
                            LIMIT $limit
                            OFFSET $num_offset";
                    $query = mysql_query($sql); //executa a query com o limite de linhas.

                    $num_rows = mysql_num_rows($query);
                    if($num_rows > 0){
                        // Cabeçalho da pesquisa
                        echo '<div class="headertabela">';
                        //echo '<div class="tabelapesq id">ID</div>';
                        echo '<div class="tabelapesq deficiencia_def">Deficiência</div>';
                        echo '<div class="tabelapesq edita">Edita</div>';
                        echo '</div>';

                        while($row = mysql_fetch_object($query)) {
                            echo '<div class="linhatabela">';
                            //echo '<div id="editar" class="linha id" >'.$row->id_profissao. '</div>';
                            echo '<div class="linha deficiencia_def">'.$row->nm_deficiencia. '</div>';
                            echo '<div class="linha edita" ><a href="editaDeficiencia.php?edita='.$row->id_deficiencia.';#parte-01"><img  src="../../Utilidades/Imagens/bancodeoportunidades/edita.png"></a></div>';
                            // echo '<div class="linha deleta"><a href="deletaUsuario.php?deleta='.$row->id_usuario.'"><img id="deltar" alt="Deletar" src="imagens/deleta.png"></a></div>';
                            echo "</div>";
                        }
                    }else{
                        echo $retorno_zero;
                    }
                    ?>
                <div class="paginacao">
                    <span>
                    <?php

                    if($qtd_pg > 1){

                        $espaco = '&nbsp&nbsp&nbsp';
                        $primeira = 0;
                        $ultima = $qtd_pg - 1;
                        $ant = $pg_atual - 1;
                        $prox = $pg_atual + 1;

                        if($pg_atual > 0) {
                            if($qtd_pg > 3){
                                $url_pri = "$PHP_SELF?buscaDef=$busca&pgDef=$primeira&#parte-04";
                                echo '<a href="'.$url_pri.'">Primeira</a>'.$espaco.'|'.$espaco;
                            }
                            $url = "$PHP_SELF?buscaDef=$busca&pgDef=$ant&#parte-04";
                            echo '<a href="'.$url.'">Anterior</a>'; // Vai para a página anterior
                         }
                         for($i = 0; $i < $qtd_pg; $i++) { // Gera um loop com o link para as páginas
                             $j = $i + 1;

                             if($pg_atual == $i){
                                 echo $espaco.'|'.$espaco.'<font class="page">'.$j.'</font>';
                             }else{
                                $url = "$PHP_SELF?buscaDef=$busca&pgDef=$i#parte-04";
                                echo $espaco.'|'.$espaco.'<a href="'.$url.'">'.$j.'</a>';
                             }
                         }
                         if($qtd_pg - $pg_atual != 1) {
                            $url = "$PHP_SELF?buscaDef=$busca&pgDef=$prox&#parte-04";
                            echo $espaco.'|'.$espaco.'<a href="'.$url.'">Próxima</a>';
                            if($qtd_pg > 3){
                                $url_ult = "$PHP_SELF?pgDef=$ultima&buscaDef=$busca#parte-04";
                                echo $espaco.'|'.$espaco.'<a href="'.$url_ult.'">Última</a>';
                            }
                        }
                    }
                    ?>
                    </span>
                </div>
          </div>
          <?php } ?>

          <?php  if(in_array(S_PESQUISA_SECRETARIA , $_SESSION[SESSION_ACESSO])){?>
          <div id="parte-05">
            <div class="pesquisa">
              <form id="form1" action="" method="post">
                <div class="busca">
                  Pesquisa: <input type="text" name="buscaSecretaria" size="70" maxlength="60" id="buscaSecretaria" class="campo" value="" />
                            <input type="submit" name="Enviar" value="OK" style="border: solid 1px black; background: #EE7228; color: white; font-size: 12px; padding: 5px;">
                </div>
              </form>
            </div>
            <?php
                    if ($_POST['Enviar'] == 'OK' && !empty($_POST['buscaSecretaria'])) {
                        $busca = $_POST['buscaSecretaria'];
                        $pg_atual = 0;
                    }elseif ($_POST['Enviar'] == 'OK' && empty($_POST['buscaSecretaria'])) {
                        $busca = '';
                        $pg_atual = 0;
                    }else{
                        $busca = $_REQUEST['buscaSec'];
                        $pg_atual = $_GET['pgSec'];
                        if(!isset($pg_atual)) { $pg_atual = 0; }
                    }

                    $sql_all = mysql_query("SELECT
                                                    *
                                            FROM
                                                    secretaria s
                                            WHERE
                                                    s.nm_secretaria LIKE '%$busca%'
                                            ORDER BY s.nm_secretaria ASC"); //executa a query com o limite de linhas.

                    $limit = 20; //determina qtd de resultados por pagina

                    $all = mysql_num_rows($sql_all); //recebe o total de registros

                    $qtd_pg = ceil($all / $limit); //retorna o total de páginas

                    $num_offset = $pg_atual * $limit; //retorna qual será a primeira linha a ser mostrada


                    $sql = "SELECT
                                    *
                            FROM
                                    secretaria s
                            WHERE
                                    s.nm_secretaria LIKE '%$busca%'
                            ORDER BY s.nm_secretaria ASC
                            LIMIT $limit
                            OFFSET $num_offset";
                    $query = mysql_query($sql); //executa a query com o limite de linhas.

                    $num_rows = mysql_num_rows($query);
                    if($num_rows > 0){
                        // Cabeçalho da pesquisa
                        echo '<div class="headertabela">';
                        //echo '<div class="tabelapesq id">ID</div>';
                        echo '<div class="tabelapesq secretaria">Secretaria</div>';
                        echo '<div class="tabelapesq edita">Edita</div>';
                        echo '</div>';

                        while($row = mysql_fetch_object($query)) {
                            echo '<div class="linhatabela">';
                            //echo '<div id="editar" class="linha id" >'.$row->id_profissao. '</div>';
                            echo '<div class="linha secretaria">'.$row->nm_secretaria. '</div>';
                            echo '<div class="linha edita" ><a href="editaSecretaria.php?edita='.$row->id_secretaria.';#parte-05"><img  src="../../Utilidades/Imagens/bancodeoportunidades/edita.png"></a></div>';
                            // echo '<div class="linha deleta"><a href="deletaUsuario.php?deleta='.$row->id_usuario.'"><img id="deltar" alt="Deletar" src="imagens/deleta.png"></a></div>';
                            echo "</div>";
                        }
                    }else{
                        echo $retorno_zero;
                    }
                    ?>
                <div class="paginacao">
                    <span>
                    <?php

                    if($qtd_pg > 1){

                        $espaco = '&nbsp&nbsp&nbsp';
                        $primeira = 0;
                        $ultima = $qtd_pg - 1;
                        $ant = $pg_atual - 1;
                        $prox = $pg_atual + 1;

                        if($pg_atual > 0) {
                            if($qtd_pg > 3){
                                $url_pri = "$PHP_SELF?buscaSec=$busca&pgSec=$primeira&#parte-05";
                                echo '<a href="'.$url_pri.'">Primeira</a>'.$espaco.'|'.$espaco;
                            }
                            $url = "$PHP_SELF?buscaSec=$busca&pgSec=$ant&#parte-05";
                            echo '<a href="'.$url.'">Anterior</a>'; // Vai para a página anterior
                         }
                         for($i = 0; $i < $qtd_pg; $i++) { // Gera um loop com o link para as páginas
                             $j = $i + 1;

                             if($pg_atual == $i){
                                 echo $espaco.'|'.$espaco.'<font class="page">'.$j.'</font>';
                             }else{
                                $url = "$PHP_SELF?buscaSec=$busca&pgSec=$i#parte-05";
                                echo $espaco.'|'.$espaco.'<a href="'.$url.'">'.$j.'</a>';
                             }
                         }
                         if($qtd_pg - $pg_atual != 1) {
                            $url = "$PHP_SELF?buscaSec=$busca&pgSec=$prox&#parte-05";
                            echo $espaco.'|'.$espaco.'<a href="'.$url.'">Próxima</a>';
                            if($qtd_pg > 3){
                                $url_ult = "$PHP_SELF?pgSec=$ultima&buscaSec=$busca#parte-05";
                                echo $espaco.'|'.$espaco.'<a href="'.$url_ult.'">Última</a>';
                            }
                        }
                    }
                    ?>
                    </span>
                </div>
          </div>
          <?php } ?>


          <?php if(in_array(S_PESQUISA_EMPRESA,$_SESSION[SESSION_ACESSO])){?>

          <div id="parte-06">
              <div class="pesquisa">
                  <form id="form1" action="" method="post">
                      <div class="busca">
                          Pesquisa: <input type="text" name="buscaEmpresa" size="70" maxlength="60" id="buscaEmpresa" class="campo" value="<?php if(isset($_REQUEST['buscaEmpresa'])){ echo $_REQUEST['buscaEmpresa'];}elseif(isset($_REQUEST['buscaEmp'])){ echo $_REQUEST['buscaEmp'];} ?>" />
                                    <input type="submit" name="Enviar" value="OK" style="border: solid 1px black; background: #EE7228; color: white; font-size: 12px; padding: 5px;">
                                    <br/><br/>
                                    <div align="left">
                                        <input type="radio" name="moderacao" value="" checked />Todas as empresas<br/>
                                        <input type="radio" name="moderacao" value="S" <?php if(isset($_REQUEST['moderacao']) && $_REQUEST['moderacao']=='S') echo 'checked'; ?> />Empresas liberadas para acessar os curículos<br/>
                                        <input type="radio" name="moderacao" value="N" <?php if(isset($_REQUEST['moderacao']) && $_REQUEST['moderacao']=='N') echo 'checked'; ?> />Empresas não liberadas para acessar os curículos
                                    </div>
                      </div>

                  </form>
              </div>
              <?php
                     if ($_POST['Enviar'] == 'OK' && !empty($_POST['buscaEmpresa'])) {
                        $busca = $_POST['buscaEmpresa'];
                        $pg_atual = 0;
                    }else if ($_POST['Enviar'] == 'OK' && empty($_POST['buscaEmpresa'])) {
                        $busca = '';
                        $pg_atual = 0;
                    }else{
                        $busca = $_REQUEST['buscaEmpresa'];
                        $pg_atual = $_GET['pgEmp'];
                        if(!isset($pg_atual)) { $pg_atual = 0; }
                    }

                    if ($_POST['Enviar'] == 'OK' && !empty($_POST['moderacao'])) {
                        $moderacao = $_POST['moderacao'];
                    }else if ($_POST['Enviar'] == 'OK' && empty($_POST['moderacao'])) {
                        $moderacao = '';
                    }else{
                        $moderacao = $_REQUEST['moderacao'];
                    }

                    $filtro_moderacao = ($moderacao != '') ? "AND e.ao_liberacao = '".$moderacao."'" : '';

                    $consulta_sql = "SELECT
                                                    e.*, c.nm_cidade
                                            FROM
                                                    empresa e,
                                                    cidade c
                                            WHERE
                                                    e.nm_razaosocial LIKE '%$busca%' AND e.id_cidade = c.id_cidade $filtro_moderacao
                                            ORDER BY e.nm_razaosocial ASC";

                    $sql_all = mysql_query($consulta_sql); //executa a query com o limite de linhas.
                    $limit = 50; //determina qtd de resultados por pagina



                    $all = mysql_num_rows($sql_all); //recebe o total de registros

                    $qtd_pg = ceil($all / $limit); //retorna o total de páginas

                    $num_offset = $pg_atual * $limit; //retorna qual será a primeira linha a ser mostrada

                    $sql = "SELECT
                                    e.*, c.nm_cidade
                            FROM
                                    empresa e,
                                    cidade c
                            WHERE
                                    (e.nm_razaosocial LIKE '%$busca%' OR e.nm_fantasia LIKE '%$busca%') AND e.id_cidade = c.id_cidade $filtro_moderacao
                            ORDER BY e.nm_razaosocial ASC
                            LIMIT $limit
                            OFFSET $num_offset";

                    $query = mysql_query($sql); //executa a query com o limite de linhas.
                    ControleSessao::inserirVariavel('consultaBuscaEmpresas', $consulta_sql);
                    ?>

                    <div class="tab_adiciona">
                       <form name="imprimirAdmissao" method="post" action="printBuscaEmpresa.php">
                    <?php
                    $num_rows = mysql_num_rows($query);
                    if($num_rows > 0){
                         //Cabeçalho da pesquisa
                    ?>
                        <table width="100%" border="0">
                    <?php
                        echo '<tr class="table_formacao_cab">';
                            echo '<td align="center">Empresa</td> ';
                            echo '<td align="center">Cidade</td>';
                            echo '<td align="center">Logradouro</td>';
                            echo '<td align="center">Número</td>';
                            echo '<td align="center">Email / Telefone</td>';
                            echo '<td align="center">Edita</td>';
                        echo '</tr>';

                        while($row = mysql_fetch_object($query)) {
                                echo '<tr class="table_formacao_row">';
                                    echo '<td align="left" style="padding-left: 4px;">'.$row->nm_razaosocial. '</td>';
                                    echo '<td align="center">'.$row->nm_cidade.' </td>';
                                    echo '<td align="left" style="padding-left: 4px;">'.$row->ds_logradouro.'</td>';
                                    echo '<td align="center">'.$row->nr_logradouro.'</td>';
                                    echo '<td align="center"><div>'.$row->ds_email;
                                    echo '</div><div style="margin-top:4px">'.$row->nr_telefoneempresa.'</div></td>';
                                    echo '<td align="center"><a href="editaEmpresa.php?edita='.$row->id_empresa.'#parte-06"><img  src="../../Utilidades/Imagens/bancodeoportunidades/edita.png"></a></td>';
                                echo '</tr>';
                        }

                    }else {
                        echo $retorno_zero;
                   }
                    ?>

                   <tr>
                        <td colspan="8" align="center">
                            <span id="paginacao">
                                <?php

                                if($qtd_pg > 1){

                                    $espaco = '&nbsp&nbsp&nbsp';
                                    $primeira = 0;
                                    $ultima = $qtd_pg - 1;
                                    $ant = $pg_atual - 1;
                                    $prox = $pg_atual + 1;

                                    if($pg_atual > 0) {
                                        if($qtd_pg > 3){
                                            $url_pri = "$PHP_SELF?buscaEmp=$busca&moderacao=$moderacao&pgEmp=$primeira&#parte-06";
                                            echo '<a href="'.$url_pri.'">Primeira</a>'.$espaco.'|'.$espaco;
                                        }
                                        $url = "$PHP_SELF?buscaEmp=$busca&moderacao=$moderacao&pgEmp=$ant&#parte-06";
                                        echo '<a href="'.$url.'">Anterior</a>';
                                     }
                                     for($i = 0; $i < $qtd_pg; $i++) { // Gera um loop com o link para as páginas
                                         $j = $i + 1;

                                         if($pg_atual == $i){
                                             echo $espaco.'|'.$espaco.'<font class="page">'.$j.'</font>';
                                         }else{
                                            $url = "$PHP_SELF?buscaEmp=$busca&moderacao=$moderacao&pgEmp=$i#parte-06";
                                            echo $espaco.'|'.$espaco.'<a href="'.$url.'">'.$j.'</a>';
                                         }
                                     }
                                     if($qtd_pg - $pg_atual != 1) {
                                        $url = "$PHP_SELF?buscaEmp=$busca&moderacao=$moderacao&pgEmp=$prox&#parte-06";
                                        echo $espaco.'|'.$espaco.'<a href="'.$url.'">Próxima</a>';
                                        if($qtd_pg > 3){
                                            $url_ult = "$PHP_SELF?pgEmp=$ultima&moderacao=$moderacao&buscaEmp=$busca#parte-06";
                                            echo $espaco.'|'.$espaco.'<a href="'.$url_ult.'">Última</a>';
                                        }
                                    }
                                }
                                ?>
                        </span>
                    </td>
                </tr>

            </table>
                           <?php if($num_rows > 0) {?><div><input type="submit" class="botao" value="Imprimir" style="height: 25px; width: 102px; float: right; margin:5px 0px" /></div><?php }?>
                    </form>
            </div>
          </div>
          <?php } ?>

          <?php  if(in_array(S_PESQUISA_PROFISSAO , $_SESSION[SESSION_ACESSO])){?>
          <div id="parte-07">
            <div class="pesquisa">
              <form id="form1" action="" method="post">
                <div class="busca">
                  Pesquisa: <input type="text" name="buscaProfissao" size="70" maxlength="60" id="buscaProfissao" class="campo" value="<?php if(isset($_REQUEST['buscaProfissao'])){ echo $_REQUEST['buscaProfissao'];}elseif(isset($_REQUEST['buscaProf'])){ echo $_REQUEST['buscaProf'];} ?>" />
                            <input type="submit" name="Enviar" value="OK" style="border: solid 1px black; background: #EE7228; color: white; font-size: 12px; padding: 5px;">
                            <br/><br/>
                            <input type="radio" name="status" value="" checked />Todas os status&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="status" value="S" <?php if(isset($_REQUEST['status']) && $_REQUEST['status']=='S') echo 'checked'; ?> />Ativo&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="status" value="N" <?php if(isset($_REQUEST['status']) && $_REQUEST['status']=='N') echo 'checked'; ?> />Inativo&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="status" value="V" <?php if(isset($_REQUEST['status']) && $_REQUEST['status']=='V') echo 'checked'; ?> />Em Validação
                </div>
              </form>
            </div>
            <?php
                    if ($_POST['Enviar'] == 'OK' && !empty($_POST['buscaProfissao'])) {
                        $busca = $_POST['buscaProfissao'];
                        $pg_atual = 0;
                    }elseif ($_POST['Enviar'] == 'OK' && empty($_POST['buscaProfissao'])) {
                        $busca = '';
                        $pg_atual = 0;
                    }else{
                        $busca = $_REQUEST['buscaProf'];
                        $pg_atual = $_GET['pgProf'];
                        if(!isset($pg_atual)) { $pg_atual = 0; }
                    }

                    if ($_POST['Enviar'] == 'OK' && !empty($_POST['status'])) {
                        $status = $_POST['status'];
                    }else if ($_POST['Enviar'] == 'OK' && empty($_POST['status'])) {
                        $status = '';
                    }else{
                        $status = $_REQUEST['status'];
                    }

                    $filtro_profissao = ($status != '') ? "AND p.ao_ativo = '".$status."'" : '';

                    $sql_all = mysql_query("SELECT
                                                    *
                                            FROM
                                                    profissao p
                                            WHERE
                                                    p.nm_profissao LIKE '%$busca%' $filtro_profissao
                                            ORDER BY p.nm_profissao ASC"); //executa a query com o limite de linhas.

                    $limit = 50; //determina qtd de resultados por pagina

                    $all = mysql_num_rows($sql_all); //recebe o total de registros

                    $qtd_pg = ceil($all / $limit); //retorna o total de páginas

                    $num_offset = $pg_atual * $limit; //retorna qual será a primeira linha a ser mostrada


                    $sql = "SELECT
                                    *
                            FROM
                                    profissao p
                            WHERE
                                    p.nm_profissao LIKE '%$busca%' $filtro_profissao
                            ORDER BY p.ao_ativo ASC, p.nm_profissao ASC
                            LIMIT $limit
                            OFFSET $num_offset";
                    $query = mysql_query($sql); //executa a query com o limite de linhas.

                    $num_rows = mysql_num_rows($query);
                    if($num_rows > 0){
                        // Cabeçalho da pesquisa
                        echo '<div class="headertabela">';
                        echo '<div class="tabelapesq desc_profissao">Profissão</div>';
                        echo '<div class="tabelapesq status_prof">Status</div>';
                        echo '<div class="tabelapesq edita">Edita</div>';
                        echo '</div>';

                        while($row = mysql_fetch_object($query)) {

                                    if($row->ao_ativo == 'S'){
                                        $statusProf = 'Ativo';}
                                    else if($row->ao_ativo == 'N'){
                                        $statusProf = 'Inativo';
                                    }else{
                                        $statusProf = 'Em Validação';
                                    }
                            echo '<div class="linhatabela">';
                            echo '<div class="linha desc_profissao">'.$row->nm_profissao. '</div>';
                            echo '<div class="linha status_prof">'. $statusProf .'</div>';
                            echo '<div class="linha edita" ><a href="editaProfissao.php?edita='.$row->id_profissao.';#parte-01"><img  src="../../Utilidades/Imagens/bancodeoportunidades/edita.png"></a></div>';
                            echo "</div>";
                        }
                    }else{
                        echo $retorno_zero;
                    }
                    ?>
                <div class="paginacao">
                    <span>
                    <?php

                    if($qtd_pg > 1){

                        $espaco = '&nbsp&nbsp&nbsp';
                        $primeira = 0;
                        $ultima = $qtd_pg - 1;
                        $ant = $pg_atual - 1;
                        $prox = $pg_atual + 1;

                        if($pg_atual > 0) {
                            if($qtd_pg > 3){
                                $url_pri = "$PHP_SELF?buscaProf=$busca&status=$status&pgProf=$primeira&#parte-07";
                                echo '<a href="'.$url_pri.'">Primeira</a>'.$espaco.'|'.$espaco;
                            }
                            $url = "$PHP_SELF?buscaProf=$busca&status=$status&pgProf=$ant&#parte-07";
                            echo '<a href="'.$url.'">Anterior</a>'; // Vai para a página anterior
                         }
                         for($i = 0; $i < $qtd_pg; $i++) { // Gera um loop com o link para as páginas
                             $j = $i + 1;

                             if($pg_atual == $i){
                                 echo $espaco.'|'.$espaco.'<font class="page">'.$j.'</font>';
                             }else{
                                $url = "$PHP_SELF?buscaProf=$busca&status=$status&pgProf=$i#parte-07";
                                echo $espaco.'|'.$espaco.'<a href="'.$url.'">'.$j.'</a>';
                             }
                         }
                         if($qtd_pg - $pg_atual != 1) {
                            $url = "$PHP_SELF?buscaProf=$busca&status=$status&pgProf=$prox&#parte-07";
                            echo $espaco.'|'.$espaco.'<a href="'.$url.'">Próxima</a>';
                            if($qtd_pg > 3){
                                $url_ult = "$PHP_SELF?pgProf=$ultima&status=$status&buscaProf=$busca#parte-07";
                                echo $espaco.'|'.$espaco.'<a href="'.$url_ult.'">Última</a>';
                            }
                        }
                    }
                    ?>
                    </span>
                </div>
          </div>
          <?php } ?>

      </div>
</div>
<?php
}else{
    echo "SEM ACESSO";
}
require_once 'footer.php';
?>
