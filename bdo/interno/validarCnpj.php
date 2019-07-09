<?php
require_once 'conecta.php';
require_once 'define.php';
header("Content-Type: text/html; charset=ISO-8859-1",true);

$nr_cnpj = $_POST['cnpj'];

$sql = "SELECT
            *
        FROM 
            empresa
        WHERE
            nr_cnpj = '$nr_cnpj'";

$query = mysql_query($sql);

$num_linhas = mysql_num_rows($query);

if($num_linhas != 0){
    $row = mysql_fetch_object($query);
    $retorno = "Este CNPJ já está cadastrado como ".$row->nm_fantasia;
}else{
    $retorno = false;
}
echo $retorno;

?>
