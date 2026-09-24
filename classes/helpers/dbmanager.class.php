<?php

class DBManager {

    protected $_bd_nombre = CONF_DB_NAME;
    protected $_bd_servidor = CONF_DB_SERVER;
    protected $_bd_usuario = CONF_DB_USER;
    protected $_bd_clave = CONF_DB_PASS;
    protected $_bd_conexion = null;
    protected $_transaccion_activa = false;
    protected $_dbtype = '';

    // Constructor de la clase
    public function __construct($p_dbtype = '') {
        if ($p_dbtype != '') {
            $this->_dbtype = $p_dbtype;
        } else {
            if (defined('CONF_DB_TYPE')) {
                $this->_dbtype = CONF_DB_TYPE;
            } else {
                $this->_dbtype = 'MYSQL';
            }
        }
    }

    public function set_db_type($p_dbtype) {
        $this->_dbtype = $p_dbtype;
    }

    /**
     * Estbalece la conexion con el servidor.
     */
    public function openConnection() {
        try {
            switch ($this->_dbtype) {
                case 'MYSQL':
                    $this->_bd_conexion = mysql_connect($this->_bd_servidor, $this->_bd_usuario, $this->_bd_clave, true);
                    mysql_select_db($this->_bd_nombre, $this->_bd_conexion);
                    mysqli_query($this->_bd_conexion, "SET NAMES 'utf8'");
                    break;
                case 'POSTGRESQL':
                    $conn_string = "host={$this->_bd_servidor} port=5432 dbname={$this->_bd_nombre} user={$this->_bd_usuario} password={$this->_bd_clave}";
                    $this->_bd_conexion = pg_connect($conn_string);
                    break;
            }
        } catch (Exception $exc) {
            EventLog::writeEntry($exc->getTraceAsString(), 'error');
        }
    }

    /**
     * Cierra las conexiones con la BD.
     */
    public function closeConnection() {
        try {
            switch ($this->_dbtype) {
                case 'MYSQL':
                    mysql_close($this->_bd_conexion);
                    break;
                case 'POSTGRESQL':
                    pg_close($this->_bd_conexion);
                    break;
            }
        } catch (Exception $exc) {
            EventLog::writeEntry($exc->getTraceAsString(), 'error');
        }
    }

    /**
     * Establece los valores para la conexion a la base de datos
     * @param String $p_bd_servidor Nombre del servidor o direccion IP
     * @param String $p_bd_nombre Nombre de la base de datos
     * @param String $p_bd_usuario Usuario de la base daros
     * @param String $p_bd_clave Clave del usuario
     */
    public function setConnectionParams($p_bd_servidor, $p_bd_nombre, $p_bd_usuario, $p_bd_clave) {
        $this->_bd_servidor = $p_bd_servidor;
        $this->_bd_nombre = $p_bd_nombre;
        $this->_bd_usuario = $p_bd_usuario;
        $this->_bd_clave = $p_bd_clave;
    }

    //////////////////////////////////////
    // Metodos para recuperar consultas //
    //////////////////////////////////////

    /**
     * Ejecuta una consulta y devuelve el valor de la primera columna de la primera fila
     * @param  DBQuery $p_query - Consulta SQL
     * @return string
     */
    public function executeScalar(DBQuery $p_query) {

        if ($this->_bd_conexion == null)
            $this->openConnection();

        $returnSTR = "";
        switch ($this->_dbtype) {
            case 'MYSQL':
                if (!$rs = mysqli_query($this->_bd_conexion, $p_query->getQuery())) {
                    EventLog::writeEntry(mysqli_error($this->_bd_conexion) . $p_query->getQuery(), 'error');
                }
                if (mysqli_num_rows($rs)) {
                    $fila = mysqli_fetch_array($rs);
                    $returnSTR .= $fila[0];
                    mysqli_free_result($rs);
                    return $returnSTR;
                }
                break;
            case 'POSTGRESQL':
                $rs = pg_query($this->_bd_conexion, $p_query->getQuery());
                if ($rs === false) {
                    EventLog::writeEntry(pg_last_error($this->_bd_conexion) . ' :: ' . $p_query->getQuery(), 'error');
                } else {
                    if (pg_num_rows($rs)) {
                        $fila = pg_fetch_array($rs);
                        $returnSTR .= $fila[0];
                        pg_free_result($rs);
                        return $returnSTR;
                    }
                }
                break;
        }
        return null;
    }

