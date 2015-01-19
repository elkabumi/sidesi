<?php

function select(){
	$query = mysql_query("select * from villages where right(village_code, 4) <> '0000' order by village_id");
	return $query;
}

function read_id($id){
	$query = mysql_query("select *
			from villages 
			where village_id = '$id'");
	$result = mysql_fetch_object($query);
	return $result;
}


function create($data){
	mysql_query("insert into villages values(".$data.")");
}

function update($data, $id){
	mysql_query("update villages set ".$data." where village_id = '$id'");
}

function delete($id){
	mysql_query("delete from villages  where village_id = '$id'");
}


?>