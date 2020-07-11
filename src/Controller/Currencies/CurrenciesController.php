<?php

declare(strict_types=1);

namespace App\Controller\Currencies;

use App\Controller\Currencies\Action\Currencies;
use App\Controller\Currencies\Action\CurrencyExchangeRates;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class CurrenciesController extends AbstractController
{
    /**
     * List available lists.
     *
     * @Route("/currencies", name="currencies", methods={"GET"})
     * @param Currencies $currencies
     *
     * @return JsonResponse
     */
    public function currencies(Currencies $currencies): JsonResponse
    {
        return $currencies();
    }

    /**
     * Return current exchange rates for currency.
     *
     * @Route("/currencies/{currency}", name="currencyExchangeRates", methods={"GET"})
     *
     * @param CurrencyExchangeRates $currencyExchangeRates
     * @param string $currency
     *
     * @return JsonResponse
     */
    public function currencyExchangeRates(CurrencyExchangeRates $currencyExchangeRates, string $currency): JsonResponse
    {
        return $currencyExchangeRates($currency);
    }
}
