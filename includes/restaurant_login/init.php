<?php
require('includes/configure.php');
class base {
  /**
   * method used to an attach an observer to the notifier object
   *
   * NB. We have to get a little sneaky here to stop session based classes adding events ad infinitum
   * To do this we first concatenate the class name with the event id, as a class is only ever going to attach to an
   * event id once, this provides a unique key. To ensure there are no naming problems with the array key, we md5 the
   * unique name to provide a unique hashed key.
   *
   * @param object Reference to the observer class
   * @param array An array of eventId's to observe
   */
  function attach(&$observer, $eventIDArray) {
    foreach($eventIDArray as $eventID) {
      $nameHash = md5(get_class($observer).$eventID);
      base::setStaticObserver($nameHash, array('obs'=>&$observer, 'eventID'=>$eventID));
    }
  }
  /**
   * method used to detach an observer from the notifier object
   * @param object
   * @param array
   */
  function detach($observer, $eventIDArray) {
    foreach($eventIDArray as $eventID) {
      $nameHash = md5(get_class($observer).$eventID);
      base::unsetStaticObserver($nameHash);
    }
  }
  /**
   * method to notify observers that an event has occurred in the notifier object
   * Can optionally pass parameters and variables to the observer, useful for passing stuff which is outside of the 'scope' of the observed class.
   * Any of params 2-9 can be passed by reference, and will be updated in the calling location if the observer "update" function also receives them by reference
   *
   * @param string The event ID to notify.
   * @param mixed passed as value only.
   * @param mixed Passed by reference.
   * @param mixed Passed by reference.
   * @param mixed Passed by reference.
   * @param mixed Passed by reference.
   * @param mixed Passed by reference.
   * @param mixed Passed by reference.
   * @param mixed Passed by reference.
   * @param mixed Passed by reference.
   *
   * NOTE: The $param1 is not received-by-reference, but params 2-9 are.
   * NOTE: The $param1 value CAN be an array, and is sometimes typecast to be an array, but can also safely be a string or int etc if the notifier sends such and the observer class expects same.
   */
  function notify($eventID, $param1 = array(), & $param2 = NULL, & $param3 = NULL, & $param4 = NULL, & $param5 = NULL, & $param6 = NULL, & $param7 = NULL, & $param8 = NULL, & $param9 = NULL ) {
    // notifier trace logging - for advanced debugging purposes only --- NOTE: This log file can get VERY big VERY quickly!
    if (defined('NOTIFIER_TRACE') && NOTIFIER_TRACE != '' && NOTIFIER_TRACE != 'false' && NOTIFIER_TRACE != 'Off') {
      $file = DIR_FS_LOGS . '/notifier_trace.log';
      $paramArray = (is_array($param1) && sizeof($param1) == 0) ? array() : array('param1' => $param1);
      for ($i = 2; $i < 10; $i++) {
        $param_n = "param$i";
        if ($$param_n !== NULL) {
          $paramArray[$param_n] = $$param_n;
        }
      }
      global $this_is_home_page, $PHP_SELF;
      $main_page = (isset($this_is_home_page) && $this_is_home_page) ? 'index-home' : (IS_ADMIN_FLAG) ? basename($PHP_SELF) : (isset($_GET['main_page'])) ? $_GET['main_page'] : '';
      $output = '';
      if (count($paramArray)) {
        $output = ', ';
        if (NOTIFIER_TRACE == 'var_export' || NOTIFIER_TRACE == 'var_dump' || NOTIFIER_TRACE == 'true') {
          $output .= var_export($paramArray, true);
        } elseif (NOTIFIER_TRACE == 'print_r' || NOTIFIER_TRACE == 'On' || NOTIFIER_TRACE === TRUE) {
          $output .= print_r($paramArray, true);
        }
      }
      error_log( strftime("%Y-%m-%d %H:%M:%S") . ' [main_page=' . $main_page . '] ' . $eventID . $output . "\n", 3, $file);
    }

    // handle observers
    // observers can fire either a generic update() method, or a notifier-point-specific updateNotifierPointCamelCased() method. The specific one will fire if found; else the generic update() will fire instead.
    $observers = & base::getStaticObserver();
    if (is_null($observers)) {
      return;
    } else
    {
      foreach($observers as $key=>$obs) {
        if ($obs['eventID'] == $eventID || $obs['eventID'] === '*') {
         $method = 'update';
         $testMethod = $method . self::camelize(strtolower($eventID), TRUE);
         if (method_exists($obs['obs'], $testMethod))
           $method = $testMethod;
         $obs['obs']->{$method}($this, $eventID, $param1,$param2,$param3,$param4,$param5,$param6,$param7,$param8,$param9);
        }
      }
    }
  }
  function & getStaticProperty($var)
  {
    static $staticProperty;
    return $staticProperty;
  }
  function & getStaticObserver() {
    return base::getStaticProperty('observer');
  }
  function setStaticObserver($element, $value)
  {
    $observer =  & base::getStaticObserver();
    if (!is_array($observer)) {
      $observer = array ();
    }
    $observer[$element] = $value;
  }
  function unsetStaticObserver($element)
  {
    $observer =  & base::getStaticObserver();
    unset($observer[$element]);
  }
  public static function camelize($rawName, $camelFirst = FALSE)
  {
    if ($rawName == "")
      return $rawName;
    if ($camelFirst)
    {
      $rawName[0] = strtoupper($rawName[0]);
    }
    return preg_replace_callback('/[_-]([0-9,a-z])/', create_function('$matches', 'return strtoupper($matches[1]);'), $rawName);
  }
}


















class queryFactory extends base {
  var $link, $count_queries, $total_query_time;

  function __construct() {
    $this->count_queries = 0;
    $this->total_query_time = 0;
  }