    /**
     * Ejecuta un consulta del tipo select y devuelve un vector con los resultados obtenidos.
     * @param DBQuery $p_query Consulta a ejecutarse.
     * @return Array con los resultados de la consulta 
     */
    public function executeQuery(DBQuery $p_query) {

        if ($this->_bd_conexion == null)
            $this->openConnection();

        $data_table = array();
        switch ($this->_dbtype) {
            case 'MYSQL':
                if (!$resultado = mysqli_query($this->_bd_conexion, $p_query->getQuery())) {
                    EventLog::writeEntry(mysqli_error($this->_bd_conexion) . $p_query->getQuery(), 'error');
                    die('Ocurrio un error al procesar la consulta');
                }
                if ($resultado) {
                    while ($fila = mysqli_fetch_array($resultado)) {
                        $data_table[] = $fila;
                    }
                }
                mysqli_free_result($resultado);
                break;
            case 'POSTGRESQL':
                $resultado = pg_query($this->_bd_conexion, $p_query->getQuery());

                if ($resultado === false) {
                    EventLog::writeEntry(pg_last_error($this->_bd_conexion) . ' :: ' . $p_query->getQuery(), 'error');
                } elseif ($resultado !== null) {
                    while ($fila = pg_fetch_array($resultado)) {
                        $data_table[] = $fila;
                    }
                }
                pg_free_result($resultado);
                break;
        }
        return $data_table;
    }

    /**
     * Ejecuta un consulta devolviendo el nÃºmero de filas afectadas
     * @param DBQuery $p_query
     * @return Integer cantidad de filas afectadas
     */
    public function executeNonQuery(DBQuery $p_query) {

        if ($this->_bd_conexion == null)
            $this->openConnection();
        switch ($this->_dbtype) {
            case 'MYSQL':
			
                if (!$rs = mysqli_query($this->_bd_conexion, $p_query->getQuery())):
                    EventLog::writeEntry(mysqli_error($this->_bd_conexion) . $p_query->getQuery(), 'error');
                endif;
                if ($rs) {
                    return mysql_affected_rows($this->_bd_conexion);
                }
                break;
            case 'POSTGRESQL':
                $rs = pg_query($this->_bd_conexion, $p_query->getQuery());
                if ($rs === false) {
                    EventLog::writeEntry(pg_last_error($this->_bd_conexion) . $p_query->getQuery(), 'error');
                } else {
                    return pg_affected_rows($rs);
                }
                break;
        }
        return 0;
    }

    public function lastID() {
        switch ($this->_dbtype) {
            case 'MYSQL':
                $query = new DBQuery('SELECT LAST_INSERT_ID()');
                return $this->executeScalar($query);
                break;
            case 'POSTGRESQL':
                $query = new DBQuery('SELECT LASTVAL()');
                return $this->executeScalar($query);
                break;
        }
    }

    public function transactionBegin() {
        if ($this->_bd_conexion == null)
            $this->openConnection();

        switch ($this->_dbtype) {
            case 'MYSQL':
                if ($this->_transaccion_activa == false):
                    mysqli_query($this->_bd_conexion, "SET AUTOCOMMIT=0");
                    mysqli_query($this->_bd_conexion, "START TRANSACTION");
                    $this->_transaccion_activa = true;
                endif;
                break;
            case 'POSTGRESQL':
                if ($this->_transaccion_activa == false):
                    pg_query($this->_bd_conexion, "SET AUTOCOMMIT = OFF");
                    pg_query($this->_bd_conexion, "START TRANSACTION");
                    $this->_transaccion_activa = true;
                endif;
                break;
        }
    }

    public function transactionCommit() {
        if ($this->_bd_conexion == null)
            $this->openConnection();

        switch ($this->_dbtype) {
            case 'MYSQL':
                if ($this->_transaccion_activa):
                    mysqli_query($this->_bd_conexion, "COMMIT");
                endif;
                break;
            case 'POSTGRESQL':
                if ($this->_transaccion_activa):
                    pg_query($this->_bd_conexion, "COMMIT");
                endif;
                break;
        }
    }

