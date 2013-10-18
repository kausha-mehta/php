<?
function connect_db()
{
	global $ARR_CFGS;
	if (!isset($GLOBALS['dbcon'])) {
		$GLOBALS['dbcon'] =	mysql_connect($ARR_CFGS["db_host"], $ARR_CFGS["db_user"], $ARR_CFGS["db_pass"]);
		mysql_select_db($ARR_CFGS["db_name"]) or die("Could not connect to database");
	}
}
function db_scalar($sql, $dbcon2 = null)
{
	if($dbcon2 ==''){
		$dbcon2	= $GLOBALS['dbcon'];
	}
	$result	= mysql_query($sql,	$dbcon2) or	die(db_error($sql));
	if ($line =	mysql_fetch_array($result))	{
		$response =	$line[0];
	}
	return $response;
}



function db_total_records($sql, $dbcon2 = null)
{
	if($dbcon2 ==''){
		$dbcon2	= $GLOBALS['dbcon'];
	}
	$result	= mysql_query($sql,	$dbcon2) or	die("<center>An	Internal Error has Occured.	Please report following error	to the webmaster.<br><br>" . $sql .	"<br><br>" . mysql_errno() . ':	' .	mysql_error() . "</center>");
	return mysql_num_rows($result);
}

function db_error($sql)
{
	return "<span style='FONT-SIZE:11px; FONT-COLOR: #000000; font-family=tahoma;'><center>An	Internal Error has Occured.	Please report following	error to the webmaster.<br><br>"	. $sql . "<br><br>"	. mysql_errno()	. ': ' . mysql_error() . "</center></FONT>";
}


function apply_filter($sql,	$field,	$field_filter, $column)
{
	if (!empty($field))	{
		if ($field_filter == "=" || $field_filter == "") {
			$sql = $sql	. "	and	$column	= '$field' ";
		} else if ($field_filter == "like")	{
			$sql = $sql	. "	and	$column	like '%$field%'	";
		} else if ($field_filter ==	"starts_with") {
			$sql = $sql	. "	and	$column	like '$field%' ";
		} else if ($field_filter ==	"ends_with") {
			$sql = $sql	. "	and	$column	like '%$field' ";
		} else if ($field_filter ==	"not_contains")	{
			$sql = $sql	. "	and	$column	not	like '%$field%'	";
		} else if ($field_filter ==	"!=") {
			$sql = $sql	. "	and	$column	!= '$field'	";
		}
	}
	return $sql;
}
function filter_dropdown($name	= 'filter',	$sel_value, $extra)
{
	$arr = array( "like" => 'Contains', '=' => 'Is', "starts_with" => 'Starts with', "ends_with"	=> 'Ends with', "!=" => 'Is not' , "not_contain" => 'Not contains');
	return array_dropdown($arr, $sel_value, $name, $extra);
}


function move_up($table_name, $where_clause_all, $where_clause_item, $sort_order, $move_by)
{
	$dest_order	= $sort_order -	$move_by;
	// $arr_ids_to_move=Array();
	// echo	"<br>$movie_artist_id, $movie_id, $artistcate_id, $sort_order, $move_by, $dest_order<br>";
	for($i = $sort_order-1;	$i > $dest_order-1;	$i--) {
		$sql = " update	$table_name	set	sort_order=sort_order+1	where $where_clause_all	and	sort_order='$i'";
		// echo	"<br>$sql<br>";
		mysql_query($sql) or die(db_error($sql));
	}
	$sql = " update	$table_name	set	sort_order=sort_order-$move_by where $where_clause_item";
	// echo	"<br>$sql<br>";
	mysql_query($sql) or die(db_error($sql));
}

function move_down($table_name,	$where_clause_all, $where_clause_item, $sort_order,	$move_by)
{
	$dest_order	= $sort_order +	$move_by;
	// $arr_ids_to_move=Array();
	// echo	"<br>$movie_artist_id, $movie_id, $artistcate_id, $sort_order, $move_by, $dest_order<br>";
	for($i = $sort_order + 1; $i < $dest_order + 1;	$i++) {
		$sql = " update	$table_name	set	sort_order=sort_order-1	where $where_clause_all	and	sort_order='$i'	";
		// echo	"<br>$sql<br>";
		mysql_query($sql) or die(db_error($sql));
	}
	$sql = " update	$table_name	set	sort_order=sort_order+$move_by where $where_clause_item";
	// echo	"<br>$sql<br>";
	mysql_query($sql) or die(db_error($sql));
}

