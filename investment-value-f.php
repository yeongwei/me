<?php

function epf($startAmount, $startAge, $startYear, $yearsToGo, $interestPerYear, $startRecuringAmount, $recuringAmountIncrement) {
	$iv = array();
	$data = array("age" => "", "year" => "", "value" => "", "recur" => "");
	$interestPerYear = $interestPerYear / 100.00;
	$recuringAmountIncrement = $recuringAmountIncrement / 100.00;
	
	for ($i = 0; $i < $yearsToGo; $i++) {
		$data["year"] = $startYear + $i;
		$data["age"] = $startAge + $i;

		if ($i == 0) {
			$data["recur"] = $startRecuringAmount;
			$data["value"] = 
				($startAmount + $data["recur"]) * (1 + $interest);
		} else {
			$data["recur"] = $iv[$i-1]["recur"] * (1 + $recuringAmountIncrement); 
			$data["value"] = ($iv[$i-1]["value"] + $data["recur"]) * (1 + $interest);
		}

		array_push($iv, $data);
	}

	return $iv;
}

include "common.php";

$epf = epf(
	$startAmount = 120000, 
	$startAge = $startAge, 
	$startYear = $startYear,
	$yearsToGo = $retirementAge - $startAge + 1,
	$interestPerYear = 4.60, 
	$startRecuringAmount = 1900.00 * 12, 
	$recuringAmountIncrement = 5.00);

dataDump($epf);

?>