<?php

use \PHPUnit\Framework\TestCase;
use \Payroll\Infrastructure\DelimitedFileWriter;

class DelimitedFileWriterTest extends TestCase
{
    public function testDelimitedFileWriterCreatesFileAndWrites()
    {
        $delimitedFileWriter = new DelimitedFileWriter('phpUnitTestFile');

        $testData = array(
            'test',
            'test1',
            'test2',
            'test3',
            'test4'
        );

        $this->assertSame(true, $delimitedFileWriter->createFile());
        $this->assertSame(true, $delimitedFileWriter->write($testData));

        $file =  fopen($delimitedFileWriter->getFileName(), 'r');

        while(($line = fgetcsv($file)) !== false){
            $csvData = $line;
        }

        $this->assertSame($testData, $csvData);

        fclose($file);
        unlink($delimitedFileWriter->getFileName());
    }
}