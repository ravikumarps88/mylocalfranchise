<?
require "../lib/app_top_admin.php";
$link	= dbConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$franchise	= getFieldValue($_REQUEST['franchise_id'],'vendor','franchises');
$rsSearchResults = mysqli_query($link,"SELECT * FROM request_details WHERE franchise_id='{$_REQUEST['franchise_id']}'") or die(mysqli_error($link));
 
$out = '';
$field = mysqli_field_count($link);

// create line with field names
for($i = 0; $i < $field; $i++) {
    $out.= mysqli_fetch_field_direct($rsSearchResults, $i)->name.',';
}

$out .="\n";

while($row = mysqli_fetch_array($rsSearchResults)) {
    // create line with field values
    for($i = 0; $i < $field; $i++) {
        $out.= '"'.$row[mysqli_fetch_field_direct($rsSearchResults, $i)->name].'",';
    }
    $out.="\n";
}

// Output to browser with appropriate mime type, you choose ;)
header("Content-type: text/x-csv");
//header("Content-type: text/csv");
//header("Content-type: application/csv");
header("Content-Disposition: attachment; filename=".$franchise."_enquiries.csv");
echo $out;
exit;
?>