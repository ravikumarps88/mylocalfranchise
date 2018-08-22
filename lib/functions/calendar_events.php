<?
/* draws a calendar */
function draw_calendar($month,$year,$event_type=''){

	/* draw table */
	$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

	/* table headings */
	$headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
	$calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

	/* days and weeks vars now ... */
	$running_day = date('w',mktime(0,0,0,$month,1,$year));
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();

	/* row for week one */
	$calendar.= '<tr class="calendar-row">';

	/* print "blank" days until the first of the current week */
	$last_month_date	= date("t",mktime(0,0,0, $month-1, 1, $year));
	$last_year			= date("Y",mktime(0,0,0, $month-1, 1, $year));
	for($x = $running_day-1; $x >=0 ; $x--):
		$calendar.= '<td class="calendar-day">';
		
		/** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
		$schTasks	= getScheduledEvents(date('Y-m-d',strtotime($last_year.'-'.($month-1).'-'.($last_month_date - $x))),$event_type);
		foreach($schTasks as $val):
			$tipContent	= '<div><pre><span><b>'.no_magic_quotes($val['event_name']).'</b></span><br /><span>'.no_magic_quotes($val['description']).'</span><br /><span><b>Event Date:&nbsp;</b>'.date('F d, Y',strtotime($val['event_date'])).', &nbsp;From '.date('h:ia',strtotime($val['time_from'])).' to '.date('h:ia',strtotime($val['time_to'])).'</span><br /></pre></div>';
			
			$tasks_dis	.= str_repeat('<a href="event/'.$val['id'].'/'.urlencode(no_magic_quotes(str_replace("/","",$val['event_name']))).'"><div name="prjtaskincal" title="'.$tipContent.'" class="tool_tip_help eventincal ui-widget-content" >'. substr(no_magic_quotes($val['event_name']),0,20).'</div></a>',1);
		endforeach;
		
		$calendar.= '<div class="cal_cell" val="'.($month-1).'_'.($last_month_date - $x).'_'.$last_year.'">
						<div class="day-number-prev">'.($last_month_date - $x).'</div>
						'.$tasks_dis.'
					 </div>';

		//$calendar.= str_repeat('<p>&nbsp;</p>',2).'</div>';
		
		
		
		
		$calendar.= '</td>';
		$days_in_this_week++;
		$tasks_dis = '';
	endfor;

	/* keep going with days.... */
	for($list_day = 1; $list_day <= $days_in_month; $list_day++):
		$calendar.= '<td class="calendar-day">';
		
		/** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
		$schTasks	= getScheduledEvents(date('Y-m-d',strtotime($year.'-'.($month).'-'.($list_day))),$event_type);
		foreach($schTasks as $val):
			$tipContent	= '<div><pre><span><b>'.no_magic_quotes($val['event_name']).'</b></span><br /><span>'.no_magic_quotes($val['description']).'</span><br /><span><b>Event Date:&nbsp;</b>'.date('F d, Y',strtotime($val['event_date'])).', &nbsp;From '.date('h:ia',strtotime($val['time_from'])).' to '.date('h:ia',strtotime($val['time_to'])).'</span><br /></pre></div>';
			
			$tasks_dis	.= str_repeat('<a href="event/'.$val['id'].'/'.urlencode(no_magic_quotes(str_replace("/","",$val['event_name']))).'"><div name="prjtaskincal" title="'.$tipContent.'" class="tool_tip_help eventincal ui-widget-content" >'.substr(no_magic_quotes($val['event_name']),0,20).'</div></a>',1);
		endforeach;
		
		$calendar.= '<div class="cal_cell" val="'.$month.'_'.$list_day.'_'.$year.'">
							<div class="day-number">'.$list_day.'</div>
							'.$tasks_dis.'
						 </div>';
	
		$calendar.= '</td>';
		if($running_day == 6):
			$calendar.= '</tr>';
			if(($day_counter+1) != $days_in_month):
				$calendar.= '<tr class="calendar-row">';
			endif;
			$running_day = -1;
			$days_in_this_week = 0;
		endif;
		$days_in_this_week++; $running_day++; $day_counter++;
		$tasks_dis = '';
	endfor;

	/* finish the rest of the days in the week */
	$next_year			= date("Y",mktime(0,0,0, $month+1, 1, $year));
	if($days_in_this_week < 8):
		for($x = 1; $x <= (8 - $days_in_this_week); $x++):
			$calendar.= '<td class="calendar-day">';
			
			
	
			/** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
		$schTasks	= getScheduledEvents(date('Y-m-d',strtotime($next_year.'-'.($month+1).'-'.($x))),$event_type);
		foreach($schTasks as $val):
			$tipContent	= '<div><pre><span><b>'.no_magic_quotes($val['event_name']).'</b></span><br /><span>'.no_magic_quotes($val['description']).'</span><br /><span><b>Event Date:&nbsp;</b>'.date('F d, Y',strtotime($val['event_date'])).', &nbsp;From '.date('h:ia',strtotime($val['time_from'])).' to '.date('h:ia',strtotime($val['time_to'])).'</span><br /></pre></div>';
			
			$tasks_dis	.= str_repeat('<a href="event/'.$val['id'].'/'.urlencode(no_magic_quotes(str_replace("/","",$val['event_name']))).'"><div name="prjtaskincal" title="'.$tipContent.'" class="tool_tip_help eventincal ui-widget-content" >'.substr(no_magic_quotes($val['event_name']),0,20).'</div></a>',1);
		endforeach;
		
		$calendar.= '<div class="cal_cell" val="'.($month+1).'_'.$x.'_'.$next_year.'">
							<div class="day-number-next">'.$x.'</div>
							'.$tasks_dis.'
						</div>';	
			
			
		
			$calendar.= '</td>';
			$tasks_dis = '';
		endfor;
	endif;

	/* final row */
	$calendar.= '</tr>';

	/* end the table */
	$calendar.= '</table>';
	
	/* all done, return result */
	return $calendar;
}

