<?php
function antiInjection($txt){
	$txt = strtolower($txt);
	$txt = str_replace("@","",$txt);
	$txt = str_replace("$","",$txt);
	$txt = str_replace("¨","",$txt);
	$txt = str_replace("&","",$txt);
	$txt = str_replace("=","",$txt);
	$txt = str_replace("¬","",$txt);
	$txt = str_replace("¢","",$txt);
	$txt = str_replace("£","",$txt);
	$txt = str_replace("|","",$txt);
	$txt = str_replace(">","",$txt);
	$txt = str_replace("<","",$txt);
	$txt = str_replace(".","",$txt);
	$txt = str_replace(",","",$txt);
	$txt = str_replace(":","",$txt);
	$txt = str_replace("º","",$txt);
	$txt = str_replace("ª","",$txt);
	$txt = str_replace("§","",$txt);
	$txt = str_replace("´","",$txt);
	$txt = str_replace("`","",$txt);
	$txt = str_replace(";","",$txt);
	$txt = str_replace("-","",$txt);
	$txt = str_replace("+","",$txt);
	$txt = str_replace("?","",$txt);
	$txt = str_replace("!","",$txt);
	$txt = str_replace("~","",$txt);
	$txt = str_replace("^","",$txt);
	$txt = str_replace("#","",$txt);
	$txt = str_replace("*","",$txt);
	$txt = str_replace("%","",$txt);
	//$txt = str_replace("/","",$txt);
	$txt = str_replace("select","",$txt);
	$txt = str_replace("insert","",$txt);
	$txt = str_replace("update","",$txt);
	$txt = str_replace("delete","",$txt);
	$txt = str_replace("drop","",$txt);
	return $txt;
}


function antiInjectionname($txt){
	
	$txt = str_replace("@","",$txt);
	$txt = str_replace("$","",$txt);
	$txt = str_replace("¨","",$txt);
	$txt = str_replace("&","",$txt);
	$txt = str_replace("=","",$txt);
	$txt = str_replace("¬","",$txt);
	$txt = str_replace("¢","",$txt);
	$txt = str_replace("£","",$txt);
	$txt = str_replace("|","",$txt);
	$txt = str_replace(">","",$txt);
	$txt = str_replace("<","",$txt);
	$txt = str_replace(".","",$txt);
	$txt = str_replace(",","",$txt);
	$txt = str_replace(":","",$txt);
	$txt = str_replace("º","",$txt);
	$txt = str_replace("ª","",$txt);
	$txt = str_replace("§","",$txt);
	$txt = str_replace("´","",$txt);
	$txt = str_replace("`","",$txt);
	$txt = str_replace(";","",$txt);
	$txt = str_replace("-","",$txt);
	$txt = str_replace("+","",$txt);
	$txt = str_replace("?","",$txt);
	$txt = str_replace("!","",$txt);
	$txt = str_replace("~","",$txt);
	$txt = str_replace("^","",$txt);
	$txt = str_replace("#","",$txt);
	$txt = str_replace("*","",$txt);
	$txt = str_replace("%","",$txt);
	//$txt = str_replace("/","",$txt);
	$txt = str_replace("select","",$txt);
	$txt = str_replace("insert","",$txt);
	$txt = str_replace("update","",$txt);
	$txt = str_replace("delete","",$txt);
	$txt = str_replace("drop","",$txt);
	return $txt;
}

/**
 * Remove acentos
 *
 * @param string $texto
 * @return string
 */
