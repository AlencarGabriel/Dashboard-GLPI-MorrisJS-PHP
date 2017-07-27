<?php

/**
 	PÁGINA MESTRE COM PRÉ-CONFIGURAÇÕES DO SITE - GABRIEL 02/2017
*/


/* GLOBAL */
$ano_atual = date('Y'); // retorna o ano atual
$Caminho_Site = '/PainelGLPI/';

/* HEADER*/
$nome_site = "Painel GLPI"; //<title>
$key = ''; // meta tag KEY
$descricao = ''; //meta tag description
$dominio = ''; // nao colocar barra "/" no final
$url_dominio = "http://" . $dominio . "/"; 
$autor = $nome_site;

/* BODY */
$titulo = "Painel GLPI"; // pagina index e outras paginas que precisarem do nome do site
$rodape = "Copyright &copy; {$ano_atual} <b>" . $dominio . "</b>"; // texto do rodape do site

/* Endereços de email */
$smtp = '';
$porta = 587;
$mail_principal = '';
$mail_bug = '';
$mail_dev = '';
$senha_mail_dev = '';
$mail_contact = '';

/* URL */
// constante de array so no PHP >= 7
// const protocolos = array('http://','https://');
$protocolos = array('http://','https://');
//$url = explode('/', $_SERVER['HTTP_HOST']);
$protocolo = $protocolos[0];
$host = $_SERVER['HTTP_HOST']; 
$caminho = (($host == 'localhost') ? $protocolo . $host . $Caminho_Site : $protocolo . $host . $Caminho_Site);


/* 
$_SERVER ['REQUEST_URI'] retorna a url completa "/teste.php?a=1&b=2
echo $_SERVER['PHP_SELF']; retornará apenas "/teste.php"

// auto_loads
	function my_autoload ($pClassName) {
		$dir = 'scripts/php/lib/';
   		//$dir = '';
        include($dir . $pClassName . ".class.php");
    }
    spl_autoload_register("my_autoload");

 	//    $autoloadFuncs = spl_autoload_functions();
	// var_dump($autoloadFuncs);
*/
    ?>