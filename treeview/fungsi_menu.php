<?php
 
function get_menu($data, $parent = 0) {
 static $i = 1;
 $tab = str_repeat(" ", $i);
 $data[] = array();
 if ($data[$parent]) {
 $html = "$tab<ul id='menu-tree' class='filetree'>";
 $i++;
 foreach ($data[$parent] as $v) {
 $child = get_menu($data, $v->vps_id);
 $html .= "$tab<li>";
 $html .= '<a href="#">'.$v->vps_name.'</a>';
 if ($child) {
 $i--;
 $html .= $child;
 $html .= "$tab";
 }
 $html .= '</li>';
 }
 $html .= "$tab</ul>";
 return $html;
 }
 else {
 return false;
 }
 }
 
?>