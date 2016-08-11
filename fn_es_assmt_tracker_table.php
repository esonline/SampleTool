<?php
	date_default_timezone_set("Asia/Calcutta");
	include("includes/login/auth.php");
	
	include("includes/data/dbinfo.inc.php");
	include_once($include_phpGrid);	
	include_once("includes/functions/gui.php");	
	include_once("includes/functions/managers.php");	
	include_once("includes/functions/ods_base.php");	
		
	print("<p><a href=\"index.php\">Index</a><p> \n");
	
		$es_conn = mysql_connect($es_hostname,$es_mysql_login,$es_mysql_pw);
		@mysql_select_db($es_database, $es_conn) or die("Could not select ES database");
			
	//Special task - ideally should've been done during assmt upload
	//Basically we need to ensure that the assmt_tracker table does have a basic rows (basic => ods_pgm_id & assmt_nr)
	//else it cannot show the Planned Month & Delivery Deadline for it's 1st-2nd-3rd Assmts!
	//prepareAssmtTrackerRowsFor(); //all rows 
		// -> moved to script_update_trackers.php which needs to run overnight!
	
	$sql= "select * from $assmt_tracker";
?>
<html>
<head>
<title>ES Assessment Tracker Table</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?php
	$dg= new C_DataGrid($sql, "sat_id", "AssmtTrackerId");
	$dg -> set_caption("ES Assmt Tracker Table"); 
	$dg -> set_dimension(2400, 800); 
	$dg -> enable_search(true);
	$dg -> enable_resize(true);
	$dg -> enable_edit("INLINE", "RU");
	$dg -> set_pagesize(1000);		

	//$dg= setChannelFilter($_POST, $dg); //$dg, the key in _GET and the fieldname for the ChId in this table/view

	$dg -> set_col_title    ("sat_id", "Id");
	$dg -> set_col_width	 ("sat_id", 70);	
			
	$dg -> set_col_title    ("sat_school_pgm_id", "Pgm_Id");
	$dg -> set_col_width	 ("sat_school_pgm_id", 70);		
	
	$dg -> set_col_title    ("sat_school_ch_id", "ChId");
	$dg -> set_col_width	 ("sat_school_ch_id", 70);		

	$dg -> set_col_title    ("sat_num_assmts_promised", "#Assmts");
	$dg -> set_col_width	 ("sat_num_assmts_promised", 100);	

	$dg -> set_col_title    ("sat_customized_rpts", "Custom_Rpts?");
	$dg -> set_col_width	 ("sat_customized_rpts", 120);	

	$dg -> set_col_title    ("sat_assmt_nr", "Assmt#");
	$dg -> set_col_width	 ("sat_assmt_nr", 90);		

	$dg -> set_col_title    ("sat_basedata_update_on", "BaseData_Updt_On");
	$dg -> set_col_width	 ("sat_basedata_update_on", 120);	

	$dg -> set_col_title    ("sat_assmt_date_planned", "Assmt_Planned_On");
	$dg -> set_col_width	 ("sat_assmt_date_planned", 90);	

	$dg -> set_col_title    ("sat_assmt_date_actual", "Assmt_Done_On");
	$dg -> set_col_width	 ("sat_assmt_date_actual", 90);		
	
	$dg -> set_col_title    ("sat_assmt_rpt_type", "Rpt_Type");
	$dg -> set_col_width	 ("sat_assmt_rpt_type", 120);	

	$dg -> set_col_title    ("sat_delivery_date_planned", "Rpt_Delivery_Planned_On");
	$dg -> set_col_width	 ("sat_delivery_date_planned", 120);	

	$dg -> set_col_title    ("sat_delivery_date_actual", "Rpt_Delivery_Done_On");
	$dg -> set_col_width	 ("sat_delivery_date_actual", 120);	

	$dg -> set_col_title    ("sat_current_status", "Current_Status");
	$dg -> set_col_width	 ("sat_current_status", 90);

	$dg -> set_col_hidden("sat_ts");	
	$dg -> set_col_readonly("sat_id, sat_school_pgm_id, sat_school_ch_id, sat_num_assmts_promised, sat_customized_rpts," .
								"sat_assmt_nr, sat_assmt_date_planned, sat_assmt_rpt_type, sat_delivery_date_planned");
	$dg -> enable_export('EXCEL');
	
	$dg -> display();
?>

</body>
</html>	