<?php
require_once 'define.php';
require_once 'conecta.php';
header("Content-Type: text/html; charset=ISO-8859-1",true);
// RECEBENDO OS DADOS PREENCHIDOS DO FORMULÁRIO !

$id             = $_POST["id"];
$profissao      = utf8_decode($_POST["profissao"]);
$status         = utf8_decode($_POST["status"]);
$descricao = utf8_decode($_POST ["descricao"]);
$ajuste = utf8_decode($_POST ["ajuste"]);

if (empty($profissao)) {
	echo "Digite a profissão";
}

//if (empty($descricao) && $ajuste == 'N') {
  //   echo "Preencha o campo descrição";
//}

//elseif (strlen($profissao) <= 4) {
//	echo "Profissão inválida";
//}

//Se não houve rnenhum erro

else {
    
    if($ajuste != 'N'){
        $status = 'N';
    }else{
        $dt_moderacao = '';
        if($status == 'S'){
            $dt_moderacao = ', dt_moderacao = now()';
        }
    }
    
    $sql = "UPDATE 
                    profissao 
            SET 
                    id_usuarioalteracao = ".$_SESSION['id_usuario'].", 
                    nm_profissao = '".mb_strtoupper($profissao)."', 
                    dt_alteracao = now(),
                    ao_ativo = '".mb_strtoupper($status)."', 
                    ds_profissao = '".mb_strtoupper($descricao)."'
                    ".$dt_moderacao."
            WHERE 
                    id_profissao = $id";
    
    $query = mysql_query($sql);
	// Se inserido com sucesso
	if ($query) {
            
            if($ajuste != 'N'){
                
                $sql = "select 
                                id_candidatoprofissao 
                        from 
                                candidatoprofissao
                        where 
                                id_profissao = $ajuste
                                and id_candidato in(select 
                                                            id_candidato 
                                                    from 
                                                            candidatoprofissao 
                                                    where 
                                                            id_profissao = $id)";
                //echo $sql;die;
                $sql = mysql_query($sql);
                $qt = mysql_num_rows($sql);
                
                if($qt>0){
                    
                    //deleto o outro
                    $sql = "DELETE FROM candidatoprofissao WHERE id_profissao = $id";
                    //echo $sql;die;
                    $query = mysql_query($sql);
                    
                }else{
                    //update o outro
                    
                    //update candidatoprofissao
                    $sql = "UPDATE 
                                    candidatoprofissao 
                            SET 
                                    id_profissao = $ajuste
                            WHERE 
                                    id_profissao = $id";
                    //echo $sql;die;
                    $query = mysql_query($sql);
                }
                
                

                //update vaga
                $sql = "UPDATE 
                                vaga 
                        SET 
                                id_profissao = $ajuste 
                        WHERE 
                                id_profissao = $id";
                //echo $sql;die;
                $query = mysql_query($sql);

            }            
            echo false;
	}
	// Se houver algum erro ao inserir
	else {
		echo "Não foi possivel alterar a profissão.";
	}

}
?>