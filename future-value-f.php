<?php
// At the end of `year`, `age` the value of `amount` is `actualAmount`
// At the following year, the spending power of `amount` requires the amount of `actualAmount`
// This year `amount` == last year `actualAmount`
function computeFutureValue($amount, $startYear, $age, $years, $inflation) {
	$fv = array();
	$data = array("year" => "", "amount" => "", 
		"depreciatedAmount" => "", "actualAmount" => "");
	$inflation = $inflation / 100.00;

	for ($i = 0; $i < $years; $i++) {
		$data["year"] = $startYear + $i;
		$data["age"] = $age + $i;
		$data["amount"] = $amount;
		if ($i == 0) {
			$data["depreciatedAmount"] = $amount * (1 - $inflation);
			$data["actualAmount"] = $amount * (1 + $inflation);
		} else {
			$data["depreciatedAmount"] = 
				$fv[$i-1]["depreciatedAmount"] * (1 - $inflation);
			$data["actualAmount"] = 
				$fv[$i-1]["actualAmount"] * (1 + $inflation);
		}

		array_push($fv, $data);

		$year = $year + 1;
	}

	return $fv;
}

include "common.php";

$fv = computeFutureValue(
	$amount = $monthlyAmount, 
	$startYear = date("Y"), 
	$age = $currentAge, 
	$years = $retirementAge - $currentAge + $yearsOfRetirement + 1, // inclusive of `this` year
	$inflation = 4.00);

// dataDump($fv);

$retirementStartYear = date("Y") + ($retirementAge - $currentAge);

$fvFiltered = array();
foreach ($fv as $i => $v)
	if ($v["year"] >= $retirementStartYear - 1) 
		// One year before retirement starts
		// Because `actualAmount` is only applicable to the following year
		array_push($fvFiltered, $v);

foreach ($fvFiltered as $i => $v) if ($i != 0) 
	$fvFiltered[$i]["yearlyRequiredAmount"] = $fvFiltered[$i - 1]["actualAmount"] * 12;
		
$fvFiltered = array_slice($fvFiltered, 1);
dataDump($fvFiltered);

$total = 0;
foreach ($fvFiltered as $i => $v)
	$total = $total + $v["yearlyRequiredAmount"];

echo $total;
?>