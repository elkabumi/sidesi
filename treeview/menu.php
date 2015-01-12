<?php
 
include"koneksi.php";
include"fungsi_menu.php";
 
$sql=mysql_query("select * from village_profile_structures");
 
while ($row = mysql_fetch_object($sql)) {
 $data[$row->vps_parent_id][] = $row;
 }
 $menu = get_menu($data);
 echo "$menu";
?>