  function query($link, $query, $remove_from_queryCache = false) {
      global $queryLog;
      global $queryCache;

      if ($remove_from_queryCache && isset($queryCache)) {
        $queryCache->reset($query);
      }

      if( isset($queryCache) && $queryCache->inCache($query) ) {
            $cached_value = $queryCache->getFromCache($query);
            $this->count_queries--;
            return($cached_value);
      }

      if(isset($queryLog)) $queryLog->start($query);
      $result = mysqli_query($link, $query);
      if(isset($queryLog)) $queryLog->stop($query, $result);
      if(isset($queryCache)) $queryCache->cache($query, $result);
      return($result);
  }

  function connect($zf_host, $zf_user, $zf_password, $zf_database, $zf_pconnect = 'false', $zp_real = false) {
    $this->database = $zf_database;
    $this->user = $zf_user;
    $this->host = $zf_host;
    $this->password = $zf_password;
    $this->pConnect = $zf_pconnect;
    $this->dieOnErrors = false;
    if (defined('DB_CHARSET')) $dbCharset = DB_CHARSET;
    if (isset($options['dbCharset'])) $dbCharset = $options['dbCharset'];
    if (!function_exists('mysqli_connect')) die ('Call to undefined function: mysqli_connect().  Please install the MySQL Connector for PHP');
    $connectionRetry = 10;
    while (!isset($this->link) || ($this->link == FALSE && $connectionRetry !=0) )
    {
      $this->link = mysqli_connect($zf_host, $zf_user, $zf_password);
      $connectionRetry--;
    }
    if ($this->link) {
      if (mysqli_select_db($this->link, $zf_database)) {
        if (isset($dbCharset) ) {
          mysqli_query($this->link, "SET NAMES '" . $dbCharset . "'");
          if (function_exists('mysqli_set_charset')) {
            mysqli_set_charset($this->link, $dbCharset);
          } else {
            mysqli_query($this->link, "SET CHARACTER SET '" . $dbCharset . "'");
          }
        }
        $this->db_connected = true;
        if (!defined('DISABLE_MYSQL_TZ_SET')) {
          mysqli_query($this->link, "SET time_zone = '" . substr_replace(date("O"),":",-2,0) . "'");
        }
        return true;
      } else {
        $this->set_error(mysqli_errno($this->link), mysqli_error($this->link), $dieOnErrors);
        return false;
      }
    } else {
      $this->set_error(mysqli_connect_errno(), mysqli_connect_error(), $dieOnErrors);
      return false;
    }
  }

  function simpleConnect($zf_host, $zf_user, $zf_password, $zf_database) {
    $this->database = $zf_database;
    $this->user = $zf_user;
    $this->host = $zf_host;
    $this->password = $zf_password;
    $this->link = @mysqli_connect($zf_host, $zf_user, $zf_password);
    if ($this->link) {
      $this->db_connected = true;
      return true;
    } else {
      $this->set_error(mysqli_connect_errno(), mysqli_connect_error(), $zp_real);
      return false;
    }
  }

  function selectdb($zf_database) {
    $result = mysqli_select_db($this->link, $zf_database);
    if ($result) return $result;
      $this->set_error(mysqli_errno($this->link), mysqli_error($this->link), $zp_real);
     return false;

  }

  function prepare_input($zp_string) {
    if (function_exists('mysqli_real_escape_string')) {
      return mysqli_real_escape_string($this->link, $zp_string);
    } elseif (function_exists('mysqli_escape_string')) {
      return mysqli_escape_string($this->link, $zp_string);
    } else {
      return addslashes($zp_string);
    }
  }

  function close() {
    @mysqli_close($this->link);
    unset($this->link);
  }

  function set_error($zp_err_num, $zp_err_text, $zp_fatal = true) {
    $this->error_number = $zp_err_num;
    $this->error_text = $zp_err_text;
    if ($zp_fatal && $zp_err_num != 1141) { // error 1141 is okay ... should not die on 1141, but just continue on instead
      $this->show_error();
      die();
    }
  }

  function show_error() {
    if ($this->error_number == 0 && $this->error_text == DB_ERROR_NOT_CONNECTED && !headers_sent() && file_exists('nddbc.html') ) include('nddbc.html');
    echo '<div class="systemError">';
    if (defined('STRICT_ERROR_REPORTING') && STRICT_ERROR_REPORTING == true)
    {
      echo $this->error_number . ' ' . $this->error_text;
      echo '<br />in:<br />[' . (strstr($this->zf_sql, 'db_cache') ? 'db_cache table' : $this->zf_sql) . ']<br />';
    } else {
      echo 'WARNING: An Error occurred, please refresh the page and try again.';
    }
    $backtrace_array = debug_backtrace();
    $query_factory_caller = '';
    foreach ($backtrace_array as $current_caller) {
      if (strcmp($current_caller['file'], __FILE__) != 0) {
        $query_factory_caller = ' ==> (as called by) ' . $current_caller['file'] . ' on line ' . $current_caller['line'] . ' <==';
        break;
      }
    }
    trigger_error($this->error_number . ':' . $this->error_text . ' :: ' . $this->zf_sql . $query_factory_caller, E_USER_ERROR);
    if (defined('IS_ADMIN_FLAG') && IS_ADMIN_FLAG==true) echo 'If you were entering information, press the BACK button in your browser and re-check the information you had entered to be sure you left no blank fields.<br />';
    echo '</div>';
  }

