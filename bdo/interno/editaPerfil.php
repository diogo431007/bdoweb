<?php 
require_once 'header.php'; 

if(in_array(S_ALTERACAO_PERFIL , $_SESSION[SESSION_ACESSO])){
?>
<div id="conteudo">
    <!--<img id="cabecalho-logo" alt="Brasão da Prefeitura" src="imagens/Orange wave.png">-->
    <div class="subtitulo">Banco de Oportunidades</div>
    <div id="principal">
        <ul>
            <li><a href="#parte-03"><span>Alteração de Perfil</span></a></li>
            <li><a href="busca.php#parte-03"><span>Nova Pesquisa</span></a></li>
        </ul>
        <div id="parte-03">
            <?php
            $id = $_GET['edita'];

            if ($id != "") {
                $sql = "SELECT * FROM perfil p WHERE p.id_perfil = $id";
                $query = mysql_query($sql);
                $row = mysql_fetch_object($query);

                $sqlPerfilPagina = "SELECT 
                                            * 
                                    FROM 
                                            perfilpagina pp 
                                    WHERE 
                                            pp.id_perfil = $row->id_perfil";
                
                $queryPerfilPagina = mysql_query($sqlPerfilPagina);
                while ($rowPerfilPagina = mysql_fetch_object($queryPerfilPagina)) {
                    $auxArrayPerfil[] = $rowPerfilPagina->id_pagina;
                }
                
                ?>
                    <form id="editaPerfil" name="editaPerfil" method="post" action="enviaEditaPerfil.php">
                    <div id="user_load"></div>
                    <div id="user_ok"></div>
                    <div id="user_error"></div>
                    <input name="id_perfil" id="id_perfil"  type="hidden"  value="<?php echo $row->id_perfil ?>"/>
                    <fieldset>
                        <legend class="legend">Dados Do Perfil</legend>
                        <table class="tabela" border="0">
                            <tr>
                                <td><span class="style1">*</span></td>
                                <td width="69">Descrição:</td>
                                <td width="546"><input name="descricao" id="descricao" class="campo" type="text"  value="<?php echo $row->ds_perfil ?>" size="40" maxlength="60" /></td>
                            </tr>
                            <tr>
                                <td><span class="style1">*</span></td>
                                <td>Controle:</td>
                                <td>  
                                    <input type="radio" name="controle" value="S" <?php if($row->ao_controle == 'S') echo "checked"?>> Ativo </br>
                                    <input type="radio" name="controle" value="N" <?php if($row->ao_controle == 'N') echo "checked"?>> Inativo
                                </td>
                            </tr>

                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td><span class="style1">* Campos com * são obrigatórios!</span></td>
                            </tr>
                            <tr>
                                <td  colspan="3"><input type="checkbox" name="paginasTodos" id="todos" value="" onclick="marcardesmarcar();"> MARCAR TODOS</td>
                            </tr>
                            <?php
                            $sqlPagina = "SELECT * FROM pagina p WHERE p.ao_ativo = 'S' ORDER BY p.ds_pagina ASC";
                            $queryPagina = mysql_query($sqlPagina);
                            while ($rowPagina = mysql_fetch_object($queryPagina)) {
                                ?> <tr>
                                    <td colspan="3">
                                        <input type="checkbox" class="marcar" id="pag_perfil" name="paginas[]" value="<?php echo $rowPagina->id_pagina ?>" <?php
                                        if ($auxArrayPerfil) {
                                            if (in_array($rowPagina->id_pagina, $auxArrayPerfil)) {
                                                echo "checked";
                                            }
                                        }
                                        ?>
                                               >
                                               <?php echo $rowPagina->ds_pagina; ?>

                                        <?php
                                    }
                                    ?>
                                </td>
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
                <?php
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
