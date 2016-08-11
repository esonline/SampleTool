<?php
error_reporting(E_ERROR);
if(isset($_GET['coverageId'])){
include 'includes/data/dbinfo.inc.php';
include_once 'includes/functions/dbutils.php';
$coverage_id = $_GET['coverageId'];
$selected_Sports_String = $_GET['SportsString'];
$selected_Sports_array = explode(",",$selected_Sports_String);
$coverage_sport_res = doSelect($inv_coverage_sport_prop_count_view, " WHERE Coverage_Id = '$coverage_id' ORDER BY Sport_Name");
if($coverage_sport_res!='' && $coverage_sport_res!='-1'){
	$sport_chkbox = "chkSport_";
	$chk_box_name = "chkSport[]";
	$chk_id = 1;
	$chk_box_html = "";
	$sports_ids_array = array();
	while($each_coverage_sport_value_row = mysql_fetch_assoc($coverage_sport_res)){
		$sport_chkbox_id = $sport_chkbox.$chk_id;
		$sport_id = $each_coverage_sport_value_row['Sport_Id'];
		if(!in_array($sport_id, $sports_ids_array)){
		$sports_ids_array[] = $sport_id;
		$sport_name = $each_coverage_sport_value_row['Sport_Name'];
		if(is_array($selected_Sports_array) && in_array($sport_id, $selected_Sports_array)){
			$checked_status = "checked";
		}
		else{
			$checked_status = "";
		}
		$chk_box_html .= '<input type="checkbox" name="'.$chk_box_name.'" id="'.$sport_chkbox_id.'" value="'.$sport_id.'" '.$checked_status.'/>&nbsp;'.$sport_name.' &nbsp;&nbsp;';
		$chk_id++;
		}
	}
}
echo "$chk_box_html";
}
?>