function refine_list($id_column, $table_name, $where_clause)
{
	$sql = " select	$id_column,	sort_order from	$table_name	where $where_clause	order by sort_order";
	// echo	"<br>$sql<br>";
	$result	= mysql_query($sql) or die(db_error($sql));
	$i = 1;
	while ($line = mysql_fetch_array($result)) {
		$sql = " update	$table_name	set	sort_order='$i'	where $id_column='$line[0]'";
		// echo	"<br>$sql<br>";
		mysql_query($sql) or die(db_error($sql));
		$i++;
	}
}

function make_url($url)
{
	$parsed_url	= parse_url($url);
	if ($parsed_url['scheme'] == '') {
		return 'http://' . $url;
	} else {
		return $url;
	}
}


function date_to_mysql($date)
{
	list($month, $day, $year) = explode('/', $date);
	return "$year-$month-$day";
}



function readable_col_name($str) 
{
	return ucwords( str_replace('_', ' ', strtolower($str) ) );
}

function m_echo($str) {
	if(LOCAL_MODE){
		echo($str);
	}
}


function pagesize_dropdown($name, $value)
{
	$arr = array('10'=>'10','25'=>'25','50'=>'50','100'=>'100');
	$m = $_GET;
	unset($m['pagesize']);
	return array_dropdown($arr, $value , $name,  '  onchange="location.href=\''.$_SERVER['PHP_SELF'].qry_str($m).'&pagesize=\'+this.value" ');
}

function qry_str($arr, $skip = '')
{
	$s = "?";
	$i = 0;
	foreach($arr as	$key =>	$value)	{
		if ($key !=	$skip) {
			if (is_array($value)) {
				foreach($value as $value2) {
					if ($i == 0) {
						$s .= $key . '[]=' . $value2;
						$i = 1;
					} else {
						$s .= '&' .	$key . '[]=' . $value2;
					}
				}
			} else {
				if ($i == 0) {
					$s .= "$key=$value";
					$i = 1;
				} else {
					$s .= "&$key=$value";
				}
			}
		}
	}
	return $s;
}

function ms_form_value($var)
{
	return is_array($var) ? array_map('ms_form_value', $var) : htmlspecialchars(stripslashes(trim($var)));
}

function ms_display_value($var)
{
	return is_array($var) ? array_map('ms_display_value', $var) : nl2br(stripslashes(trim($var)));
}

function ms_stripslashes($var)
{
	return is_array($var) ? array_map('ms_stripslashes', $var) : stripslashes(trim($var));
}

function ms_addslashes($var)
{
	return is_array($var) ? array_map('ms_addslashes', $var) : addslashes(trim($var));
}

function ms_trim($var)
{
	return is_array($var) ? array_map('ms_trim', $var) : trim($var);
}


function make_dropdown($sql, $combo_name, $sel_value =	'',	$extra = '', $choose_one = '')
{
	$result	= mysql_query($sql) or die(db_error($sql));
	if (mysql_num_rows($result)	> 0) {
		$str_dropdown = "<select name='$combo_name' id='$combo_name' $extra>";

		if ($choose_one	!= '') {
			// if($css== "opt1"){ $css='opt2';}else{$css='opt1';};
			$str_dropdown .= "<option value=''>$choose_one</option>";
		}
		while	($line = mysql_fetch_array($result)) {
			// if($css== "opt1"){ $css='opt2';}else{$css='opt1';};
			$str_dropdown .= "<option value=\"" . ms_form_value($line[0]) . "\"";
			if ($sel_value == $line[0])	{
				$str_dropdown .= "	selected ";
			}
			$str_dropdown .= ">" .	$line[1] . "</option>";
		}
		$str_dropdown .= "</select>";
	}
	return $str_dropdown;
}

