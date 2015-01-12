<?php

function get_child($id){
	$query = mysql_query("select count(vms_id) as result from village_monograph_structures where vms_parent_id = '$id'");
	$result = mysql_fetch_array($query);
	
	return $result['result'];
}

function get_total_level(){
	$query = mysql_query("select max(vms_level) as result from village_monograph_structures");
	$result = mysql_fetch_array($query);
	
	return $result['result'];
}

function get_parent_number(){
	$query = mysql_query("select max(vms_number) as result from village_monograph_structures where vms_level = '1'");
	$result = mysql_fetch_array($query);
	
	return $result['result'] + 1;
}

function get_vms_number($parent_id){
	$query = mysql_query("select max(vms_number) as result from village_monograph_structures where vms_parent_id = '$parent_id'");
	$result = mysql_fetch_array($query);
	
	return $result['result'] + 1;
}

function get_parent_name($id){
	$query = mysql_query("select * from village_monograph_structures where vms_id = '$id'");
	$result = mysql_fetch_array($query);
	
	return $result;
}

function select(){
	$query = mysql_query("SELECT a.*, b.number_type_id as number_type_id_parent, b.vms_child_separator as vms_child_separator_parent 
										   						FROM village_monograph_structures a 
										   						left JOIN village_monograph_structures b on b.vms_id = a.vms_parent_id 
										   						ORDER BY a.vms_parent_id, a.vms_number ASC");
	return $query;
}

function read_id($id){
	$query = mysql_query("select *
			from village_monograph_structures 
			where vms_id = '$id'");
	$result = mysql_fetch_object($query);
	return $result;
}


function create($data){
	mysql_query("insert into village_monograph_structures values(".$data.")");
}

function update($data, $id){
	mysql_query("update village_monograph_structures set ".$data." where vms_id = '$id'");
}

function delete($id){
	mysql_query("delete from village_monograph_structures  where vms_id = '$id'");
}
function cek_name_login($name){
	$query = mysql_query("select count(village_monograph_structure_id)
							from village_monograph_structures 
						where village_monograph_structure_login = '".$name."'");
	$result = mysql_fetch_array($query);
	$row = $result['0'];
	return $row;
}

function get_jumlah_data(){
	$query = mysql_query("select count(vms_id) as jumlah_data from village_monograph_structures");
	$result = mysql_fetch_array($query);
	$row = $result['jumlah_data'];
	return $row;
}

?>