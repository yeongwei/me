<?php

include "common.php";

$currentYear = date("Y");
$currentAge = isset($_POST["current-age"]) ? $_POST["current-age"] : 30;
$inflationRate = isset($_POST["inflation-rate"]) ? $_POST["inflation-rate"] : 3.5;
$inflationRate = $inflationRate / 100;
$yearsToRetirement = isset($_POST["years-to-retirement"]) ? $_POST["years-to-retirement"] : 25;
$amount = isset($_POST["amount"]) ? $_POST["amount"] : 5000.00;

$investments = array(
	array("name" => "3%", "rate" => 0.03, "value" => $amount),
	array("name" => "4%", "rate" => 0.04, "value" => $amount),
	array("name" => "5%", "rate" => 0.05, "value" => $amount),
	array("name" => "6%", "rate" => 0.06, "value" => $amount),
	array("name" => "7%", "rate" => 0.07, "value" => $amount),
	array("name" => "8%", "rate" => 0.08, "value" => $amount),
	array("name" => "9%", "rate" => 0.09, "value" => $amount),
	array("name" => "10%", "rate" => 0.10, "value" => $amount));
?>

<html>
<head>
	<title>Future Value</title>
</head>
<body>
<h1>Future Value</h1>
<p>
This document computes the future value of a given amount over a number of years before reaching the desired retirement age subject to both yearly inflation and yearly growth. The computation assumes that throughout the years, there were no injections.
</p>
<form method="post">
<label>Amount (RM): </label><input name="amount" value="<?php echo $amount; ?>"/>
<br>
<label>Number of year(s) to retirement: </label><input name="years-to-retirement" value="<?php echo $yearsToRetirement?>"/>
<br>
<label>Yearly Inflation Rate(%) : </label><input name="inflation-rate" value="<?php echo $inflationRate * 100; ?>"/>
<br>
<label>Current Age : </label><input name="current-age" value="<?php echo $currentAge; ?>"/>
<br>
<input type="submit" value="submit"/>
</form>
<p>
The table below shows the future value of RM <?php echo $amount; ?> after <?php echo $yearsToRetirement; ?> year subject to a yearly inflation rate of <?php echo $inflationRate * 100; ?>%.
</p>
<table border="1" width="100%">
	<tr>
		<th>No.</th>
		<th>Year</th>
		<th>Age</th>
		<th>Amount</th>
		<th>Depreciated Amount</th>
		<th>Depreciation Amount</th>
		<th>Amount Required</th>
		<?php foreach ($investments as $k => $r) { ?>
		<th><?php echo $r["name"]; ?> p.a</th>
		<?php } ?>
	</tr>
<?php
	$amount2 = $amount;
	$requiredAmount	= $amount;
	for ($i = 0; $i <= $yearsToRetirement; $i++) {
		$depreciatedAmount = $amount * (1 - $inflationRate); // Remaining value adjusted by inflation
		$depreciationAmount = $amount - $depreciatedAmount; // Value depreciated by inflation
		$requiredAmount = $requiredAmount + ($requiredAmount * $inflationRate); // Required amount to fend of inflation
		foreach ($investments as $k => $r)
			$investments[$k]["value"] = $investments[$k]["value"] * 
			(1 - $inflationRate + $investments[$k]["rate"])
?>
	<tr>
		<td><?php echo $i + 1?></td>
		<td><?php echo $currentYear; ?></td>
		<td><?php echo $currentAge; ?></td>
		<td><?php echo rounding($amount); ?></td>
		<td><?php echo rounding($depreciatedAmount); ?></td>
		<td><?php echo rounding($depreciationAmount); ?></td>
		<td><?php echo rounding($requiredAmount); ?></td>
		<?php foreach ($investments as $k => $r) { ?>
		<td><?php echo rounding($investments[$k]["value"]); ?></td>
		<?php } ?>
	</tr>
<?php
		$amount = $depreciatedAmount;
		$currentYear = $currentYear + 1;
		$currentAge = $currentAge + 1;
	}
?>
</table>
<p>
At the retirement year <?php echo $currentYear - 1; ?>, age <?php echo $currentAge - 1; ?>. The amount of RM <?php echo $amount2; ?> will only have the value of RM <?php echo rounding($depreciatedAmount); ?> and requires the amount of RM <?php echo rounding($requiredAmount); ?> in order to have the same value. Which is an additional of RM <?php echo rounding($requiredAmount - $amount2); ?>
</p>
</body>
</html>