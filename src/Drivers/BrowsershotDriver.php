<?php

declare(strict_types=1);

namespace AndrewDyer\PdfGenerator\Drivers;

use AndrewDyer\PdfGenerator\Contracts\DriverInterface;
use AndrewDyer\PdfGenerator\Enums\Orientation;
use AndrewDyer\PdfGenerator\Values\Options;
use Spatie\Browsershot\Browsershot;

/**
 * Generates PDF documents using the Browsershot library.
 */
final class BrowsershotDriver implements DriverInterface
{
    /**
     * Creates a new BrowsershotDriver with the required dependencies.
     *
     * @param string|null $nodeBinary The path to the Node.js binary.
     * @param string|null $npmBinary The path to the npm binary.
     * @param string|null $chromiumPath The path to the Chromium executable.
     * @param int $marginTop The top margin in millimetres.
     * @param int $marginRight The right margin in millimetres.
     * @param int $marginBottom The bottom margin in millimetres.
     * @param int $marginLeft The left margin in millimetres.
     */
    public function __construct(
        private readonly ?string $nodeBinary = null,
        private readonly ?string $npmBinary = null,
        private readonly ?string $chromiumPath = null,
        private readonly int $marginTop = 10,
        private readonly int $marginRight = 10,
        private readonly int $marginBottom = 10,
        private readonly int $marginLeft = 10,
    ) {
    }

    /**
     * Generates a PDF from the given HTML and returns its contents.
     *
     * @param string $html The HTML content to render as a PDF.
     * @param Options $options The PDF generation options.
     * @return string The generated PDF contents.
     */
    public function generate(string $html, Options $options): string
    {
        $shot = Browsershot::html($html)
            ->format($options->paperSize->value)
            ->landscape($options->orientation === Orientation::Landscape)
            ->margins(
                $this->marginTop,
                $this->marginRight,
                $this->marginBottom,
                $this->marginLeft,
            );

        if ($this->nodeBinary !== null) {
            $shot->setNodeBinary($this->nodeBinary);
        }

        if ($this->npmBinary !== null) {
            $shot->setNpmBinary($this->npmBinary);
        }

        if ($this->chromiumPath !== null) {
            $shot->setChromePath($this->chromiumPath);
        }

        return $shot->pdf();
    }
}
