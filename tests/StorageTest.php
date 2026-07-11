<?php

declare(strict_types=1);

namespace Turnmark\API\Tests;

use PHPUnit\Framework\TestCase;
use Turnmark\API\Storage;

/**
 * @author shimomo
 */
final class StorageTest extends TestCase
{
    /**
     * @var string
     */
    private string $tempDir;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->tempDir = sys_get_temp_dir() . '/saver_test_' . bin2hex(random_bytes(8));

        if (!mkdir($this->tempDir, 0755, true) && !is_dir($this->tempDir)) {
            $this->fail('Failed to create temp dir: ' . $this->tempDir);
        }
    }

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        if (is_dir($this->tempDir)) {
            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($this->tempDir, \FilesystemIterator::SKIP_DOTS),
                \RecursiveIteratorIterator::CHILD_FIRST
            );

            foreach ($files as $file) {
                $file->isDir() ? rmdir($file->getRealPath()) : unlink($file->getRealPath());
            }

            rmdir($this->tempDir);
        }
    }

    /**
     * @return void
     */
    public function testSave(): void
    {
        $payload = [
            [
                'date' => '2026-05-31',
                'stadium_number' => 6,
                'race_number' => 12,
            ],
        ];

        $path = $this->tempDir . '/payload.json';

        Storage::save($path, $payload);

        $this->assertFileExists($path);

        $content = json_decode(file_get_contents($path), true);

        $this->assertSame($payload, $content);
    }
}
