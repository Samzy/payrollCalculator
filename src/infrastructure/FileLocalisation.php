<?php

namespace Payroll\Infrastructure;


class FileLocalisation
{
    private $enGbHeaders = array(
        'Month Name',
        '1st expenses day',
        '2nd expenses day',
        'Salary day'
    );

    public function getFileHeaders($locale)
    {
        switch ($locale) {
            case $locale == 'en-GB' :
                return $this->enGbHeaders;
            default:
                return $this->enGbHeaders;
        }
    }
}
