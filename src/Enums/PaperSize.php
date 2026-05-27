<?php

declare(strict_types=1);

namespace AndrewDyer\Pdf\Enums;

/**
 * Defines the available paper sizes for a PDF document.
 */
enum PaperSize: string
{
    case A3 = 'A3';
    case A4 = 'A4';
    case A5 = 'A5';
    case Legal = 'Legal';
    case Letter = 'Letter';
}
