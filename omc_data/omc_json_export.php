<?php
$app->get('omc/json/{id}', function ($id) use ($app) {
    $moduleId = $id;
    $jsonData = array();

    if (!$moduleId) {
        $error = array('message' => 'The user was not found.');
        return $app->json($error, 404);
    }

    $sql = "SELECT * FROM modules WHERE id = ?";
    $dbData = $app['db']->fetchAssoc($sql, array((int) $moduleId));

    $sql = "SELECT name FROM vendors WHERE id = ?";
    $dbData2 = $app['db']->fetchAssoc($sql, array((int) $dbData["vendor"]));

    $jsonData["name"] = $dbData["title"];
    $jsonData["vendor"] = $dbData2["name"];
    $jsonData["type"] = "oxid";
    $jsonData["picture"] = $dbData["url_picture"];
    $jsonData["price"] = number_format($dbData["price"], 2, ".", "");
    $jsonData["license"] = $dbData["license"];
    $jsonData["desc"]["en"] = $dbData["desc_en"];
    $jsonData["desc"]["de"] = $dbData["desc_de"];

    // tags
    $tags = str_replace(", ", ",", $dbData["tags"]);
    $tagsData = explode(",", $tags);
    foreach($tagsData as $tag) {
        $jsonDataTags[] = trim($tag);
    }
    $jsonData["tags"] = $jsonDataTags;

    // shop versions
    $versions = str_replace(", ", ",", $dbData["shop_versions"]);
    $versionsData = explode(",", $versions);
    foreach($versionsData as $version) {
        $jsonDataVersions[] = trim($version);
    }

    // version
    $jsonData["versions"][$dbData["module_version"]] = array(
        "project" => $dbData["url_info"],
        "url" => $dbData["url_download"],
        "supported" => $jsonDataVersions,
        "mapping" => array(
            "src" => $dbData["mapping_src"],
            "dest" => $dbData["mapping_dest"],
        ),
    );

    // vendor directory
    $dirName = __DIR__.'/export/'.$dbData2["name"].'/';
    if(!file_exists($dirName)) {
        mkdir($dirName);
    }
    $fileName = preg_replace('/[^a-zA-Z0-9\']/', '_', $dbData["title"]);
    $fileName = str_replace("'", '', $fileName);
    $fileName = strtolower($fileName.'.json');

    $fileData = json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    #$fileData = str_replace("\/", "/", $fileData);

    // json file
    if(file_put_contents($dirName.$fileName, $fileData)) {
        echo '<span style="color: green;">file successfully created</span>';
        $recipeUrl = 'https://github.com/OXIDprojects/OXID-Modul-Connector/blob/recipes/'.$dbData2["name"].'/'.$fileName;
        $sql = "UPDATE modules SET url_recipe = ? WHERE id = ?";
        $app['db']->executeUpdate($sql, array($recipeUrl, (int) $dbData["id"]));
    } else {
        echo '<span style="color: red;">file creation failed</span>';
    }

    echo '<br><br><pre>';
    print_r($jsonData);
    echo '</pre>';
    exit;
    #return $app->json($jsonData);
});