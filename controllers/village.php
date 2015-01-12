<?php
include '../lib/config.php';
include '../lib/function.php';
include '../models/village_model.php';
$page = null;
$page = (isset($_GET['page'])) ? $_GET['page'] : "list";
$title = ucfirst("Desa");

$_SESSION['menu_active'] = 1;

switch ($page) {
	case 'list':
		get_header($title);
		
		$query = select();
		$add_button = "village.php?page=form";


		include '../views/village/list.php';
		get_footer();
	break;
	
	case 'form':
		get_header();

		$close_button = "village.php?page=list";

		$id = (isset($_GET['id'])) ? $_GET['id'] : null;
		if($id){

			$row = read_id($id);

			$action = "village.php?page=edit&id=$id";
		} else{
			
			//inisialisasi
			$row = new stdClass();
			$get_code = get_village_code();

			$row->village_code = $get_code;
			$row->village_name = false;
			$row->village_description = false;

			$action = "village.php?page=save";
		}

		include '../views/village/form.php';
		get_footer();
	break;

	case 'save':

		extract($_POST);

		$i_name = get_isset($i_name);
		$i_code = get_isset($i_code);
		$i_descripton = get_isset($i_descripton);

			$data = "'',
					'$i_code', 
					'$i_name', 
					'$i_description'
			";
			
			//echo $data;

			create($data);
			edit_village_code();

			header('Location: village.php?page=list&did=1');
		
	break;

	case 'edit':

		extract($_POST);

		$id = get_isset($_GET['id']);
		$i_name = get_isset($i_name);
		$i_code = get_isset($i_code);
		$i_descripton = get_isset($i_descripton);

		
					$data = "
					village_code = '$i_code',
					village_name = '$i_name',
					village_description = '$i_descripton'
					";

			
			
			update($data, $id);
			
			header('Location: village.php?page=list&did=2');

	break;

	case 'delete':

		$id = get_isset($_GET['id']);	

		delete($id);

		header('Location: village.php?page=list&did=3');

	break;
}

?>