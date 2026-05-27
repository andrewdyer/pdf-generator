<?php

declare(strict_types=1);

namespace AndrewDyer\PdfGenerator\Values;

use AndrewDyer\PdfGenerator\Enums\Orientation;
use AndrewDyer\PdfGenerator\Enums\PaperSize;

/**
 * Carries the configuration options for a PDF document.
 */
final readonly class Options
{
    /**
     * Creates a new Options.
     *
     * @param string $filename The output filename for the PDF.
     * @param PaperSize $paperSize The paper size to use.
     * @param Orientation $orientation The page orientation to use.
     * @param array $metadata Additional metadata to embed in the PDF.
     */
    public function __construct(
        public string $filename = 'document.pdf',
        public PaperSize $paperSize = PaperSize::A4,
        public Orientation $orientation = Orientation::Portrait,
        public array $metadata = [],
    ) {
    }
}
