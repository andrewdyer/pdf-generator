<?php

declare(strict_types=1);

namespace AndrewDyer\Pdf;

use AndrewDyer\Pdf\Contracts\PdfDocumentInterface;
use AndrewDyer\Pdf\Values\Content;
use AndrewDyer\Pdf\Values\Options;

/**
 * Provides a base implementation for a PDF document.
 */
abstract class PdfDocument implements PdfDocumentInterface
{
    /**
     * Returns the options for the PDF document.
     *
     * @return Options The PDF document options.
     */
    abstract public function options(): Options;

    /**
     * Returns the content for the PDF document.
     *
     * @return Content The PDF document content.
     */
    abstract public function content(): Content;

    /**
     * Returns the view name from the document content.
     *
     * @return string The view template name.
     */
    public function getView(): string
    {
        return $this->content()->view;
    }

    /**
     * Returns the data array from the document content.
     *
     * @return array The view template data.
     */
    public function getData(): array
    {
        return $this->content()->data;
    }
}
