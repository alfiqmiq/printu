<?php

declare(strict_types=1);
ini_set('memory_limit', '2G');

/**
 * Maszyna: 8GB RAM, Intel(R) Core(TM) i5-3570 CPU @ 3.40GHz 4c/4t
 * PHP 8.1, FreeBSD 13
 * Program dla wymaganych testów przy użyciu bcmath wykonuje się w ~20sek bez ~4sek
 */
function hashOrder(int $orderId): string
{
//    return str_pad(bcmod(bcadd(bcmul($orderId, 1_234_567), 7_654_321), 10_000_000), 7, '0', STR_PAD_LEFT);
    return str_pad((string)(($orderId * 1_234_567 + 7_654_321) % 10_000_000), 7, '0', STR_PAD_LEFT);
}

try {
    $unique = [];
    echo "Starting test ...." . PHP_EOL;
    $start = microtime(true);
    for ($num = 1; $num <= 9_999_999; $num++) {
        $result = hashOrder($num);
        // printf("num: %7s hash: %7s\n", $num, $result);

        if (!preg_match("/^[0-9]{7}$/", $result)) {
            throw new InvalidArgumentException("Result {$result} does not match regex");
        }

        if (!empty($unique[$result])) {
            throw new InvalidArgumentException("Collision detected for key {$num}:{$unique[$result]} and result {$result}");
        }

        $unique[$result] = $num;
    }

    $time_elapsed_secs = microtime(true) - $start;

    if ($time_elapsed_secs > 60) {
        throw new InvalidArgumentException("Could not finish test in 60 seconds");
    }

    echo "Finished in {$time_elapsed_secs}" . PHP_EOL;
} catch (InvalidArgumentException $e) {
    echo $e->getMessage() . PHP_EOL;
}
