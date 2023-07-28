<?php

function findUniqueString(string $s): int
{
    if (!filter_var(strlen($s), FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_rage' => 10 ** 5]])) {
        throw new InvalidArgumentException("String length mismatch for '{$s}'");
    }

    if (!preg_match('/^[a-z]+$/', $s)) {
        throw new InvalidArgumentException("Illegal characters found in string '{$s}', allowed only small letters a-z");
    }

    return !($test = array_search(1, array_count_values(str_split($s)), true)) ? -1 : strpos($s, $test) + 1;
}

$testcase = [
    'aaabbb',
    '',
    '     ',
    'hashthegame',
    'statistics',
    'ala ma kota',
    'alamakota',
    'staTistIcs',
];

foreach ($testcase as $test) {
    try {
        printf('%-40s => %s' . PHP_EOL, "'{$test}'", findUniqueString($test));
    } catch (InvalidArgumentException $e) {
        echo $e->getMessage() . PHP_EOL;
    }
}
