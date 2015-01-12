<?php
include '../lib/config.php';
include '../lib/function.php';
include '../models/village_monograph_structure_model.php';
$page = null;
$page = (isset($_GET['page'])) ? $_GET['page'] : "list";
$title = ucfirst("Struktur Monografi Desa");

$_SESSION['menu_active'] = 1;

switch ($page) {
	case 'list':
		get_header($title);
		
		$total_level = get_total_level();
		
		
		$query = select();
		$add_button = "village_monograph_structure.php?page=form";


		include '../views/village_monograph_structure/list.php';
		get_footer();
	break;
	
	case 'form':
		get_header();
		
		


		$close_button = "village_monograph_structure.php?page=list";

		$id = (isset($_GET['id'])) ? $_GET['id'] : null;
		if($id){
			$title = ucfirst("Edit Struktur Monografi Desa");
			$row = read_id($id);
			
			$action = "village_monograph_structure.php?page=edit&id=$id";
		} else{
			$title = ucfirst("Tambah Struktur Monografi Desa");
			//inisialisasi
			$row = new stdClass();
			
			$row->number_type_id = false;
			$row->vms_child_separator = false;
			$row->vms_name = false;

			$action = "village_monograph_structure.php?page=save";
		}

		include '../views/village_monograph_structure/form.php';
		get_footer();
	break;
	
	case 'form_child':
		get_header();
		
		


		$close_button = "village_monograph_structure.php?page=list";

		$id = (isset($_GET['id'])) ? $_GET['id'] : null;
		if($id){
			$title = ucfirst("Tambah Struktur Monografi Desa");
			
			$row = read_id($id);
			
			$action = "village_monograph_structure.php?page=edit&id=$id";
		} else{
			$title = ucfirst("Edit Struktur Monografi Desa");
			//inisialisasi
			$row = new stdClass();
			
			$id_parent = (isset($_GET['id_parent'])) ? $_GET['id_parent'] : null;
			$get_parent = get_parent_name($id_parent);
			
			$row->number_type_id = false;
			$row->vms_child_separator = false;
			$row->vms_parent_name = $get_parent['vms_name'];
			$row->vms_name = false;

			$action = "village_monograph_structure.php?page=save_child&id_parent=$id_parent";
		}

		include '../views/village_monograph_structure/form_child.php';
		get_footer();
	break;

	case 'save':
	
		$parent_number = get_parent_number();
		
		extract($_POST);

		$i_name = get_isset($i_name);
		$i_number_type_id = get_isset($i_number_type_id);
		$i_child_separator = get_isset($i_child_separator);
		
			$data = "'',
					'0', 
					'1',
					'$i_number_type_id', 
					'$i_child_separator', 
					'$parent_number', 
					'$i_name'
			";
		
			create($data);
			header('Location: village_monograph_structure.php?page=list&did=1');
		
	
	break;
	
	case 'save_child':
	
		
		$id_parent = (isset($_GET['id_parent'])) ? $_GET['id_parent'] : null;
		$get_parent = get_parent_name($id_parent);
		$level = $get_parent['vms_level'] + 1;
		$vms_number = get_vms_number($id_parent);
		
		extract($_POST);

		$i_name = get_isset($i_name);
		$i_number_type_id = get_isset($i_number_type_id);
		$i_child_separator = get_isset($i_child_separator);
		
			$data = "'',
					'$id_parent', 
					'$level',
					'$i_number_type_id', 
					'$i_child_separator', 
					'$vms_number', 
					'$i_name'
			";
		
			create($data);
			header('Location: village_monograph_structure.php?page=list&did=1');
		
	
	break;

	case 'edit':
	
		$id = get_isset($_GET['id']);	

		extract($_POST);

		$i_name = get_isset($i_name);
		$i_number_type_id = get_isset($i_number_type_id);
		$i_child_separator = get_isset($i_child_separator);
	
		
			$data = " number_type_id = '$i_number_type_id',
					vms_child_separator = '$i_child_separator',
					vms_name = '$i_name'
					";
			
			update($data, $id);
			
			header('Location: village_monograph_structure.php?page=list&did=2');

	break;

	case 'delete':

		$id = get_isset($_GET['id']);	

		delete($id);

		header('Location: village_monograph_structure.php?page=list&did=3');

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

               $class = empty($child) ? "unchild" : "has_child";
				
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
			   
               $tx.= "<td>$me[vms_level]</td><td>$total_spasi$number$separator$me[vms_name]</td>";
			   
			   $tx .= "<td style='text-align:center;'>
  <a href='village_monograph_structure.php?page=form_child&id_parent=$me[vms_id]' class='btn btn-default' >Add Child</a>
                                                <a href='village_monograph_structure.php?page=form&id=$me[vms_id]' class='btn btn-default' ><i class='fa fa-pencil'></i></a>
                                                <a href=\"javascript:void(0)\" onclick=\"confirm_delete($me[vms_id], 'village_monograph_structure.php?page=delete&id=')\" class='btn btn-default' ><i class='fa fa-trash-o'></i></a>
                                                </td>";
			   
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