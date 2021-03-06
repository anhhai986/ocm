<?php

chdir('../../');

require_once ('pika-danio.php'); 
pika_init();
require_once ('pikaTempLib.php');
require_once ('pikaUser.php');

$report_title = 'Inactive Case Report';
$report_name = "inactive_case";

$base_url = pl_settings_get('base_url');
if(!pika_report_authorize($report_name)) {
	$main_html = array();
	$main_html['base_url'] = $base_url;
	$main_html['page_title'] = $report_title;
	$main_html['nav'] = "<a href=\"{$base_url}/\">Pika Home</a>
    				  &gt; <a href=\"{$base_url}/reports/\">Reports</a> 
    				  &gt; $report_title";
	$main_html['content'] = "You are not authorized to run this report";

	$default_template = new pikaTempLib('templates/default.html', $main_html);
	$buffer = $default_template->draw();
	pika_exit($buffer);
}

$menu_limit = array('100'=>'100','500'=>'500','1000'=>'1000','10000'=>'10000');

$a = array();
$a['report_name'] = $report_name;
$a['open_date_begin'] = '1/1/' . (date('Y'));
$a['open_date_end'] =  $a['inactive_date_begin'] = '12/31/' . (date('Y'));
$a['limit'] = '1000';



$main_html = array();
$main_html['base_url'] = $base_url;
$main_html['page_title'] = $report_title;
$main_html['nav'] = "<a href=\"{$base_url}/\">Pika Home</a>
      &gt; <a href=\"{$base_url}/reports/\">Reports</a> &gt; $report_title";
$template = new pikaTempLib("reports/{$report_name}/form.html", $a);
$template->addMenu('user_id',pikaUser::getUserArray());
$template->addMenu('limit',$menu_limit);
$main_html['content'] = $template->draw();

$default_template = new pikaTempLib('templates/default.html', $main_html);
$buffer = $default_template->draw();
pika_exit($buffer);


?>
