<?php

$dsn = 'mysql:dbname=omc;host=127.0.0.1';
$user = 'omc';
$password = 'omc';

try {
    $url = $_POST['feed'];

    if (filter_var($url, FILTER_VALIDATE_URL) === false) {
        throw new Exception('URL not valid.');
    }

    $mapping = [];
    $mappingRaw = explode("\n", $_POST['mapping']);
    foreach ($mappingRaw as $map) {
        $map = trim($map);

        if (preg_match('/^[-a-zA-z0-9_]+:[-a-zA-z0-9_]+$/', $map) != 1) {
            throw new Exception('Mapping not valid.');
        }

        $map = explode(':', $map);
        $mapping[$map[0]] = $map[1];
    }

    $feedList = [
        [
            'url' => $url,
            'mapping' => $mapping
        ]
    ];

    $db = new PDO($dsn, $user, $password);

    foreach ($feedList as $feed) {

        $xml = new DOMDocument();
        $xml->load($feed['url']);

        $xpath = new DOMXpath($xml);
        $elements = $xpath->query("/rss/channel/item");

        $columnList = array_keys($feed['mapping']);
        $sql = "INSERT IGNORE INTO modules (" . implode(', ', $columnList) . ", created_at, updated_at) "
            . "VALUES (:" . implode(', :', $columnList) . ", NOW(), NOW())";
        $statement = $db->prepare($sql, [PDO::ERRMODE_EXCEPTION]);

        for ($i = 0; $i < $elements->length; $i++) {
            $module = $elements->item($i);

            $childNodes = [];
            foreach ($module->childNodes AS $item) {
                $childNodes[$item->nodeName] = $item->nodeValue;
            }

            $sqlParameters = [];
            foreach ($feed['mapping'] as $column => $xmlTag) {
                $sqlParameters[':' . $column] = $childNodes[$xmlTag];
            }

            $statement->execute($sqlParameters);
        }
    }

    echo "Luckily there wasn't any problem.\n";

} catch (PDOException $e) {
    echo 'Database error: ' . $e->getMessage() ."\n";
} catch (DOMException $e) {
    echo 'Download failed: ' . $e->getMessage() ."\n";
} catch (Exception $e) {
    echo 'Something terrible has gone completely wrong: ' .$e->getMessage() ."\n";
}
