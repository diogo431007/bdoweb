<?php
require_once 'conecta.php';
$idform = $_GET['deletar']; 
$id = $_GET['candidato']; 
	
             if($id != "" and $idform != "") {
                $sqldel = "DELETE FROM candidatoformacao WHERE id_candidato_formacao = ".$idform;
                              //echo $sqldel;die;
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
