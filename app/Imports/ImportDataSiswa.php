<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Imports\ImportDataSiswaSheet;

class ImportDataSiswa implements WithMultipleSheets
{
    protected $sheetImport;

    public function __construct()
    {
        $this->sheetImport = new ImportDataSiswaSheet();
    }

    public function sheets(): array
    {
        return [
            0 => $this->sheetImport,
        ];
    }

    public function failures()
    {
        return $this->sheetImport->failures();
    }
}
