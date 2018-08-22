<?php
	$pContents	= no_magic_quotes(getPageContents(CURRENT_PAGE));
	$pContents	= insertPageContents($pContents);
	echo $pContents;
?>