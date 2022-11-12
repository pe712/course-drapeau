<?php

use SimpleExcel\SimpleExcel;

class Excel
{
    public static function loadExcel($filename, $n)
    {
        require("../lib/SimpleExcel/SimpleExcel.php");
        $excel = new SimpleExcel('CSV');
        $excel->parser->loadFile($filename);
        $data = $excel->parser->getField();
        var_dump($data);
    }
}
