<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraints as Assert;

final class CurrencyAssert
{
    const EXPECTED_ISO_4217 = 'Expected 3-letter ISO 4217 currency code';

    public function __invoke(): Assert\Currency
    {
        return new Assert\Currency([
            'message' => self::EXPECTED_ISO_4217
        ]);
    }
}