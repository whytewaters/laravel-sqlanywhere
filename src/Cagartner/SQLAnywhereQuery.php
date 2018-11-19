<?php namespace Cagartner;

/**
 * Classe para trabalhar com a query
 * @author Carlos A Gartner <contato@carlosgartner.com.br>
 */
class SQLAnywhereQuery {
    protected $result;
    protected $num_rows;
    protected $num_fields;
    protected $connection;

    public function __construct($result, $connection) {
        $this->result = $result;
        $this->connection = $connection;
    }

    /**
     * Returns number os rows of the query.
     * @return integer
     */
    public function rowCount() {
        return sasql_num_rows($this->result);
    }

    /**
     * Returns number os rows of the query.
     * @return integer
     */
    public function fieldCount() {
        return sasql_num_fields($this->connection);
    }

    /**
     * Returns number os rows of the query.
     * @return integer
     */
    public function columnCount() {
        return sasql_num_fields($this->connection);
    }

    /**
     * The number of rows affected.
     * @return integer
     */
    public function affectedRows() {
        return sasql_affected_rows($this->connection);
    }

    /**
     * Returns number os rows of the query.
     * This function is for simple of name
     * @return integer
     */
    public function count($type = 'row') {
        if ($type === 'row') {
            return sasql_num_rows($this->result);
        }

        return sasql_num_fields($this->connection);
    }

    /**
     * Return one row of result
     * @param  constant $type Format of return
     * @return array|object
     *
     * TODO: NOTE THAT THERE CONSTANTS SEEM TO BE MADEUP. SQLAnywhereClient::FETCH_ASSOC
     * TODO: LARAVEL USES PDO CONTANTS WHICH ARE NUMBERIC
     * TODO: LARAVEL 5 USES FETCH_CLASS AS THE DEFAULT, LARAVEL 4 USERS FETCH_ASSOC
     */
    public function fetch($type = SQLAnywhereClient::FETCH_ASSOC) {
        $data = null;
        if ($this->result) {
            switch ($type) {
                case 'assoc':
                    $data = sasql_fetch_assoc($this->result);
                    break;

                case 'array':
                    $data = sasql_fetch_array($this->result);
                    break;

                case 'row':
                    $data = sasql_fetch_row($this->result);
                    break;

                case 'field':
                    $data = sasql_fetch_field($this->result);
                    break;

                case \PDO::FETCH_OBJ:
                    $data = sasql_fetch_object($this->result);
                    break;

                default:
                    throw new \Exception("Invalid Fetch Type {$type}");
            }
        }

        return $data;
    }

    /**
     * Return All values of Results in one choose format
     * @param  constant $type Format of return
     * @return array
     *
     * TODO: NOTE THAT THERE CONSTANTS SEEM TO BE MADEUP. SQLAnywhereClient::FETCH_ASSOC
     * TODO: LARAVEL USES PDO CONTANTS WHICH ARE NUMBERIC
     * TODO: LARAVEL 5 USES FETCH_CLASS AS THE DEFAULT, LARAVEL 4 USERS FETCH_ASSOC
     */
    public function fetchAll($type = SQLAnywhereClient::FETCH_ASSOC) {
        $data = [];

        if ($this->result) {
            switch ($type) {
                case 'assoc':
                    while ($row = sasql_fetch_assoc($this->result)) {
                        $data[] = $row;
                    }
                    break;

                case 'array':
                    while ($row = sasql_fetch_array($this->result)) {
                        $data[] = $row;
                    }
                    break;

                case 'row':
                    while ($row = sasql_fetch_row($this->result)) {
                        $data[] = $row;
                    }
                    break;

                case 'field':
                    while ($row = sasql_fetch_field($this->result)) {
                        $data[] = $row;
                    }
                    break;

                case \PDO::FETCH_OBJ:
                    while ($row = sasql_fetch_object($this->result)) {
                        $data[] = $row;
                    }
                    break;

                default:
                    throw new \Exception("Invalid Fetch Type {$type}");
            }
        }

        return $data;
    }

    /**
     * Return value of de Result in Object
     * @return object Results
     */
    public function fetchObject() {
        return sasql_fetch_object($this->result);
    }

    /**
     * Fetches all results of the $result and generates an HTML output table with an optional formatting string.
     * @param  string $table_format Format in HTML of table, EX: "border=1,cellpadding=5"
     * @param  string $header_format Format HTML of header of Table
     * @param  string $row_format Format HTML of row table
     * @param  string $cell_format Format HTML of cell
     * @return boolean               TRUE on success or FALSE on failure.
     */
    public function resultAll($table_format = null, $header_format = null, $row_format = null, $cell_format = null) {
        return sasql_result_all($this->result, $table_format, $header_format, $row_format, $cell_format);
    }

    /**
     * Frees database resources associated with a result resource returned from sasql_query.
     * @return boolean            TRUE on success or FALSE on error.
     */
    public function freeResults() {
        return sasql_free_result($this->result);
    }
}