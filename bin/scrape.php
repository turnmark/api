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
            $program['preview'] = normalizeObject(
                $previewBulk[$stadiumNumber][$raceNumber] ?? [],
                ['racers']
            );

            $program['odds'] = normalizeObject(
                $oddsBulk[$stadiumNumber][$raceNumber] ?? [],
                ['trifecta', 'trio', 'exacta', 'quinella', 'quinella_place', 'win', 'place']
            );

            $program['result'] = normalizeObject(
                $resultBulk[$stadiumNumber][$raceNumber] ?? [],
                ['racers']
            );

            $payload['programs']['stadiums'][$stadiumNumber]['races'][$raceNumber] = $program;
        }
    }
}

if ($payload === []) {
    exit;
}

Saver::save($payload, "docs/{$version}/" . $yesterday->format('Y') . '/' . $yesterday->format('Ymd') . '.json');

/**
 * @param array $payload
 * @param array $keys
 * @return array
 */
function normalizeObject(array $payload, array $keys): array
{
    foreach ($keys as $key) {
        if (isset($payload[$key]) && $payload[$key] === []) {
            $payload[$key] = new stdClass();
        }
    }

    return $payload;
}
