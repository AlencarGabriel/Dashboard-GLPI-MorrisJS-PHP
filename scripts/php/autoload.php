<?php
	
	function AutoLoadPainelGLPI ($ClassName) {
		//$dir = 'scripts/php/lib/';
   		$dir = 'lib/';
        include($dir . "{$ClassName}.class.php");
    }
    spl_autoload_register("AutoLoadPainelGLPI");	