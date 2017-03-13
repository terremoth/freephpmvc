<?php
/**
 * FreePHPMVC Database connection class
 */
class Database
{
	/** DB properties */
	public $host      = 'localhost', // Hostname
	       $dbName    = 'taskero',   // Name
	       $user      = 'root',      // User
	       $password  = '',          // Password
	       $charset   = 'utf8',      // Charset
	       $pdo       = null,        // Connection Type
	       $error     = null,        // Configures Error
	       $debug     = false,       // Show All Errors
	       $lastId    = null;        // Last Inserted id
	
	/**
	 * Class Constructor
	 * @access public
	 * @param string $host     
	 * @param string $dbName
	 * @param string $password
	 * @param string $user
	 * @param string $charset
	 * @param string $debug
	 */
	public function __construct(
		$host     = null,
		$dbName   = null,
		$password = null,
		$user     = null,
		$charset  = null,
		$debug    = null
	) {
	
		// Two way of connect
		$this->host     = defined( 'HOSTNAME'    ) ? HOSTNAME    : $host;
		$this->dbName   = defined( 'DB_NAME'     ) ? DB_NAME     : $dbName;
		$this->password = defined( 'DB_PASSWORD' ) ? DB_PASSWORD : $password;
		$this->user     = defined( 'DB_USER'     ) ? DB_USER     : $user;
		$this->charset  = defined( 'DB_CHARSET'  ) ? DB_CHARSET  : $charset;
		$this->debug    = defined( 'DEBUG'       ) ? DEBUG       : $debug;
	
		// Connects
		$this->connect();
		
	} 
	
	/**
	 * Creates the connection with database
	 * @final
	 * @access protected
	 */
	final protected function connect() {
	
		/* PDO Details */
		$pdo_details  = "mysql:host={$this->host};";
		$pdo_details .= "dbname={$this->dbName};";
		$pdo_details .= "charset={$this->charset};";
		 
		// Try to connect
		try {
			$this->pdo = new PDO($pdo_details, $this->user, $this->password);
			
			// Verify if needs debug
			if ( $this->debug === true ) {
				// Configures PDO ERROR MODE
				$this->pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
			}
            
			// We do not need these properties in memory anymores
			unset( $this->host);
			unset( $this->dbName);
			unset( $this->password);
			unset( $this->user);
			unset( $this->charset);
		
		} catch (PDOException $e) {
			
            // Verify if needs debug again
			if ( $this->debug === true ) {
			
				// Showing error message
				echo "Error: " . $e->getMessage();
			}
			// Kills the script
			die();
		} 
	}
	
    public function get($sTable, $sWhere = false) {
        
        // Prepares to execute
        $sStatement = 'SELECT * FROM `'.$sTable.'` ';
        if($sWhere !== false){
            $sStatement .= 'WHERE '.$sWhere;
        }
        
		$query = $this->pdo->prepare($sStatement);
		$result = $query->execute();
        
        
		// Verifies if the query was right made
		if ($result) {
			// Returns query
			return $query->fetchAll();
            
		} else {
            
			// Instances error
			$error = $query->errorInfo();
			$this->error = $error[2];
			
			// Retorns false because the error(s)
			return false;
		}
    }
    
	/**
	 * Querys the DataBase
	 * @access public
	 * @return object|bool Returns the query in case of true, else returns false
	 */
	public function query($sStatement, $aArrayData = null) {
		
		// Prepares to execute
		$query = $this->pdo->prepare($sStatement);
		$checkExecution = $query->execute($aArrayData);
		
		// Verifies if the query was right made
		if ($checkExecution) {
			// Returns query
			return $query;
            
		} else {
            
			// Instances error
			$error = $query->errorInfo();
			$this->error = $error[2];
			
			// Retorns false because the error(s)
			return false;
		}
	}
	
