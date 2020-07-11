<?php

declare(strict_types=1);

namespace App\Controller\Currencies\Action;

use App\Controller\Currencies\Messages;
use App\Repository\CurrencyRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

final class Currencies
{
    private CurrencyRepository $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    public function __invoke(): JsonResponse
    {
        if (!$currencies = $this->currencyRepository->findAll()) {
            return new JsonResponse(
                ['error' => [
                    'code' => Messages::CUR01,
                    'msg' => Messages::CUR01_MSG,
                ]], 404);
        }

        return new JsonResponse(['data' => $currencies], 200);
    }

}