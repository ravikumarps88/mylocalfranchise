<?
ob_start();
session_start();

error_reporting();

// check the development/live env and include the correct config file
$serverMode = getenv("SERVER_MODE");	// devp, test or live

// config file
require "../lib/config/live.php";

//classes
require "../lib/classes/class.imagetransform.php";

// functions
require "../lib/functions/system.php";
require "../lib/functions/general.php";
require "../lib/functions/messaging.php";
require "../lib/functions/mysqli.php";
require "../lib/functions/auth.php";
require "../lib/functions/abbreviations.php";
require "../lib/functions/date.php";

dbConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

fixMagicQuotes();
loadConfig();

$newsCategArr		= dbQuery("SELECT id AS optionId, category AS optionText FROM news_categories WHERE status='active' ORDER BY category");
$franchiseCategArr	= dbQuery("SELECT id AS optionId, category AS optionText FROM franchise_categories WHERE status='active' ORDER BY category");
$parentCategorieseArr	= dbQuery("SELECT id AS optionId, category AS optionText FROM franchise_categories WHERE status='active' AND parent_id=0");
?>
