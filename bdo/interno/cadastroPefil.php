<?php  if(in_array(S_CADASTRO_PERFIL , $_SESSION[SESSION_ACESSO])){?>
<form id="cadastroPerfil" name="cadastroPerfil" onsubmit="javascript: return valida()" method="post" action="enviaPerfil.php">
    <div id="perf_load"></div>
    <div id="perf_error"></div>
    <div id="perf_ok"></div>

    <fieldset>
        <legend class="legend">Cadastro de Pefil</legend>
        <table class="tabela">  
            <tr>
                <td><span class="style1">*</span></td>
                <td width="50">Descrição:</td>
                <td width="546"><input id="perfil" name="perfil" class="campo" type="text"  size="40" maxlength="60" /></td>
            </tr>

            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><span class="style1">* Campos com * são obrigatórios!</span></td>
            </tr>
        </table>
        <div class="checkPosicao">     
            <div class ="checkTitulo">
                <input type="checkbox" name="paginasTodos" id="todos" value="" onclick="marcardesmarcar();"> MARCAR TODOS
            </div>

            <?php
            $sql = "SELECT * FROM pagina p WHERE p.ao_ativo = 'S' ORDER BY p.ds_pagina ASC";
            $query = mysql_query($sql);
            while ($row = mysql_fetch_object($query)) {
                ?>


                <div class ="checkCadastro">
                    <input type="checkbox" class="marcar" id="pag_perfil" name="paginas[]" value="<?php echo ($row->id_pagina) ?>"> <?php echo $row->ds_pagina ?>
                </div>
                <?php
            }
            ?>

        </div>
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