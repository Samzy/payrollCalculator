<?php

namespace Payroll;

use PHPUnit\Framework\TestCase;

class PayrollDateCalculatorTest extends TestCase
{
    /**
     * @test
     * @dataProvider dataProvider
     */
    public function testPayrollCalculatorReturnCorrectDays($paymentYear, $locale, $month, $result)
    {
        $payrollCalculator = new PayrollDateCalculator($paymentYear, $locale);
        $this->assertSame($result, $payrollCalculator->getPaymentDates($month));
    }

    public function dataProvider()
    {
        return [
            ['2017', 'en-gb', '01', ['January', '2017-01-02', '2017-01-16', '2017-01-31']],
            ['2016', 'en-gb', '12', ['December', '2016-12-01', '2016-12-15', '2016-12-30']],
            ['2016', 'en-gb', '10', ['October', '2016-10-03', '2016-10-17', '2016-10-31']],
            ['2016', 'en-gb', '07', ['July', '2016-07-01', '2016-07-15', '2016-07-29']],
        ];
    }
}