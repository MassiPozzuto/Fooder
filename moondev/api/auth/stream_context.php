<?php

$postdata = http_build_query(
    array(
        "auth_method" => "false",
        'email' => 'nico205@gmail.com',
        'password1' => 'EE$$$77eeGg',
        "saveCookie" => 'true'
    )
);

$opts = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata
    )
);
//https://stackoverflow.com/questions/2090723/how-to-get-the-relative-directory-no-matter-from-where-its-included-in-php
$current_directory = substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT']));

$context = stream_context_create($opts);

$result = file_get_contents("http://localhost/" . $current_directory . "/authentification.php", false, $context);
echo(json_encode($result));
?>