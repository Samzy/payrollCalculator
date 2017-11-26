<?php

namespace Payroll;


class PayrollDateCalculator
{
    private $paymentYear;

    /*
     * @var DateTime
     */
    private $paymentDate;

    private $dates;

    public function __construct($paymentYear, $locale)
    {
        $this->paymentYear = $paymentYear;
    }

    public function getPaymentDates($month): array
    {

        $this->paymentDate = \DateTime::createFromFormat('d-m-Y', '01-' . $month . '-' . $this->paymentYear);
        $this->dates = array();
        //if we were localising the dates we would use the datetime localisation set in the constructor

        $this->dates[] = $this->paymentDate->format('F');
        $this->getExpensesDates();
        $this->getSalaryDate();

        return $this->dates;
    }

    private function getExpensesDates()
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

    private function getSalaryDate()
    {
        $lastDayOfMonth = new \DateTime($this->paymentDate->format('Y-m-d'));
        $lastDayOfMonth->modify('last day of this month');

        if ($lastDayOfMonth->format('N') == 6 || $lastDayOfMonth->format('N') == 7) {
            $this->dates[] =  $this->calculateLastWorkingDay($lastDayOfMonth);
        } else {
            $this->dates[] = $lastDayOfMonth->format('Y-m-d');
        }
    }

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

        return 0;
    }

    private function calculateLastWorkingDay($lastDayOfMonth): string
    {
        if ($lastDayOfMonth->format('N') == 6) {
            $lastDayOfMonth->modify('-1 days');

            return $lastDayOfMonth->format('Y-m-d');
        } elseif ($lastDayOfMonth->format('N') == 7) {
            $lastDayOfMonth->modify('-2 days');

            return $lastDayOfMonth->format('Y-m-d');
        }

        return 0;
    }
}