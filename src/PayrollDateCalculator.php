<?php

namespace Payroll;


class PayrollDateCalculator
{
    /**
     * @var String
     */
    private $paymentYear;

    /**
     * @var \DateTime
     */
    private $paymentDate;

    /**
     * @var arrays
     */
    private $dates;

    public function __construct($paymentYear, $locale)
    {
        $this->paymentYear = $paymentYear;
    }

    /**
     * @param $month
     * @return array
     */
    public function getPaymentDates($month): array
    {

        $this->paymentDate = \DateTime::createFromFormat('d-m-Y', '01-' . $month . '-' . $this->paymentYear);
        $this->dates = array();
        //if we were localising the dates we would use the datetime localisation set in the constructor

        $this->dates[] = $this->paymentDate->format('F');
        $this->appendExpensesDates();
        $this->appendSalaryDate();

        return $this->dates;
    }

    private function appendExpensesDates()
    {
        if ($this->paymentDate->format('N') == 6 || $this->paymentDate->format('N') == 7) {
            $this->dates[] = $this->calculateNextMonday();
        } else {
            $this->dates[] = $this->paymentDate->format('Y-m-d');
        }

        $this->paymentDate->modify('+14 days');

        if ($this->paymentDate->format('N') == 6 || $this->paymentDate->format('N') == 7) {
            $this->dates[] = $this->calculateNextMonday();
        } else {
            $this->dates[] = $this->paymentDate->format('Y-m-d');
        }
    }

    private function appendSalaryDate()
    {
        $lastDayOfMonth = new \DateTime($this->paymentDate->format('Y-m-d'));
        $lastDayOfMonth->modify('last day of this month');

        if ($lastDayOfMonth->format('N') == 6 || $lastDayOfMonth->format('N') == 7) {
            $this->dates[] = $this->calculateLastWorkingDay($lastDayOfMonth);
        } else {
            $this->dates[] = $lastDayOfMonth->format('Y-m-d');
        }
    }

    /**
     * @return string
     */
    private function calculateNextMonday(): string
    {
        if ($this->paymentDate->format('N') == 6) {
            $nextMonday = new \DateTime($this->paymentDate->format('Y-m-d'));
            $nextMonday->modify('+2 days');

            return $nextMonday->format('Y-m-d');
        } elseif ($this->paymentDate->format('N') == 7) {
            $nextMonday = $nextMonday = new \DateTime($this->paymentDate->format('Y-m-d'));
            $nextMonday->modify('+1 days');

            return $nextMonday->format('Y-m-d');
        }

        return '1970-01-01';
    }

    /**
     * @param \DateTime $lastDayOfMonth
     * @return string
     */
    private function calculateLastWorkingDay($lastDayOfMonth): string
    {
        if ($lastDayOfMonth->format('N') == 6) {
            $lastDayOfMonth->modify('-1 days');

            return $lastDayOfMonth->format('Y-m-d');
        } elseif ($lastDayOfMonth->format('N') == 7) {
            $lastDayOfMonth->modify('-2 days');

            return $lastDayOfMonth->format('Y-m-d');
        }

        return '1970-01-01';
    }
}
