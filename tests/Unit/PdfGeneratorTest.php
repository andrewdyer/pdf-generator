<?php

declare(strict_types=1);

namespace AndrewDyer\PdfGenerator\Tests\Unit;

use AndrewDyer\PdfGenerator\Contracts\DriverInterface;
use AndrewDyer\PdfGenerator\PdfGenerator;
use AndrewDyer\PdfGenerator\Tests\Support\Documents\ExamplePdfDocument;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Twig\Environment;

/**
 * Unit tests for PdfGenerator.
 */
final class PdfGeneratorTest extends TestCase
{
    /**
     * Asserts that generate renders the document view and returns the PDF string from the driver.
     */
    public function testGenerateReturnsPdfString(): void
    {
        $document = new ExamplePdfDocument('invoice.html.twig', ['total' => 99.99]);

        $twig = $this->createMock(Environment::class);
        $twig->expects($this->once())
            ->method('render')
            ->with('invoice.html.twig', ['total' => 99.99])
            ->willReturn('<p>Hello, world</p>');

        $driver = $this->createMock(DriverInterface::class);
        $driver->expects($this->once())
            ->method('generate')
            ->willReturn('%PDF-1.4 content');

        $generator = new PdfGenerator($twig, $driver);

        $this->assertSame('%PDF-1.4 content', $generator->generate($document));
    }

    /**
     * Asserts that save writes the PDF to the given directory and returns the full path.
     */
    public function testSaveWritesPdfAndReturnsPath(): void
    {
        $document = new ExamplePdfDocument();
        $directory = sys_get_temp_dir();
        $expected = $directory . DIRECTORY_SEPARATOR . 'document.pdf';

        $twig = $this->createMock(Environment::class);
        $twig->method('render')->willReturn('<p>Hello, world</p>');

        $driver = $this->createMock(DriverInterface::class);
        $driver->method('generate')->willReturn('%PDF-content');

        $path = (new PdfGenerator($twig, $driver))->save($document, $directory);

        $this->assertSame($expected, $path);
        $this->assertFileExists($path);

        unlink($path);
    }

    /**
     * Asserts that save throws RuntimeException when the directory does not exist.
     */
    public function testSaveThrowsWhenDirectoryDoesNotExist(): void
    {
        $twig = $this->createMock(Environment::class);
        $driver = $this->createMock(DriverInterface::class);

        $this->expectException(RuntimeException::class);

        (new PdfGenerator($twig, $driver))->save(new ExamplePdfDocument(), '/non/existent/directory');
    }

    /**
     * Asserts that save throws RuntimeException when the file cannot be written.
     */
    public function testSaveThrowsWhenFileCannotBeWritten(): void
    {
        $directory = sys_get_temp_dir();

        $twig = $this->createMock(Environment::class);
        $twig->method('render')->willReturn('<p>Hello, world</p>');

        $driver = $this->createMock(DriverInterface::class);
        $driver->method('generate')->willReturn('%PDF-content');

        $unwritable = $directory . DIRECTORY_SEPARATOR . uniqid('pdf_test_', true);
        mkdir($unwritable, 0444);

        try {
            $this->expectException(RuntimeException::class);
            (new PdfGenerator($twig, $driver))->save(new ExamplePdfDocument(), $unwritable);
        } finally {
            rmdir($unwritable);
        }
    }

    /**
     * Asserts that sanitiseFilename strips CR, LF, null bytes, and double quotes.
     *
     * @dataProvider sanitiseFilenameProvider
     */
    public function testSanitiseFilename(string $input, string $expected): void
    {
        $twig = $this->createMock(Environment::class);
        $driver = $this->createMock(DriverInterface::class);

        $generator = new PdfGenerator($twig, $driver);

        $reflection = new \ReflectionMethod($generator, 'sanitiseFilename');
        $result = $reflection->invoke($generator, $input);

        $this->assertSame($expected, $result);
    }

    /**
     * Provides filenames and their expected sanitised values.
     *
     * @return array<string, array{string, string}>
     */
    public static function sanitiseFilenameProvider(): array
    {
        return [
            'clean filename' => ['invoice-001.pdf', 'invoice-001.pdf'],
            'double quotes stripped' => ['"invoice".pdf', 'invoice.pdf'],
            'CR stripped' => ["invoice\r.pdf", 'invoice.pdf'],
            'LF stripped' => ["invoice\n.pdf", 'invoice.pdf'],
            'null byte stripped' => ["invoice\x00.pdf", 'invoice.pdf'],
            'header injection' => ["foo\r\nX-Injected: bar", 'fooX-Injected: bar'],
        ];
    }
}
