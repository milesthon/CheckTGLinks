<?php

$links = file('links.txt', FILE_IGNORE_NEW_LINES);

file_put_contents('ONLINE.txt', '');

foreach($links as $url) {

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $content = curl_exec($ch);
    curl_close($ch);

    if(strpos($content, '</strong>, you can view and join <br>') !== false) {

        file_put_contents('ONLINE.txt', $url . PHP_EOL, FILE_APPEND);

        echo 'live - ' . $url . PHP_EOL;
    } else {
        echo 'dead - ' . $url . PHP_EOL;
    }
}

?>
