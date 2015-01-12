<?php

$cont = mysql_connect("localhost", "root", "");
$sel = mysql_select_db("sidesi");

$qtree = mysql_query("SELECT * FROM `village_profile_structures` ORDER BY `vps_parent_id`, `vps_id` ASC");

while(false !== $tr = mysql_fetch_assoc($qtree))
     if(!empty($tr))
          $tre[] = $tr;

global $tree;
foreach($tre as $v)
     $tree[$v['vps_id']] = $v;
$tx = "";
$tx.= my_parent(0);

function my_parent($id) {
     global $tree;
     $tx = "";
     foreach($tree as $v){
          if($v['vps_parent_id'] == $id){
               $me = $v;
               unset($tree[$v['vps_id']]);
               $child = my_parent($me['vps_id']);

               $class = empty($child) ? "unchild" : "has_child";

               $tx.= "<li class='$class'>";
               $tx.= "<a href='index.php#' title='$me[vps_name]'>$me[vps_name]</a>";
               $tx.= $child;
               $tx.= "</li>";
          }
     }
     if(!empty($tx)){
          $cl = $id > 0 ? " class='child'" : "";
          return "<ul$cl>$tx</ul>";
     }
     return "";
}