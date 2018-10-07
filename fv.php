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

$investments = array(
	array("name" => "3%", "rate" => 0.03, "value" => $currentAmount),
	array("name" => "5%", "rate" => 0.05, "value" => $currentAmount),
	array("name" => "7%", "rate" => 0.07, "value" => $currentAmount),
	array("name" => "8%", "rate" => 0.08, "value" => $currentAmount),
	array("name" => "9%", "rate" => 0.09, "value" => $currentAmount),
	array("name" => "10%", "rate" => 0.10, "value" => $currentAmount),);
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
		<?php foreach ($investments as $k => $r) { ?>
		<th>ROI <?php echo $r["name"]; ?></th>
		<?php } ?>
	</tr>
<?php
	$newAmount	= $currentAmount;
	for ($i = 0; $i <= $remainingYearsToRetirement; $i++) {
		$inflatedAmount = $currentAmount * (1 - $inflationRate); // Remaining value adjusted by inflation
		$depreciatedAmount = $currentAmount - $inflatedAmount; // Value depreciated by inflation
		$newAmount = $newAmount + ($newAmount * $inflationRate); // Required amount to fend of inflation
		foreach ($investments as $k => $r)
			$investments[$k]["value"] = $investments[$k]["value"] * 
			(1 - $inflationRate + $investments[$k]["rate"])
?>
	<tr>
		<td><?php echo $i + 1?></td>
		<td><?php echo $currentYear + $i; ?></td>
		<td><?php echo $currentAge + $i; ?></td>
		<td><?php echo rounding($currentAmount); ?></td>
		<td><?php echo rounding($inflatedAmount); ?></td>
		<td><?php echo rounding($depreciatedAmount); ?></td>
		<td><?php echo rounding($newAmount); ?></td>
		<?php foreach ($investments as $k => $r) { ?>
		<td><?php echo rounding($investments[$k]["value"]); ?></td>
		<?php } ?>
	</tr>
<?php
		$currentAmount = $inflatedAmount;
	}
?>
</table>