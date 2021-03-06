<?php


/**
 * Creates a database connection
 *
 * @return PDO
 */
function getDb(): PDO
{
    $db = new PDO('mysql:host=db; dbname=marcus-collection', 'root', 'password');
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $db;
}

/**
 * Gets an array from a database
 *
 * @param PDO $db
 *
 * @return array|false
 */
function getRecordsFromDB(PDO $db): array
{
    $query = $db->prepare("SELECT `cover`, `name`, `band`, `release`, `numSongs` FROM `albums`;");
    $query->execute();
    return $query->fetchAll();
}

/**
 * Takes a YYYY-MM-DD date and returns a DD/MM/YYYY date
 *
 * @param string $date
 *
 * @return string
 */
function formatDate(string $date): string
{
    if (strtotime($date) === false) {
        return 'Invalid Date';
    }
    $formattedDate = date_create($date);
    return date_format($formattedDate,"jS F Y");
}

/**
 * Takes in an array of information and returns it in a readable string with an image
 *
 * @param array $records
 *
 * @return string
 */
function displayRecords(array $records): string
{
    if ($records === []) {
        return 'Sorry, missing records';
    }
    $result = '';
    foreach ($records as $record) {
        $result .= '<div class="textbox">' . '<img src="' . $record['cover'] . '" alt="Album cover">' . '<p>' . $record['name'] . ' is an album by ' . $record['band'] . '. The album was released on ' . formatDate($record['release']) . ' and has ' . $record['numSongs'] . ' songs.' . '</p>' . '</div>';
    }
    return $result;
}
