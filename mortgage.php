<?php

include "common.php";

$loanAmount = isset($_POST["loan-amount"]) ? $_POST["loan-amount"] : 120000.00;
$loanInterest = isset($_POST["loan-interest"]) ? $_POST["loan-interest"] : 5;
$loanRepayment = isset($_POST["loan-repayment"]) ? $_POST["loan-repayment"] : 700.00;

$dailyInterest = $loanInterest / 100.00 / 364;
$date = date("Y-m-d");
$count = 1;
?>
<html>
	<head>
		<title>Mortgage</title>
	</head>
	<body>
		<form method="post">
		<label>Loan Amount (RM): </label><input name="loan-amount" value="<?php echo $loanAmount; ?>"/>
		<br>
		<label>Loan Interest (%): </label><input name="loan-interest" value="<?php echo $loanInterest?>"/>
		<br>
		<label>Monthly Repayment (RM) : </label><input name="loan-repayment" value="<?php echo $loanRepayment; ?>"/>
		<br>
		<input type="submit" value="submit"/>
		</form>
		<table border="1">
			<th>No.</th>
			<th>Year</th>
			<th>Month</th>
			<th>Remaining Principal</th>
			<th>Total Interest</th>
			<th>Total Repayment to Principal</th>
			<?php
			while($loanAmount > 0) {
				$parsedDate = date_parse_from_format("Y-m-d", $date);
				$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $parsedDate["month"],  $parsedDate["year"]);
				$totalInterestRate = $dailyInterest * $daysInMonth;
				$totalInterest = $loanAmount * $totalInterestRate;
				$totalRepaymentToPrincipal = $loanRepayment - $totalInterest;
				$loanAmount = $loanAmount - $totalRepaymentToPrincipal;
			?>
			<tr>
				<td><?php echo $count; ?></td>
				<td><?php echo date("Y", strtotime($date)); ?></td>
				<td><?php echo date("M", strtotime($date)); ?></td>
				<td><?php echo rounding($loanAmount); ?></td>
				<td><?php echo rounding($totalInterest); ?></td>
				<td><?php echo rounding($totalRepaymentToPrincipal); ?></td>
			</tr>
			<?php
				$count = $count + 1;
				$date = date("Y-m-d", strtotime(date("Y-m-d", strtotime($date)) . " +1 month"));
				}
			?>
		</table>
	</body>
</html>