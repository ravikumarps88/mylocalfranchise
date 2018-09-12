<?
ob_start();
session_start();
error_reporting(0);
ini_set('session.gc_maxlifetime', 86400);
// check the development/live env and include the correct config file
$serverMode = getenv("SERVER_MODE");	// devp, test or live

// config file
require "lib/config/live.php";

//classes
//require "lib/classes/class.imagetransform.php";
//require "lib/classes/mpdf/mpdf.php";
require_once 'lib/classes/src/Mandrill.php';

// functions
require "lib/functions/general.php";
require "lib/functions/system.php";
require "lib/functions/cms.php";
require "lib/functions/messaging.php";
require "lib/functions/mysqli.php";
require "lib/functions/auth.php";
require "lib/functions/abbreviations.php";
require "lib/functions/date.php";

$titleArr	= array();
$titleArr[]	= array("optionId"=>"Mr","optionText"=>"Mr");
$titleArr[]	= array("optionId"=>"Miss","optionText"=>"Miss");
$titleArr[]	= array("optionId"=>"Mrs","optionText"=>"Mrs");
$titleArr[]	= array("optionId"=>"Ms","optionText"=>"Ms");

dbConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

fixMagicQuotes();
loadConfig();

$franchiseCategArr	= dbQuery("SELECT fc.id AS optionId, fc.category AS optionText
								FROM franchise_categories fc
								LEFT JOIN franchises f
									ON fc.id=f.category_id
								WHERE
									fc.status='active' AND f.status='active' GROUP BY fc.id ORDER BY category");

$lifeStyleArr		= dbQuery("SELECT id AS optionId, lifestyle AS optionText FROM lifestyles WHERE status='active' AND is_lifestyle='yes' ORDER BY lifestyle");
$franchiseArr		= dbQuery("SELECT id AS optionId, vendor AS optionText FROM franchises WHERE status='active' ORDER BY vendor");

$liquid_capitalArr	= array("0"=>"Not specified","15"=>"Less than &pound;15,000", "15-30"=>"&pound;15,000 to &pound;30,000", "30-40"=>"&pound;30,000 to &pound;40,000", "40-50"=>"&pound;40,000 to &pound;50,000", "50-100"=>"&pound;500,000 to &pound;100,000", "100-150"=>"&pound;100,000 to &pound;150,000", "150-250"=>"&pound;150,000 to &pound;250,000", "250-500"=>"&pound;250,000 to &pound;500,000", "500-1000"=>"&pound;500,000 to &pound;1,000,000", "1000"=>"More than �1,000,000");
?>
