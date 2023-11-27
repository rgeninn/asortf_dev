<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class PhoneExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('phone_slice', [$this, 'formatPhone']),
        ];
    }

    public function formatPhone($number)
    {
        $rev = strrev($number);
        $split = trim(chunk_split($rev, 2, ' '));
        return strrev($split);
    }

}
