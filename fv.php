<?php

function rounding($val) {
	return round($val, 2, PHP_ROUND_HALF_EVEN);
}

$currentYear = 2018;
$currentAge = 30;
$inflationRate = 0.031;
$remainingYearsToRetirement = 25;

$currentAmount = 5000.00;

$rois = array(0.03,0.04,0.05,0.06,0.07,0.08,0.09);
$roiAmount = array($rm,$rm,$rm,$rm,$rm,$rm,$rm);

echo "At year " . $currentYear . ". Inflation Rate of " . $inflationRate * 100 . "% for a period of " . $remainingYearsToRetirement . " years of RM " . $currentAmount . ".";
?>