function remove_acento($texto) {
	$search = array ('´','ç', 'á', 'é', 'í', 'ó', 'ú', 'ã', 'õ', 'â', 'ê', 'î', 'ô', 'û', 'ö', 'ü', 'à', 'è', 'ì', 'ò', 'ù',
			'Ç', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ã', 'Õ', 'Â', 'Ê', 'Î', 'Ô', 'Û', 'Ö', 'Ü', 'À', 'È', 'Ì', 'Ò', 'Ù');

	$replace = array ('','c', 'a', 'e', 'i', 'o', 'u', 'a', 'o', 'a', 'e', 'i', 'o', 'u', 'o', 'u', 'a', 'e', 'i', 'o', 'u',
			'C', 'A', 'E', 'I', 'O', 'U', 'A', 'O', 'A', 'E', 'I', 'O', 'U', 'O', 'U', 'A', 'E', 'I', 'O', 'U');
	$novoTexto = str_replace($search, $replace, $texto);
	return $novoTexto;
}


function remove_numero($texto) {
	$search = array ('0','1','2','3','4','5','6','7','8','9');

	$replace = array ('','','','','','','','','','');
	$novoTexto = str_replace($search, $replace, $texto);
	return $novoTexto;
}



/**
* Converte data mysql para data dd/mm/yyyy
* 
* @param string $data_mysql
* @return string
*/
function mysql_to_data($data_mysql,$hora=false,$segundos=true){
  if($hora){
    if($segundos){
      return date("d/m/Y H:i:s",strtotime($data_mysql));
    }
    else{
      return date("d/m/Y H:i",strtotime($data_mysql));
    }
  }
  else{
    return date("d/m/Y",strtotime($data_mysql));
  }
}

/**
* Converte data dd/mm/yyyy para data mysql
* 
* @param string $data
* @return string
*/
function data_to_mysql($data){
  $dia = substr($data,0,2);
  $mes = substr($data,3,2);
  $ano = substr($data,6);
  return $ano."-".$mes."-".$dia;
}
/**
* --------------------------------------------------------------------------------------------------
* Valida CPF
* 
* @param string $cpf
* @return boolean
*/
function valida_cpf($cpf){

if(!is_numeric($cpf)) return false;
else{
if( ($cpf == '11111111111') || ($cpf == '22222222222') ||
($cpf == '33333333333') || ($cpf == '44444444444') ||
($cpf == '55555555555') || ($cpf == '66666666666') ||
($cpf == '77777777777') || ($cpf == '88888888888') ||
($cpf == '99999999999') || ($cpf == '00000000000') ) {
return false;
}
else{
$dv_informado = substr($cpf, 9,2);
for($i=0; $i<=8; $i++) {
$digito[$i] = substr($cpf, $i,1);
}
$posicao = 10;
$soma = 0;
for($i=0; $i<=8; $i++) {
$soma = $soma + $digito[$i] * $posicao;
$posicao = $posicao - 1;
}
$digito[9] = $soma % 11;
if($digito[9] < 2) $digito[9] = 0;
else $digito[9] = 11 - $digito[9];
$posicao = 11;
$soma = 0;
for ($i=0; $i<=9; $i++) {
$soma = $soma + $digito[$i] * $posicao;
$posicao = $posicao - 1;
}
$digito[10] = $soma % 11;
if ($digito[10] < 2) $digito[10] = 0;
else $digito[10] = 11 - $digito[10];
$dv = $digito[9] * 10 + $digito[10];
if($dv != $dv_informado) return false;
}
}
return true;
}

function deletaFormacao($id){
 
  $sqldelformacao =  "DELETE FROM formacao_candidato WHERE id_candidato = ".$id;
  $querydelformcao = mysql_query($sqldelformacao);
  if($querydelformcao){
     echo'<script>alert("Formação deletada.")</script>';
  }
  else{
     echo'<script>alert("Não foi possivel deletar a formação.")</script>'; 
  }
}

function deletaAreaInteresse($id){
 
  $sqldelarea =  "DELETE FROM area_candidato WHERE id_candidato = ".$id;
  $querydelarea = mysql_query($sqldelarea);
  if($querydelarea){
     echo'<script>alert("Área de interesse deletada.")</script>';
  }
  else{
     echo'<script>alert("Não foi possivel deletar a área deinteresse.")</script>'; 
  }
}

function teste(){
        echo'<script>alert("chegou aqui")</script>';
 
}

function converterDataMysql($data) {
    
    if(empty($data)){
        return null;
    }
    $arrayData = array();
    $arrayData = explode("-", $data);
    $d = array($arrayData[2], $arrayData[1], $arrayData[0]);
    $nData = implode("/", $d);
    return $nData;
    
}

function converterData($data) {
    
    if(empty($data)){
        return 'null';
    }
    $arrayData = array();
    $arrayData = explode("/", $data);
    $d = array($arrayData[2], $arrayData[1], $arrayData[0]);
    $nData = implode("-", $d);
    return $nData;
    
}

function validarEmailNaoObg($email) {
    if(empty($email)){
        return true;
    }
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        return true;
    }else{
        return false;
    }
}

function validarData($data){
    if(empty($data)){
        return false;
    }
    $arrayData = array();
    $arrayData = explode("/", $data);

    $mes = $arrayData[1];
    $dia = $arrayData[0];
    $ano = $arrayData[2];

    if(checkdate($mes, $dia, $ano)){
        return true;
    }else{
        return false;
    }
}

function validarOrigemAcesso($origem){
    $exp = '/^[CE]$/';
    if(preg_match($exp, $origem)){
        return true;
    }else{
        return false;
    }
}

function validarTipoRelatorio($tipo){
    $exp = '/^[AS]$/';
    if(preg_match($exp, $tipo)){
        return true;
    }else{
        return false;
    }
}

function validarNomeProprietario($nm_proprietario){
    $exp = '[a-zA-Z]';
   if(preg_match($exp, $nm_proprietario)){
        return false;
    }
    else{
        return true;
    }
}


