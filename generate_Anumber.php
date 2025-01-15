<?php

$currentYear = date('y');
$startYear = 20; // Tahun 2020
$endYear = 24;   // Tahun 2024

$anumbers = [];
$startingIndex = 2604; // Nomor ID mulai dari 2605

$minNumber = 604; // Nomor minimum
$maxNumber = 999; // Nomor maksimum

for ($year = $startYear; $year <= $endYear; $year++) {
    $yearPrefix = 'A' . $year;

    for ($number = $minNumber; $number <= $maxNumber; $number++) {
        $aNumber = $yearPrefix . str_pad($number, 4, '0', STR_PAD_LEFT);
        $anumbers[] = $aNumber;
    }
}

$csvFileName = 'anumbers.csv';
$file = fopen($csvFileName, 'w');
fputcsv($file, ['id', 'A Number']);

foreach ($anumbers as $index => $aNumber) {
    $id = $startingIndex + $index + 1;
    fputcsv($file, [$id, $aNumber]);
}

fclose($file);


