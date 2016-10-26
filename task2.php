<?php
$array_swap = function(&$arr, $num) {
    $c = $arr[0];
    $arr[0] = $arr[$num];
    $arr[$num] = $c;
};

$array = [4, 5, 8, 9, 1, 7, 2];

$count = count($array);

foreach ($array as $key => $item) {

    $maxNum = 0;
    $j = $count - $key;
    for ($i = 0; $i < $j; $i++) {
        if ($array[$maxNum] < $array[$i]) {
            $maxNum = $i;
        }
    }

    $array_swap($array, $maxNum);
    $array_swap($array, ($j -1));
}

echo implode(',', $array) . "\n";