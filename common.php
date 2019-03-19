<?php

function rounding($val) {
	return number_format((float) $val, 2, '.', '');
}

function dataDump($val) {
	echo "<pre>" . var_export($val, true) . "</pre>";
}

$amount = 5000; // Required monthly spending value
$startAge = 30; // Starting age
$startYear = 2018; // Starting year
$retirementAge = 60; // Start age for retirement
$yearsOfRetirement = 20; // Number of years to spend for retirement

?>