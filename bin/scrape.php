<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Carbon\CarbonImmutable as Carbon;
use Turnmark\API\Saver;
use Turnmark\Scraper\Scraper;

$version = $argv[1] ?? 'v1';

$payload = ['programs' => []];

$yesterday = Carbon::yesterday('Asia/Tokyo');

if ($version === 'v1') {
    $programBulk = Scraper::scrapeProgramBulk($yesterday);
    $previewBulk = Scraper::scrapePreviewBulk($yesterday);
    $oddsBulk = Scraper::scrapeOddsBulk($yesterday);
    $resultBulk = Scraper::scrapeResultBulk($yesterday);

    foreach ($programBulk as $stadiumNumber => $items) {
        foreach ($items as $raceNumber => $program) {
            $program['preview'] = $previewBulk[$stadiumNumber][$raceNumber] ?? [];
            $program['odds'] = $oddsBulk[$stadiumNumber][$raceNumber] ?? [];
            $program['result'] = $resultBulk[$stadiumNumber][$raceNumber] ?? [];

            $payload['programs']['stadiums'][$stadiumNumber]['races'][$raceNumber] = $program;
        }
    }
}

if ($payload === []) {
    exit;
}

Saver::save($payload, "docs/{$version}/" . $yesterday->format('Y') . '/' . $yesterday->format('Ymd') . '.json');
