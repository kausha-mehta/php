<?php

//	Add New Record Start
if(isset($_POST['Submit_g']) && $_GET['id']=='')
		{
		if($name!='')
		{
					$sql="insert into user set 
						name='$name',
						email='$email',
						add_date=now()";
					$res=mysql_query($sql) or die(mysql_error());
			$_SESSION['SESS_MSG']= $j.' Record Added Successfully!';
			header("Location: index.php");
			exit;
			
		}else{
		      $_SESSION['SESS_MSG']='Please Enter All Information !';
			  header("Location: index.php");
			  exit;
			  }	
			  }
			  
			  

//	Update Record Start
if(isset($_POST['Submit_g']) && $_GET['id']!='')
		{
		if($name!='')
		{
			mysql_query("update user set name='$name',email='$email',mod_date=now() where id='$id'");	
			$_SESSION['SESS_MSG']='Record Successfully Save !';
			header("Location: index.php");
			  exit;
		}else{
		      $_SESSION['SESS_MSG']='Please Enter Heading !';
			  header("Location: index.php?id=".$_GET['id']);
			  exit;
			  }	
			  }


 if($_GET['did']!='')
 {
 		mysql_query("delete from user where id='$did'");
		$_SESSION['SESS_MSG'] = " Record Successfully Delete";
		header("Location:index.php");
		exit;
 }







//	Fetch Record Start

$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";

$sql = "from user where 1 ";
$order_by == '' ? $order_by = 'add_date' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql .= "order by $order_by $order_by2 ";
$sql_count = "select count(*) ".$sql; 
$sql .= "limit $start, $pagesize ";
$sql = $columns.$sql;
$result = mysql_query($sql) or die(db_error($sql));
$rows = mysql_num_rows($result);
$reccnt = db_scalar($sql_count);



?>