function validaEmpresaDetalhe($array){
    
    $i=0;
    foreach($array as $valor){   
        //verifica se o campo da que esta sendo verificado no loop esta vazio
        if(empty($valor)){
            $i++;
        }
    }
    
    if($i>0){
        return false;
    }else{
        return true;
    }
}

function listar($array,$qtd,$page){
        
    $inicio = $page * $qtd;

    $fim = $inicio + $qtd;

    $novoArray = array();

    for($inicio; $inicio<$fim; $inicio++){
        $novoArray[] = $array[$inicio];
    }

    return $novoArray;
}

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 20/01/2014 - 10:05
     * 
     * @param array $array Recebe um array para se listado com paginacao
     * @param int $qtd Recebe a quantidade de elementos do array por pagina
     * @param int $page Recebe a pagina atual
     * @param string $ancora Quando necessario recebe a ancora da pagina atual
     * @return string Retorna uma string com paginacao
     */
    function criarPaginacao($array,$qtd,$page,$ancora=''){
        
        $paginacao = '';
        
        $nrPaginas = ceil(count($array)/$qtd);
        
        if($nrPaginas>1){
            $espaco = '&nbsp&nbsp&nbsp';
            
            $primeira = 0;
            $segunda = 1;
            
            $ultima = $nrPaginas - 1;
            $penultima = $ultima - 1;
            
            $auxUltima = $nrPaginas;
            $auxPenultima = $auxUltima - 1;
            
            $menos = $page - 1;
            $mais = $page + 1;
            $adjacentes = 2;
            
            if($page > 0) {
                
                // primeira pagina
                if($nrPaginas > 2){
                    $url_pri = "$PHP_SELF?pg=$primeira$ancora";
                    $paginacao .= '<a href="'.$url_pri.'">Primeira</a>'.$espaco.'|'.$espaco;
                }

                // pagina anterior
                $url = "$PHP_SELF?pg=$menos$ancora";
                $paginacao .= '<a href="'.$url.'">Anterior</a>';
            }
            
            // 5 paginas ou menos
            if($nrPaginas <= 5){
                for ($i=0; $i<$nrPaginas; $i++){
                    $j = $i + 1;
                    if($i == $page){
                        $paginacao .= $espaco.'|'.$espaco.$j; // pagina atual
                    }else{
                        $url = "$PHP_SELF?pg=$i$ancora";
                        $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url.'">'.$j.'</a>'; // link para outras paginas
                    }
                }
            }
            
            // mais de 5 paginas
            if ($nrPaginas > 5){
                
                // intervalo no fim
                if($page < 1 + (2 * $adjacentes)){
                    
                    for($i=0; $i< 2 + (2 * $adjacentes); $i++){
                        $j = $i + 1;
                        if($i == $page){
                            $paginacao .= $espaco.'|'.$espaco.$j; // pagina atual
                        }else{
                            $url = "$PHP_SELF?pg=$i$ancora";
                            $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url.'">'.$j.'</a>'; // link para outras paginas
                        }
                    }
                    
                    $paginacao .= $espaco.'|'.$espaco.'...'.$espaco;
                    
                    $url_pen = "$PHP_SELF?pg=$penultima$ancora";
                    $paginacao .= '|'.$espaco.'<a href="'.$url_pen.'">'.$auxPenultima.'</a>'.$espaco.'|'.$espaco;
                    
                    $url_ult = "$PHP_SELF?pg=$ultima$ancora";
                    $paginacao .= '<a href="'.$url_ult.'">'.$auxUltima.'</a>';
                
                
                }
                // intervalo no inicio e no fim
                else if($page > (2 * $adjacentes) && $page < $nrPaginas - 3){
                    
                    $url_pri = "$PHP_SELF?pg=$primeira$ancora";
                    $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url_pri.'">1</a>'.$espaco.'|'.$espaco;
                    
                    $url_seg = "$PHP_SELF?pg=$segunda$ancora";
                    $paginacao .= '<a href="'.$url_seg.'">2</a>'.$espaco.'|'.$espaco.'...';
                        
                    for($i = $page-$adjacentes; $i <= $page + $adjacentes; $i++){
                        $j = $i + 1;
                        if($i == $page){
                            $paginacao .= $espaco.'|'.$espaco.$j; // pagina atual
                        }else{
                            $url = "$PHP_SELF?pg=$i$ancora";
                            $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url.'">'.$j.'</a>'; // link para outras paginas
                        }
                    }
                    
                    $paginacao .= $espaco.'|'.$espaco.'...'.$espaco;
                    
                    $url_pen = "$PHP_SELF?pg=$penultima$ancora";
                    $paginacao .= '|'.$espaco.'<a href="'.$url_pen.'">'.$auxPenultima.'</a>'.$espaco.'|'.$espaco;
                    
                    $url_ult = "$PHP_SELF?pg=$ultima$ancora";
                    $paginacao .= '<a href="'.$url_ult.'">'.$auxUltima.'</a>';
                    
                }
                // intervalo no inicio
                else{
                    
                    $url_pri = "$PHP_SELF?pg=$primeira$ancora";
                    $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url_pri.'">1</a>'.$espaco.'|'.$espaco;
                    
                    $url_seg = "$PHP_SELF?pg=$segunda$ancora";
                    $paginacao .= '<a href="'.$url_seg.'">2</a>'.$espaco.'|'.$espaco.'...';
                    
                    for($i = $nrPaginas - (4 + (2 * adjacentes)); $i < $nrPaginas; $i++){
                        $j = $i + 1;
                        if($i == $page){
                            $paginacao .= $espaco.'|'.$espaco.$j; // pagina atual
                        }else{
                            $url = "$PHP_SELF?pg=$i$ancora";
                            $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url.'">'.$j.'</a>'; // link para outras paginas
                        }
                    }
                }
                
            }
            
            if($nrPaginas - $page != 1) {

               // proxima pagina
               $url = "$PHP_SELF?pg=$mais$ancora";
               $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url.'">Próxima</a>';

               // ultima pagina
               if($nrPaginas > 2){
                   $url_ult = "$PHP_SELF?pg=$ultima$ancora";
                   $paginacao .= $espaco.'|'.$espaco.'<a href="'.$url_ult.'">Última</a>';
               }
           }
           
        }
        return $paginacao;  
    }

