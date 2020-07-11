<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Currency;
use App\Entity\ExchangeRate;
use App\Repository\CurrencyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class InsertInitialDataCommand extends Command
{
    protected static $defaultName = 'exchange-api:insert-initial-data';

    private CurrencyRepository $currencyRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(
        CurrencyRepository $currencyRepository,
        EntityManagerInterface $entityManager
    )
    {
        $this->currencyRepository = $currencyRepository;
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $currencies = ['PLN', 'USD', 'EUR'];
        foreach ($currencies as $currency) {
            $newCurrency = new Currency();
            $newCurrency->setCode($currency);
            $this->entityManager->persist($newCurrency);
        }
        $this->entityManager->flush();

        $pln = $this->currencyRepository->findByCode('PLN');
        $usd = $this->currencyRepository->findByCode('USD');
        $eur = $this->currencyRepository->findByCode('EUR');

        $exchangeRates = [
            ['from' => $pln, 'to' => $usd, 'rate' => 0.25],
            ['from' => $pln, 'to' => $eur, 'rate' => 0.22],
            ['from' => $usd, 'to' => $pln, 'rate' => 3.95],
            ['from' => $usd, 'to' => $eur, 'rate' => 0.89],
        ];

        foreach ($exchangeRates as $exchange) {
            $exchangeRate = new ExchangeRate();
            $exchangeRate
                ->setRate($exchange['rate'])
                ->setExchangeFrom($exchange['from'])
                ->setExchangeTo($exchange['to']);

            $this->entityManager->persist($exchangeRate);
        }
        $this->entityManager->flush();
        $output->writeln('<info>Data inserted correctly.</info>');

        return 0;
    }
}