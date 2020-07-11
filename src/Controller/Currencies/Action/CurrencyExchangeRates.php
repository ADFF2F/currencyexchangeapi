<?php

declare(strict_types=1);

namespace App\Controller\Currencies\Action;

use App\Controller\Currencies\Messages;
use App\Repository\CurrencyRepository;
use App\Validator\CurrencyValidator;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CurrencyExchangeRates
{

    private CurrencyRepository $currencyRepository;
    private CurrencyValidator $currencyValidator;

    public function __construct(
        CurrencyRepository $currencyRepository,
        CurrencyValidator $currencyValidator
    )
    {
        $this->currencyRepository = $currencyRepository;
        $this->currencyValidator = $currencyValidator;
    }

    public function __invoke(string $currency): JsonResponse
    {
        $this->currencyValidator->validate(['currency' => strtoupper($currency)]);
        if ($errors = $this->currencyValidator->getErrors()) {
            return new JsonResponse(['error' => $errors], 400);
        }

        if (!$currency = $this->currencyRepository->findByCode($currency)) {
            return new JsonResponse(
                ['error' => [
                    'code' => Messages::CUR02,
                    'msg' => Messages::CUR02_MSG,
                ]], 404);
        }

        if (!$exchangeRates = $currency->getExchangeRates()->toArray()) {
            return new JsonResponse(
                ['error' => [
                    'code' => Messages::CEX01,
                    'msg' => Messages::CEX01_MSG,
                ]], 404);
        }

        return new JsonResponse(['data' => $exchangeRates], 200);
    }

}