  function Execute($zf_sql, $zf_limit = false, $zf_cache = false, $zf_cachetime=0, $remove_from_queryCache = false) {
    // bof: collect database queries
    if (defined('STORE_DB_TRANSACTIONS') && STORE_DB_TRANSACTIONS=='true') {
      global $PHP_SELF, $box_id, $current_page_base;
      if (strtoupper(substr($zf_sql,0,6))=='SELECT' /*&& strstr($zf_sql,'products_id')*/) {
        $f=@fopen(DIR_FS_LOGS.'/query_selects_' . $current_page_base . '_' . time() . '.txt','a');
        if ($f) {
          fwrite($f,  "\n\n" . 'I AM HERE ' . $current_page_base . /*zen_get_all_get_params() .*/ "\n" . 'sidebox: ' . $box_id . "\n\n" . "Explain \n" . $zf_sql.";\n\n");
          fclose($f);
        }
        unset($f);
      }
    }
    // eof: collect products_id queries
    global $zc_cache;
    if ($zf_limit) {
      $zf_sql = $zf_sql . ' LIMIT ' . $zf_limit;
    }
    $this->zf_sql = $zf_sql;
    if ( $zf_cache AND $zc_cache->sql_cache_exists($zf_sql, $zf_cachetime) ) {
      $obj = new queryFactoryResult;
      $obj->cursor = 0;
      $obj->is_cached = true;
      $obj->sql_query = $zf_sql;
      $zp_result_array = $zc_cache->sql_cache_read($zf_sql);
      $obj->result = $zp_result_array;
      if (sizeof($zp_result_array) > 0 ) {
        $obj->EOF = false;
        while (list($key, $value) = each($zp_result_array[0])) {
          $obj->fields[$key] = $value;
        }
      } else {
        $obj->EOF = true;
      }
      return $obj;
    } elseif ($zf_cache) {
      $zc_cache->sql_cache_expire_now($zf_sql);
      $time_start = explode(' ', microtime());
      $obj = new queryFactoryResult;
      $obj->sql_query = $zf_sql;
      if (!$this->db_connected)
      {
        if (!$this->connect($this->host, $this->user, $this->password, $this->database, $this->pConnect, $this->real))
        $this->set_error('0', DB_ERROR_NOT_CONNECTED);
      }
      $zp_db_resource = $this->query($this->link, $zf_sql, $remove_from_queryCache);
      if (!$zp_db_resource) $this->set_error(mysqli_errno($this->link), mysqli_error($this->link), $this->dieOnErrors);
      if (FALSE === $zp_db_resource){
        $obj = null;
        return true;
      }
      $obj->resource = $zp_db_resource;
      $obj->cursor = 0;
      if ($obj->RecordCount() > 0) {
        $obj->EOF = false;
        $zp_ii = 0;
        while (!$obj->EOF) {
          $zp_result_array = mysqli_fetch_array($zp_db_resource);
          if ($zp_result_array) {
            while (list($key, $value) = each($zp_result_array)) {
              if (!preg_match('/^[0-9]/', $key)) {
                $obj->result[$zp_ii][$key] = $value;
              }
            }
          } else {
            $obj->Limit = $zp_ii;
            $obj->EOF = true;
          }
          $zp_ii++;
        }
        while (list($key, $value) = each($obj->result[$obj->cursor])) {
          if (!preg_match('/^[0-9]/', $key)) {
            $obj->fields[$key] = $value;
          }
        }
        $obj->EOF = false;
      } else {
        $obj->EOF = true;
      }
      $zc_cache->sql_cache_store($zf_sql, $obj->result);
       $obj->is_cached = true;
      $time_end = explode (' ', microtime());
      $query_time = $time_end[1]+$time_end[0]-$time_start[1]-$time_start[0];
      $this->total_query_time += $query_time;
      $this->count_queries++;
      return($obj);
    } else {
      $time_start = explode(' ', microtime());
      $obj = new queryFactoryResult;
      if (!$this->db_connected)
      {
        if (!$this->connect($this->host, $this->user, $this->password, $this->database, $this->pConnect, $this->real))
        $this->set_error('0', DB_ERROR_NOT_CONNECTED);
      }
      $zp_db_resource = $this->query($this->link, $zf_sql, $remove_from_queryCache);
      if (!$zp_db_resource) {
        if (mysqli_errno($this->link) == 2006) {
          $this->link = FALSE;
          $this->connect($this->host, $this->user, $this->password, $this->database, $this->pConnect, $this->real);
          $zp_db_resource = mysqli_query($this->link, $zf_sql);
        }
        if (!$zp_db_resource) {
          $this->set_error(mysqli_errno($this->link), mysqli_error($this->link), $this->dieOnErrors);
          return FALSE;
        }
      }
      if (FALSE === $zp_db_resource){
        $obj = null;
        return true;
      }
      $obj->resource = $zp_db_resource;
      $obj->cursor = 0;
      if ($obj->RecordCount() > 0) {
        $obj->EOF = false;
        $zp_result_array = mysqli_fetch_array($zp_db_resource);
        if ($zp_result_array) {
          while (list($key, $value) = each($zp_result_array)) {
            if (!preg_match('/^[0-9]/', $key)) {
              $obj->fields[$key] = $value;
            }
          }
          $obj->EOF = false;
        } else {
          $obj->EOF = true;
        }
      } else {
        $obj->EOF = true;
      }

      $time_end = explode (' ', microtime());
      $query_time = $time_end[1]+$time_end[0]-$time_start[1]-$time_start[0];
      $this->total_query_time += $query_time;
      $this->count_queries++;
      return($obj);
    }
  }

