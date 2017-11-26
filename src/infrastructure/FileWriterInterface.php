<?php

namespace Payroll\Infrastructure;


interface FileWriterInterface
{
    public function createFile(): bool;

    public function write($line): bool;
}