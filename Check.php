<?php

$links = file('links.txt', FILE_IGNORE_NEW_LINES);

file_put_contents('ONLINE.txt', '');

foreach($links as $url) {

    $content = file_get_contents($url);

    if(strpos($content, '</strong>, you can view and join <br>') !== false) {

        file_put_contents('ONLINE.txt', $url . PHP_EOL, FILE_APPEND);

        echo 'live - ' . $url . PHP_EOL;
    } else {
        echo 'dead - ' . $url . PHP_EOL;
    }
}

?>