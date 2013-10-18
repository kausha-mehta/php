<?php
@error_reporting(0);
//	Include Configuration File
require_once("config.php");
require_once("query.php");

?>
<html>
<head>
<title>PHP Pagination</title>
</head>

<body>


<div style="margin:0px auto; width:500px; border:1px solid;">
<form action="" method="post" enctype="multipart/form-data" style="margin:0px; padding:0px;">
<?php	
	if($_GET['id']!='')
	{
		$rq = mysql_query("select * from user where id='".$_GET['id']."'");
		$rr = mysql_fetch_array($rq);
		@extract($rr);	
	}
?>   
	
    <table width="500" align="center" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #ff8c00;">
    	<tr bgcolor="#ff8c00">
        	<td colspan="2" height="30" style="border-bottom:1px solid; font-weight:500; color:#FFFFFF; font-size:18px;"> &nbsp; &nbsp; PHP Pagination</td>
        </tr>
        
      <tr>
        <td width="104" height="30" valign="top" class="left-text"> &nbsp; &nbsp; Name:<span style="color:#F00;">*</span></td>
        <td align="left" valign="top"><label><input type="text" name="name" value="<?=$name?>" size="35" required /></label></td>
      </tr>
      
      <tr>
        <td height="30" valign="top" class="left-text"> &nbsp; &nbsp; Email:<span style="color:#F00;">*</span></td>
        <td align="left" valign="top"><label><input type="email" name="email" value="<?=$email?>" size="35" required /></label></td>
      </tr>
      
      <tr>
        <td valign="top">&nbsp;</td>
        <td width="394"><input type="submit" name="Submit_g" id="save" value="Save" style="border:1px solid #ff8c00; background-color:#ff8c00; color:#FFFFFF; font-weight:500; margin-bottom:10px;"/></td>
      </tr>
    </table>  
  </form>
  

<table width="500" align="center" border="1" cellpadding="2" cellspacing="0" bordercolor="#ff8c00">
  <tr bgcolor="whitesmoke">
    <td align="left" valign="top" bgcolor="whitesmoke" class="topheader_td">SNO</td>
    <td align="left" valign="top" bgcolor="whitesmoke" class="topheader_td">Name</td>
    <td align="left" valign="top" bgcolor="whitesmoke" class="topheader_td">Email </td>
    <td align="center" valign="top" bgcolor="whitesmoke" class="topheader_td">Edit</td>
    <td align="center" valign="top" bgcolor="whitesmoke" class="topheader_td">Delete</td>
    </tr>
<? if($rows==0) { ?>
    <tr><td style="color:#F00;" height="30" align="center" colspan="5"><b>Sorry.. No records available.</b></td></tr>
<?php	}	else	{	?>
	<tr><td colspan="5" align="center"><?php	include_once("paging.inc.php");	?></td></tr>
    <tr>
                <td colspan="5" bgcolor="#ff8c00"><table width="100%" border="0" cellspacing="0" cellpadding="5">
                  <tr>
                    <td width="60%" class="adminwhitename" align="left"><strong>Showing Records <?= $start+1?>&nbsp;to 
                    <?=($reccnt<=$start+$pagesize)?($reccnt):($start+$pagesize)?> of <?=$reccnt?></strong></td>
                    <td width="40%" align="right"><strong>Records Per Page: </strong>
                        <?=pagesize_dropdown('pagesize', $pagesize);?></td>
                  </tr>
                </table></td>
        </tr>
 <tr bgcolor="#CCCCCC">
        <td colspan="5" align="center" valign="middle"><?php include('error.msg.inc.php'); ?></td>
    </tr>
<? $counter=$start; 
while($data=mysql_fetch_array($result)){
?>
  <tr valign="top" onmousemove="javascript: this.style.background='#ECF1F2'" onmouseout="javascript: this.style.background='#FFFFFF'">
    <td width="33" align="left"  class="left-tdtext"><?=++$counter?></td>
    <td width="115" align="left" class="left-tdtext"><?=$data['name']?></td>
    <td width="243" align="left" class="left-tdtext"><?=$data['email']?></td>
    <td width="38" align="center" class="left-tdtext"><a href="index.php?id=<?php echo $data['id'];?>" class="bluelink">Edit</a></td>
    <td width="39" align="center" class="left-tdtext"><a href="index.php?did=<?php echo $data['id'];?>" class="bluelink" onclick="return confirm('Are you sure want to delete record')">Delete</a></td>
  </tr>
<?php	}	}	?> 

<tr bgcolor="#ff8c00">
        	<td colspan="5" align="right" height="30" style="border-bottom:1px solid; font-weight:500; color:#FFFFFF; font-size:18px;"> 
            	&nbsp; &nbsp; Script Developed By &nbsp; 
                <a href="http://www.codetrip.info" target="_blank">www.codetrip.info</a> &nbsp; 
            </td>
        </tr>
</table>
</div>
</body>
</html>
