<?php

function get_child($id){
	$query = mysql_query("select count(vps_id) as result from village_profile_structures where vps_parent_id = '$id'");
	$result = mysql_fetch_array($query);
	
	return $result['result'];
}

function get_total_level(){
	$query = mysql_query("select max(vps_level) as result from village_profile_structures");
	$result = mysql_fetch_array($query);
	
	return $result['result'];
}

function get_parent_number(){
	$query = mysql_query("select max(vps_number) as result from village_profile_structures where vps_level = '1'");
	$result = mysql_fetch_array($query);
	
	return $result['result'] + 1;
}

function get_vps_number($parent_id){
	$query = mysql_query("select max(vps_number) as result from village_profile_structures where vps_parent_id = '$parent_id'");
	$result = mysql_fetch_array($query);
	
	return $result['result'] + 1;
}

function get_parent_name($id){
	$query = mysql_query("select * from village_profile_structures where vps_id = '$id'");
	$result = mysql_fetch_array($query);
	
	return $result;
}

function select(){
	$query = mysql_query("SELECT a.*, b.number_type_id as number_type_id_parent, b.vps_child_separator as vps_child_separator_parent 
										   						FROM village_profile_structures a 
										   						left JOIN village_profile_structures b on b.vps_id = a.vps_parent_id 
										   						ORDER BY a.vps_parent_id, a.vps_number ASC");
	return $query;
}

function read_id($id){
	$query = mysql_query("select *
			from village_profile_structures 
			where vps_id = '$id'");
	$result = mysql_fetch_object($query);
	return $result;
}


function create($data){
	mysql_query("insert into village_profile_structures values(".$data.")");
}

function update($data, $id){
	mysql_query("update village_profile_structures set ".$data." where vps_id = '$id'");
}

function delete($id){
	mysql_query("delete from village_profile_structures  where vps_id = '$id'");
}
function cek_name_login($name){
	$query = mysql_query("select count(village_profile_structure_id)
							from village_profile_structures 
						where village_profile_structure_login = '".$name."'");
	$result = mysql_fetch_array($query);
	$row = $result['0'];
	return $row;
}

function get_jumlah_data(){
	$query = mysql_query("select count(vps_id) as jumlah_data from village_profile_structures");
	$result = mysql_fetch_array($query);
	$row = $result['jumlah_data'];
	return $row;
}

?>