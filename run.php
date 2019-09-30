<?php

function getKeysFromText($text, $numberOfChars = 3)
{
    $table = [];

    for ($i = 0; $i < strlen($text) - $numberOfChars; $i++) {
        $subString = substr($text, $i, $numberOfChars);
        if (!isset($table[$subString])) {
            $table[$subString] = [];
        }
    }

    return $table;
}

$text = file_get_contents('shakespeare_input.txt');
$table = getKeysFromText($text, 3);
echo count($table);
echo PHP_EOL;

$c = 0;
foreach ($table as $k => $v) {
    var_dump($k);
    var_dump($v);
    echo PHP_EOL;
    $c++;
    if ($c > 9) {
        return;
    }
}
