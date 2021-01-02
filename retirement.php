<?php
include "./common.php";

$currentAge = isset($_GET["current_age"]) ? $_GET["current_age"] : 31; // current age
$retireAge = isset($_GET["retire_age"]) ? $_GET["retire_age"] : 60; // retirement age
$dieAge = isset($_GET["die_age"]) ? $_GET["die_age"] : 80; // die age
$epfAmtCurrent = isset($_GET["epf_amt_current"]) ? $_GET["epf_amt_current"] : 190000; // die age
$epfAmtYearly = isset($_GET["epf_amt_early"]) ? $_GET["epf_amt_early"] : 30000;
$epfDivPerc = (isset($_GET["epf_dev_perc"]) ? $_GET["epf_dev_perc"] : 5) / 100;

$expYearly = (isset($_GET["exp_yearly"]) ? $_GET["exp_yearly"] : 60000);
$expinf = (isset($_GET["exp_infla"]) ? $_GET["exp_infla"] : 4) / 100;

$epfTotal = $epfAmtCurrent;
$epfDiv = 0;

$expVal = $expYearly;
?>

<html>
    <head></head>
    <body>
        <table>
            <tr><td>Current Age</td><td><?php echo $currentAge; ?></td></tr>
            <tr><td>Retire Age</td><td><?php echo $retireAge; ?></td></tr>
            <tr><td>Die Age</td><td><?php echo $dieAge; ?></td></tr>
            <tr><td>EPF Currently (MYR)</td><td><?php echo $epfAmtCurrent; ?></td></tr>
            <tr><td>EPF Yearly (MYR)</td><td><?php echo $epfAmtYearly; ?></td></tr>
            <tr><td>EPF Div (%)</td><td><?php echo $epfDivPerc * 100; ?></td></tr>
            <tr><td>Yearly Expenses (MYR)</td><td><?php echo $expYearly; ?></td></tr>
            <tr><td>Yearly Expenses Inflation (%)</td><td><?php echo $expinf * 100; ?></td></tr>
        </table>
        <table border="1">
            <tr>
                <th>Year</th>
                <th>Age</th>
                <th>Epf Start</th>
                <th>Epf End</th>
                <th>Epf Div</th>
                <th>Epf Total</th>
                <th>Exp Value</th>
            </tr>
            <?php for ($year = 1; $year < ($dieAge - $currentAge + 1); $year++) { ?>
                <tr style="<?php if ($currentAge + $year == $retireAge) echo "background: cyan"?>">
                    <td><?php echo $year; ?></td>
                    <td><?php echo $currentAge + $year; ?></td>
                    <td><?php echo rounding($epfTotal); ?></td>
                    <td><?php
                        if ($currentAge + $year <= $retireAge)
                            $epfTotal += $epfAmtYearly;
                        else 
                            $epfTotal -= $expVal;
                        echo rounding($epfTotal);
                        ?></td>
                    <td><?php
                        if ($epfTotal >= 0)
                            $epfDiv = $epfTotal * $epfDivPerc;
                        else $epfDiv = 0;
                        echo rounding($epfDiv);
                        ?></td>
                    <td  style="<?php if ($epfTotal < 0) echo "background: #fadfeb" ?>"><?php
                        $epfTotal += $epfDiv;
                        echo rounding($epfTotal);
                        ?></td>
                    <td><?php
                        $expVal *= (1 + $expinf);
                        echo rounding($expVal);
                        ?></td>
                </tr>
<?php } ?>
        </table>
    </body>
</html>

