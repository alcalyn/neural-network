<?php

require_once 'vendor/autoload.php';

$network = new Network([2, 8, 2]);
$network->e = 1;


//echo $network;

$samples = [
    [[0, 0], [1, 0]],
    [[0, 1], [1, 1]],
    [[1, 0], [1, 0]],
    [[1, 1], [1, 0]],
];

$mod = 0;

while ($mod < 100000) {
    $mod++;
    $refresh = 0 === ($mod % 1000);

    if ($refresh) $display = '';

    foreach ($samples as $sample) {
        $out = $network->trainInput($sample[0], $sample[1]);

        if ($refresh) $display .= implode('', $sample[0]).' ; out = '.f($out[0]).' '.f($out[1]).PHP_EOL;
    }

    if ($refresh) $display .= 'e = '.f($network->e).PHP_EOL;

    if ($refresh) system('clear');
    if ($refresh) echo $display;

    if ($network->e > 0.01) $network->e *= 0.999995;
}


echo $network;

function f($float) {
    return number_format($float, 3, '.', '');
}

