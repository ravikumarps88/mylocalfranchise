<?
$query 		= "select * from pages WHERE status='active' AND parent_id='-1' ORDER BY sort_order";
$pagelist 	= dbQuery($query);

$query 		= "select * from news WHERE status='active' ORDER BY sort_order";
$newspagelist 	= dbQuery($query);

$query 		= "select * from events WHERE status='active' ORDER BY sort_order";
$eventspagelist 	= dbQuery($query);
?>
<ul class="category">
<?
foreach($pagelist as $val)	{
	$href		= ($val['page_alias'] == '' ? '#' : $val['page_alias'].'.html');
?>
	<li><a href="<?=APP_URL.'/'.$href?>"><?=no_magic_quotes($val['menu_text'])?></a></li>
<?
	if($val['page_alias'] == 'blog')	{
	$query 		= "select * from news WHERE status='active' ORDER BY sort_order";
	$newspagelist 	= dbQuery($query);
?>
	<li style="background:none;"><ul class="">
<?	
		foreach($newspagelist as $sval)	{
?>
			<li><a href="<?=APP_URL.'/blog/'.$sval['id']?>/<?=urlencode(no_magic_quotes(str_replace("/","",$sval['title'])))?>.html"><?=no_magic_quotes($sval['title'])?></a></li> 
<?
		}
?>
	</ul></li>
<?    
	}
	else	{
	$query 			= "select * from pages WHERE status='active' AND parent_id='{$val['id']}' ORDER BY sort_order";
	$subpagelist 	= dbQuery($query);
	if(count($subpagelist)>0)	{
?>
	<li style="background:none;"><ul class="">
<?	
		foreach($subpagelist as $sval)	{
			$href		= ($sval['page_alias'] == '' ? '#' : $sval['page_alias'].'.html');
?>
			<li><a href="<?=APP_URL.'/'.$href?>"><?=no_magic_quotes($sval['menu_text'])?></a></li>    
<?
			if($sval['page_alias'] == 'eventlist')	{
				$query 		= "select * from events WHERE status='active' ORDER BY sort_order";
				$eventspagelist 	= dbQuery($query);
?>
				<li style="background:none;"><ul class="">
<?	
				foreach($eventspagelist as $sval)	{
?>
					<li><a href="<?=APP_URL.'/event-'.$sval['id'].'-'.$sval['page_alias']?>-<?=urlencode(no_magic_quotes(str_replace("/","",$sval['event_name'])))?>.html"><?=no_magic_quotes($sval['event_name'])?></a></li>
<?
				}
?>
				</ul></li>
<?    
			}
		}
?>
	</ul></li>
<?  
	}  
    }
	
}
?>
</ul>