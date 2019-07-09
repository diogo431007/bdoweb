<?php 

require_once 'header.php';

if(in_array(S_CONFIGURACAO , $_SESSION[SESSION_ACESSO])){
?>

<div id="conteudo">  
    <div class="subtitulo">Banco de Oportunidades</div>
      <div id="principal">
        <ul>
          <?php  if(in_array(S_CADASTRO_TEXTOS , $_SESSION[SESSION_ACESSO])){?>  
          <li><a href="#parte-00"><span>Página Principal</span></a></li>
          <?php } ?>
          <?php  if(in_array(S_CADASTRO_IMAGENS , $_SESSION[SESSION_ACESSO])){?>
          <li><a href="#parte-01"><span>Imagens</span></a></li>
          <?php } ?>
          <?php  if(in_array(S_CADASTRO_FAQ , $_SESSION[SESSION_ACESSO])){?>
          <li><a href="#parte-02"><span>Perguntas Frequentes</span></a></li>
          <?php } ?>
        </ul>
        <?php if(in_array(S_CADASTRO_TEXTOS , $_SESSION[SESSION_ACESSO])){?>
        <div id="parte-00">
          <?php require_once 'cadastroTextos.php';?>
        </div>
         <?php } ?>
         <?php  if(in_array(S_CADASTRO_IMAGENS , $_SESSION[SESSION_ACESSO])){?>  
        <div id="parte-01">
          <?php require_once 'cadastroImagens.php';?>
        </div>
         <?php } ?>
         <?php  if(in_array(S_CADASTRO_FAQ , $_SESSION[SESSION_ACESSO])){?>  
        <div id="parte-02">
          <?php require_once 'cadastroFaq.php';?>
        </div>
        <?php } ?>
      </div>
</div>
<?php 
}else{
    echo 'SEM ACESSO!';
} 