  function ExecuteRandomMulti($zf_sql, $zf_limit = 0, $zf_cache = false, $zf_cachetime=0) {
    $this->zf_sql = $zf_sql;
    $time_start = explode(' ', microtime());
    $obj = new queryFactoryResult;
    $obj->result = array();
    if (!$this->db_connected)
    {
      if (!$this->connect($this->host, $this->user, $this->password, $this->database, $this->pConnect, $this->real))
      $this->set_error('0', DB_ERROR_NOT_CONNECTED);
    }
    $zp_db_resource = @$this->query($this->link, $zf_sql, $remove_from_queryCache);
    if (!$zp_db_resource) $this->set_error(mysqli_errno($this->link), mysqli_error($this->link), $this->dieOnErrors);
    if (FALSE === $zp_db_resource){
      $obj = null;
      return true;
    }
    $obj->resource = $zp_db_resource;
    $obj->cursor = 0;
    $obj->Limit = $zf_limit;
    if ($obj->RecordCount() > 0 && $zf_limit > 0) {
      $obj->EOF = false;
      $zp_Start_row = 0;
      if ($zf_limit) {
      $zp_start_row = zen_rand(0, $obj->RecordCount() - $zf_limit);
      }
      $obj->Move($zp_start_row);
      $obj->Limit = $zf_limit;
      $zp_ii = 0;
      while (!$obj->EOF) {
        $zp_result_array = @mysqli_fetch_array($zp_db_resource);
        if ($zp_ii == $zf_limit) $obj->EOF = true;
        if ($zp_result_array) {
          while (list($key, $value) = each($zp_result_array)) {
            $obj->result[$zp_ii][$key] = $value;
          }
        } else {
          $obj->Limit = $zp_ii;
          $obj->EOF = true;
        }
        $zp_ii++;
      }
      $obj->result_random = array_rand($obj->result, sizeof($obj->result));

      if (is_array($obj->result_random)) {
        $zp_ptr = $obj->result_random[$obj->cursor];
      } else {
        $zp_ptr = $obj->result_random;
      }
      while (list($key, $value) = each($obj->result[$zp_ptr])) {
        if (!preg_match('/^[0-9]/', $key)) {
          $obj->fields[$key] = $value;
        }
      }
      $obj->EOF = false;
    } else {
      $obj->EOF = true;
    }


    $time_end = explode (' ', microtime());
    $query_time = $time_end[1]+$time_end[0]-$time_start[1]-$time_start[0];
    $this->total_query_time += $query_time;
    $this->count_queries++;
    return($obj);
  }

  function insert_ID() {
    return @mysqli_insert_id($this->link);
  }

  function metaColumns($zp_table) {
    $sql = "SHOW COLUMNS from :tableName:";
    $sql = $this->bindVars($sql, ':tableName:', $zp_table, 'noquotestring');
    $res = $this->execute($sql);
    while (!$res->EOF)
    {
      $obj [strtoupper($res->fields['Field'])] = new queryFactoryMeta($res->fields);
      $res->MoveNext();
    }
    return $obj;
  }

  function get_server_info() {
    if ($this->link) {
      return mysqli_get_server_info($this->link);
    } else {
      return UNKNOWN;
    }
  }

  function queryCount() {
    return $this->count_queries;
  }

  function queryTime() {
    return $this->total_query_time;
  }

  function perform ($tableName, $tableData, $performType='INSERT', $performFilter='', $debug=false) {
    switch (strtolower($performType)) {
      case 'insert':
      $insertString = "";
      $insertString = "INSERT INTO " . $tableName . " (";
      foreach ($tableData as $key => $value) {
        if ($debug === true) {
          echo $value['fieldName'] . '#';
        }
        $insertString .= $value['fieldName'] . ", ";
      }
      $insertString = substr($insertString, 0, strlen($insertString)-2) . ') VALUES (';
      reset($tableData);
      foreach ($tableData as $key => $value) {
        $bindVarValue = $this->getBindVarValue($value['value'], $value['type']);
        $insertString .= $bindVarValue . ", ";
      }
      $insertString = substr($insertString, 0, strlen($insertString)-2) . ')';
      if ($debug === true) {
        echo $insertString;
        die();
      } else {
        $this->execute($insertString);
      }
      break;
      case 'update':
      $updateString ="";
      $updateString = 'UPDATE ' . $tableName . ' SET ';
      foreach ($tableData as $key => $value) {
        $bindVarValue = $this->getBindVarValue($value['value'], $value['type']);
        $updateString .= $value['fieldName'] . '=' . $bindVarValue . ', ';
      }
      $updateString = substr($updateString, 0, strlen($updateString)-2);
      if ($performFilter != '') {
        $updateString .= ' WHERE ' . $performFilter;
      }
      if ($debug === true) {
        echo $updateString;
        die();
      } else {
        $this->execute($updateString);
      }
      break;
    }
  }
  function getBindVarValue($value, $type) {
    $typeArray = explode(':',$type);
    $type = $typeArray[0];
    switch ($type) {
      case 'csv':
        return $value;
      break;
      case 'passthru':
        return $value;
      break;
      case 'float':
        return (!zen_not_null($value) || $value=='' || $value == 0) ? 0 : $value;
      break;
      case 'integer':
        return (int)$value;
      break;
      case 'string':
        if (isset($typeArray[1])) {
          $regexp = $typeArray[1];
        }
        return '\'' . $this->prepare_input($value) . '\'';
      break;
      case 'noquotestring':
        return $this->prepare_input($value);
      break;
      case 'currency':
        return '\'' . $this->prepare_input($value) . '\'';
      break;
      case 'date':
        return '\'' . $this->prepare_input($value) . '\'';
      break;
      case 'enum':
        if (isset($typeArray[1])) {
          $enumArray = explode('|', $typeArray[1]);
        }
        return '\'' . $this->prepare_input($value) . '\'';
      case 'regexp':
        $searchArray = array('[', ']', '(', ')', '{', '}', '|', '*', '?', '.', '$', '^');
        foreach ($searchArray as $searchTerm) {
          $value = str_replace($searchTerm, '\\' . $searchTerm, $value);
        }
        return $this->prepare_input($value);
      default:
      die('var-type undefined: ' . $type . '('.$value.')');
    }
  }
/**
 * method to do bind variables to a query
**/
  function bindVars($sql, $bindVarString, $bindVarValue, $bindVarType, $debug = false) {
    $bindVarTypeArray = explode(':', $bindVarType);
    $sqlNew = $this->getBindVarValue($bindVarValue, $bindVarType);
    $sqlNew = str_replace($bindVarString, $sqlNew, $sql);
    return $sqlNew;
  }

  function prepareInput($string) {
    return $this->prepare_input($string);
  }
}

class queryFactoryResult {

  function queryFactoryResult() {
    $this->is_cached = false;
  }

