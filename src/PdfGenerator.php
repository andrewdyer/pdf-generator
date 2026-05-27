<?php

declare(strict_types=1);

namespace AndrewDyer\Pdf;

use AndrewDyer\Pdf\Contracts\DriverInterface;
use AndrewDyer\Pdf\Contracts\PdfDocumentInterface;
use RuntimeException;
use Twig\Environment;

/**
 * Handles PDF generation, inline serving, downloading, and saving.
 */
final readonly class PdfGenerator
{
    /**
     * Creates a new PdfGenerator with the required dependencies.
     *
     * @param Environment $twig The Twig environment for rendering HTML templates.
     * @param DriverInterface $driver The PDF generation driver.
     */
    public function __construct(
        private Environment $twig,
        private DriverInterface $driver,
    ) {
    }

    /**
     * Generates a PDF from the given document and returns its contents.
     *
     * @param PdfDocumentInterface $document The PDF document to generate.
     * @return string The generated PDF contents.
     */
    public function generate(PdfDocumentInterface $document): string
    {
        $html = $this->twig->render(
            $document->content()->view,
            $document->content()->data
        );

        return $this->driver->generate($html, $document->options());
    }

    /**
     * Handles sending the PDF as an inline browser response.
     *
     * @param PdfDocumentInterface $document The PDF document to serve inline.
     */
    public function inline(PdfDocumentInterface $document): never
    {
        $bytes = $this->generate($document);
        $filename = $document->options()->filename;

        header('Content-Type: application/pdf');
        header(sprintf('Content-Disposition: inline; filename="%s"', $filename));
        header('Content-Length: ' . strlen($bytes));
        header('Cache-Control: private, max-age=0, must-revalidate');

        echo $bytes;
        exit;
    }

    /**
     * Handles sending the PDF as a file download response.
     *
     * @param PdfDocumentInterface $document The PDF document to download.
     */
    public function download(PdfDocumentInterface $document): never
    {
        $bytes = $this->generate($document);
        $filename = $document->options()->filename;

        header('Content-Type: application/pdf');
        header(sprintf('Content-Disposition: attachment; filename="%s"', $filename));
        header('Content-Length: ' . strlen($bytes));
        header('Cache-Control: private, max-age=0, must-revalidate');

        echo $bytes;
        exit;
    }

    /**
     * Saves the PDF to the given directory and returns the full file path.
     *
     * @param PdfDocumentInterface $document The PDF document to save.
     * @param string $directory The directory to save the file in.
     * @return string The full path to the saved file.
     * @throws RuntimeException When the directory does not exist or is not writable.
     */
    public function save(PdfDocumentInterface $document, string $directory): string
    {
        $directory = rtrim($directory, '/\\');

        if (!is_dir($directory) || !is_writable($directory)) {
            throw new RuntimeException(
                sprintf('Directory "%s" does not exist or is not writable.', $directory),
            );
        }

        $bytes = $this->generate($document);
        $path = $directory . DIRECTORY_SEPARATOR . $document->options()->filename;

        file_put_contents($path, $bytes);

        return $path;
    }
}
