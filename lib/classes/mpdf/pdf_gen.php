<?php
include('mpdf.php');
$mpdf=new mPDF();
$mpdf->WriteHTML('<div class="div_center">
    	<h1>Quotation</h1>
        <label>Project: Test</label><br />
        <label>Number:  007</label>
        <h4>03/02/2014</h4>
    </div>');
$mpdf->Output();   exit;
?>