<?php
function anti_injection($anti){
	$anti = addslashes($anti);//Adiciona barras invertidas a uma string
	$anti = preg_replace('/[^\p{L}]|[\p{S}]/i', '', $anti);// remove palavras que contenham sintaxe sql
	$anti = preg_replace('/select/i','',$anti);
	$anti = preg_replace('/insert/i','',$anti);
	$anti = preg_replace('/update/i','',$anti);
	$anti = preg_replace('/delete/i','',$anti);
	$anti = preg_replace('/from/i','',$anti);
	$anti = preg_replace('/drop/i','',$anti);
	$anti = preg_replace('/create/i','',$anti);
	$anti = preg_replace('/where/i','',$anti);
	$anti = preg_replace('/like/i','',$anti);
	$anti = preg_replace('/or/i','',$anti);
	$anti = preg_replace('/and/i','',$anti);
	$anti = preg_replace('/set/i','',$anti);
	$anti = preg_replace('/values/i','',$anti);
	$anti = preg_replace('/alter/i','',$anti);
	$anti = preg_replace('/not/i','',$anti);
	$anti = preg_replace('/by/i','',$anti);
	$anti = preg_replace('/group/i','',$anti);
	$anti = preg_replace('/distinct/i','',$anti);
	$anti = trim($anti);//limpa espaços vazio
	$anti = strip_tags($anti);//tira tags html e php
	$anti = mysql_real_escape_string($anti);
	return $anti;
}

function anti_injection_string($str){
	$str = addslashes($str);//Adiciona barras invertidas a uma string
	$str = preg_replace('/[^\p{L}]|[\p{S}]/i', '', $anti);// remove palavras que contenham sintaxe sql
	$str = strip_tags($str);//tira tags html e php
	$str = mysql_real_escape_string($str);
	return $str;
}

?>
