<?php

declare(strict_types=1);

namespace AndrewDyer\PdfGenerator\Drivers;

use AndrewDyer\PdfGenerator\Contracts\DriverInterface;
use AndrewDyer\PdfGenerator\Values\Options;
use Dompdf\Dompdf;
use Dompdf\Options as DompdfOptions;

/**
 * Generates PDF documents using the Dompdf library.
 */
final readonly class DompdfDriver implements DriverInterface
{
    /**
     * Creates a new DompdfDriver with the required dependencies.
     *
     * @param DompdfOptions $options The Dompdf options instance.
     */
    public function __construct(
        private DompdfOptions $options = new DompdfOptions(),
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
        $dompdf = new Dompdf($this->options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper(
            $options->paperSize->value,
            $options->orientation->value,
        );
        $dompdf->render();

        return $dompdf->output();
    }
}
