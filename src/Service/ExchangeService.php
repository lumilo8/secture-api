<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ExchangeService
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function eurToCurrency($price, $currency = 'USD')
    {
        $url = 'https://api.exchangeratesapi.io/latest';

        try {
            $response = $this->client->request(
                'GET',
                sprintf('%s?symbols=%s', $url, $currency)
            );
        } catch (TransportExceptionInterface $e) {
            throw $e;
        }

        $rate = $response->toArray()['rates'][$currency];

        return round($price * $rate);
    }
}