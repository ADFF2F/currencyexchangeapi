<?php

declare(strict_types=1);

namespace App\Controller\Currencies\Action;

final class CurrenciesConverter
{
    const SCALE = 2;

    public function convert(string $value, string $rate): string
    {
        return bcmul($value, $rate, self::SCALE);
    }
}