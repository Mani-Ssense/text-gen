<?php
require "vendor/autoload.php";
Predis\Autoloader::register();
try {
    $redis = new Predis\Client([
        "scheme" => "tcp",
        "host" => "localhost",
        "port" => 6379
    ]);
    //Your code
} catch (Exception $e) {
    //Note: bad practice to catch general exception, but you are exiting
    error_log('error with Redis ' . $e->getMessage());
    exit;
}

function getKeysFromText($text, $numberOfChars = 3)
{
    $table = [];

    for ($i = 0; $i < strlen($text) - $numberOfChars; $i++) {
        $subString = substr($text, $i, $numberOfChars);
        if (!isset($table[$subString])) {
            $table[$subString] = [];
        }

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
        foreach ($v as $char => $charCount) {
            $table[$k][$char] = $charCount / $sum;
        }

        $table[$k] = json_encode($table[$k]);
    }
}

$text = file_get_contents('shakespeare_input.txt');
$table = getKeysFromText($text, 10);
replaceCountWithProb($table);

echo count($table);
echo PHP_EOL;

foreach ($table as $k => $v) {
    $redis->set($k, $v);
}