function verificarCursoSemestre($ds_curso, $ds_semestre){
    if((!empty($ds_curso) && !empty($ds_semestre))){
        return " / ". $ds_curso ." / ". $ds_semestre ."º Sem.";
    }else{
        return null;
    }
}

function validarStatus($status){
    $exp = '/^[SNT]$/';
    if(preg_match($exp, $status)){
        return true;
    }else{
        return false;
    }
}

function validarStatusVaga($tipo){
    $exp = '/^[ECD]$/';
    if(preg_match($exp, $tipo)){
        return true;
    }else{
        return false;
    }
}

/**
* @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
* @version Banco de Oportunidades 2.0
* @since 16/04/2015 - 14:14
* 
* @param String $id_candidato Recebe o id do candidato para validação.
* @return boolean Retorna true se o id do candidato for verdadeiro, caso contrário false.
*/
function validarIdCandidato($id_candidato){    
    $exp = '/^[0-9]{1,10}$/';
    if(preg_match($exp,$id_empresatipo)){
        return true;
    }else{            
        return false;
    }
}


/**
* @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
* @version Banco de Oportunidades 2.0
* @since 16/04/2015 - 14:22
* 
* @param String $tamanho recebe o tamanho da senha.
* @param String $maiusculas recebe o booleano de letra maiúscula .
* @param String $numeros recebe o booleano de números.
* @param String $simbolos recebe o booleano de símbolos.
* @return boolean Retorna true com a nova senha caso os parâmetros estiverem certos.
*/
function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
{
// Caracteres de cada tipo
$lmin = 'abcdefghijklmnopqrstuvwxyz';
$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$num = '1234567890';
$simb = '!@#$%*-';

// Variáveis internas
$retorno = '';
$caracteres = '';

// Agrupamos todos os caracteres que poderão ser utilizados
$caracteres .= $lmin;
if ($maiusculas){$caracteres .= $lmai;}
if ($numeros){$caracteres .= $num;}
if ($simbolos){$caracteres .= $simb;}

// Calculamos o total de caracteres possíveis
$len = strlen($caracteres);

for ($n = 1; $n <= $tamanho; $n++) {
// Criamos um número aleatório de 1 até $len para pegar um dos caracteres
$rand = mt_rand(1, $len);
// Concatenamos um dos caracteres na variável $retorno
$retorno .= $caracteres[$rand-1];
}

return $retorno;
}
/* COMO CHAMAR ESSA FUNÇÃO:
// Gera uma senha com 10 carecteres: letras (min e mai), números
$senha = geraSenha(10);
// gfUgF3e5m7

// Gera uma senha com 9 carecteres: letras (min e mai)
$senha = geraSenha(9, true, false);
// BJnCYupsN

// Gera uma senha com 6 carecteres: letras minúsculas e números
$senha = geraSenha(6, false, true);
// sowz0g

// Gera uma senha com 15 carecteres de números, letras e símbolos
$senha = geraSenha(15, true, true, true);
// fnwX@dGO7P0!iWM
################################################################################
*/


?>