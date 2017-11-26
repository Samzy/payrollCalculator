<?php

namespace Payroll;

use Payroll\Infrastructure\DelimitedFileWriter;
use Payroll\Infrastructure\FileLocalisation;

class PayrollFile
{
    /**
     * @var DelimitedFileWriter
     */
    private $fileWriter;

    /**
     * @var string
     */
    private $paymentYear;

    /**
     * @var string
     */
    private $locale;

    /**
     * PayrollFile constructor.
     * @param $fileName
     * @param $paymentYear
     * @param $locale
     */
    public function __construct($paymentYear, $fileName, $locale = 'en-GB')
    {
        $this->fileWriter = new DelimitedFileWriter($fileName);
        $this->paymentYear = $paymentYear;
        $this->locale = $locale;
    }

    /**
     * @return string
     */
    public function createPayrollFile()
    {
        if (!$this->fileWriter->createFile()) {
            return "Failed to create file for specified filename";
        }

        $fileLocalisation = new FileLocalisation();
        $this->fileWriter->write($fileLocalisation->getFileHeaders($this->locale));

        $paymentCalculator = new PayrollDateCalculator($this->paymentYear, $this->locale);

        for($month = 1; $month <= 12; $month++) {
            if(!$this->fileWriter->write($paymentCalculator->getPaymentDates($month))){
                return "Failed to complete file, there was an issue writing data to the file";
            }
        }

        return "Success! The file has been completed";
    }
}