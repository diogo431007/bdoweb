<?php
require_once 'conecta.php';
$idexp = $_GET['deletar']; 
$id = $_GET['candidato']; 
	
             if($id != "" and $idexp!= "") {
		   $sqldel = "DELETE FROM candidatoexperiencia WHERE id_experiencia = ".$idexp; 
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
