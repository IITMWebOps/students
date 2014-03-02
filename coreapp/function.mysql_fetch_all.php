<?php
if (!function_exists('mysql_fetch_all') ){
/**
 ** Fetches all rows from a MySQL result set as an array of arrays
 **
 ** @param   $result       MySQL result resource
 ** @param   $result_type  Type of array to be fetched
 **                        { MYSQL_NUM | MYSQL_ASSOC | MYSQL_BOTH }
 ** @return  mixed
 **/
  
  function mysql_fetch_all ($result, $result_type = MYSQL_BOTH){
    if (!is_resource($result) || get_resource_type($result) != 'mysql result'){
      trigger_error(__FUNCTION__ . '(): supplied argument is not a valid MySQL result resource', E_USER_WARNING);
        return false;
    }
    if (!in_array($result_type, array(MYSQL_ASSOC, MYSQL_BOTH, MYSQL_NUM), true)){
      trigger_error(__FUNCTION__ . '(): result type should be MYSQL_NUM, MYSQL_ASSOC, or MYSQL_BOTH', E_USER_WARNING);
      return false;
    }
    $rows = array();
    while ($row = mysql_fetch_array($result, $result_type)){
      $rows[] = $row;
    }
    return $rows;
  }

}
?>