  function MoveNext() {
    global $zc_cache;
    $this->cursor++;
    if ($this->is_cached) {
      if ($this->cursor >= sizeof($this->result)) {
        $this->EOF = true;
      } else {
        while(list($key, $value) = each($this->result[$this->cursor])) {
          $this->fields[$key] = $value;
        }
      }
    } else {
      $zp_result_array = @mysqli_fetch_array($this->resource);
      if (!$zp_result_array) {
        $this->EOF = true;
      } else {
        while (list($key, $value) = each($zp_result_array)) {
          if (!preg_match('/^[0-9]/', $key)) {
            $this->fields[$key] = $value;
          }
        }
      }
    }
  }

  function MoveNextRandom() {
    $this->cursor++;
    if ($this->cursor < $this->Limit) {
      $zp_result_array = $this->result[$this->result_random[$this->cursor]];
      while (list($key, $value) = each($zp_result_array)) {
        if (!preg_match('/^[0-9]/', $key)) {
          $this->fields[$key] = $value;
        }
      }
    } else {
      $this->EOF = true;
    }
  }

  function RecordCount() {
    if ($this->is_cached) return sizeof($this->result);
    return @mysqli_num_rows($this->resource);
  }

  function Move($zp_row) {
    global $db;
    if ($this->is_cached) {
      if($zp_row >= sizeof($this->result)) {
        $this->cursor = sizeof($this->result);
        $this->EOF = true;
      } else {
        $this->cursor = $zp_row;
        while(list($key, $value) = each($this->result[$this->cursor])) {
          $this->fields[$key] = $value;
        }
        $this->EOF = false;
      }
    }
    else if (@mysqli_data_seek($this->resource, $zp_row)) {
      $zp_result_array = @mysqli_fetch_array($this->resource);
      while (list($key, $value) = each($zp_result_array)) {
        $this->fields[$key] = $value;
      }
      @mysqli_data_seek($this->resource, $zp_row);
      $this->EOF = false;
      return;
    } else {
      $this->EOF = true;
      $db->set_error(mysqli_errno($this->link), mysqli_error($this->link), $this->dieOnErrors);
    }
  }
}

class queryFactoryMeta {

  function queryFactoryMeta($zp_field) {
    $type = $zp_field['Type'];
    $rgx = preg_match('/^[a-z]*/', $type, $matches);
    $this->type = $matches[0];
    $this->max_length = preg_replace('/[a-z\(\)]/', '', $type);
  }
}



















/**
 * File contains just the zcPassword class
 *
 * @package classes
 * @copyright Copyright 2003-2014 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version GIT: $Id: Author: wilt  Modified in v1.5.4 $
 */
/**
 * class zcPassword
 *
 * helper class for managing password hashing for different PHP versions
 *
 * Updates admin/customer tables on successful login
 * For php < 5.3.7 uses custom code to create hashes using SHA256 and longer salts
 * For php >= 5.3.7 and < 5.5.0 uses https://github.com/ircmaxell/PHP-PasswordLib
 * For php >= 5.5.0 uses inbuilt php functions
 *
 * @package classes
 */
