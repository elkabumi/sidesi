<?php

function select(){
	$query = mysql_query("SELECT a.*, b.village_code, b.village_name from village_monographs a
						JOIN villages b on b.village_id = a.village_id
						ORDER BY village_monograph_id ASC");
	return $query;
}

function get_period($id){
	$query = mysql_query("SELECT * from village_monograph_periods 
						  where village_monograph_id = '".$id."'");
	return $query;
}

function select_structure(){
	$query = mysql_query("SELECT a.*, b.number_type_id as number_type_id_parent, b.vms_child_separator as vms_child_separator_parent 
										   						FROM village_monograph_structures a 
										   						left JOIN village_monograph_structures b on b.vms_id = a.vms_parent_id 
										   						ORDER BY a.vms_parent_id, a.vms_number ASC");
	return $query;
}

function select_structure_edit($id){
	$query = mysql_query("SELECT a.*, b.number_type_id as number_type_id_parent, b.vms_child_separator as vms_child_separator_parent 
										   						FROM village_monograph_details a 
										   						left JOIN village_monograph_details b on b.vms_id = a.vms_parent_id and b.vmp_id = '$id'
																WHERE a.vmp_id = '$id'
										   						ORDER BY a.vms_parent_id, a.vms_number ASC");
	return $query;
}

function read_id($id){
	$query = mysql_query("select *
			from village_monographs 
			where village_monograph_id = '$id'");
	$result = mysql_fetch_object($query);
	return $result;
}

function read_id_period($id){
	$query = mysql_query("select *
			from village_monograph_periods 
			where vmp_id = '$id'");
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
	mysql_query("delete from village_monographs  where village_monograph_id = '$id'");
	mysql_query("delete from village_monograph_details  where village_monograph_id = '$id'");
}

function delete_village_monograph_detail($id){
	mysql_query("delete from village_monograph_details  where vmp_id = '$id'");
}

function get_child($id){
	$query = mysql_query("select count(vms_id) as result
							from village_monograph_structures
						where vms_parent_id = '".$id."'");
	$result = mysql_fetch_array($query);
	$row = $result['result'];
	return $row;
}

function check_save($village_id){
	$query = mysql_query("select count(village_id) as result
							from village_monographs 
						where village_id = '".$village_id."'");
	$result = mysql_fetch_array($query);
	$row = $result['result'];
	return $row;
}

function check_double($village_id,$type_id){
	$query = mysql_query("select count(village_id) as result
							from village_monographs a
							join village_monograph_periods b on b.village_monograph_id = a.village_monograph_id
						where a.village_id = '".$village_id."' and b.vmp_year = '".$type_id."'");
	$result = mysql_fetch_array($query);
	$row = $result['result'];
	return $row;
}

function get_village_old($id){
	$query = mysql_query("select a.village_id 
							from village_monographs a
							join village_monograph_periods b on b.village_monograph_id = a.village_monograph_id
						where b.vmp_id = '".$id."'");
	$result = mysql_fetch_array($query);
	$row = $result['village_id'];
	return $row;
}

function get_village_profil_id($village_id){
	$query = mysql_query("select village_monograph_id
							from village_monographs 
						where village_id = '".$village_id."'");
	$result = mysql_fetch_array($query);
	$row = $result['village_monograph_id'];
	return $row;
}

function check_edit($village_id, $village_old){
	$query = mysql_query("select count(village_id) as result
							from village_monographs
						where village_id = '".$village_id."' and village_id <> $village_old");
	$result = mysql_fetch_array($query);
	$row = $result['result'];
	return $row;
}

function get_village_data($id){
	$query = mysql_query("select a.village_id, village_name
						from village_monographs a
						join villages b on b.village_id = a.village_id
						where village_monograph_id = '$id'
						");
	$result = mysql_fetch_array($query);

	return $result;
}


?>