    public function transactionRollback() {

        if ($this->_bd_conexion == null)
            $this->openConnection();

        switch ($this->_dbtype) {
            case 'MYSQL':
                if ($this->_transaccion_activa):
                    mysqli_query($this->_bd_conexion, "ROLLBACK");
                endif;
                break;
            case 'POSTGRESQL':
                if ($this->_transaccion_activa):
                    pg_query($this->_bd_conexion, "ROLLBACK");
                endif;
                break;
        }
    }

    public function executeTransaction(Array $p_querys) {

        $commit_changes = true;

        if ($this->_bd_conexion == null)
            $this->openConnection();

        switch ($this->_dbtype) {
            case 'MYSQL':
                mysqli_query($this->_bd_conexion, "SET AUTOCOMMIT=0");
                mysqli_query($this->_bd_conexion, "START TRANSACTION");

                try {

                    foreach ($p_querys as $query):
                        if (!$rs = mysqli_query($this->_bd_conexion, $query->getQuery())):
                            EventLog::writeEntry(mysqli_error($this->_bd_conexion) . $query->getQuery(), 'error');
                            $commit_changes = false;
                            break;
                        endif;
                    endforeach;

                    if ($commit_changes) {
                        mysqli_query($this->_bd_conexion, "COMMIT");
                    } else {
                        mysqli_query($this->_bd_conexion, "ROLLBACK");
                    }
                } catch (Exception $exc) {
                    mysqli_query($this->_bd_conexion, "ROLLBACK");
                }
                break;
            case 'POSTGRESQL':
                // pg_query("SET AUTOCOMMIT=0", $this->_bd_conexion);
                pg_query($this->_bd_conexion, "START TRANSACTION");
                try {

                    foreach ($p_querys as $query):
                        $rs = pg_query($this->_bd_conexion, $query->getQuery());
                        if ($rs === false):
                            EventLog::writeEntry(pg_last_error($this->_bd_conexion) . $query->getQuery(), 'error');
                            $commit_changes = false;
                            break;
                        endif;
                    endforeach;

                    if ($commit_changes) {
                        pg_query($this->_bd_conexion, "COMMIT");
                    } else {
                        pg_query($this->_bd_conexion, "ROLLBACK");
                    }
                } catch (Exception $exc) {
                    pg_query($this->_bd_conexion, "ROLLBACK");
                }
                break;
        }
        return $commit_changes;
    }

    // Formatea un valor de acuerdo a su tipo de dato, para evitar errores y posibles ataques
    public static function formatSQLValue($pValor, $pTipoDatos = "String") {

        $valor_formateado = addslashes($pValor);

        switch (strtolower($pTipoDatos)) {

            case "string":
                $valor_formateado = "'" . $valor_formateado . "'";
                break;

            case "number":
            case "integer":

                $valor_formateado = $valor_formateado;
                break;

            case "date":

                if ($valor_formateado == "") {
                    $valor_formateado = "NULL";
                } else {
                    $arr_fecha = preg_split("/\//", $valor_formateado);
                    if (count($arr_fecha) === 3) {
                        $valor_formateado = "'" . $arr_fecha[2] . "-" . $arr_fecha[1] . "-" . $arr_fecha[0] . "'";
                    } else {
                        $valor_formateado = "NULL";
                    }
                }
                break;

            case "datetime":
            case "timestamp":

                if ($valor_formateado == "") {
                    $valor_formateado = "NULL";
                } else {
                    $arr_fecha_completa = preg_split("/ /", $valor_formateado);
                    if (count($arr_fecha_completa) !== 2) {
                        $valor_formateado = "NULL";
                    } else {
                        $arr_fecha = preg_split("/\//", $arr_fecha_completa[0]);
                        if (count($arr_fecha) === 3) {
                            $valor_formateado = "'" . $arr_fecha[2] . "-" . $arr_fecha[1] . "-" . $arr_fecha[0] . "'";
                            $arr_hora = preg_split("/:/", $arr_fecha_completa[1]);
                            if ((count($arr_hora) >= 1) && (count($arr_hora) <= 3)) {
                                $valor_formateado .= ' ' . $arr_hora[0] . ':' . $arr_hora[1] . ':' . $arr_hora[2];
                            } else {
                                $valor_formateado = 'NULL';
                            }
                        } else {
                            $valor_formateado = "NULL";
                        }
                    }
                }
                break;
        }
        return $valor_formateado;
    }

}

?>