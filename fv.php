<?php

function rounding($val) {
	return number_format((float) $val, 2, '.', '');
}

$currentYear = 2018;
$currentAge = 30;
$inflationRate = 0.035;
$remainingYearsToRetirement = 25;

$currentAmount = 5000.00;

echo "At year " . $currentYear . ". Inflation Rate of " . $inflationRate * 100 . "% for a period of " . $remainingYearsToRetirement . " years of RM " . $currentAmount . ".";
?>

<table border="1">
	<tr>
		<th>No.</th>
		<th>Year</th>
		<th>Age</th>
		<th>Amount</th>
		<th>Inflated Amount</th>
		<th>Depreciated Amount</th>
		<th>New Amount</th>
		<th>ROI 3%</th>
		<th>ROI 5%</th>
	</tr>
<?php
	$newAmount	= $currentAmount;
	$amountFor3 = $currentAmount;
	$amountFor5 = $currentAmount;
	for ($i = 0; $i <= $remainingYearsToRetirement; $i++) {
		$inflatedAmount = $currentAmount * (1 - $inflationRate);
		$depreciatedAmount = $currentAmount - $inflatedAmount;
		$newAmount = $newAmount + ($newAmount *$inflationRate);
		$amountFor3 = $amountFor3 * (1 - $inflationRate + 0.03);
		$amountFor5 = $amountFor5 * (1 - $inflationRate + 0.05);
?>
	<tr>
		<td><?php echo $i + 1?></td>
		<td><?php echo $currentYear + $i; ?></td>
		<td><?php echo $currentAge + $i; ?></td>
		<td><?php echo rounding($currentAmount); ?></td>
		<td><?php echo rounding($inflatedAmount); ?></td>
		<td><?php echo rounding($depreciatedAmount); ?></td>
		<td><?php echo rounding($newAmount); ?></td>
		<td><?php echo rounding($amountFor3); ?></td>
		<td><?php echo rounding($amountFor5); ?></td>
	</tr>
<?php
		$currentAmount = $inflatedAmount;
	}
?>
</table>