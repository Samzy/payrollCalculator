<?php

namespace Payroll\Infrastructure;


class DelimitedFileWriter implements FileWriterInterface
{
    /**
     * @var
     */
    private $file;

    /**
     * @var string
     */
    private $fileName;

    /**
     * @var string
     */
    private $delimiter = ",";


    public function __construct($fileName)
    {
        $this->fileName = __DIR__ . '/../../files/' . $fileName . '.csv';
    }

    /**
     * @return bool
     */
    public function createFile(): bool
    {
        $this->file = fopen($this->fileName, 'w+');

        if ($this->file == null) {
            return false;
        }

        return true;
    }

    /**
     * @param $line
     * @return bool
     */
    public function write($line): bool
    {
        if (!fputcsv($this->file, $line, $this->delimiter)) {
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }
}