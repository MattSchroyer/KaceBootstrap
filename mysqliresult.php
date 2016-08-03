<?php
### added function as a subsitute for mysql_result, which doesn't have an mysqli equivalent
function mysqli_result($res, $row, $field) { 
    $res->data_seek($row); 
    $datarow = $res->fetch_array(); 
    return $datarow[$field]; 
}
?>