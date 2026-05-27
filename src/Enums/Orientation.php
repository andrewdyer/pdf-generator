<?php

declare(strict_types=1);

namespace AndrewDyer\PdfGenerator\Enums;

/**
 * Defines the available page orientations for a PDF document.
 */
enum Orientation: string
{
    case Landscape = 'landscape';
    case Portrait = 'portrait';
}
