<?php

function select(){
	$query = mysql_query("SELECT a.*, b.village_code, b.village_name from village_profiles a
						JOIN villages b on b.village_id = a.village_id
						ORDER BY village_profile_id ASC");
	return $query;
}

function select_structure(){
	$query = mysql_query("SELECT a.*, b.number_type_id as number_type_id_parent, b.vps_child_separator as vps_child_separator_parent 
										   						FROM village_profile_structures a 
										   						left JOIN village_profile_structures b on b.vps_id = a.vps_parent_id 
										   						ORDER BY a.vps_parent_id, a.vps_number ASC");
	return $query;
}

function select_structure_edit($id){
	$query = mysql_query("SELECT a.*, b.number_type_id as number_type_id_parent, b.vps_child_separator as vps_child_separator_parent 
										   						FROM village_profile_details a 
										   						left JOIN village_profile_details b on b.vps_id = a.vps_parent_id and b.village_profile_id = '$id'
																WHERE a.village_profile_id = '$id'
										   						ORDER BY a.vps_parent_id, a.vps_number ASC");
	return $query;
}

function read_id($id){
	$query = mysql_query("select *
			from village_profiles 
			where village_profile_id = '$id'");
	$result = mysql_fetch_object($query);
	return $result;
}


function create_config($table, $data){
	mysql_query("insert into $table values(".$data.")");
}

function update_config($table, $data, $id, $param){
	mysql_query("update $table set ".$data." where $param = '$id'");
}

function delete($id){
	mysql_query("delete from village_profiles  where village_profile_id = '$id'");
	mysql_query("delete from village_profile_details  where village_profile_id = '$id'");
}
function get_child($id){
	$query = mysql_query("select count(vps_id) as result
							from village_profile_structures
						where vps_parent_id = '".$id."'");
	$result = mysql_fetch_array($query);
	$row = $result['result'];
	return $row;
}

function check_save($village_id){
	$query = mysql_query("select count(village_id) as result
							from village_profiles
						where village_id = '".$village_id."'");
	$result = mysql_fetch_array($query);
	$row = $result['result'];
	return $row;
}

function get_village_old($id){
	$query = mysql_query("select village_id
							from village_profiles
						where village_profile_id = '".$id."'");
	$result = mysql_fetch_array($query);
	$row = $result['village_id'];
	return $row;
}

function check_edit($village_id, $village_old){
	$query = mysql_query("select count(village_id) as result
							from village_profiles
						where village_id = '".$village_id."' and village_id <> $village_old");
	$result = mysql_fetch_array($query);
	$row = $result['result'];
	return $row;
}


?>