<?php
$links = file('links.txt', FILE_IGNORE_NEW_LINES);
file_put_contents('ONLINE.txt', '');

$dom = new DOMDocument;
$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

echo "1 - No name ( https:t.me/Sample )" , PHP_EOL;
echo "2 - Name ( Sample - https:t.me/Sample )" , PHP_EOL;
echo "choice: ";
$handle = fopen ("php://stdin","r");
$line = fgets($handle);
if(trim($line) != '1' && trim($line) != '2'){
    echo "Неверный ввод!\n";
    exit;
}

$choice = trim($line);

foreach($links as $url) {
    curl_setopt($ch, CURLOPT_URL, $url);
    $html = curl_exec($ch);
    if(curl_errno($ch)) {
        echo 'ERROR - ' . $url . PHP_EOL;
        continue;
    }
    @$dom->loadHTML($html);
    $spans = $dom->getElementsByTagName('span');
    $spanValue = null;
    foreach ($spans as $span) {
        if ($span->hasAttribute('dir') && $span->getAttribute('dir') == 'auto') {
            $spanValue = $span->nodeValue;
        }
    }
    if(strpos($html, '<div class="tgme_page_additional">') !== false) {
        if ($choice == '1') {
            file_put_contents('ONLINE.txt', $url . PHP_EOL, FILE_APPEND);
            echo 'LIVE - ' . $url . PHP_EOL;
        } else if ($choice == '2' && $spanValue) {
            file_put_contents('ONLINE.txt', $spanValue . ' - ' . $url . PHP_EOL, FILE_APPEND);
            echo 'LIVE - ' . $spanValue . ' - '. $url . PHP_EOL;
        }
    } else {
        echo 'DEAD - ' . $url . PHP_EOL;
    }
}

curl_close($ch);
?>
