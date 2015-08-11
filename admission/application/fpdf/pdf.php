<?php

/***************************
  Sample using a PHP array
****************************/

require('fpdm.php');

$fields = array(
    'stdt_lname'    => 'My name',
    'stdt_fname' => 'My address'
);

$pdf = new FPDM('appacadrecc-writeable.pdf');
$pdf->Load($fields, false); // second parameter: false if field values are in ISO-8859-1, true if UTF-8
$pdf->Merge();
$pdf->Output();
?>