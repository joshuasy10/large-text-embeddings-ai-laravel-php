<?php

namespace App\Helpers;

use League\Csv\Reader;

class Documents
{

    public static function getOlympicsData($limit = null){
        $url = 'https://cdn.openai.com/API/examples/data/olympics_sections_text.csv';
        return self::getRemoteCSV($url, $limit);
    }

    public static function getRemoteCSV($url, $limit = null){

        $file = fopen($url, 'r');

        $ds = [];

        $headers = fgetcsv($file);
        // Loop through each row in the CSV file
        while (($data = fgetcsv($file)) !== FALSE) {
            $temp = [];
            foreach ($headers as $key => $value) {
                $temp[$value] = $data[$key];
            }
            $ds[] = $temp;
        }
        fclose($file);

        if($limit)
            return array_slice($ds, 0, $limit);
        else
            return $ds;
    }
}
