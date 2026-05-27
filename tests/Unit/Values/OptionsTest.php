<?php

declare(strict_types=1);

namespace AndrewDyer\Pdf\Tests\Unit\Values;

use AndrewDyer\Pdf\Enums\Orientation;
use AndrewDyer\Pdf\Enums\PaperSize;
use AndrewDyer\Pdf\Values\Options;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for Options.
 */
final class OptionsTest extends TestCase
{
    /**
     * Asserts that Options uses the default filename when none is provided.
     */
    public function testDefaultFilename(): void
    {
        $options = new Options();

        $this->assertSame('document.pdf', $options->filename);
    }

    /**
     * Asserts that Options uses A4 as the default paper size.
     */
    public function testDefaultPaperSize(): void
    {
        $options = new Options();

        $this->assertSame(PaperSize::A4, $options->paperSize);
    }

    /**
     * Asserts that Options uses Portrait as the default orientation.
     */
    public function testDefaultOrientation(): void
    {
        $options = new Options();

        $this->assertSame(Orientation::Portrait, $options->orientation);
    }

    /**
     * Asserts that Options uses an empty array as the default metadata.
     */
    public function testDefaultMetadata(): void
    {
        $options = new Options();

        $this->assertSame([], $options->metadata);
    }

    /**
     * Asserts that Options stores the provided filename.
     */
    public function testCustomFilename(): void
    {
        $options = new Options(filename: 'report.pdf');

        $this->assertSame('report.pdf', $options->filename);
    }

    /**
     * Asserts that Options stores the provided paper size.
     */
    public function testCustomPaperSize(): void
    {
        $options = new Options(paperSize: PaperSize::Letter);

        $this->assertSame(PaperSize::Letter, $options->paperSize);
    }

    /**
     * Asserts that Options stores the provided orientation.
     */
    public function testCustomOrientation(): void
    {
        $options = new Options(orientation: Orientation::Landscape);

        $this->assertSame(Orientation::Landscape, $options->orientation);
    }

    /**
     * Asserts that Options stores the provided metadata.
     */
    public function testCustomMetadata(): void
    {
        $metadata = ['author' => 'Jane Doe', 'title' => 'Annual Report'];
        $options = new Options(metadata: $metadata);

        $this->assertSame($metadata, $options->metadata);
    }
}
