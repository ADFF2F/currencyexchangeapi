<?php

declare(strict_types=1);

namespace App\Controller\Currencies\Action;

use App\Repository\CurrencyRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

final class Currencies
{
    const CUR01 = 'CUR01';
    const CUR01_MSG = 'Not Found';

    private CurrencyRepository $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    public function __invoke()
    {
        if (!$currencies = $this->currencyRepository->findAll()) {
            return new JsonResponse(['error' => [
                'code' => self::CUR01,
                'msg' => self::CUR01_MSG,
            ]], 404);
        }

        return new JsonResponse(['data' => $currencies], 200);
    }

}