class zcPassword extends base
{
  /**
   *
   * @var $instance object
   */
  protected static $instance = null;
  /**
   * enforce singleton
   *
   * @param string $phpVersion
   */
  public static function getInstance($phpVersion)
  {
    if (! self::$instance) {
      $class = __CLASS__;
      self::$instance = new $class($phpVersion);
    }
    return self::$instance;
  }
  /**
   * constructor
   *
   * @param string $phpVersion
   */
  public function __construct($phpVersion = PHP_VERSION)
  {
    if (version_compare($phpVersion, '5.3.7', '<')) {
      require_once (realpath(dirname(__FILE__)) . '/../functions/password_compat.php');
    } elseif (version_compare($phpVersion, '5.5.0', '<')) {
      require_once (realpath(dirname(__FILE__)) . '/../classes/vendors/password_compat-master/lib/password.php');
	  //require_once (realpath(dirname(__FILE__)) . '/../functions/password_compat.php');
    }
  }
  /**
   * Determine the password type
   *
   * Legacy passwords were hash:salt with a salt of length 2
   * php < 5.3.7 updated passwords are hash:salt with salt of length > 2
   * php >= 5.3.7 passwords are BMCF format
   *
   * @param string $encryptedPassword
   * @return string
   */
  function detectPasswordType($encryptedPassword)
  {
    $type = 'unknown';
    $tmp = explode(':', $encryptedPassword);
    if (count($tmp) == 2) {
      if (strlen($tmp [1]) > 2) {
        $type = 'compatSha256';
      } elseif (strlen($tmp [1]) == 2) {
        $type = 'oldMd5';
      }
    }
    return $type;
  }
  /**
   * validate a password where format is unknown
   *
   * @param string $plain
   * @param string $encrypted
   * @return boolean
   */
  public function validatePassword($plain, $encrypted)
  {
    $type = $this->detectPasswordType($encrypted);
    if ($type != 'unknown') {
      $method = 'validatePassword' . ucfirst($type);
      return $this->{$method}($plain, $encrypted);
    }
    $result = password_verify($plain, $encrypted);
    return $result;
  }
  /**
   * validate a legacy md5 type password
   *
   * @param string $plain
   * @param string $encrypted
   * @return boolean
   */
  public function validatePasswordOldMd5($plain, $encrypted)
  {
    if (zen_not_null($plain) && zen_not_null($encrypted)) {
      $stack = explode(':', $encrypted);
      if (sizeof($stack) != 2)
        return false;
      if (md5($stack [1] . $plain) == $stack [0]) {
        return true;
      }
    }
    return false;
  }
  /**
   * validate a SHA256 type password
   *
   * @param string $plain
   * @param string $encrypted
   * @return boolean
   */
  public function validatePasswordCompatSha256($plain, $encrypted)
  {
    if (zen_not_null($plain) && zen_not_null($encrypted)) {
      $stack = explode(':', $encrypted);
      if (sizeof($stack) != 2)
        return false;
      if (hash('sha256', $stack [1] . $plain) == $stack [0]) {
        return true;
      }
    }
    return false;
  }
  /**
   * Update a logged in Customer password.
   * e.g. when customer wants to change password
   *
   * @param string $plain
   * @param integer $customerId
   * @return string
   */
  public function updateLoggedInCustomerPassword($plain, $customerId)
  {
    $this->confirmDbSchema('customer');
    global $db;
    $updatedPassword = password_hash($plain, PASSWORD_DEFAULT);
    $sql = "UPDATE " . TABLE_CUSTOMERS . "
              SET customers_password = :password:
              WHERE customers_id = :customersId:";

    $sql = $db->bindVars($sql, ':customersId:', $_SESSION ['customer_id'], 'integer');
    $sql = $db->bindVars($sql, ':password:', $updatedPassword, 'string');
    $db->Execute($sql);
    return $updatePassword;
  }
  /**
   * Update a not logged in Customer password.
   * e.g. login/timeout
   *
   * @param string $plain
   * @param string $emailAddress
   * @return string
   */
  public function updateNotLoggedInCustomerPassword($plain, $emailAddress)
  {
    $this->confirmDbSchema('customer');
    global $db;
    $updatedPassword = password_hash($plain, PASSWORD_DEFAULT);
    $sql = "UPDATE " . TABLE_CUSTOMERS . "
              SET customers_password = :password:
              WHERE customers_email_address = :emailAddress:";

    $sql = $db->bindVars($sql, ':emailAddress:', $emailAddress, 'string');
    $sql = $db->bindVars($sql, ':password:', $updatedPassword, 'string');
    $db->Execute($sql);
    return $updatedPassword;
  }
  /**
   * Update a not logged in Admin password.
   *
   * @param string $plain
   * @param string $admin
   * @return string
   */
  public function updateNotLoggedInAdminPassword($plain, $admin)
  {
    $this->confirmDbSchema('admin');
    global $db;
    $updatedPassword = password_hash($plain, PASSWORD_DEFAULT);
    $sql = "UPDATE " . TABLE_ADMIN . "
              SET admin_pass = :password:
              WHERE admin_name = :adminName:";

    $sql = $db->bindVars($sql, ':adminName:', $admin, 'string');
    $sql = $db->bindVars($sql, ':password:', $updatedPassword, 'string');
    $db->Execute($sql);
    return $updatedPassword;
  }
  /**
   * Ensure db schema has been updated to support the required password lengths
   * @param string $mode
   */
  public function confirmDbSchema($mode = '') {
    global $db;
    if ($mode == '' || $mode == 'admin') {
      $sql = "ALTER TABLE " . TABLE_ADMIN . " MODIFY admin_pass VARCHAR( 255 ) NOT NULL DEFAULT ''";
      $db->Execute($sql);
      $sql = "ALTER TABLE " . TABLE_ADMIN . " MODIFY prev_pass1 VARCHAR( 255 ) NOT NULL DEFAULT ''";
      $db->Execute($sql);
      $sql = "ALTER TABLE " . TABLE_ADMIN . " MODIFY prev_pass2 VARCHAR( 255 ) NOT NULL DEFAULT ''";
      $db->Execute($sql);
      $sql = "ALTER TABLE " . TABLE_ADMIN . " MODIFY prev_pass3 VARCHAR( 255 ) NOT NULL DEFAULT ''";
      $db->Execute($sql);
      $sql = "ALTER TABLE " . TABLE_ADMIN . " MODIFY reset_token VARCHAR( 255 ) NOT NULL DEFAULT ''";
      $db->Execute($sql);
    }
    if ($mode == '' || $mode == 'customer') {
      $found = false;
      $sql = "show fields from " . TABLE_CUSTOMERS;
      $result = $db->Execute($sql);
      while (!$result->EOF && !$found) {
        if ($result->fields['Field'] == 'customers_password' && strtoupper($result->fields['Type']) == 'VARCHAR(255)') {
          $found = true;
        }
        $result->MoveNext();
      }
      if (!$found) {
        $sql = "ALTER TABLE " . TABLE_CUSTOMERS . " MODIFY customers_password VARCHAR( 255 ) NOT NULL DEFAULT ''";
        $db->Execute($sql);
      }
    }
    return;
  }
}

















function zen_validate_password($plain, $encrypted, $userRef = NULL)
{
  $zcPassword = zcPassword::getInstance(PHP_VERSION);
  return $zcPassword->validatePassword($plain, $encrypted);
}

// //
// This function makes a new password from a plaintext password.
function zen_encrypt_password($plain)
{
  $password = '';

  for($i = 0; $i < 10; $i ++) {
    $password .= zen_rand();
  }

  $salt = substr(md5($password), 0, 2);

  $password = md5($salt . $plain) . ':' . $salt;

  return $password;
}
function zen_encrypt_password_new($plain)
{
  $password = '';
  for($i = 0; $i < 40; $i ++) {
    $password .= zen_rand();
  }
  $salt = hash('sha256', $password);
  $password = hash('sha256', $salt . $plain) . ':' . $salt;
  return $password;
}
// //
function zen_create_random_value($length, $type = 'mixed')
{
  if (($type != 'mixed') && ($type != 'chars') && ($type != 'digits'))
    return false;

  $rand_value = '';
  while ( strlen($rand_value) < $length ) {
    if ($type == 'digits') {
      $char = zen_rand(0, 9);
    } else {
      $char = chr(zen_rand(0, 255));
    }
    if ($type == 'mixed') {
      if (preg_match('/^[a-z0-9]$/i', $char))
        $rand_value .= $char;
    } elseif ($type == 'chars') {
      if (preg_match('/^[a-z]$/i', $char))
        $rand_value .= $char;
    } elseif ($type == 'digits') {
      if (preg_match('/^[0-9]$/', $char))
        $rand_value .= $char;
    }
  }

  if ($type == 'mixed' && ! preg_match('/^(?=.*[\w]+.*)(?=.*[\d]+.*)[\d\w]{' . $length . ',}$/', $rand_value)) {
    $rand_value .= zen_rand(0, 9);
  }

  return $rand_value;
}
/**
 * Returns entropy using a hash of various available methods for obtaining
 * random data.
 * The default hash method is "sha1" and the default size is 32.
 *
 * @param string $hash
 *          the hash method to use while generating the hash.
 * @param int $size
 *          the size of random data to use while generating the hash.
 * @return string the randomized salt
 */
