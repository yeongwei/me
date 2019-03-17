<?php
/**
 * 
 * @param mixed $initialAmount 
 * @param mixed $years years of investment run
 * @param mixed $interest average interest per year
 * @param mixed $reoucurringAmount
 * @return  
 */
function computeInvestmentValue($initialAmount, $years, $interest, $reoucurringAmount) {
	$iv = array();
	$data = array("year" => "", "value" => "");
	$year = date("Y");
	$interest = $interest / 100.00;
	
	for ($i = 0; $i < $years; $i++) {
		$data["year"] = $year + $i;

		if ($i == 0) {
			$data["value"] = 
				($initialAmount + $reoucurringAmount) * (1 + $interest);
		} else {
			$data["value"] = ($iv[$i-1]["value"] + $reoucurringAmount) * (1 + $interest);
		}

		array_push($iv, $data);
	}

	return $iv;
}

include "common.php";

$currentAge = date("Y") - 1988;
$retirementAge = 60; // Start to retire at the age of 60
$yearsOfRetirement = 20; // Years in retirement

$iv = computeInvestmentValue(150000, 30, 5.00, 2000.00 * 12);

// Append age to investment value
foreach ($iv as $i => $v)
	if ($i == 0)
		$iv[$i]["age"] = $currentAge;
	else
		$iv[$i]["age"] = $iv[$i - 1]["age"] + 1;

dataDump($iv);

?>