<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Carbon\CarbonImmutable as Carbon;
use Turnmark\API\Storage;
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
            $program['preview'] = $previewBulk[$stadiumNumber][$raceNumber] ?? new stdClass();
            $program['odds'] = $oddsBulk[$stadiumNumber][$raceNumber] ?? new stdClass();
            $program['result'] = $resultBulk[$stadiumNumber][$raceNumber] ?? new stdClass();

            $payload['programs']['stadiums'][$stadiumNumber]['races'][$raceNumber] = $program;
        }
    }
}

if ($payload['programs'] === []) {
    exit;
}

$yesterdayY = $yesterday->format('Y');
$yesterdayYmd = $yesterday->format('Ymd');

Storage::save("docs/{$version}/{$yesterdayY}/{$yesterdayYmd}.json", $payload);
