<?
// -- MySql database related function --
###############################################################################
/*
  connects to mysql database
  INPUTS: host, user, pass, db_name
  OUTPUT: connection handler
*/
function dbConnect($host, $user, $pass, $dbName){
  $link = mysqli_connect($host, $user, $pass, $dbName);
  if(!$link) trigger_error("Unable to connect to database server $host.");
  
  return $link;
}
###############################################################################
/*
  closes the mysql database connection 
  alias of mysql_close()
*/
function dbClose(){
  mysqli_close();
}
###############################################################################
/*
  executes the query and returns the result as an array
  INPUTS:   query
            type - can be 'single'/'singlerow' to return a single row, 'count'/'singlecolumn' for returning the first column, or null 
  OUTPUT: an array containing the rows fetched OR 
      the number of rows affected OR
      mysql_insertid OR
      false on error
*/
function dbQuery($query, $type=''){
	$link	= dbConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query = trim($query);
    $first_letter = strtoupper(substr($query, 0, 1));
	
    $query_result = mysqli_query($link, $query);
    if(!$query_result) trigger_error("Error executing query $query. -- ".mysqli_error($link));
    
    // if a select query
    if($first_letter=="S" || $first_letter=="("){
        $rows = array();
        for($i=0; $i<mysqli_num_rows($query_result); $i++)
            $rows[] = mysqli_fetch_array($query_result);
        mysqli_free_result($query_result);
        
        if($type=='count' || $type=='singlecolumn')
            return $rows[0][0];
		elseif($type=='single' || $type=='singlerow')
			return $rows[0];
        else
			return $rows;  
    }
    // if an insert query
    else if($first_letter=="I"){
    	return mysqli_insert_id($link);
    }
    // if an update query
    else{
        return mysqli_affected_rows();
    }
}

###############################################################################

function _prepareInsertQuery($tableName, $fields, $specialFields=array(), $link) {
	$insertQuery = "INSERT INTO {$tableName}";
	
	$fieldStr = "";
	$valStr = "";
	
	$arrFields = array_keys($fields);
	for ($i=0; $i<count($arrFields); $i++) {
		if ($i!=0) {
			$fieldStr .= ", ";
			$valStr .= ", ";
		}
		$fieldStr .= $arrFields[$i];
		if (in_array($arrFields[$i], $specialFields)) {
			$valStr .= $fields[$arrFields[$i]];
		} else {
			$valStr .= "'" . mysqli_real_escape_string($link, $fields[$arrFields[$i]]) . "'";
		}			
	}
	
	$insertQuery .= " ($fieldStr) values ($valStr)";
	return $insertQuery;
}

//-------------------------------------------------------------------------	
function _prepareUpdateQuery($tableName, $fields, $specialFields, $whereClause, $link) {
	$updateQuery = "UPDATE {$tableName} SET ";
	
	$arrFields = array_keys($fields);
	for ($i=0; $i<count($arrFields); $i++) {
		if ($i!=0) {
			$updateQuery .= ", ";
		}
		if (in_array($arrFields[$i], $specialFields)) {
			$updateQuery .="{$arrFields[$i]} = {$fields[$arrFields[$i]]}";
		} else {
			$updateQuery .="{$arrFields[$i]} = '" . mysqli_real_escape_string($link, $fields[$arrFields[$i]]) . "'";
		}			
	}
	
	$updateQuery .= " WHERE $whereClause";
	return $updateQuery;
}	
###############################################################################
/*
Permoms insert or update
INPUTS: $table - the table name
        $fields_array - an array containing the field, value pairs
        $action can be '' or 'insert' for insert , 'update' for update
		$condition, $debug
OUTPUTS: out put of db_query();
*/
function dbPerform($table, $fieldsArray, $specialFields, $condition=''){
	$link	= dbConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	
	$action = ($condition=="" ? "insert" : "update");

	if($action=="insert")
		$query = _prepareInsertQuery($table, $fieldsArray, $specialFields,$link);
	else
		$query = _prepareUpdateQuery($table, $fieldsArray, $specialFields, $condition,$link);
	return dbQuery($query);
}

function mre($p1) {
	$link	= dbConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	return mysqli_real_escape_string($link,$p1);
}

?>
