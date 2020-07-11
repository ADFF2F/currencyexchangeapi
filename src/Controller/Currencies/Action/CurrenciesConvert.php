<?php

declare(strict_types=1);

namespace App\Controller\Currencies\Action;

use App\Controller\Currencies\Messages;
use App\Repository\CurrencyRepository;
use App\Repository\ExchangeRateRepository;
use App\Validator\CurrenciesConvertValidator;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CurrenciesConvert
{
    private ExchangeRateRepository $exchangeRateRepository;
    private CurrencyRepository $currencyRepository;
    private CurrenciesConvertValidator $currenciesConvertValidator;
    private CurrenciesConverter $currenciesConverter;

    public function __construct
    (
        ExchangeRateRepository $currencyExchangeRepository,
        CurrenciesConvertValidator $currenciesConvertValidator,
        CurrencyRepository $currencyRepository,
        CurrenciesConverter $currenciesConverter
    )
    {
        $this->exchangeRateRepository = $currencyExchangeRepository;
        $this->currencyRepository = $currencyRepository;
        $this->currenciesConvertValidator = $currenciesConvertValidator;
        $this->currenciesConverter = $currenciesConverter;
    }

    public function __invoke(array $parameters): JsonResponse
    {
        $this->currenciesConvertValidator->validate([
            'from' => isset($parameters['from']) ? strtoupper($parameters['from']) : null,
            'to' => isset($parameters['to']) ? strtoupper($parameters['to']) : null,
            'amount' => $parameters['amount'] ?? null,
        ]);

        if ($errors = $this->currenciesConvertValidator->getErrors()) {
            return new JsonResponse(['error' => $errors], 400);
        }
        $exchangeRate = $this->exchangeRateRepository->findOneBy([
            'exchangeFrom' => $this->currencyRepository->findByCode($parameters['from']),
            'exchangeTo' => $this->currencyRepository->findByCode($parameters['to'])
        ]);

        if (!$exchangeRate) {
            return new JsonResponse(
                ['error' => [
                    'code' => Messages::CEX01,
                    'msg' => Messages::CEX01_MSG,
                ]], 404);
        }

        $data = $this->currenciesConverter->convert($parameters['amount'], strval($exchangeRate->getRate()));

        return new JsonResponse(['data' => $data], 200);
    }

}