	/**
	 * Insert values in database
	 * @access public
	 * @param string $table table name
	 * @param array Hidden and unlimited params: keys and values to insert in column => value style
	 * @return object|bool Returns the query itself or false in case of can
	 */
	public function insert($table) {
		// Start cols list
		$aCols = array();
		
		// Configura o valor inicial do modelo
		$sPlaceHolders = '(';
		
		// Start the array values
		$aValues = array();
		
		// O $j will assegura que colunas serão configuradas apenas uma vez
		$j = 1;
		
		// Get all extra function arguments
		$aArgs = func_get_args();
		
		// É preciso enviar pelo menos um array de chaves e valores
		if (!isset($aArgs[1]) || !is_array($aArgs[1])) {
			return false;
		}
		
		// Iterates all function args
		for ( $i = 1; $i < count( $aArgs ); $i++ ) {
		
            // Get the keys as columns and their respective values
			foreach ($aArgs[$i] as $col => $val) {
			
				// The first iteration starts the columns
				if ($i === 1) {
					$aCols[] = "`$col`";
				}
				
				if ($j != $i) {
					// Configures values divisors 
					$sPlaceHolders .= '), (';
				}
				
				// Add placeholder to replace
				$sPlaceHolders .= '?, ';
				
				// Creates the list of columns values
				$aValues[] = $val;
				
				$j = $i;
			}
			
			// Remove extra placeholder's characters
			$sPlaceHolders = substr($sPlaceHolders, 0, strlen( $sPlaceHolders ) - 2);
		}
		
		// Divide columns by commas
		$aCols = implode(', ', $aCols);
		
		// Create statement expression to execute
		$statement = "INSERT INTO `$table` ($aCols) VALUES $sPlaceHolders) ";
		
		// insert values
		$insert = $this->query($statement, $aValues);
		
		// Verifies if insert was succeed
		if ($insert) {
			
			// Verifies if we have last inserted Id
			if (method_exists( $this->pdo, 'lastInsertId' ) 
				&& $this->pdo->lastInsertId() 
			) {
				// instances last Id
				$this->lastId = $this->pdo->lastInsertId();
			}
			
			// Returns insert query response
			return $insert;
		}
	}
	
	/**
	 * Updates field value
	 * @access protected
	 * @param string $sTable Table name
	 * @param string $sWhereField WHERE $sWhereField = $sWhereFieldValue
	 * @param string $sWhereFieldValue WHERE $sWhereField = $sWhereFieldValue
	 * @param array $aValues Array with new values
	 * @return object|bool Returns the query or false
	 */
	public function update( $sTable, $sWhereField, $sWhereFieldValue, $aValues) {
        
		// Need all params
		if (empty($sTable) || empty($sWhereField) || empty($sWhereFieldValue) || !is_array( $aValues )) {
			return false;
		}
		
		// Begin statement
		$sStatement = " UPDATE `$sTable` SET ";
		
		// start array with values
		$aSet = array();
		
		// Start of "Where"
		$sWhere = " WHERE `$sWhereField` = ? ";
		
		// Configures columns to update
		foreach ( $aValues as $column => $value ) {
			$aSet[] = " `$column` = ?";
		}
		
		// Separete columns by commas
		$aSet = implode(', ', $aSet);
		
		// Concats statement
		$sStatement .= $aSet . $sWhere;
		
		// Creates list of values to search
		$aValues[] = $sWhereFieldValue;
		
		// Guarantee only numbers in keys and re-organizes array
		$aValues = array_values($aValues);
				
		// Updates
		$bUpdate = $this->query( $sStatement, $aValues );
		
		// Verifica se a consulta está OK
		if ($bUpdate) {
			// Retorns query
			return $bUpdate;
		}
	}
 
	/**
	 * Delets a row in database
	 * @access protected
	 * @param string $sTable Nome da tabela
	 * @param string $sWhereField WHERE $where_field = $where_field_value
	 * @param string $sWhereFieldValue WHERE $where_field = $where_field_value
	 * @return object|bool Retorna a consulta ou falso
	 */
	public function delete($sTable, $sWhereField, $sWhereFieldValue) {
        
		// Need to send all params
		if (empty($sTable) || empty($sWhereField) || empty($sWhereFieldValue)) {
			return false;
		}
		
		// Begins statement
		$sStatement = " DELETE FROM `$sTable` ";
 
		// Configures as WHERE field = value
		$sWhere = " WHERE `$sWhereField` = '$sWhereFieldValue' ";
		
		// Concats all
		$sStatement .= $sWhere;
		
		// Value to search and delete
//		$aValue = array($sWhereFieldValue);
 
		// Apaga
		$bDelete = $this->query( $sStatement );
		
		// Verifica se a consulta está OK
		if ($bDelete) {
			// Retorna a consulta
			return $bDelete;
		}
		
	}
	
}