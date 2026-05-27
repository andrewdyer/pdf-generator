# PDF Generator

A framework-agnostic PHP library for generating PDFs from Twig templates, with support for a swappable driver interface.

## Introduction

This library provides a PDF generation pipeline for PHP applications, converting Twig templates to PDF documents through an extensible driver interface. Dompdf and Browsershot drivers are included, with support for custom drivers via a simple contract.

## Prerequisites

- **[PHP](https://www.php.net/)**: Version 8.3 or higher is required.
- **[Composer](https://getcomposer.org/)**: Dependency management tool for PHP.

## Installation

```bash
composer require andrewdyer/pdf-generator
```

## Getting Started

### 1. Create a Twig template

Create an HTML template in the application's templates directory:

```html
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <style>
      body {
        font-family: Arial, sans-serif;
        font-size: 14px;
        color: #333;
        padding: 40px;
      }
      h1 {
        font-size: 28px;
        color: #1a1a2e;
      }
    </style>
  </head>
  <body>
    <h1>Invoice #{{ order.id }}</h1>
    <p>{{ order.customer.name }}</p>
  </body>
</html>
```

### 2. Create a PDF document

Extend `PdfDocument` and implement `options()` to configure the output and `content()` to define the template and data:

```php
use AndrewDyer\PdfGenerator\PdfDocument;
use AndrewDyer\PdfGenerator\Values\Content;
use AndrewDyer\PdfGenerator\Values\Options;

class InvoicePdf extends PdfDocument
{
    public function __construct(private readonly Order $order) {}

    public function options(): Options
    {
        return new Options(
            filename: sprintf('invoice-%s.pdf', $this->order->id),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'pdfs/invoice.html.twig',
            data: ['order' => $this->order],
        );
    }
}
```

### 3. Set up the PDF generator

Instantiate `PdfGenerator` with a `Twig\Environment` and a driver:

```php
use AndrewDyer\PdfGenerator\PdfGenerator;
use AndrewDyer\PdfGenerator\Drivers\DompdfDriver;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$twig = new Environment(new FilesystemLoader('/path/to/templates'));

$generator = new PdfGenerator(
    twig:   $twig,
    driver: new DompdfDriver(),
);
```

## Usage

### Saving to disk

Returns the full path of the written file:

```php
$path = $generator->save(new InvoicePdf($order), '/storage/invoices');
```

### Streaming inline

Streams the PDF directly in the browser for preview:

```php
$generator->inline(new InvoicePdf($order));
```

### Forcing a download

Sends the PDF as a browser download:

```php
$generator->download(new InvoicePdf($order));
```

### Retrieving raw bytes

Returns the raw PDF bytes for further processing, such as attaching to an email:

```php
$bytes = $generator->generate(new InvoicePdf($order));
```

## Drivers

### Dompdf

A pure PHP driver requiring no external services or binaries.

```bash
composer require dompdf/dompdf
```

Instantiate the driver directly, or pass a pre-configured [`Options`](https://github.com/dompdf/dompdf) instance:

```php
use AndrewDyer\PdfGenerator\Drivers\DompdfDriver;
use Dompdf\Options;

$options = new Options();
$options->set('isRemoteEnabled', true);

$driver = new DompdfDriver($options);
```

### Browsershot

A driver backed by headless Chromium via [Puppeteer](https://pptr.dev/), producing pixel-perfect output. Best suited for complex layouts, modern CSS, and web fonts.

Requires [Node.js](https://nodejs.org/) and Puppeteer:

```bash
npm install puppeteer
```

Then install the driver via Composer:

```bash
composer require spatie/browsershot
```

Pass optional binary paths if they are not on the system path:

```php
use AndrewDyer\PdfGenerator\Drivers\BrowsershotDriver;

$driver = new BrowsershotDriver(
    nodeBinary:   '/usr/local/bin/node',
    npmBinary:    '/usr/local/bin/npm',
    chromiumPath: '/usr/bin/chromium',
);
```

### Custom drivers

Any class implementing `DriverInterface` can be used as a driver, accepting rendered HTML and returning raw PDF bytes:

```php
use AndrewDyer\PdfGenerator\Contracts\DriverInterface;
use AndrewDyer\PdfGenerator\Values\Options;

class CustomDriver implements DriverInterface
{
    public function generate(string $html, Options $options): string
    {
        // Convert $html to PDF bytes and return them...
    }
}
```

## Options

A value object passed to the driver alongside the rendered HTML. All properties have sensible defaults:

```php
use AndrewDyer\PdfGenerator\Values\Options;
use AndrewDyer\PdfGenerator\Enums\Orientation;
use AndrewDyer\PdfGenerator\Enums\PaperSize;

new Options(
    filename:    'document.pdf',
    paperSize:   PaperSize::A4,
    orientation: Orientation::Portrait,
    metadata:    ['Author' => 'Acme Ltd'],
);
```

## License

Licensed under the [MIT licence](https://opensource.org/licenses/MIT) and is free for private or commercial projects.
