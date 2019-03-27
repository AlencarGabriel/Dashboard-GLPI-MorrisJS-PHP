<?php
	date_default_timezone_set('America/Sao_Paulo');
	define('_TESTE_', false); // define se o sistema esta em modo teste ou não

	include "master.php";	
	
	function AutoLoadPainelGLPI ($ClassName) {
		//$dir = 'scripts/php/lib/';
   		$dir = 'lib/';
        include(realpath(__DIR__) . DIRECTORY_SEPARATOR . $dir . "{$ClassName}.class.php");
    }
    spl_autoload_register("AutoLoadPainelGLPI");	
