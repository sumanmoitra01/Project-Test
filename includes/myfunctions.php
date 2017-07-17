<?php
function location_list( $location_id = ''){
  echo $sql = "SELECT `location_id`, `location_name` FROM academic_location_tbl";
  $res = mysql_query($sql);
  $str = '';
  if( mysql_num_rows($res) > 0 ){
    while( $obj = mysql_fetch_object($res) ){
      if( $location_id == $obj->location_id ){
        $str .= '<option value="'.$obj->location_id.'" selected="selected">'.$obj->location_name. '</option>';
      } else{
        $str .= '<option value="'.$obj->location_id.'">'.$obj->location_name. '</option>';
      }
    }
  }
  return $str;
}

