<?php

namespace Payroll\Script;

require_once __DIR__.'/../../vendor/autoload.php';

use Payroll\PayrollFile;

// Basic validation to prevent incorrect arguments
if($argc == 1) {
    echo "Please input the correct number of arguments specified in the readme";

    return;
}

if(!checkdate(01, 01, $argv[1])) {
    echo "Please input a valid year for the first argument, please refer to the readme";

    return;
}

if(!is_string($argv[2])) {
    echo "Please input a valid filename for the second argument, please refer to the readme";

    return;
}

$payrollFile = new PayrollFile($argv[1], $argv[2],'en-GB');

$output = $payrollFile->createPayrollFile();

echo $output;