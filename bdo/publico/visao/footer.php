
</div>

<?php
/*
    $sql_IE = mysql_query("SELECT imagem FROM imagemsistema WHERE lado = 'IE'");
    $sql_ID = mysql_query("SELECT imagem FROM imagemsistema WHERE lado = 'ID'");
    
    $usuario_IE = mysql_fetch_object($sql_IE);
    $usuario_ID = mysql_fetch_object($sql_ID);  
 * */
 
?>


<div id="footer">
    <div id="rodape">
        <!--<span id="assinatura">Banco de Oportunidades &copy; 2014</span>-->
        <img src="../../../Utilidades/Imagens/bancodeoportunidades/logo_prefeitura.png" height="40px">
        <img src="../../../Utilidades/Imagens/bancodeoportunidades/logo_canoastec.png" height="40px" style=" margin-top: 13px; margin-right: 638px;">
        <?php
            // lê todo o conteúdo do arquivo
            // atribui à variável $arquivo
            $arquivo = file_get_contents('../../version.txt');    
            // imprime o conteúdo do arquivo
            // no navegador            
            echo "<div style='border: solid 1px #E4E2CD; margin-top: 60px; width: 950px; margin-left: 10px;'></div>";
            echo "<div class='versao_rodape'>Versão: ".$arquivo."</div>";
        ?>
    </div>    
</div>

</body>
</html>

