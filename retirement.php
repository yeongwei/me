<?php
include "./common.php";

$currentAge = isset($_POST["current_age"]) ? $_POST["current_age"] : 31; // current age
$retireAge = isset($_POST["retire_age"]) ? $_POST["retire_age"] : 60; // retirement age
$dieAge = isset($_POST["die_age"]) ? $_POST["die_age"] : 80; // die age
$epfAmtCurrent = isset($_POST["epf_amt_current"]) ? $_POST["epf_amt_current"] : 190000; // die age
$epfAmtYearly = isset($_POST["epf_amt_early"]) ? $_POST["epf_amt_early"] : 30000;
$epfDivPerc = (isset($_POST["epf_dev_perc"]) ? $_POST["epf_dev_perc"] : 5) / 100;

$expYearly = (isset($_POST["exp_yearly"]) ? $_POST["exp_yearly"] : 60000);
$expinf = (isset($_POST["exp_infla"]) ? $_POST["exp_infla"] : 4) / 100;

$epfTotal = $epfAmtCurrent;
$epfDiv = 0;

$expVal = $expYearly;
?>

<html>
    <head>
        <meta name="viewport" 
              content="width=device-width, initial-scale=1.0, maximum-scale=1.0, 
              user-scalable=0" >
    </head>
    <body>
        <h1>Retirement Calculator (WIP)</h1>
        <p>Inclusive of accumulation and decumulation of retirement funds.</p>
        <p>Note(s):</p>
        <ol>
            <li>Color <b style="color: cyan">CYAN</b> indicates retirement age.</li> 
            <li>Color <b style="color: #fadfeb">CYAN</b> indicates insufficient funds.</li> 
        </ol>
        <h2>Your Inputs</h2>
        <form  action="./retirement.php" method="post">
            <table>
                <tr><td>(1) Current Age</td><td><input name="current_age" value="<?php echo $currentAge; ?>"></td><td><small>(Your current age / any age)</small></td></tr>
                <tr><td>(2) Retire Age</td><td><input name="retire_age" value="<?php echo $retireAge; ?>"></td><td><small>(Your intending retirement age)</small></td></tr>
                <tr><td>(3) Die Age</td><td><input name="die_age" value="<?php echo $dieAge; ?>"></td><td><small>(Your intending pass away age)</small></td></tr>
                <tr><td>(4) EPF Currently (MYR)</td><td><input name="epf_amt_current" value="<?php echo $epfAmtCurrent; ?>"></td><td><small>(Your current savings in EPF)</small></td></tr>
                <tr><td>(5) EPF Yearly (MYR)</td><td><input name="epf_amt_early" value="<?php echo $epfAmtYearly; ?>"></td><td><small>(Your yearly EPF contribution)</small></td></tr>
                <tr><td>(6) EPF Dividend (%)</td><td><input name="epf_dev_perc" value="<?php echo $epfDivPerc * 100; ?>"></td><td><small>(Estimated EPF Dividend %)</small></td></tr>
                <tr><td>(7) Yearly Expenses (MYR)</td><td><input name="exp_yearly" value="<?php echo $expYearly; ?>"></td><td><small>(Your intending yearly expense in today's value. Example, MYR 5000 / month = MYR 60000 / year)</small></td></tr>
                <tr><td>(8) Yearly Expenses Inflation (%)</td><td><input name="exp_infla" value="<?php echo $expinf * 100; ?>"></td><td><small>(Estimated inflation rate %)</small></td></tr>
                <tr><td></td><td><input type="submit" value="Submit"></td><td><small>(Click submit to recompute the results below)</small></td></tr>
            </table>
        </form>
        <h2>Result</h2>
        <table border="1" width="100%">
            <tr>
                <th>Year</th>
                <th>Age</th>
                <th>(A) EPF Starting Balance (MYR)<br>(4) or (D)</th>
                <th>(B) EPF Ending Balance (MYR)<br>(A) + (5) or after (3) then (A) - (previous E)</th>
                <th>(C) EPF Dividend (MYR)<br>(B) * (6)</th>
                <th>(D) EPF Remaining Total (MYR)<br>(B) + (C)</th>
                <th>(E) Expenses Value Inflation Adjusted (MYR)<br>(7) * (8)</th>
            </tr>
            <?php for ($year = 1; $year < ($dieAge - $currentAge + 1); $year++) { ?>
                <tr style="<?php if ($currentAge + $year == $retireAge) echo "background: cyan" ?>">
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
                        else
                            $epfDiv = 0;
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

