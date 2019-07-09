<?php
class Email{

    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 14/10/2014 - 16:55
     * Ajustes no envio de anexo
     * @param string $paraEmail Recebe o email do destinatario
     * @param string $assunto Recebe o assunto do email
     * @param string $corpo Recebe a mensagem do email
     * @param string $paraNome Recebe o nome do destinatario
     * @param string $arquivo Recebe o anexo do email
     */
    public static function enviarEmail($paraEmail,
					$assunto,
					$corpo,
					$paraNome,
                                        $arquivo){


        $remetenteNome = 'Banco de Oportunidades';
        $remetenteEmail = "seuemail@prefeitura.com";

        //formato o campo da mensagem
        //$mensagem = wordwrap( $mensagem, 50, "<br>", 1);

        //$remetenteEmail = 'bancodeoportunidades@canoastec.rs.gov.br';

        if(PATH_SEPARATOR == ";"){$quebra_linha = "\r\n";
        }else {$quebra_linha = "\n";}



        $msg  = "<html>";
        $msg .= "\n<head>";
        $msg .= "\n<title>Banco de Oportunidades</title>";


        $msg .= "\n<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>";
        $msg .= "\n</head>";

        $msg .= '<body style="background: url(http://sistemas.canoas.rs.gov.br/Utilidades/Imagens/bancodeoportunidades/back_laranja.png); margin: 0;padding: 0;">';

        $msg .= '<div id="box" style="width: 100%; height: 100%; position: relative; font-family: sans-serif; font-size: 13px; background: url(http://sistemas.canoas.rs.gov.br/Utilidades/Imagens/bancodeoportunidades/login_background.png) no-repeat bottom right;">';

        $msg .= '<div id="msg" style="position: relative;width: 80%;margin: 0 auto;">';
        $msg .= '<div style="padding:30;"></div><br><br>';
        $msg .= "\n<h2>Prezado(a) $paraNome</h2>";
        $msg .= $corpo;

        $msg .= "\n<div><p><br>Atenciosamente,<br> ";

        $msg .= '</p><div style="padding:30;"></div></div></div></div>';

        $msg .= "\n</body>";
        $msg .= "\n</html>";


        $mensagem = $msg;


        //Verifica se o anexo existe
        $arquivo = isset($_FILES["arquivo"]) ? $_FILES["arquivo"] : FALSE;

        if(file_exists($arquivo["tmp_name"]) and !empty($arquivo)){

            $fp = fopen($_FILES["arquivo"]["tmp_name"],"rb");
            $anexo = fread($fp,filesize($_FILES["arquivo"]["tmp_name"]));
            $anexo = base64_encode($anexo);

            fclose($fp);
            $anexo = chunk_split($anexo);

            $boundary = "XYZ-" . date("dmYis") . "-ZYX";

            $mens = "--$boundary" . $quebra_linha . "";
            $mens .= "Content-Transfer-Encoding: 8bits" . $quebra_linha . "";
            $mens .= "Content-Type: text/html; charset=\"ISO-8859-1\"" . $quebra_linha . "" . $quebra_linha . ""; //plain
            $mens .= "$mensagem" . $quebra_linha . "";
            $mens .= "--$boundary" . $quebra_linha . "";
            $mens .= "Content-Type: ".$arquivo["type"]."" . $quebra_linha . "";
            $mens .= "Content-Disposition: attachment; filename=\"".$arquivo["name"]."\"" . $quebra_linha . "";
            $mens .= "Content-Transfer-Encoding: base64" . $quebra_linha . "" . $quebra_linha . "";
            $mens .= "$anexo" . $quebra_linha . "";
            $mens .= "--$boundary--" . $quebra_linha . "";


            $headers = "MIME-Version: 1.0" . $quebra_linha . "";
            $headers .= "From: ".$remetenteNome." <".$remetenteEmail.">".$quebra_linha . "";
            $headers .= "Return-Path: $remetenteEmail " . $quebra_linha . "";
            $headers .= "Content-type: multipart/mixed; boundary=\"$boundary\"" . $quebra_linha . "";
            $headers .= "$boundary" . $quebra_linha . "";


            //envio o email com o anexo
            mail($paraEmail,$assunto,$mens,$headers, "-r".$remetenteEmail);

        }
        //se nao tiver anexo
        else{
            $headers = "MIME-Version: 1.0" . $quebra_linha . "";
            $headers .= "Content-type: text/html; charset=iso-8859-1" . $quebra_linha . "";
            $headers .= "From: ".$remetenteNome." <".$remetenteEmail.">".$quebra_linha . "";
            $headers .= "Return-Path: $remetenteEmail " . $quebra_linha . "";

            //envia o email sem anexo
            mail($paraEmail,$assunto,$mensagem, $headers, "-r".$remetenteEmail);

        }

    }
}
?>
