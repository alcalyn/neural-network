<?php

$dir = './n';

$samples = [];

for ($i = 0; $i < 10; $i++) {
    echo "Scanning samples in $dir/$i/*.png...".PHP_EOL;

    $files = glob("$dir/$i/*.png", GLOB_BRACE);

    foreach ($files as $filename) {
        echo "    Parsing $filename...".PHP_EOL;
        $samples []= generateSample($i, $filename, false);
        $samples []= generateSample($i, $filename, true);
    }
}

echo "Scanning samples in $dir/nan/*.png...".PHP_EOL;

$files = glob("$dir/nan/*.png", GLOB_BRACE);

foreach ($files as $filename) {
    echo "    Parsing $filename...".PHP_EOL;
    $samples []= generateSample(-1, $filename, false);
    $samples []= generateSample(-1, $filename, true);
}



file_put_contents('number-samples.php', '<?php return '.var_export($samples, true).';');



function generateSample($number, $imagePath, $negateImage = false) {
    return [
        imageToArray($imagePath, $negateImage),
        number($number),
    ];
}

function imageToArray($imagePath, $negateImage = false) {
    $image = imagecreatefrompng($imagePath);
    $array = [];

    for ($y = 0; $y < 7; $y++) {
        for ($x = 0; $x < 7; $x++) {
            $rgb = imagecolorat($image, $x, $y);
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;

            $array []= ((($r + $g + $b) > (128 * 3)) xor $negateImage) ? 1 : 0;
        }
    }

    return $array;
}

function number($n) {
    $out = [];

    for ($i = 0; $i < 10; $i++) {
        if ($i === $n) {
            $out []= 1;
        } else {
            $out []= 0;
        }
    }

    return $out;
}
