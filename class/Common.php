<?php
require '../config/dbconfig.php';

$GLOBALS['mysqli'] = $mysqli;
class Common
{
  function Login($email, $password, $tblname)
  {

    $q = "select * from " . $tblname . " where email='" . $email . "' and password='" . $password . "'";
    return $GLOBALS['mysqli']->query($q)->num_rows;
  }

  function Insertdata($field, $data, $table)
  {

    // $field_values = implode(',', $field);
    $field_values = '`' . implode('`,`', $field) . '`';
    $data_values = implode("','", $data);

    $myQuery = "INSERT INTO " . $table . "( " . $field_values . " ) VALUES ( '" . $data_values . "' )";

    return $GLOBALS['mysqli']->query($myQuery);
  }

  function Insertdata_table_id($field, $data, $table)
  {

    $field_values = implode(',', $field);
    $data_values = implode("','", $data);

    $myQuery = "INSERT INTO " . $table . "( " . $field_values . " ) VALUES ( '" . $data_values . "' )";
    if ($GLOBALS['mysqli']->query($myQuery)) {
      $id = $GLOBALS['mysqli']->insert_id;
    } else {
      $id = 0;
    }
    return $id;
  }

  function Insertdata_id($field, $data, $table)
  {

    $field_values = implode(',', $field);
    $data_values = implode("','", $data);

    $myQuery = "INSERT INTO " . $table . "( " . $field_values . " ) VALUES ( '" . $data_values . "' )";
    return $GLOBALS['mysqli']->query($myQuery);
  }

  function InsertData_Api($field, $data, $table)
  {

    $field_values = implode(',', $field);
    $data_values = implode("','", $data);

    $myQuery = "INSERT INTO " . $table . "( " . $field_values . " ) VALUES ( '" . $data_values . "' )";
    return $GLOBALS['mysqli']->query($myQuery);
  }

  function InsertData_Api_Id($field, $data, $table)
  {
    // print_r($field);
    $field_values = implode(',', $field);
    $data_values = implode("','", $data);

    $myQuery = "INSERT INTO " . $table . "( " . $field_values . " ) VALUES ( '" . $data_values . "' )";

    return $GLOBALS['mysqli']->query($myQuery);
  }


  function InsertData_PId($field, $data, $table)
  {
    $field_values = implode(',', $field);
    $data_values = implode("','", $data);

    $myQuery = "INSERT INTO " . $table . "( " . $field_values . " ) VALUES ( '" . $data_values . "' )";
    $GLOBALS['mysqli']->query($myQuery);
    return mysqli_insert_id($GLOBALS['mysqli']);
  }

  function UpdateDataNULL($field, $table, $where)
  {
    $cols = '';
    $count = COUNT($field);
    $i = 0;
    foreach ($field as $key => $val) {
      if ($i == $count - 1) {
        $cols .= "$key = '$val'";
      } else {
        $cols .= "$key = '$val',";
      }
      $i++;
    }
    $myQuery = "UPDATE " . $table . " set " . $cols . " " . $where;
    return $GLOBALS['mysqli']->query($myQuery);
  }

  function UpdateData($field, $table, $where)
  {
    $cols = '';

    $count = COUNT($field);
    $i = 0;
    foreach ($field as $key => $val) {
      if ($val != NULL) // check if value is not null then only add that colunm to array
      {
        if ($i == $count - 1) {
          $cols .= "`$key` = '$val'";
          // $cols .= "$key = '$val'";
        } else {
          $cols .= "`$key` = '$val',";
          // $cols .= "$key = '$val',";
        }
      }
      $i++;
    }

    $myQuery = "UPDATE " . $table . " set " . $cols . " " . $where;
    return $GLOBALS['mysqli']->query($myQuery);
  }
  function UpdateData_single($field, $table, $where)
  {
    $cols = '';

    // $count = COUNT($field);
    // $i = 0;
    // foreach($field as $key=>$val) {
    //     if($val != NULL) // check if value is not null then only add that colunm to array
    //     {
    //         if($i == $count-1){
    //             $cols .= "$key = '$val'"; 
    //         }
    //         else{
    //             $cols .= "$key = '$val',"; 
    //         }
    //     }
    //     $i++;
    // }

    $myQuery = "UPDATE " . $table . " set " . $field . " " . $where;
    return $GLOBALS['mysqli']->query($myQuery);
  }

  function UpdateData_Api($field, $table, $where)
  {
    $cols = array();

    // foreach($field as $key=>$val) {
    //     if($val != NULL) // check if value is not null then only add that colunm to array
    //     {
    //        $cols[] = "$key = '$val'"; 
    //     }
    // }
    // print_r($field);

    $count = COUNT($field);
    $i = 0;
    foreach ($field as $key => $val) {
      // echo $key;
      if ($val != NULL) // check if value is not null then only add that colunm to array
      {
        if ($i == $count - 1) {
          $cols = "$key = '$val'";
        } else {
          echo $cols = "$key = '$val',";
        }
      }
      $i++;
    }


    $myQuery = "UPDATE " . $table . " set " . $cols . " " . $where;
    // echo $myQuery; die;
    return $GLOBALS['mysqli']->query($myQuery);
  }
  function UpdateData_Api_set($field, $table, $where)
  {
    // $cols = array();

    // // foreach($field as $key=>$val) {
    // //     if($val != NULL) // check if value is not null then only add that colunm to array
    // //     {
    // //        $cols[] = "$key = '$val'"; 
    // //     }
    // // }
    // // print_r($field);

    // $count = COUNT($field);
    // $i=0;
    //  foreach($field as $key=>$val) {
    //     // echo $key;
    //     if($val != NULL) // check if value is not null then only add that colunm to array
    //     {
    //         if($i == $count-1){
    //              $cols = "$key = '$val'"; 

    //         }
    //         else{
    //             $cols = "$key = '$val',"; 
    //         }
    //     }
    //     $i++;
    //  $myQuery = "UPDATE ".$table." set ".$key = $val." ".$where;
    //  $GLOBALS['mysqli']->query($myQuery);
    // return true;

  }



  function UpdateData_Api_new($field, $table, $where)
  {

    $cols = '';

    $count = COUNT($field);
    $i = 0;
    foreach ($field as $key => $val) {
      if ($val != NULL  || $val == 0) // check if value is not null then only add that colunm to array
      {
        if ($i == $count - 1) {
          $cols .= "`$key` = '$val'";
        } else {
          $cols .= "`$key` = '$val',";
        }
      }
      $i++;
    }
    $cols = rtrim($cols, ",");
    $myQuery = "UPDATE " . $table . " set " . $cols . " " . $where;

    //print_r($myQuery);
    //die;
    return $GLOBALS['mysqli']->query($myQuery);
  }



  function Deletedata($where, $table)
  {


    $myQuery = "DELETE FROM " . $table . " " . $where;
    return $GLOBALS['mysqli']->query($myQuery);
  }
}
