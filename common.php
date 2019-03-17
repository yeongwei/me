<?php

function rounding($val) {
	return number_format((float) $val, 2, '.', '');
}

function dataDump($val) {
	echo "<pre>" . var_export($val, true) . "</pre>";
}

// Constants

$monthlyAmount = 5000;
$currentAge = date("Y") - 1988;
$retirementAge = 60; // Start to retire at the age of 60
$yearsOfRetirement = 20; // Years in retirement

?>