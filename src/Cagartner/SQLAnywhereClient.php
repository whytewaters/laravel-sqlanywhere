<?php namespace Cagartner;

use Cagartner\SQLAnywherePrepared as SQLAnywherePrepared;
use Cagartner\SQLAnywhereQuery as SQLAnywhereQuery;
use Exception;

/**
 * @author Carlos A Gartner <contato@carlosgartner.com.br>
 */
class SQLAnywhereClient {
    const VERSION = '1.0';

    private $connection;
    protected $persistent = false;
    protected $autocommit = false;
    protected $dns;
    protected $dbinfo = [];

    // Types os returns
    const FETCH_ARRAY = 'array';
    const FETCH_OBJECT = 'object';
    const FETCH_ROW = 'row';
    const FETCH_FIELD = 'field';
    const FETCH_ASSOC = 'assoc';

    // Bind Param
    const INPUT = 1;
    const OUTPUT = 2;
    const INPUT_OUTPUT = 3;

    // ----------------------------------------------------
    // Query and Statent
    // ----------------------------------------------------
    protected $query;
    protected $sql_string;
    protected $num_rows = 0;

    /**
     * Create connection sybase
     * @param string $dns String connection for sybase
     * @param boolean $persistent Define connection for persistent
     * @throws Exception
     */
    public function __construct($dns, $autocommit = true, $persistent = false) {
        $this->dns = $dns;
        $this->persistent = $persistent;
        $this->autocommit = $autocommit;

        if (!function_exists('sasql_connect')) {
            throw new Exception('SQL Anywhere driver is not installed on this server!', 100);
        }
    }

    /**
     * Retunr Array of items
     * @param  string $sql_string SQL command
     * @return array|boolean
     * @throws Exception
     */
    public function query($sql_string, $return = self::FETCH_ASSOC) {
        $query = $this->exec($sql_string);
        if ($query) {
            return $query->fetch($return);
        }

        return 0;
    }

    /**
     * Exec a query os sql comand
     * @param  string $sql_string SQÇ Command
     * @return SQLAnywhereQuery|boolean
     * @throws Exception
     */
    public function exec($sql_string) {
        $this->sql_string = $sql_string;
        $query = sasql_query($this->getConnection(), $this->sql_string);
        if ($query) {
            return new SQLAnywhereQuery($query, $this->getConnection());
        }

        throw new Exception('SQL String Problem :: ' . sasql_error($this->getConnection()), 110);
    }

    /**
     * Returns the last value inserted into an IDENTITY column or a DEFAULT AUTOINCREMENT column, or zero if the most recent insert was into a table that did not contain an IDENTITY or DEFAULT AUTOINCREMENT column.
     * @return integer Last insert ID.
     */
    public function inserted_id() {
        return sasql_insert_id($this->getConnection());
    }

    /**
     * Alias for PDO Compability
     * Returns the last value inserted into an IDENTITY column or a DEFAULT AUTOINCREMENT column, or zero if the most recent insert was into a table that did not contain an IDENTITY or DEFAULT AUTOINCREMENT column.
     * @return integer Last insert ID.
     */
    public function lastInsertId() {
        return $this->inserted_id();
    }

    /**
     * Create a prepared statement an store it in self::stmnt
     * @param  string $sql_string SQL string
     * @return SQLAnywherePrepared
     */
    public function prepare($sql_string, $array = []) {
        $this->sql_string = $sql_string;

        return new SQLAnywherePrepared($this->sql_string, $this->getConnection(), $this->dbinfo);
    }

    /**
     * Return error code for connection
     * @return int
     */
    public function errorCode() {
        return sasql_errorcode($this->getConnection());
    }

    /**
     * Returns all error info for connection
     * @return string
     */
    public function errorInfo() {
        return sasql_error($this->getConnection());
    }

    /**
     * Commit the transaction
     * @return boolean TRUE if is successful or FALSE otherwise.
     */
    public function commit() {
        return sasql_commit($this->getConnection());
    }

    /**
     * Rollback last commit action
     * @return boolean TRUE if is successful or FALSE otherwise.
     */
    public function rollback() {
        return sasql_rollback($this->getConnection());
    }

    public function __destruct() {
        sasql_commit($this->getConnection());
    }

    public function getConnection() {

        if (!$this->connection) {
            $this->connect();
        }

        return $this->connection;
    }

    private function connect() {
        if ($this->persistent) {
            $this->connection = @sasql_pconnect($this->dns);
        } else {
            $this->connection = @sasql_connect($this->dns);
        }

        if (!$this->connection) {
            throw new Exception('Connection Problem :: ' . sasql_error(), 101);
        }

        // Define option auto_commit
        sasql_set_option($this->connection, 'auto_commit', ($this->autocommit ? 'on' : 0));
        $this->dbinfo = [$this->dns, $this->autocommit, $this->persistent];
    }

    // TODO add support
    public function beginTransaction() {
        return true;
    }

    public function quote($data = '') {
        return sasql_escape_string($this->connection, $data);
    }

}