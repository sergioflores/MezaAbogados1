<?php
class DBHelper {
	
	private $conection;
	
	const VARCHAR = "varchar";
	const DATE = "date";
	const FLOAT = "float";
	const INTEGER = "int";
	const DOUBLE = "double";

	
	/**
	 *
	 * @return the $conection
	 */
	public function getConection() {
		return $this->conection;
	}
	
	/**
	 *
	 * @param $conection field_type       	
	 */
	public function setConection($conection) {
		$this->conection = $conection;
	}
	
	function persist($class) {
		
		// Se obtiene la descripciÃ³n de la Clase		mysql_query("SET NAMES 'utf8'");
		$classDescription = get_object_vars ( $class );
		
		// Se obtiene el nombre de la clase
		$className = get_class ( $class );
		
		// Se define el query INSERT
		$query = "INSERT INTO " . $className;
		
		$fields = null;
		$values = null;
		$numberFields = sizeof ( $classDescription );
		$count = 0;
		
		foreach ( $classDescription as $fieldName => $value ) {
			$count ++;
			$fields .= $fieldName;
			if (is_numeric ( $value )) {
				$values .= "'$value'";
			} else {
				$values .= "'$value'";
			}
			
			if ($count != $numberFields) {
				$values .= ",";
				$fields .= ",";
			}
		}
		
		// Armado de querys
		$query .= " (" . strtoupper ( $fields ) . ") VALUES (" . $values . ")";
		
		// Ejecuciï¿½n de query.
		$result = mysql_query ( $query, $this->conection );
		
		if (! $result) {
			die ( 'Invalid query: ' . mysql_error () );
		}
		
		$newInstance = new $className ();
		$reflectionClass = new ReflectionClass ( $newInstance );
		$idName = $reflectionClass->getConstant ( "ID" );
		$reflectionClass->getProperty ( $idName )->setValue ( $newInstance, $this->getLastId() );
		
		return $newInstance;
	}
	
	function read($class, $orderBy = '', $start = 0, $noRecords = 0) {
		mysql_query("SET NAMES 'utf8'");
		// Se obtiene el nombre de la clase
		$className = get_class ( $class );
		
		// Import class to use
		require_once "$className.php";
		require_once "Mapping.php";
		
		// Se obtiene la descripciÃ³n de la Clase
		$classDescription = get_object_vars ( $class );
		
		$numberFields = sizeof ( $classDescription );
		$count = 0;
		$conditions = NULL;
		
		$entity = XMLMapping::getEntity($className);
		
		$query = "SELECT ";
		foreach ( $classDescription as $fieldName => $value ) {
			$count ++;
			$fields .= $fieldName;
			if (isset ( $value ) && !empty($value)) {
				
				$type = XMLMapping::getTypeProperty($entity, $fieldName);
				if($type == self::DOUBLE || $type == self::INTEGER || $type == self::FLOAT) {
					if (isset ( $conditions ))
						$conditions .= " AND ";
					$conditions .= "$fieldName = '$value'";
				} else {
					if (isset ( $conditions ))
						$conditions .= " AND ";
					$conditions .= "$fieldName LIKE '%$value%'";
				}
			}
			
			if ($count != $numberFields) {
				$fields .= ",";
			}
		
		}
		
		$query .= $fields . " FROM " . $className;
		if (isset ( $conditions )) {
			$query .= " WHERE " . $conditions;
		}
		
		if(!empty ($orderBy)){
			$query .= " ORDER BY " . $orderBy;
		}
		
		if($noRecords != 0){
			$query .= " LIMIT " . $start . ", " . $noRecords;
		}
	
		$result = mysql_query ( $query, $this->conection );
		
		if (! $result) {
			die ( 'Invalid query: ' . mysql_error () . " className: " . $className );
		}
		
		while ( $rows = mysql_fetch_array ( $result, MYSQL_ASSOC ) ) {
			
			$newInstance = new $className ();
			$reflectionClass = new ReflectionClass ( $newInstance );
			
			foreach ( $rows as $rowName => $rowValue ) {
				$reflectionClass->getProperty ( $rowName )->setValue ( $newInstance, $rowValue );
			}
			
			$arrayClass [] = $newInstance;
		
		}
		
		return $arrayClass;
	}
	