function array_dropdown( $arr, $sel_value='', $name='', $extra='', $choose_one='', $arr_skip= array())
{
	$combo="<select name='$name' id='$name' $extra >";
	if($choose_one!=''){
		$combo.="<option value=\"\">$choose_one</option>";
	}
	foreach($arr as $key => $value)
	{
		if(is_array($arr_skip) && in_array($key, $arr_skip)) {
			continue;
		}
		$combo.='<option value="'.htmlspecialchars($key).'"';
		if(is_array($sel_value)) {
			if(in_array($key, $sel_value) || in_array(htmlspecialchars($key), $sel_value)) {
				$combo.=" selected ";
			}
		} else {
			if($sel_value==$key || $sel_value==htmlspecialchars($key)) {
				$combo.=" selected ";
			}
		}
		$combo.=" >$value</option>";
	}
	$combo.=" </select>";
	return $combo;
}


function sort_arrows($column)
{
	return '<A HREF="' . $_SERVER['PHP_SELF'] .	get_qry_str(array('order_by', 'order_by2'),	array($column, 'asc')) . '"><img src="images/up_arrow.gif" border="0"></a>	<a href="'	. $_SERVER['PHP_SELF'] . get_qry_str(array('order_by', 'order_by2'), array($column,	'desc')) . '"><img src="images/down_arrow.gif" border="0"></a>';
}

function select_option($s, $s1)
{
	if ($s == $s1) {
		echo " selected	";
	}
}




//########### Change Order ##########//
function change_order($cat_id,$question_id,$new_order,$id,$type,$is_ques_page=0)
{		
		if($cat_id!='' && $is_ques_page==1)	{
			$id_head = "forum_cat_id"; //cat_id to forum_cat_id column name
			$id_head_value = $cat_id;
		}
		else{
			$id_head = "forum_cat_id"; //question_id to forum_sub_cat_id column name
		
			$id_head_value = $cat_id;
		}

	if ($type=='frm_sub_cat_list')
	{
		$table_name = "liq_frm_sub_cat";
		$col1       = "cat_order";
		$col2       = "forum_sub_cat_id";
	}
	else if ($type=='frm_category_list')						
	{
		$table_name = "liq_frm_cat";
		$col1       = "cat_order";
		$col2       = "forum_cat_id";
		$id_head    = "";
		$id_head_value = "";
	}
	else if ($type=='topic_list')
	{
		$table_name = "liq_frm_topic";
		$col1       = "cat_order";
		$col2       = "topic_id";
		$id_head    = "";
		$id_head_value = "";
	}

	else if ($type=='category_list')
	{
		$table_name = "liq_category";
		$col1       = "cat_order";
		$col2       = "cat_id";
		$id_head    = "";
		$id_head_value = "";
	}
	else if ($type=='videos_list')
	{
		$table_name = "liq_videos";
		$col1       = "cat_order";
		$col2       = "vid_id";
		$id_head    = "";
		$id_head_value = "";
	}

	$sql = " select $col1 from $table_name where $col2='$id' ";
	$order_old=getsingleresult($sql);
	$order_old;
	$new_order;
	if(intval($order_old)>intval($new_order))
	{
		$sql= "select $col1,$col2 from $table_name where $col1 >='$new_order' and $col1<'$order_old' ";
		if($id_head_value!='' && $id_head!='') { 
			$sql .= " and $id_head ='$id_head_value' ";
		}
		$sql .= " order by $col1 asc ";
		$result=executeQuery($sql);
		while($line = mysql_fetch_array($result))
		{
			$orderx = $line[$col1];
			$idx	 = $line[$col2];
			$orderx++;
			 $sql="update $table_name set $col1='$orderx' where $col2= '$idx'";
			mysql_query($sql);
		}
	}
	else
	{
		$sql= "select $col1,$col2 from $table_name where $col1>$order_old  and $col1<=$new_order ";
		if($id_head_value!='' && $id_head!='') { 
			$sql .= " and $id_head ='$id_head_value' ";
		}
		$sql .= " order by $col1 asc ";
		$result=executeQuery($sql);
		while($line = mysql_fetch_array($result))
		{
			$orderx  = $line[$col1];
			$idx	 = $line[$col2];
			$orderx--;
			$sql="update $table_name set $col1='$orderx' where $col2= '$idx'";
			mysql_query($sql);
	}
	}
	
	$sql= "update $table_name set $col1='$new_order' where $col2='$id'";
	mysql_query($sql);
	
}


?>
