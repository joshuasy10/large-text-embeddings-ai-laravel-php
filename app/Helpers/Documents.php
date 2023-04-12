<?php

namespace App\Helpers;

use League\Csv\Reader;

class Documents
{

    public static function getOlympicsData($limit = null){
        $url = 'https://cdn.openai.com/API/examples/data/olympics_sections_text.csv';
        return self::getRemoteCSV($url, $limit);
    }
    public static function getOlympicsEmbeddings($limit = null, $onlyEmbeddings = true){
        $url = 'https://cdn.openai.com/API/examples/data/olympics_sections_document_embeddings.csv';
        $ds = self::getRemoteCSV($url, $limit);

        if ($onlyEmbeddings) {
            // remove the first 2 rows of each array in result
            foreach ($ds as $key => $value) {
                unset($ds[$key]['title']);
                unset($ds[$key]['heading']);
            }
        }
        return $ds;
    }

    public static function getRemoteCSV($url, $limit = null){

        $file = fopen($url, 'r');

        $ds = [];

        $headers = fgetcsv($file);
        // Loop through each row in the CSV file
        $count = 0;
        while (($data = fgetcsv($file)) !== FALSE && (!$limit || $count++ <= $limit)) {
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
