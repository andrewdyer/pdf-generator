<?php

declare(strict_types=1);

namespace AndrewDyer\PdfGenerator\Contracts;

use AndrewDyer\PdfGenerator\Values\Content;
use AndrewDyer\PdfGenerator\Values\Options;

/**
 * Defines the contract for a PDF document.
 */
interface PdfDocumentInterface
{
    /**
     * Returns the options for the PDF document.
     *
     * @return Options The PDF document options.
     */
    public function options(): Options;

    /**
     * Returns the content for the PDF document.
     *
     * @return Content The PDF document content.
     */
    public function content(): Content;
}
