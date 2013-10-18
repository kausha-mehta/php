<?
if($reccnt>$pagesize){
$num_pages=$reccnt/$pagesize;
$PHP_SELF=$_SERVER['PHP_SELF'];
$qry_str=$_SERVER['argv'][0];
$m=$_GET;
unset($m['start']);
$qry_str=qry_str($m);
//echo "$qry_str : $p<br>";
//$j=abs($num_pages/10)-1;
$j=$start/$pagesize-5;
//echo("<br>$j");
if($j<0) {
	$j=0;
}
$k=$j+10;
if($k>$num_pages)	{
	$k=$num_pages;
}
$j=intval($j);
?>
<? //="reccnt=$reccnt, start=$start, pagesize=$pagesize, num_pages=$num_pages : j=$j : k=$k"?>
<table width="100%" border="0" align="right" cellpadding="0" cellspacing="0" bordercolor="#B1C3D9">
  <tr valign="middle">
    <td align="right">
<? if($start!=0) {?><a class="graylink" href="<?=$PHP_SELF?><?=$qry_str?>&start=<?=$start-$pagesize?>" >
      <? }?>
</a></td>
    <td align="right">
	
	<? if($start!=0) {?><a class="graylink" href="<?=$PHP_SELF?><?=$qry_str?>&start=<?=$start-$pagesize?>" >
      <? }?> &nbsp;Prev</a>    </td>
    <td align="center" >
	<?
	for($i=$j;$i<$k;$i++)
	{
		if(($pagesize*($i))!=$start)
		{
	?><a class="graylink" href="<?=$PHP_SELF?><?=$qry_str?>&start=<?=$pagesize*($i)?>" style="text-decoration:none; font-weight:bold" ><?=$i+1?></a>
	<? } else
	{ ?>
      <?=$i+1?>
 	<? }	} ?></td>
    <td ><? if($start+$pagesize < $reccnt){?><a class="graylink" href="<?=$PHP_SELF?><?=$qry_str?>&start=<?=$start+$pagesize?>"><? }?>Next</a> 
	  <? if($start+$pagesize < $reccnt){?><a class="graylink" href="<?=$PHP_SELF?><?=$qry_str?>&start=<?=$start+$pagesize?>"><? }?>&nbsp;</a><a class="graylink" href="<?=$PHP_SELF?><?=$qry_str?>&amp;start=<?=$start-$pagesize?>" ></a> </td>
  </tr>
</table>
<? }?>