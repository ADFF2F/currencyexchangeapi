<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class CurrenciesControllerTest extends WebTestCase
{
    public function provideUriAndExpectedCodes(): array
    {
        return [
            [200, '/currencies'],
            [200, '/currencies/USD'], // uppercase
            [200, '/currencies/pln'], // lowercase
            [404, '/currencies/php'], // unavailable
            [400, '/currencies/invalid'],
            [400, '/currencies/convert'], // lack of parameters
            [400, '/currencies/convert?to=pln&amount=1'], // lack of 'from'
            [400, '/currencies/convert?from=pln'], // lack of 'to' and 'amount'
            [400, '/currencies/convert?from=pln&to=usd'], // lack of 'amount'
            [400, '/currencies/convert?from=pln&to=usd&amount=xyz'], // 'amount' string
            [400, '/currencies/convert?from=pln&to=usd&amount=1.23'], // 'amount' float
            [400, '/currencies/convert?from=pln&to=usd&amount=-1.23'], // 'amount' negative float
            [400, '/currencies/convert?from=pln&to=usd&amount=0.00'], // 'amount' zero float
            [400, '/currencies/convert?from=pln&to=usd&amount=-1'], // 'amount' negative integer
            [404, '/currencies/convert?from=pln&to=php&amount=1'], // convert to unavailable currency
            [404, '/currencies/convert?from=php&to=pln&amount=1'], // convert from unavailable currency
            [200, '/currencies/convert?from=pln&to=usd&amount=1'], // 'amount' integer
            [400, '/currencies/convert?from=pln&to=usd&amount=0x1'], // hexadecimal notation
            [200, '/currencies/convert?from=pln&to=usd&amount=010'], // expect to remove prefix 0
            [200, '/currencies/convert?from=pln&to=usd&amount=0'], // 'amount' zero
        ];
    }

    /**
     * @dataProvider provideUriAndExpectedCodes
     * @param int $expectedCode
     * @param string $uri
     */
    public function testCurrencies(int $expectedCode, string $uri)
    {
        $client = static::createClient();
        $client->request('GET', $uri);
        $this->assertEquals($expectedCode, $client->getResponse()->getStatusCode());
    }

}