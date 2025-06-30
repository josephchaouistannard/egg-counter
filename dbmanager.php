<?php
/**
 * Data access class to read a json file to an associative array
 */
class Dbaccess
{
    /**
     * Retourne toutes les offres contenus dans un fichier JSON.
     * @return mixed array si reussi, array vide autrement
     */
    function chargerToutesOffresJSON()
    {
        $file_contents = file_get_contents(dirname(__DIR__) . "/db.json");
        $data = json_decode($file_contents, true);
        if ($data) {
            return $data;
        }
        return [];
    }
}
