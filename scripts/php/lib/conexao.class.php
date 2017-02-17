<?php

date_default_timezone_set('America/Sao_Paulo');

class conexao{

	// Variáveis da conexão
	static private $base_dados  = 'dbname=glpi;';
	static private $usuario_bd  = 'root';
	static private $senha_bd    = 'm3d1c0';
	static private $host_db     = 'mysql:host=192.168.50.32;';
	static private $charset_db  = 'charset=UTF8;';
	public static  $Instancia_Conexao =  null;
	

	public static function conecta(){ 
		if (!isset(self::$instance)) {
			try {
    			// Cria a conexão PDO com a base de dados
				$detalhes_pdo = self::$host_db . self::$base_dados . self::$charset_db;
				self::$Instancia_Conexao = new PDO($detalhes_pdo, self::$usuario_bd, self::$senha_bd);
				//print "Conectado!!";
			} catch (PDOException $e) {
		   	 // Se der algo errado, mostra o erro PDO
				print "Erro: " . $e->getMessage() . "<br/>";   
  		  	// Mata o script
				die();
			}
			self::$Instancia_Conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			self::$Instancia_Conexao->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
		}

		return self::$Instancia_Conexao;
	}
}

/* CONSTANTES PDO 

PDO::PARAM_BOOL (integer)
Represents a boolean data type.
PDO::PARAM_NULL (integer)
Represents the SQL NULL data type.
PDO::PARAM_INT (integer)
Represents the SQL INTEGER data type.
PDO::PARAM_STR (integer)
Represents the SQL CHAR, VARCHAR, or other string data type.
PDO::PARAM_LOB (integer)
Represents the SQL large object data type.
PDO::PARAM_STMT (integer)
Represents a recordset type. Not currently supported by any drivers.
PDO::PARAM_INPUT_OUTPUT (integer)
Specifies that the parameter is an INOUT parameter for a stored procedure. You must bitwise-OR this value with an explicit PDO::PARAM_* data type.
PDO::FETCH_LAZY (integer)
Specifies that the fetch method shall return each row as an object with variable names that correspond to the column names returned in the result set. PDO::FETCH_LAZY creates the object variable names as they are accessed. Not valid inside PDOStatement::fetchAll().
PDO::FETCH_ASSOC (integer)
Specifies that the fetch method shall return each row as an array indexed by column name as returned in the corresponding result set. If the result set contains multiple columns with the same name, PDO::FETCH_ASSOC returns only a single value per column name.
PDO::FETCH_NAMED (integer)
Specifies that the fetch method shall return each row as an array indexed by column name as returned in the corresponding result set. If the result set contains multiple columns with the same name, PDO::FETCH_NAMED returns an array of values per column name.
PDO::FETCH_NUM (integer)
Specifies that the fetch method shall return each row as an array indexed by column number as returned in the corresponding result set, starting at column 0.
PDO::FETCH_BOTH (integer)
Specifies that the fetch method shall return each row as an array indexed by both column name and number as returned in the corresponding result set, starting at column 0.
PDO::FETCH_OBJ (integer)
Specifies that the fetch method shall return each row as an object with property names that correspond to the column names returned in the result set.
PDO::FETCH_BOUND (integer)
Specifies that the fetch method shall return TRUE and assign the values of the columns in the result set to the PHP variables to which they were bound with the PDOStatement::bindParam() or PDOStatement::bindColumn() methods.
PDO::FETCH_COLUMN (integer)
Specifies that the fetch method shall return only a single requested column from the next row in the result set.
PDO::FETCH_CLASS (integer)
Specifies that the fetch method shall return a new instance of the requested class, mapping the columns to named properties in the class.
Note: The magic __set() method is called if the property doesn't exist in the requested class
PDO::FETCH_INTO (integer)
Specifies that the fetch method shall update an existing instance of the requested class, mapping the columns to named properties in the class.
PDO::FETCH_FUNC (integer)
Allows completely customize the way data is treated on the fly (only valid inside PDOStatement::fetchAll()).
PDO::FETCH_GROUP (integer)
Group return by values. Usually combined with PDO::FETCH_COLUMN or PDO::FETCH_KEY_PAIR.
PDO::FETCH_UNIQUE (integer)
Fetch only the unique values.
PDO::FETCH_KEY_PAIR (integer)
Fetch a two-column result into an array where the first column is a key and the second column is the value. Available since PHP 5.2.3.
PDO::FETCH_CLASSTYPE (integer)
Determine the class name from the value of first column.
PDO::FETCH_SERIALIZE (integer)
As PDO::FETCH_INTO but object is provided as a serialized string. Available since PHP 5.1.0. Since PHP 5.3.0 the class constructor is never called if this flag is set.
PDO::FETCH_PROPS_LATE (integer)
Call the constructor before setting properties. Available since PHP 5.2.0.
PDO::ATTR_AUTOCOMMIT (integer)
If this value is FALSE, PDO attempts to disable autocommit so that the connection begins a transaction.
PDO::ATTR_PREFETCH (integer)
Setting the prefetch size allows you to balance speed against memory usage for your application. Not all database/driver combinations support setting of the prefetch size. A larger prefetch size results in increased performance at the cost of higher memory usage.
PDO::ATTR_TIMEOUT (integer)
Sets the timeout value in seconds for communications with the database.
PDO::ATTR_ERRMODE (integer)
See the Errors and error handling section for more information about this attribute.
PDO::ATTR_SERVER_VERSION (integer)
This is a read only attribute; it will return information about the version of the database server to which PDO is connected.
PDO::ATTR_CLIENT_VERSION (integer)
This is a read only attribute; it will return information about the version of the client libraries that the PDO driver is using.
PDO::ATTR_SERVER_INFO (integer)
This is a read only attribute; it will return some meta information about the database server to which PDO is connected.
PDO::ATTR_CONNECTION_STATUS (integer)
PDO::ATTR_CASE (integer)
Force column names to a specific case specified by the PDO::CASE_* constants.
PDO::ATTR_CURSOR_NAME (integer)
Get or set the name to use for a cursor. Most useful when using scrollable cursors and positioned updates.
PDO::ATTR_CURSOR (integer)
Selects the cursor type. PDO currently supports either PDO::CURSOR_FWDONLY and PDO::CURSOR_SCROLL. Stick with PDO::CURSOR_FWDONLY unless you know that you need a scrollable cursor.
PDO::ATTR_DRIVER_NAME (string)
Returns the name of the driver.
Example #1 using PDO::ATTR_DRIVER_NAME

<?php
if ($db->getAttribute(PDO::ATTR_DRIVER_NAME) == 'mysql') {
  echo "Running on mysql; doing something mysql specific here\n";
}
?>
PDO::ATTR_ORACLE_NULLS (integer)
Convert empty strings to SQL NULL values on data fetches.
PDO::ATTR_PERSISTENT (integer)
Request a persistent connection, rather than creating a new connection. See Connections and Connection management for more information on this attribute.
PDO::ATTR_STATEMENT_CLASS (integer)
PDO::ATTR_FETCH_CATALOG_NAMES (integer)
Prepend the containing catalog name to each column name returned in the result set. The catalog name and column name are separated by a decimal (.) character. Support of this attribute is at the driver level; it may not be supported by your driver.
PDO::ATTR_FETCH_TABLE_NAMES (integer)
Prepend the containing table name to each column name returned in the result set. The table name and column name are separated by a decimal (.) character. Support of this attribute is at the driver level; it may not be supported by your driver.
PDO::ATTR_STRINGIFY_FETCHES (integer)
PDO::ATTR_MAX_COLUMN_LEN (integer)
PDO::ATTR_DEFAULT_FETCH_MODE (integer)
Available since PHP 5.2.0
PDO::ATTR_EMULATE_PREPARES (integer)
Available since PHP 5.1.3.
PDO::ERRMODE_SILENT (integer)
Do not raise an error or exception if an error occurs. The developer is expected to explicitly check for errors. This is the default mode. See Errors and error handling for more information about this attribute.
PDO::ERRMODE_WARNING (integer)
Issue a PHP E_WARNING message if an error occurs. See Errors and error handling for more information about this attribute.
PDO::ERRMODE_EXCEPTION (integer)
Throw a PDOException if an error occurs. See Errors and error handling for more information about this attribute.
PDO::CASE_NATURAL (integer)
Leave column names as returned by the database driver.
PDO::CASE_LOWER (integer)
Force column names to lower case.
PDO::CASE_UPPER (integer)
Force column names to upper case.
PDO::NULL_NATURAL (integer)
PDO::NULL_EMPTY_STRING (integer)
PDO::NULL_TO_STRING (integer)
PDO::FETCH_ORI_NEXT (integer)
Fetch the next row in the result set. Valid only for scrollable cursors.
PDO::FETCH_ORI_PRIOR (integer)
Fetch the previous row in the result set. Valid only for scrollable cursors.
PDO::FETCH_ORI_FIRST (integer)
Fetch the first row in the result set. Valid only for scrollable cursors.
PDO::FETCH_ORI_LAST (integer)
Fetch the last row in the result set. Valid only for scrollable cursors.
PDO::FETCH_ORI_ABS (integer)
Fetch the requested row by row number from the result set. Valid only for scrollable cursors.
PDO::FETCH_ORI_REL (integer)
Fetch the requested row by relative position from the current position of the cursor in the result set. Valid only for scrollable cursors.
PDO::CURSOR_FWDONLY (integer)
Create a PDOStatement object with a forward-only cursor. This is the default cursor choice, as it is the fastest and most common data access pattern in PHP.
PDO::CURSOR_SCROLL (integer)
Create a PDOStatement object with a scrollable cursor. Pass the PDO::FETCH_ORI_* constants to control the rows fetched from the result set.
PDO::ERR_NONE (string)
Corresponds to SQLSTATE '00000', meaning that the SQL statement was successfully issued with no errors or warnings. This constant is for your convenience when checking PDO::errorCode() or PDOStatement::errorCode() to determine if an error occurred. You will usually know if this is the case by examining the return code from the method that raised the error condition anyway.
PDO::PARAM_EVT_ALLOC (integer)
Allocation event
PDO::PARAM_EVT_FREE (integer)
Deallocation event
PDO::PARAM_EVT_EXEC_PRE (integer)
Event triggered prior to execution of a prepared statement.
PDO::PARAM_EVT_EXEC_POST (integer)
Event triggered subsequent to execution of a prepared statement.
PDO::PARAM_EVT_FETCH_PRE (integer)
Event triggered prior to fetching a result from a resultset.
PDO::PARAM_EVT_FETCH_POST (integer)
Event triggered subsequent to fetching a result from a resultset.
PDO::PARAM_EVT_NORMALIZE (integer)



*/
?>