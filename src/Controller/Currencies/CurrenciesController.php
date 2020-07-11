<?php

declare(strict_types=1);

namespace App\Controller\Currencies;

use App\Controller\Currencies\Action\Currencies;
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
}
