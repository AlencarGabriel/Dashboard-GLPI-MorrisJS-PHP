<?php 

class funcoes{
/**
 * nÃO PASSAR CONSULTAS COM ";" NO FINAL DA STRING
 */
public static function ExecutaSQL($query, $pdo){
	$sql = $pdo->prepare($query);
	$sql->execute();

	return $sql;
}

/**
 * @return Retorna a ultima query caso $QUEBRAR_QUERY == true
 */

public static function ExecutePDO($QUERY_SQL, $QUEBRAR_QUERY){
	$pdo = conexao::conecta();
	$pdo->beginTransaction();

	if ($QUEBRAR_QUERY) {			
		$arr = explode(";", $QUERY_SQL);
			// var_dump($arr);
		foreach ($arr as $value) {			
			$last = self::ExecutaSQL($value, $pdo);			
		}

		return $last;

	}else{
		return self::ExecutaSQL($QUERY_SQL, $pdo);
	}

	$pdo->commit();
}
}

?>