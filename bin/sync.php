<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Carbon\CarbonImmutable as Carbon;
use Turnmark\API\Storage;
use Turnmark\Scraper\BatchScraper;

$version = $argv[1] ?? 'v1';

$payload = ['programs' => []];

$yesterday = Carbon::yesterday('Asia/Tokyo');

if ($version === 'v1') {
    $program = BatchScraper::scrapeProgram($yesterday);
    $preview = BatchScraper::scrapePreview($yesterday);
    $odds = BatchScraper::scrapeOdds($yesterday);
    $result = BatchScraper::scrapeResult($yesterday);

    foreach ($program as $stadiumNumber => $races) {
        foreach ($races as $raceNumber => $race) {
            $race['preview'] = $preview[$stadiumNumber][$raceNumber] ?? new stdClass();
            $race['odds'] = $odds[$stadiumNumber][$raceNumber] ?? new stdClass();
            $race['result'] = $result[$stadiumNumber][$raceNumber] ?? new stdClass();

            $payload['programs']['stadiums'][$stadiumNumber]['races'][$raceNumber] = $race;
        }
    }
}

if ($payload['programs'] === []) {
    exit;
}

$yesterdayY = $yesterday->format('Y');
$yesterdayYmd = $yesterday->format('Ymd');

Storage::save("docs/{$version}/{$yesterdayY}/{$yesterdayYmd}.json", $payload);
