<?php
include '../lib/config.php';
include '../lib/function.php';
include '../models/village_monograph_model.php';
$page = null;
$page = (isset($_GET['page'])) ? $_GET['page'] : "list";
$title = ucfirst("Monografi Desa");

$_SESSION['menu_active'] = 1;

switch ($page) {
	case 'list':
		get_header($title);

		$query = select();
		$add_button = "village_monograph.php?page=form";

		include '../views/village_monograph/list.php';
		get_footer();
	break;
	
	case 'form':
		get_header();
		
		$close_button = "village_monograph.php?page=list";

		$id = (isset($_GET['id'])) ? $_GET['id'] : null;
		
		if($id){
			$title = ucfirst("Edit Monografi Desa");
			$row = read_id($id);
			$query = select_structure_edit($id);
			
			$action = "village_monograph.php?page=edit&id=$id";
		} else{
			$title = ucfirst("Tambah Monografi Desa");
			//inisialisasi
			$row = new stdClass();
			$query = select_structure();
			
			$row->village_id = false;

			$action = "village_monograph.php?page=save";
		}

		include '../views/village_monograph/form.php';
		get_footer();
	break;
	
	
	case 'save':
	
		extract($_POST);

		$i_village_id = get_isset($i_village_id);
		$date = date("Y-m-d");
		
		$check_save = check_save($i_village_id);
		if($check_save > 0 ){

			header('Location: village_monograph.php?page=form&err=1');

		}else{

			$data = "'',
					'$i_village_id',
					'$date', 
					'$date', 
					''
			";
		
		create_config("village_monographs", $data);
		$village_monograph_id = mysql_insert_id();	
		
		$query = select_structure();
		while($row = mysql_fetch_array($query)){
			$get_child = get_child($row['vms_id']);
			
			if($get_child == 0){
				$field = $_POST["i_field_".$row['vms_id']];
			}else{
				$field = "";
			}
			
				$data_detail = "
									'".$row['vms_id']."',
									'$village_monograph_id',
									'".$row['vms_parent_id']."',
									'".$row['vms_level']."',
									'".$row['number_type_id']."',
									'".$row['vms_child_separator']."',
									'".$row['vms_number']."',
									'".$row['vms_name']."',
									'$field'
									";
				create_config("village_monograph_details", $data_detail);
		} 
			
			
			header('Location: village_monograph.php?page=list&did=1');
		
		}
	break;
	

	case 'edit':
	
		$id = get_isset($_GET['id']);
		extract($_POST);

		$i_village_id = get_isset($i_village_id);
		$date = date("Y-m-d");
		
		$get_village_old = get_village_old($id);

		echo $i_village_id."-".$get_village_old;
		
		if($i_village_id != $get_village_old){
			$check_edit = check_edit($i_village_id, $get_village_old);
		}else{
			$check_edit = 0;
		}
			if($check_edit > 0 ){
				header("Location: village_monograph.php?page=form&id=$id&err=1");

			}else{

			$data = "
					village_id = '$i_village_id',
					village_monograph_updated_date = '$date'
			";
		
			update_config("village_monographs", $data, $id, "village_monograph_id");
			
			$query = select_structure_edit($id);
			while($row = mysql_fetch_array($query)){
				$get_child = get_child($row['vms_id']);
				
				if($get_child == 0){
					$field = $_POST["i_field_".$row['vms_id']];
				}else{
					$field = "";
				}
				
					$data_detail = "
										vms_answer = '$field'
										";
					update_config("village_monograph_details", $data_detail, $row['vms_id'], "vms_id");
			} 
				
				
				header('Location: village_monograph.php?page=list&did=2');
			}

	break;

	case 'delete':

		$id = get_isset($_GET['id']);	

		delete($id);

		header('Location: village_monograph.php?page=list&did=3');

	break;
}

function my_parent($id) {
     global $tree;
     $tx = "";
     foreach($tree as $v){
          if($v['vms_parent_id'] == $id){
               $me = $v;
               unset($tree[$v['vms_id']]);
               $child = my_parent($me['vms_id']);

               $total_spasi = "";
			   for($spasi=2; $spasi<=$me['vms_level']; $spasi++){
				 
			   		$total_spasi .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				  
			   }
               $tx.= "<tr>";
			   
			   $number = "";
			   if($me['vms_level'] > 1)
			   {
					$urut = get_urutan("village_monograph_structures", "vms_id", " vms_parent_id = '".$me['vms_parent_id']."' and vms_number < '". $me['vms_number']."'");
					if($me['number_type_id_parent'] == 1){ $number =  $urut; }
					else if($me['number_type_id_parent'] == 2){ $number = get_abjad_besar($urut); }
					else if($me['number_type_id_parent'] == 3){ $number = get_abjad($urut); }
			   }
			   $me['vms_child_separator_parent'] = ($me['vms_child_separator_parent']) ? $me['vms_child_separator_parent'] : '';
			   
			   $separator = $me['vms_child_separator_parent']." ";
			   
			   $get_child = get_child($me['vms_id']);
			   
			   if($get_child > 0){
				   $textfield = "";
			   }else{
				   $textfield = "<input type='text' name='i_field_$me[vms_id]' class='form-control' />";
			   }
			   
               $tx.= "<td width='50%'>$total_spasi$number$separator$me[vms_name]</td>";
			   
			   $tx .= "<td style='text-align:center;'>";
			   $tx .= $textfield;
               $tx .= "</td>";
			   $tx.= "</td>";
               $tx.= $child;
               $tx.= "</tr>";
          }
     }
     if(!empty($tx)){
          $cl = $id > 0 ? " class='child'" : "";
          return $tx;
     }
     return "";
}

function my_parent_edit($id) {
     global $tree;
     $tx = "";
     foreach($tree as $v){
          if($v['vms_parent_id'] == $id){
               $me = $v;
               unset($tree[$v['vms_id']]);
               $child = my_parent_edit($me['vms_id']);

               $total_spasi = "";
			   for($spasi=2; $spasi<=$me['vms_level']; $spasi++){
				 
			   		$total_spasi .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				  
			   }
               $tx.= "<tr>";
			   
			   $number = "";
			   if($me['vms_level'] > 1)
			   {
					$urut = get_urutan("village_monograph_structures", "vms_id", " vms_parent_id = '".$me['vms_parent_id']."' and vms_number < '". $me['vms_number']."'");
					if($me['number_type_id_parent'] == 1){ $number =  $urut; }
					else if($me['number_type_id_parent'] == 2){ $number = get_abjad_besar($urut); }
					else if($me['number_type_id_parent'] == 3){ $number = get_abjad($urut); }
			   }
			   $me['vms_child_separator_parent'] = ($me['vms_child_separator_parent']) ? $me['vms_child_separator_parent'] : '';
			   
			   $separator = $me['vms_child_separator_parent']." ";
			   
			   $get_child = get_child($me['vms_id']);
			   
			   if($get_child > 0){
				   $textfield = "";
			   }else{
				   $textfield = "<input type='text' name='i_field_$me[vms_id]' class='form-control' value='$me[vms_answer]' />";
			   }
			   
               $tx.= "<td width='50%'>$total_spasi$number$separator$me[vms_name]</td>";
			   
			   $tx .= "<td style='text-align:center;'>";
			   $tx .= $textfield;
               $tx .= "</td>";
			   $tx.= "</td>";
               $tx.= $child;
               $tx.= "</tr>";
          }
     }
     if(!empty($tx)){
          $cl = $id > 0 ? " class='child'" : "";
          return $tx;
     }
     return "";
}

?>