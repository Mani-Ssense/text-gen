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

    for ($i = 0; $i < (strlen($text) - $numberOfChars); $i++) {
        $subString = substr($text, $i, $numberOfChars);
        $charCount = substr($text, $i + $numberOfChars, 1);
        if (isset($table[$subString][$charCount])) {
            $table[$subString][$charCount]++;
        } else {
            $table[$subString][$charCount] = 1;
        }
    }

    return $table;
}

function replaceCountWithProb(&$table) 
{
    foreach ($table as $k => $v) {
        $sum = array_sum($v);
        foreach($v as $char => $charCount) {
            $table[$k][$char] = $charCount / $sum;
        }
    }
}

$text = file_get_contents('shakespeare_input.txt');
$table = getKeysFromText($text, 3);
replaceCountWithProb($table);

echo count($table);
echo PHP_EOL;

$c = 0;
foreach ($table as $k => $v) {
    var_dump($k);
    var_dump($v);
    echo PHP_EOL;
    $c++;
    if ($c > 0) {
        return;
    }
}
