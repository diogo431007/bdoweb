<?php
require_once 'conecta.php';
require 'define.php';
header("Content-Type: text/html; charset=ISO-8859-1",true);
$uf = $_POST['id_estado'];

$sql = "SELECT 
            *
        FROM
            cidade
        WHERE
            id_estado = $uf
        ORDER BY nm_cidade";


$query = mysql_query($sql);
$num_linhas = mysql_num_rows($query);
if($query){
    if($num_linhas !=  0){
        while ($row = mysql_fetch_object($query)) {
            $cidades.= "<option value='$row->id_cidade'>".$row->nm_cidade."</option>";
        }
        $retorno = $cidades;
    }else{
        $retorno = false;
    }
}else{
    $retorno = false;
}
echo $retorno;
?>