#----------------#-----------------#------------------#------------------#-----------------#--------------------#--------------------#---------------------#-----------------#-----------------#--------
#----------------#-----------------#------------------#------------------#-----------------#--------------------#--------------------#---------------------#-----------------#-----------------#--------
#----------------#-----------------#--------------------##----------------#-----------------#------------------#------------------#-----------------#--------------------#--------------------#-------
function draw_home_calendar($month,$year)	{
	/* draw table */
	$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

	/* table headings */
	$headings = array('S','M','T','W','T','F','S');
	$calendar.= '<tr class="calendar-row"><td class="calendar-day-head-home">'.implode('</td><td class="calendar-day-head-home">',$headings).'</td></tr>';

	/* days and weeks vars now ... */
	$running_day = date('w',mktime(0,0,0,$month,1,$year));
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();

	/* row for week one */
	$calendar.= '<tr class="calendar-row">';

	/* print "blank" days until the first of the current week */
	$last_month_date	= date("t",mktime(0,0,0, $month-1, 1, $year));
	$last_year			= date("Y",mktime(0,0,0, $month-1, 1, $year));
	for($x = $running_day-1; $x >=0 ; $x--):
		$calendar.= '<td class="home_calendar-day">';
		$tipContent = '';
		/** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
		$schTasks	= getScheduledEvents(date('Y-m-d',strtotime($last_year.'-'.($month-1).'-'.($last_month_date - $x))));
		foreach($schTasks as $val):
			$tipContent	.= '<div><pre><span><b>'. substr(no_magic_quotes($val['event_name']),0,20).'..</b></span>&nbsp;<a style=\'color:#ff0000;\'  href=\'event-'.$val['id'].'-'.urlencode(no_magic_quotes(str_replace('/','',$val['event_name']))).'.html\' target=\'_parent\'>more</a></span></pre></div>';
		endforeach;
		$evn_cls	= ($tipContent != '' ? 'homeeventincal' : '');
		$tasks_dis	.= str_repeat('<div name="prjtaskincal" title="'.$tipContent.'" class="tool_tip_help ui-widget-content '.$evn_cls.'" >&nbsp;</div>',1);	
		$calendar.= '<div class="cal_cell" val="'.($month-1).'_'.($last_month_date - $x).'_'.$last_year.'">
						<div class="day-number-prev-home">'.($last_month_date - $x).'</div>
						'.$tasks_dis.'
					 </div>';

		//$calendar.= str_repeat('<p>&nbsp;</p>',2).'</div>';
		
		
		
		
		$calendar.= '</td>';
		$days_in_this_week++;
		$tasks_dis = '';
	endfor;

	/* keep going with days.... */
	for($list_day = 1; $list_day <= $days_in_month; $list_day++):
		$calendar.= '<td class="home_calendar-day">';
		$tipContent = '';
		/** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
		$schTasks	= getScheduledEvents(date('Y-m-d',strtotime($year.'-'.($month).'-'.($list_day))));
		foreach($schTasks as $val):
			$tipContent	.= '<div><pre><span><b>'.substr(no_magic_quotes($val['event_name']),0,20).'..</b></span>&nbsp;<a style=\'color:#ff0000;\'  href=\'event-'.$val['id'].'-'.urlencode(no_magic_quotes(str_replace('/','',$val['event_name']))).'.html\' target=\'_parent\'>more</a></span></pre></div>';
		endforeach;
		$evn_cls	= ($tipContent != '' ? 'homeeventincal' : '');
		$tasks_dis	.= str_repeat('<div name="prjtaskincal" title="'.$tipContent.'" class="tool_tip_help ui-widget-content '.$evn_cls.'" >&nbsp;</div>',1);	
		
		$calendar.= '<div class="cal_cell" val="'.$month.'_'.$list_day.'_'.$year.'">
							<div class="day-number-home">'.$list_day.'</div>
							'.$tasks_dis.'
						 </div>';
	
		$calendar.= '</td>';
		if($running_day == 6):
			$calendar.= '</tr>';
			if(($day_counter+1) != $days_in_month):
				$calendar.= '<tr class="calendar-row">';
			endif;
			$running_day = -1;
			$days_in_this_week = 0;
		endif;
		$days_in_this_week++; $running_day++; $day_counter++;
		$tasks_dis = '';
	endfor;

	/* finish the rest of the days in the week */
	$next_year			= date("Y",mktime(0,0,0, $month+1, 1, $year));
	if($days_in_this_week < 8):
		for($x = 1; $x <= (8 - $days_in_this_week); $x++):
			$calendar.= '<td class="home_calendar-day">';
			$tipContent = '';
			
	
			/** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
		$schTasks	= getScheduledEvents(date('Y-m-d',strtotime($next_year.'-'.($month+1).'-'.($x))));
		foreach($schTasks as $val):
			$tipContent	.= '<div><pre><span><b>'.substr(no_magic_quotes($val['event_name']),0,20).'..</b></span>&nbsp;<a style=\'color:#ff0000;\'  href=\'event-'.$val['id'].'-'.urlencode(no_magic_quotes(str_replace('/','',$val['event_name']))).'.html\' target=\'_parent\'>more</a></span></pre></div>';
		endforeach;
		$evn_cls	= ($tipContent != '' ? 'homeeventincal' : '');
		$tasks_dis	.= str_repeat('<div name="prjtaskincal" title="'.$tipContent.'" class="tool_tip_help ui-widget-content '.$evn_cls.'" >&nbsp;</div>',1);	
		
		$calendar.= '<div class="cal_cell" val="'.($month+1).'_'.$x.'_'.$next_year.'">
							<div class="day-number-next-home">'.$x.'</div>
							'.$tasks_dis.'
						</div>';	
			
			
		
			$calendar.= '</td>';
			$tasks_dis = '';
		endfor;
	endif;

	/* final row */
	$calendar.= '</tr>';

	/* end the table */
	$calendar.= '</table>';
	
	/* all done, return result */
	return $calendar;
}