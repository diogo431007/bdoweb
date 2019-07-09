<?php 

    require_once 'header.php';
    
    if(in_array(S_CADASTRO , $_SESSION[SESSION_ACESSO])){
        ?>

<div id="conteudo">
 <!--<img id="cabecalho-logo" alt="Brasão da Prefeitura" src="imagens/Orange wave.png">-->
    
    <div class="subtitulo">Banco de Oportunidades</div>
    
      <div id="principal">
        <ul>
          <?php  if(in_array(S_CADASTRO_CANDIDATO , $_SESSION[SESSION_ACESSO])){?>  
          <li><a href="#parte-00"><span>Candidato</span></a></li>
          <?php } ?>

          <?php  if(in_array(S_CADASTRO_USUARIO , $_SESSION[SESSION_ACESSO])){?>
          <li><a href="#parte-02"><span>Usuários</span></a></li>
          <?php } ?>
          
          <?php  if(in_array(S_CADASTRO_PERFIL , $_SESSION[SESSION_ACESSO])){?>
          <li><a href="#parte-03"><span>Perfil</span></a></li>
          <?php } ?>
          
          <?php  if(in_array(S_CADASTRO_DEFICIENCIA , $_SESSION[SESSION_ACESSO])){?>
          <li><a href="#parte-04"><span>Deficiências</span></a></li>
          <?php } ?>
          
          <?php  if(in_array(S_CADASTRO_SECRETARIA , $_SESSION[SESSION_ACESSO])){?>
          <li><a href="#parte-05"><span>Secretarias</span></a></li>
          <?php } ?>
          
          <?php  if(in_array(S_CADASTRO_EMPRESA , $_SESSION[SESSION_ACESSO])){?>
          <li><a href="#parte-06"><span>Empresa</span></a></li>
          <?php } ?>
          
          <?php  if(in_array(S_CADASTRO_PROFISSAO , $_SESSION[SESSION_ACESSO])){?>
          <li><a href="#parte-07"><span>Profissão</span></a></li>
          <?php } ?>
          
        </ul>
        
        <?php if(in_array(S_CADASTRO_CANDIDATO , $_SESSION[SESSION_ACESSO])){?>
        <div id="parte-00">
          <?php require_once 'cadastroCandidato.php';?>
        </div>
        <?php } ?>
          
        <?php  if(in_array(S_CADASTRO_USUARIO , $_SESSION[SESSION_ACESSO])){?>  
        <div id="parte-02">
        
        <?php require_once 'cadastroUsuario.php';?>
        </div>
        <?php } ?>
          
         <?php  if(in_array(S_CADASTRO_PERFIL , $_SESSION[SESSION_ACESSO])){?>  
        <div id="parte-03">
          <?php require_once 'cadastroPefil.php';?>
        </div>
         <?php } ?> 
          
         <?php  if(in_array(S_CADASTRO_DEFICIENCIA , $_SESSION[SESSION_ACESSO])){?>  
        <div id="parte-04">
          <?php require_once 'cadastroDeficiencia.php';?>
        </div>
          <?php } ?>
          
         <?php  if(in_array(S_CADASTRO_SECRETARIA , $_SESSION[SESSION_ACESSO])){?>  
        <div id="parte-05">
          <?php require_once 'cadastroSecretaria.php';?>
        </div>
         <?php } ?>
          
        <?php if(in_array(S_CADASTRO_EMPRESA, $_SESSION[SESSION_ACESSO])) {?>
          <div id="parte-06">
              <?php require_once 'cadastroEmpresa.php';?>
          </div>
        <?php } ?>
          
        <?php if(in_array(S_CADASTRO_PROFISSAO, $_SESSION[SESSION_ACESSO])) {?>
          <div id="parte-07">
              <?php require_once './cadastroProfissao.php';?>
          </div>
        <?php } ?>
          
      </div>
</div>

<?php 
}else{
    echo 'SEM ACESSO!';
} 