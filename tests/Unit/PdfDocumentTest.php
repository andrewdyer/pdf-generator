<?php

declare(strict_types=1);

namespace AndrewDyer\PdfGenerator\Tests\Unit;

use AndrewDyer\PdfGenerator\Tests\Support\Documents\ExamplePdfDocument;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for PdfDocument.
 */
final class PdfDocumentTest extends TestCase
{
    /**
     * Asserts that getView returns the view name from the content value object.
     */
    public function testGetViewReturnsContentView(): void
    {
        $this->assertSame('example.twig.html', (new ExamplePdfDocument())->getView());
    }

    /**
     * Asserts that getData returns the data array from the content value object.
     */
    public function testGetDataReturnsContentData(): void
    {
        $data = ['title' => 'Invoice #001', 'total' => 99.99];

        $this->assertSame($data, (new ExamplePdfDocument(data: $data))->getData());
    }

    /**
     * Asserts that getData returns an empty array when no data is provided to content.
     */
    public function testGetDataReturnsEmptyArrayByDefault(): void
    {
        $this->assertSame([], (new ExamplePdfDocument())->getData());
    }
}
