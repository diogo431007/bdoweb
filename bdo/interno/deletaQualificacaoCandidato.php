<?php
require_once 'conecta.php';
$idquali = $_GET['deletar']; 
$id = $_GET['candidato']; 
	
             if($id != "" and $idquali != "") {
		   $sqldel = "DELETE FROM candidatoqualificacao WHERE id_qualificacao = ".$idquali;  
                   $querydel = mysql_query($sqldel);
                  if($querydel){
                    echo "<script>alert('Registro Deletado!');window.location = 'editaCandidato.php?edita=".$id."';</script>";
                  }
                  else{
                     echo "<script>alert('Erro ao deletar registro!');window.location = 'editaCandidato.php?edita=".$id."';</script>";
                  }
             }
             else{
               echo "<script>alert('Registro não encontrado!');window.location = 'editaCandidato.php?edita=".$id."';</script>";
             }
?>
