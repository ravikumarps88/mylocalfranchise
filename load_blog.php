<?
require "lib/app_top.php";
if($_REQUEST['action'] == 'load_blog')	{
	$newsList		= getNewsList($_REQUEST['start'],BLOG_PER_PAGE, $_REQUEST['user_id'], $_REQUEST['category_id'], $_REQUEST['month'],$_REQUEST['year']);
  
	foreach($newsList as $val)	{?>
        <div class="post">
        <h2 class=""><a href="blog/<?=$val['id']?>/<?=urlencode(no_magic_quotes(str_replace("/","",$val['title'])))?>"><?=no_magic_quotes($val['title'])?></a> </h2>
        <div class="entry-utility"><?=date("F d, Y",strtotime($val['updated_on']));?> in <a href="#"><?=getNewsCategory($val['category'])?></a> by <a href="#"><?=no_magic_quotes(getUser($val['user_id']))?></a></div>
        <div class="entry">
        	<?=$val['image']=='' ? '' : '<a href="blog/'.$val['id'].'/'. urlencode(no_magic_quotes(str_replace("/","",$val['title']))).'" title="Click to read more"><img src="images/news/thumbnail/'.$val['image'].'" alt="" ></a>'?>
       	 	<p><?=substr(no_magic_quotes(strip_tags($val['news'])),0,150);?>&nbsp;...<a href="blog/<?=$val['id']?>/<?=urlencode(no_magic_quotes(str_replace("/","",$val['title'])))?>" class="more">Read More</a></p>
        </div>
    </div><!-- end .post -->
<?
	}
}
?>