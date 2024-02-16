<?php

namespace App\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

class ExcerptExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct()
    {
        // Inject dependencies if needed
    }

    public function excerpt($text, $length = 50)
    {
        return substr($text, 0, $length);
    }
}
