<?php

declare(strict_types=1);

namespace AndrewDyer\Pdf\Contracts;

use AndrewDyer\Pdf\Values\Options;

/**
 * Defines the contract for a PDF generation driver.
 */
interface DriverInterface
{
    /**
     * Generates a PDF from the given HTML and returns its contents.
     *
     * @param string $html The HTML content to render as a PDF.
     * @param Options $options The PDF generation options.
     * @return string The generated PDF contents.
     */
    public function generate(string $html, Options $options): string;
}
