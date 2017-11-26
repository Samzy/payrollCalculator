<?php

use \PHPUnit\Framework\TestCase;
use \Payroll\Infrastructure\FileLocalisation;

class FileLocalisationTest extends TestCase
{
    /**
     * @dataProvider getLocalisedHeaders
     * @test
     */
    public function testFileLocalisationReturnsCorrectHeaders($locale, $headers)
    {
        $fileLocalisation = new FileLocalisation();

        $this->assertSame($headers, $fileLocalisation->getFileHeaders($locale));
    }

    public function getLocalisedHeaders()
    {
        return [
            ['en-GB', ['Month Name', '1st expenses day', '2nd expenses day', 'Salary day']]
        ];
    }
}