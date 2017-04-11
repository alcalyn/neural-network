<?php

require_once '../../vendor/autoload.php';

use Alcalyn\NeuralNetwork\Network;

$network = new Network([2, 4, 1]);
$network->e = 1;


//echo $network;

$samples = [
    [[0, 0], [0]],
    [[0, 1], [1]],
    [[1, 0], [1]],
    [[1, 1], [0]],
];

$mod = 0;

while ($mod < 50000) {
    $mod++;
    $refresh = 0 === ($mod % 100);

    if ($refresh) $display = '';

    foreach ($samples as $sample) {
        $out = $network->trainInput($sample[0], $sample[1]);

        if ($refresh) $display .= implode('', $sample[0]).' ; out = '.f($out[0]).PHP_EOL;
    }

    if ($refresh) $display .= 'e = '.f($network->e).PHP_EOL;

    if ($refresh) system('clear');
    if ($refresh) echo $display;

    if ($network->e > 0.01) $network->e *= 0.99999;
}


echo $network;

function f($float) {
    return number_format($float, 3, '.', '');
}

