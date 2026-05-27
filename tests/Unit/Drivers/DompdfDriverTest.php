<?php

declare(strict_types=1);

namespace AndrewDyer\Pdf\Tests\Unit\Drivers;

use AndrewDyer\Pdf\Contracts\DriverInterface;
use AndrewDyer\Pdf\Drivers\DompdfDriver;
use AndrewDyer\Pdf\Enums\Orientation;
use AndrewDyer\Pdf\Enums\PaperSize;
use AndrewDyer\Pdf\Values\Options;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for DompdfDriver.
 */
final class DompdfDriverTest extends TestCase
{
    /**
     * Asserts that DompdfDriver implements DriverInterface.
     */
    public function testImplementsDriverInterface(): void
    {
        $this->assertInstanceOf(DriverInterface::class, new DompdfDriver());
    }

    /**
     * Asserts that generate returns a non-empty PDF string.
     */
    public function testGenerateReturnsPdfString(): void
    {
        $driver = new DompdfDriver();
        $result = $driver->generate('<p>Hello, world</p>', new Options());

        $this->assertStringStartsWith('%PDF-', $result);
    }

    /**
     * Asserts that generate produces output for each supported paper size.
     *
     * @dataProvider paperSizeProvider
     */
    public function testGenerateWithPaperSize(PaperSize $paperSize): void
    {
        $driver = new DompdfDriver();
        $options = new Options(paperSize: $paperSize);
        $result = $driver->generate('<p>Hello, world</p>', $options);

        $this->assertStringStartsWith('%PDF-', $result);
    }

    /**
     * Provides all supported paper sizes.
     *
     * @return array<string, array{PaperSize}>
     */
    public static function paperSizeProvider(): array
    {
        return [
            'A3' => [PaperSize::A3],
            'A4' => [PaperSize::A4],
            'A5' => [PaperSize::A5],
            'Legal' => [PaperSize::Legal],
            'Letter' => [PaperSize::Letter],
        ];
    }

    /**
     * Asserts that generate produces output for each supported orientation.
     *
     * @dataProvider orientationProvider
     */
    public function testGenerateWithOrientation(Orientation $orientation): void
    {
        $driver = new DompdfDriver();
        $options = new Options(orientation: $orientation);
        $result = $driver->generate('<p>Hello, world</p>', $options);

        $this->assertStringStartsWith('%PDF-', $result);
    }

    /**
     * Provides all supported orientations.
     *
     * @return array<string, array{Orientation}>
     */
    public static function orientationProvider(): array
    {
        return [
            'portrait' => [Orientation::Portrait],
            'landscape' => [Orientation::Landscape],
        ];
    }
}
