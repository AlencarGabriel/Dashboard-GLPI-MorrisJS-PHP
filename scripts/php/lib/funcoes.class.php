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

public static function ExecutePDO($QUERY_SQL, $QUEBRAR_QUERY = false){
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

/**
 * Função para adicionar aspas (") em ma string
 * @param string $str - string à adicionar aspas
 * @return string - sring com aspas
 */
public static function QuotedStr($str){
	return '"' . $str . '"';
}

/**
 * função que verifica se há tickets modificados após ou no momento que o timestamp foi informado
 * @param string $timestamp - timestamp para ser o parâmetro da consulta
 * @param string &$outTimestamp - timestamp da consulta, para ser usado nas próximas
 * @return boolean - true para existe modificação, false para não 
 */

public static function ExisteModificacao($timestamp, &$outTimestamp){
	$consulta = self::ExecutePDO(constants::SQL_EXISTE_MODIFICACAO . self::QuotedStr($timestamp));
	$row = $consulta->fetch();
	
	if ($row["existe_mod"]){
		$outTimestamp = $row["timestamp"];
		return true;
	}else{
		$outTimestamp = null;
		return false;
	}
	
}


/**
 * função que faz a técnica Long Pooling
 * @param string $timestamp - timestamp a ser consultado
 * @param anonymou function $funcao - função que será executada quando existir modificação nos tickets
 * @return string json que será resultada de $funcao 
 */
public static function LongPooling($timestamp, $funcao){
	// faz com que o PHP entenda que nao está em loop infinito, o lopp só pode permanecer por 6 minutos.
	// foi definido este tempo, pois a pagina (HTML) vai atualizar de 5 em 5 min. Então cada loop pode ser processado por até 6min.
	ini_set('max_execution_time', 360); //360 seconds = 6 minutes 

	if (!isset($funcao)) throw new Exception("A FUNÇÃO não foi atribuída em '$funcao'", 1);			

	// Este loop será o responsável por manter a conexão aberta com o servidor
	while (true) {
		if (self::ExisteModificacao($timestamp, $retornoTimestamp)){			
				return $funcao($retornoTimestamp); // chama a função que fará as requisições necessárias para entregar ao JS
			}else{
				sleep(2);
				continue;
			}
		}
	}
}
?>