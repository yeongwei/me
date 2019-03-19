<?php

function futureValue($amount, $startAge, $startYear, $yearsToGo, $inflation) {
	$fv = array();
	$data = array("age" => "", "year" => "", "amount" => "", 
		"depreciatedAmount" => "", "requiredAmount" => "");
	$inflation = $inflation / 100.00;

	for ($i = 0; $i < $yearsToGo; $i++) {
		$data["year"] = $startYear + $i;
		$data["age"] = $startAge + $i;
		$data["amount"] = $amount;
		if ($i == 0) {
			$data["depreciatedAmount"] = $amount * (1 - $inflation);
			$data["requiredAmount"] = $amount * (1 + $inflation);
		} else {
			$data["depreciatedAmount"] = 
				$fv[$i-1]["depreciatedAmount"] * (1 - $inflation);
			$data["requiredAmount"] = 
				$fv[$i-1]["requiredAmount"] * (1 + $inflation);
		}

		array_push($fv, $data);
	}

	return $fv;
}

include "common.php";

$fv = futureValue(
	$amount = $amount, 
	$startAge = $startAge, 
	$startYear = $startYear, 
	$years = $retirementAge - $startAge + $yearsOfRetirement + 1, // inclusive of `this` year
	$inflation = 4.00);

// dataDump($fv);

?>