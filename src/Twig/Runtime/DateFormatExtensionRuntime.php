<?php

namespace App\Twig\Runtime;

use DateTime;
use DateTimeImmutable;
use Twig\Extension\RuntimeExtensionInterface;

class DateFormatExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct()
    {
        // Inject dependencies if needed
    }

    public function format(DateTimeImmutable|DateTime $dateTime): string
    {
        return $dateTime->format('\L\e d/m/Y \à H:i:s');
    }
}
