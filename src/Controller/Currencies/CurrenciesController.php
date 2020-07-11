<?php

declare(strict_types=1);

namespace App\Controller\Currencies;

use App\Controller\Currencies\Action\Currencies;
use App\Controller\Currencies\Action\CurrenciesConvert;
use App\Controller\Currencies\Action\CurrencyExchangeRates;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CurrenciesController
 * @package App\Controller\Currencies
 */
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
     * Return converted value.
     *
     * @Route("/currencies/convert", name="currenciesConvert", methods={"GET"})
     *
     * @param Request $request
     * @param CurrenciesConvert $currenciesConvert
     *
     * @return JsonResponse
     */
    public function currenciesConvert(Request $request, CurrenciesConvert $currenciesConvert): JsonResponse
    {
        return $currenciesConvert($request->query->all());
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