function zen_get_entropy($hash = 'sha1', $size = 32)
{
  $data = null;
  if (! in_array($hash, hash_algos()))
    $hash = 'sha1';
  if (! is_int($size))
    $size = (int)$size;

    // Use openssl if available
  if (function_exists('openssl_random_pseudo_bytes')) {
    // echo('Attempting to create entropy using openssl');
    $entropy = openssl_random_pseudo_bytes($size, $strong);
    if ($strong)
      $data = $entropy;
    unset($strong, $entropy);
  }

  // Use mcrypt with /dev/urandom if available
  if ($data === null && function_exists('mcrypt_create_iv') && (
    // There is a bug in Windows + IIS in older versions of PHP
    (
strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN' || version_compare(PHP_VERSION, '5.3.7', '>='))))
  {
    // echo('Attempting to create entropy using mcrypt');
    $entropy = mcrypt_create_iv($size, MCRYPT_DEV_URANDOM);
    if ($entropy !== FALSE)
      $data = $entropy;
    unset($entropy);
  }

  if ($data === null) {
    // Fall back to using /dev/urandom if available
    $fp = @fopen('/dev/urandom', 'rb');
    if ($fp !== FALSE) {
      // echo('Attempting to create entropy using /dev/urandom');
      $entropy = @fread($fp, $size);
      @fclose($fp);
      if (strlen($entropy) == $size)
        $data = $entropy;
      unset($fp, $entropy);
    }
  }

  // Final fallback (mixture of various methods)
  if ($data === null) {
    // echo('Attempting to create entropy using FINAL FALLBACK');
    if (!defined('DIR_FS_ROOT')) define('DIR_FS_ROOT', DIR_FS_CATALOG);
    $filename = DIR_FS_ROOT . 'includes/configure.php';
    $stat = @stat($filename);
    if ($stat === FALSE) {
      $stat = array(
          'microtime' => microtime()
      );
    }
    $stat ['mt_rand'] = mt_rand();
    $stat ['file_hash'] = hash_file($hash, $filename, TRUE);

    // Attempt to get a random value on windows
    // http://msdn.microsoft.com/en-us/library/aa388176(VS.85).aspx
    if (@class_exists('COM')) {
      try {
        $CAPI_Util = new COM('CAPICOM.Utilities.1');
        $entropy = $CAPI_Util->GetRandom($size, 0);

        if ($entropy) {
          // echo('Adding random data to entropy using CAPICOM.Utilities');
          $stat ['CAPICOM_Utilities_random'] = md5($entropy, TRUE);
        }
        unset($CAPI_Util, $entropy);
      } catch ( Exception $ex ) {
      }
    }

    // echo('Adding random data to entropy using file information and contents');
    @shuffle($stat);
    foreach ( $stat as $value ) {
      $data .= $value;
    }
    unset($filename, $value, $stat);
  }

  return hash($hash, $data);
}
function zen_create_PADSS_password($length = 8)
{
  $charsAlpha = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charsNum = '0123456789';
  $charsMixed = $charsAlpha . $charsNum;
  $password = "";
  for($i = 0; $i < $length; $i ++) {
    $addChar = substr($charsMixed, zen_pwd_rand(0, strlen($charsMixed) - 1), 1);
    while ( strpos($password, $addChar) ) {
      $addChar = substr($charsMixed, zen_pwd_rand(0, strlen($charsMixed) - 1), 1);
    }
    $password .= $addChar;
  }
  if (! preg_match('/[0-9]/', $password)) {
    $addChar = substr($charsNum, zen_pwd_rand(0, strlen($charsNum) - 1), 1);
    $addPos = zen_pwd_rand(0, strlen($password) - 1);
    $password [$addPos] = $addChar;
  }
  return $password;
}
function zen_pwd_rand($min = 0, $max = 10)
{
  static $seed;
  if (! isset($seed))
    $seed = zen_get_entropy();
  $random = hash('sha1', zen_get_entropy() . $seed);
  $random .= hash('sha1', zen_get_entropy() . $random);
  $random = hash('sha1', $random);
  $random = substr($random, 0, 8);
  $value = abs(hexdec($random));
  $value = $min + (($max - $min + 1) * ($value / (4294967295 + 1)));
  $value = abs(intval($value));
  return $value;
}

  function zen_db_input($string) {
    global $db;
    return $db->prepareInput($string);
  }
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
    $SESS_LIFE = 20000000;
  
  function _sess_open($save_path, $session_name) {
    return true;
  }

  function _sess_close() {
    return true;
  }

  function _sess_read($key) {
    global $db;
    $qid = "select value
            from sessions
            where sesskey = '" . zen_db_input($key) . "'
            and expiry > '" . time() . "'";

    $value = $db->Execute($qid);

    if (isset($value->fields['value']) && $value->fields['value']) {
      $value->fields['value'] = base64_decode($value->fields['value']);
      return $value->fields['value'];
    }

    return ("");
  }

  function _sess_write($key, $val) {
    global $db;
    if (!is_object($db)) return;
    $val = base64_encode($val);

    global $SESS_LIFE;
    $expiry = time() + $SESS_LIFE;

    $qid = "select count(*) as total
            from sessions
            where sesskey = '" . zen_db_input($key) . "'";
    $total = $db->Execute($qid);

    if ($total->fields['total'] > 0) {
      $sql = "update sessions
              set expiry = '" . zen_db_input($expiry) . "', value = '" . zen_db_input($val) . "'
              where sesskey = '" . zen_db_input($key) . "'";
      $result = $db->Execute($sql);
    } else {
		if (isset($_SESSION['admin_id'])) {
			$ses_id=$_SESSION['admin_id'];
		}else if(isset($_SESSION['customer_id'])){
			$ses_id=$_SESSION['customer_id'];
		}else{
			$ses_id=0;	
		}
      $sql = "insert into sessions
              values ('" . zen_db_input($key) . "', '" . zen_db_input($expiry) . "', '" .
                       zen_db_input($val) . "','".$ses_id."')";
      $result = $db->Execute($sql);
    }
    return (!empty($result) && !empty($result->resource));
  }

  function _sess_destroy($key) {
    global $db;
    $sql = "delete from sessions where sesskey = '" . zen_db_input($key) . "'";
    $db->Execute($sql);
    return TRUE;
  }

  function _sess_gc($maxlifetime) {
    global $db;
    $sql = "delete from sessions where expiry < " . time();
    $db->Execute($sql);
    return true;
  }

  function zen_db_prepare_input($string) {
    if (is_string($string)) {
      return trim(zen_sanitize_string(stripslashes($string)));
    } elseif (is_array($string)) {
      reset($string);
      while (list($key, $value) = each($string)) {
        $string[$key] = zen_db_prepare_input($value);
      }
      return $string;
    } else {
      return $string;
    }
  }
  // Initialize session save-handler
  session_set_save_handler('_sess_open', '_sess_close', '_sess_read', '_sess_write', '_sess_destroy', '_sess_gc');
  // write and close session at the end of scripts, and before objects are destroyed
  register_shutdown_function('session_write_close');


  function zen_session_start() {
	 
    @ini_set('session.gc_probability', 1);
    @ini_set('session.gc_divisor', 2);
    @ini_set('session.gc_maxlifetime', 20000000);

    if (preg_replace('/[a-zA-Z0-9]/', '', session_id()) != '')
    {
      zen_session_id(md5(uniqid(rand(), true)));
    }

    $temp = session_start();
    if (!isset($_SESSION['securityToken'])) {
      $_SESSION['securityToken'] = md5(uniqid(rand(), true));
    }
    return $temp;
  }

  function zen_session_id($sessid = '') {
    if (!empty($sessid)) {
      $tempSessid = $sessid;
      if (preg_replace('/[a-zA-Z0-9]/', '', $tempSessid) != '')
      {
        $sessid = md5(uniqid(rand(), true));
      }
      return session_id($sessid);
    } else {
      return session_id();
    }
  }
  function zen_sanitize_string($string) {
    $string = preg_replace('/ +/', ' ', $string);
    return preg_replace("/[<>]/", '_', $string);
  }

  function zen_session_name($name = '') {
    if (!empty($name)) {
      $tempName = $name;
      if (preg_replace('/[a-zA-Z0-9]/', '', $tempName) == '') return session_name($name);
      return FALSE;
    } else {
      return session_name();
    }
  }

  function zen_session_write_close() {
    return session_write_close();
  }

  function zen_session_destroy() {
    return session_destroy();
  }

  function zen_session_save_path($path = '') {
    if (!empty($path)) {
      return session_save_path($path);
    } else {
      return session_save_path();
    }
  }

  function zen_session_recreate() {
    global $http_domain, $https_domain, $current_domain;
      if ($http_domain == $https_domain) {
      $saveSession = $_SESSION;
      $oldSessID = session_id();
      session_regenerate_id();
      $newSessID = session_id();
      session_id($oldSessID);
      session_id($newSessID);
      session_set_save_handler('_sess_open', '_sess_close', '_sess_read', '_sess_write', '_sess_destroy', '_sess_gc');
      $_SESSION = $saveSession;
      if (IS_ADMIN_FLAG !== true) {
        whos_online_session_recreate($oldSessID, $newSessID);
      }
    }
  }
    function zen_not_null($value) {
    if (is_array($value)) {
      if (sizeof($value) > 0) {
        return true;
      } else {
        return false;
      }
    } elseif( is_a( $value, 'queryFactoryResult' ) ) {
      if (sizeof($value->result) > 0) {
        return true;
      } else {
        return false;
      }
    } else {
      if (($value != '') && (strtolower($value) != 'null') && (strlen(trim($value)) > 0)) {
        return true;
      } else {
        return false;
      }
    }
  }
  
  



class GCMPushMessage {
	var $url = 'https://android.googleapis.com/gcm/send';
	var $serverApiKey = "AIzaSyB3Qlncbq6RLBGCetjtDCrGvXFvuhTZD7I";
	var $devices = array();
	
	/*
		Constructor
		@param $apiKeyIn the server API key
	*/
	function GCMPushMessage(){

	}
	/*
		Set the devices to send to
		@param $deviceIds array of device tokens to send to
	*/
	function setDevices($deviceIds){
	
		if(is_array($deviceIds)){
			$this->devices = $deviceIds;
		} else {
			$this->devices = array($deviceIds);
		}
	
	}
	/*
		Send the message to the device
		@param $message The message to send
		@param $data Array of data to accompany the message
	*/
	function send($message,$device_id='', $data = false){
		
		if($device_id==''){
			$this->error("Enter device id");
			return 0;
		}
		
		if(strlen($this->serverApiKey) < 8){
			$this->error("Server API Key not set");
			return 0;
		}
		
		$fields = array(
			'registration_ids'  => $this->devices,
			'data'              => array( "message" => $message ),
		);
		

		$headers = array( 
			'Authorization: key=' . $this->serverApiKey,
			'Content-Type: application/json'
		);
		// Open connection
		$ch = curl_init();
		
		// Set the url, number of POST vars, POST data
		curl_setopt( $ch, CURLOPT_URL, $this->url );
		
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		
		curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );
		
		// Avoids problem with https certificate
		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false);
		
		// Execute post
		$result = curl_exec($ch);
		
		// Close connection
		curl_close($ch);
		$result = json_decode($result,true);
		if($result['success']!=0 && $result['failure']==0){
			return true;
		}else{
			return false;
		}
	}
	
	function error($msg){
		echo "Android send notification failed with error:";
		echo "\t" . $msg;
		exit(1);
	}
}
?>