<?php
class Mysqli_Lib {

	private $host;
	private $user;
	private $pass;
	private $db;
	private $con;
	private $table;
	private $query;

/****************************CONSTRUCTOR**************************************/
/* Connect with server and check database */
	function __construct( $host,$user,$pass,$database )
	{
		$this->host	=	$host; // hostname
		$this->user	=	$user; // username
		$this->pass	=	$pass; // password
		$this->db	=	$database; // database
		$this->con	=	new mysqli($this->host, $this->user, $this->pass, $this->db);
		
		if ($this->con->connect_error) 
		{
    	die('Connect Error: ' . $this->con->connect_error);
		}
	}

/****************************CONSTRUCTOR**************************************/

/**************************** SINGLE RESULT**************************************/
	function query_execute( $query )
	{
		$this->query = $this->con->query( $query );
		
		if ($this->query->num_rows > 0 ) 
		{
			return $this->query->fetch_array(MYSQLI_ASSOC);
		} 
		else 
		{
			return $this->con->error;
		}
		$this->query->free();
		$this->con->close();
	}
/**************************** SINGLE RESULT**************************************/

/**************************** FETCH ALL RESULTS **************************************/
	function fetch_all( $query )
	{
		$this->query = $this->con->query( $query );
		if ( $this->query->num_rows > 0 ) 
		{
			while ($row = $this->query->fetch_assoc()) 
			{
				$data[] = $row;
  		}

			return $data;
		} 
		else 
		{
			return $this->con->error;
		}
		$this->query->free();
		$this->con->close();
	}
/**************************** FETCH ALL RESULTS **************************************/

/****************************COUNT SINGLE RESULTS**************************************/
	function count_results ( $query )
	{
		$this->query = $this->con->query( $query );
		
		if ( !empty($this->query) ) 
		{
			$fetch_rows = $this->query->fetch_row();

			if (empty($fetch_rows) ) 
			{
				return 0;
			} 
			else if ( array_key_exists(1,$fetch_rows) ) 
			{
				return $this->query->num_rows;
			} 
			else if ( $fetch_rows[0] > 0 ) 
			{
				return $fetch_rows[0];
			} 
			else if ( $fetch_rows[0] == 0 ) 
			{
				return 0;
			} 
			else 
			{
				return $this->con->error;
			}
		} 
		else 
		{
			return $this->con->error;
		}

		$this->query->free();
		$this->con->close();
	}
/****************************COUNT SINGLE RESULTS**************************************/

/****************************COUNT ALL RESULTS**************************************/
	/*
	$data = array(
		0		=>	'user_log_id',
		1		=>	'user_id'
	);
	$key = array(
		'user_id'	=>	'16'
	);

	*/

	function count_all_results( $table,$data,$key_check=NULL )
	{
		$this->table = $table;
		$implodeData = 'count('.implode('),count(',$data).')';
		if ( !empty($key_check) ) {
			$keys = $this->array_implode_keys( $key_check );
			$this->query = $this->con->query("SELECT ".$implodeData." FROM ".$this->table.' WHERE '.$keys);
		} else {
			$this->query = $this->con->query("SELECT ".$implodeData." FROM ".$this->table);
		}
		$fetch_rows = $this->query->fetch_row();
		if ( !empty($fetch_rows) ) {
			foreach ( $fetch_rows as $key=>$rows ) :
				$response[$key] = array(
					$data[$key]	=>	$rows
				);
			endforeach;
			return $response;
		}  else {
			return $this->con->error;
		}
		$this->query->free();
		$this->con->close();
	}
/****************************COUNT ALL RESULTS**************************************/

/****************************INSERT**************************************/
	function insert( $query )
	{
		$this->query = $this->con->query( $query );
		if ( $this->con->insert_id  ) {
			return $this->con->insert_id;
		} else {
			return $this->con->error;
		}
		$this->query->free();
		$this->con->close();
	}
/****************************INSERT**************************************/

/****************************DELETE**************************************/
	function delete ( $query )
	{
		$this->query = $this->con->query( $query );
		if ( $this->con->affected_rows ) {
			return $this->con->affected_rows;
		} else {
			return $this->con->error;
		}
		$this->query->free();
		$this->con->close();
	}
/****************************DELETE**************************************/

/****************************UPDATE**************************************/
	function update ( $query )
	{
		$this->query = $this->con->query( $query );
		if ( $this->con->affected_rows ) {
			return $this->con->affected_rows;
		} else {
			return $this->con->error;
		}
		$this->query->free();
		$this->con->close();
	}
/****************************UPDATE**************************************/

/****************************INSERT BATCH **************************************/
/* params should be pass like this
	$params = array(
		0 => array(
			'user_name'		=>	'umair',
			'user_pwd'		=>	'123456',
			'user_created'	=>	date('Y-m-d H:i:s')
		),
		1 => array(
			'user_name'		=>	'umair',
			'user_pwd'		=>	'123456',
			'user_created'	=>	date('Y-m-d H:i:s')
		)
	);
*/
	function insert_batch ( $table, $params = NULL )
	{
		$query_rows = array();
		$this->table = $table;

		foreach ( $params as $key=>$rows ) {
			foreach ( $rows as $row ) :
			$query_rows[] = "('" . implode("','", $row) . "')";
			$cols = array_keys($row);
			endforeach;
		}
		$implode_cols = implode(',',$cols);
		$implode_rows = implode(',',$query_rows);
		$sql  = "INSERT INTO ".$this->table."(".$implode_cols.") VALUES ".$implode_rows ;

		$this->query = $this->con->query( $sql);
		if ( $this->con->insert_id ) {
			return $this->con->insert_id;
		} else {
			return $this->con->error;
		}
		$this->query->free();
		$this->con->close();
	}


