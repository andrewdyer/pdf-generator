<?php

declare(strict_types=1);

namespace AndrewDyer\PdfGenerator\Tests\Unit\Values;

use AndrewDyer\PdfGenerator\Values\Content;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for Content.
 */
final class ContentTest extends TestCase
{
    /**
     * Asserts that Content stores the provided view name.
     */
    public function testStoresView(): void
    {
        $content = new Content(view: 'invoice');

        $this->assertSame('invoice', $content->view);
    }

    /**
     * Asserts that Content uses an empty array as the default data.
     */
    public function testDefaultData(): void
    {
        $content = new Content(view: 'invoice');

        $this->assertSame([], $content->data);
    }

    /**
     * Asserts that Content stores the provided data.
     */
    public function testCustomData(): void
    {
        $data = ['title' => 'Invoice #001', 'total' => 99.99];
        $content = new Content(view: 'invoice', data: $data);

        $this->assertSame($data, $content->data);
    }
}
