<?php
class Seguranca {

    public static function antiInjection($txt){
        # Remove palavras suspeitas de injection
        $txt = preg_replace(sql_regcase("/(\n|\r|%0a|%0d|Content-Type:|bcc:|to:|cc:|Autoreply:|from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/"), "", $txt);
        $txt = trim($txt);
        $txt = strip_tags($txt);  # Remove tags HTML e PHP
        $txt = addslashes($txt);  # Adiciona barras invertidas a uma string
        $txt = str_replace("'","",$txt);
        $txt = str_replace(";","",$txt);
        $txt = str_replace("#","",$txt);
        $txt = str_replace("*","",$txt);
        $txt = str_replace("%","",$txt);
        $txt = str_replace("/","",$txt);
        $txt = str_replace("<","",$txt);
        $txt = str_replace(">","",$txt);
        $txt = str_replace("script","",$txt);
        $txt = str_replace("type","",$txt);
        $txt = str_replace("js","",$txt);
        $txt = str_replace("!","",$txt);
        $txt = str_replace("?","",$txt);
        return $txt;
    }

    public static function antiInjectionPostGet(){
        if(is_array($_POST)){
            foreach($_POST as $nomePost => $valorPost){
                if(!is_array($valorPost) && $valorPost != ""){
                    Seguranca::limpaPostGet($_POST[$nomePost]);
                    Seguranca::limpaPostGet($_REQUEST[$nomePost]);
                }
            }
        }
        if(is_array($_GET)){
            foreach($_GET as $nomeGet => $valorGet){
                if(!is_array($valorGet) && $valorGet != ""){
                    Seguranca::limpaPostGet($_GET[$nomeGet]);
                    Seguranca::limpaPostGet($_REQUEST[$nomeGet]);
                }
            }
        }
    }

    private static function limpaPostGet(&$txt){
        $txt = trim($txt);
        $txt = str_replace("#","",$txt);
        $txt = str_replace("*","",$txt);
        $txt = str_replace("\\","",$txt);
        $txt = str_replace("SELECT","",$txt);
        $txt = str_replace("INSERT","",$txt);
        $txt = str_replace("UPDATE","",$txt);
        $txt = str_replace("DELETE","",$txt);
        $txt = str_replace("<","",$txt);
        $txt = str_replace(">","",$txt);	
        $txt = str_replace("DROP","",$txt);
        $txt = str_replace("SHOW","",$txt);
        $txt = str_replace("TABLE","",$txt);
        $txt = str_replace("script","",$txt);
        $txt = str_replace("type","",$txt);
        $txt = str_replace(".js","",$txt);
        $txt = str_replace("null","",$txt);
        $txt = str_replace("+","",$txt);
    }   

}
?>