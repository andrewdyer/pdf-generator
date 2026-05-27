<?php

declare(strict_types=1);

namespace AndrewDyer\Pdf\Enums;

/**
 * Defines the available page orientations for a PDF document.
 */
enum Orientation: string
{
    case Landscape = 'landscape';
    case Portrait = 'portrait';
}