	function insert_batch2 ( $table, $params = NULL )
	{
		$query_rows = array();
		$this->table = $table;
		//if (!mysql_ping($this->conn))
		//$this->__constructt
		//return new Mysqli_Lib($host,$user,$pass,$database);
		foreach ( $params as $key=>$rows ) {
			foreach ( $rows as $row ) :
			$query_rows[] = "('" . implode("','", $row) . "')";
			$cols = array_keys($row);
			endforeach;
		}
		$implode_cols = implode(',',$cols);
		$implode_rows = implode(',',$query_rows);
 		$sql  = "REPLACE INTO ".$this->table."(".$implode_cols.") VALUES ".$implode_rows ;

		$this->query = $this->con->query( $sql);
		if ( $this->con->insert_id ) {
			return $this->con->insert_id;
		} else {
			return $this->con->error;
		}
		$this->query->free();
		$this->con->close();

	}

/****************************INSERT BATCH **************************************/

/****************************UPDATE BATCH **************************************/
/* Define params and keys
	$params = array(
			'user_name'		=>	'abc',
			'user_pwd'		=>	'123456',
			'user_created'	=>	date('Y-m-d H:i:s')
	);
	$keys = array(
		'user_id'	=>	16
	);
*/
	function update_batch ( $table, $params, $keys )
	{
		$this->table = $table;
		$key = $this->array_implode_keys( $keys );
		$values = $this->array_implode_values( $params );
		$sql  = "UPDATE ".$this->table." SET ".$values." WHERE ".$key ;

		$this->query = $this->con->query($sql);
		$affected_rows =  $this->con->affected_rows;
		if ( $affected_rows > 0 ) {
			return true;
			die();
		} else {
			return $this->con->error;
			die();
		}
		$this->query->free();
		$this->con->close();
	}
/****************************UPDATE BATCH **************************************/

/**************************** Array Map Associative **************************************/
	private function array_implode_values($array,$glue = ', ')
    {
        // separate the associative array into keys and values
        $keys = array_keys($array);
        $values = array_values($array);
        // build a new array with joined keys and values
        $newArray = null;
        for ($i = 0; $i < count($keys); $i++) {
            $newArray[] = $keys[$i].'='.$values[$i];
        }
        // implode and return the new array
        return implode($glue, $newArray);
    }

	private function array_implode_keys($array, $separator = ' AND ')
    {
        // separate the associative array into keys and values
        $keys = array_keys($array);
        $values = array_values($array);
        // build a new array with joined keys and values
        $newArray = null;
        for ($i = 0; $i < count($keys); $i++) {
            $newArray[] = $keys[$i].'='.$values[$i];
        }
        // implode and return the new array
        return implode($separator, $newArray);
    }
/**************************** Array Map Associative **************************************/
}
?>
