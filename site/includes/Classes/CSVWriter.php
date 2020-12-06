<?php

namespace CIS475\Classes;
require 'autoload.php';

class CSVWriter
{
    public $rows = [];
    private $file;
    private $csv;
    
    public function __construct($path = 'php://output')
    {
        $this->file = $path;
        $this->open();
    }
    
    public function open()
    {
        $this->csv = fopen($this->file, 'w');
    }
    
    public function addRow($data)
    {
        fputcsv($this->csv, $data);
        $this->rows[] = $data;
    }
    
    public function __destruct()
    {
        $this->close();
    }
    
    public function close()
    {
        fclose($this->csv);
    }
    
}
