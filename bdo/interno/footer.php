
</div>

<div id="footer">
    <div id="rodape">
        <!--<span id="assinatura">Banco de Oportunidades &copy; 2014</span>-->
        <img src="../../Utilidades/Imagens/bancodeoportunidades/logo_prefeitura.png" height="40px">
        <img src="../../Utilidades/Imagens/bancodeoportunidades/logo_canoastec.png" height="40px" style=" margin-top: 13px; float:left; margin-right: 638px;">
        <?php
            // lê todo o conteúdo do arquivo
            // atribui à variável $arquivo
            $arquivo = file_get_contents('../version.txt');
            // imprime o conteúdo do arquivo
            // no navegador
            echo "<div style='border: solid 1px #E4E2CD; margin-top: 60px; width: 950px; margin-left: 10px;'></div>";
            echo "<div class='versao_rodape'>Versão: ".$arquivo."</div>";
        ?>
    </div>
</div>

</body>
</html>
