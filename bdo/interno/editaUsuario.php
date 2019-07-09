<?php 
require_once 'header.php';

if(in_array(S_ALTERACAO_USUARIO , $_SESSION[SESSION_ACESSO])){
?>
<div id="conteudo">
    <!--<img id="cabecalho-logo" alt="Brasão da Prefeitura" src="imagens/Orange wave.png">-->
    <div class="subtitulo">Banco de Oportunidades</div>
    <div id="principal">
        <ul>
            <li><a href="#parte-02"><span>Alteração de Usuários</span></a></li>
            <li><a href="busca.php#parte-02"><span>Nova Pesquisa</span></a></li>
        </ul>
        <div id="parte-02">
            <?php
            $id = $_GET['edita'];
            if ($id != "") {
                $sql = "SELECT 
                            * 
                        FROM 
                            usuario u 
                        WHERE 
                            u.id_usuario = ".$id;
                $query = mysql_query($sql);
                while ($row = mysql_fetch_object($query)) {
                    ?>
                    <form id="editaUsuario" name="editaUsuario" method="post" action="javascript:func()">
                        <div id="user_load"></div>
                        <div id="user_ok"></div>
                        <div id="user_error"></div>
                        <input name="id_user" id="id_user"  type="hidden"  value="<?php echo $row->id_usuario ?>"/>
                        <fieldset>
                            <legend class="legend">Dados De Usuário</legend>
                            <table class="tabela">
                                <tr>
                                    <td><span class="style1">*</span></td>
                                    <td width="69">Nome:</td>
                                    <td width="546"><input name="nome_user" id="nome_user" class="campo" type="text"  value="<?php echo $row->nm_usuario ?>" size="40" maxlength="60" /></td>
                                </tr>
                                <tr>
                                    <td><span class="style1">*</span></td>
                                    <td>Email:</td>
                                    <td><input name="email_user" id="email_user" class="campo" type="text" value="<?php echo $row->ds_email ?>" size="40" maxlength="60" /></td>
                                </tr>
                                <tr>
                                    <td><span class="style1">*</span></td>
                                    <td>Perfil:</td>
                                    <td>
                                        <select name="perfil_user" id="perfil_user" class="campo">
                                            <option value="">Selecione...</option>
                                            <?php
                                            // busca o restante para completar a list.
                                            $sql_perfil = "SELECT 
                                                                * 
                                                           FROM 
                                                                perfil p 
                                                           ORDER BY p.ds_perfil ASC ";
                                            $query_perfil = mysql_query($sql_perfil);
                                            while ($row_perfil = mysql_fetch_object($query_perfil)) {
                                                ?>
                                                <option value="<?php echo $row_perfil->id_perfil ?>" <?php if ($row_perfil->id_perfil == $row->id_perfil) echo 'selected'; ?>><?php echo $row_perfil->ds_perfil ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select> 
                                    </td>
                                </tr> 
                                <tr>
                                    <td><span class="style1">*</span></td>
                                    <td>Secretaria:</td>
                                    <td>
                                        <select name="secretaria_user" id="secretaria_user" class="campo">
                                            <option value="">Selecione...</option>
                                            <?php
                                            // busca o restante para completar a list.
                                            $sql_secretaria = "SELECT 
                                                                    * 
                                                               FROM 
                                                                    secretaria s 
                                                               ORDER BY s.nm_secretaria ASC ";
                                            $query_secretaria = mysql_query($sql_secretaria);
                                            while ($row_secretaria = mysql_fetch_object($query_secretaria)) {
                                                ?>
                                                <option value="<?php echo $row_secretaria->id_secretaria ?>" <?php if ($row_secretaria->id_secretaria == $row->id_secretaria) echo 'selected'; ?>><?php echo $row_secretaria->nm_secretaria ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select> 
                                    </td>
                                </tr> 
                                <tr>
                                    <td><span class="style1">*</span></td>
                                    <td>Controle:</td>
                                    <td>
                                        <input type="radio" name="controle_user" id="controle_user" value="S" <?php if ($row->ao_controle == 'S') echo "checked";?>> Ativo </br>
                                        <input type="radio" name="controle_user" id="controle_user" value="N" <?php if ($row->ao_controle == 'N') echo "checked";?>> Inativo
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
                    <?php
                }
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
