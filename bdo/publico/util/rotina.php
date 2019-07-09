<?php
if($_SERVER["REMOTE_ADDR"] != "189.38.85.36"){
    die("Acesso nao Autorizado");
}
include_once '../persistencia/CandidatoDAO.class.php';

$cDAO = new CandidatoDAO();
$candidatos = $cDAO->buscarPorValidadeVencida();

if(count($candidatos)>0){
    include_once './Email.class.php';
    
    foreach ($candidatos as $c) {
        
        $paraNome = $c->nm_candidato;
        $paraEmail = $c->ds_email;
        $assunto = 'Banco de Oportunidades - Currículo Desativado';
        $corpo = "<p>$c->nm_candidato
                    <br>
                    Por meio deste informamos que seu currículo está desativado por inatividade.
                    <br>
                    Para ativar seu currículo novamente, basta acessar o sistema.
                    <br>
                    Para maiores dúvidas acesse: 
                    <a href='http://sistemas.canoas.rs.gov.br/bancodeoportunidades/publico/visao/GuiContato.php' target='_blank' style='color: #000; font-weight: bold;'>
                    Fale Conosco
                    </a>
                  </p>";
        
        Email::enviarEmail($paraEmail, $assunto, $corpo, $paraNome);
        $cDAO = new CandidatoDAO();
        $cDAO->incrementarQtLembrete($c->id_candidato);
    }
}
?>
