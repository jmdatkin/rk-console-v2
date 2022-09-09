<?php

namespace App\Services;

use Illuminate\Support\Collection;

class CSVProcessorService {
    /**
     * Parses a string in csv format into a collection
     * 
     * @property string|array $header
     * @property string|array $row
     * 
     * @param string $csv_string
     * @return array
     */
    public function parse($csv_string, $row_delimeter = "\r\n", $col_delimeter = ","): array {

        if (strlen($csv_string) <= 0) return collect();
        $rows = explode($row_delimeter, $csv_string);

        $data = array_map(fn ($row) => str_getcsv($row, $col_delimeter), $rows);


        $header = $data[0];             // Col names


        $body = array_slice($data, 1);  // Data

        $csv = array();

        foreach ($body as $row) {
            $csv[] = array_combine($header, $row);
        }

        return $csv;
    }
}