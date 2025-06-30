<?php
/**
 * Data access class to read and write json files
 */
class dbManager
{
    /**
     * Read json and return associative array
     * @return mixed array si reussi, array vide autrement
     */
    function readJSON()
    {
        $path_lower = dirname(__DIR__) . "/db.json";
        $path_upper = dirname(__DIR__) . "/db.JSON";

        $file_contents = file_get_contents($path_lower);

        // If .json doesn't work, tries .JSON
        if ($file_contents === false || $file_contents === '') {
            $file_contents = file_get_contents($path_upper);
        }

        $json_data = json_decode($file_contents, true);

        if ($json_data) {
            return $json_data;
        }
        return [];
    }

    /**
     * Save data as json
     * @param mixed $data
     * @return void
     */
    function writeJSON($data) {
        $json_data = json_encode($data, JSON_PRETTY_PRINT);
        // Toujours enregistrer compteur.json
        file_put_contents(dirname(__DIR__) . "/db.json", $json_data);
    }
}