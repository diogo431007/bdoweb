<?php
require_once 'conecta.php';
require 'define.php';
header("Content-Type: text/html; charset=ISO-8859-1",true);
$quadrante = $_POST['id_quadrante'];

$sql = "SELECT 
            *
        FROM
            microregiao
        WHERE
            id_quadrante = $quadrante
        ORDER BY nm_microregiao";


$query = mysql_query($sql);
$num_linhas = mysql_num_rows($query);
if($query){
    if($num_linhas !=  0){
        while ($row = mysql_fetch_object($query)) {
            $microregioes.= "<option value='$row->id_microregiao'>".$row->nm_microregiao."</option>";
        }
        $retorno = $microregioes;
    }else{
        $retorno = false;
    }
}else{
    $retorno = false;
}
echo $retorno;
?>