	function readFirst($class) {
		mysql_query("SET NAMES 'utf8'");
		// Se obtiene el nombre de la clase
		$className = get_class ( $class );
		
		// Import class to use
		require_once "$className.php";
		
		// Se obtiene la descripciÃ³n de la Clase
		$classDescription = get_object_vars ( $class );
		
		$numberFields = sizeof ( $classDescription );
		$count = 0;
		$conditions = NULL;
		$fields = "";
		
		$query = "SELECT ";
		foreach ( $classDescription as $fieldName => $value ) {
			$count ++;
			$fields .= $fieldName;
			if (isset ( $value )) {
				if (is_numeric ( $value )) {
					if (isset ( $conditions ))
						$conditions .= " AND ";
					$conditions .= "$fieldName = $value";
				} else {
					if (isset ( $conditions ))
						$conditions .= " AND ";
					$conditions .= "$fieldName = '$value'";
				}
			}
			
			if ($count != $numberFields) {
				$fields .= ",";
			}
		
		}
		
		$query .= $fields . " FROM " . $className;
		if (isset ( $conditions )) {
			$query .= " WHERE " . $conditions;
		}				$query .= " LIMIT 1";
		
		$result = mysql_query ( $query, $this->conection );
		
		if (! $result) {
			die ( 'Invalid query: ' . mysql_error () . " className: " . $className );
		}
		
		$classResult = new $className ();		$reflectionClass = new ReflectionClass ( $classResult );		while ( $rows = mysql_fetch_array ( $result, MYSQL_ASSOC ) ) {			foreach ( $rows as $rowName => $rowValue ) {					$reflectionClass->getProperty ( $rowName )->setValue ( $classResult, $rowValue );				}		}
		return $classResult;
	}
	
	function update($class, $id) {		
		mysql_query("SET NAMES 'utf8'");
		// Se obtiene el nombre de la clase		
		$className = get_class ( $class );
		// Import class to use		
		require_once "$className.php";
		// Se obtiene la descripciÃ³n de la Clase		
		$classDescription = get_object_vars ( $class );
		$numberFields = sizeof ( $classDescription );		
		$count = 0;		$valuesToUpdate = NULL;
		$query = "UPDATE $className SET ";		
		foreach ( $classDescription as $fieldName => $value ) {
			
			$count ++;
			$fields .= $fieldName;
			if (isset ( $value )) {
				if (is_numeric ( $value )) {
					$valuesToUpdate .= "$fieldName = '$value'";
				} else {
					$valuesToUpdate .= "$fieldName = '$value'";
				}
				if ($count != $numberFields) {
					$valuesToUpdate .= ",";
				}
			}
		
		}
		$reflectionClass = new ReflectionClass ( $className );
		$idName = $reflectionClass->getConstant ( "ID" );
		$conditions = " WHERE $idName = $id";
		
		$query .= $valuesToUpdate . $conditions;
		$result = mysql_query ( $query );
		
		if (! $result) {
			die ( 'Invalid query: ' . mysql_error () . " className: " . $className . "<br>" . $query);
		}
	}
	
	function getAutoincrement($class) {
		
		// Se obtiene el nombre de la clase
		$className = get_class ( $class );
		
		$query = "SELECT AUTO_INCREMENT FROM information_schema.TABLES 
				  WHERE TABLE_NAME = '$className'";
		
		$result = mysql_query ( $query );
		
		if (! $result) {
			die ( 'Invalid query: ' . mysql_error () . " className: " . $className );
		}
		
		$row = mysql_fetch_row ( $result );
		
		return $row [0];
	
	}
	
	function getLastId() {
		
		$lastId = mysql_insert_id ( $this->conection );
		return $lastId;
	}
	
	function starTransaction() {
		mysql_query ( "START TRANSACTION", $this->conection );
	}
	
	function commitTransaction() {
		mysql_query ( "COMMIT", $this->conection );
	}
	
	function queryValor($query){
		
		$result = mysql_query ( $query );
		
		if (! $result) {
			die ( 'Invalid query: ' . mysql_error ());
		}
		
		$row = mysql_fetch_row($result);
		
		return $row;
		
	}
	
	function executeQuery($query){
		mysql_query("SET NAMES 'utf8'");
		$result = mysql_query ( $query );
		
		if (! $result) {
			die ( 'Invalid query: ' . mysql_error ());
		}
		
	return $result;
		
	}
	
	function toObject($result, $class){
		
		// Se obtiene el nombre de la clase
		$className = get_class ( $class );
		
		// Import class to use
		require_once "$className.php";
		
		while ( $rows = mysql_fetch_array ( $result, MYSQL_ASSOC ) ) {
			
			$newInstance = new $className ();
			$reflectionClass = new ReflectionClass ( $newInstance );
			
			foreach ( $rows as $rowName => $rowValue ) {
				$reflectionClass->getProperty ( $rowName )->setValue ( $newInstance, $rowValue );
			}
			
			$arrayClass [] = $newInstance;
		
		}
		
		return $arrayClass;
		
	}
	
	function pagination($class, $recordsPerPage, $page){
	
		if($page <= 0)
			$page = 1;
		
		$start = ($page - 1) * $recordsPerPage;
		
		$arrayOfClass = $this->read($class, "", $start, $recordsPerPage);
		
		return $arrayOfClass;
		
	}

}

?>