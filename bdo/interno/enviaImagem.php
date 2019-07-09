
<?php
header("Content-Type: text/html; charset=ISO-8859-1",true);
require_once 'define.php';
require_once 'conecta.php';
// RECEBENDO OS DADOS PREENCHIDOS DO FORMULÁRIO !

$lado      = utf8_decode($_POST["lado"]);
$imagem      = $_FILES["imagem"];
?>

<form id="retorno" name="retorno" method="post" action="configuracao.php#parte-01" />
<input type="hidden" id="ok" name="ok" value="ok" />
</form>
<?php
if($_POST['enviar']){
    //-------------NÃO SERÁ PRECISO-------------
    // Largura máxima em pixels
    //$largura = 500;
    // Altura máxima em pixels
    //$altura = 500;
    //------------------------------------------

    // Tamanho máximo do arquivo em bytes
    $tamanho = 3000;

    // Verifica se o arquivo é uma imagem
    if(!preg_match("/^image\/(pjpeg|jpeg|png|bmp)$/", $imagem["type"])){
        $error[1] = "Isso não é uma imagem.";
            }
            // Pega as dimensões da imagem
            $dimensoes = getimagesize($imagem["tmp_name"]);
            
            
            //--------------------NÃO SERÁ PRECISO!------------------------------------------
            // Verifica se a largura da imagem é maior que a largura permitida
            /*if($dimensoes[0] > $largura) {
                $error[2] = "A largura da imagem não deve ultrapassar ".$largura." pixels";
            }

            // Verifica se a altura da imagem é maior que a altura permitida
            if($dimensoes[1] > $altura) {
                $error[3] = "Altura da imagem não deve ultrapassar ".$altura." pixels";
            }*/
            //-------------------------------------------------------------------------------

            // Verifica se o tamanho da imagem é maior que o tamanho permitido
            if($foto["size"] > $tamanho) {
                $error[4] = "A imagem deve ter no máximo ".$tamanho." bytes";
            }

            // Se não houver nenhum erro
            if (count($error) == 0) {
                // Pega extensão da imagem
                preg_match("/\.(bmp|png|jpg|jpeg){1}$/i", $imagem["name"], $ext);

                //-----------------NÃO SERÁ PRECISO-----------------------
                // Gera um nome único para a imagem
                //$nome_imagem = md5(uniqid(time())) . "." . $ext[1];
                //--------------------------------------------------------
                
                if($lado == "SE"){
                    $nome_imagem = "brasao_prefeitura.".$ext[1];
                }else if($lado == "SD"){
                    $nome_imagem = "logo_banco.".$ext[1];
                }else if($lado == "IE"){
                    $nome_imagem = "logo_canoastec.".$ext[1];
                }else if($lado == "ID"){
                    $nome_imagem = "logo_prefeitura.".$ext[1];
                }else if($lado == "IF"){
                    $nome_imagem = "imagem_fundo.".$ext[1];
                }
                                
                // Caminho de onde ficará a imagem
                $caminho_imagem = "../../Utilidades/Imagens/bancodeoportunidades/" . $nome_imagem;
                
                // Selecionando a imagem do sistema a ser excluída
                $sql_img = mysql_query("SELECT imagem FROM imagemsistema WHERE lado = '".$lado."'");
                $usuario = mysql_fetch_object($sql_img);
                
                // Removendo imagem da pasta
                unlink("../../Utilidades/Imagens/bancodeoportunidades/".$usuario->imagem."");
                
                
                // Faz o upload da imagem para seu respectivo caminho
                move_uploaded_file($imagem["tmp_name"], $caminho_imagem);                

                // Insere os dados no banco
                $sql = mysql_query("UPDATE "
                        . "imagemsistema "
                        . "SET "
                        . "id_usuarioalteracao = '".$_SESSION['id_usuario']."', "
                        . "imagem = '".$nome_imagem."', "
                        . "dt_alteracao = now() "
                        . "WHERE "
                        . "lado = '".$lado."'");

                // Se os dados forem inseridos com sucesso
                if ($sql){
                    //Caso não houver nenhum erro chama o form acima retornando página a mensagem de sucesso.                    
                    echo "<script>                                
                             document.getElementById('retorno').submit();
                          </script>";
                    
                    
                }
            }

            // Se houver mensagens de erro, exibe-as
            if (count($error) != 0) { ?>
            <form id="retornoErro" name="retornoErro" method="post" action="configuracao.php#parte-01">
                <input type="hidden" id="erro" name="erro" value="<?php echo implode('|',$error); ?>" />         
            </form>
            <?php
                //Caso ouver algum erro da um submit no form acima retornano o erro a página de imagens
                echo "<script>
                        document.getElementById('retornoErro').submit();
                      </script>";
                foreach ($error as $erro) {
                    echo $erro . "<br />";
                }
            }
}
?>

    