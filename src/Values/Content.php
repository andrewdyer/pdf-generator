<?php

declare(strict_types=1);

namespace AndrewDyer\Pdf\Values;

/**
 * Carries the content data required to render a PDF document.
 */
final readonly class Content
{
    /**
     * Creates a new Content.
     *
     * @param string $view The name of the view template to render.
     * @param array $data The data to pass to the view template.
     */
    public function __construct(
        public string $view,
        public array $data = [],
    ) {
    }
}
