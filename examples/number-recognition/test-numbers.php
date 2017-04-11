<?php

require_once '../../vendor/autoload.php';

use Alcalyn\NeuralNetwork\Network;

$network = new Network([49, 64, 64, 11]);
$network->e = 1;


$samples = require 'number-samples.php';

$mod = 0;

while ($mod < 300) {
    $mod++;
    $refresh = 0 === ($mod % 1);

    if ($refresh) {
        $ratio = [0, 0];
        $display = '';
    }

    foreach ($samples as $sample) {
        $out = $network->trainInput($sample[0], $sample[1]);

        if ($refresh) {
            $expect = implode('', $sample[1]);
            $given = renderOutput($out);
            $display .= "expect $expect ; given $given".PHP_EOL;
            $ratio[1]++;
            if ($expect === $given) {
                $ratio[0]++;
            }
        }
    }

    if ($refresh) {
        $display .= 'e = '.f($network->e).PHP_EOL;
        $display .= 'Learn: '.implode(' / ', $ratio).PHP_EOL;
        $display .= 'Iteration: '.$mod.PHP_EOL;
        system('clear');
        echo $display;
    }

    if ($network->e > 0.01) $network->e *= 0.992;
}

$test = [];

$test []= $network->pulseInput([
    0, 0, 0, 0, 0, 0, 0,
    0, 0, 0, 0, 0, 0, 0,
    0, 0, 0, 0, 0, 0, 0,
    0, 0, 0, 0, 0, 0, 0,
    0, 0, 0, 0, 0, 0, 0,
    0, 0, 0, 0, 0, 0, 0,
    0, 0, 0, 0, 0, 0, 0,
]);

$test []= $network->pulseInput([
    0, 0, 1, 1, 1, 0, 0,
    0, 1, 0, 0, 0, 1, 0,
    0, 1, 0, 0, 0, 1, 0,
    0, 1, 0, 0, 0, 1, 0,
    0, 1, 0, 0, 0, 1, 0,
    0, 0, 1, 1, 1, 0, 0,
    0, 0, 0, 0, 0, 0, 0,
]);

$test []= $network->pulseInput([
    0, 0, 0, 0, 0, 0, 0,
    0, 0, 0, 1, 0, 0, 0,
    0, 0, 1, 1, 0, 0, 0,
    0, 1, 0, 1, 0, 0, 0,
    0, 0, 0, 1, 0, 0, 0,
    0, 0, 0, 1, 0, 0, 0,
    0, 0, 0, 1, 0, 0, 0,
]);

$test []= $network->pulseInput([
    0, 0, 1, 1, 0, 0, 0,
    0, 1, 0, 0, 1, 0, 0,
    0, 1, 0, 0, 1, 0, 0,
    0, 0, 0, 0, 1, 0, 0,
    0, 0, 0, 1, 0, 0, 0,
    0, 0, 1, 0, 0, 0, 0,
    0, 1, 1, 1, 1, 1, 0,
]);

$test []= $network->pulseInput([
    0, 1, 1, 1, 1, 0, 0,
    0, 0, 0, 0, 1, 0, 0,
    0, 0, 0, 1, 0, 0, 0,
    0, 0, 1, 1, 1, 0, 0,
    0, 0, 0, 0, 0, 1, 0,
    0, 0, 0, 0, 0, 1, 0,
    0, 0, 1, 1, 1, 0, 0,
]);

$test []= $network->pulseInput([
    0, 0, 0, 1, 0, 0, 0,
    0, 0, 1, 0, 0, 0, 0,
    0, 0, 1, 0, 0, 0, 0,
    0, 1, 0, 1, 0, 0, 0,
    0, 1, 1, 1, 1, 0, 0,
    0, 0, 0, 1, 0, 0, 0,
    0, 0, 0, 0, 0, 0, 0,
]);

$test []= $network->pulseInput([
    0, 0, 1, 1, 1, 0, 0,
    0, 1, 0, 0, 0, 0, 0,
    0, 1, 1, 1, 0, 0, 0,
    0, 0, 0, 0, 1, 0, 0,
    0, 0, 0, 0, 1, 0, 0,
    0, 1, 1, 1, 0, 0, 0,
    0, 0, 0, 0, 0, 0, 0,
]);

$test []= $network->pulseInput([
    0, 0, 0, 1, 0, 0, 0,
    0, 0, 1, 0, 0, 0, 0,
    0, 0, 1, 0, 0, 0, 0,
    0, 1, 0, 1, 0, 0, 0,
    0, 1, 0, 0, 1, 0, 0,
    0, 0, 1, 1, 0, 0, 0,
    0, 0, 0, 0, 0, 0, 0,
]);

$test []= $network->pulseInput([
    0, 0, 1, 1, 1, 0, 0,
    0, 0, 0, 0, 1, 0, 0,
    0, 0, 0, 1, 1, 1, 0,
    0, 0, 0, 0, 1, 0, 0,
    0, 0, 0, 1, 0, 0, 0,
    0, 0, 0, 1, 0, 0, 0,
    0, 0, 0, 1, 0, 0, 0,
]);

$test []= $network->pulseInput([
    0, 0, 1, 1, 0, 0, 0,
    0, 1, 0, 0, 1, 0, 0,
    0, 1, 0, 0, 1, 0, 0,
    0, 0, 1, 1, 1, 0, 0,
    0, 1, 0, 0, 1, 0, 0,
    0, 1, 0, 0, 1, 0, 0,
    0, 0, 1, 1, 0, 0, 0,
]);

$test []= $network->pulseInput([
    0, 0, 1, 1, 1, 0, 0,
    0, 1, 0, 0, 0, 1, 0,
    0, 1, 0, 0, 0, 1, 0,
    0, 0, 1, 1, 1, 1, 0,
    0, 0, 0, 0, 0, 1, 0,
    0, 0, 0, 0, 0, 1, 0,
    0, 0, 1, 1, 1, 0, 0,
]);

$test []= $network->pulseInput([
    1, 0, 0, 0, 0, 1, 0,
    0, 0, 0, 1, 0, 0, 0,
    0, 0, 1, 1, 1, 0, 1,
    0, 0, 1, 0, 0, 1, 0,
    1, 0, 0, 0, 0, 0, 0,
    0, 1, 0, 0, 1, 1, 0,
    0, 0, 1, 0, 0, 1, 1,
]);


echo 'test:'.PHP_EOL;

foreach ($test as $t) {
    echo renderOutput($t).PHP_EOL;
}


function renderOutput($out) {
    $s = '';

    foreach ($out as $o) {
        $s .= $o > 0.5 ? '1' : '0';
    }

    return $s;
}



function f($float) {
    return number_format($float, 3, '.', '');
}

