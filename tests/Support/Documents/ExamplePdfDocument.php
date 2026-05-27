<?php

declare(strict_types=1);

namespace AndrewDyer\Pdf\Tests\Support\Documents;

use AndrewDyer\Pdf\PdfDocument;
use AndrewDyer\Pdf\Values\Content;
use AndrewDyer\Pdf\Values\Options;

/**
 * Provides a concrete PdfDocument implementation for use in tests.
 */
final class ExamplePdfDocument extends PdfDocument
{
    /**
     * Creates a new ExamplePdfDocument.
     *
     * @param string $view The view template name.
     * @param array $data The view template data.
     */
    public function __construct(
        private readonly string $view = 'example.twig.html',
        private readonly array $data = [],
    ) {
    }

    /**
     * Returns the options for the PDF document.
     *
     * @return Options The PDF document options.
     */
    public function options(): Options
    {
        return new Options();
    }

    /**
     * Returns the content for the PDF document.
     *
     * @return Content The PDF document content.
     */
    public function content(): Content
    {
        return new Content(view: $this->view, data: $this->data);
    }
}
