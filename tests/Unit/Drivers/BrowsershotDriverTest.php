<?php

declare(strict_types=1);

namespace AndrewDyer\PdfGenerator\Tests\Unit\Drivers;

use AndrewDyer\PdfGenerator\Contracts\DriverInterface;
use AndrewDyer\PdfGenerator\Drivers\BrowsershotDriver;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for BrowsershotDriver.
 */
final class BrowsershotDriverTest extends TestCase
{
    /**
     * Asserts that BrowsershotDriver implements DriverInterface.
     */
    public function testImplementsDriverInterface(): void
    {
        $this->assertInstanceOf(DriverInterface::class, new BrowsershotDriver());
    }

    /**
     * Asserts that BrowsershotDriver can be instantiated with default values.
     */
    public function testCanBeInstantiatedWithDefaults(): void
    {
        $this->assertInstanceOf(BrowsershotDriver::class, new BrowsershotDriver());
    }

    /**
     * Asserts that BrowsershotDriver can be instantiated with custom binary paths.
     */
    public function testCanBeInstantiatedWithCustomBinaryPaths(): void
    {
        $driver = new BrowsershotDriver(
            nodeBinary: '/usr/local/bin/node',
            npmBinary: '/usr/local/bin/npm',
            chromiumPath: '/usr/bin/chromium',
        );

        $this->assertInstanceOf(BrowsershotDriver::class, $driver);
    }

    /**
     * Asserts that BrowsershotDriver can be instantiated with custom margins.
     */
    public function testCanBeInstantiatedWithCustomMargins(): void
    {
        $driver = new BrowsershotDriver(
            marginTop: 20,
            marginRight: 15,
            marginBottom: 20,
            marginLeft: 15,
        );

        $this->assertInstanceOf(BrowsershotDriver::class, $driver);
    }
}
