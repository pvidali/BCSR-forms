<?php

/***************************
  Sample using a PHP array
****************************/

require('fpdm.php');

$fields = array(
	'fname'    => 'Daniel'
);

$pdf = new FPDM('fpdm/school-couns4.pdf');
$pdf->Load($fields, false); // second parameter: false if field values are in ISO-8859-1, true if UTF-8
$pdf->Merge();
$pdf->Output();
?>
