<?php
include '../lib/config.php';
include '../lib/function.php';

$type = null;
$type = (isset($_GET['type'])) ? $_GET['type'] : "1";
$title = ucfirst("Home");

switch ($type) {
	case '1': $title = "Data Kader Posyandu"; $_SESSION['menu_active'] = 4; break;
	case '2': $title = "Data Puskesmas"; $_SESSION['menu_active'] = 5; break;
	case '3': $title = "Data Pilkada"; $_SESSION['menu_active'] = 6;  break;
	case '4': $title = "Pasar Online"; $_SESSION['menu_active'] = 7; break;
}
	
		get_header($title);
		include '../views/layout/premium.php';
		get_footer();
	

/*
$query = mysql_query("select * from m_lokasi order by l_KD");
while($row = mysql_fetch_array($query)){
	mysql_query("insert into villages values('', '".$row['l_KD']."', '".$row['l_NAMA']."', '')");
}
*/
?>